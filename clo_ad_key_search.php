<?php
//判斷權限及輸入使用者資料
include("include/Cheak_user_pur.php");

//每一頁顯示的記錄筆數
$page_record = 10;

// 取得URL參數的頁數
if (isset($_GET["Pages"])) $pages = $_GET["Pages"];
else                       $pages = 1;

//判斷使用者權限並給予搜尋範圍
$key = $_GET["key"];
switch($user_pur){
  case'1':
    //判斷是否需要清單
    if ( $key == 'list') {
      $sql = "SELECT * FROM clo_app WHERE Status LIKE '尚未讀取' OR Status LIKE '準備中' ORDER BY id DESC ";
    }else{
      $sql = "SELECT * FROM clo_app WHERE id LIKE '".$key."' OR ".
          "app_date = binary '".$key."' OR ".
          "work_id LIKE '%".$key."%' OR ".
          "name LIKE '%".$key."%' OR ".
          "dep LIKE '%".$key."%' OR ".
          "app_rea LIKE '%".$key."%' OR ".
          "app_name LIKE '%".$key."%' OR ".
          "remark LIKE '%".$key."%' OR ".
          "Status LIKE '%".$key."%' ORDER BY id DESC";
    }
    break;
  case'2':
    $sql = "SELECT * FROM clo_app WHERE ( id LIKE '".$key."' OR ".
        "app_date = binary '".$key."' OR ".
        "work_id LIKE '%".$key."%' OR ".
        "name LIKE '%".$key."%' OR ".
        "remark LIKE '%".$key."%' OR ".
        "Status LIKE '%".$key."%' ) AND ".
        "app_name ='".$user_name."' ORDER BY id DESC";
    break;
}

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

<div data-role="page" id="news_ad">
<div data-role="header" class="hea">
	<a href="clo_ad.php" target="_self" data-icon="back">返回</a>
	<H1>管理搜尋</H1>
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
        $id = mysql_result($rows, $i, "id");
        $app_date = mysql_result($rows, $i, "app_date");
        $work_id = mysql_result($rows, $i, "work_id");
        $name = mysql_result($rows, $i, "name");
        $dep = mysql_result($rows, $i, "dep");
        $app_rea = mysql_result($rows, $i, "app_rea");
        $app_name = mysql_result($rows, $i, "app_name");
        $app_clo = mysql_result($rows, $i, "app_clo");
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
            //判斷權限更改清單顯示內容
            switch($user_pur){
                case'1':
                    echo "<li data-icon='delete'>";
                    echo "<a href='clo_updata.php?id=".$id."'>";
                    echo "<h1>".$id.'.'.$app_date."</h1>";
                    echo "<p class='ui-li-aside' style='color:#".$color."'><strong>".$Status."</strong></p>";
                    echo "<P><strong>".$app_name."</strong> 幫 <strong>".$name.
                         "</strong> 申請了</P><P style='color:blue;'>".$app_clo.
                         "</P><P>原因: ".$app_rea."</P><P>備註: ".$remark."</p>";
                    echo "<a href='clo_delete.php?id=".$id."' data-position-to='window'></a>";
                    echo '</a></li>';
                break;
                case'2':
                    echo "<li>";
                    echo "<h1>".$id.'.'.$app_date."</h1>";
                    echo "<p class='ui-li-aside' style='color:#".$color."'><strong>".$Status."</strong></p>";
                    echo "<P><strong>".$app_name."</strong> 幫 <strong>".$name.
                         "</strong> 申請了</P><P style='color:blue;'>".$app_clo.
                         "</P><P>原因: ".$app_rea."</P><P>備註: ".$remark."</p>";
                    echo '</li>';
                break;
            }
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
