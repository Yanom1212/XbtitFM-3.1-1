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
    (isset($_POST["req_onoff"]) && $_POST["req_onoff"]=="true") ? $req_onoff="true" : $req_onoff="false";
    (isset($_POST["req_shout"]) && $_POST["req_shout"]=="true") ? $req_shout="true" : $req_shout="false";
    (isset($_POST["req_maxon"]) && $_POST["req_maxon"]=="true") ? $req_maxon="true" : $req_maxon="false";
    (isset($_POST["req_rwon"]) && $_POST["req_rwon"]=="true") ? $req_rwon="true" : $req_rwon="false";
    (isset($_POST["req_sbmb"]) && $_POST["req_sbmb"]=="true") ? $req_sbmb="true" : $req_sbmb="false";
    (isset($_POST["req_number"]) && is_numeric($_POST["req_number"]) && $_POST["req_number"]>0) ? $req_number=(int)0+$_POST["req_number"] : $req_number=0;
    (isset($_POST["req_prune"]) && is_numeric($_POST["req_prune"]) && $_POST["req_prune"]>0) ? $req_prune=(int)0+$_POST["req_prune"] : $req_prune=0;
    (isset($_POST["req_page"]) && is_numeric($_POST["req_page"]) && $_POST["req_page"]>0) ? $req_page=(int)0+$_POST["req_page"] : $req_page=0;
    (isset($_POST["req_max"]) && is_numeric($_POST["req_max"]) && $_POST["req_max"]>0) ? $req_max=(int)0+$_POST["req_max"] : $req_max=0;
    (isset($_POST["req_mb"]) && is_numeric($_POST["req_mb"]) && $_POST["req_mb"]>0) ? $req_mb=(int)0+$_POST["req_mb"] : $req_mb=0;
    (isset($_POST["req_sb"]) && is_numeric($_POST["req_sb"]) && $_POST["req_sb"]>0) ? $req_sb=(int)0+$_POST["req_sb"] : $req_sb=0;

    do_sqlquery("UPDATE `{$TABLE_PREFIX}settings` SET `value`='".$req_onoff."' WHERE `key`='req_onoff'", true);
    do_sqlquery("UPDATE `{$TABLE_PREFIX}settings` SET `value`='".$req_shout."' WHERE `key`='req_shout'", true);
    do_sqlquery("UPDATE `{$TABLE_PREFIX}settings` SET `value`='".$req_maxon."' WHERE `key`='req_maxon'", true);
    do_sqlquery("UPDATE `{$TABLE_PREFIX}settings` SET `value`='".$req_rwon."' WHERE `key`='req_rwon'", true);
    do_sqlquery("UPDATE `{$TABLE_PREFIX}settings` SET `value`='".$req_sbmb."' WHERE `key`='req_sbmb'", true);
    do_sqlquery("UPDATE `{$TABLE_PREFIX}settings` SET `value`='".$req_number."' WHERE `key`='req_number'", true);
    do_sqlquery("UPDATE `{$TABLE_PREFIX}settings` SET `value`='".$req_prune."' WHERE `key`='req_prune'", true);
    do_sqlquery("UPDATE `{$TABLE_PREFIX}settings` SET `value`='".$req_page."' WHERE `key`='req_page'", true);
    do_sqlquery("UPDATE `{$TABLE_PREFIX}settings` SET `value`='".$req_max."' WHERE `key`='req_max'", true);
    do_sqlquery("UPDATE `{$TABLE_PREFIX}settings` SET `value`='".$req_mb."' WHERE `key`='req_mb'", true);
    do_sqlquery("UPDATE `{$TABLE_PREFIX}settings` SET `value`='".$req_sb."' WHERE `key`='req_sb'", true);

    foreach (glob($THIS_BASEPATH."/cache/*.txt") as $filename)
        unlink($filename);
    redirect("index.php?page=admin&user=".$CURUSER["uid"]."&code=".$CURUSER["random"]."&do=requests");
}

$btit_settings["req_rwonyes"]=($btit_settings["req_rwon"]?"checked=\"checked\"":"");
$btit_settings["req_rwonno"]=(!$btit_settings["req_rwon"]?"checked=\"checked\"":"");
$btit_settings["req_sbmbyes"]=($btit_settings["req_sbmb"]?"checked=\"checked\"":"");
$btit_settings["req_sbmbno"]=(!$btit_settings["req_sbmb"]?"checked=\"checked\"":"");
$btit_settings["req_shoutyes"]=($btit_settings["req_shout"]?"checked=\"checked\"":"");
$btit_settings["req_shoutno"]=(!$btit_settings["req_shout"]?"checked=\"checked\"":"");
$btit_settings["req_onoffyes"]=($btit_settings["req_onoff"]?"checked=\"checked\"":"");
$btit_settings["req_onoffno"]=(!$btit_settings["req_onoff"]?"checked=\"checked\"":"");
$btit_settings["req_maxonyes"]=($btit_settings["req_maxon"]?"checked=\"checked\"":"");
$btit_settings["req_maxonno"]=(!$btit_settings["req_maxon"]?"checked=\"checked\"":"");

$admintpl->set("uid",$CURUSER["uid"]);
$admintpl->set("random",$CURUSER["random"]);
$admintpl->set("language",$language);
$admintpl->set("config", $btit_settings);

?>