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
    (isset($_POST["min_bet"]) && substr($_POST["min_bet"],0,4)=="lro-") ? $min_bet=$_POST["min_bet"] : $min_bet=false;
    (isset($_POST["fid_bet"]) && is_numeric($_POST["fid_bet"]) && $_POST["fid_bet"]>0) ? $fid_bet=(int)0+$_POST["fid_bet"] : $fid_bet=1;
    (isset($_POST["max_bon_bet"]) && is_numeric($_POST["max_bon_bet"]) && $_POST["max_bon_bet"]>0) ? $max_bon_bet=(int)0+$_POST["max_bon_bet"] : $max_bon_bet=200;
    (isset($_POST["fid_bet_user"]) && is_numeric($_POST["fid_bet_user"]) && $_POST["fid_bet_user"]>0) ? $fid_bet_user=(int)0+$_POST["fid_bet_user"] : $fid_bet_user=0;
    if($min_bet)
    {
        $newType=((is_integer($min_bet))?array():explode("-", $min_bet));
        if(count($newType)>0)
        {
            $i=0;
            foreach($newType as $value)
            {
                if($i>0)
                {
                    if(!is_integer($value))
                        stderr($language["ERROR"], $language["BAD_DATA"]);
                }
            }
        }
        do_sqlquery("UPDATE `{$TABLE_PREFIX}settings` SET `value`='".$min_bet."' WHERE `key`='min_bet'", true);
        do_sqlquery("UPDATE `{$TABLE_PREFIX}settings` SET `value`='".$fid_bet."' WHERE `key`='fid_bet'", true);
        do_sqlquery("UPDATE `{$TABLE_PREFIX}settings` SET `value`='".$max_bon_bet."' WHERE `key`='max_bon_bet'", true);
        do_sqlquery("UPDATE `{$TABLE_PREFIX}settings` SET `value`='".$fid_bet_user."' WHERE `key`='fid_bet_user'", true);

        foreach (glob($THIS_BASEPATH."/cache/*.txt") as $filename)
            unlink($filename);
    }
    redirect("index.php?page=admin&user=".$CURUSER["uid"]."&code=".$CURUSER["random"]."&do=sport_bet");
}

$res=get_result("SELECT `id_level`, `level`, `logical_rank_order` FROM `{$TABLE_PREFIX}users_level` ".(($btit_settings["fmhack_logical_rank_ordering"]=="enabled")?"":"WHERE `id`>=1 AND `id`<=8")." ORDER BY ".(($btit_settings["fmhack_logical_rank_ordering"]=="enabled")?"`logical_rank_order`":"`id_level`")."  ASC", true, $btit_settings["cache_duration"]);
if($btit_settings["fmhack_logical_rank_ordering"]=="enabled")
{
    $test_lro=array();
    foreach($res as $row)
    {
        if(!isset($test_lro[$row["logical_rank_order"]]))
            $test_lro[$row["logical_rank_order"]]=1;
        else
        {
            stderr($language["ERROR"], $language["LRO_ERR_BLOCK"]." <a href='index.php?page=admin&user=".$CURUSER["uid"]."&code=".$CURUSER["random"]."&do=groups&action=read'>".$language["HERE"]."</a>.");
            break;
        }
    }
}

$curType=((is_integer($btit_settings["min_bet"]))?array():explode("-", $btit_settings["min_bet"]));

$formSelect="\n<select name='min_bet'>\n<option value='0'".((count($curType)==0 || ($btit_settings["fmhack_logical_rank_ordering"]=="enabled" && count($curType)>0 && $curType[1]==0))?" selected='selected'":"").">---------</option>\n";

foreach($res as $row)
{
    $formSelect.="<option value='lro-".(($btit_settings["fmhack_logical_rank_ordering"]=="enabled")?"1-".$row["logical_rank_order"]:"0-".$row["id_level"])."'".(($btit_settings["min_bet"]=="lro-".(($btit_settings["fmhack_logical_rank_ordering"]=="enabled")?"1-".$row["logical_rank_order"]:"0-".$row["id_level"])?" selected='selected'":"")).">".$row["level"]."</option>\n";
}
$formSelect.="</select>";

$admintpl->set("uid",$CURUSER["uid"]);
$admintpl->set("random",$CURUSER["random"]);
$admintpl->set("language",$language);
$admintpl->set("config", $btit_settings);
$admintpl->set("formSelect", $formSelect);

?>