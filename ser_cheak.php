<?php
    $err = '';  //錯誤訊息
    $ptitel ='填寫資料內容確認';  //抬頭
    $pcon =''; // 訊息內容
    $app_date = date("Y-m-d");//申請日期
    $work_id = $_POST["work_id"];//工號
    $name = $_POST["name"];//報修人
    $dep = $_POST["dep"];//部門
    $err_name = $_POST["err_name"];//故障名稱
    $location = $_POST["location"];//故障地點
    $err_con = $_POST["err_con"];//故障內容
    $ser_sta = '待修中';//發送狀態

if(isset($_POST['c_send'])){

include("include/SQ.php");// 開啟資料庫連接

//資料庫敘述指令-查詢語法
$sql1 = "SELECT MAX(id) FROM service";
$arr = mysql_query($sql1);
$id = end(mysql_fetch_row($arr));
$id = $id + 1 ;

//資料庫敘述指令-新增語法
$sql2 = "INSERT INTO service"."(id,app_date,work_id,
name,dep,err_name,location,err_con,ser_sta) ".
"VALUES ('$id','$app_date','$work_id','$name','$dep',
'$err_name','$location','$err_con','$ser_sta')";
//執行指令
if (!mysql_query($sql2)){
  $err = $app_date."<div style='color: #f00' >新增資料失敗!!!錯誤代碼為:".mysql_error()." and ".mysql_errno()."</div>";
}else{
  /*//寄通知信件
  include('include/PHPMailerAutoload.php'); //匯入PHPMailer類別
  include('include/mail.php');//載入發送信
  $mail->From = "信箱"; //設定寄件者信箱
  $mail->FromName = "報修系統"; //設定寄件者姓名
  $mail->Subject = "【 ".$dep."的".$name." 】登記維修 ".$err_name." 於".date("Y/m/d H:i:s"); //設定郵件標題
  $mail->Body = "地點為《 ".$location." 》, 故障概況『 ".$err_con." 』。"; //設定郵件內容
  if(!$mail->Send()) {
    $err = "錯誤碼:MA";
    //$mail->ErrorInfo;
  }else{

  }*/
if(isset($_POST['c_send'])){header("Location: ser_search.php");}//單筆申請轉址
}
mysql_close($db);//關閉資料庫

//縮圖程式
// 取得上傳圖片
$src = imagecreatefromjpeg($_FILES['file']['tmp_name']);

// 取得來源圖片長寬
$src_w = imagesx($src);
$src_h = imagesy($src);

// 假設要長寬不超過90
if($src_w > $src_h){
  $thumb_w = 600;
  $thumb_h = intval($src_h / $src_w * 600);
}else{
  $thumb_h = 600;
  $thumb_w = intval($src_w / $src_h * 600);
}

// 建立縮圖
$thumb = imagecreatetruecolor($thumb_w, $thumb_h);

// 開始縮圖
imagecopyresampled($thumb, $src, 0, 0, 0, 0, $thumb_w, $thumb_h, $src_w, $src_h);

// 儲存縮圖到指定 thumb 目錄
//imagejpeg($thumb, "thumb/".$_FILES['file']['name']);
imagejpeg($thumb, "thumb/".$id.".jpg");
// 複製上傳圖片到指定 images 目錄
//copy($_FILES['file']['tmp_name'], "images/" . $_FILES['file']['name']);

//縮圖結束

}

    //輸入內容
    if ($err === "錯誤碼:MA") {
        $ptitel ='發生錯誤';
        $pcon .='<div style="color: #f00" >已報修成功，但發生錯誤。</div>';
        $pcon .='<div style="color: #f00" >錯誤碼:MA，請連絡總務人員</div>';
        $pcon .='<a href="ser_search.php" data-role="button" data-icon="alert">確定</a>';
    } else if ($err !== '') {
        $ptitel ='輸入資料有誤';
        $pcon .= $err;
        $pcon .='<a href="javascript:history.back(-1)" data-role="button" data-icon="delete">返回</a>';
    }else{

        $pcon .='報修人為:'.$name.'<br/>';
        $pcon .='工號為:'.$work_id.'<br/>';
        $pcon .='部門為:'.$dep.'<br/>';
        $pcon .='◎報修設備資料如下◎<br/>';
        $pcon .='故障設備名稱:<span style="color: blue" >'.$err_name.'</span><br/>';
        $pcon .='故障設備地點:<span style="color: blue" >'.$location.'</span><br/>';
        $pcon .='故障概況:<span style="color: blue" >'.$err_con.'</span><br/>';
        $pcon .='<form method="post" data-ajax="false" enctype="multipart/form-data">
                <input type="hidden" name="work_id" id="work_id" value="'.$work_id.'">
                <input type="hidden" name="name" id="name" value="'.$name.'">
                <input type="hidden" name="dep" id="dep" value="'.$dep.'">
                <input type="hidden" name="err_name" id="err_name" value="'.$err_name.'">
                <input type="hidden" name="location" id="location" value="'.$location.'">
                <input type="hidden" name="err_con" id="err_con" value="'.$err_con.'">
                <div data-role="fieldcontain">
                <div>上傳故障JPG圖片【非必要】</div>
                <input type="file" data-clear-btn="true" name="file" accept=".jpg">
                </div>
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
