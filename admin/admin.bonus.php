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
      


if (!$CURUSER || $CURUSER["admin_access"]!="yes")
{
       err_msg($language["ERROR"],$language["NOT_ADMIN_CP_ACCESS"]);
       stdfoot();
       exit;
}
else
{
  $i=0;
  $r=do_sqlquery("SELECT * FROM {$TABLE_PREFIX}bonus");
  while($row = mysqli_fetch_array($r)){
    $traffic=number_format($row["traffic"]/1073741824,0);
$traf[$i]["traffic"]=$traffic;
$traf[$i]["points"]=$row["points"];
$traf[$i]["name"]=$row["name"];
$i++;
  }
    $admintpl->set("language", $language);
    $admintpl->set("price_vip", $btit_settings["price_vip"]);
    $admintpl->set("price_ct", $btit_settings["price_ct"]);
    $admintpl->set("price_name", $btit_settings["price_name"]);
    $admintpl->set("bonus", $btit_settings["bonus"]);
    $admintpl->set("traf", $traf);
    $admintpl->set("random", $CURUSER["random"]);
    $admintpl->set("uid", $CURUSER["uid"]);
    $admintpl->set("firstview", (($_POST["action"]=="Update")?FALSE:TRUE), TRUE);
    $admintpl->set("gb_enable", (($btit_settings["gb_enable"]=="true")?TRUE:FALSE), TRUE);
    $admintpl->set("vip_enable", (($btit_settings["vip_enable"]=="true")?TRUE:FALSE), TRUE);
    $admintpl->set("ct_enable", (($btit_settings["ct_enable"]=="true")?TRUE:FALSE), TRUE);
    $admintpl->set("uname_enable", (($btit_settings["uname_enable"]=="true")?TRUE:FALSE), TRUE);
    $admintpl->set("show_inv", (($btit_settings["fmhack_invitation_system"]=="enabled")?TRUE:FALSE), TRUE);
    $admintpl->set("inv_enable", (($btit_settings["inv_enable"]=="true" && $btit_settings["fmhack_invitation_system"]=="enabled")?TRUE:FALSE), TRUE);
    $admintpl->set("price_inv", $btit_settings["price_inv"]);
    $admintpl->set("price_inv3", $btit_settings["price_inv3"]);
    $admintpl->set("price_inv5", $btit_settings["price_inv5"]);
    $admintpl->set("all", (($GLOBALS["bonus_type"]=="all")?TRUE:FALSE), TRUE);
    $admintpl->set("one", (($GLOBALS["bonus_type"]=="one")?TRUE:FALSE), TRUE);
    $admintpl->set("upl_enable", (($btit_settings["upl_enable"]=="true")?TRUE:FALSE), TRUE);
    $admintpl->set("bonus_upl", $btit_settings["bonus_upl"]);
    $admintpl->set("bonus_upl_delay", $btit_settings["bonus_upl_delay"]);
    $admintpl->set("comm_enable", (($btit_settings["comm_enable"]=="true")?TRUE:FALSE), TRUE);
    $admintpl->set("bonus_comm", $btit_settings["bonus_comm"]);
    $admintpl->set("timed_ranks_enabled_1", (($btit_settings["fmhack_timed_ranks"]=="enabled")?TRUE:FALSE), TRUE);
    $admintpl->set("timed_ranks_enabled_2", (($btit_settings["fmhack_timed_ranks"]=="enabled")?TRUE:FALSE), TRUE);
    $admintpl->set("vip_timeframe", $btit_settings["vip_timeframe"]);
    $admintpl->set("opt1", (($btit_settings["vip_timeframe"]==0)?TRUE:FALSE),TRUE);
    $admintpl->set("opt2", (($btit_settings["vip_timeframe"]==7)?TRUE:FALSE),TRUE);
    $admintpl->set("opt3", (($btit_settings["vip_timeframe"]==14)?TRUE:FALSE),TRUE);
    $admintpl->set("opt4", (($btit_settings["vip_timeframe"]==21)?TRUE:FALSE),TRUE);
    $admintpl->set("opt5", (($btit_settings["vip_timeframe"]==30)?TRUE:FALSE),TRUE);
    $admintpl->set("opt6", (($btit_settings["vip_timeframe"]==61)?TRUE:FALSE),TRUE);
    $admintpl->set("opt7", (($btit_settings["vip_timeframe"]==91)?TRUE:FALSE),TRUE);
    $admintpl->set("opt8", (($btit_settings["vip_timeframe"]==182)?TRUE:FALSE),TRUE);
    $admintpl->set("opt9", (($btit_settings["vip_timeframe"]==365)?TRUE:FALSE),TRUE);
    $admintpl->set("forpost_enable", (($btit_settings["forpost_enable"]=="true")?TRUE:FALSE), TRUE);
    $admintpl->set("bonus_forpost", $btit_settings["bonus_forpost"]);
    $admintpl->set("sb_speed_enable", (($btit_settings["sb_speed_enable"]=="true")?TRUE:FALSE), TRUE);
    $admintpl->set("bonus_min_uprate", $btit_settings["bonus_min_uprate"]);
    $admintpl->set("sb_max_ph_enable", (($btit_settings["sb_max_ph_enable"]=="true")?TRUE:FALSE), TRUE);
    $admintpl->set("bonus_max_per_hour", $btit_settings["bonus_max_per_hour"]);
    $admintpl->set("sb_shout_enable", (($btit_settings["sb_shout_enable"]=="true")?TRUE:FALSE), TRUE);
    $admintpl->set("bonus_make_a_shout", $btit_settings["bonus_make_a_shout"]);
    $admintpl->set("radio_enabled", (($btit_settings["fmhack_shoutcast_stats_and_DJ_application"]=="enabled")?TRUE:FALSE), TRUE);
    $admintpl->set("sb_radio_enable", (($btit_settings["sb_radio_enable"]=="true")?TRUE:FALSE), TRUE);
    $admintpl->set("bonus_listen2radio", $btit_settings["bonus_listen2radio"]);
    $admintpl->set("sb_gift_enable", (($btit_settings["sb_gift_enable"]=="true")?TRUE:FALSE), TRUE);
    $admintpl->set("bonus_giftmax", $btit_settings["bonus_giftmax"]);
    $admintpl->set("show_hnr", (($btit_settings["fmhack_warning_system"]=="enabled" && $btit_settings["fmhack_anti_hit_and_run_system"]=="enabled")?TRUE:FALSE), TRUE);
    $admintpl->set("hnr_enable", (($btit_settings["hnr_enable"]=="true" && $btit_settings["fmhack_warning_system"]=="enabled" && $btit_settings["fmhack_anti_hit_and_run_system"]=="enabled")?TRUE:FALSE), TRUE);
    $admintpl->set("price_hnr", $btit_settings["price_hnr"]);
    $admintpl->set("archive_enable", (($btit_settings["archive_enable"]=="true" && $btit_settings["fmhack_archive_torrents"]=="enabled")?true:false), true);
    $admintpl->set("arc_enabled", (($btit_settings["fmhack_archive_torrents"]=="enabled")?true:false), true);
    $admintpl->set("bonus_archive", $btit_settings["bonus_archive"]);
    $admintpl->set("flshot_enable", (($btit_settings["flshot_enable"]=="true" && $btit_settings["fmhack_freeleech_slots"]=="enabled")?true:false), true);
    $admintpl->set("show_fls", (($btit_settings["fmhack_freeleech_slots"]=="enabled")?true:false), true);
    $admintpl->set("bonus_flslot", $btit_settings["bonus_flslot"]);

    if($_POST["action"]==$language["UPDATE"])
    {
        (isset($_POST["price_vip"]) && !empty($_POST["price_vip"]) && is_numeric($_POST["price_vip"]))?$price_vip=0+$_POST["price_vip"]:$price_vip=0;
        (isset($_POST["price_ct"]) && !empty($_POST["price_ct"]) && is_numeric($_POST["price_ct"]))?$price_ct=0+$_POST["price_ct"]:$price_ct=0;
        (isset($_POST["price_name"]) && !empty($_POST["price_name"]) && is_numeric($_POST["price_name"]))?$price_name=0+$_POST["price_name"]:$price_name=0;
        (isset($_POST["bonus"]) && !empty($_POST["bonus"]) && is_numeric($_POST["bonus"]))?$bonus=0+$_POST["bonus"]:$bonus=0;
        (isset($_POST["bonus_archive"]) && !empty($_POST["bonus_archive"]) && is_numeric($_POST["bonus_archive"]))?$bonus_archive=0+$_POST["bonus_archive"]:$bonus_archive=0;
        (isset($_POST["archive_enable"]) && $_POST["archive_enable"]=="on") ?$archive_enable="true":$archive_enable="false";
        (isset($_POST["bonus_flslot"]) && !empty($_POST["bonus_flslot"]) && is_numeric($_POST["bonus_flslot"]))?$bonus_flslot=0+$_POST["bonus_flslot"]:$bonus_flslot=0;
        (isset($_POST["flshot_enable"]) && $_POST["flshot_enable"]=="on") ?$flshot_enable="true":$flshot_enable="false";
        (isset($_POST["gb1"]) && !empty($_POST["gb1"]) && is_numeric($_POST["gb1"]))?$gb1=0+$_POST["gb1"]:$gb1=0;
        (isset($_POST["pts1"]) && !empty($_POST["pts1"]) && is_numeric($_POST["pts1"]))?$pts1=0+$_POST["pts1"]:$pts1=0;
        (isset($_POST["gb2"]) && !empty($_POST["gb2"]) && is_numeric($_POST["gb2"]))?$gb2=0+$_POST["gb2"]:$gb2=0;
        (isset($_POST["pts2"]) && !empty($_POST["pts2"]) && is_numeric($_POST["pts2"]))?$pts2=0+$_POST["pts2"]:$pts2=0;
        (isset($_POST["gb3"]) && !empty($_POST["gb3"]) && is_numeric($_POST["gb3"]))?$gb3=0+$_POST["gb3"]:$gb3=0;
        (isset($_POST["pts3"]) && !empty($_POST["pts3"]) && is_numeric($_POST["pts3"]))?$pts3=0+$_POST["pts3"]:$pts3=0;
        (isset($_POST["gb_enable"]) && $_POST["gb_enable"]=="on") ?$gb_enable="true":$gb_enable="false";
        (isset($_POST["vip_enable"]) && $_POST["vip_enable"]=="on") ?$vip_enable="true":$vip_enable="false";
        (isset($_POST["ct_enable"]) && $_POST["ct_enable"]=="on") ?$ct_enable="true":$ct_enable="false";
        (isset($_POST["uname_enable"]) && $_POST["uname_enable"]=="on") ?$uname_enable="true":$uname_enable="false";
        (isset($_POST["inv_enable"]) && $_POST["inv_enable"]=="on" && $btit_settings["fmhack_invitation_system"]=="enabled") ?$inv_enable="true":$inv_enable="false";
        (isset($_POST["inv1"]) && !empty($_POST["inv1"]) && is_numeric($_POST["inv1"]))?$price_inv=0+$_POST["inv1"]:$price_inv=0;
        (isset($_POST["inv3"]) && !empty($_POST["inv3"]) && is_numeric($_POST["inv3"]))?$price_inv3=0+$_POST["inv3"]:$price_inv3=0;
        (isset($_POST["inv5"]) && !empty($_POST["inv5"]) && is_numeric($_POST["inv5"]))?$price_inv5=0+$_POST["inv5"]:$price_inv5=0;
        (isset($_POST["sb_type"]) && $_POST["sb_type"]=="all")?$sb_type="all":$sb_type="one";
        (isset($_POST["upl_enable"]) && $_POST["upl_enable"]=="on") ?$upl_enable="true":$upl_enable="false";
        (isset($_POST["bonus_upl"]) && !empty($_POST["bonus_upl"]) && is_numeric($_POST["bonus_upl"]))?$bonus_upl=0+$_POST["bonus_upl"]:$bonus_upl=0;
        (isset($_POST["bonus_upl_delay"]) && !empty($_POST["bonus_upl_delay"]) && is_numeric($_POST["bonus_upl_delay"]))?$bonus_upl_delay=0+$_POST["bonus_upl_delay"]:$bonus_upl_delay=0;
        (isset($_POST["comm_enable"]) && $_POST["comm_enable"]=="on") ?$comm_enable="true":$comm_enable="false";
        (isset($_POST["bonus_comm"]) && !empty($_POST["bonus_comm"]) && is_numeric($_POST["bonus_comm"]))?$bonus_comm=0+$_POST["bonus_comm"]:$bonus_comm=0;
        (isset($_POST["vip_timeframe"]) && !empty($_POST["vip_timeframe"]) && is_numeric($_POST["vip_timeframe"]))?$vip_timeframe=0+$_POST["vip_timeframe"]:$vip_timeframe=0;
        (isset($_POST["forpost_enable"]) && $_POST["forpost_enable"]=="on") ?$forpost_enable="true":$forpost_enable="false";
        (isset($_POST["bonus_forpost"]) && !empty($_POST["bonus_forpost"]) && is_numeric($_POST["bonus_forpost"]))?$bonus_forpost=0+$_POST["bonus_forpost"]:$bonus_forpost=0;
        (isset($_POST["sb_speed_enable"]) && $_POST["sb_speed_enable"]=="on") ?$sb_speed_enable="true":$sb_speed_enable="false";
        (isset($_POST["bonus_min_uprate"]) && !empty($_POST["bonus_min_uprate"]) && is_numeric($_POST["bonus_min_uprate"]))?$bonus_min_uprate=0+$_POST["bonus_min_uprate"]:$bonus_min_uprate=0;
        (isset($_POST["sb_max_ph_enable"]) && $_POST["sb_max_ph_enable"]=="on") ?$sb_max_ph_enable="true":$sb_max_ph_enable="false";
        (isset($_POST["bonus_max_per_hour"]) && !empty($_POST["bonus_max_per_hour"]) && is_numeric($_POST["bonus_max_per_hour"]))?$bonus_max_per_hour=0+$_POST["bonus_max_per_hour"]:$bonus_max_per_hour=0;
        (isset($_POST["sb_shout_enable"]) && $_POST["sb_shout_enable"]=="on") ?$sb_shout_enable="true":$sb_shout_enable="false";
        (isset($_POST["bonus_make_a_shout"]) && !empty($_POST["bonus_make_a_shout"]) && is_numeric($_POST["bonus_make_a_shout"]))?$bonus_make_a_shout=0+$_POST["bonus_make_a_shout"]:$bonus_make_a_shout=0;
        (isset($_POST["sb_radio_enable"]) && $_POST["sb_radio_enable"]=="on") ?$sb_radio_enable="true":$sb_radio_enable="false";
        (isset($_POST["bonus_listen2radio"]) && !empty($_POST["bonus_listen2radio"]) && is_numeric($_POST["bonus_listen2radio"]))?$bonus_listen2radio=0+$_POST["bonus_listen2radio"]:$bonus_listen2radio=0;
        (isset($_POST["sb_gift_enable"]) && $_POST["sb_gift_enable"]=="on") ?$sb_gift_enable="true":$sb_gift_enable="false";
        (isset($_POST["bonus_giftmax"]) && !empty($_POST["bonus_giftmax"]) && is_numeric($_POST["bonus_giftmax"]))?$bonus_giftmax=0+$_POST["bonus_giftmax"]:$bonus_giftmax=0;
        (isset($_POST["hnr_enable"]) && $_POST["hnr_enable"]=="on") ?$hnr_enable="true":$hnr_enable="false";
        (isset($_POST["price_hnr"]) && !empty($_POST["price_hnr"]) && is_numeric($_POST["price_hnr"]))?$price_hnr=0+$_POST["price_hnr"]:$price_hnr=0;

        $gbinbytes1=$gb1*1024*1024*1024;
        $gbinbytes2=$gb2*1024*1024*1024;
        $gbinbytes3=$gb3*1024*1024*1024;

        do_sqlquery("UPDATE `{$TABLE_PREFIX}settings` SET `value`='$gb_enable' WHERE `key`='gb_enable'",true);
        do_sqlquery("UPDATE `{$TABLE_PREFIX}settings` SET `value`='$vip_enable' WHERE `key`='vip_enable'",true);
        do_sqlquery("UPDATE `{$TABLE_PREFIX}settings` SET `value`='$ct_enable' WHERE `key`='ct_enable'",true);
        do_sqlquery("UPDATE `{$TABLE_PREFIX}settings` SET `value`='$uname_enable' WHERE `key`='uname_enable'",true);
        do_sqlquery("UPDATE `{$TABLE_PREFIX}settings` SET `value`='$inv_enable' WHERE `key`='inv_enable'",true);
        do_sqlquery("UPDATE `{$TABLE_PREFIX}settings` SET `value`='$price_vip' WHERE `key`='price_vip'",true);
        do_sqlquery("UPDATE `{$TABLE_PREFIX}settings` SET `value`='$price_ct' WHERE `key`='price_ct'",true);
        do_sqlquery("UPDATE `{$TABLE_PREFIX}settings` SET `value`='$price_name' WHERE `key`='price_name'",true);
        do_sqlquery("UPDATE `{$TABLE_PREFIX}settings` SET `value`='$bonus' WHERE `key`='bonus'",true);
        do_sqlquery("UPDATE `{$TABLE_PREFIX}settings` SET `value`='$bonus_archive' WHERE `key`='bonus_archive'",true);
        do_sqlquery("UPDATE `{$TABLE_PREFIX}settings` SET `value`='$archive_enable' WHERE `key`='archive_enable'",true);
        do_sqlquery("UPDATE `{$TABLE_PREFIX}settings` SET `value`='$bonus_flslot' WHERE `key`='bonus_flslot'",true);
        do_sqlquery("UPDATE `{$TABLE_PREFIX}settings` SET `value`='$flshot_enable' WHERE `key`='flshot_enable'",true);
        do_sqlquery("UPDATE `{$TABLE_PREFIX}settings` SET `value`='$price_inv' WHERE `key`='price_inv'",true);
        do_sqlquery("UPDATE `{$TABLE_PREFIX}settings` SET `value`='$price_inv3' WHERE `key`='price_inv3'",true);
        do_sqlquery("UPDATE `{$TABLE_PREFIX}settings` SET `value`='$price_inv5' WHERE `key`='price_inv5'",true);
        do_sqlquery("UPDATE `{$TABLE_PREFIX}settings` SET `value`='$sb_type' WHERE `key`='bonus_type'",true);
        do_sqlquery("UPDATE `{$TABLE_PREFIX}settings` SET `value`='$upl_enable' WHERE `key`='upl_enable'",true);
        do_sqlquery("UPDATE `{$TABLE_PREFIX}settings` SET `value`='$bonus_upl' WHERE `key`='bonus_upl'",true);
        do_sqlquery("UPDATE `{$TABLE_PREFIX}settings` SET `value`='$bonus_upl_delay' WHERE `key`='bonus_upl_delay'",true);
        do_sqlquery("UPDATE `{$TABLE_PREFIX}settings` SET `value`='$comm_enable' WHERE `key`='comm_enable'",true);
        do_sqlquery("UPDATE `{$TABLE_PREFIX}settings` SET `value`='$bonus_comm' WHERE `key`='bonus_comm'",true);
        do_sqlquery("UPDATE `{$TABLE_PREFIX}settings` SET `value`='$vip_timeframe' WHERE `key`='vip_timeframe'",true);
        do_sqlquery("UPDATE `{$TABLE_PREFIX}settings` SET `value`='$forpost_enable' WHERE `key`='forpost_enable'",true);
        do_sqlquery("UPDATE `{$TABLE_PREFIX}settings` SET `value`='$bonus_forpost' WHERE `key`='bonus_forpost'",true);
        do_sqlquery("UPDATE `{$TABLE_PREFIX}settings` SET `value`='$sb_speed_enable' WHERE `key`='sb_speed_enable'",true);
        do_sqlquery("UPDATE `{$TABLE_PREFIX}settings` SET `value`='$bonus_min_uprate' WHERE `key`='bonus_min_uprate'",true);
        do_sqlquery("UPDATE `{$TABLE_PREFIX}settings` SET `value`='$sb_max_ph_enable' WHERE `key`='sb_max_ph_enable'",true);
        do_sqlquery("UPDATE `{$TABLE_PREFIX}settings` SET `value`='$bonus_max_per_hour' WHERE `key`='bonus_max_per_hour'",true);
        do_sqlquery("UPDATE `{$TABLE_PREFIX}settings` SET `value`='$sb_shout_enable' WHERE `key`='sb_shout_enable'",true);
        do_sqlquery("UPDATE `{$TABLE_PREFIX}settings` SET `value`='$bonus_make_a_shout' WHERE `key`='bonus_make_a_shout'",true);
        do_sqlquery("UPDATE `{$TABLE_PREFIX}settings` SET `value`='$sb_radio_enable' WHERE `key`='sb_radio_enable'",true);
        do_sqlquery("UPDATE `{$TABLE_PREFIX}settings` SET `value`='$bonus_listen2radio' WHERE `key`='bonus_listen2radio'",true);
        do_sqlquery("UPDATE `{$TABLE_PREFIX}settings` SET `value`='$sb_gift_enable' WHERE `key`='sb_gift_enable'",true);
        do_sqlquery("UPDATE `{$TABLE_PREFIX}settings` SET `value`='$bonus_giftmax' WHERE `key`='bonus_giftmax'",true);
        do_sqlquery("UPDATE `{$TABLE_PREFIX}settings` SET `value`='$price_hnr' WHERE `key`='price_hnr'",true);
        do_sqlquery("UPDATE `{$TABLE_PREFIX}settings` SET `value`='$hnr_enable' WHERE `key`='hnr_enable'",true);
        do_sqlquery("UPDATE `{$TABLE_PREFIX}bonus` SET `points`='$pts1', `gb`='$gb1', `traffic`='$gbinbytes1' WHERE `name`='1'",true);
        do_sqlquery("UPDATE `{$TABLE_PREFIX}bonus` SET `points`='$pts2', `gb`='$gb2', `traffic`='$gbinbytes2' WHERE `name`='2'",true);
        do_sqlquery("UPDATE `{$TABLE_PREFIX}bonus` SET `points`='$pts3', `gb`='$gb3', `traffic`='$gbinbytes3' WHERE `name`='3'",true);

        if(substr($FORUMLINK,0,3)=="smf" && $forpost_enable=="true")
        {
            $petr1=do_sqlquery("SELECT `u`.`id`, `m`.`posts` FROM `{$TABLE_PREFIX}users` `u` INNER JOIN `{$db_prefix}members` `m` ON `u`.`smf_fid`=`m`.".(($FORUMLINK=="smf")?"`ID_MEMBER`":"`id_member`")." WHERE `u`.`smf_postcount`!=`m`.`posts`",true);
            if(@mysqli_num_rows($petr1)>0)
            {
                while($fied=mysqli_fetch_assoc($petr1))
                {
                    do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `smf_postcount`=".$fied["posts"]." WHERE `id`=".$fied["id"],true);
                }
            }
        }
        elseif($FORUMLINK=="ipb" && $forpost_enable=="true")
        {
            $petr1=do_sqlquery("SELECT `u`.`id`, `m`.`posts` FROM `{$TABLE_PREFIX}users` `u` INNER JOIN `{$ipb_prefix}members` `m` ON `u`.`ipb_fid`=`m`.`member_id` WHERE `u`.`ipb_postcount`!=`m`.`posts`",true);
            if(@mysqli_num_rows($petr1)>0)
            {
                while($fied=mysqli_fetch_assoc($petr1))
                {
                    do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `ipb_postcount`=".$fied["posts"]." WHERE `id`=".$fied["id"],true);
                }
            }
        }
        foreach (glob($THIS_BASEPATH."/cache/*.txt") as $filename)
            unlink($filename);
    }
}

?>