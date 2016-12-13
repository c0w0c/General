<?php
header("Content-Type:text/html; charset=utf-8");

//判斷權限及輸入使用者資料
include("include/Cheak_user_pur.php");

//非最高權限則強制轉出
if ($user_pur != "1") {mysql_close($db);header("location:index.html");}

//開啟 PDO 設定連結 MySQL 資料庫
include 'include/PDO.php';

//查詢SQL語法
$sql = 'SELECT * FROM clo_inv';

//執行查詢
$reslut = $pdo -> query($sql);

$data = $reslut->fetchAll();

//表單資料送出處理
if (isset($_POST['send'])) {

    //將變更數量的JSON寫入clo_inv_rec資料表裡
    $insert_type = $_POST["rec_type"];
    $insert_con = $_POST["data"]; //申請的內容
    $insert_date = date("Y-m-d");//申請日期

    //搜尋最後一筆資料的ID
    $ser_id_sql = "SELECT MAX(id) FROM clo_inv_rec";
    $reslut = $pdo -> query($ser_id_sql);
    $ser_id = $reslut->fetchAll();
    $id = $ser_id[0]['MAX(id)'] + 1 ;

    $insert_sql = "INSERT INTO clo_inv_rec"."(id,date,type,con) "."VALUES ('$id','$insert_date','$insert_type','$insert_con')";
    $pdo -> exec($insert_sql);

    //搜尋clo_inv的欄位進行扣補作業
    $json_data = json_decode(stripslashes($_POST["data"])) ;

    foreach ($json_data as $type => $str) {

        $ser_inv_sql =  "SELECT * FROM clo_inv WHERE type = '". $type . "'" ;
        $inv_reslut = $pdo -> query($ser_inv_sql);
        $ser_inv = $inv_reslut->fetchAll();

        $sign = substr($str,0,1);
        $val = substr($str,1);

        switch ($sign) {
            case '+':
                $up_amount = $ser_inv[0]['amount'] + $val;
                break;
            case '-':
                $up_amount = $ser_inv[0]['amount'] - $val;
                break;
        }

        $up_inv_sql = "UPDATE clo_inv SET amount='$up_amount' WHERE type='" . $type . "'";
        $pdo -> exec($up_inv_sql);
    }
    header("Location: clo_ad.php");//返回衣物管理頁面
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
    <style>
        .movie-list{
            margin-top:-25px;
        }
        .movie-list thead th,
        .movie-list tbody tr:last-child {
            border-bottom: 1px solid #d6d6d6; /* non-RGBA fallback */
            border-bottom: 1px solid rgba(0,0,0,.1);
            font-size: 14px;
        }
        .movie-list tbody th,
        .movie-list tbody td {
            border-bottom: 1px solid #e6e6e6; /* non-RGBA fallback  */
            border-bottom: 1px solid rgba(0,0,0,.05);
            font-size: 14px;
        }
        .movie-list tbody tr:last-child th,
        .movie-list tbody tr:last-child td {
            border-bottom: 0;
        }
        .movie-list tbody tr:nth-child(odd) td,
        .movie-list tbody tr:nth-child(odd) th {
            background-color: #eeeeee; /* non-RGBA fallback  */
            background-color: rgba(0,0,0,.04);
        }
    </style>
</head>
<body>
<div data-role="page" id="">
<div data-role="header" class="hea">
	<a href="clo_ad.php" target="_self" data-icon="back">返回</a>
	<H1>衣物扣補帳系統</H1>
</div>
<div data-role="content" >
<form action="clo_inv_rec.php" method="post" data-ajax="false">
<div class="ui-grid-a">
    <div class="ui-block-a">
        <select id="rec_type" name="rec_type">
            <option value="盤點">盤點</option>
            <option value="補貨">補貨</option>
        </select>
    </div>
    <div class="ui-block-b">
        <button class="ui-btn ui-corner-all ui-shadow ui-btn-icon-right ui-icon-arrow-r" name="send" onclick="inputdata_cheak();">送出</button>
    </div>
    <input type="hidden" id="data" name="data" value="">
</div>
</form>
<table data-role="table" id="movie-table-custom" data-mode="reflow" class="movie-list ui-responsive">
  <thead>
    <tr>
      <th data-priority="1">短袖S</th>
      <th data-priority="2">短袖M</th>
      <th data-priority="3">短袖L</th>
      <th data-priority="4">短袖XL/2L</th>
      <th data-priority="4">短袖2XL/3L</th>
      <th data-priority="4">短袖3XL/4L</th>
      <th data-priority="4">短袖4XL/5L</th>
      <th data-priority="4">短袖5XL/6L</th>
    </tr>
  </thead>
  <tbody>
    <tr>
        <?php
            for ($i = 0; $i < 8 ; $i++) {
                print_r('<td><input type="text" id="'.$i.'" name="'.$data[$i]['type'].'" value="" placeholder="'.$data[$i]['amount'].'"></td>');
            }
        ?>
    </tr>
  </tbody>
</table>
<table data-role="table" id="movie-table-custom" data-mode="reflow" class="movie-list ui-responsive">
  <thead>
    <tr>
      <th data-priority="1">長袖S</th>
      <th data-priority="2">長袖M</th>
      <th data-priority="3">長袖L</th>
      <th data-priority="4">長袖XL/2L</th>
      <th data-priority="4">長袖2XL/3L</th>
      <th data-priority="4">長袖3XL/4L</th>
      <th data-priority="4">長袖4XL/5L</th>
      <th data-priority="4">長袖5XL/6L</th>
    </tr>
  </thead>
  <tbody>
    <tr>
        <?php
            for ($i = 8; $i < 16 ; $i++) {
                print_r('<td><input type="text" id="'.$i.'" name="'.$data[$i]['type'].'" value="" placeholder="'.$data[$i]['amount'].'"></td>');
            }
        ?>
    </tr>
  </tbody>
</table>
<table data-role="table" id="movie-table-custom" data-mode="reflow" class="movie-list ui-responsive">
  <thead>
    <tr>
      <th data-priority="1">37鞋</th>
      <th data-priority="2">38鞋</th>
      <th data-priority="3">39鞋</th>
      <th data-priority="4">40鞋</th>
      <th data-priority="4">41鞋</th>
      <th data-priority="4">42鞋</th>
      <th data-priority="4">43鞋</th>
    </tr>
  </thead>
  <tbody>
    <tr>
        <?php
            for ($i = 16; $i < 23 ; $i++) {
                print_r('<td><input type="text" id="'.$i.'" name="'.$data[$i]['type'].'" value="" placeholder="'.$data[$i]['amount'].'"></td>');
            }
        ?>
    </tr>
  </tbody>
<table data-role="table" id="movie-table-custom" data-mode="reflow" class="movie-list ui-responsive">
  <thead>
    <tr>
      <th data-priority="1">男帽</th>
      <th data-priority="2">女帽</th>
    </tr>
  </thead>
  <tbody>
    <tr>
        <?php
            for ($i = 23; $i < 25 ; $i++) {
                print_r('<td><input type="text" id="'.$i.'" name="'.$data[$i]['type'].'" value="" placeholder="'.$data[$i]['amount'].'"></td>');
            }
        ?>
    </tr>
  </tbody>
</table>
</div><!--con end-->
<div data-role="footer" class="foot">
	<p class="foot_p">Copyright © 2016 科技股份有限公司</p>
</div>
</div><!--page end-->
</body>
<script>
    function inputdata_cheak() {
        var data_blank_count = 0 ;
        var data_err = false ;
        var data_json = "{" ;
        //驗證並寫入資料
        for (var i = 0; i < 25; i++) {
            if ($("#"+i).val() === "" ) {
                data_blank_count = data_blank_count + 1;
                //data_json = data_json + '"' + $("#"+i).attr("name") + '":"' + '0' + '", ' ;
            }else{
                //驗證資料格式
                var str1 = $("#"+i).val().slice(0,1);
                var str2 = parseInt($("#"+i).val().slice(1));
                var re2 = /^[^0]&/

                if (str1 != "+" && str1 != "-"){
                    alert('欄位名稱 ' + $("#"+i).attr("name") + ' 內容為 ' + $("#"+i).val() + ' 首位符號錯誤必須為+號或-號');
                    data_err = true ;
                    break;
                }
                if ( isNaN(str2) || str2 == 0 || str2 >= 100){
                    alert('欄位名稱 ' + $("#"+i).attr("name") + ' 內容為 ' + $("#"+i).val() + ' 扣補值必須為數值且不可為0或大於100的數值');
                    data_err = true ;
                    break;
                }
                data_json = data_json + '"' + $("#"+i).attr("name") + '":"' + str1 + str2 + '", ' ;
            }
        }
        if (data_blank_count === 25 ) {
            alert('全部欄位無資料，請輸入資料。');
            window.event.returnValue = false;
        }
        if (data_err) {
            window.event.returnValue = false;
        }

        data_json = data_json.slice(0,-2);
        data_json = data_json + '}';
        //alert(data_json);
        $("#data").val(data_json);
    }
</script>
</html>
