 <?php
 	header("Content-Type:text/html; charset=utf-8");

 	$star_date = $_GET['star_date']; //起始日期
 	$end_date = $_GET['end_date'];	//結束日期
 	$chart_type = $_GET['chart_type'];	//報表型態
 	$chart_key = $_GET['chart_key']; //關鍵字

	//開啟 PDO 設定連結 MySQL 資料庫
	include 'include/PDO.php';

 	switch ($chart_type) { //判斷報表型態
 		//已總數統計
 		case '':
 			$sql = 'SELECT * FROM sup_app where app_date between "'.$star_date.'" and "'.$end_date.'"';
 			$type = "dep";
 			break;
 		//已申領部門統計
 		case 'dep':
 			$sql = 'SELECT * FROM sup_app where dep = "'.$chart_key.'" and app_date between "'.$star_date.'" and "'.$end_date.'"';
 			$type = "app_sup";
 			break;
 		//已申領物品統計
 		case 'rea':
 			$sql = 'SELECT * FROM sup_app where app_sup LIKE "%'.$chart_key.'%" and app_date between "'.$star_date.'" and "'.$end_date.'"';
 			$type = "dep";
 			break;
 	}

 	$reslut = $pdo -> query($sql);
 	$rows = $reslut->fetchAll();
 	//echo "資料總筆數:".$reslut->rowCount()."筆</br>";
 	$count = $reslut->rowCount();
 	$date = array();
	$num = 0 ;

	if ( $count < 1 ) {
		$date[$num] = array( "label" => "查無資料" ,"value" => 0);
	}else{

		//將資料每筆拉出比對
		foreach($rows as $i){
			switch ($type) {
				case 'app_sup':
					//將關鍵字移除後面數量
					$t = substr($i['app_sup'] ,0 ,-4);
					$label[$t] += 1;
					break;

				default:
					//比對後將該陣列+1
  				$label[$i[$type]] += 1;
					break;
			}


		}

		//製作JSON格式陣列
		foreach ($label as $key => $value) {
 			$date[$num] = array (
 				"label" => $key,
 				"value" => $value
 			);
			$num += 1;
		}
	}

	echo json_encode($date); //php 5.2 000webhost

?>
