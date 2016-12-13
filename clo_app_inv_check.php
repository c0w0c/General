 <?php
 	header("Content-Type:text/html; charset=utf-8");

 	$type = $_GET['type']; //選擇的關鍵字

	//開啟 PDO 設定連結 MySQL 資料庫
	include 'include/PDO.php';

 	$sql = 'SELECT * FROM clo_inv where type = "' . $type .'"';

 	$reslut = $pdo -> query($sql);
 	$rows = $reslut->fetchAll();

	foreach ($rows as $date) {
		echo $date['amount'] ;
	}

?>
