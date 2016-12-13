<?php
//判斷權限及輸入使用者資料
include("include/Cheak_user_pur.php");

//非最高權限則強制轉出
if ($user_pur != "1") {mysql_close($db);header("location:index.html");}

$er = "";
    //按下送出鈕後取得表單資料
if (isset($_POST["send"])){
    $date = $_POST["date"];
    $title = $_POST["title"];
    $con =$_POST["con"];
    $sup =$_POST["sup"];

    //資料庫敘述指令-查詢語法
    $sql1 = "SELECT MAX(id) FROM news";
    $arr = mysql_query($sql1);
    $id = end(mysql_fetch_row($arr));
    $id = $id + 1 ;
    //資料庫敘述指令-新增語法
    $sql2 = "INSERT INTO news"."(id,date,title,con,sup) ".
    "VALUES ('$id','$date','$title','$con','$sup')";
    //執行指令
    if (!mysql_query($sql2)){
        $er = "<div style='color: #f00' >新增資料失敗!!!錯誤代碼為:".mysql_error()." and ".mysql_errno()."</div>";
    }else{
        header("Location: news_ad.php");
    }
    mysql_close($db);//關閉資料庫

}
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
<div data-role="header" class="hea">
	<a href="news_ad.php" target="_self"  data-icon="back">返回</a>
	<H1>新增公告</H1>
</div>
<div data-role="content" >
    <?php echo $er;?>
    <form action="" method="post" data-ajax="false">
        <ul data-role="listview" data-inset="true">
            <li class="ui-field-contain">
            <label for="date">日 期 :</label>
            <input type="date" name="date" id="date" value="<?php echo date("Y-m-d");?>" required>
            </li>
            <li class="ui-field-contain">
            <label for="title">標 題 :</label>
            <input type="text" name="title" id="title" data-clear-btn="true" required>
            </li>
            <li class="ui-field-contain">
            <label for="con">內 容 :</label>
            <textarea cols="40" rows="8" name="con" id="con" required></textarea>
            </li>
            <li class="ui-field-contain">
            <label for="sup">作 者 :</label>
            <input type="text" name="sup" id="sup" data-clear-btn="true">
            </li>
            <li class="ui-field-contain">
            <div class="ui-grid-a">
		    <div class="ui-block-a">
			<input type="submit" value="送出" name="send"  data-icon="check"/>
		    </div>
		    <div class="ui-block-b">
        	<input type="reset" value="取消返回" name="del"  data-icon="delete"/>
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
