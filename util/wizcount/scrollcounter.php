<?

/*
 * 위즈카운트의 웹상에서의 경로
 */
if ( !defined("_zCNTDIR_") ) {
    define("_zCNTDIR_", "/wizcount");
}
$countimg = "images/count.jpg";
function sCounterHead($left_position = 0, $top_position = 0, $speed = 0)
{
    global $count;
	global $countimg;

    $len1 = strlen($count[today_hit]);
    $len2 = strlen($count[total_hit]);

    $twidth = ($len1 + $len2 + 1) * 8;
    $left_position -= $len1 * 8;
    if ( $left_position < 0 ) {
        $left_position = 0;
    }

    echo "    <style TYPE=text/css>\n".
         "    <!--\n".
         "        #scrollWindow {position:absolute; left:$left_position; top:$top_position; width:65; height:300;".
         " clip:rect(19,$twidth,30,0);\n".
         "    -->\n".
         "    </style>\n\n".
 
         "    <script language='JavaScript'>\n".
         "    <!--\n".
         "    function RWindow(URL, WD, HT)\n".
         "    {\n".
         "        window.open(URL, 'counter', 'width='+WD+',height='+HT+',scrollbars=yes,resizable=0,status=no,menubar=0');\n".
         "    }\n\n".

         "    function window_onload()\n".
         "    {\n".
         "        count_today0();\n".
         "    }\n\n";

    for ( $i = 0; $i < $len1; $i++ ) {
        $c = -(substr($count[today_hit], $i, 1) * 13) + 18;

        echo "    function count_today$i()\n".
             "    {\n".
             "        if ( today_hit$i.style.posTop < $c ) {\n".
             "            today_hit$i.style.posTop += 1.5;\n".
             "            window.setTimeout(\"count_today$i();\", $speed, \"JavaScript\");\n".
             "        }\n".
             "        else {\n".
             "            today_hit$i.style.posTop = $c;\n";
        if ( $i < $len1 -1 ) {
            echo "            count_today".($i+1)."();\n";
        }
        else {
            echo "            count_split();\n";
        }
        echo "        }\n".
             "    }\n\n";
    }

    echo "    function count_split()\n".
         "    {\n".
         "        split.innerHTML = \"<a href=# onclick=\\\"javascript:RWindow('"._zCNTDIR_."/status.php', 430, 400)\\\">\\n\"+\n".
         "                          \"<img src="._zCNTDIR_."/images/split.jpg border=0>\\n\"+\n".
         "                          \"</a>\\n\"\n".
         "        count_total0();\n".
         "    }\n\n";

    for ( $i = 0; $i < $len2; $i++ ) {
        $c = -(substr($count[total_hit], $i, 1) * 13) + 18;

        echo "    function count_total$i()\n".
             "    {\n".
             "        if ( total_hit$i.style.posTop < $c ) {\n".
             "            total_hit$i.style.posTop += 1.5;\n".
             "            window.setTimeout(\"count_total$i();\", $speed, \"JavaScript\");\n".
             "        }\n".
             "        else {\n".
             "            total_hit$i.style.posTop = $c;\n";
        if ( $i < $len2 -1 ) {
            echo "            count_total".($i+1)."();\n";
        }
        echo "        }\n".
             "    }\n\n";
    }
    echo "    -->\n".
         "    </script>\n\n";
}

function sCounterView()
{
    global $count;
	global $countimg;

    echo "    <div id=scrollWindow>\n";

    $len = strlen($count[today_hit]);
    for ( $i = 0, $left = 0; $i < $len; $i++, $left += 8 ) {
        echo "        <div id=today_hit$i style='position:absolute; left:$left; top:-142px; width:74px;'>\n".
             "            <img src="._zCNTDIR_."/$countimg border=0 alt='오늘'>\n".
             "        </div>\n\n";
    }

    echo "        <div id=split style=\"position:absolute; left:$left; top:16px; width:74px;\">\n".
         "        </div>\n\n";

    $len = strlen($count[total_hit]);
    for ( $i = 0, $left += 8; $i < $len; $i++, $left += 8 ) {
        echo "        <div id=total_hit$i style='position:absolute; left:$left; top:-142px; width:74px;'>\n".
             "            <img src="._zCNTDIR_."/$countimg border=0 alt='전체'>\n".
             "        </div>\n\n";
    }

    echo "    </div>\n\n";
}

?>
