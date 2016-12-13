<?php
//判斷權限及輸入使用者資料
include("include/Cheak_user_pur.php");

//非最高權限則強制轉出
if ($user_pur != "1") {mysql_close($db);header("location:index.html");}

//每一頁顯示的記錄筆數
$page_record = 10;

// 取得URL參數的頁數
if (isset($_GET["Pages"])) $pages = $_GET["Pages"];
else                       $pages = 1;

//判斷使用者權限並給予搜尋範圍
$key = $_GET["key"];

$sql = "SELECT * FROM emp WHERE work_id LIKE '".$key."' OR ".
          "name LIKE '%".$key."%' OR ".
          "dep LIKE '%".$key."%' OR ".
          "pur LIKE '%".$key."%' ORDER BY work_id DESC";

$rows = mysql_query($sql); // 執行SQL查詢

$total_record = mysql_num_rows($rows); // 取得記錄數

$total_pages = ceil($total_record/$page_record);// 計算總頁數

$star_record = ($pages - 1)*$page_record;// 計算這一頁第1筆記錄的位置

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
<div data-role="page">
<div data-role="header" class="hea">
	<a href="user_ad.php" target="_self" data-icon="back">返回</a>
	<H1>帳號搜尋</H1>
<?php
            echo "<div data-role='controlgroup' data-type='horizontal' class='ui-mini ui-btn-right'>";
            if ( $pages > 1 )  // 顯示上一頁
            echo "<a href='clo_ad_key_search.php?key=".$key."&Pages=".($pages-1).
            "' target='_self' class='ui-btn ui-icon-arrow-l ui-btn-icon-notext ui-corner-all'>　</a>";

            echo "<select data-native-menu='false' data-icon='false' onChange='self.location.href=this.value'>";
            echo "<form action='' method='POST' data-ajax='false'>";
            echo "<option value='".$pages."'>".$pages."</option>";
            for ( $i = 1; $i <= $total_pages; $i++ )
            if ($i != $pages) // 顯示頁碼
            echo "<option value='clo_ad_key_search.php?key=".$key."&Pages=".$i."'>".$i."</option>";
            echo "</form></select>";

            if ( $pages < $total_pages )  // 顯示下一頁
            echo "<a href='clo_ad_key_search.php?key=".$key."&Pages=".($pages+1).
            "' target='_self' class='ui-btn ui-icon-arrow-r ui-btn-icon-notext ui-corner-all'>　</a>";

            echo "</div>";
            ?>
</div>
<div data-role="content" >
<div class="titel" style="margin-top: -30px"><h2>總共<?php echo $total_record;?>筆資料</h2></Div>
      <ul data-role="listview"  data-filter-placeholder="輸入關鍵字" data-filter-theme="a" data-inset="true">
      <?php
      if ($total_record > 0) { // 有記錄
      $num = $star_record + $page_record;

      //顯示指定記錄
      for ($i = $star_record;$i < $num && $i < $total_record; $i++ ) {
          $work_id = mysql_result($rows, $i, "work_id");
          $name = mysql_result($rows, $i, "name");
          $password = mysql_result($rows, $i, "password");
          $dep = mysql_result($rows, $i, "dep");
          $pur = mysql_result($rows, $i, "pur");
          $date = mysql_result($rows, $i, "date");

      echo "<li data-icon='delete'>";
      echo "<a href='user_updata.php?id=".$work_id."'>";
      echo "<h1>姓名：".$name."</h1>";
      echo "<h1><strong>工號：".$work_id."</strong></h1>";
      echo "<h1><strong>部門：".$dep."</strong></h1>";
      echo "<h1><strong>權限：".$pur."</strong></h1>";
      echo "<h1><strong>密碼：".$password."</strong></h1>";
      echo "<P>".$con."</P><p class='ui-li-aside'><strong>".$date."</strong></p>";
      echo "<a href='user_delete.php?id=".$work_id."' data-position-to='window'></a>";
      echo '</a></li>';
      }
      }
      ?>
      </UL>
      <?php
        //如搜尋資料數為零
          if ($total_record == 0){
            echo "<h1>無相關搜尋資料</h1>";
          }
      ?>
</div>
<div data-role="footer" class="foot" data-position="fixed">
	<p  class="foot_p">Copyright © 2016 科技股份有限公司</p>
</div>
</div>
</body>
</html>
