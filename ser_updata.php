<?php
//判斷權限及輸入使用者資料
include("include/Cheak_user_pur.php");

//非最高權限則強制轉出
if ($user_pur != "1") {mysql_close($db);header("location:index.html");}

$er ="";
$id = $_GET["id"]; // 取得編號

$sql1 = "SELECT * FROM service WHERE id='" . $id . "'";
$rows = mysql_query($sql1); // 執行SQL查詢
$row = mysql_fetch_row($rows); // 取出第1筆

//按鈕送出
if (isset($_POST["send"])) {
    $app_date = $_POST["app_date"];$name = $_POST["name"];
    $work_id = $_POST["work_id"];$dep = $_POST["dep"];
    $err_cat = $_POST["err_cat"];$err_name = $_POST["err_name"];
    $location = $_POST["location"];$err_con = $_POST["err_con"];
    $repair_details = $_POST["repair_details"];$ser_sta = $_POST["ser_sta"];

//資料庫敘述指令-更新語法
$sql2 = "UPDATE service SET app_date='$app_date',name='$name',work_id='$work_id'," .
        "dep='$dep',err_cat='$err_cat',err_name='$err_name',location='$location'," .
        "err_con='$err_con',repair_details='$repair_details',ser_sta='$ser_sta' WHERE id='" . $id . "'";
if (!mysql_query($sql2)){ // 執行SQL指令
    $er = "<div style='color: #f00' >更新資料失敗!!!<br.>錯誤代碼為:".mysql_error()." and ".mysql_errno()."</div>";
}else header("Location: ser_ad.php"); // 轉址
}

mysql_close($db); // 關閉資料庫連接

if( is_file('thumb/'.$id.'.jpg') ){
    $img_str = "顯示照片";
    $img_src = $id;
}else{
    $img_str = "暫無照片";
    $img_src = "noimg";
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
	<a href="ser_ad.php" target="_self" data-icon="back">返回</a>
	<H1>修改報修內容</H1>
</div>
<div data-role="content" >
<?php echo $er;?>
<a href="#popupPhotoLandscape" data-rel="popup" data-position-to="window" class="ui-btn ui-corner-all ui-shadow"><?php echo $img_str;?></a>
<div data-role="popup" id="popupPhotoLandscape" class="photopopup" data-overlay-theme="a" data-corners="false" data-tolerance="30,15">
<a href="#" data-rel="back" class="ui-btn ui-corner-all ui-shadow ui-btn-a ui-icon-delete ui-btn-icon-notext ui-btn-right">Close</a><img src="thumb/<?php echo $img_src; ?>.jpg" alt="故障照片">
</div>
<form action="" method="post" data-ajax="false">
<table data-role="table" id="table1" data-mode="columntoggle" data-filter="true" data-input="#filterTable-input"  class="ui-body-d ui-shadow table-stripe ui-responsive" data-column-btn-theme="b" data-column-btn-text="顯示項次選擇" data-column-popup-theme="a">
<thead>
    <tr style="font-size: small;">
	<th style="text-align: center;" data-priority="persist">編號</th>
    <th style="text-align: center;" data-priority="1">申請日期</th>
	<th style="text-align: center;" data-priority="persist">領用人</th>
	<th style="text-align: center;" data-priority="3">工號</th>
    <th style="text-align: center;" data-priority="3">部門</th>
    <th style="text-align: center;" data-priority="persist">設備種類</th>
	</tr>
</thead>
<tbody>
    <tr style="font-size: small;">
	<th style="text-align: center;vertical-align: middle;"><?php echo $row[0] ?></th>
	<th><input type="date" name="app_date" id="app_date" value="<?php echo $row[1] ?>"></th>
	<th><input type="text" name="name" id="name" value="<?php echo $row[3] ?>"></th>
	<th><input type="text" name="work_id" id="work_id" value="<?php echo $row[2] ?>"></th>
	<th><input type="text" name="dep" id="dep" value="<?php echo $row[4] ?>"></th>
    <th>
    <select name="err_cat" id="err_cat" data-native-menu="false" required>
       <?php

       switch($row[5]) {
          case '':
            echo "<option value=''>選擇種類</option>";
            echo "<option value='生活設備'>生活設備</option>";
            echo "<option value='空調設備'>空調設備</option>";
            echo "<option value='消防設備'>消防設備</option>";
            break;
          case '生活設備':
            echo "<option value='生活設備'>生活設備</option>";
            echo "<option value='空調設備'>空調設備</option>";
            echo "<option value='消防設備'>消防設備</option>";
            break;
          case '空調設備':
            echo "<option value='空調設備'>空調設備</option>";
            echo "<option value='生活設備'>生活設備</option>";
            echo "<option value='消防設備'>消防設備</option>";
            break;
          case '消防設備':
            echo "<option value='生活設備'>生活設備</option>";
            echo "<option value='消防設備'>消防設備</option>";
            echo "<option value='空調設備'>空調設備</option>";
            break;
       }
       ?>
    </select></th>
    </tr>
</tbody>
</table>
<table data-role="table" id="table2" data-mode="columntoggle" data-filter="true" data-input="#filterTable-input"  class="ui-body-d ui-shadow table-stripe ui-responsive" data-column-btn-theme="b" data-column-btn-text="顯示項次選擇" data-column-popup-theme="a">
<thead>
    <tr style="font-size: small;">
    <th style="text-align: center;" data-priority="persist">設備名稱</th>
    <th style="text-align: center;" data-priority="3">地點</th>
    <th style="text-align: center;" data-priority="persist">故障概況</th>
    <th style="text-align: center;" data-priority="persist">修復細節</th>
    <th style="text-align: center;" data-priority="persist">維修情況</th>
    </tr>
</thead>
<tbody>
    <tr style="font-size: small;">

    <th><input type="text" name="err_name" id="err_name" value="<?php echo $row[6] ?>"></th>
    <th><input type="text" name="location" id="location" value="<?php echo $row[7] ?>"></th>
    <th><input type="text" name="err_con" id="err_con" value="<?php echo $row[8] ?>"></th>
    <th><input type="text" name="repair_details" id="repair_details" value="<?php echo $row[10] ?>"></th>
    <th><select name="ser_sta" id="ser_sta" data-native-menu="false">
        <?php
        switch($row[9]) {
            case '待修中':
                echo "<option value='".$row[9]."'>".$row[9]."</option>";
                echo "<option value='已修復'>已修復</option>";
                break;
            case '已修復':
                echo "<option value='".$row[9]."'>".$row[9]."</option>";
                echo "<option value='待修中'>待修中</option>";
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