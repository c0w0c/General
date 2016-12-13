<?php
	header("Content-Type:text/html; charset=utf-8");

	$work_id = $_POST['work_id'];

	//開啟 PDO 設定連結 MySQL 資料庫
	include 'include/PDO.php';

	// 傳回class資料表的所有紀錄
	$sql = 'SELECT * FROM emp where work_id = '.$work_id;

	$reslut = $pdo->prepare($sql);
	$reslut->execute();
	// 顯示每一筆紀錄
	$row = $reslut->fetch(PDO::FETCH_ASSOC);

	if (!empty($row['work_id'])) {
		echo "<strong style='color:red;'>該工號已經使用</strong>";
	}else{
		echo "<strong style='color:green;'>可以使用</strong>";
	}
?>