//  點選當下確認庫存數，如無庫存告知使用者。

//短袖無庫存提示
$("#short_size").change(function() {
    var type = "S" + $('#short_size :selected').val(); //關鍵字
    //資料傳送詢問
    $.ajax({
        url: "clo_app_inv_check.php",
        type: "GET",
        data: {
            type: type,
        },
        dataType: "text",
        success: function(amount) {
            if (amount == 0 && amount != " ") {
                alert("短袖靜電衣 " + $('#short_size :selected').val() + " 已經無庫存!!\n如要領取需等待衣物進貨。");
            }
        },
    });
});
//長袖無庫存提示
$("#lon_size").change(function() {
    var type = "L" + $('#lon_size :selected').val(); //關鍵字
    //資料傳送詢問
    $.ajax({
        url: "clo_app_inv_check.php",
        type: "GET",
        data: {
            type: type,
        },
        dataType: "text",
        success: function(amount) {
            if (amount == 0 && amount != " ") {
                alert("長袖靜電衣 " + $('#lon_size :selected').val() + " 已經無庫存!!\n如要領取需等待衣物進貨。");
            }
        },
    });
});
//鞋子無庫存提示
$("#shoe_size").change(function() {
    var type = "SH" + $('#shoe_size :selected').val(); //關鍵字
    //資料傳送詢問
    $.ajax({
        url: "clo_app_inv_check.php",
        type: "GET",
        data: {
            type: type,
        },
        dataType: "text",
        success: function(amount) {
            if (amount == 0 && amount != " ") {
                alert("靜電鞋 " + $('#shoe_size :selected').val() + " 號已經無庫存!!\n如要領取需等待衣物進貨。");
            }
        },
    });
});
//帽子無庫存提示
$("#cap_size").change(function() {
    switch ($('#cap_size :selected').val()) {
        case "男帽":
            var type = "CM"; //關鍵字
            break;
        case "女帽":
            var type = "CW"; //關鍵字
            break;
    }
    //資料傳送詢問
    $.ajax({
        url: "clo_app_inv_check.php",
        type: "GET",
        data: {
            type: type,
        },
        dataType: "text",
        success: function(amount) {
            if (amount == 0 && amount != " ") {
                alert($('#cap_size :selected').val() + " 已經無庫存!!\n如要領取需等待衣物進貨。");
            }
        },
    });
});
