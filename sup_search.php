<?php
$er="";

$page_record = 10; // 每一頁顯示的記錄筆數

// 取得URL參數的頁數
if (isset($_GET["Pages"])) $pages = $_GET["Pages"];
else                       $pages = 1;

include("include/SQ.php"); // 開啟資料庫連接
$sql = "SELECT * FROM sup_app ORDER BY id DESC";
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
<div data-role="page" id="">
<div data-role="header" class="hea">
	<a href="index.html#p2" target="_self" data-icon="back">返回</a>
	<h1>雜項用品</h1>
<div data-role="navbar">
	<ul>
	<li><a href="sup_key_search.php?key=%E5%B0%9A%E6%9C%AA%E8%AE%80%E5%8F%96" target="_self">尚未讀取</a></li>
	<li><a href="sup_key_search.php?key=%E6%BA%96%E5%82%99%E4%B8%AD" target="_self">準備中</a></li>
    <li><a href="sup_key_search.php?key=%E5%B7%B2%E7%99%BC%E9%80%81" target="_self">已發送</a></li>
	</ul>
</div><!-- /navbar -->
            <?php
            echo "<div data-role='controlgroup' data-type='horizontal' class='ui-mini ui-btn-right'>";
            if ( $pages > 1 )  // 顯示上一頁
            echo "<a href='sup_search.php?Pages=".($pages-1).
            "' target='_self' class='ui-btn ui-icon-arrow-l ui-btn-icon-notext ui-corner-all'>　</a>";

            echo "<select data-native-menu='false' data-icon='false' onChange='self.location.href=this.value'>";
            echo "<form action='' method='POST' data-ajax='false'>";
            echo "<option value='".$pages."'>".$pages."</option>";
            for ( $i = 1; $i <= $total_pages; $i++ )
            if ($i != $pages) // 顯示頁碼
            echo "<option value='sup_search.php?Pages=".$i."'>".$i."</option>";
            echo "</form></select>";

            if ( $pages < $total_pages )  // 顯示下一頁
            echo "<a href='sup_search.php?Pages=".($pages+1).
            "' target='_self' class='ui-btn ui-icon-arrow-r ui-btn-icon-notext ui-corner-all'>　</a>";

            echo "</div>";
            ?>

</div>
<div data-role="content" >
<table data-role="table" id="movie-table" data-mode="columntoggle" data-filter="true" data-input="#filterTable-input"  class="ui-body-d ui-shadow table-stripe ui-responsive" data-column-btn-theme="b" data-column-btn-text="顯示項次選擇" data-column-popup-theme="a">
<thead>
    <tr>
	<th style="border:1px solid #e6e6e6;text-align: center;vertical-align: middle;" data-priority="persist">編號</th>
	<th style="border:1px solid #e6e6e6;text-align: center;vertical-align: middle;" data-priority="3">申請</br>日期</th>
	<th style="border:1px solid #e6e6e6;text-align: center;vertical-align: middle;" data-priority="persist">領用人</th>
	<th style="border:1px solid #e6e6e6;text-align: center;vertical-align: middle;" data-priority="3">部門</th>
	<th style="border:1px solid #e6e6e6;text-align: center;vertical-align: middle;" data-priority="persist">領用</br>物品</th>
    <th style="border:1px solid #e6e6e6;text-align: center;vertical-align: middle;" data-priority="3">備註</th>
    <th style="border:1px solid #e6e6e6;text-align: center;vertical-align: middle;" data-priority="persist">發送</br>狀態</th>
	</tr>
</thead>
<tbody>
    <?php
    if ($total_record > 0) { // 有記錄
    $num = $star_record + $page_record;

    //顯示指定記錄
    for ($i = $star_record;$i < $num && $i < $total_record; $i++ ) {
        $id = mysql_result($rows, $i, "id");
        $app_date = mysql_result($rows, $i, "app_date");
        $work_id = mysql_result($rows, $i, "work_id");
        $name = mysql_result($rows, $i, "name");
        $dep = mysql_result($rows, $i, "dep");
        $app_sup = mysql_result($rows, $i, "app_sup");
        $remark = mysql_result($rows, $i, "remark");
        $Status = mysql_result($rows, $i, "Status");

    switch($Status) {
        case '尚未讀取':
            $color = 'ff6a00' ;
            break;
        case '準備中':
            $color = 'ff0000' ;
            break;
        case '已發送':
            $color = '0000FF' ;
            break;
    }

      echo "<tr>";
      echo "<th style='border:1px solid #e6e6e6;text-align: center;vertical-align: middle;'>".$id."</th>";
      echo "<th style='border:1px solid #e6e6e6;text-align: center;vertical-align: middle;'>".$app_date."</th>";
      echo "<th style='border:1px solid #e6e6e6;text-align: center;vertical-align: middle;'>".$name."</br>(".$work_id.")"."</th>";
      echo "<th style='border:1px solid #e6e6e6;text-align: center;vertical-align: middle;'>".$dep."</th>";
      echo "<th style='border:1px solid #e6e6e6;text-align: center;vertical-align: middle;'>".$app_sup."</th>";
      echo "<th style='border:1px solid #e6e6e6;text-align: center;vertical-align: middle;'>".$remark."</th>";
      echo "<th style='border:1px solid #e6e6e6;text-align: center;vertical-align: middle;color:#".$color."'>".$Status."</th>";
      echo "</tr>";
      }
      }
      if ($total_record == 0){// 無記錄
      echo "<tr>資料庫尚無建立資料</tr>";
      }
      ?>
</tbody>
</table>
</div>
<div data-role="footer" class="foot" data-position="fixed">
<form action="sup_key_search.php" method="GET" data-ajax="false">
<table>
  <tr>
    <td style="width: 100%;" ><input data-type="search" name="key" data-mini="true" id="key"  placeholder="請輸入關鍵字 ex:工號,姓名等等..." required ></td>
    <td ><input type="submit" data-mini="true" value="搜尋" name="send"  data-icon="search"></td>
  </tr>
</table>
</form>
</div>
</div>
</body>
</html>
