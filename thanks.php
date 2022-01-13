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

if ((isset($_POST["infohash"]))&&(!empty($_POST["infohash"])))
{   
    $_POST["infohash"]=str_replace("'","",$_POST["infohash"]);
    $THIS_BASEPATH=dirname(__FILE__);
    require("$THIS_BASEPATH/include/functions.php");
    include(load_language("lang_torrents.php"));
    dbconn();

    if($btit_settings["fmhack_SEO_panel"]=="enabled")
    {
        $active_seo_thanks = get_result("SELECT `activated_user`, `str`, `strto` FROM `{$TABLE_PREFIX}seo` WHERE `id`='1'", true, $btit_settings["cache_duration"]);
        $res_seo_thanks=$active_seo_thanks[0];
    }

    $uid = intval(0+$CURUSER['uid']);
    if(preg_match("/([a-z0-9]{40})/",$_POST['infohash']))
    {
        $infohash=stripslashes($_POST["infohash"]);
    }
    else
    {
        die('Hacking Attempt!');
    }

    $out="";
    $rt=get_result("SELECT `uploader` FROM `{$TABLE_PREFIX}files` WHERE `info_hash`='".$infohash."' AND `uploader`=".$uid, true, $btit_settings["cache_duration"]);
    // he's not the uploader
    if (count($rt)==0)
       $button=true;
    else
       $button=false;

    // saying thank you.
    if (isset($_POST["thanks"]) && $button)
    {
        $rt=get_result("SELECT `userid` FROM `{$TABLE_PREFIX}files_thanks` WHERE `userid`=$uid AND `infohash`='".$infohash."'", true);
        // never thanks for this file
        if (count($rt)==0)
        {
           quickQuery("INSERT INTO `{$TABLE_PREFIX}files_thanks` (`infohash`, `userid`) VALUES ('".$infohash."', $uid)");
    // DT reputation system start
    $reput=do_sqlquery("SELECT * FROM {$TABLE_PREFIX}reputation_settings WHERE id =1");
    $setrep=mysqli_fetch_array($reput);

    $plus= $setrep["rep_userrates"];

    if ($setrep["rep_is_online"]== 'false')
    {
    //do nothing
    }
    else
    {
     @do_sqlquery("UPDATE {$TABLE_PREFIX}users SET reputation = reputation + '$plus' WHERE id='$uid'");
    }
    // DT reputation system end
        }
    }

    $rt=get_result("SELECT `u`.`id`, `u`.`username`, `ul`.`prefixcolor`, `ul`.`suffixcolor` FROM `{$TABLE_PREFIX}files_thanks` `t` LEFT JOIN `{$TABLE_PREFIX}users` `u` ON `u`.`id`=`t`.`userid` LEFT JOIN `{$TABLE_PREFIX}users_level` `ul` ON `u`.`id_level`=`ul`.`id` WHERE `infohash`='".$infohash."'", true, $btit_settings["cache_duration"]);
    if (count($rt)==0)
       $out=$language["THANKS_BE_FIRST"];

    foreach($rt as $ty)
    {
        if ($ty["id"]==$uid) // already thank
            $button=false;
        $out.="<a href=\"$BASEURL/".(($btit_settings["fmhack_SEO_panel"]=="enabled" && $res_seo_thanks["activated_user"]=="true")?$ty["id"]."_".strtr($ty["username"], $res_seo["str"], $res_seo["strto"]).".html":"index.php?page=userdetails&id=".$ty["id"])."\">".unesc($ty["prefixcolor"].$ty["username"].$ty["suffixcolor"])."</a> ";
    }
    if ($button && $CURUSER["uid"]>1)
       $out.="|0";
    else
       $out.="|1";

}
else
    $out= "no direct access!";

echo $out;
die;

?>