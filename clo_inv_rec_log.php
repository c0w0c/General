<?php
header("Content-Type:text/html; charset=utf-8");

//判斷權限及輸入使用者資料
include("include/Cheak_user_pur.php");

//非最高權限則強制轉出
if ($user_pur != "1") {mysql_close($db);header("location:index.html");}

include("include/Ch_type.php"); // 載入轉換形式

//開啟 PDO 設定連結 MySQL 資料庫
include 'include/PDO.php';

//查詢SQL語法
$sql = 'SELECT * FROM clo_inv_rec ORDER BY id DESC';

//執行查詢
$reslut = $pdo -> query($sql);

$data = $reslut->fetchAll();

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no " />
    <!-- 主要CSS -->
    <link rel="stylesheet" href="css/body.css" />
    <!-- jquery mobile CSS -->
    <link rel="stylesheet" href="css/jquery.mobile-1.4.5.min.css" />
    <!-- 網站ICON -->
    <link rel="shortcut icon" href="img/logo.png">
    <!-- jquery js -->
    <script src="js/jquery-1.12.3.min.js"></script>
    <!-- jquery mobile js -->
    <script src="js/jquery.mobile-1.4.5.min.js"></script>
</head>
<body>
<div data-role="page" id="">
<div data-role="header" class="hea" data-position="fixed">
	<a href="clo_ad.php" target="_self" data-icon="back">返回</a>
	<H1>扣補帳紀錄</H1>
</div>
<div data-role="content" >
    <?php
        foreach ($data as $id => $arr) {
            echo '<div style=" clear:right;" data-role="collapsible"  data-collapsed-icon="carat-d" data-expanded-icon="carat-u" data-corners="false">';
            echo "<h1>".$arr['id'].'. '.$arr['date'].'　'.$arr['type']."</h1>";

            $json_data = json_decode($arr['con']) ;
            foreach ($json_data as $en_type => $val) {
                $ch_type = Ch_type($en_type);
                echo $ch_type . " " . $val ."件 ,";
            }
            echo '</div>';
        }
    ?>
</div><!--con end-->
<div data-role="footer" class="foot" data-position="fixed">
	<p class="foot_p">Copyright © 2016 科技股份有限公司</p>
</div>
</div><!--page end-->
</body>
</html>
