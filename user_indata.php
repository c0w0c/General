<?php
//判斷權限及輸入使用者資料
include("include/Cheak_user_pur.php");

//非最高權限則強制轉出
if ($user_pur != "1") {mysql_close($db);header("location:index.html");}

$er = "";
    //按下送出鈕後取得表單資料
if (isset($_POST["send"])){
    $work_id = $_POST["work_id"];
    $name = $_POST["name"];
    $password = md5($_POST["password"]);
    $dep = $_POST["dep"];
    $pur = $_POST["pur"];
    $date = $_POST["date"];

    //資料庫敘述指令-新增語法
    $sql1 = "INSERT INTO emp"."(work_id,name,password,dep,pur,date) ".
    "VALUES ('$work_id','$name','$password','$dep','$pur','$date')";
    //執行指令
    if (!mysql_query($sql1)){
        $er = "<div style='color: #f00' >新增資料失敗!!!錯誤代碼為:".mysql_error()." and ".mysql_errno()."</div>";
    }else{
        header("Location: user_ad.php");
    }
    mysql_close($db);//關閉資料庫
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
    <script>
    $("document").ready(function(){
        //延遲秒數執行AJAX
        var delay = (function(){
            var timer = 0;
            return function(callback, ms){
                clearTimeout (timer);
                timer = setTimeout(callback, ms);
            };
        })();

        //當輸入完畢功號後，使用AJAX查詢功號並顯示
        $("#work_id").keyup(function(){
            txt = $("#work_id").val();
            if (!!txt) {
                delay(function(){
                    $.post("user_cheak_id.php",{work_id:txt},function(result){
                        $("#cheak_id").html(result);
                    });
                }, 500 );
            }else{
                $("#cheak_id").empty();
            }
        });

        //驗證功號是否被使用，如被使用則阻止表單提交
        $("#submit").click(function(check){
            cheak_id_tip = $("#cheak_id").text();
            if (cheak_id_tip === "該工號已經使用") {
                alert("該工號已被使用，無法新增該筆資料!!");
                $("#work_id").focus();
                check.preventDefault();//阻止表單提交
            }
        });
    });
    </script>
</head>
<body>

<div data-role="page">
<div data-role="header" class="hea">
    <a href="user_ad.php" target="_self"  data-icon="back">返回</a>
    <H1>新增使用者</H1>
</div>
<div data-role="content" >
    <?php echo $er;?>
    <form action="" method="post" data-ajax="false">
        <ul data-role="listview" data-inset="true">
            <li class="ui-field-contain">
            <label for="date">日 期 :</label>
            <input type="date" name="date" id="date" value="<?php echo date("Y-m-d");?>" required>
            </li>
            <li class="ui-field-contain">
            <p id="cheak_id"></p>
            <label for="work_id">工 號 :</label>
            <input type="text" name="work_id" id="work_id" data-clear-btn="true" required>
            </li>
            <li class="ui-field-contain">
            <label for="name">姓 名 :</label>
            <input type="text" name="name" id="name" data-clear-btn="true" required>
            </li>
            <li class="ui-field-contain">
            <label for="password">密 碼 :</label>
            <input type="text" name="password" id="password" data-clear-btn="true" required>
            <li class="ui-field-contain">
            <label for="dep">部 門 :</label>
            <input type="text" name="dep" id="dep" data-clear-btn="true" required>
            </li>
            <li class="ui-field-contain">
            <label for="pur">權 限 :</label>
            <input type="text" name="pur" id="pur" data-clear-btn="true" required>
            </li>
            <li class="ui-field-contain">
            <div class="ui-grid-a">
            <div class="ui-block-a">
            <input type="submit" id="submit" value="送出" name="send"  data-icon="check"/>
            </div>
            <div class="ui-block-b">
            <input type="reset" value="取消返回" name="del"  data-icon="delete"/>
            </div>
            </div>
            </li>
        </ul>
    </form>
</div>
    <div  data-role="footer" class="foot">
        <p class="foot_p">Copyright © 2016 科技股份有限公司</p>
    </div>
</div>
</body>
</html>
