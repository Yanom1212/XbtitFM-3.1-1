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

//by CobraCRK 21.07.2006 - www.extremeshare.org - cobracrk@yahoo.com
//converted to xbtit by cooly

if (!defined("IN_BTIT"))
      die("non direct access!");

      
require(load_language("lang_subs.php"));

global $STYLEURL, $CURUSER;

if ($CURUSER["view_torrents"]=="no")
{
    stderr($language["ERROR"],$language["NOT_AUTH_VIEW_NEWS"]);
}

$substpl=new bTemplate();
$substpl->set("language",$language);

if ($CURUSER["can_upload"]=="yes")
{
    $subadd="<br><center><a href='index.php?page=subadd'><img src='images/Add.png' width=30 height=30 alt='Add Subtitle' title='Add Subtitle'></a></center>";
}

$search="<form id='form1' name='form1' method='post' action='index.php?page=subsearch'>
         <div align='center'>
         <input name='src' type='text' size='40' />
         <input type='submit' class=btn name='Submit' value='".$language['SUBSEARCH']."' />
         </div>
         </form>
        ";

require_once ("include/sanitize.php");

if (isset($_GET['id']))
{
    $id=mysqli_real_escape_string($GLOBALS['conn'],strtolower(preg_replace("/[^A-Fa-f0-9]/", "", $_GET["id"])));
    $where="AND `s`.`hash`='$id'";
}

$substpl->set("subadd",$subadd);
$substpl->set("subsearch",$search);

$subres=do_sqlquery("SELECT COUNT(*) from {$TABLE_PREFIX}subtitles where id>0 $where ORDER BY id ASC $limit");

$subnum=mysqli_fetch_row($subres);

$result="";
$num2=$subnum[0];
if($num2==0) { $result=$language['SUBS_EMPTY']; }

$perpage=(max(0,$CURUSER["torrentsperpage"])>0?$CURUSER["torrentsperpage"]:10);

list($pagertop, $pagerbottom, $limit) = pager($perpage, $num2, "index.php?page=subtitles&amp;");

$substpl->set("pagertop",$pagertop);
$substpl->set("pagerbottom",$pagerbottom); 
    
$r=do_sqlquery("SELECT ".(($btit_settings["fmhack_SEO_panel"]=="enabled" && $res_seo["activated"]=="true")?"`f`.`id` `fileid`, `f`.`filename`, ":"")."`s`.`id` `id`, `s`.`name`, `s`.`pic`, `s`.`imdb`, `s`.`author`, `s`.`uploader`, `s`.`file`, `s`.`framerate`, `s`.`cds`, `s`.`downloaded`, `s`.`hash`, `s`.`flag`, `c`.`flagpic`, `c`.`name` `country`, `u`.`username`, ul.prefixcolor, ul.suffixcolor FROM `{$TABLE_PREFIX}subtitles` `s` LEFT JOIN `{$TABLE_PREFIX}countries` `c` ON `s`.`flag`=`c`.`id` LEFT JOIN `{$TABLE_PREFIX}users` `u` ON `s`.`uploader`=`u`.`id` LEFT JOIN `{$TABLE_PREFIX}users_level` `ul` ON `u`.`id_level`=`ul`.`id` ".(($btit_settings["fmhack_SEO_panel"]=="enabled" && $res_seo["activated"]=="true")?"LEFT JOIN `{$TABLE_PREFIX}files` `f` ON `s`.`hash`=`f`.`info_hash` ":"")."WHERE `s`.`id`>0 $where ORDER BY `s`.`id` ASC $limit", true);

$subs=array();
$i=0;

while($row = mysqli_fetch_array($r))
{
    $uploader=stripslashes($row["prefixcolor"].$row["username"].$row["suffixcolor"]);

    if(is_null($row['author'])) 
    {
        $row['author']="Unknown";
    }

    $subs[$i]["id"] = (int)$row["id"];
    $subs[$i]["pic"] = (empty($row["pic"])?"<img src='images/no_subcover.jpg' width='61' height='90' border='0' alt='' />":"<img src='".$row["pic"]."' alt='Subtitles' width='61' height='90' border='0' />");
    $subs[$i]["imdb"] = (empty($row["imdb"])?"":"<a href='".$row["imdb"]."' target='_blank'>".$language["SUB_IMDBT"]."</a>");
    $subs[$i]["flagpic"] = "<img src='images/flag/".$row["flagpic"]."' alt='".$row["country"]."' title='".$row["country"]."'>";
    $subs[$i]["uploader"] = "<a href='".(($btit_settings["fmhack_SEO_panel"]=="enabled" && $res_seo["activated_user"]=="true")?$row["uploader"]."_".strtr($row["username"], $res_seo["str"], $res_seo["strto"]).".html":"index.php?page=userdetails&id=".$row["uploader"])."'>$uploader</a>";
    $subs[$i]["downloaded"] = (int)$row["downloaded"];
    $subs[$i]["framerate"] = (empty($row["framerate"])?"":$language["SUB_FR"].": <b>".$row["framerate"]."</b><br />\n");
    $subs[$i]["cds"] = (empty($row["cds"])?"":$language["SUB_CD"].": <b>".$row["cds"]."</b><br />\n");
    $subs[$i]["author"] = (!empty($row["author"])?$language["SUB_AUTH"].": <b>".$row["author"]."</b><br />\n":"");
    $subs[$i]["details"] = "<a href='".(($btit_settings["fmhack_SEO_panel"]=="enabled" && $res_seo["activated"]=="true")?strtr($row["filename"], $res_seo["str"], $res_seo["strto"])."-".$row["fileid"].".html":"index.php?page=torrent-details&id=".$row["hash"])."'>".$language["TORRENT_DETAIL"]."</a><br />\n";
    $subs[$i]["dl"] = "<a href='subtitle_download.php?id=".$row["id"]."'>".$row["name"]."&nbsp; <img src='images/download.gif' alt='download' title='download'></a>";
    if($CURUSER["edit_torrents"]=="yes")
    { 
        $subs[$i][del] = "<a href='subtitle_del.php?do=del&id=".$row["id"]."'><img src='".$STYLEURL."/images/delete.png' alt='delete' title='delete'></a>";
    }
    if($CURUSER==$row["uploader"] || $CURUSER["edit_torrents"]=="yes")
    { 
        $subs[$i][ed] = "<a href='index.php?page=subedit&action=edit&id=".$row["id"]."'><img src='".$STYLEURL."/images/edit.png' alt='delete' title='edit'></a>";
    }
    $i++;
}

$substpl->set("subs",$subs);
$substpl->set("subadd",$subadd);
$substpl->set("tds",$tds);
$substpl->set("result",$result);

//by CobraCRK 21.07.2006 - www.extremeshare.org - cobracrk@yahoo.com
//converted to xbtit by cooly
?>