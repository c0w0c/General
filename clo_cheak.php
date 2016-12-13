<?php
    $err = '';  //錯誤訊息
    $ptitel ='填寫資料內容確認';  //抬頭
    $pcon =''; // 訊息內容
    $app_clo=$_POST["app_clo"]; //申請的內容
    $app_date = date("Y-m-d");//申請日期
    $work_id = $_POST["work_id"];//工號
    $name = $_POST["name"];//領用人
    $dep = $_POST["dep"];//部門
    $app_rea = $_POST["app_rea"];//申請原因
    $app_name = $_POST["app_name"];//申請人
    $remark = $_POST["remark"];//備註內容
    $status ='尚未讀取';//發送狀態
    $recorded ='0';//發送狀態

//申請
if(isset($_POST['c_send']) or isset($_POST['a_send'])){

include("include/SQ.php");// 開啟資料庫連接

//資料庫敘述指令-查詢語法
$sql1 = "SELECT MAX(id) FROM clo_app";
$arr = mysql_query($sql1);
$id = end(mysql_fetch_row($arr));
$id = $id + 1 ;

//資料庫敘述指令-新增語法
$sql2 = "INSERT INTO clo_app"."(id,app_date,work_id,
name,dep,app_rea,app_name,app_clo,remark,status,recorded) ".
"VALUES ('$id','$app_date','$work_id','$name','$dep',
'$app_rea','$app_name','$app_clo','$remark','$status','$recorded')";
//執行指令
if (!mysql_query($sql2)){
  $err = $app_date."<div style='color: #f00' >新增資料失敗!!!錯誤代碼為:".mysql_error()." and ".mysql_errno()."</div>";
}else{
    //修改衣物字串
    $app_clo_arr = explode("</br>",rtrim($app_clo ,"</br>"));
    $app_clo_mail = "";
    foreach ($app_clo_arr as $value) {
        $app_clo_mail .= "【" . $value . "】";
    }
    /*//寄通知信件
    include('include/PHPMailerAutoload.php'); //匯入PHPMailer類別
    include('include/mail.php');//載入發送信
    $mail->From = "信箱"; //設定寄件者信箱
    $mail->FromName = "衣物系統"; //設定寄件者姓名
    $mail->Subject = "【 ".$dep."的".$app_name." 】登記申領了".$app_clo_mail."於".date("Y/m/d H:i:s"); //設定郵件標題
    $mail->Body = "領用人為《 ".$app_name." 》, 工號【 ".$work_id." 】, 領用原因為 『 ".$app_rea." 』。"; //設定郵件內容
    if(!$mail->Send()) {
        $err = "錯誤碼:MA";
        //$mail->ErrorInfo;
    }else{

    }*/
if(isset($_POST['c_send'])){header("Location: clo_search.php");}//單筆申請轉址
if(isset($_POST['a_send'])){header("Location: clo_app.php");}//多筆申請轉址
}
mysql_close($db);//關閉資料庫
}

    //判斷短袖衣服的尺寸及數量
    if( $_POST['short_size'] != 'none' && $_POST['short_num'] == 'none'  ){
        $err .= '<div style="color: #f00" ><CENTER>*短袖衣服數量輸入不正確!!</CENTER></div>';
    }elseif( $_POST['short_size'] == 'none' && $_POST['short_num'] != 'none' ){
        $err .='<div style="color: #f00" ><CENTER>*短袖衣服尺寸輸入不正確!!</CENTER></div>';
    }
    //判斷長袖衣服的尺寸及數量
    if( $_POST['lon_size'] != 'none' && $_POST['lon_num'] == 'none'  ){
        $err .= '<div style="color: #f00" ><CENTER>*長袖衣服數量輸入不正確!!</CENTER></div>';
    }elseif( $_POST['lon_size'] == 'none' && $_POST['lon_num'] != 'none' ){
        $err .='<div style="color: #f00" ><CENTER>*長袖衣服尺寸輸入不正確!!</CENTER></div>';
    }
    //寫入短袖
    if($_POST["short_size"] !== 'none' || $_POST["short_num"] !== 'none' ){
        $app_clo .= '短袖'.$_POST["short_size"].'*'.$_POST["short_num"]."</br>";
    }
    //寫入長袖
    if($_POST["lon_size"] !== 'none' || $_POST["lon_size"] !== 'none' ){
        $app_clo .= '長袖'.$_POST["lon_size"].'*'.$_POST["lon_num"]."</br>";
    }
    //寫入鞋子
    if($_POST["shoe_size"] !== 'none'){
        $app_clo .= $_POST["shoe_size"].'號鞋*1</br>';
    }
    //寫入帽子
    if($_POST["cap_size"] !== 'none'){
        $app_clo .= $_POST["cap_size"].'*1</br>';
    }
    //判斷是否有申請內容
        if($app_clo == ''){
        $err .= '<div style="color: #f00" ><CENTER>*請選擇欲申請的用品!!</CENTER></div>';
    }
    //輸入內容
    if ($err === "錯誤碼:MA") {
        $ptitel ='發生錯誤';
        $pcon .='<div style="color: #f00" >已申領成功，但發生錯誤。</div>';
        $pcon .='<div style="color: #f00" >錯誤碼:MA，請連絡總務人員</div>';
        $pcon .='<a href="clo_search.php" data-role="button" data-icon="alert">確定</a>';
    } else if ($err !== '') {
        $ptitel ='輸入資料有誤';
        $pcon .= $err;
        $pcon .='<a href="javascript:history.back(-1)" data-role="button" data-icon="delete">返回</a>';
    }else{

        $pcon .='申請人為:'.$name.'<br/>';
        $pcon .='工號為:'.$work_id.'<br/>';
        $pcon .='部門為:'.$dep.'<br/>';
        $pcon .='填表人為:'.$app_name.'<br/>';
        $pcon .='領用原因為:'.$app_rea.'<br/>';
        $pcon .='您申請的衣物用品如下:<br/><div style="color: blue" >'.$app_clo.'</div><br/>';
        $pcon .='備註的內容為:'.$remark.'<br/>';
        $pcon .='<form method="post" data-ajax="false">
                <input type="hidden" name="work_id" id="work_id" value="'.$work_id.'">
                <input type="hidden" name="name" id="name" value="'.$name.'">
                <input type="hidden" name="dep" id="dep" value="'.$dep.'">
                <input type="hidden" name="app_name" id="app_name" value="'.$app_name.'">
                <input type="hidden" name="app_rea" id="app_rea" value="'.$app_rea.'">
                <input type="hidden" name="app_clo" id="app_clo" value="'.$app_clo.'">
                <input type="hidden" name="remark" id="remark" value="'.$remark.'">
                <div class="ui-grid-a">
	            <div class="ui-block-a">
		        <input type="submit" value="確定送出" name="c_send"  data-icon="check"/>
	            </div>
	            <div class="ui-block-b">
                <a href="javascript:history.back(-1)" data-role="button" data-icon="delete">取消返回</a>
                </div></div>
                <div style="margin:0px 5px 0px 5px;" >
                <input type="submit" value="確定送出後繼續申領" name="a_send" data-icon="edit"/></div>
                </form>';
                }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no " />
    <title>填寫資料內容確認</title>
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
<div data-role="dialog" id="cheak" data-close-btn="none">
   <div data-role="header" data-theme="a">
    <H1><?php echo $ptitel ;?></H1>
   </div>
   <div data-role="content" data-theme="a">
       <div style="margin-bottom: 5px;" >
       <?php echo $pcon ;?>
       </div>
</div></div>
</body>
</html>
