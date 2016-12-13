<?php
header("Content-Type:text/html; charset=utf-8");

$page_record = 5; // 每一頁顯示的記錄筆數

// 取得URL參數的頁數
if (isset($_GET["Pages"])) $pages = $_GET["Pages"];
else                       $pages = 1;

include("include/SQ.php"); // 開啟資料庫連接
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
</head>
<body>
    <div data-role="page" id="">
		<div data-role="content" >
     	 <div class="titel"><span class="titeltext">最新公告消息</span>
            <span class="titelpage" style="float:right;padding-top:15px;">
            <?php
            if ( $pages > 1 )  // 顯示上一頁
            echo "<a href='news.php?Pages=".($pages-1).
            "' target='_self' style='text-decoration:none;' >《</a> ";

            echo "第".$pages."頁";

            //for ( $i = 1; $i <= $total_pages; $i++ )
            //if ($i != $pages) // 顯示頁碼
            //    echo "<a href='news.php?Pages=".$i."' target='_self' style='text-decoration:none;' >".
            //    $i."</a> ";
            //else echo "$i ";

            if ( $pages < $total_pages )  // 顯示下一頁
                echo " <a href='news.php?Pages=".($pages+1).
                "' target='_self' style='text-decoration:none;' >》</a> ";
            ?>
           </span>
         </div>

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

         echo '<div style=" clear:right;" data-role="collapsible"  data-collapsed-icon="carat-d" data-expanded-icon="carat-u">';
         echo "<h1>".$date.'　'.$title."</h1>";
         echo $con;
         echo "<p style='text-align: right;color:blue;font-weight: bold;'>發布者:".$sup."</p>";
         echo '</div>';
         }
		}

        ?>
        </div>
    </div>
</body>
</html>