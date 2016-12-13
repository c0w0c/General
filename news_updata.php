<?php
//判斷權限及輸入使用者資料
include("include/Cheak_user_pur.php");

//非最高權限則強制轉出
if ($user_pur != "1") {mysql_close($db);header("location:index.html");}

$er = "";
$id = $_GET["id"]; // 取得編號

$sql1 = "SELECT * FROM news WHERE id='" . $id . "'";
$rows = mysql_query($sql1); // 執行SQL查詢
$row = mysql_fetch_row($rows); // 取出第1筆

//按鈕送出
if (isset($_POST["send"])) {
    $date = $_POST["date"];
    $title = $_POST["title"];
    $con =$_POST["con"];
    $sup =$_POST["sup"];

//資料庫敘述指令-更新語法
$sql2 = "UPDATE news SET date='$date',title='$title',con='$con'," .
"sup='$sup' WHERE id='" . $id . "'";
if (!mysql_query($sql2)){ // 執行SQL指令
    $er = "<div style='color: #f00' >更新資料失敗!!!<br.>錯誤代碼為:".mysql_error()." and ".mysql_errno()."</div>";
}else header("Location: news_ad.php"); // 轉址
}
mysql_close($db); // 關閉資料庫連接
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
<div data-role="header" class="hea">
	<a href="news_ad.php" target="_self" data-icon="back">返回</a>
	<H1>修改公告內容</H1>
</div>
<div data-role="content" >
    <?php echo $er;?>
    <form action="" method="post" data-ajax="false">
        <ul data-role="listview" data-inset="true">
            <li data-role="list-divider" style="text-align: center;font-size:large;">資料ID : <?php echo $id ?></li>
            <li class="ui-field-contain">
            <label for="date">日 期 :</label>
            <input type="date" name="date" id="date" value="<?php echo $row[1] ?>">
            </li>
            <li class="ui-field-contain">
            <label for="title">標 題 :</label>
            <input type="text" name="title" id="title" value="<?php echo $row[2] ?>" data-clear-btn="true">
            </li>
            <li class="ui-field-contain">
            <label for="con">內 容 :</label>
            <textarea cols="40" rows="8" name="con" id="con"><?php echo $row[3] ?></textarea>
            </li>
            <li class="ui-field-contain">
            <label for="sup">作 者 :</label>
            <input type="text" name="sup" id="sup" value="<?php echo $row[4] ?>" data-clear-btn="true">
            </li>
            <li class="ui-field-contain">
            <div class="ui-grid-a">
		    <div class="ui-block-a">
			<input type="submit" value="修改送出" name="send"  data-icon="check"/>
		    </div>
		    <div class="ui-block-b">
        	<input type="reset" value="重新輸入" name="del"  data-icon="delete"/>
            </div>
		    </div>
            </li>
        </ul>
    </form>

</div>
	<div  data-role="footer" class="foot">
		<p class="foot_p">Copyright © 2016 科技股份有限公司</p>
	</div>
</div>
</body>
</html>
