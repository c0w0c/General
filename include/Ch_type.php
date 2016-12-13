<?PHP
//判斷型號函數
function Ch_type($x){
   switch($x){
     case "短袖S":$x = "SS";break; case "短袖M":$x = "SM";break;
     case "短袖L":$x = "SL";break; case "短袖2L":$x = "S2L";break;
     case "短袖3L":$x = "S3L";break; case "短袖4L":$x = "S4L";break;
     case "短袖5L":$x = "S5L";break; case "短袖6L":$x = "S6L";break;

     case "長袖S":$x = "LS";break; case "長袖M":$x = "LM";break;
     case "長袖L":$x = "LL";break; case "長袖2L":$x = "L2L";break;
     case "長袖3L":$x = "L3L";break; case "長袖4L":$x = "L4L";break;
     case "長袖5L":$x = "L5L";break; case "長袖6L":$x = "L6L";break;

     case "37號鞋":$x = "SH37";break; case "38號鞋":$x = "SH38";break;
     case "39號鞋":$x = "SH39";break; case "40號鞋":$x = "SH40";break;
     case "41號鞋":$x = "SH41";break; case "42號鞋":$x = "SH42";break;
     case "43號鞋":$x = "SH43";break;

     case "男帽":$x = "CM";break; case "女帽":$x = "CW";break;

     case "SS":$x = "短袖S";break; case "SM":$x = "短袖M";break;
     case "SL":$x = "短袖L";break; case "S2L":$x = "短袖2L";break;
     case "S3L":$x = "短袖3L";break; case "S4L":$x = "短袖4L";break;
     case "S5L":$x = "短袖5L";break; case "S6L":$x = "短袖6L";break;

     case "LS":$x = "長袖S";break; case "LM":$x = "長袖M";break;
     case "LL":$x = "長袖L";break; case "L2L":$x = "長袖2L";break;
     case "L3L":$x = "長袖3L";break; case "L4L":$x = "長袖4L";break;
     case "L5L":$x = "長袖5L";break; case "L6L":$x = "長袖6L";break;

     case "SH37":$x = "37號鞋";break; case "SH38":$x = "38號鞋";break;
     case "SH39":$x = "39號鞋";break; case "SH40":$x = "40號鞋";break;
     case "SH41":$x = "41號鞋";break; case "SH42":$x = "42號鞋";break;
     case "SH43":$x = "43號鞋";break;

     case "CM":$x = "男帽";break; case "CW":$x = "女帽";break;

   }
   return $x;
}
?>