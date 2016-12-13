<?php
//判斷權限及輸入使用者資料
include("include/Cheak_user_pur.php");

//非最高權限則強制轉出
if ($user_pur != "1") {mysql_close($db);header("location:index.html");}

$er ="";
$id = $_GET["id"]; // 取得編號

$sql1 = "SELECT * FROM sup_app WHERE id='" . $id . "'";
$rows = mysql_query($sql1); // 執行SQL查詢
$row = mysql_fetch_row($rows); // 取出第1筆

//按鈕送出
if (isset($_POST["send"])) {
    $app_date = $_POST["app_date"];$name = $_POST["name"];
    $work_id = $_POST["work_id"];$dep = $_POST["dep"];
    $app_sup = $_POST["app_sup"];$remark = $_POST["remark"];
    $Status = $_POST["Status"];

//資料庫敘述指令-更新語法
$sql2 = "UPDATE sup_app SET app_date='$app_date',name='$name',work_id='$work_id'," .
        "dep='$dep',app_sup='$app_sup'," .
        "remark='$remark',Status='$Status' WHERE id='" . $id . "'";
if (!mysql_query($sql2)){ // 執行SQL指令
    $er = "<div style='color: #f00' >更新資料失敗!!!<br.>錯誤代碼為:".mysql_error()." and ".mysql_errno()."</div>";
}else header("Location: sup_ad.php"); // 轉址
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
	<a href="sup_ad.php" target="_self" data-icon="back">返回</a>
	<h1>修改用品申請內容</h1>
</div>
<div data-role="content" >
<?php echo $er;?>
<form action="" method="post" data-ajax="false">
<table data-role="table" id="table1" data-mode="columntoggle" data-filter="true" data-input="#filterTable-input"  class="ui-body-d ui-shadow table-stripe ui-responsive" data-column-btn-theme="b" data-column-btn-text="顯示項次選擇" data-column-popup-theme="a">
<thead>
    <tr style="font-size: small;">
	<th style="text-align: center;" data-priority="persist">編號</th>
    <th style="text-align: center;" data-priority="1">申請日期</th>
	<th style="text-align: center;" data-priority="persist">領用人</th>
	<th style="text-align: center;" data-priority="3">工號</th>
	</tr>
</thead>
<tbody>
    <tr style="font-size: small;">
	<th style="text-align: center;vertical-align: middle;"><?php echo $row[0] ?></th>
	<th><input type="date" name="app_date" id="app_date" value="<?php echo $row[1] ?>"></th>
	<th><input type="text" name="name" id="name" value="<?php echo $row[3] ?>"></th>
	<th><input type="text" name="work_id" id="work_id" value="<?php echo $row[2] ?>"></th>
	</tr>
</tbody>
</table>
<table data-role="table" id="table2" data-mode="columntoggle" data-filter="true" data-input="#filterTable-input"  class="ui-body-d ui-shadow table-stripe ui-responsive" data-column-btn-theme="b" data-column-btn-text="顯示項次選擇" data-column-popup-theme="a">
<thead>
    <tr style="font-size: small;">
	<th style="text-align: center;" data-priority="3">部門</th>
    <th style="text-align: center;" data-priority="persist">領用物品</th>
    <th style="text-align: center;" data-priority="3">備註</th>
    <th style="text-align: center;" data-priority="persist">發送狀態</th>
	</tr>
</thead>
<tbody>
    <tr style="font-size: small;">
	<th><input type="text" name="dep" id="dep" value="<?php echo $row[4] ?>"></th>
    <th><input type="text" name="app_sup" id="app_sup" value="<?php echo $row[5] ?>"></th>
    <th><input type="text" name="remark" id="remark" value="<?php echo $row[6] ?>"></th>
    <th><select name="Status" id="Status" data-native-menu="false">
        <?php
        switch($row[7]) {
            case '尚未讀取':
                echo "<option value='".$row[7]."'>".$row[7]."</option>";
                echo "<option value='準備中'>準備中</option>";
                echo "<option value='已發送'>已發送</option>";
                break;
            case '準備中':
                echo "<option value='".$row[7]."'>".$row[7]."</option>";
                echo "<option value='尚未讀取'>尚未讀取</option>";
                echo "<option value='已發送'>已發送</option>";
                break;
            case '已發送':
                echo "<option value='".$row[7]."'>".$row[7]."</option>";
                echo "<option value='尚未讀取'>尚未讀取</option>";
                echo "<option value='準備中'>準備中</option>";
                break;
         }
        ?>
         </select></th>
	</tr>
</tbody>
</table>
<div class="ui-grid-a">
<div class="ui-block-a">
    <input type="reset" value="重新輸入" name="del"  data-icon="delete"/>
</div>
<div class="ui-block-b">
    <input type="submit" value="修改送出" name="send"  data-icon="check"/>
</div>
</div>
</form>
</div><!--con end-->
<div data-role="footer" class="foot">
	<p class="foot_p">Copyright © 2016 科技股份有限公司</p>
</div>
</div><!--page end-->

</body>
</html>
