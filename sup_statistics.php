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
    <!-- D3 js -->
    <script src="js/d3.min.js"></script>
    <!-- D3pie js -->
    <script src="js/d3pie.min.js"></script>
</head>

<body>
    <div data-role="page">
        <div data-role="header" class="hea">
            <a href="index.html#p2" target="_self" data-icon="back">返回</a>
            <H1>衣物統計報表</H1>
        </div>
        <div data-role="content" style="padding-top:5px;">
            <div id="d1"></div>
            <form data-mini="true">
                <fieldset class="ui-grid-b">
                  <div class="ui-block-a" style="width: 40%;"><input type="date" id="star_date" value="<?php echo date ("Y").'-01-01';?>"></div>
                  <div class="ui-block-b" style="text-align: center;width: 20%;height: 68px;"><h2>起至</h2></div>
                   <div class="ui-block-c" style="width: 40%;"><input type="date" id="end_date" value="<?php echo date ("Y-m-d");?>"></div>
                </fieldset>
                <label for="sta" class="ui-hidden-accessible">請選擇報表統計方式:</label>
                <select id="sta" name="sta" data-shadow="true" data-native-menu="false">
                    <option value="總數統計" SELECTED>總數統計</option>
                    <optgroup value="rea" label="以領用物品統計">
                        <option value="垃圾袋">垃圾袋</option>
                        <option value="A1白棉布">A1白棉布</option>
                        <option value="掃把">掃把</option>
                        <option value="畚斗">畚斗</option>
                        <option value="拖把">拖把</option>
                        <option value="肥皂">肥皂</option>
                    </optgroup>
                    <optgroup value="dep" label="以各別部門統計">
                        <option value="SMD">SMD</option>
                        <option value="後製成">後製程</option>
                        <option value="後製程(手插)">後製程(手插)</option>
                        <option value="後製程(修整)">後製程(修整)</option>
                        <option value="後製程(測試)">後製程(測試)</option>
                        <option value="後製程(系統)">後製程(系統)</option>
                        <option value="製本部">製本部</option>
                        <option value="工程">工程</option>
                        <option value="物料">物料</option>
                        <option value="品保">品保</option>
                        <option value="工務">工務</option>
                        <option value="行政">行政</option>
                        <option value="財務">財務</option>
                        <option value="財務(人事)">財務(人事)</option>
                        <option value="業務">業務</option>
                    </optgroup>
                </select>
            </form>
            <div id="pieChart"></div>
            <script>
            //視窗縮放延遲功能
            var waitForFinalEvent = (function() {
                var timers = {};
                return function(callback, ms, uniqueId) {
                    if (!uniqueId) {
                        uniqueId = "Don't call this twice without a unique Id";
                    }
                    if (timers[uniqueId]) {
                        clearTimeout(timers[uniqueId]);
                    }
                    timers[uniqueId] = setTimeout(callback, ms);
                };
            })();

            //建立圓餅圖功能
            function create_pieChart(pie_width, pie_height, json, h_t , h_s, f_t ,lab_out ,lab_int ,lab_main) {
                var pie = new d3pie("pieChart", {
                    "header": {
                        "title": {
                            "text": h_t,
                            //"color": "#000",
                            "font": "標楷體",
                            "fontSize": 21
                        },
                        "subtitle": {
                            "text": h_s,
                            //"color": "#000",
                            "font": "標楷體",
                            "fontSize": 12
                        },
                        "location": "pie-center"
                    },
                    "footer": {
                        "text": f_t,
                        "location": "bottom-center",
                        "color": "#999999",
                        "font": "標楷體",
                        "fontSize": 20
                    },
                    "size": {
                        "canvasWidth": pie_width,
                        "canvasHeight": pie_height - 100,
                        "pieInnerRadius": "60%",
                        "pieOuterRadius": "90%"
                    },
                    "labels": {
                        "outer": lab_out,
                        "inner": lab_int,
                        "mainLabel": lab_main,
                        "percentage": {
                            "color": "#fff",
                            "font": "標楷體",
                            "fontSize": 14,
                            "decimalPlaces": 0 //小數點位數
                        },
                        //"value": {
                        //  "color": "#1a1a1a",
                        // "fontSize": 14
                        //},
                        //"truncation": {
                        //  "enabled": true
                        //}
                    },
                    "tooltips": {
                        "enabled": true,
                        "type": "placeholder",
                        "string": "{label}: {percentage}% ({value}筆資料)",
                        //{label}: {percentage}% ({value}筆),{value} 筆紀錄
                        "styles": {
                            "fadeInSpeed": 500,
                            "backgroundColor": "#00cc99",
                            "backgroundOpacity": 0.8,
                            "borderRadius": 4,
                            "color": "#ffffcc",
                            "font": "標楷體",
                            "fontSize": 14,
                            "padding": 10
                        }
                    },
                    "data": {
                        "sortOrder": "label-asc",
                        "content": json
                    },
                });
            }

            //AJAX獲取資料功能
            function ajax_get_date(event) {
                //獲取初始化參數
                var star_date = $("#star_date").val(); //起始日期
                var end_date = $("#end_date").val(); //結束日期
                var chart_type = $('#sta :selected').parent().attr('value'); //型態
                var chart_key = $('#sta :selected').val(); //關鍵字

                switch (chart_type) { //判斷報表型態
                  //已部門統計
                  case 'dep':
                    var h_t = chart_key;
                    var h_s = chart_key+"部門領用統計數據";
                    var f_t = "";
                  break;
                  //已申領原因統計
                  case 'rea':
                    var h_t = chart_key;
                    var h_s = "領用物品統計數據";
                    var f_t = "";
                  break;
                  //已總數統計
                  default:
                    var h_t = chart_key;
                    var h_s = "申領總數統計數據";
                    var f_t = "";
                  break;
                }

                //設定圓餅圖大小
                var pie_width = document.documentElement.scrollWidth *0.9;
                var pie_height = document.documentElement.scrollHeight * 0.9;

                //傳送參數
                $.ajax({
                    url: "sup_statistics_json.php",
                    type: "GET",
                    data: {
                        star_date: star_date,
                        end_date: end_date,
                        chart_type: chart_type,
                        chart_key: chart_key
                    },
                    dataType: "json",
                    success: function(json) {
                      if (json.length > 5) {
                        var lab_out = {"format": "label","pieDistance": 10,};
                        var lab_int = {"format": "percentage",};
                        var lab_main = {"color": "#000","font": "標楷體","fontSize": 14};
                      }else{
                        var lab_out = {"format": "none",};
                        var lab_int = {"format": "label-percentage2"};
                        var lab_main = {"color": "#fff","font": "標楷體","fontSize": 14};
                      }
                      if ( json[0]["label"] == "查無資料" ) {
                        alert('查無資料，請修改查詢日期或條件。');
                        return false;
                      }

                      $("svg").remove(); //移除舊有圓餅圖
                      //呼叫創建圓餅圖
                      create_pieChart(pie_width, pie_height, json, h_t , h_s, f_t ,lab_out ,lab_int ,lab_main);
                    },
                });
            }

            //當文件完成時
            $(document).ready(function() {

                //呼叫資料傳送
                ajax_get_date();

                //視窗縮放時
                $(window).resize(function() {
                    if (document.documentElement.scrollWidth > 450) { //行動版不更新
                        waitForFinalEvent(function() { //呼叫延遲程式
                            ajax_get_date(); //呼叫資料傳送
                        }, 500, "some unique string");
                    }
                });

                //select選擇被改變時
                $("select").change(function(){
                  ajax_get_date(); //呼叫資料傳送
                });

                //input日期被改變時
                $("input").change(function(){
                  var star_date = $("#star_date").val(); //起始日期
                  var end_date = $("#end_date").val(); //結束日期
                  //日期驗證
                  if (star_date === "" || end_date === "") {
                    alert("日期設定不可為空白。");
                    return false;
                  }
                  if ( Date.parse(star_date) >= Date.parse(end_date) ) {
                    alert("起始日不能大於或等於結束日。");
                    return false;
                  }
                  //延遲呼叫
                  waitForFinalEvent(function(event) {
                    ajax_get_date(); //呼叫資料傳送
                  }, 500, "some unique string");
                });
            });
            </script>
        </div>
        <div data-role="footer" class="foot">
            <p class="foot_p">Copyright © 2016 科技股份有限公司</p>
        </div>
</body>

</html>
