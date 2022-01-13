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
    (isset($_POST["un_invite"]) && ($_POST["un_invite"]=="enabled" || $_POST["un_invite"]=="disabled") && $btit_settings["fmhack_invitation_system"]=="enabled") ? $un_invite=$_POST["un_invite"] : $un_invite="disabled";
    (isset($_POST["un_bonus"]) && ($_POST["un_bonus"]=="enabled" || $_POST["un_bonus"]=="disabled") && $btit_settings["fmhack_bonus_system"]=="enabled") ? $un_bonus=$_POST["un_bonus"] : $un_bonus="disabled";
    (isset($_POST["un_donate"]) && ($_POST["un_donate"]=="enabled" || $_POST["un_donate"]=="disabled") && $btit_settings["fmhack_advanced_auto_donation_system"]=="enabled") ? $un_donate=$_POST["un_donate"] : $un_donate="disabled";
    (isset($_POST["un_warn"]) && ($_POST["un_warn"]=="enabled" || $_POST["un_warn"]=="disabled") && $btit_settings["fmhack_warning_system"]=="enabled") ? $un_warn=$_POST["un_warn"] : $un_warn="disabled";
    (isset($_POST["un_autorank"]) && ($_POST["un_autorank"]=="enabled" || $_POST["un_autorank"]=="disabled") && $btit_settings["fmhack_auto_rank"]=="enabled") ? $un_autorank=$_POST["un_autorank"] : $un_autorank="disabled";
    (isset($_POST["un_booted"]) && ($_POST["un_booted"]=="enabled" || $_POST["un_booted"]=="disabled") && $btit_settings["fmhack_booted"]=="enabled") ? $un_booted=$_POST["un_booted"] : $un_booted="disabled";
    (isset($_POST["un_sbban"]) && ($_POST["un_sbban"]=="enabled" || $_POST["un_sbban"]=="disabled") && $btit_settings["fmhack_shoutbox_banned"]=="enabled") ? $un_sbban=$_POST["un_sbban"] : $un_sbban="disabled";
    (isset($_POST["un_banbut"]) && ($_POST["un_banbut"]=="enabled" || $_POST["un_banbut"]=="disabled") && $btit_settings["fmhack_ban_button"]=="enabled") ? $un_banbut=$_POST["un_banbut"] : $un_banbut="disabled";
    (isset($_POST["un_notesperpage"]) && !empty($_POST["un_notesperpage"]) && is_numeric($_POST["un_notesperpage"]) && $_POST["un_notesperpage"]>0) ? $un_notesperpage=(int)0+$_POST["un_notesperpage"] : $un_notesperpage=10;

    do_sqlquery("UPDATE `{$TABLE_PREFIX}settings` SET `value`='".$un_invite."' WHERE `key`='un_invite'", true);
    do_sqlquery("UPDATE `{$TABLE_PREFIX}settings` SET `value`='".$un_bonus."' WHERE `key`='un_bonus'", true);
    do_sqlquery("UPDATE `{$TABLE_PREFIX}settings` SET `value`='".$un_donate."' WHERE `key`='un_donate'", true);
    do_sqlquery("UPDATE `{$TABLE_PREFIX}settings` SET `value`='".$un_warn."' WHERE `key`='un_warn'", true);
    do_sqlquery("UPDATE `{$TABLE_PREFIX}settings` SET `value`='".$un_autorank."' WHERE `key`='un_autorank'", true);
    do_sqlquery("UPDATE `{$TABLE_PREFIX}settings` SET `value`='".$un_booted."' WHERE `key`='un_booted'", true);
    do_sqlquery("UPDATE `{$TABLE_PREFIX}settings` SET `value`='".$un_sbban."' WHERE `key`='un_sbban'", true);
    do_sqlquery("UPDATE `{$TABLE_PREFIX}settings` SET `value`='".$un_banbut."' WHERE `key`='un_banbut'", true);
    do_sqlquery("UPDATE `{$TABLE_PREFIX}settings` SET `value`='".$un_notesperpage."' WHERE `key`='un_notesperpage'", true);

    foreach (glob($THIS_BASEPATH."/cache/*.txt") as $filename)
        unlink($filename);
    redirect("index.php?page=admin&user=".$CURUSER["uid"]."&code=".$CURUSER["random"]."&do=user_notes");
}

$btit_settings["un_invite_1"]=(($btit_settings["un_invite"]=="enabled")?"selected='selected'":"");
$btit_settings["un_invite_2"]=(($btit_settings["un_invite"]=="disabled")?"selected='selected'":"");
$btit_settings["un_invite_color"]=(($btit_settings["un_invite"]=="enabled")?"#00FF00;":"#FF0000;");

$btit_settings["un_bonus_1"]=(($btit_settings["un_bonus"]=="enabled")?"selected='selected'":"");
$btit_settings["un_bonus_2"]=(($btit_settings["un_bonus"]=="disabled")?"selected='selected'":"");
$btit_settings["un_bonus_color"]=(($btit_settings["un_bonus"]=="enabled")?"#00FF00;":"#FF0000;");

$btit_settings["un_donate_1"]=(($btit_settings["un_donate"]=="enabled")?"selected='selected'":"");
$btit_settings["un_donate_2"]=(($btit_settings["un_donate"]=="disabled")?"selected='selected'":"");
$btit_settings["un_donate_color"]=(($btit_settings["un_donate"]=="enabled")?"#00FF00;":"#FF0000;");

$btit_settings["un_warn_1"]=(($btit_settings["un_warn"]=="enabled")?"selected='selected'":"");
$btit_settings["un_warn_2"]=(($btit_settings["un_warn"]=="disabled")?"selected='selected'":"");
$btit_settings["un_warn_color"]=(($btit_settings["un_warn"]=="enabled")?"#00FF00;":"#FF0000;");

$btit_settings["un_autorank_1"]=(($btit_settings["un_autorank"]=="enabled")?"selected='selected'":"");
$btit_settings["un_autorank_2"]=(($btit_settings["un_autorank"]=="disabled")?"selected='selected'":"");
$btit_settings["un_autorank_color"]=(($btit_settings["un_autorank"]=="enabled")?"#00FF00;":"#FF0000;");

$btit_settings["un_booted_1"]=(($btit_settings["un_booted"]=="enabled")?"selected='selected'":"");
$btit_settings["un_booted_2"]=(($btit_settings["un_booted"]=="disabled")?"selected='selected'":"");
$btit_settings["un_booted_color"]=(($btit_settings["un_booted"]=="enabled")?"#00FF00;":"#FF0000;");

$btit_settings["un_sbban_1"]=(($btit_settings["un_sbban"]=="enabled")?"selected='selected'":"");
$btit_settings["un_sbban_2"]=(($btit_settings["un_sbban"]=="disabled")?"selected='selected'":"");
$btit_settings["un_sbban_color"]=(($btit_settings["un_sbban"]=="enabled")?"#00FF00;":"#FF0000;");

$btit_settings["un_banbut_1"]=(($btit_settings["un_banbut"]=="enabled")?"selected='selected'":"");
$btit_settings["un_banbut_2"]=(($btit_settings["un_banbut"]=="disabled")?"selected='selected'":"");
$btit_settings["un_banbut_color"]=(($btit_settings["un_banbut"]=="enabled")?"#00FF00;":"#FF0000;");

$admintpl->set("uid",$CURUSER["uid"]);
$admintpl->set("random",$CURUSER["random"]);
$admintpl->set("language",$language);
$admintpl->set("config", $btit_settings);

?>