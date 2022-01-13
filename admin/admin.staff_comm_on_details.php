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
    (isset($_POST["add_notes"]) && substr($_POST["add_notes"],0,4)=="lro-") ? $staff_comment=$_POST["add_notes"] : $staff_comment=false;
    (isset($_POST["view_notes"]) && substr($_POST["view_notes"],0,4)=="lro-") ? $staff_comment_view=$_POST["view_notes"] : $staff_comment_view=false;
    if($staff_comment && $staff_comment_view)
    {
        $newType1=((is_integer($staff_comment))?array():explode("-", $staff_comment));
        $newType2=((is_integer($staff_comment_view))?array():explode("-", $staff_comment_view));
        if(count($newType1)>0)
        {
            $i=0;
            foreach($newType1 as $value)
            {
                if($i>0)
                {
                    if(!is_integer($value))
                        stderr($language["ERROR"], $language["BAD_DATA"]);
                }
            }
        }
        if(count($newType2)>0)
        {
            $i=0;
            foreach($newType2 as $value)
            {
                if($i>0)
                {
                    if(!is_integer($value))
                        stderr($language["ERROR"], $language["BAD_DATA"]);
                }
            }
        }
        do_sqlquery("UPDATE `{$TABLE_PREFIX}settings` SET `value`='".$staff_comment."' WHERE `key`='staff_comment'", true);
        do_sqlquery("UPDATE `{$TABLE_PREFIX}settings` SET `value`='".$staff_comment_view."' WHERE `key`='staff_comment_view'", true);

        foreach (glob($THIS_BASEPATH."/cache/*.txt") as $filename)
            unlink($filename);
    }
    redirect("index.php?page=admin&user=".$CURUSER["uid"]."&code=".$CURUSER["random"]."&do=scommdet");
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

$curAddType=((is_integer($btit_settings["staff_comment"]))?array():explode("-", $btit_settings["staff_comment"]));
$curViewType=((is_integer($btit_settings["staff_comment_view"]))?array():explode("-", $btit_settings["staff_comment_view"]));

$formSelectAdd="\n<select name='add_notes'>\n<option value='0'".((count($curType)==0 || ($btit_settings["fmhack_logical_rank_ordering"]=="enabled" && count($curType)>0 && $curType[1]==0))?" selected='selected'":"").">---------</option>\n";
$formSelectView="\n<select name='view_notes'>\n<option value='0'".((count($curType)==0 || ($btit_settings["fmhack_logical_rank_ordering"]=="enabled" && count($curType)>0 && $curType[1]==0))?" selected='selected'":"").">---------</option>\n";
foreach($res as $row)
{
    $formSelectAdd.="<option value='lro-".(($btit_settings["fmhack_logical_rank_ordering"]=="enabled")?"1-".$row["logical_rank_order"]:"0-".$row["id_level"])."'".(($btit_settings["staff_comment"]=="lro-".(($btit_settings["fmhack_logical_rank_ordering"]=="enabled")?"1-".$row["logical_rank_order"]:"0-".$row["id_level"])?" selected='selected'":"")).">".$row["level"]."</option>\n";
    $formSelectView.="<option value='lro-".(($btit_settings["fmhack_logical_rank_ordering"]=="enabled")?"1-".$row["logical_rank_order"]:"0-".$row["id_level"])."'".(($btit_settings["staff_comment_view"]=="lro-".(($btit_settings["fmhack_logical_rank_ordering"]=="enabled")?"1-".$row["logical_rank_order"]:"0-".$row["id_level"])?" selected='selected'":"")).">".$row["level"]."</option>\n";
}
$formSelectAdd.="</select>";
$formSelectView.="</select>";

$admintpl->set("uid",$CURUSER["uid"]);
$admintpl->set("random",$CURUSER["random"]);
$admintpl->set("language",$language);
$admintpl->set("add_notes",$formSelectAdd);
$admintpl->set("view_notes",$formSelectView);
$admintpl->set("lro_enabled1", (($btit_settings["fmhack_logical_rank_ordering"]=="enabled")?true:false), true);
$admintpl->set("lro_enabled2", (($btit_settings["fmhack_logical_rank_ordering"]=="enabled")?true:false), true);
?>