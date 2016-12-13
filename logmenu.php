<?php
header("Content-Type:text/html; charset=utf-8");

$work_id = $_POST["work_id"];
$password = $_POST["password"];

session_start();
$err_con = $_SESSION['err_con'];

$userlog_id = $_COOKIE["userlog_id"];
$userlog_password = base64_decode($_COOKIE["userlog_password"]);

include("include/SQ.php"); // 開啟資料庫連接

//當COOKIE裡有使用者名稱的值，查詢使用者權限
if (!empty($userlog_id) && !empty($userlog_password)) {
  $sql_user = "SELECT * FROM emp WHERE work_id LIKE '".$userlog_id."'";
  $row = mysql_fetch_row(mysql_query($sql_user)); // 執行SQL查詢
  if ($userlog_id == $row[0] && md5($userlog_password) == $row[2]) {
  //確認帳號密碼正確
    $user_name = $row[1] ; //寫入使用者名稱
    $user_dep = $row[3]; //寫入使用者部門
    $user_pur = $row[4]; //寫入使用者權限
  }else{
    $user_pur = "";
  }
}

//使用者登入
if (isset($_POST["send"]) && (!empty($work_id)) && (!empty($password))){
  //確認輸入的帳號密碼
  $sql_user = "SELECT * FROM emp WHERE work_id LIKE '".$work_id."'";
  $row = mysql_fetch_row(mysql_query($sql_user)); // 執行SQL查詢
  if ($work_id == $row[0] and md5($password) == $row[2]){
    //密碼正確寫入COOKIE
    $day = strtotime("+1 days"); //設定COOKIE期限一天
    setcookie("userlog_id",$work_id,$day); //寫入使用者ID
    setcookie("userlog_password",base64_encode($password),$day); //寫入使用者密碼
    $user_name = $row[1] ; //寫入使用者名稱
    $user_dep = $row[3]; //寫入使用者部門
    $user_pur = $row[4]; //寫入使用者權限
  }else{
    $err_con = $err_con + 1 ;
    $_SESSION['err_con'] = $err_con;
    $info="帳號密碼錯誤或查無帳號</br>【還可嘗試".( 3 - $err_con)."次】";
  }
}

mysql_close($db); // 關閉資料庫連接

//使用者登出
if (isset($_POST["logout"])){
  //清空COOKIE
  $day = strtotime("-1 day");
  setcookie("userlog_id","",$day); //清除使用者ID
  setcookie("userlog_password","",$day); //清除使用者密碼
  header("location:logmenu.php");
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
<div data-role="page" data-title="使用者登錄│科技股份有限公司">
<div data-role="content" data-theme="a" >
<?php
    if ($err_con >= 3) {
      $user_pur = "err";
      $info="錯誤次數過多!!</br>【請與總務人員聯絡】";
    }

    echo "<p style='text-align:center;color: #f00'>".$info."</p>";

    switch($user_pur) {

        case '1':
            echo "<div style='text-align: right;color:blue'><h6>".$user_name." 您好!!</h6></div>";
            echo "<div style='text-align: center'><h3>管理頁面</h3></div>";
            echo "<a class='ui-btn' data-theme='b' href='news_ad.php' target='_parent'>公告管理</a>";
            echo "<a class='ui-btn' data-theme='b' href='clo_ad.php' target='_parent'>靜電衣物管理</a>";
            echo "<a class='ui-btn' data-theme='b' href='sup_ad.php' target='_parent'>雜項用品管理</a>";
            echo "<a class='ui-btn' data-theme='b' href='ser_ad.php' target='_parent'>報修管理</a>";
            echo "<a class='ui-btn' data-theme='b' href='user_ad.php' target='_parent'>使用者帳號管理</a>";
            echo "<form action='' method='POST' data-ajax='false'>";
            echo "<input type='submit' name='logout' id='logout' value='登出'  />";
            echo "</form>";
            break;
        case '2':
            echo "<div style='text-align: right;color:blue'><h6>".$user_name." 您好!!</h6></div>";
            echo "<div style='text-align: center'><h3>管理頁面</h3></div>";
            echo "<a class='ui-btn' data-theme='b' href='clo_ad.php' target='_parent'>靜電衣物管理</a>";
            echo "<a class='ui-btn' data-theme='b' href='sup_ad.php' target='_parent'>雜項用品管理</a>";
            echo "<a class='ui-btn' data-theme='b' href='ser_ad.php' target='_parent'>報修管理</a>";
            echo "<form action='' method='POST' data-ajax='false'>";
            echo "<input type='submit' name='logout' id='logout' value='登出'  />";
            echo "</form>";
            break;
        case 'err':
            break;
        default:
            echo "<form action='' method='POST' data-ajax='false'>";
            echo "工號: <input type='text' name='work_id' id='work_id' />";
            echo "密碼: <input type='password' name='password' id='password' />";
            echo "<input type='submit' name='send' id='send' value='登入'  />";
            echo "</form>";
    }

?>

</div>
</div>
</body>
</html>
