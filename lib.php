<?php
// SQL quiz judge: fresh DB per run, compare to reference.
mysqli_report(MYSQLI_REPORT_OFF);
// Case 1 = Hehe Groceries, Case 2 = Buku Kita bookstore (set $CASE before requiring this file).
$CASE = $CASE ?? 1;
require __DIR__ . ($CASE === 2 ? '/questions2.php' : '/questions.php');
$DUMP = __DIR__ . ($CASE === 2 ? '/dump2.sql' : '/dump.sql');

function fresh($db) {
    $c = new mysqli(getenv('DB_HOST') ?: 'localhost', 'quiz', 'quiz');
    $c->query("DROP DATABASE IF EXISTS $db");
    $c->query("CREATE DATABASE $db");
    $c->select_db($db);
    $c->multi_query(file_get_contents($GLOBALS['DUMP']));
    do { if ($r = $c->store_result()) $r->free(); } while ($c->more_results() && $c->next_result());
    return $c;
}

// Run many statements; return the last result set and the first error.
function run_sql($c, $sql) {
    $last = null; $err = null;
    if (!$c->multi_query($sql)) return [null, $c->error];
    do {
        if ($r = $c->store_result()) {
            $cols = array_map(fn($f) => $f->name, $r->fetch_fields());
            $last = ['cols' => $cols, 'rows' => $r->fetch_all(MYSQLI_NUM)];
            $r->free();
        }
        if (!$c->more_results()) break;
        if (!$c->next_result()) { $err = $c->error; break; }
    } while (true);
    if (!$err && $c->errno) $err = $c->error;
    return [$last, $err];
}

function attempt($db, $q, $sql) {
    $db .= '_' . bin2hex(random_bytes(4));   // own DB per run: parallel runs never collide
    $c = fresh($db);
    if (isset($q['setup'])) run_sql($c, $q['setup']);
    [$res, $err] = run_sql($c, $sql);
    $check = null;
    if (!$err && isset($q['check'])) [$check, $err] = run_sql($c, $q['check']);
    $c->close();
    (new mysqli(getenv('DB_HOST') ?: 'localhost', 'quiz', 'quiz'))->query("DROP DATABASE IF EXISTS $db");
    return ['result' => $res, 'check' => $check, 'error' => $err];
}

function canon($set, $ordered) {
    if (!$set) return null;
    $rows = array_map(fn($r) => json_encode(array_map(fn($v) => $v === null ? null : (string)$v, $r)), $set['rows']);
    if (!$ordered) sort($rows);
    return [count($set['cols']), $rows];
}

function grade($i, $sql) {
    global $QUESTIONS;
    $q = $QUESTIONS[$i];
    $you = attempt('qz_user', $q, $sql);
    if ($you['error']) return ['ok' => false, 'score' => 0, 'error' => $you['error'], 'you' => $you];
    // Expected output is fixed per question (per day: one uses CURDATE), so compute it once.
    $cf = sys_get_temp_dir() . '/sqlquiz_' . md5(json_encode($q) . date('Y-m-d')) . '.json';
    $ref = is_file($cf) ? json_decode(file_get_contents($cf), true) : null;
    if (!$ref) { $ref = attempt('qz_ref', $q, $q['ref']); file_put_contents($cf, json_encode($ref)); }
    $key = isset($q['check']) ? 'check' : 'result';
    $ord = $q['ordered'] ?? false;
    [$score, $why] = score($you[$key], $ref[$key], $ord);
    return ['ok' => $score === 100, 'score' => $score, 'why' => $why, 'you' => $you, 'expected' => $ref[$key]];
}

function col($set, $j) { return array_map(fn($r) => $r[$j] === null ? 'NULL' : (string)$r[$j], $set['rows']); }

// Column match: half exact (multiset overlap), half closeness of sorted values (typos still earn credit).
function col_sim($a, $b) {
    sort($a); sort($b); $n = max(count($a), count($b));
    if ($n === 0) return [1.0, null];
    $left = array_count_values($b); $ex = 0;
    foreach ($a as $v) if (($left[$v] ?? 0) > 0) { $left[$v]--; $ex++; }
    $fz = 0; $diff = null;
    for ($k = 0; $k < min(count($a), count($b)); $k++) {
        similar_text($a[$k], $b[$k], $p); $fz += $p / 100;
        if ($diff === null && $a[$k] !== $b[$k]) $diff = [$a[$k], $b[$k]];
    }
    return [0.5 * $ex / $n + 0.5 * $fz / $n, $diff];
}

function score($y, $e, $ord) {
    if (!$y) return [0, 'Your query returned no result table.'];
    if (canon($y, $ord) === canon($e, $ord)) return [100, 'Correct.'];
    if ($ord && canon($y, false) === canon($e, false)) return [70, 'Rows are right but the ORDER is wrong.'];
    $ny = count($y['rows']); $ne = count($e['rows']);
    if ($ny === 0 && $ne > 0) return [0, "Your query returned 0 rows, expected $ne. Check the WHERE: right column? right value? missing %?"];
    $rowScore = max($ny, $ne) ? min($ny, $ne) / max($ny, $ne) : 1;
    $E = count($e['cols']); $Y = count($y['cols']); $sum = 0; $notes = [];
    for ($j = 0; $j < $E; $j++) {
        $best = [0, null];
        for ($c = 0; $c < $Y; $c++) { $s = col_sim(col($y, $c), col($e, $j)); if ($s[0] > $best[0]) $best = $s; }
        $sum += $best[0];
        if ($best[0] < 1 && count($notes) < 2) {
            $name = $e['cols'][$j];
            $notes[] = ($best[1] && $best[0] >= 0.35) ? "column \"$name\" is off — e.g. you '{$best[1][0]}', expected '{$best[1][1]}'" : "column \"$name\" is missing or wrong";
        }
    }
    $colScore = $sum / max($E, 1) * ($Y > $E ? $E / $Y : 1);
    $s = (int)round(100 * (0.2 * $rowScore + 0.8 * $colScore));
    $s = max(1, min(99, $s));
    $why = [];
    if ($ny !== $ne) $why[] = "you returned $ny rows, expected $ne";
    if ($Y !== $E) $why[] = "you return $Y columns, expected $E";
    $why = array_merge($why, $notes);
    return [$s, ucfirst(implode('; ', $why ?: ['values differ slightly'])) . '.'];
}

// Hint 2: keep SQL keywords, function names, numbers and symbols; blank out names and text.
function skeleton($sql) {
    $sql = preg_replace("/'[^']*'/", "'…'", $sql);
    $sql = preg_replace('/`[^`]*`/', '___', $sql);
    $sql = preg_replace_callback('/\b([A-Za-z_][A-Za-z0-9_]*)\b(\s*\()?/', function ($m) {
        if (!empty($m[2]) || preg_match('/^[A-Z_]{2,}$/', $m[1])) return $m[0];
        return '___';
    }, $sql);
    return preg_replace('/___\.___/', '___', $sql);   // the page formats it into lines
}
