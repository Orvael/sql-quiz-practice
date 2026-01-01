<?php
// Case 2 (Buku Kita bookstore): 25 transfer problems, same patterns as Case 1, new names/wording.
$QUESTIONS = [
[ 'topic' => 'LIKE · starts with',
  'text' => "Display all data of every book whose title starts with 'The'.",
  'hint' => 'LIKE',
  'ref' => "SELECT * FROM MsBook WHERE BookTitle LIKE 'The%';" ],

[ 'topic' => 'CONCAT',
  'text' => "Display MemberName (obtained by adding 'Ms. ' before the member name, e.g. 'Ms. Maria Wijaya'), MemberEmail, and MemberDOB for every 'Female' member.",
  'hint' => 'CONCAT, LIKE',
  'ref' => "SELECT CONCAT('Ms. ', MemberName) AS MemberName, MemberEmail, MemberDOB FROM MsMember WHERE MemberGender LIKE 'Female';" ],

[ 'topic' => 'REPLACE + BETWEEN',
  'text' => "Display Sale Code (obtained by replacing 'SA' with 'Sale-' in SaleID, e.g. 'Sale-001'), StaffID, and SaleDate for every sale that happened between January 1st, 2023 and March 31st, 2023.",
  'hint' => 'REPLACE, BETWEEN',
  'ref' => "SELECT REPLACE(SaleID, 'SA', 'Sale-') AS `Sale Code`, StaffID, SaleDate FROM SalesHeader WHERE SaleDate BETWEEN '2023-01-01' AND '2023-03-31';" ],

[ 'topic' => 'CONCAT + ROUND',
  'text' => "Display BookTitle and Promo (obtained by adding 'Now only $' before the book price discounted by 25% and rounded to 2 decimals, then adding '!' after it) for every book whose title ends with 'Guide'.",
  'hint' => 'CONCAT, ROUND, LIKE',
  'ref' => "SELECT BookTitle, CONCAT('Now only $', ROUND(BookPrice * 0.75, 2), '!') AS Promo FROM MsBook WHERE BookTitle LIKE '%Guide';" ],

[ 'topic' => 'Last word',
  'text' => "Display MemberName and Street Type (the last word of MemberAddress, e.g. '790 Oak Street' → 'Street') for every 'Male' member.",
  'hint' => 'RIGHT, POSITION, REVERSE',
  'ref' => "SELECT MemberName, RIGHT(MemberAddress, POSITION(' ' IN REVERSE(MemberAddress)) - 1) AS `Street Type` FROM MsMember WHERE MemberGender LIKE 'Male';" ],

[ 'topic' => 'First word',
  'text' => "Display StaffID and First Name (the first word of StaffName) for every 'Female' staff.",
  'hint' => 'LEFT, POSITION',
  'ref' => "SELECT StaffID, LEFT(StaffName, POSITION(' ' IN StaffName) - 1) AS `First Name` FROM MsStaff WHERE StaffGender LIKE 'Female';" ],

[ 'topic' => 'DAYNAME + UPPER + INSERT',
  'text' => "Display SaleID, Day (the day name of the sale), MemberName (in uppercase), and Campus Email (everything after '@' replaced with 'binus.ac.id', e.g. 'maria37@binus.ac.id') for every sale in May made by a member whose name is shorter than 13 characters.",
  'hint' => 'DAYNAME, UPPER, INSERT, POSITION, LENGTH, MONTH, JOIN',
  'ref' => "SELECT sh.SaleID, DAYNAME(SaleDate) AS Day, UPPER(MemberName) AS MemberName, INSERT(MemberEmail, POSITION('@' IN MemberEmail) + 1, LENGTH(MemberEmail), 'binus.ac.id') AS `Campus Email` FROM SalesHeader sh JOIN MsMember mm ON sh.MemberID = mm.MemberID WHERE MONTH(SaleDate) = 5 AND LENGTH(MemberName) < 13;" ],

[ 'topic' => 'GROUP_CONCAT + DATE_FORMAT',
  'text' => "Display SaleID, Books (all book titles in the sale, in alphabetical order, separated by ' | '), and Date (sale date in dd/mm/yyyy format, e.g. '14/08/2023') for every sale in August on an even day.",
  'hint' => 'GROUP_CONCAT(... ORDER BY ... SEPARATOR), DATE_FORMAT, MONTH, DAY, GROUP BY',
  'ref' => "SELECT sh.SaleID, GROUP_CONCAT(BookTitle ORDER BY BookTitle SEPARATOR ' | ') AS Books, DATE_FORMAT(SaleDate, '%d/%m/%Y') AS Date FROM SalesHeader sh JOIN SalesDetail sd ON sh.SaleID = sd.SaleID JOIN MsBook mb ON sd.BookID = mb.BookID WHERE MONTH(SaleDate) = 8 AND DAY(SaleDate) % 2 = 0 GROUP BY sh.SaleID, SaleDate;" ],

[ 'topic' => 'INSERT INTO',
  'text' => "Insert these rows into SalesDetail (SaleID, BookID, Qty): ('SA001','BK027',3), ('SA001','BK028',1), ('SA002','BK029',5).",
  'hint' => 'INSERT INTO ... VALUES (...), (...)',
  'ref' => "INSERT INTO SalesDetail VALUES ('SA001','BK027',3), ('SA001','BK028',1), ('SA002','BK029',5);",
  'check' => "SELECT * FROM SalesDetail WHERE SaleID IN ('SA001','SA002');" ],

[ 'topic' => 'ALTER ADD + CHECK',
  'text' => "Add a column MemberPhone VARCHAR(20) to MsMember, then add a constraint named 'check_memberphone' so MemberPhone must contain only digits. (Remember what NOT NULL does to existing rows.)",
  'hint' => 'ALTER TABLE ... ADD, ADD CONSTRAINT ... CHECK, REGEXP',
  'ref' => "ALTER TABLE MsMember ADD MemberPhone VARCHAR(20); ALTER TABLE MsMember ADD CONSTRAINT check_memberphone CHECK (MemberPhone REGEXP '^[0-9]+$');",
  'check' => "SELECT COLUMN_NAME, DATA_TYPE, CHARACTER_MAXIMUM_LENGTH FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND COLUMN_NAME = 'MemberPhone' UNION ALL SELECT CONSTRAINT_NAME, 'check', NULL FROM information_schema.CHECK_CONSTRAINTS WHERE CONSTRAINT_SCHEMA = DATABASE() AND CONSTRAINT_NAME = 'check_memberphone';" ],

[ 'topic' => 'DELETE + IN',
  'text' => "Delete the sales whose SaleID is 'SA010', 'SA020', or 'SA030'.",
  'hint' => 'DELETE FROM ... WHERE ... IN',
  'ref' => "DELETE FROM SalesHeader WHERE SaleID IN ('SA010','SA020','SA030');",
  'check' => "SELECT (SELECT COUNT(*) FROM SalesHeader) AS headers, (SELECT COUNT(*) FROM SalesDetail) AS details;" ],

[ 'topic' => 'UPDATE',
  'text' => "Add 50 to BookStock for every book whose stock is below 20.",
  'hint' => 'UPDATE ... SET ... WHERE',
  'ref' => "UPDATE MsBook SET BookStock = BookStock + 50 WHERE BookStock < 20;",
  'check' => "SELECT BookID, BookStock FROM MsBook;" ],

[ 'topic' => 'UPDATE + INSERT + TIMESTAMPDIFF',
  'text' => "Update MsMember: add 'vip.' right after the '@' in the email (e.g. 'maria37@yahoo.co.id' → 'maria37@vip.yahoo.co.id') for every member whose age on January 1st, 2024 is over 25.",
  'hint' => 'INSERT, LOCATE, TIMESTAMPDIFF',
  'ref' => "UPDATE MsMember SET MemberEmail = INSERT(MemberEmail, LOCATE('@', MemberEmail) + 1, 0, 'vip.') WHERE TIMESTAMPDIFF(YEAR, MemberDOB, '2024-01-01') > 25;",
  'check' => "SELECT MemberID, MemberEmail FROM MsMember;" ],

[ 'topic' => 'DISTINCT + 3-table JOIN',
  'text' => "Display StaffName and StaffAddress for every staff who ever served a 'Male' member in July. Each staff only once.",
  'hint' => 'DISTINCT, JOIN, MONTH',
  'ref' => "SELECT DISTINCT StaffName, StaffAddress FROM MsStaff ms JOIN SalesHeader sh ON ms.StaffID = sh.StaffID JOIN MsMember mm ON sh.MemberID = mm.MemberID WHERE MemberGender = 'Male' AND MONTH(SaleDate) = 7;" ],

[ 'topic' => 'VIEW',
  'text' => "Create a view named 'member_lastname_view' that displays MemberID and LastName (the last word of MemberName) for every member.",
  'hint' => 'CREATE VIEW, RIGHT, POSITION, REVERSE',
  'ref' => "CREATE VIEW member_lastname_view AS SELECT MemberID, RIGHT(MemberName, POSITION(' ' IN REVERSE(MemberName)) - 1) AS LastName FROM MsMember;",
  'check' => "SELECT MemberID, TRIM(LastName) FROM member_lastname_view;" ],

[ 'topic' => 'TEMPORARY TABLE + middle words',
  'text' => "Create a temporary table named 'staff_street' that stores StaffID, StaffCode (the first two characters of the staff name in uppercase), and StreetName (the address without its first and last word, e.g. '605 Pine Hill Drive' → 'Pine Hill').",
  'hint' => 'CREATE TEMPORARY TABLE ... AS SELECT, UPPER, LEFT, SUBSTR, POSITION, LENGTH, REVERSE',
  'ref' => "CREATE TEMPORARY TABLE staff_street AS SELECT StaffID, UPPER(LEFT(StaffName, 2)) AS StaffCode, SUBSTR(StaffAddress, POSITION(' ' IN StaffAddress) + 1, LENGTH(StaffAddress) - POSITION(' ' IN StaffAddress) - POSITION(' ' IN REVERSE(StaffAddress))) AS StreetName FROM MsStaff;",
  'check' => "SELECT StaffID, StaffCode, TRIM(StreetName) FROM staff_street;" ],

[ 'topic' => 'TEMPORARY TABLE + TOP N',
  'text' => "Create a temporary table named 'best_books' that stores BookTitle and Total Sold (the sum of Qty) for the 3 books with the highest Total Sold.",
  'hint' => 'SUM, GROUP BY, ORDER BY ... DESC, LIMIT',
  'ref' => "CREATE TEMPORARY TABLE best_books AS SELECT BookTitle, SUM(Qty) AS `Total Sold` FROM MsBook mb JOIN SalesDetail sd ON mb.BookID = sd.BookID GROUP BY mb.BookID, BookTitle ORDER BY `Total Sold` DESC LIMIT 3;",
  'check' => "SELECT * FROM best_books;" ],

[ 'topic' => 'VIEW + COUNT DISTINCT',
  'text' => "Create a view named 'staff_h2_view' that displays StaffID, StaffName, and Sale Count (the number of different sales each staff made) for sales in the second half of 2023 (July–December).",
  'hint' => 'CREATE VIEW, COUNT(DISTINCT ...), MONTH, GROUP BY',
  'ref' => "CREATE VIEW staff_h2_view AS SELECT ms.StaffID, StaffName, COUNT(DISTINCT sh.SaleID) AS `Sale Count` FROM MsStaff ms JOIN SalesHeader sh ON ms.StaffID = sh.StaffID WHERE MONTH(SaleDate) > 6 GROUP BY ms.StaffID, StaffName;",
  'check' => "SELECT * FROM staff_h2_view;" ],

[ 'topic' => 'VIEW + SUM + CAST',
  'text' => "Create a view named 'odd_sale_view' that displays SaleID and Total ('$' + the sum of Qty * BookPrice rounded to 2 decimals) for every sale whose SaleID number is odd.",
  'hint' => 'CREATE VIEW, CONCAT, ROUND, SUM, CAST, RIGHT',
  'ref' => "CREATE VIEW odd_sale_view AS SELECT sh.SaleID, CONCAT('$', ROUND(SUM(Qty * BookPrice), 2)) AS Total FROM SalesHeader sh JOIN SalesDetail sd ON sh.SaleID = sd.SaleID JOIN MsBook mb ON sd.BookID = mb.BookID WHERE CAST(RIGHT(sh.SaleID, 3) AS UNSIGNED) % 2 = 1 GROUP BY sh.SaleID;",
  'check' => "SELECT * FROM odd_sale_view;" ],

[ 'topic' => 'CREATE TABLE + CHECK',
  'text' => "Create table MsPublisher: PublisherID CHAR(5) primary key that must start with 'PB' followed by 3 numbers, PublisherName VARCHAR(50) that cannot be empty, and PublisherCity VARCHAR(30) that cannot be empty.",
  'hint' => 'CREATE TABLE, PRIMARY KEY, NOT NULL, CHECK ... REGEXP',
  'ref' => "CREATE TABLE MsPublisher (PublisherID CHAR(5) PRIMARY KEY CHECK (PublisherID REGEXP '^PB[0-9]{3}$'), PublisherName VARCHAR(50) NOT NULL, PublisherCity VARCHAR(30) NOT NULL);",
  'check' => "SELECT COLUMN_NAME AS `Column Name`, UPPER(DATA_TYPE) AS `Data Type`, CHARACTER_MAXIMUM_LENGTH AS Size, IF(COLUMN_KEY = 'PRI', 'YES', 'NO') AS `Primary Key`, IF(IS_NULLABLE = 'NO', 'NOT NULL', 'NULLABLE') AS `Not Null` FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'mspublisher' UNION ALL SELECT 'CHECK constraints', COUNT(*), '', '', '' FROM information_schema.CHECK_CONSTRAINTS WHERE CONSTRAINT_SCHEMA = DATABASE() AND TABLE_NAME = 'mspublisher';" ],

[ 'topic' => 'CREATE TABLE + composite key + FK',
  'text' => "Create table Wishlist: MemberID CHAR(5) and BookID CHAR(5) together form the primary key; each references MsMember / MsBook with ON UPDATE CASCADE ON DELETE CASCADE; Priority INT cannot be empty and must be between 1 and 5.",
  'hint' => 'PRIMARY KEY (a, b), FOREIGN KEY ... REFERENCES ... CASCADE, CHECK ... BETWEEN',
  'ref' => "CREATE TABLE Wishlist (MemberID CHAR(5), BookID CHAR(5), Priority INT NOT NULL CHECK (Priority BETWEEN 1 AND 5), PRIMARY KEY (MemberID, BookID), FOREIGN KEY (MemberID) REFERENCES MsMember(MemberID) ON UPDATE CASCADE ON DELETE CASCADE, FOREIGN KEY (BookID) REFERENCES MsBook(BookID) ON UPDATE CASCADE ON DELETE CASCADE);",
  'check' => "SELECT COLUMN_NAME, COLUMN_KEY, IS_NULLABLE FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'wishlist' UNION ALL SELECT REFERENCED_TABLE_NAME, UPDATE_RULE, DELETE_RULE FROM information_schema.REFERENTIAL_CONSTRAINTS WHERE CONSTRAINT_SCHEMA = DATABASE() AND TABLE_NAME = 'wishlist' UNION ALL SELECT 'checks', COUNT(*), '' FROM information_schema.CHECK_CONSTRAINTS WHERE CONSTRAINT_SCHEMA = DATABASE() AND TABLE_NAME = 'wishlist';" ],

[ 'topic' => 'HAVING',
  'text' => "Display GenreName and Book Count for every genre that has more than 5 books.",
  'hint' => 'JOIN, COUNT, GROUP BY, HAVING',
  'ref' => "SELECT GenreName, COUNT(BookID) AS `Book Count` FROM MsGenre mg JOIN MsBook mb ON mg.GenreID = mb.GenreID GROUP BY mg.GenreID, GenreName HAVING COUNT(BookID) > 5;" ],

[ 'topic' => 'Subquery · AVG',
  'text' => "Display BookTitle and BookPrice for every book that is cheaper than the average book price.",
  'hint' => 'WHERE col < (SELECT AVG(...) FROM ...)',
  'ref' => "SELECT BookTitle, BookPrice FROM MsBook WHERE BookPrice < (SELECT AVG(BookPrice) FROM MsBook);" ],

[ 'topic' => 'LEFT JOIN · count zero',
  'text' => "Display StaffName and Sale Count for every staff, including staff with 0 sales.",
  'hint' => 'LEFT JOIN, COUNT(sh.SaleID), GROUP BY',
  'ref' => "SELECT StaffName, COUNT(sh.SaleID) AS `Sale Count` FROM MsStaff ms LEFT JOIN SalesHeader sh ON ms.StaffID = sh.StaffID GROUP BY ms.StaffID, StaffName;" ],

[ 'topic' => 'CASE WHEN',
  'text' => "Display BookTitle, BookStock, and Stock Level: 'Low' if the stock is below 30, 'Medium' if below 80, otherwise 'High'.",
  'hint' => 'CASE WHEN ... THEN ... WHEN ... ELSE ... END',
  'ref' => "SELECT BookTitle, BookStock, CASE WHEN BookStock < 30 THEN 'Low' WHEN BookStock < 80 THEN 'Medium' ELSE 'High' END AS `Stock Level` FROM MsBook;" ],
];
