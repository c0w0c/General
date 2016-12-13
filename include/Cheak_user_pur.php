<?php
$userlog_id = $_COOKIE["userlog_id"];
$userlog_password = base64_decode($_COOKIE["userlog_password"]);

//判斷COOKIE是否有使用者的資料
if (!empty($userlog_id) && !empty($userlog_password)) {
  include("include/SQ.php");// 開啟資料庫連接
  $sql_user = "SELECT * FROM emp WHERE work_id LIKE '".$userlog_id."'";
  $row = mysql_fetch_row(mysql_query($sql_user)); // 執行SQL查詢
  //如有檢查權限
  if ($userlog_id == $row[0] && md5($userlog_password) == $row[2]) {
    //確認帳號密碼正確
    $user_id = $row[0] ; //寫入使用者工號
    $user_name = $row[1] ; //寫入使用者名稱
    $user_dep = $row[3]; //寫入使用者部門
    $user_pur = $row[4]; //寫入使用者權限
  }else{
    mysql_close($db); // 關閉資料庫連接
    header("location:index.html");
  }
}else{
  header("location:index.html");
}
?>