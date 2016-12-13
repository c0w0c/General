<?php
include("include/SQ.php");// 開啟資料庫連接

function fontcolor($num){ //庫存量提示顏色
    if ($num == 0) {
        $num = "<span style='color:red;'>".$num."<span>";
    }elseif ($num < 10) {
        $num = "<span style='color:#ff9900;'>".$num."<span>";
    }
    return $num;
};

//查詢短袖靜電衣語法
$sql = "SELECT * FROM clo_inv";

$rows1 = mysql_query($sql); // 執行SQL查詢

$SS = fontcolor(mysql_result($rows1 , 0, "amount"));
$SM = fontcolor(mysql_result($rows1 , 1, "amount"));
$SL = fontcolor(mysql_result($rows1 , 2, "amount"));
$S2L = fontcolor(mysql_result($rows1 , 3, "amount"));
$S3L = fontcolor(mysql_result($rows1 , 4, "amount"));
$S4L = fontcolor(mysql_result($rows1 , 5, "amount"));
$S5L = fontcolor(mysql_result($rows1 , 6, "amount"));
$S6L = fontcolor(mysql_result($rows1 , 7, "amount"));

$LS = fontcolor(mysql_result($rows1 , 8, "amount"));
$LM = fontcolor(mysql_result($rows1 , 9, "amount"));
$LL = fontcolor(mysql_result($rows1 , 10, "amount"));
$L2L = fontcolor(mysql_result($rows1 , 11, "amount"));
$L3L = fontcolor(mysql_result($rows1 , 12, "amount"));
$L4L = fontcolor(mysql_result($rows1 , 13, "amount"));
$L5L = fontcolor(mysql_result($rows1 , 14, "amount"));
$L6L = fontcolor(mysql_result($rows1 , 15, "amount"));

$sh37 = fontcolor(mysql_result($rows1 , 16, "amount"));
$sh38 = fontcolor(mysql_result($rows1 , 17, "amount"));
$sh39 = fontcolor(mysql_result($rows1 , 18, "amount"));
$sh40 = fontcolor(mysql_result($rows1 , 19, "amount"));
$sh41 = fontcolor(mysql_result($rows1 , 20, "amount"));
$sh42 = fontcolor(mysql_result($rows1 , 21, "amount"));
$sh43 = fontcolor(mysql_result($rows1 , 22, "amount"));

$man = fontcolor(mysql_result($rows1 , 23, "amount"));
$woman = fontcolor(mysql_result($rows1 , 24, "amount"));

mysql_close($db); // 關閉資料庫連接

?>
<!DOCTYPE html>
<html>
<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no "/>
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
<script>
    function clo() {
        document.getElementById("clo").style.display='';
        document.getElementById("shoes").style.display='none';
        document.getElementById("cap").style.display='none';
    }
    function shoes() {
        document.getElementById("clo").style.display='none';
        document.getElementById("shoes").style.display='';
        document.getElementById("cap").style.display='none';
    }
    function cap() {
        document.getElementById("clo").style.display='none';
        document.getElementById("shoes").style.display='none';
        document.getElementById("cap").style.display='';
    }
</script>
</head>
<body>
<div data-role="page">
<div data-role="header" class="hea" data-position="fixed">
	<a href="index.html#p1" target="_self" data-icon="back">返回</a>
	<H1>靜電用品庫存</H1>
    <div data-role="navbar">
        <ul>
        <li><a onclick="clo(this)" >靜電衣</a></li>
        <li><a onclick="shoes(this)" >靜電鞋</a></li>
        <li><a onclick="cap(this)">防塵帽</a></li>
        </ul>
    </div><!-- /navbar -->
</div>
<div data-role="content">
<div id="clo" >
   <div class="ui-grid-solo" style="text-align: center;">
     <div class="ui-block-a"><div style="background-color: #b3d9ff;" class="ui-bar ui-bar-a ui-solo">靜電衣</div></div>
</div>
<div id="S" class="ui-grid-b" style="text-align: center;">
	<div class="ui-block-a"><div class="ui-size1">S</div></div>
	<div class="ui-block-b"><div class="ui-up1">短</div>
                            <div class="ui-down1">長</div></div>
	<div class="ui-block-c"><div class="ui-up1"><?php echo $SS; ?></div>
                            <div class="ui-down1"><?php echo $LS; ?></div></div>
</div>
<div id="M" class="ui-grid-b" style="text-align: center;">
	<div class="ui-block-a"><div class="ui-size2">M</div></div>
	<div class="ui-block-b"><div class="ui-up2">短</div>
                            <div class="ui-down2">長</div></div>
	<div class="ui-block-c"><div class="ui-up2"><?php echo $SM; ?></div>
                            <div class="ui-down2"><?php echo $LM; ?></div></div>
</div>
<div id="L" class="ui-grid-b" style="text-align: center;">
	<div class="ui-block-a"><div class="ui-size1">L</div></div>
	<div class="ui-block-b"><div class="ui-up1">短</div>
                            <div class="ui-down1">長</div></div>
	<div class="ui-block-c"><div class="ui-up1"><?php echo $SL; ?></div>
                            <div class="ui-down1"><?php echo $LL; ?></div></div>
</div>
<div id="XL" class="ui-grid-b" style="text-align: center;">
	<div class="ui-block-a"><div class="ui-size2">2L,XL</div></div>
	<div class="ui-block-b"><div class="ui-up2">短</div>
                            <div class="ui-down2">長</div></div>
	<div class="ui-block-c"><div class="ui-up2"><?php echo $S2L; ?></div>
                            <div class="ui-down2"><?php echo $L2L; ?></div></div>
</div>
<div id="2XL" class="ui-grid-b" style="text-align: center;">
	<div class="ui-block-a"><div class="ui-size1">3L,2XL</div></div>
	<div class="ui-block-b"><div class="ui-up1">短</div>
                            <div class="ui-down1">長</div></div>
	<div class="ui-block-c"><div class="ui-up1"><?php echo $S3L; ?></div>
                            <div class="ui-down1"><?php echo $L3L; ?></div></div>
</div>
<div id="3XL" class="ui-grid-b" style="text-align: center;">
	<div class="ui-block-a"><div class="ui-size2">4L,3XL</div></div>
	<div class="ui-block-b"><div class="ui-up2">短</div>
                            <div class="ui-down2">長</div></div>
	<div class="ui-block-c"><div class="ui-up2"><?php echo $S4L; ?></div>
                            <div class="ui-down2"><?php echo $L4L; ?></div></div>
</div>
<div id="4XL" class="ui-grid-b" style="text-align: center;">
	<div class="ui-block-a"><div class="ui-size1">5L,4XL</div></div>
	<div class="ui-block-b"><div class="ui-up1">短</div>
                            <div class="ui-down1">長</div></div>
	<div class="ui-block-c"><div class="ui-up1"><?php echo $S5L; ?></div>
                            <div class="ui-down1"><?php echo $L5L; ?></div></div>
</div>
<div id="5XL" class="ui-grid-b" style="text-align: center;">
	<div class="ui-block-a"><div class="ui-size2">6L,5XL</div></div>
	<div class="ui-block-b"><div class="ui-up2">短</div>
                            <div class="ui-down2">長</div></div>
	<div class="ui-block-c"><div class="ui-up2"><?php echo $S6L; ?></div>
                            <div class="ui-down2"><?php echo $L6L; ?></div></div>
</div>
    </div>

<div id="shoes">
   <div class="ui-grid-solo" style="text-align: center;">
     <div class="ui-block-a" ><div style="background-color: #b3d9ff;" class="ui-bar ui-bar-a ui-solo">靜電鞋</div></div>
</div>
<div id="37" class="ui-grid-a" style="text-align: center;">
	<div class="ui-block-a"><div class="ui-size1">37號</div></div>
	<div class="ui-block-b"><div class="ui-size1"><?php echo $sh37;?></div></div>
</div>
<div id="38" class="ui-grid-a" style="text-align: center;">
	<div class="ui-block-a"><div class="ui-size2">38號</div></div>
	<div class="ui-block-b"><div class="ui-size2"><?php echo $sh38;?></div></div>
</div>
<div id="39" class="ui-grid-a" style="text-align: center;">
	<div class="ui-block-a"><div class="ui-size1">39號</div></div>
	<div class="ui-block-b"><div class="ui-size1"><?php echo $sh39;?></div></div>
</div>
<div id="40" class="ui-grid-a" style="text-align: center;">
	<div class="ui-block-a"><div class="ui-size2">40號</div></div>
	<div class="ui-block-b"><div class="ui-size2"><?php echo $sh40;?></div></div>
</div>
<div id="41" class="ui-grid-a" style="text-align: center;">
	<div class="ui-block-a"><div class="ui-size1">41號</div></div>
	<div class="ui-block-b"><div class="ui-size1"><?php echo $sh41;?></div></div>
</div>
<div id="42" class="ui-grid-a" style="text-align: center;">
	<div class="ui-block-a"><div class="ui-size2">42號</div></div>
	<div class="ui-block-b"><div class="ui-size2"><?php echo $sh42;?></div></div>
</div>
<div id="43" class="ui-grid-a" style="text-align: center;">
	<div class="ui-block-a"><div class="ui-size1">43號</div></div>
	<div class="ui-block-b"><div class="ui-size1"><?php echo $sh43;?></div></div>
</div>
    </div>

<div id="cap">
   <div class="ui-grid-solo" style="text-align: center;">
     <div class="ui-block-a" ><div style="background-color: #b3d9ff;" class="ui-bar ui-bar-a ui-solo">防塵帽</div></div>
</div>
<div id="man" class="ui-grid-a" style="text-align: center;">
	<div class="ui-block-a"><div class="ui-size1">男帽</div></div>
	<div class="ui-block-b"><div class="ui-size1"><?php echo $man;?></div></div>
</div>
<div id="woman" class="ui-grid-a" style="text-align: center;">
	<div class="ui-block-a"><div class="ui-size2">女帽</div></div>
	<div class="ui-block-b"><div class="ui-size2"><?php echo $woman;?></div></div>
</div>
</div>
</div>

	<div  data-role="footer" class="foot" data-position="fixed">
		<p class="foot_p">Copyright © 2016 科技股份有限公司</p>
	</div>
</div>
</body>
</html>
