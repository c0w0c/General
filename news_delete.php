<?php
//判斷權限及輸入使用者資料
include("include/Cheak_user_pur.php");

//非最高權限則強制轉出
if ($user_pur != "1") {mysql_close($db);header("location:index.html");}

$er ="";
$id = $_GET["id"]; // 取得編號

if (isset($_POST["del"])) {  // 是否是表單送回
   $sql = "DELETE FROM news WHERE id='" . $id . "'";
   if (!mysql_query($sql)) // 執行SQL指令
        $er = "刪除記錄失敗...<br/>" . mysql_error();
   else header("Location: news_ad.php"); // 轉址
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

<div data-role="page">

<div data-role="content" style="width: 75%;margin: 0px auto;" >
    <?php echo $er;?>
    <form action="" method="post" data-ajax="false">
        <ul data-role="listview" data-inset="true">
            <li data-role="list-divider" style="text-align: center;font-size:large;">刪除第 <?php echo $id ?> 筆資料</li>
            <li class="ui-field-contain">
                <p style="font-size: large;">您確定要刪除資料!?</p>
                <p style="font-size: medium;">資料刪除後將不能復原!!</p>
            </li>
            <li class="ui-field-contain">
            <div class="ui-grid-a">
		    <div class="ui-block-a">
			<input type="submit" value="刪除" name="del"  data-icon="delete"/>
		    </div>
		    <div class="ui-block-b">
        	<input type="button" value="取消" data-icon="back" onclick="javascript:history.back(-1)">
            </div>
		    </div>
            </li>
        </ul>
    </form>
</div></div>
</body>
</html>
