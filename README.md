# SQL Quiz Practice

A local practice app for MySQL / MariaDB, in the style of a BlueJack practicum exam.
You write SQL, the app runs it on a fresh copy of the data, and it scores your output against a reference answer.

- **Case 1** — Hehe Groceries: 50 problems.
- **Case 2** — Buku Kita bookstore: 25 transfer problems (same patterns, new names).
- Modes: Practice (hints, skeleton, answer), Exam (timed), Data (browse tables), Result.
- `notes.html`: must-know syntax and common traps.

Works on Windows, Linux and macOS.

## Option A — XAMPP (Windows, Linux, macOS)

1. Install XAMPP from https://www.apachefriends.org and start **Apache** and **MySQL**.
2. Copy this folder into XAMPP's `htdocs` as `sqlquiz`:
   - Windows: `C:\xampp\htdocs\sqlquiz`
   - Linux: `/opt/lampp/htdocs/sqlquiz`
   - macOS: `/Applications/XAMPP/xamppfiles/htdocs/sqlquiz`
3. Open http://localhost/phpmyadmin → **SQL** tab → paste the contents of `setup.sql` → **Go**.
4. Open http://localhost/sqlquiz

**Linux only:** table names are case-sensitive on Linux. Add `lower_case_table_names=1` under `[mysqld]`
in `/opt/lampp/etc/my.cnf` *before* the first start (or on a fresh data directory), then restart MySQL.

## Option B — Docker (any OS)

```
docker compose up --build
```

Open http://localhost:8080/sqlquiz

## How it works

- `lib.php` creates a throwaway database `qz_*` for every run, loads `dump.sql` / `dump2.sql`, runs your SQL, and drops it.
- Scoring compares your result table with the reference result (row and column match, partial credit).
- Progress is saved per profile name in `qz_store.progress` and in the browser.
- The DB user `quiz` / `quiz` can only touch databases named `qz_*`. It is for local use only; do not expose this app to the internet.
- `DB_HOST` env var sets the database host (default `localhost`).
