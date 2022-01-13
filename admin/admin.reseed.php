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
if(!defined("IN_BTIT"))
    die("non direct access!");
if(!defined("IN_ACP"))
    die("non direct access!");

if(isset($_POST) && !empty($_POST))
{
    $reseed_minSeeds=(isset($_POST["reseed_minSeeds"]) && is_numeric($_POST["reseed_minSeeds"]) && $_POST["reseed_minSeeds"]>=0) ? (int)0+$_POST["reseed_minSeeds"]: 0;
    $reseed_minFinished=(isset($_POST["reseed_minFinished"]) && is_numeric($_POST["reseed_minFinished"]) && $_POST["reseed_minFinished"]>=1) ? (int)0+$_POST["reseed_minFinished"]: 1;
    $reseed_minLeechers=(isset($_POST["reseed_minLeechers"]) && is_numeric($_POST["reseed_minLeechers"]) && $_POST["reseed_minLeechers"]>=1) ? (int)0+$_POST["reseed_minLeechers"]: 1;
    $reseed_minTorrentAgeInDays=(isset($_POST["reseed_minTorrentAgeInDays"]) && is_numeric($_POST["reseed_minTorrentAgeInDays"]) && $_POST["reseed_minTorrentAgeInDays"]>=1) ? (int)0+$_POST["reseed_minTorrentAgeInDays"]: 1;
    $reseed_minDaysSinceLast=(isset($_POST["reseed_minDaysSinceLast"]) && is_numeric($_POST["reseed_minDaysSinceLast"]) && $_POST["reseed_minDaysSinceLast"]>=1) ? (int)0+$_POST["reseed_minDaysSinceLast"]: 1;

    do_sqlquery("DELETE FROM `{$TABLE_PREFIX}settings` WHERE `key` LIKE 'reseed_%'", true);
    do_sqlquery("INSERT INTO `{$TABLE_PREFIX}settings` (`key`, `value`) VALUES ('reseed_minSeeds', '".$reseed_minSeeds."'), ('reseed_minFinished', '".$reseed_minFinished."'), ('reseed_minLeechers', '".$reseed_minLeechers."'), ('reseed_minTorrentAgeInDays', '".$reseed_minTorrentAgeInDays."'), ('reseed_minDaysSinceLast', '".$reseed_minDaysSinceLast."');", true);

    foreach(glob($THIS_BASEPATH."/cache/*.txt") as $filename)
        unlink($filename);
    redirect("index.php?page=admin&user=".$CURUSER["uid"]."&code=".$CURUSER["random"]."&do=reseed");
}

$admintpl->set("reseed_minSeeds", $btit_settings["reseed_minSeeds"]);
$admintpl->set("reseed_minFinished", $btit_settings["reseed_minFinished"]);
$admintpl->set("reseed_minLeechers", $btit_settings["reseed_minLeechers"]);
$admintpl->set("reseed_minTorrentAgeInDays", $btit_settings["reseed_minTorrentAgeInDays"]);
$admintpl->set("reseed_minDaysSinceLast", $btit_settings["reseed_minDaysSinceLast"]);
$admintpl->set("uid", $CURUSER["uid"]);
$admintpl->set("random", $CURUSER["random"]);
$admintpl->set("language", $language);
?>