<?PHP
// 設定 MySQL 資料庫的 DSN
$dsn = 'mysql:host=伺服器.com;dbname=資料庫;';
// 建立 PDO 物件
$pdo = new PDO($dsn, '帳號', '密碼');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// 設定 MySQL 資料庫的字元編碼
$pdo->query("SET NAMES 'utf8'");
?>