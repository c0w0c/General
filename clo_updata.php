<?php
//判斷權限及輸入使用者資料
include("include/Cheak_user_pur.php");

//非最高權限則強制轉出
if ($user_pur != "1") {mysql_close($db);header("location:index.html");}

$id = $_GET["id"]; // 取得編號
include("include/Ch_type.php"); // 載入轉換形式

$sql1 = "SELECT * FROM clo_app WHERE id='" . $id . "'";
$rows = mysql_query($sql1); // 執行SQL查詢
$row = mysql_fetch_row($rows); // 取出第1筆

$re_Status = mysql_result($rows, 0 , "Status"); //取得原始狀態
$recorded = mysql_result($rows, 0 , "recorded");//取得原始寫入狀態

//按鈕送出
if (isset($_POST["send_one"]) || isset($_POST["send_next"]) ) {
    $app_date = $_POST["app_date"];$name = $_POST["name"];
    $work_id = $_POST["work_id"];$dep = $_POST["dep"];
    $app_rea = $_POST["app_rea"];$app_clo = $_POST["app_clo"];
    $app_name = $_POST["app_name"];$remark = $_POST["remark"];
    $Status = $_POST["Status"];

//當登錄狀態為未登錄(0),發送狀態又更改為發送時即寫入扣帳紀錄
if ($recorded == 0 && $Status =="已發送"){

    //寫入扣帳紀錄 開始
    $sql_rd1 = "SELECT MAX(id) FROM clo_inv_log";
    $arr = mysql_query($sql_rd1);
    $inv_id = end(mysql_fetch_row($arr));
    $inv_id = $inv_id + 1 ;
    $inv_date = date("Y-m-d");//登錄日期
    $con_sub = substr($app_clo,0,-5); //去除申請內容字串最後的</br>
    $con = str_replace ("</br>",",",$con_sub);//將$con_sub變數裡的</br>取代為,號
    $sql_re = "INSERT INTO clo_inv_log (id,date,name,con,rea,sta) ".
    "VALUES ('$inv_id','$inv_date','$name','$con','$app_rea','扣帳')";
    mysql_query($sql_re);
    $recorded = 1;
    //寫入扣帳紀錄 結束

    //修改庫存數量(扣件) 開始
    $con = str_replace ("</br>","*",$con_sub);//將$con_sub變數裡的</br>取代為*號
    $arr = explode("*",$con); //將字串寫入陣列
    for ( $i=0; $i < count($arr) ;$i+=2){
        $type = Ch_type($arr[$i]); //申請衣物形式
        $a_num = (int)$arr[$i+1]; //申請數量
        $sql_rd2 = "SELECT amount FROM clo_inv WHERE type = '".$type."'";
        $rows2 = mysql_query($sql_rd2);
        $inv_num = mysql_result($rows2 , 0, "amount");
        mysql_query("UPDATE clo_inv SET amount = '".($inv_num - $a_num).
        "' WHERE type = '".$type."'"); //執行修改庫存紀錄語法 扣件

    }
    //修改庫存數量(扣件) 結束
}
//當登錄狀態為已登錄(1),發送狀態又更改為非發送時即寫入除帳紀錄
if ($recorded == 1 && $Status !=="已發送"){

    //寫入剃除帳紀錄 開始
    $sql_rd1 = "SELECT MAX(id) FROM clo_inv_log";
    $arr = mysql_query($sql_rd1);
    $inv_id = end(mysql_fetch_row($arr));
    $inv_id = $inv_id + 1 ;
    $inv_date = date("Y-m-d");//登錄日期
    $con_sub = substr($app_clo,0,-5); //去除申請內容字串最後的</br>
    $con = str_replace ("</br>",",",$con_sub);//將$con_sub變數裡的</br>取代為,號
    $sql_re = "INSERT INTO clo_inv_log (id,date,name,con,rea,sta) ".
    "VALUES ('$inv_id','$inv_date','$name','$con','$app_rea','除帳')";
    mysql_query($sql_re);
    $recorded = 0;
    //寫入剃除帳紀錄 結束

    //修改庫存數量(增帳) 開始
    $con = str_replace ("</br>","*",$con_sub);//將$con_sub變數裡的</br>取代為*號
    $arr = explode("*",$con); //將字串寫入陣列
    for ( $i=0; $i < count($arr) ;$i+=2){
        $type = Ch_type($arr[$i]); //申請衣物形式
        $a_num = (int)$arr[$i+1]; //申請數量
        $sql_rd2 = "SELECT amount FROM clo_inv WHERE type = '".$type."'";
        $rows2 = mysql_query($sql_rd2);
        $inv_num = mysql_result($rows2 , 0, "amount");
        mysql_query("UPDATE clo_inv SET amount = '".($inv_num + $a_num).
        "' WHERE type = '".$type."'"); //執行修改庫存紀錄語法 加一件

    }
    //修改庫存數量(增帳) 結束
}

//資料庫敘述指令-更新語法
$sql2 = "UPDATE clo_app SET app_date='$app_date',name='$name',work_id='$work_id'," .
        "dep='$dep',app_rea='$app_rea',app_clo='$app_clo',app_name='$app_name',".
        "remark='$remark',Status='$Status',recorded='$recorded' WHERE id='" . $id . "'";
if (!mysql_query($sql2)){ // 執行SQL指令
    $er = "<div style='color: #f00' >更新資料失敗!!!<br.>錯誤代碼為:".mysql_error()." and ".mysql_errno()."</div>";
}elseif ( mysql_query($sql2) && isset($_POST["send_one"])) {
    header("Location: clo_ad.php"); // 修改後進入管理頁面
}elseif ( mysql_query($sql2) && isset($_POST["send_next"])) {
    header("Location: clo_ad_key_search.php?key=list"); // 修改後進入清單頁面
}}
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
	<a href="clo_ad.php" target="_self" data-icon="back">返回</a>
	<H1>修改衣物申請內容</H1>
</div>
<div data-role="content" >
<?php echo $er;?>
<form action="" method="post" data-ajax="false">
<table data-role="table" id="table1" data-mode="columntoggle" data-filter="true" data-input="#filterTable-input"  class="ui-body-d ui-shadow table-stripe ui-responsive" data-column-btn-theme="b" data-column-btn-text="顯示項次選擇" data-column-popup-theme="a">
<thead>
    <tr style="font-size: small;">
	<th style="text-align: center;" data-priority ="persist">編號</th>
	<th style="text-align: center;" data-priority="2">申請日期</th>
	<th style="text-align: center;" data-priority="persist">領用人</th>
    <th style="text-align: center;" data-priority="persist">工號</th>
	<th style="text-align: center;" data-priority="1">部門</th>
	</tr>
</thead>
<tbody>
    <tr style="font-size: small;">
	<th style="text-align: center;vertical-align: middle;"><?php echo $row[0] ?></th>
	<th><input type="date" name="app_date" id="app_date" value="<?php echo $row[1] ?>"></th>
	<th><input type="text" name="name" id="name" value="<?php echo $row[3] ?>"></th>
	<th><input type="text" name="work_id" id="work_id" value="<?php echo $row[2] ?>"></th>
    <th><input type="text" name="dep" id="dep" value="<?php echo $row[4] ?>"></th>
	</tr>
</tbody>
</table>
<table data-role="table" id="table2" data-mode="columntoggle" data-filter="true" data-input="#filterTable-input"  class="ui-body-d ui-shadow table-stripe ui-responsive" data-column-btn-theme="b" data-column-btn-text="顯示項次選擇" data-column-popup-theme="a">
<thead>
    <tr style="font-size: small;">
	<th style="text-align: center;" data-priority="3">領用原因</th>
    <th style="text-align: center;" data-priority="persist">領用物品</th>
    <th style="text-align: center;" data-priority="persist">填表人</th>
    <th style="text-align: center;" data-priority="4">備註</th>
    <th style="text-align: center;" data-priority="persist">發送狀態</th>
	</tr>
</thead>
<tbody>
    <tr style="font-size: small;">
	<th><input type="text" name="app_rea" id="app_rea" value="<?php echo $row[5] ?>"></th>
    <th><input type="text" name="app_clo" id="app_clo" value="<?php echo $row[7] ?>"></th>
    <th><input type="text" name="app_name" id="app_name" value="<?php echo $row[6] ?>"></th>
    <th><input type="text" name="remark" id="remark" value="<?php echo $row[8] ?>"></th>
    <th><select name="Status" id="Status" data-native-menu="false">
        <?php
        switch($row[9]) {
            case '尚未讀取':
                echo "<option value='".$row[9]."'>".$row[9]."</option>";
                echo "<option value='準備中'>準備中</option>";
                echo "<option value='已發送'>已發送</option>";
                break;
            case '準備中':
                echo "<option value='".$row[9]."'>".$row[9]."</option>";
                echo "<option value='尚未讀取'>尚未讀取</option>";
                echo "<option value='已發送'>已發送</option>";
                break;
            case '已發送':
                echo "<option value='".$row[9]."'>".$row[9]."</option>";
                echo "<option value='尚未讀取'>尚未讀取</option>";
                echo "<option value='準備中'>準備中</option>";
                break;
         }
        ?>
         </select></th>
	</tr>
</tbody>
</table>
<div class="ui-grid-solo">
<div class="ui-block-a">
    <input type="submit" value="多筆修改" name="send_next"  data-icon="check"/>
</div>
</div>
<div class="ui-grid-a">
<div class="ui-block-a">
    <input type="reset" value="重新輸入" name="del"  data-icon="delete"/>
</div>
<div class="ui-block-b">
    <input type="submit" value="單筆修改" name="send_one"  data-icon="check"/>
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
