<?php
// 20 questions from COMP6799 practicum sheets 02-04 (hehe_groceries data).
// ref = reference answer; check = query run after your SQL (for DML/DDL); ordered = row order matters.
$QUESTIONS = [
[ 'topic' => 'Sheet 02 · LIKE',
  'text' => "Display all data from MsCategory for every category whose name contains the letter 'a'.",
  'hint' => 'LIKE',
  'ref' => "SELECT * FROM MsCategory WHERE CategoryName LIKE '%a%';" ],

[ 'topic' => 'Sheet 02 · CONCAT',
  'text' => "Display CustomerName (obtained by adding 'Mr. ' before the customer name, e.g. 'Mr. Dirk Titterell'), CustomerGender, and CustomerAddress for every 'Male' customer.",
  'hint' => 'CONCAT, LIKE',
  'ref' => "SELECT CONCAT('Mr. ', CustomerName) AS CustomerName, CustomerGender, CustomerAddress FROM MsCustomer WHERE CustomerGender LIKE 'Male';" ],

[ 'topic' => 'Sheet 02 · REPLACE + DATE_SUB',
  'text' => "Display Transaction Number (obtained by replacing 'TR' with 'Transaction ' in TransactionID, e.g. 'Transaction 001'), CustomerID, and TransactionID for every transaction that occurred between 1 year before January 31st, 2023 and January 31st, 2023.",
  'hint' => 'REPLACE, DATE_SUB, BETWEEN',
  'ref' => "SELECT REPLACE(TransactionID, 'TR', 'Transaction ') AS `Transaction Number`, CustomerID, TransactionID FROM TransactionHeader WHERE TransactionDate BETWEEN DATE_SUB('2023-01-31', INTERVAL 1 YEAR) AND '2023-01-31';" ],

[ 'topic' => 'Sheet 02 · CONCAT + ROUND',
  'text' => "Display ProductName and Announcement (obtained by adding 'Price: $' before the product price discounted by 50% and rounded to 2 decimals, then adding ' just for today!' after it) for every product whose name ends with 'Cheese'.",
  'hint' => 'CONCAT, ROUND, LIKE',
  'ref' => "SELECT ProductName, CONCAT('Price: $', ROUND(ProductPrice * 0.5, 2), ' just for today!') AS Announcement FROM MsProduct WHERE ProductName LIKE '%Cheese';" ],

[ 'topic' => 'Sheet 02 · RIGHT + REVERSE',
  'text' => "Display CustomerName and AddressType (obtained from the last word of CustomerAddress, e.g. '811 Debs Street' → 'Street') for every 'Female' customer.",
  'hint' => 'RIGHT, POSITION, REVERSE, LIKE',
  'ref' => "SELECT CustomerName, RIGHT(CustomerAddress, POSITION(' ' IN REVERSE(CustomerAddress)) - 1) AS AddressType FROM MsCustomer WHERE CustomerGender LIKE 'Female';" ],

[ 'topic' => 'Sheet 02 · DAYNAME + INSERT',
  'text' => "Display TransactionID, Day (the day name of the transaction), CustomerName (in uppercase), and Email (obtained by replacing everything after '@' with 'gmail.com', e.g. 'ddiano1@gmail.com') for every transaction that happened in November and was done by a customer whose name is shorter than 12 characters.",
  'hint' => 'DAYNAME, UPPER, INSERT, POSITION, LENGTH, MONTH, JOIN',
  'ref' => "SELECT th.TransactionID, DAYNAME(TransactionDate) AS Day, UPPER(CustomerName) AS CustomerName, INSERT(CustomerEmail, POSITION('@' IN CustomerEmail) + 1, LENGTH(CustomerEmail), 'gmail.com') AS Email FROM TransactionHeader th JOIN MsCustomer mc ON th.CustomerID = mc.CustomerID WHERE MONTH(TransactionDate) = 11 AND LENGTH(CustomerName) < 12;" ],

[ 'topic' => 'Sheet 02 · GROUP_CONCAT',
  'text' => "Display TransactionID, Product Bought (all product names bought in the transaction, in alphabetical order, separated by ', '), and Date (transaction date in dd-mm-yyyy format, e.g. '05-08-2022') for every transaction that happened in August on an odd day.",
  'hint' => 'GROUP_CONCAT(... ORDER BY ... SEPARATOR), DATE_FORMAT, MONTH, DAY, GROUP BY',
  'ref' => "SELECT th.TransactionID, GROUP_CONCAT(ProductName ORDER BY ProductName SEPARATOR ', ') AS `Product Bought`, DATE_FORMAT(TransactionDate, '%d-%m-%Y') AS Date FROM TransactionHeader th JOIN TransactionDetail td ON th.TransactionID = td.TransactionID JOIN MsProduct mp ON td.ProductID = mp.ProductID WHERE MONTH(TransactionDate) = 8 AND DAY(TransactionDate) % 2 = 1 GROUP BY th.TransactionID, TransactionDate;" ],

[ 'topic' => 'Sheet 03 · INSERT',
  'text' => "Insert these rows into TransactionDetail (TransactionID, ProductID, Quantity): ('TR001','PR014',27), ('TR001','PR010',2), ('TR005','PR005',26), ('TR005','PR002',21).",
  'hint' => 'INSERT INTO ... VALUES (...), (...)',
  'ref' => "INSERT INTO TransactionDetail VALUES ('TR001','PR014',27), ('TR001','PR010',2), ('TR005','PR005',26), ('TR005','PR002',21);",
  'check' => "SELECT * FROM TransactionDetail WHERE TransactionID IN ('TR001','TR005');" ],

[ 'topic' => 'Sheet 03 · ALTER TABLE + CHECK',
  'text' => "Add a column CustomerPhone VARCHAR(50) to MsCustomer, then add a constraint named 'check_phonenumber' so CustomerPhone must be numeric. (Trap: the table already has rows. Think about what NOT NULL would put in them.)",
  'hint' => 'ALTER TABLE ... ADD, ADD CONSTRAINT ... CHECK, REGEXP',
  'ref' => "ALTER TABLE MsCustomer ADD CustomerPhone VARCHAR(50); ALTER TABLE MsCustomer ADD CONSTRAINT check_phonenumber CHECK (CustomerPhone REGEXP '^[0-9]+$');",
  'check' => "SELECT COLUMN_NAME, DATA_TYPE, CHARACTER_MAXIMUM_LENGTH FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND COLUMN_NAME = 'CustomerPhone' UNION ALL SELECT CONSTRAINT_NAME, 'check', NULL FROM information_schema.CHECK_CONSTRAINTS WHERE CONSTRAINT_SCHEMA = DATABASE() AND CONSTRAINT_NAME = 'check_phonenumber';" ],

[ 'topic' => 'Sheet 03 · DELETE + IN',
  'text' => "Delete data from TransactionHeader for every transaction whose TransactionID is 'TR001', 'TR003', or 'TR005'.",
  'hint' => 'DELETE FROM ... WHERE ... IN',
  'ref' => "DELETE FROM TransactionHeader WHERE TransactionID IN ('TR001','TR003','TR005');",
  'check' => "SELECT (SELECT COUNT(*) FROM TransactionHeader) AS headers, (SELECT COUNT(*) FROM TransactionDetail) AS details;" ],

[ 'topic' => 'Sheet 03 · UPDATE',
  'text' => "Update MsProduct by subtracting 2 from ProductPrice for every product whose price is above 10.",
  'hint' => 'UPDATE ... SET ... WHERE',
  'ref' => "UPDATE MsProduct SET ProductPrice = ProductPrice - 2 WHERE ProductPrice > 10;",
  'check' => "SELECT ProductID, ProductPrice FROM MsProduct;" ],

[ 'topic' => 'Sheet 03 · UPDATE + TIMESTAMPDIFF',
  'text' => "Update MsCustomer: add 'Mrs. ' before the customer name, and add 'lady' before the '@' in the email (e.g. 'cjermey3@guardian.com' → 'cjermey3lady@guardian.com'), for every female customer whose age is over 20.",
  'hint' => 'CONCAT, INSERT, LOCATE, TIMESTAMPDIFF, CURDATE',
  'ref' => "UPDATE MsCustomer SET CustomerName = CONCAT('Mrs. ', CustomerName), CustomerEmail = INSERT(CustomerEmail, LOCATE('@', CustomerEmail), 0, 'lady') WHERE CustomerGender = 'Female' AND TIMESTAMPDIFF(YEAR, CustomerDOB, CURDATE()) > 20;",
  'check' => "SELECT CustomerID, CustomerName, CustomerEmail FROM MsCustomer;" ],

[ 'topic' => 'Sheet 03 · JOIN',
  'text' => "Display ProductID, ProductName, ProductPrice (with '$' in front, e.g. '$5.99'), and CategoryName for every product whose category is 'Dairy' or 'Meat'.",
  'hint' => 'CONCAT, JOIN, IN',
  'ref' => "SELECT ProductID, ProductName, CONCAT('$', ProductPrice) AS ProductPrice, CategoryName FROM MsProduct mp JOIN MsCategory mc ON mp.CategoryID = mc.CategoryID WHERE CategoryName IN ('Dairy','Meat');" ],

[ 'topic' => 'Sheet 03 · DISTINCT + 3-table JOIN',
  'text' => "Display EmployeeName and EmployeeAddress for every employee who ever handled a transaction with a female customer in December. Each employee only once.",
  'hint' => 'DISTINCT, JOIN, MONTH',
  'ref' => "SELECT DISTINCT EmployeeName, EmployeeAddress FROM MsEmployee me JOIN TransactionHeader th ON me.EmployeeID = th.EmployeeID JOIN MsCustomer mc ON th.CustomerID = mc.CustomerID WHERE CustomerGender = 'Female' AND MONTH(TransactionDate) = 12;" ],

[ 'topic' => 'Sheet 04 · VIEW',
  'text' => "Create a view named 'customer_firstname_view' that displays CustomerID and FirstName (the first word of the customer name) for every customer.",
  'hint' => 'CREATE VIEW, LEFT, POSITION',
  'ref' => "CREATE VIEW customer_firstname_view AS SELECT CustomerID, LEFT(CustomerName, POSITION(' ' IN CustomerName) - 1) AS FirstName FROM MsCustomer;",
  'check' => "SELECT CustomerID, TRIM(FirstName) FROM customer_firstname_view;" ],

[ 'topic' => 'Sheet 04 · TEMPORARY TABLE',
  'text' => "Create a temporary table named 'employee_location' that stores EmployeeID, EmployeeInitial (the first three characters of the employee name in uppercase), and AddressLocation (the address without its first and last word, e.g. '0975 Forest Dale Trail' → 'Forest Dale').",
  'hint' => 'CREATE TEMPORARY TABLE ... AS SELECT, UPPER, LEFT, SUBSTR, POSITION, LENGTH, REVERSE',
  'ref' => "CREATE TEMPORARY TABLE employee_location AS SELECT EmployeeID, UPPER(LEFT(EmployeeName, 3)) AS EmployeeInitial, SUBSTR(EmployeeAddress, POSITION(' ' IN EmployeeAddress) + 1, LENGTH(EmployeeAddress) - POSITION(' ' IN EmployeeAddress) - POSITION(' ' IN REVERSE(EmployeeAddress))) AS AddressLocation FROM MsEmployee;",
  'check' => "SELECT EmployeeID, EmployeeInitial, TRIM(AddressLocation) FROM employee_location;" ],

[ 'topic' => 'Sheet 04 · TEMPORARY TABLE + TOP 5',
  'text' => "Create a temporary table named 'top_customer' that stores CustomerName, CustomerEmail (everything after '@' replaced with 'gmail.com'), and TransactionCount (the number of transactions of the customer) for the 5 customers with the highest TransactionCount.",
  'hint' => 'INSERT, LOCATE, COUNT, GROUP BY, ORDER BY ... DESC, LIMIT',
  'ref' => "CREATE TEMPORARY TABLE top_customer AS SELECT CustomerName, INSERT(CustomerEmail, LOCATE('@', CustomerEmail) + 1, LENGTH(CustomerEmail), 'gmail.com') AS CustomerEmail, COUNT(th.TransactionID) AS TransactionCount FROM MsCustomer mc JOIN TransactionHeader th ON mc.CustomerID = th.CustomerID GROUP BY mc.CustomerID, CustomerName, CustomerEmail ORDER BY TransactionCount DESC LIMIT 5;",
  'check' => "SELECT * FROM top_customer;" ],

[ 'topic' => 'Sheet 04 · VIEW + COUNT DISTINCT',
  'text' => "Create a view named 'employee_2022_view' that displays EmployeeID, EmployeeName, and Transaction Count (the number of transactions of each employee) for transactions done in 2022. Duplicated items must be counted only once.",
  'hint' => 'CREATE VIEW, COUNT(DISTINCT ...), YEAR, GROUP BY',
  'ref' => "CREATE VIEW employee_2022_view AS SELECT me.EmployeeID, EmployeeName, COUNT(DISTINCT th.TransactionID) AS `Transaction Count` FROM MsEmployee me JOIN TransactionHeader th ON me.EmployeeID = th.EmployeeID WHERE YEAR(TransactionDate) = 2022 GROUP BY me.EmployeeID, EmployeeName;",
  'check' => "SELECT * FROM employee_2022_view;" ],

[ 'topic' => 'Sheet 04 · VIEW + SUM + CAST',
  'text' => "Create a view named 'even_transaction_view' that displays TransactionID and TotalPrice ('$' + the sum of Quantity * ProductPrice rounded to 2 decimals) for every transaction whose TransactionID number is even.",
  'hint' => 'CREATE VIEW, CONCAT, ROUND, SUM, CAST, RIGHT',
  'ref' => "CREATE VIEW even_transaction_view AS SELECT th.TransactionID, CONCAT('$', ROUND(SUM(Quantity * ProductPrice), 2)) AS TotalPrice FROM TransactionHeader th JOIN TransactionDetail td ON th.TransactionID = td.TransactionID JOIN MsProduct mp ON td.ProductID = mp.ProductID WHERE CAST(RIGHT(th.TransactionID, 3) AS UNSIGNED) % 2 = 0 GROUP BY th.TransactionID;",
  'check' => "SELECT * FROM even_transaction_view;" ],

[ 'topic' => 'Sheet 04 · INDEX',
  'text' => "Create an index named 'idx_productname' on the ProductName column of MsProduct. (Then practise: how do you delete it?)",
  'hint' => 'CREATE INDEX ... ON table(column) · DROP INDEX ... ON table',
  'ref' => "CREATE INDEX idx_productname ON MsProduct(ProductName);",
  'check' => "SELECT INDEX_NAME, COLUMN_NAME, NON_UNIQUE FROM information_schema.STATISTICS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'msproduct' ORDER BY 1, 2;" ],

// ---- Sheet 01: DDL + basic DML ----
[ 'topic' => 'Sheet 01 · CREATE TABLE + CHECK',
  'text' => "Create table MsBrand: BrandID CHAR(5) primary key that must start with 'BR' followed by 3 numbers (e.g. BR001), and BrandName VARCHAR(50) that cannot be empty.",
  'hint' => 'CREATE TABLE, PRIMARY KEY, NOT NULL, CHECK ... REGEXP',
  'ref' => "CREATE TABLE MsBrand (BrandID CHAR(5) PRIMARY KEY CHECK (BrandID REGEXP '^BR[0-9]{3}$'), BrandName VARCHAR(50) NOT NULL);",
  'check' => "SELECT COLUMN_NAME AS `Column Name`, UPPER(DATA_TYPE) AS `Data Type`, CHARACTER_MAXIMUM_LENGTH AS Size, IF(COLUMN_KEY = 'PRI', 'YES', 'NO') AS `Primary Key`, IF(IS_NULLABLE = 'NO', 'NOT NULL', 'NULLABLE') AS `Not Null` FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'msbrand' UNION ALL SELECT 'CHECK constraints', COUNT(*), '', '', '' FROM information_schema.CHECK_CONSTRAINTS WHERE CONSTRAINT_SCHEMA = DATABASE() AND TABLE_NAME = 'msbrand';" ],

[ 'topic' => 'Sheet 01 · FOREIGN KEY CASCADE',
  'text' => "The table MsProduct was dropped. Re-create it: ProductID CHAR(5) primary key (must be 'PR' + 3 numbers), CategoryID CHAR(5) referencing MsCategory(CategoryID) — if the referenced data is changed or removed, MsProduct follows (cascade) — ProductName VARCHAR(50) not empty, ProductPrice FLOAT not empty, ProductStock INT not empty.",
  'hint' => 'FOREIGN KEY ... REFERENCES ... ON UPDATE CASCADE ON DELETE CASCADE',
  'setup' => "SET FOREIGN_KEY_CHECKS = 0; DROP TABLE TransactionDetail; DROP TABLE MsProduct;",
  'ref' => "CREATE TABLE MsProduct (ProductID CHAR(5) PRIMARY KEY CHECK (ProductID REGEXP '^PR[0-9]{3}$'), CategoryID CHAR(5) NOT NULL, ProductName VARCHAR(50) NOT NULL, ProductPrice FLOAT NOT NULL, ProductStock INT NOT NULL, FOREIGN KEY (CategoryID) REFERENCES MsCategory(CategoryID) ON UPDATE CASCADE ON DELETE CASCADE);",
  'check' => "SELECT COLUMN_NAME, DATA_TYPE, COLUMN_KEY FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'msproduct' UNION ALL SELECT REFERENCED_TABLE_NAME, UPDATE_RULE, DELETE_RULE FROM information_schema.REFERENTIAL_CONSTRAINTS WHERE CONSTRAINT_SCHEMA = DATABASE() AND TABLE_NAME = 'msproduct';" ],

[ 'topic' => 'Sheet 01 · COMPOSITE PRIMARY KEY',
  'text' => "The table TransactionDetail was dropped. Re-create it: TransactionID CHAR(5) and ProductID CHAR(5) together form the primary key; each references TransactionHeader / MsProduct with ON UPDATE CASCADE ON DELETE CASCADE; Quantity INT not empty and must be more than 0.",
  'hint' => 'PRIMARY KEY (col1, col2), two FOREIGN KEYs, CHECK (Quantity > 0)',
  'setup' => "DROP TABLE TransactionDetail;",
  'ref' => "CREATE TABLE TransactionDetail (TransactionID CHAR(5), ProductID CHAR(5), Quantity INT NOT NULL CHECK (Quantity > 0), PRIMARY KEY (TransactionID, ProductID), FOREIGN KEY (TransactionID) REFERENCES TransactionHeader(TransactionID) ON UPDATE CASCADE ON DELETE CASCADE, FOREIGN KEY (ProductID) REFERENCES MsProduct(ProductID) ON UPDATE CASCADE ON DELETE CASCADE);",
  'check' => "SELECT COLUMN_NAME, COLUMN_KEY, IS_NULLABLE FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'transactiondetail' UNION ALL SELECT REFERENCED_TABLE_NAME, UPDATE_RULE, DELETE_RULE FROM information_schema.REFERENTIAL_CONSTRAINTS WHERE CONSTRAINT_SCHEMA = DATABASE() AND TABLE_NAME = 'transactiondetail' UNION ALL SELECT 'checks', COUNT(*), '' FROM information_schema.CHECK_CONSTRAINTS WHERE CONSTRAINT_SCHEMA = DATABASE() AND TABLE_NAME = 'transactiondetail';" ],

[ 'topic' => 'Sheet 01 · DROP TABLE',
  'text' => "A table MsBrand exists. Delete the MsBrand table.",
  'hint' => 'DROP TABLE',
  'setup' => "CREATE TABLE MsBrand (BrandID CHAR(5) PRIMARY KEY, BrandName VARCHAR(50) NOT NULL);",
  'ref' => "DROP TABLE MsBrand;",
  'check' => "SELECT COUNT(*) FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'msbrand';" ],

[ 'topic' => 'Sheet 01 · INSERT many rows',
  'text' => "Insert these employees into MsEmployee: ('EM016','Clem','Male','0975 Forest Dale Trail'), ('EM017','Lethia','Female','905 Goodland Lane'), ('EM018','Shanda','Male','848 New Castle Center').",
  'hint' => 'INSERT INTO ... VALUES (...), (...), (...)',
  'ref' => "INSERT INTO MsEmployee VALUES ('EM016','Clem','Male','0975 Forest Dale Trail'), ('EM017','Lethia','Female','905 Goodland Lane'), ('EM018','Shanda','Male','848 New Castle Center');",
  'check' => "SELECT * FROM MsEmployee WHERE EmployeeID >= 'EM016';" ],

[ 'topic' => 'Sheet 01 · SELECT + WHERE',
  'text' => "Display all data for the customer whose name is 'Dirk Titterell'.",
  'hint' => 'SELECT *, WHERE / LIKE',
  'ref' => "SELECT * FROM MsCustomer WHERE CustomerName LIKE 'Dirk Titterell';" ],

[ 'topic' => 'ALTER TABLE · MODIFY + DROP COLUMN',
  'text' => "Change EmployeeAddress in MsEmployee to VARCHAR(100), then remove the EmployeeGender column.",
  'hint' => 'ALTER TABLE ... MODIFY col type · ALTER TABLE ... DROP COLUMN col',
  'ref' => "ALTER TABLE MsEmployee MODIFY EmployeeAddress VARCHAR(100) NOT NULL; ALTER TABLE MsEmployee DROP COLUMN EmployeeGender;",
  'check' => "SELECT COLUMN_NAME, COLUMN_TYPE FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'msemployee';" ],

// ---- Aggregates ----
[ 'topic' => 'Aggregate · COUNT + GROUP BY',
  'text' => "Display CustomerGender and Total (the number of customers) for each gender.",
  'hint' => 'COUNT(*), GROUP BY',
  'ref' => "SELECT CustomerGender, COUNT(*) AS Total FROM MsCustomer GROUP BY CustomerGender;" ],

[ 'topic' => 'Aggregate · HAVING',
  'text' => "Display CategoryName and Product Count for every category that has more than 10 products.",
  'hint' => 'JOIN, COUNT, GROUP BY, HAVING (WHERE cannot filter on COUNT)',
  'ref' => "SELECT CategoryName, COUNT(ProductID) AS `Product Count` FROM MsCategory mc JOIN MsProduct mp ON mc.CategoryID = mp.CategoryID GROUP BY mc.CategoryID, CategoryName HAVING COUNT(ProductID) > 10;" ],

[ 'topic' => 'Aggregate · SUM + ORDER BY',
  'text' => "Display ProductName and Total Sold (the sum of quantity sold) for every product with at least 100 units sold, ordered from the highest Total Sold.",
  'hint' => 'SUM, GROUP BY, HAVING, ORDER BY ... DESC',
  'ordered' => true,
  'ref' => "SELECT ProductName, SUM(Quantity) AS `Total Sold` FROM MsProduct mp JOIN TransactionDetail td ON mp.ProductID = td.ProductID GROUP BY mp.ProductID, ProductName HAVING SUM(Quantity) >= 100 ORDER BY `Total Sold` DESC;" ],

[ 'topic' => 'Aggregate · MAX / MIN / AVG',
  'text' => "Display Highest Price, Lowest Price, and Average Price (rounded to 2 decimals) of all products.",
  'hint' => 'MAX, MIN, AVG, ROUND',
  'ref' => "SELECT MAX(ProductPrice) AS `Highest Price`, MIN(ProductPrice) AS `Lowest Price`, ROUND(AVG(ProductPrice), 2) AS `Average Price` FROM MsProduct;" ],

[ 'topic' => 'Aggregate · TOP N',
  'text' => "Display EmployeeName and Revenue (the sum of Quantity * ProductPrice, rounded to 2 decimals) for the 3 employees with the highest revenue, highest first.",
  'hint' => '3-table JOIN, SUM, ROUND, GROUP BY, ORDER BY DESC, LIMIT',
  'ordered' => true,
  'ref' => "SELECT EmployeeName, ROUND(SUM(Quantity * ProductPrice), 2) AS Revenue FROM MsEmployee me JOIN TransactionHeader th ON me.EmployeeID = th.EmployeeID JOIN TransactionDetail td ON th.TransactionID = td.TransactionID JOIN MsProduct mp ON td.ProductID = mp.ProductID GROUP BY me.EmployeeID, EmployeeName ORDER BY Revenue DESC LIMIT 3;" ],

[ 'topic' => 'Aggregate · per month',
  'text' => "Display Month (the month name, e.g. 'January') and Transaction Count for every month that has transactions, ordered by month (January first).",
  'hint' => 'MONTHNAME, COUNT, GROUP BY, ORDER BY MONTH(...)',
  'ordered' => true,
  'ref' => "SELECT MONTHNAME(TransactionDate) AS Month, COUNT(*) AS `Transaction Count` FROM TransactionHeader GROUP BY MONTH(TransactionDate), MONTHNAME(TransactionDate) ORDER BY MONTH(TransactionDate);" ],

// ---- Subqueries ----
[ 'topic' => 'Subquery · compare with AVG',
  'text' => "Display ProductName and ProductPrice for every product whose price is higher than the average price of all products.",
  'hint' => 'WHERE col > (SELECT AVG(...) FROM ...)',
  'ref' => "SELECT ProductName, ProductPrice FROM MsProduct WHERE ProductPrice > (SELECT AVG(ProductPrice) FROM MsProduct);" ],

[ 'topic' => 'Subquery · NOT IN',
  'text' => "Display ProductID and ProductName for every product that has never been sold.",
  'hint' => 'NOT IN (SELECT ...) — or LEFT JOIN ... WHERE ... IS NULL',
  'ref' => "SELECT ProductID, ProductName FROM MsProduct WHERE ProductID NOT IN (SELECT ProductID FROM TransactionDetail);" ],

[ 'topic' => 'Subquery · ties for the max',
  'text' => "Display CustomerName and Transaction Count of the customer(s) with the most transactions. If there is a tie, show all of them.",
  'hint' => 'GROUP BY + HAVING COUNT(*) = (SELECT MAX(...) FROM (subquery) AS x) — LIMIT 1 loses ties!',
  'ref' => "SELECT CustomerName, COUNT(*) AS `Transaction Count` FROM MsCustomer mc JOIN TransactionHeader th ON mc.CustomerID = th.CustomerID GROUP BY mc.CustomerID, CustomerName HAVING COUNT(*) = (SELECT MAX(cnt) FROM (SELECT COUNT(*) AS cnt FROM TransactionHeader GROUP BY CustomerID) AS x);" ],

[ 'topic' => 'Subquery · EXISTS',
  'text' => "Display EmployeeID and EmployeeName for every employee who handled at least one transaction that contains a 'Meat' product.",
  'hint' => 'WHERE EXISTS (SELECT ... correlated) — or JOIN + DISTINCT',
  'ref' => "SELECT EmployeeID, EmployeeName FROM MsEmployee me WHERE EXISTS (SELECT 1 FROM TransactionHeader th JOIN TransactionDetail td ON th.TransactionID = td.TransactionID JOIN MsProduct mp ON td.ProductID = mp.ProductID JOIN MsCategory mc ON mp.CategoryID = mc.CategoryID WHERE th.EmployeeID = me.EmployeeID AND CategoryName = 'Meat');" ],

// ---- Outer join / UNION ----
[ 'topic' => 'LEFT JOIN · count zero',
  'text' => "Display EmployeeName and Transaction Count for every employee, including employees with 0 transactions.",
  'hint' => 'LEFT JOIN, COUNT(th.TransactionID) — COUNT(*) would count 1 for nobody',
  'ref' => "SELECT EmployeeName, COUNT(th.TransactionID) AS `Transaction Count` FROM MsEmployee me LEFT JOIN TransactionHeader th ON me.EmployeeID = th.EmployeeID GROUP BY me.EmployeeID, EmployeeName;" ],

[ 'topic' => 'LEFT JOIN · filter',
  'text' => "Display CustomerName, CustomerEmail, CustomerDOB, TransactionID, and TransactionDate for every customer whose name contains 'm' and who was born between January and August (customers without transactions must still appear).",
  'hint' => 'LEFT JOIN, LIKE, MONTH, BETWEEN',
  'ref' => "SELECT CustomerName, CustomerEmail, CustomerDOB, th.TransactionID, th.TransactionDate FROM MsCustomer mc LEFT JOIN TransactionHeader th ON mc.CustomerID = th.CustomerID WHERE CustomerName LIKE '%m%' AND MONTH(CustomerDOB) BETWEEN 1 AND 8;" ],

[ 'topic' => 'UNION',
  'text' => "Display TransactionCode, ProductName, CustomerName (uppercase), and Quantity: for 'Wild' products bought with quantity more than 12, TransactionCode replaces 'TR' with 'Wild-'; combined with 'Organic' products bought with quantity less than 12, where TransactionCode replaces 'TR' with 'Organic-'.",
  'hint' => 'SELECT ... UNION SELECT ... (same number of columns, same order)',
  'ref' => "SELECT REPLACE(th.TransactionID, 'TR', 'Wild-') AS TransactionCode, ProductName, UPPER(CustomerName) AS CustomerName, Quantity FROM TransactionHeader th JOIN TransactionDetail td ON th.TransactionID = td.TransactionID JOIN MsProduct mp ON td.ProductID = mp.ProductID JOIN MsCustomer mc ON th.CustomerID = mc.CustomerID WHERE ProductName LIKE '%Wild%' AND Quantity > 12 UNION SELECT REPLACE(th.TransactionID, 'TR', 'Organic-'), ProductName, UPPER(CustomerName), Quantity FROM TransactionHeader th JOIN TransactionDetail td ON th.TransactionID = td.TransactionID JOIN MsProduct mp ON td.ProductID = mp.ProductID JOIN MsCustomer mc ON th.CustomerID = mc.CustomerID WHERE ProductName LIKE '%Organic%' AND Quantity < 12;" ],

// ---- CASE / IF ----
[ 'topic' => 'CASE WHEN',
  'text' => "Display ProductName, ProductPrice, and Price Level: 'Cheap' if the price is below 3, 'Normal' if below 8, otherwise 'Expensive'.",
  'hint' => 'CASE WHEN ... THEN ... WHEN ... ELSE ... END',
  'ref' => "SELECT ProductName, ProductPrice, CASE WHEN ProductPrice < 3 THEN 'Cheap' WHEN ProductPrice < 8 THEN 'Normal' ELSE 'Expensive' END AS `Price Level` FROM MsProduct;" ],

[ 'topic' => 'IF',
  'text' => "Display ProductName, ProductStock, and Status ('Restock' if the stock is below 50, otherwise 'Available') for every 'Meat' product.",
  'hint' => 'IF(condition, then, else), JOIN',
  'ref' => "SELECT ProductName, ProductStock, IF(ProductStock < 50, 'Restock', 'Available') AS Status FROM MsProduct mp JOIN MsCategory mc ON mp.CategoryID = mc.CategoryID WHERE CategoryName = 'Meat';" ],

// ---- Strings ----
[ 'topic' => 'String · SUBSTRING_INDEX',
  'text' => "Display CustomerName, Username (the part of the email before '@'), and Domain (the part after '@') for every customer.",
  'hint' => "SUBSTRING_INDEX(str, '@', 1) / SUBSTRING_INDEX(str, '@', -1) — or LEFT/SUBSTRING + LOCATE",
  'ref' => "SELECT CustomerName, SUBSTRING_INDEX(CustomerEmail, '@', 1) AS Username, SUBSTRING_INDEX(CustomerEmail, '@', -1) AS Domain FROM MsCustomer;" ],

[ 'topic' => 'String · initials',
  'text' => "Display CustomerName and Initials (first letter of the first name + first letter of the last name, e.g. 'Dirk Titterell' → 'DT') for every customer.",
  'hint' => "CONCAT, LEFT, SUBSTRING_INDEX(name, ' ', -1)",
  'ref' => "SELECT CustomerName, CONCAT(LEFT(CustomerName, 1), LEFT(SUBSTRING_INDEX(CustomerName, ' ', -1), 1)) AS Initials FROM MsCustomer;" ],

[ 'topic' => 'String · LOWER + LENGTH + sort',
  'text' => "Display Name (ProductName in lowercase) and Name Length for every product whose name is longer than 15 characters, ordered by Name Length descending, then Name ascending.",
  'hint' => 'LOWER, LENGTH, ORDER BY a DESC, b ASC',
  'ordered' => true,
  'ref' => "SELECT LOWER(ProductName) AS Name, LENGTH(ProductName) AS `Name Length` FROM MsProduct WHERE LENGTH(ProductName) > 15 ORDER BY `Name Length` DESC, Name ASC;" ],

// ---- Dates ----
[ 'topic' => 'Date · age',
  'text' => "Display CustomerName and Age (in whole years on January 1st, 2023) for every customer born before the year 2001.",
  'hint' => "TIMESTAMPDIFF(YEAR, CustomerDOB, '2023-01-01'), YEAR",
  'ref' => "SELECT CustomerName, TIMESTAMPDIFF(YEAR, CustomerDOB, '2023-01-01') AS Age FROM MsCustomer WHERE YEAR(CustomerDOB) < 2001;" ],

[ 'topic' => 'Date · DATEDIFF + QUARTER',
  'text' => "Display TransactionID and Days Left (the number of days from the transaction date to December 31st, 2022) for every transaction in the 4th quarter of the year.",
  'hint' => "DATEDIFF('2022-12-31', TransactionDate), QUARTER",
  'ref' => "SELECT TransactionID, DATEDIFF('2022-12-31', TransactionDate) AS `Days Left` FROM TransactionHeader WHERE QUARTER(TransactionDate) = 4;" ],

[ 'topic' => 'Date · DATE_ADD + format',
  'text' => "Display TransactionID and Due Date (7 days after the transaction date, formatted like 'January 08, 2022') for every transaction in December.",
  'hint' => "DATE_ADD(date, INTERVAL 7 DAY), DATE_FORMAT(..., '%M %d, %Y')",
  'ref' => "SELECT TransactionID, DATE_FORMAT(DATE_ADD(TransactionDate, INTERVAL 7 DAY), '%M %d, %Y') AS `Due Date` FROM TransactionHeader WHERE MONTH(TransactionDate) = 12;" ],

// ---- DML with JOIN / subquery ----
[ 'topic' => 'UPDATE with JOIN / subquery',
  'text' => "Increase ProductStock by 10 for every product in the 'Fruit' category.",
  'hint' => 'UPDATE ... WHERE CategoryID IN (SELECT ...) — or UPDATE t1 JOIN t2 ON ... SET ...',
  'ref' => "UPDATE MsProduct SET ProductStock = ProductStock + 10 WHERE CategoryID IN (SELECT CategoryID FROM MsCategory WHERE CategoryName = 'Fruit');",
  'check' => "SELECT ProductID, ProductStock FROM MsProduct;" ],

[ 'topic' => 'DELETE with subquery',
  'text' => "Delete all transaction details for products in the 'Vegetable' category.",
  'hint' => 'DELETE FROM ... WHERE ProductID IN (SELECT ... JOIN ...)',
  'ref' => "DELETE FROM TransactionDetail WHERE ProductID IN (SELECT ProductID FROM MsProduct mp JOIN MsCategory mc ON mp.CategoryID = mc.CategoryID WHERE CategoryName = 'Vegetable');",
  'check' => "SELECT TransactionID, ProductID FROM TransactionDetail;" ],
];
