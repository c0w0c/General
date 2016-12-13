<?php
//include('PHPMailerAutoload.php'); //匯入PHPMailer類別

$mail= new PHPMailer(); //建立新物件
$mail->IsSMTP(); //設定使用SMTP方式寄信
$mail->SMTPAuth = true; //設定SMTP需要驗證
$mail->Host = "SMTP主機"; //設定SMTP主機
$mail->Port = 25; //設定SMTP埠位，預設為25埠
$mail->CharSet = "utf-8"; //設定郵件編碼

$mail->Username = "帳號"; //設定驗證帳號
$mail->Password = "密碼"; //設定驗證密碼

$mail->IsHTML(flase); //設定郵件內容為HTML
$mail->AddAddress("e-mail", "shrhe"); //設定收件者郵件及名稱

//$mail->Send();
//if(!$mail->Send()) {
//	echo "Mailer Error: " . $mail->ErrorInfo;
//} else {
//	echo "Message sent!";
//}
?>
