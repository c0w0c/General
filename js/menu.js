//變更功能選單圖示

$(document).ready(function() {
    var theCookies = document.cookie.split(';');
    var str = '';
    for (var i = 1; i <= theCookies.length; i++) {
        str += theCookies[i - 1];
    }
    if (!str.match("userlog_id=")) {
        $("#menubtn,#menubtn2,#menubtn3,#menubtn4").html("登錄");
        $("#menubtn,#menubtn2,#menubtn3,#menubtn4").removeClass("ui-icon-bars");
        $("#menubtn,#menubtn2,#menubtn3,#menubtn4").addClass("ui-icon-user");
        $("#menubtn,#menubtn2,#menubtn3,#menubtn4").attr("data-icon", "user");
    } else {
        $("#menubtn,#menubtn2,#menubtn3,#menubtn4").html("MENU");
        $("#menubtn,#menubtn2,#menubtn3,#menubtn4").removeClass("ui-icon-user");
        $("#menubtn,#menubtn2,#menubtn3,#menubtn4").addClass("ui-icon-bars");
        $("#menubtn,#menubtn2,#menubtn3,#menubtn4").attr("data-icon", "bars");
    }
});
