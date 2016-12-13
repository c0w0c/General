<?PHP
// 開啟資料庫連接
$db = mysql_connect("伺服器位址", "帳號", "密碼");
mysql_query("SET NAMES 'utf8'", $db);//使資料庫編碼為UTF8
mysql_select_db("資料庫");//選擇資料庫
?>