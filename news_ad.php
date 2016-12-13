<?php
//判斷權限及輸入使用者資料
include("include/Cheak_user_pur.php");

//非最高權限則強制轉出
if ($user_pur != "1") {mysql_close($db);header("location:index.html");}

$page_record = 5; // 每一頁顯示的記錄筆數

// 取得URL參數的頁數
if (isset($_GET["Pages"])) $pages = $_GET["Pages"];
else                       $pages = 1;

$sql = "SELECT * FROM news ORDER BY id DESC";
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
    <!-- 滾動陰影 -->
    <script src="js/shadow.js"></script>
    <!-- 側頁表單 -->
    <script src="js/panel.js"></script>
</head>
<body>
<div data-role="page">
<div data-role="header" class="hea">
<div data-role="controlgroup" data-type="horizontal" class="ui-btn-left">
<a href="index.html" class="ui-btn ui-shadow ui-corner-all ui-btn-icon-left ui-icon-back" target="_self">返回</a>
<a href="#panelmenu" class="ui-btn ui-shadow ui-corner-all ui-icon-bars ui-btn-icon-notext">選單</a>
</div>
	<H1>公告管理</H1>
    <?php
            echo "<div data-role='controlgroup' data-type='horizontal' class='ui-mini ui-btn-right'>";
            if ( $pages > 1 )  // 顯示上一頁
            echo "<a href='news_ad.php?Pages=".($pages-1).
            "' target='_self' class='ui-btn ui-icon-arrow-l ui-btn-icon-notext ui-corner-all'>　</a>";

            echo "<select data-native-menu='false' data-icon='false' onChange='self.location.href=this.value'>";
            echo "<form action='' method='POST' data-ajax='false'>";
            echo "<option value='".$pages."'>".$pages."</option>";
            for ( $i = 1; $i <= $total_pages; $i++ )
            if ($i != $pages) // 顯示頁碼
            echo "<option value='news_ad.php?Pages=".$i."'>".$i."</option>";
            echo "</form></select>";

            if ( $pages < $total_pages )  // 顯示下一頁
            echo "<a href='news_ad.php?Pages=".($pages+1).
            "' target='_self' class='ui-btn ui-icon-arrow-r ui-btn-icon-notext ui-corner-all'>　</a>";

            echo "</div>";
            ?>
</div>
<div data-role="content" >
       <div class="titel"><span class="titeltext">新增公告</span></Div>
	   <ul data-role="listview" data-inset="true" data-icon='edit'>
		<li>
        <a href="news_indata.php">
        <h3>新增</h3>
        </a>
   		</li>
      </ul>
      <div class="titel"><span class="titeltext">修改刪除</span></Div>

      <ul data-role="listview" data-inset="true">
      <?php
      if ($total_record > 0) { // 有記錄
      $num = $star_record + $page_record;

      //顯示指定記錄
      for ($i = $star_record;$i < $num && $i < $total_record; $i++ ) {
          $id = mysql_result($rows, $i, "id");
          $date = mysql_result($rows, $i, "date");
          $title = mysql_result($rows, $i, "title");
          $con = mysql_result($rows, $i, "con");
          $sup = mysql_result($rows, $i, "sup");

      echo "<li data-icon='delete'>";
      echo "<a href='news_updata.php?id=".$id."'>";
      echo "<h1>".$id.'.'.$title."</h1>";
      echo "<P>".$con."</P><p class='ui-li-aside'><strong>".$date."</strong></p>";
      echo "<a href='news_delete.php?id=".$id."' data-position-to='window'></a>";
      echo '</a></li>';
      }
      }
      ?>
      </UL>
</div>

<div data-role="footer" class="foot">
	<p class="foot_p">Copyright © 2016 科技股份有限公司</p>
</div>
<div data-role="panel" id="panelmenu" data-position="left" data-display="overlay" data-theme="a">
        <iframe src="logmenu.php" height="510px" width="100%"  style="margin: 0px auto;border:none" ></iframe>
</div>
</div>
</body>
</html>
