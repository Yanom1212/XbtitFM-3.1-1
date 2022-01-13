<?php
/////////////////////////////////////////////////////////////////////////////////////
// xbtit - Bittorrent tracker/frontend
//
// Copyright (C) 2004 - 2020  xbtitFM Team
//
//    This file is part of xbtitFM.
//
// Redistribution and use in source and binary forms, with or without modification,
// are permitted provided that the following conditions are met:
//
//   1. Redistributions of source code must retain the above copyright notice,
//      this list of conditions and the following disclaimer.
//   2. Redistributions in binary form must reproduce the above copyright notice,
//      this list of conditions and the following disclaimer in the documentation
//      and/or other materials provided with the distribution.
//   3. The name of the author may not be used to endorse or promote products
//      derived from this software without specific prior written permission.
//
// THIS SOFTWARE IS PROVIDED BY THE AUTHOR ``AS IS'' AND ANY EXPRESS OR IMPLIED
// WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF
// MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED.
// IN NO EVENT SHALL THE AUTHOR BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
// SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED
// TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR
// PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF
// LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
// NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE,
// EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
//
////////////////////////////////////////////////////////////////////////////////////
require "include/functions.php";
dbconn();
global $TABLE_PREFIX, $CURUSER, $BASEURL;
$HERE = dirname(__file__);
require ("./".load_language("lang_main.php"));
if($CURUSER["edit_users"] != "yes")
    die();
if(empty($_SESSION['CURUSER']['style_url']))
{
    // get user's style
    $resheet = do_sqlquery("SELECT * FROM {$TABLE_PREFIX}style where id=".$CURUSER["style"]." LIMIT 1", false, $btit_settings["cache_duration"]);
    if(!$resheet)
    {
        $STYLEPATH = "$THIS_BASEPATH/style/xbtitFM";
        $STYLEURL = "$BASEURL/style/xbtitFM";
    }
    else
    {
        $resstyle = mysqli_fetch_array($resheet);
        $STYLEPATH = "$THIS_BASEPATH/".$resstyle["style_url"];
        $STYLEURL = "$BASEURL/".$resstyle["style_url"];
    }
    $_SESSION['CURUSER']['style_url'] = $STYLEURL;
    $_SESSION['CURUSER']['style_path'] = $STYLEPATH;
}
else
{
    $STYLEURL = $_SESSION['CURUSER']['style_url'];
    $STYLEPATH = $_SESSION['CURUSER']['style_path'];
}
$uid = (isset($_GET["id"])?intval($_GET["id"]):$uid = 0);
$wlist = get_result("SELECT *,UNIX_TIMESTAMP(date) AS data FROM `{$TABLE_PREFIX}watched_users` WHERE `uid`=".$uid." ORDER BY `id` DESC", false, $btit_settings["cache_duration"]);
include ("$HERE/include/offset.php");
echo "<table width=100%>

<tr><td class=header>".$language["LAST_IP"]."</td><td class=header>".$language["LAST_LOCATION"]."</td><td class=header>".$language["WHEN_LOCATION"]."</td><td class=header></td></tr>";
foreach($wlist as $wid => $watch)
{
    echo "<tr><td class=lista>".$watch["cip"]."</td><td class=lista>".$watch["location"]."</td><td class=lista>".date("d/m/Y H:i", $watch["data"] - $offset)."</td><td class=lista><a href=\"javascript:popprogress('watchdel.php?wid=".
        $watch["id"]."');\"><img border=0 src=".$STYLEURL."/images/delete.png></a></td></tr>";
}
echo "</table>";

?>