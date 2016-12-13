<?php
//判斷權限及輸入使用者資料
include("include/Cheak_user_pur.php");

//非最高權限則強制轉出
if ($user_pur != "1") {mysql_close($db);header("location:index.html");}

$er = "";

$id = $_GET["id"]; // 取得編號

$sql1 = "SELECT * FROM emp WHERE work_id='" . $id . "'";
$rows = mysql_query($sql1); // 執行SQL查詢
$row = mysql_fetch_row($rows); // 取出第1筆

//按下送出鈕後取得表單資料
if (isset($_POST["send"])){
    $name = $_POST["name"];
    $password = md5($_POST["password"]);
    $dep = $_POST["dep"];
    $pur = $_POST["pur"];

    //資料庫敘述指令-更新語法
    $sql2 = "UPDATE emp SET name='$name',password='$password',dep='$dep'," .
    "pur='$pur' WHERE work_id='" . $id . "'";
    //執行指令
    if (!mysql_query($sql2)){
        $er = "<div style='color: #f00' >更新資料失敗!!!錯誤代碼為:".mysql_error()." and ".mysql_errno()."</div>";
    }else{
        header("Location: user_ad.php");
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
    <a href="user_ad.php" target="_self"  data-icon="back">返回</a>
    <H1>修改帳號資料</H1>
</div>
<div data-role="content" >
    <?php echo $er;?>
    <form action="" method="post" data-ajax="false">
        <ul data-role="listview" data-inset="true">
            <li data-role="list-divider" style="text-align: center;font-size:large;">工號ID : <?php echo $row[0] ?></li>
            </li>
            <li class="ui-field-contain">
            <label for="name">姓 名 :</label>
            <input type="text" name="name" id="name" data-clear-btn="true" required value="<?php echo $row[1] ?>">
            </li>
            <li class="ui-field-contain">
            <label for="password">密 碼 :</label>
            <input type="text" name="password" id="password" data-clear-btn="true" required value="<?php echo $row[2] ?>">
            <li class="ui-field-contain">
            <label for="dep">部 門 :</label>
            <input type="text" name="dep" id="dep" data-clear-btn="true" required value="<?php echo $row[3] ?>">
            </li>
            <li class="ui-field-contain">
            <label for="pur">權 限 :</label>
            <input type="text" name="pur" id="pur" data-clear-btn="true" required value="<?php echo $row[4] ?>">
            </li>
            <li class="ui-field-contain">
            <div class="ui-grid-a">
            <div class="ui-block-a">
            <input type="submit" id="submit" value="送出" name="send"  data-icon="check"/>
            </div>
            <div class="ui-block-b">
            <input type="reset" value="取消變更" name="del"  data-icon="delete"/>
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
