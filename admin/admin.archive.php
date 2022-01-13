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

if (!defined("IN_BTIT"))
    die("non direct access!");

if (!defined("IN_ACP"))
    die("non direct access!");



if(isset($_POST) && !empty($_POST))
{
    (isset($_POST["quantity"]) && !empty($_POST["quantity"]) && is_numeric($_POST["quantity"]) && $_POST["quantity"]>=1 && $_POST["quantity"]<=99) ? $quantity=(int)0+$_POST["quantity"] : $quantity=false;
    (isset($_POST["timeframe"]) && !empty($_POST["timeframe"]) && is_numeric($_POST["timeframe"]) && $_POST["timeframe"]>=1 && $_POST["timeframe"]<=3) ? $timeframe=(int)0+$_POST["timeframe"] : $timeframe=false;

    if($quantity===false || $timeframe===false)
    {
        $quantity=7;
        $timeframe=2;
    }

    do_sqlquery("UPDATE `{$TABLE_PREFIX}settings` SET `value`='".$quantity."-".$timeframe."' WHERE `key`='archive_time'", true);
 
    foreach (glob($THIS_BASEPATH."/cache/*.txt") as $filename)
        unlink($filename);
    redirect("index.php?page=admin&user=".$CURUSER["uid"]."&code=".$CURUSER["random"]."&do=archive");
}

$currset=explode("-", $btit_settings["archive_time"]);

$admintpl->set("uid",$CURUSER["uid"]);
$admintpl->set("random",$CURUSER["random"]);
$admintpl->set("language",$language);
$admintpl->set("quantity", $currset[0]);
$admintpl->set("selected1", (($currset[1]==1)?true:false), true);
$admintpl->set("selected2", (($currset[1]==2)?true:false), true);
$admintpl->set("selected3", (($currset[1]==3)?true:false), true);

?>