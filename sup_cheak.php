<?php
    $err = '';  //錯誤訊息
    $ptitel ='填寫資料內容確認';  //抬頭
    $pcon =''; // 訊息內容
    $app_date = date("Y-m-d");//申請日期
    $work_id = $_POST["work_id"];//工號
    $name = $_POST["name"];//領用人
    $dep = $_POST["dep"];//部門
    $app_sup = $_POST["app_sup"];//申請用品內容
    $remark = $_POST["remark"];//備註內容
    $status ='尚未讀取';//發送狀態

if(isset($_POST['c_send'])){

include("include/SQ.php");// 開啟資料庫連接

//資料庫敘述指令-查詢語法
$sql1 = "SELECT MAX(id) FROM sup_app";
$arr = mysql_query($sql1);
$id = end(mysql_fetch_row($arr));
$id = $id + 1 ;

//資料庫敘述指令-新增語法
$sql2 = "INSERT INTO sup_app"."(id,app_date,work_id,
name,dep,app_sup,remark,status) ".
"VALUES ('$id','$app_date','$work_id','$name','$dep',
'$app_sup','$remark','$status')";
//執行指令
if (!mysql_query($sql2)){
  $err = $app_date."<div style='color: #f00' >新增資料失敗!!!錯誤代碼為:".mysql_error()." and ".mysql_errno()."</div>";
}else{
    /*//寄通知信件
    include('include/PHPMailerAutoload.php'); //匯入PHPMailer類別
    include('include/mail.php');//載入發送信
    $mail->From = "信箱"; //設定寄件者信箱
    $mail->FromName = "用品系統"; //設定寄件者姓名
    $mail->Subject = "【 ".$dep."的".$name." 】登記申領『 ".$app_sup." 』於".date("Y/m/d H:i:s"); //設定郵件標題
    $mail->Body = "備註:".$remark; //設定郵件內容
    if(!$mail->Send()) {
        $err = "錯誤碼:MA";
        //$mail->ErrorInfo;
    }else{

    }*/
if(isset($_POST['c_send'])){header("Location: sup_search.php");}//單筆申請轉址
}

mysql_close($db);//關閉資料庫

}

    //判斷用品的種類及數量
    if( $_POST['sup'] != 'none' && $_POST['sup_num'] == 'none'  ){
        $err .= '<div style="color: #f00" ><CENTER>*數量輸入不正確!!</CENTER></div>';
    }elseif( $_POST['sup'] == 'none' && $_POST['sup_num'] != 'none' ){
        $err .='<div style="color: #f00" ><CENTER>*種類輸入不正確!!</CENTER></div>';
    }

    //寫入用品
    if($_POST["sup"] !== 'none' || $_POST["sup_num"] !== 'none' ){
        $app_sup .=$_POST["sup"].' * '.$_POST["sup_num"];
    }

    //判斷是否有申請內容
        if($app_sup == ''){
        $err .= '<div style="color: #f00" ><CENTER>*請選擇欲申請的用品!!</CENTER></div>';
    }
    //輸入內容
    if ($err === "錯誤碼:MA") {
        $ptitel ='發生錯誤';
        $pcon .='<div style="color: #f00" >已報修成功，但發生錯誤。</div>';
        $pcon .='<div style="color: #f00" >錯誤碼:MA，請連絡總務人員</div>';
        $pcon .='<a href="sup_search.php" data-role="button" data-icon="alert">確定</a>';
    } else if ($err !== '') {
        $ptitel ='輸入資料有誤';
        $pcon .= $err;
        $pcon .='<a href="javascript:history.back(-1)" data-role="button" data-icon="delete">返回</a>';
    }else{
        $pcon .='申請人為:'.$name.'<br/>';
        $pcon .='工號為:'.$work_id.'<br/>';
        $pcon .='部門為:'.$dep.'<br/>';
        $pcon .='您申請的用品如下:<div style="color: blue" >'.$app_sup.'</div><br/>';
        $pcon .='備註的內容為:'.$remark.'<br/>';
        $pcon .='<form method="post" data-ajax="false">
                <input type="hidden" name="work_id" id="work_id" value="'.$work_id.'">
                <input type="hidden" name="name" id="name" value="'.$name.'">
                <input type="hidden" name="dep" id="dep" value="'.$dep.'">
                <input type="hidden" name="app_sup" id="app_sup" value="'.$app_sup.'">
                <input type="hidden" name="remark" id="remark" value="'.$remark.'">
                <div class="ui-grid-a">
	            <div class="ui-block-a">
		        <input type="submit" value="確定送出" name="c_send"  data-icon="check"/>
	            </div>
	            <div class="ui-block-b">
                <a href="javascript:history.back(-1)" data-role="button" data-icon="delete">取消返回</a>
                </div></div>
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
