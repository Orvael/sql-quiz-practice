<?php
// JSON API: list | run | submit | answer
$CASE = ($_GET['c'] ?? '1') === '2' ? 2 : 1;
require __DIR__ . '/lib.php';
header('Content-Type: application/json');
$in = json_decode(file_get_contents('php://input'), true) ?? [];
$a = $_GET['a'] ?? '';
$i = (int)($in['i'] ?? 0);
if ($a === 'list') { echo json_encode(array_map(fn($q) => ['topic' => $q['topic'], 'text' => $q['text'], 'hint' => $q['hint']], $QUESTIONS)); exit; }
// Progress per profile name, kept in MariaDB (qz_store) so it survives browser resets.
if ($a === 'load' || $a === 'save') {
    $c = new mysqli(getenv('DB_HOST') ?: 'localhost', 'quiz', 'quiz', 'qz_store');
    $u = substr(trim($in['user'] ?? ''), 0, 50) ?: 'student';
    if ($a === 'save') {
        $st = $c->prepare('REPLACE INTO progress VALUES (?, ?, ?)');
        $d = json_encode($in['data'] ?? []); $t = (int)($in['ts'] ?? 0);
        $st->bind_param('ssi', $u, $d, $t); $st->execute(); echo json_encode(['ok' => $st->affected_rows > 0]); exit;
    }
    $st = $c->prepare('SELECT data, ts FROM progress WHERE user = ?'); $st->bind_param('s', $u); $st->execute();
    $r = $st->get_result()->fetch_assoc();
    echo json_encode($r ? ['data' => json_decode($r['data'], true), 'ts' => (int)$r['ts']] : ['data' => null, 'ts' => 0]); exit;
}
if (!isset($QUESTIONS[$i])) { echo json_encode(['error' => 'bad question']); exit; }
if ($a === 'run') { echo json_encode(attempt('qz_user', $QUESTIONS[$i], $in['sql'] ?? '')); exit; }
if ($a === 'submit') { echo json_encode(grade($i, $in['sql'] ?? '')); exit; }
if ($a === 'skeleton') { echo json_encode(['sk' => skeleton($QUESTIONS[$i]['ref'])]); exit; }
if ($a === 'tables') {
    $c = fresh('qz_view'); $out = [];
    $tabs = $CASE === 2 ? ['MsGenre','MsBook','MsMember','MsStaff','SalesHeader','SalesDetail'] : ['MsCategory','MsCustomer','MsEmployee','MsProduct','TransactionHeader','TransactionDetail'];
    foreach ($tabs as $t) { [$r] = run_sql($c, "SELECT * FROM $t"); $out[$t] = $r; }
    $c->query('DROP DATABASE qz_view'); echo json_encode($out); exit;
}
if ($a === 'answer') { echo json_encode(['ref' => $QUESTIONS[$i]['ref']]); exit; }
