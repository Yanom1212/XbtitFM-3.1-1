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

$scriptname = htmlspecialchars($_SERVER["PHP_SELF"]."?page=torrents");
$addparam = "";
if($btit_settings["fmhack_display_new_torrents_since_last_Visit"] == "enabled")
{
    if(!isset($_COOKIE['lastseen']))
    {
        $time = date("YmdHis");
        setcookie('lastseen', $time, time() + 60 * 60 * 24 * 30, '/', false, 0);
    }
}
if($XBTT_USE)
{
    $tseeds = "`f`.`seeds`+ifnull(`x`.`seeders`,0)";
    $tleechs = "`f`.`leechers`+ifnull(`x`.`leechers`,0)";
    $tcompletes = "`f`.`finished`+ifnull(`x`.`completed`,0)";
    $ttables = "`{$TABLE_PREFIX}files` `f` LEFT JOIN `xbt_files` `x` ON `x`.`info_hash`=`f`.`bin_hash`";
}
else
{
    $tseeds = "`f`.`seeds`";
    $tleechs = "`f`.`leechers`";
    $tcompletes = "`f`.`finished`";
    $ttables = "`{$TABLE_PREFIX}files` `f`";
}
if(!$CURUSER || $CURUSER["view_torrents"] != "yes")
    stderr($language["ERROR"], $language["NOT_AUTHORIZED"]." ".$language["MNU_TORRENT"]."!<br />\n".$language["SORRY"]."...");
if($btit_settings["fmhack_archive_torrents"] == "enabled" && $CURUSER["view_new"] == "no" && $CURUSER["view_arc"] == "no")
    stderr($language["ERROR"], $language["NOT_AUTHORIZED"]." ".$language["MNU_TORRENT"]."!<br />\n".$language["SORRY"]."...");
if(isset($_GET["search"]))
{
    $trova = htmlspecialchars(str_replace("+", " ", $_GET["search"]));
}
else
{
    $trova = "";
}
if($btit_settings["fmhack_multi_delete_torrents"]=="enabled" || $btit_settings["fmhack_sticky_torrent"] == "enabled")
{
$op=isset($_POST["operation"])?0+intval($_POST["operation"]):$op='';
switch($op)
{
case 1: 
    $owntor=0;
    $do = isset($_GET["do"])?htmlspecialchars($_GET["do"]):$do='zilch';
    if ($do=="del" && $_SERVER["REQUEST_METHOD"]=="POST")
    {        
        foreach($_POST["msg"] as $msg)
        {
            $msg=preg_replace("/[^A-Fa-f0-9]/", "", $msg);
            if(strlen($msg)==40)
            {
                $filename=get_result("SELECT filename, uploader FROM {$TABLE_PREFIX}files WHERE info_hash=\"$msg\" LIMIT 1");
                // check user's permission
        		$uploader_allowed=(($CURUSER["uid"]>1 && $CURUSER["uid"]==$filename[0]["uploader"])?"yes":"no");
                if($btit_settings["fmhack_uploader_rights"]=="enabled" && $uploader_allowed=="yes" && $btit_settings["ulri_delete"]=="no")
                    $uploader_allowed="no";
                if ($uploader_allowed=="yes" || $CURUSER["delete_torrents"]=="yes")
                {
                    write_log("Deleted torrent ".unesc($filename[0]["filename"])." ($msg)","delete");
                    quickQuery("DELETE FROM {$TABLE_PREFIX}files WHERE info_hash=\"$msg\"");
                    quickQuery("DELETE FROM {$TABLE_PREFIX}timestamps WHERE info_hash=\"$msg\"");
                    quickQuery("DELETE FROM {$TABLE_PREFIX}comments WHERE info_hash=\"$msg\"");
                    quickQuery("DELETE FROM {$TABLE_PREFIX}ratings WHERE infohash=\"$msg\"");
                    quickQuery("DELETE FROM {$TABLE_PREFIX}peers WHERE infohash=\"$msg\"");
                    quickQuery("DELETE FROM {$TABLE_PREFIX}history WHERE infohash=\"$msg\"");
                    if ($XBTT_USE)
                        do_sqlquery("UPDATE xbt_files SET flags=1 WHERE info_hash=UNHEX('$msg')",true);
    
                    unlink($TORRENTSDIR."/$msg.btf");
                    
                }
            }
        }
    }
break;
case 2:
    
    $stickyList="";
    if(isset($_POST)&& !empty($_POST))
    {
        foreach($_POST["msg"] as $msg)
        {
     
         do_sqlquery("UPDATE `{$TABLE_PREFIX}files` SET `sticky`='1' WHERE `info_hash` IN ('".$msg."')",true);

            
        }

    }
    
        
break;
case 3:
    
    $stickyList="";
    if(isset($_POST)&& !empty($_POST))
    {
        foreach($_POST["msg"] as $msg)
        {

         do_sqlquery("UPDATE `{$TABLE_PREFIX}files` SET `sticky`='0' WHERE `info_hash` IN ('".$msg."')",true);

            
        }

    }
    
        
break;
}
}
$category = (!isset($_GET["category"])?0:explode(";", $_GET["category"]));
// sanitize categories id
if(is_array($category))
    $category = array_map("intval", $category);
else
    $category = 0;
if($btit_settings["fmhack_search_all_sub-categories"] == "enabled")
    $combo_categories = categories($category);
else
    $combo_categories = categories($category[0]);
//uploader
$uploader = (!isset($_GET["uploader"])?0:explode(";",$_GET["uploader"]));
if (is_array($uploader))
    $uploader = array_map("intval",$uploader);
else
    $uploader = 0;

$combo_uploader=uploader( $uploader[0] );
                    
(isset($_GET["active"]) && is_numeric($_GET["active"]) && $_GET["active"] >= 0 && $_GET["active"] <= 5)?$active = intval($_GET["active"]):$active = 0;
$download_locked=false;
if($btit_settings["fmhack_archive_torrents"] == "enabled")
{
    if($active < 3 && $CURUSER["view_new"] == "no" && $CURUSER["view_arc"] == "yes")
        $active = 3;
    elseif($active > 2 && $CURUSER["view_new"] == "yes" && $CURUSER["view_arc"] == "no")
        $active = 0;
    if($CURUSER["down_new"]=="no" && $active>=0 && $active<=2)
        $download_locked=true;
    elseif($CURUSER["down_arc"]=="no" && $active>=3 && $active<=5)
        $download_locked=true;
}
if($btit_settings["fmhack_download_requires_introduction"] == "enabled" && !$download_locked)
{
    if($CURUSER["down_req_intro"]=="yes" && $CURUSER["made_intro"]==0)
        $download_locked=true;
}
// start advanced search hack DT
if($btit_settings["fmhack_advanced_torrent_search"] == "enabled")
{
    if(isset($_GET["options"]))
        $options = intval($_GET["options"]);
    else
        $options = 0;
}
// end advanced search hack DT
if($active == 0 || ($btit_settings["fmhack_archive_torrents"] == "enabled" && $active == 3))
{
    $where = " WHERE 1=1".(($btit_settings["fmhack_archive_torrents"] == "enabled" && $active == 0)?" AND `f`.`archive`=0":(($btit_settings["fmhack_archive_torrents"] == "enabled" && $active == 3)?
        " AND archive=1":""));
    $addparam .= "active=".$active;
} // active only
elseif($active == 1 || ($btit_settings["fmhack_archive_torrents"] == "enabled" && $active == 4))
{
    $where = " WHERE $tleechs+$tseeds > 0".(($btit_settings["fmhack_archive_torrents"] == "enabled" && $active == 1)?" AND `f`.`archive`=0":(($btit_settings["fmhack_archive_torrents"] == "enabled" && $active ==
        4)?" AND archive=1":""));
    $addparam .= "active=".$active;
} // dead only
elseif($active == 2 || ($btit_settings["fmhack_archive_torrents"] == "enabled" && $active == 5))
{
    $where = " WHERE $tleechs+$tseeds = 0".(($btit_settings["fmhack_archive_torrents"] == "enabled" && $active == 2)?" AND `f`.`archive`=0":(($btit_settings["fmhack_archive_torrents"] == "enabled" && $active ==
        5)?" AND archive=1":""));
    $addparam .= "active=".$active;
}
else
{
    $where = " WHERE 1=1";
    $addparam .= "active=0";
}
/* Rewrite, part 1: encode "WHERE" statement only. */
// selezione categoria
if($category[0] > 0)
{
    $where .= " AND category IN (".implode(",", $category).")"; // . $_GET["category"];
    $addparam .= "&amp;category=".implode(";", $category); // . $_GET["category"];
}

if ($uploader[0]>0) {
   $where .= " AND uploader IN (".implode(",",$uploader).")"; // . $_GET["category"];
   $addparam.="&amp;uploader=".implode(";",$uploader); // . $_GET["category"];
}
// Search
if(isset($_GET["search"]))
{
    $testocercato = trim($_GET["search"]);
    $testocercato = explode(" ", $testocercato);
    if($_GET["search"] != "")
        $search = "search=".implode("+", $testocercato);
    for($k = 0; $k < count($testocercato); $k++)
    {
        if($btit_settings["fmhack_advanced_torrent_search"] == "enabled")
        {
            // start advanced search hack DT
            if($options == 0)
                $query_select .= " `f`.`filename` LIKE '%".mysqli_real_escape_string($GLOBALS['conn'],$testocercato[$k])."%'";
            elseif($options == 5)
            {
                $query_select .= " `f`.`gold` ='2'";
            }
            elseif($options == 6)
            {
                $query_select .= " `f`.`gold` ='1'";
            }
            elseif($options == 7)
            {
                $query_select .= " `f`.`gold` ='3'";
            }
            elseif($options == 8)
            {
                $query_select .= " `f`.`multiplier` ='1'";
            }
            elseif($options == 9)
            {
                $query_select .= " `f`.`multiplier` ='2'";
            }
            elseif($options == 10)
            {
                $query_select .= " `f`.`multiplier` ='3'";
            }
            elseif($options == 11)
            {
                $query_select .= " `f`.`multiplier` ='4'";
            }
            elseif($options == 12)
            {
                $query_select .= " `f`.`multiplier` ='5'";
            }
            elseif($options == 13)
            {
                $query_select .= " `f`.`multiplier` ='6'";
            }
            elseif($options == 14)
            {
                $query_select .= " `f`.`multiplier` ='7'";
            }
            elseif($options == 15)
            {
                $query_select .= " `f`.`multiplier` ='8'";
            }
            elseif($options == 16)
            {
                $query_select .= " `f`.`multiplier` ='9'";
            }
            elseif($options == 17)
            {
                $query_select .= " `f`.`multiplier` ='10'";
            }
            elseif($options == 18)
            {
                $query_select .= " `f`.`genre` LIKE '%".mysqli_real_escape_string($GLOBALS['conn'],$testocercato[$k])."%'";
            }
            elseif($options == 4)
            {
                $testocercato[$k] = str_replace("http://www.imdb.com/title/tt", "", $testocercato[$k]);
                $testocercato[$k] = str_replace("/", "", $testocercato[$k]);
                $query_select .= " `f`.`imdb` LIKE '%".mysqli_real_escape_string($GLOBALS['conn'],$testocercato[$k])."%'";
            }
            elseif($options == 3)
            {
                $upll = do_sqlquery("SELECT id FROM {$TABLE_PREFIX}users WHERE username ='".$testocercato[$k]."'");
                $oplls = mysqli_fetch_array($upll);
                $userup = ($oplls["id"] > 0?(int)$oplls["id"]:$userup = 0);
                $query_select .= " `f`.`uploader`=".mysqli_real_escape_string($GLOBALS['conn'],$userup)."";
                $query_select .= " AND `f`.`anonymous`='false'";
            }
            elseif($options == 1)
            {
                $query_select .= " (`f`.`filename` LIKE '%".mysqli_real_escape_string($GLOBALS['conn'],$testocercato[$k])."%'";
                $query_select .= " OR `f`.`comment` LIKE '%".mysqli_real_escape_string($GLOBALS['conn'],$testocercato[$k])."%')";
            }
            elseif($options == 2)
                $query_select .= " `f`.`comment` LIKE '%".mysqli_real_escape_string($GLOBALS['conn'],$testocercato[$k])."%'";
            // end advanced search hack DT
        }
        else
            $query_select .= " `f`.`filename` LIKE '%".mysqli_real_escape_string($GLOBALS['conn'],$testocercato[$k])."%'";
        if($k < count($testocercato) - 1)
            $query_select .= " AND ";
    }
    $where .= " AND ".$query_select;
    if($btit_settings["fmhack_show_or_hide_porn"] == "enabled")
    {
        if($CURUSER["showporn"] == 'no')
        {
            $where .= " AND `f`.`category` NOT IN(".$btit_settings["porncat"].") ";
        }
    }
    if($btit_settings["fmhack_default_cat_browse"]=="enabled")
    {
        if(!empty($CURUSER["catins"]))
        {
            $where.= " AND `f`.`category` IN(".$CURUSER["catins"].") ";
        }
    }
}
// end search
if($btit_settings["fmhack_teams"] == "enabled")
{
    if($btit_settings["team_state"] == "private")
    {
        $where .= " AND (".$CURUSER['team']." = `f`.`team` OR `f`.`team` = 0 OR '".$CURUSER['all_teams']."'='yes' OR '".$CURUSER['sel_team']."'=`f`.`team`) ";
    }
}
// torrents count...
$res = get_result("SELECT COUNT(*) as torrents FROM $ttables $where", true, $btit_settings['cache_duration']);
$count = $res[0]["torrents"];
if(!isset($search))
    $search = "search=";
if($count > 0)
{
    if($addparam != "")
    {
        $addparam .= "&amp;".$search."&amp;";
    }
    else
    {
        $addparam .= $search."&amp;";
    }
    $torrentperpage = intval($CURUSER["torrentsperpage"]);
    if($torrentperpage == 0)
        $torrentperpage = ($ntorrents == 0?15:$ntorrents);
    // getting order
    $order_param = 3;
    if(isset($_GET["order"]))
    {
        $order_param = (int)$_GET["order"];
        switch($order_param)
        {
            case 1:
                $order = "cname";
                break;
            case 2:
                $order = "filename";
                break;
            case 3:
                $order = (($btit_settings["fmhack_bump_torrents"] == "enabled")?"bumpdate":"data");
                break;
            case 4:
                $order = "size";
                break;
            case 5:
                $order = "seeds";
                break;
            case 6:
                $order = "leechers";
                break;
            case 7:
                $order = "finished";
                break;
            case 8:
                $order = "dwned";
                break;
            case 9:
                $order = "speed";
                break;
            default:
                $order = (($btit_settings["fmhack_bump_torrents"] == "enabled")?"bumpdate":"data");
        }
    }
    else
        $order = (($btit_settings["fmhack_bump_torrents"] == "enabled")?"bumpdate":"data");
    $qry_order = str_replace(array(
        "leechers",
        "seeds",
        "finished"), array(
        $tleechs,
        $tseeds,
        $tcompletes), $order);
    $by_param = 2;
    if(isset($_GET["by"]))
    {
        $by_param = (int)$_GET["by"];
        $by = ($by_param == 1?"ASC":"DESC");
    }
    else
        $by = "DESC";
    list($pagertop, $pagerbottom, $limit) = pager($torrentperpage, $count, $scriptname."&amp;".$addparam.(strlen($addparam) > 0?"&amp;":"").(($btit_settings["fmhack_advanced_torrent_search"] == "enabled")?
        "options=".$options:"")."&amp;order=$order_param&amp;by=$by_param&amp;");
      if ($XBTT_USE)
    $rowcat = do_sqlquery("SELECT u.id, (u.downloaded+IFNULL(x.downloaded,0)) as downloaded, ((u.uploaded+IFNULL(x.uploaded,0))/(u.downloaded+IFNULL(x.downloaded,0))) as uratio, cp.* FROM {$TABLE_PREFIX}users u LEFT JOIN xbt_users x ON x.uid=u.id INNER JOIN {$TABLE_PREFIX}categories_perm cp ON u.id_level=cp.levelid WHERE u.id = ".$CURUSER["uid"].";",true);
  else
    $rowcat = do_sqlquery("SELECT u.id, u.downloaded, (u.uploaded/u.downloaded) as uratio, cp.* FROM {$TABLE_PREFIX}users u INNER JOIN {$TABLE_PREFIX}categories_perm cp ON u.id_level=cp.levelid WHERE u.id = ".$CURUSER["uid"].";",true);
  if (mysqli_num_rows($rowcat)>0)
     while ($catdata=mysqli_fetch_array($rowcat))
             if($catdata["viewtorrlist"]!="yes" && (($catdata["downloaded"]>=$GLOBALS["download_ratio"] && ($catdata["ratio"]>$catdata["uratio"]))||($catdata["downloaded"]<$GLOBALS["download_ratio"])||($catdata["ratio"]=="0")))
                $where.=' AND f.category!='.$catdata[catid];
                
    /*Mod by losmi - gold mod*/
    $query1_select = "`f`.`anonymous`,";
    $query1_order = "";
    $query1_join = "";
    $query1_and = "";
    $query1_group = "";
    if($btit_settings["fmhack_gold_and_silver_torrents"] == "enabled")
        $query1_select .= "`f`.`gold`,";
    if($btit_settings["fmhack_free_leech_with_happy_hour"] == "enabled")
        $query1_select .= "`f`.`free`,";
    if($btit_settings["fmhack_show_if_seedbox_is_used"] == "enabled")
        $query1_select .= "`f`.`seedbox`,";
    if($btit_settings["fmhack_sticky_torrent"] == "enabled")
    {
        $query1_select .= "`f`.`sticky`,";
        $query1_order .= " `f`.`sticky` DESC,";
    }
    if($btit_settings["fmhack_subtitles"] == "enabled")
    {
        $query1_select .= "`s`.`hash` `shash`,";
        $query1_join .= "LEFT JOIN `{$TABLE_PREFIX}subtitles` `s` ON `f`.`info_hash`=`s`.`hash` ";
        $query1_group .= "GROUP BY `f`.`info_hash` "; //stop major loop
    }
    if($btit_settings["fmhack_torrent_nuked_and_requested"] == "enabled")
        $query1_select .= "`f`.`requested`, `f`.`nuked`, `f`.`nuke_reason`,";
    if($btit_settings["fmhack_torrent_moderation"] == "enabled")
    {
        if($btit_settings["mod_app_sa"] == "yes" && $CURUSER["admin_access"] == "yes")
        {
            $query1_select .= "`u2`.`username` `approved_by`,";
            $query1_join .= "LEFT JOIN `{$TABLE_PREFIX}users` `u2` ON `f`.`approved_by`=`u2`.`id` ";
        }
        $query1_and .= "AND f.moder='ok' ";
    }
    if($btit_settings["fmhack_balloons_on_mouseover"] == "enabled")
        $query1_select .= "`f`.`image` `img`,";
    if($btit_settings["fmhack_teams"] == "enabled")
    {
        $query1_select .= "`u`.`team` `userteam`, `t`.`id` `teamsid`, `t`.`name` `teamname`, `t`.`image` `teamimage`, `f`.`team`,";
        $query1_join .= "LEFT JOIN `{$TABLE_PREFIX}teams` `t` ON `f`.`team` = `t`.`id` ";
        if($btit_settings["team_state"] == "private")
        {
            $query1_and .= "AND (".$CURUSER['team']." = `f`.`team` OR `f`.`team` = 0 OR '".$CURUSER['all_teams']."'='yes' OR '".$CURUSER['sel_team']."'=`f`.`team`) ";
        }
    }
    if($btit_settings["fmhack_upload_multiplier"] == "enabled" && $CURUSER["view_multi"] == "yes")
        $query1_select .= "`f`.`multiplier`,";
    else
        $query1_and .= "AND `f`.`multiplier`=1 ";
    //imdb rating
    if($btit_settings["fmhack_getIMDB_in_torrent_details"] == "enabled")
    {
        $query1_select .= "`f`.`imdb`,f.`genre`,";
    }
    if($btit_settings["fmhack_recommended_torrents"] == "enabled")
    {
        $query1_select .= "`r`.`id` `recommended`,";
        $query1_join .= "LEFT JOIN `{$TABLE_PREFIX}recommended` `r` ON `f`.`info_hash` = `r`.`info_hash` ";
    }
    if($btit_settings["fmhack_SEO_panel"] == "enabled" || $btit_settings["fmhack_sticky_torrent"] == "enabled")
    {
        $query1_select .= "`f`.`id` `seoid`,";
    }
    if($btit_settings["fmhack_language_in_torrent_list_and_details"] == "enabled")
    {
        $query1_select .= "`f`.`language`,";
    }
    if($btit_settings["fmhack_show_or_hide_porn"] == "enabled")
    {
        if($CURUSER["showporn"] == 'no')
        {
            $query1_and .= "AND `f`.`category` NOT IN(".$btit_settings["porncat"].") ";
        }
    }
    if($btit_settings["fmhack_downloaded_torrents"] == "enabled")
    {
        $query1_select.="IF(`d`.`id` IS NULL, 'no', 'yes') `has_downloaded`,";
        $query1_join .= "LEFT JOIN `{$TABLE_PREFIX}down_load` `d` ON (`f`.`info_hash`=`d`.`hash` AND `d`.`pid`='".$CURUSER["pid"]."') ";
    }
    if($btit_settings["fmhack_torrent_activity_colouring"]=="enabled")
    {
        if($XBTT_USE)
        {
            $query1_select.="`xfu`.`left` `have_left`, `xfu`.`active` `is_active`,";
            $query1_join.="LEFT JOIN `xbt_files_users` `xfu` ON (`xfu`.`fid`=`x`.`fid` AND `xfu`.`uid`=".$CURUSER["uid"].") ";
        }
        else
        {
            $query1_select.="`p`.`status` `seeder_status`,";
            $query1_join.="LEFT JOIN `{$TABLE_PREFIX}peers` `p` ON (`p`.`infohash`=`f`.`info_hash` AND `p`.`pid`='".$CURUSER["pid"]."') ";
        }
    }
    if($btit_settings["fmhack_grab_images_from_theTVDB"] == "enabled")
        $query1_select .= "`f`.`tvdb_id`,";
    if($btit_settings["fmhack_magnet_links"] == "enabled")
        $query1_select.="`f`.`magnet`,";
    $query = "SELECT ".$query1_select." `f`.`info_hash` `hash`, $tseeds `seeds`, $tleechs `leechers`, $tcompletes `finished`,  `f`.`dlbytes` `dwned` , IFNULL(`f`.`filename`,'') `filename`, `f`.`url`, `f`.`info`, `f`.`anonymous`, `f`.`speed`, UNIX_TIMESTAMP(`f`.`data`) `added`, `c`.`image`, `c`.`name` `cname`, `f`.`category` `catid`, `f`.`size`, `f`.`external`, `f`.`uploader` `upname`, `u`.`username` `uploader`, `prefixcolor`, `suffixcolor` FROM $ttables LEFT JOIN `{$TABLE_PREFIX}categories` `c` ON `c`.`id` = `f`.`category` LEFT JOIN `{$TABLE_PREFIX}users` `u` ON `u`.`id` = `f`.`uploader` LEFT JOIN `{$TABLE_PREFIX}users_level` `ul` ON `u`.`id_level`=`ul`.`id` $query1_join $where $query1_and $query1_group ORDER BY ".
        $query1_order." $qry_order $by $limit";

    $results = get_result($query, true, $btit_settings['cache_duration']);
}
if($by == "ASC")
    $mark = "&nbsp;&uarr;";
else
    $mark = "&nbsp;&darr;";
// load language file
require (load_language("lang_torrents.php"));
$torrenttpl = new bTemplate();
$torrenttpl->set("arc_enabled", (($btit_settings["fmhack_archive_torrents"] == "enabled" && ($CURUSER["view_new"] == "yes" || $CURUSER["view_arc"] == "yes"))?true:false), true);
$torrenttpl->set("new_allowed1", (($btit_settings["fmhack_archive_torrents"] == "enabled" && $CURUSER["view_new"] == "yes")?true:false), true);
$torrenttpl->set("new_allowed2", (($btit_settings["fmhack_archive_torrents"] == "enabled" && $CURUSER["view_new"] == "yes")?true:false), true);
$torrenttpl->set("new_allowed3", (($btit_settings["fmhack_archive_torrents"] == "enabled" && $CURUSER["view_new"] == "yes")?true:false), true);
$torrenttpl->set("arc_allowed1", (($btit_settings["fmhack_archive_torrents"] == "enabled" && $CURUSER["view_arc"] == "yes")?true:false), true);
$torrenttpl->set("arc_allowed2", (($btit_settings["fmhack_archive_torrents"] == "enabled" && $CURUSER["view_arc"] == "yes")?true:false), true);
$torrenttpl->set("arc_allowed3", (($btit_settings["fmhack_archive_torrents"] == "enabled" && $CURUSER["view_arc"] == "yes")?true:false), true);
$torrenttpl->set("media_enabled", (($btit_settings["fmhack_torrent_details_media_player"] == "enabled")?true:false), true);
$torrenttpl->set("language", $language);
$torrenttpl->set("torrent_script", "index.php");
$torrenttpl->set("torrent_search", $trova);
$torrenttpl->set("torrent_categories_combo", $combo_categories);
$torrenttpl->set("torrent_uploader_combo",$combo_uploader);
$torrenttpl->set("torrent_selected_all", ($active == 0?"selected=\"selected\"":""));
$torrenttpl->set("torrent_selected_active", ($active == 1?"selected=\"selected\"":""));
$torrenttpl->set("torrent_selected_dead", ($active == 2?"selected=\"selected\"":""));
if($btit_settings["fmhack_archive_torrents"] == "enabled")
{
    $torrenttpl->set("torrent_selected_all2", ($active == 3?"selected=\"selected\"":""));
    $torrenttpl->set("torrent_selected_active2", ($active == 4?"selected=\"selected\"":""));
    $torrenttpl->set("torrent_selected_dead2", ($active == 5?"selected=\"selected\"":""));
}
$torrenttpl->set("torrent_pagertop", $pagertop);
if($btit_settings["fmhack_display_new_torrents_since_last_Visit"] == "enabled")
{
    if(isset($_COOKIE['lastseen']))
    {
        $time = date("YmdHis");
        setcookie('lastseen', $time, time() + 60 * 60 * 24 * 30, '/', false, 0);
    }
}
$torrenttpl->set("torrent_header_category", "<a href=\"$scriptname&amp;$addparam".(strlen($addparam) > 0?"&amp;":"")."order=1&amp;by=".($order == "cname" && $by == "ASC"?"2":"1")."\">".$language["CATEGORY"].
    "</a>".($order == "cname"?$mark:""));
$torrenttpl->set("torrent_header_filename", "<a href=\"$scriptname&amp;$addparam".(strlen($addparam) > 0?"&amp;":"")."order=2&amp;by=".($order == "filename" && $by == "ASC"?"2":"1")."\">".$language["FILE"].
    "</a>".($order == "filename"?$mark:""));
$torrenttpl->set("torrent_header_comments", $language["COMMENT"]);
$torrenttpl->set("torrent_header_rating", $language["RATING"]);
//imdb rating
if($btit_settings["fmhack_getIMDB_in_torrent_details"] == "enabled")
{
    $torrenttpl->set("torrent_header_imdb", $language["IMDB_RATING_2"]);
}
//end imdb rating
if($btit_settings["fmhack_enhanced_wait_time"] != "enabled")
{
    $CURUSER["wait_time"] = 0;
    $CURUSER["custom_wait_time"] = "no";
    $CURUSER["php_cust_wait_time"] = 0;
}
$torrenttpl->set("WT", ((max(0, $CURUSER["WT"]) > 0 || max(0, $CURUSER["wait_time"]) > 0 || ($CURUSER["custom_wait_time"] == "yes" && max(0, $CURUSER["php_cust_wait_time"]) > 0))?true:false), true);
$torrenttpl->set("torrent_header_waiting", $language["WT"]);
$torrenttpl->set("torrent_header_download", $language["DOWN"]);
$torrenttpl->set("torrent_header_added", "<a href=\"$scriptname&amp;$addparam".(strlen($addparam) > 0?"&amp;":"")."order=3&amp;by=".($order == "data" && $by == "ASC"?"2":"1")."\">".$language["ADDED"].
    "</a>".($order == "data"?$mark:""));
$torrenttpl->set("torrent_header_size", "<a href=\"$scriptname&amp;$addparam".(strlen($addparam) > 0?"&amp;":"")."order=4&amp;by=".($order == "size" && $by == "DESC"?"1":"2")."\">".$language["SIZE"].
    "</a>".($order == "size"?$mark:""));
$torrenttpl->set("torrent_header_uploader", $language["UPLOADER"]);
$torrenttpl->set("torrent_header_seeds", "<a href=\"$scriptname&amp;$addparam".(strlen($addparam) > 0?"&amp;":"")."order=5&amp;by=".($order == "seeds" && $by == "DESC"?"1":"2")."\">".$language["SHORT_S"].
    "</a>".($order == "seeds"?$mark:""));
$torrenttpl->set("torrent_header_leechers", "<a href=\"$scriptname&amp;$addparam".(strlen($addparam) > 0?"&amp;":"")."order=6&amp;by=".($order == "leechers" && $by == "DESC"?"1":"2")."\">".$language["SHORT_L"].
    "</a>".($order == "leechers"?$mark:""));
$torrenttpl->set("torrent_header_complete", "<a href=\"$scriptname&amp;$addparam".(strlen($addparam) > 0?"&amp;":"")."order=7&amp;by=".($order == "finished" && $by == "ASC"?"2":"1")."\">".$language["SHORT_C"].
    "</a>".($order == "finished"?$mark:""));
$torrenttpl->set("torrent_header_downloaded", "<a href=\"$scriptname&amp;$addparam".(strlen($addparam) > 0?"&amp;":"")."order=8&amp;by=".($order == "dwned" && $by == "ASC"?"2":"1")."\">".$language["DOWNLOADED"].
    "</a>".($order == "dwned"?$mark:""));
$torrenttpl->set("torrent_header_speed", "<a href=\"$scriptname&amp;$addparam".(strlen($addparam) > 0?"&amp;":"")."order=9&amp;by=".($order == "speed" && $by == "ASC"?"2":"1")."\">".$language["SPEED"].
    "</a>".($order == "speed"?$mark:""));
$torrenttpl->set("torrent_header_average", $language["AVERAGE"]);
//multi delete staff
$allow="";
if($btit_settings["fmhack_multi_delete_torrents"]=="enabled" || $btit_settings["fmhack_sticky_torrent"] == "enabled")
{
    if ($CURUSER["delete_torrents"]=="yes")
    {
        $allow="<td class='header' style=\"text-align: center;width:50px;\"><input type=checkbox name=all onclick=SetAllCheckBoxes('deltorrent','msg[]',this.checked)></td>";
    }
    else
    {
       $allow="<td align='center' class='header' style=\"text-align: center;width:50px;\"></td>";
    }
}
$torrenttpl->set("torrent_header_allow","$allow");
//multi delete staff
$torrenttpl->set("XBTT", $XBTT_USE, true);
$torrenttpl->set("torrent_pagerbottom", $pagerbottom);
$torrenttpl->set("torlang1", (($btit_settings["fmhack_language_in_torrent_list_and_details"] == "enabled")?true:false), true);
$torrenttpl->set("torlang2", (($btit_settings["fmhack_language_in_torrent_list_and_details"] == "enabled")?true:false), true);
$torrenttpl->set("fls_enabled1", (($btit_settings["fmhack_freeleech_slots"]=="enabled")?true:false), true);
$torrenttpl->set("fls_enabled2", (($btit_settings["fmhack_freeleech_slots"]=="enabled")?true:false), true);
if($btit_settings["fmhack_language_in_torrent_list_and_details"] == "enabled")
{
    $torrenttpl->set("torrent_header_language", $language["LANGUAGE"]);
}

$freeleech_torrents=($btit_settings["fmhack_freeleech_slots"]=="enabled" && isset($CURUSER["freeleech_slot_hashes"])&& !empty($CURUSER["freeleech_slot_hashes"])) ? explode(",",$CURUSER["freeleech_slot_hashes"]) : array();

// No reason that I can see for these queries to be within the foreach loop where they'll
// just get run multiple times and produce the same result on every iteration.
if($btit_settings["fmhack_sticky_torrent"] == "enabled")
{
    $sticky_color = get_result("SELECT * FROM {$TABLE_PREFIX}sticky ORDER BY id", true, $btit_settings["cache_duration"]);
}
if($btit_settings["fmhack_gold_and_silver_torrents"] == "enabled")
{
    $res_gold = get_result("SELECT * FROM {$TABLE_PREFIX}gold  WHERE id='1'", true, $btit_settings["cache_duration"]);
}

$torrents = array();
$i = 0;
if(!isset($language["SYSTEM_USER"]))
    $language["SYSTEM_USER"]="System";
if($count > 0)
{
    foreach($results as $data)
    {
        $filename_prefixcolor="";
        $filename_suffixcolor="";
        if($btit_settings["fmhack_torrent_activity_colouring"] == "enabled")
        {
            if($XBTT_USE)
            {
                if(!is_null($data["have_left"]) && !is_null($data["is_active"]))
                {
                    if($data["have_left"]==0 && $data["is_active"]==1)
                    {
                        $filename_prefixcolor=$btit_settings["seeding_prefixcolor"];
                        $filename_suffixcolor=$btit_settings["seeding_suffixcolor"];
                    }
                    elseif($data["have_left"]>0 && $data["is_active"]==1)
                    {
                        $filename_prefixcolor=$btit_settings["leeching_prefixcolor"];
                        $filename_suffixcolor=$btit_settings["leeching_suffixcolor"];
                    }
                }
            }
            else
            {
                if(!is_null($data["seeder_status"]))
                {
                    if($data["seeder_status"]=="seeder")
                    {
                        $filename_prefixcolor=$btit_settings["seeding_prefixcolor"];
                        $filename_suffixcolor=$btit_settings["seeding_suffixcolor"];
                    }
                    elseif($data["seeder_status"]=="leecher")
                    {
                        $filename_prefixcolor=$btit_settings["leeching_prefixcolor"];
                        $filename_suffixcolor=$btit_settings["leeching_suffixcolor"];
                    }
                }
            }
            if($filename_prefixcolor=="" && $filename_suffixcolor=="" && $btit_settings["fmhack_downloaded_torrents"]=="enabled")
            {
                if(!is_null($data["has_downloaded"]))
                {
                    if($data["has_downloaded"]=="yes")
                    {
                        $filename_prefixcolor=$btit_settings["snatched_prefixcolor"];
                        $filename_suffixcolor=$btit_settings["snatched_suffixcolor"];
                    }
                }
            }
        }
        if($btit_settings["fmhack_freeleech_slots"] == "enabled")
        {
            $freeByOtherMeans=((($btit_settings["fmhack_gold_and_silver_torrents"] && isset($data["gold"]) && $data["gold"]==2) || ($btit_settings["fmhack_free_leech_with_happy_hour"] && isset($data["free"]) && $data["free"]=="yes") || ($btit_settings["fmhack_VIP_freeleech"]=="enabled" && $CURUSER["freeleech"]=="yes") )?true:false);
            $flsTorrent=((count($freeleech_torrents)>0 && in_array($data["hash"], $freeleech_torrents))?true:false);
            $userHasSlots=(($CURUSER["freeleech_slots"]>0)?true:false);
            $torrents[$i]["custom_freeleech"]=((!$freeByOtherMeans && !$flsTorrent && $userHasSlots)?"<a href='index.php?page=fls&id=".$data["hash"]."'>":"").image_or_link("images/fls_".(($flsTorrent)?"un":"")."locked.png", "", $language["FLS_".(($flsTorrent)?"UN":"")."LOCKED"]).((!$freeByOtherMeans && !$flsTorrent && $userHasSlots)?"</a>":"");
        }
        $torrents[$i]["alt_image_with_priority"] = $GLOBALS["uploaddir"]."nocover.jpg";
        if($btit_settings["fmhack_getIMDB_in_torrent_details"] == "enabled" || $btit_settings["fmhack_torrent_image_upload"] == "enabled" || $btit_settings["fmhack_grab_images_from_theTVDB"] == "enabled")
        {
            $imgup_img = ((isset($data["img"]) && !empty($data["img"]) && file_exists(dirname(__file__)."/".$GLOBALS["uploaddir"].$data["img"]))?true:false);
            $imdb_img = ((isset($data["imdb"]) && !empty($data["imdb"]) && file_exists(dirname(__file__)."/imdb/images/".$data["imdb"].".jpg"))?true:false);
            $tvdb_img = false;
            if($btit_settings["fmhack_grab_images_from_theTVDB"] == "enabled" && !empty($data["tvdb_id"]))
            {
                $selectedPics=array();
                if(file_exists($THIS_BASEPATH."/thetvdb/".$data["tvdb_id"]."/poster"))
                {
                    foreach(glob($THIS_BASEPATH."/thetvdb/".$data["tvdb_id"]."/poster/*.*") as $imageFilename)
                        $selectedPics[]=str_replace($THIS_BASEPATH."/", "", $imageFilename);
                }
                if(count($selectedPics)>0)
                {
                    $randomkey=array_rand($selectedPics, 1);
                    if(file_exists($THIS_BASEPATH."/".$selectedPics[$randomkey]))
                        $tvdb_img = $selectedPics[$randomkey];
                }
            }
            if($btit_settings["balloontype"]=="1,2,3")
            {
                $torrents[$i]["alt_image_with_priority"] = (($imgup_img)?$GLOBALS["uploaddir"].$data["img"]:(($imdb_img)?"imdb/images/".$data["imdb"].".jpg":(($tvdb_img)?$tvdb_img:$GLOBALS["uploaddir"]."nocover.jpg")));
            }
            elseif($btit_settings["balloontype"]=="1,3,2")
            {
                $torrents[$i]["alt_image_with_priority"] = (($imgup_img)?$GLOBALS["uploaddir"].$data["img"]:(($tvdb_img)?$tvdb_img:(($imdb_img)?"imdb/images/".$data["imdb"].".jpg":$GLOBALS["uploaddir"]."nocover.jpg")));
            }
            elseif($btit_settings["balloontype"]=="2,1,3")
            {
                $torrents[$i]["alt_image_with_priority"] = (($imdb_img)?"imdb/images/".$data["imdb"].".jpg":(($imgup_img)?$GLOBALS["uploaddir"].$data["img"]:(($tvdb_img)?$tvdb_img:$GLOBALS["uploaddir"]."nocover.jpg")));
            }
            elseif($btit_settings["balloontype"]=="2,3,1")
            {
                $torrents[$i]["alt_image_with_priority"] = (($imdb_img)?"imdb/images/".$data["imdb"].".jpg":(($tvdb_img)?$tvdb_img:(($imgup_img)?$GLOBALS["uploaddir"].$data["img"]:$GLOBALS["uploaddir"]."nocover.jpg")));
            }
            elseif($btit_settings["balloontype"]=="3,1,2")
            {
                $torrents[$i]["alt_image_with_priority"] = (($tvdb_img)?$tvdb_img:(($imgup_img)?$GLOBALS["uploaddir"].$data["img"]:(($imdb_img)?"imdb/images/".$data["imdb"].".jpg":$GLOBALS["uploaddir"]."nocover.jpg")));
            }
            elseif($btit_settings["balloontype"]=="3,2,1")
            {
                $torrents[$i]["alt_image_with_priority"] = (($tvdb_img)?$tvdb_img:(($imdb_img)?"imdb/images/".$data["imdb"].".jpg":(($imgup_img)?$GLOBALS["uploaddir"].$data["img"]:$GLOBALS["uploaddir"]."nocover.jpg")));
            }
        }
        if($btit_settings["fmhack_torrent_moderation"] == "enabled" && $btit_settings["mod_app_sa"] == "yes" && $CURUSER["admin_access"] == "yes" && is_null($data["approved_by"]))
        {
            $data["approved_by"] = $language["SYSTEM_USER"];
        }
        $torrenttpl->set("show_uploader1", false, true);
        $torrenttpl->set("show_uploader2", false, true);
        if($btit_settings["fmhack_uploader_size_and_comments_on_torrent_list"] == "enabled")
        {
            if($CURUSER["uid"] > 1 && ($CURUSER["uid"] == $data["uploader"] || $CURUSER["edit_torrents"] == "yes" || $CURUSER["delete_torrents"] == "yes"))
            {
                $torrenttpl->set("show_uploader1", true, true);
                $torrenttpl->set("show_uploader2", true, true);
            }
            else
            {
                $torrenttpl->set("show_uploader1", $SHOW_UPLOADER, true);
                $torrenttpl->set("show_uploader2", $SHOW_UPLOADER, true);
            }
        }
        if($btit_settings["fmhack_display_new_torrents_since_last_Visit"] == "enabled")
        {
            if(isset($_COOKIE['lastseen']))
            {
                $filetime = date("YmdHis", $data["added"]);
                if($_COOKIE['lastseen'] <= $filetime)
                    $is_new = '<img src="images/new.png" />';
                else
                    $is_new = '';
            }
        }
        $torrenttpl->set("WT1", ((max(0, $CURUSER["WT"]) > 0 || max(0, $CURUSER["wait_time"]) > 0 || ($CURUSER["custom_wait_time"] == "yes" && max(0, $CURUSER["php_cust_wait_time"]) > 0))?true:false), true);
        $sticky_enabled = (($btit_settings["fmhack_sticky_torrent"] == "enabled")?true:false);
        $torrenttpl->set("sticky_enabled_1", $sticky_enabled, true);
        $torrenttpl->set("sticky_enabled_2", $sticky_enabled, true);
        $torrenttpl->set("sticky_enabled_3", $sticky_enabled, true);
        $torrenttpl->set("sticky_enabled_4", $sticky_enabled, true);
        $torrenttpl->set("sticky_enabled_5", $sticky_enabled, true);
        $torrenttpl->set("sticky_enabled_6", $sticky_enabled, true);
        $torrenttpl->set("sticky_enabled_7", $sticky_enabled, true);
        $torrenttpl->set("sticky_enabled_8", $sticky_enabled, true);
        $torrenttpl->set("sticky_enabled_9", $sticky_enabled, true);
        $torrenttpl->set("sticky_enabled_10", $sticky_enabled, true);
        $torrenttpl->set("sticky_enabled_11", $sticky_enabled, true);
        $torrenttpl->set("sticky_enabled_12", $sticky_enabled, true);
        $torrenttpl->set("sticky_enabled_13", $sticky_enabled, true);
        $torrenttpl->set("sticky_enabled_14", $sticky_enabled, true);
        $torrenttpl->set("sticky_enabled_15", $sticky_enabled, true);
        $torrenttpl->set("sticky_enabled_16", $sticky_enabled, true);
        $torrenttpl->set("sticky_enabled_17", $sticky_enabled, true);
        $torrenttpl->set("sticky_enabled_18", $sticky_enabled, true);
        $torrenttpl->set("sticky_enabled_19", $sticky_enabled, true);
        if($btit_settings["fmhack_sticky_torrent"] == "enabled")
        {
            /*Mod by losmi - sticky mod
            Start Operation #5*/
            //$sticky_color = get_result("SELECT * FROM {$TABLE_PREFIX}sticky ORDER BY id", true, $btit_settings["cache_duration"]);
            if(count($sticky_color) > 0)
            {
                $st = $sticky_color[0];
                $s_c = $st['color'];
            }
            else
            {
                /*Default value some green #bce1ac;*/
                $s_c = '#bce1ac;';
            }
            $torrents[$i]["color"] = '';
            if($data['sticky'] == 1)
            {
                $torrents[$i]["color"] = 'background:'.$s_c;
            }
            /*Mod by losmi - sticky mod
            End Operation #5*/
            $torrents[$i]["torrentid"]=$data["seoid"];
            $torrents[$i]["checked"]=(($data["sticky"]==1)?" checked=\"checked\"":"");
            $torrenttpl->set("queryString", $_SERVER["QUERY_STRING"]);
        }
        $torrenttpl->set("uploader1", $SHOW_UPLOADER, true);
        $torrenttpl->set("XBTT1", $XBTT_USE, true);
        if($btit_settings["fmhack_teams"] == "enabled")
        {
            $fteam = $data["team"];
            if(isset($fteam) && !empty($fteam))
                $team = "<a href='index.php?page=teaminfo&team=".$data["teamsid"]."&action=view'><img src='".$data["teamimage"]."' border='0' title='".$data["teamname"]."' style='width:25px;'></a>";
            else
                $team = "";
        }
        if($btit_settings["fmhack_subtitles"] == "enabled")
        {
            $fsub = ((isset($data["shash"]) && !is_null($data["shash"]))?$data["shash"]:"");
            if($fsub != "")
                $sub = "<a href='index.php?page=subtitles&id=$fsub'><img src='images/subs.png' border='0' title='subs' alt='subs'></a>";
            else
                $sub = "";
        }
        $data["filename"] = unesc($data["filename"]);
        $filename = cut_string($data["filename"], intval($btit_settings["cut_name"]));
        if($btit_settings["fmhack_upload_multiplier"] == "enabled" && $CURUSER["view_multi"] == "yes")
        {
            if($data["multiplier"] > 1)
                $mult = "<img alt='".$data["multiplier"]."x ".$language["UPM_UPL_MULT"]."' title='".$data["multiplier"]."x ".$language["UPM_UPL_MULT"]."' src='images/".$data['multiplier']."x.gif' />";
            else
                $mult = "";
        }
        if($btit_settings["fmhack_balloons_on_mouseover"] == "enabled")
        {
            $balon="";
            $balloonPriority=explode(",", $btit_settings["balloontype"]);
            if(count($balloonPriority)>0)
            {
                foreach($balloonPriority as $balloonValue)
                {
                    if($balon=="")
                    {
                        if($balloonValue==1)
                        {
                            if(!empty($data["img"]) && @file_exists($THIS_BASEPATH."/".$btit_settings["uploaddir"].$data["img"]))
                                $balon = $btit_settings["uploaddir"].$data["img"];
                        }
                        elseif($balloonValue==2)
                        {
                            if($btit_settings["fmhack_getIMDB_in_torrent_details"] == "enabled" && !empty($data["imdb"]) && @file_exists($THIS_BASEPATH."/imdb/images/".$data["imdb"].".jpg"))
                                $balon = "imdb/images/".$data["imdb"].".jpg";
                        }
                        elseif($balloonValue==3)
                        {
                            if($btit_settings["fmhack_grab_images_from_theTVDB"] == "enabled" && !empty($data["tvdb_id"]))
                            {
                                $selectedPics=array();
                                if(file_exists($THIS_BASEPATH."/thetvdb/".$data["tvdb_id"]."/poster"))
                                {
                                    foreach(glob($THIS_BASEPATH."/thetvdb/".$data["tvdb_id"]."/poster/*.*") as $imageFilename)
                                        $selectedPics[]=str_replace($THIS_BASEPATH."/", "", $imageFilename);
                                }
                                if(count($selectedPics)>0)
                                {
                                    $randomkey=array_rand($selectedPics, 1);
                                    if(file_exists($THIS_BASEPATH."/".$selectedPics[$randomkey]))
                                        $balon = $selectedPics[$randomkey];
                                }
                            }
                        }
                    }
                }
            }
            if($balon=="")
                $balon = $btit_settings["uploaddir"]."nocover.jpg";
        }
        if($btit_settings["fmhack_show_if_seedbox_is_used"] == "enabled")
        {
            //seedbox start
            if($data["seedbox"] == "1")
                $sb = "<img title='".$language["SB_HS_TORRENT"]."' src='images/seedbox.gif' alt='".$language["SB_HS_TORRENT"]."'>";
            else
                $sb = '';
            //seedbox end
        }
        if($btit_settings["fmhack_downloaded_torrents"] == "enabled")
        {
            $dl="";
            if($btit_settings["fmhack_torrent_activity_colouring"] == "enabled" && $btit_settings["hide_down_img"]=="yes")
            {
                // change nothing
            }
            elseif(!is_null($data["has_downloaded"]))
            {
                $dl = (($data["has_downloaded"]=="yes")?"<img src='images/downloaded.gif' alt='".$language["GRAB_AL_DOWN"]."' title='".$language["GRAB_AL_DOWN"]."' />":"");
            }
        }
        $torrents[$i]["category"] = "<a href=\"index.php?page=torrents&amp;category=$data[catid]\">".image_or_link(($data["image"] == ""?"":"$STYLEPATH/images/categories/".$data["image"]), "", $data["cname"]).
            "</a>";
        if($btit_settings["fmhack_torrent_nuked_and_requested"] == "enabled")
        {
            //Torrent Nuke/Req Hack Start
            if($data["requested"] != "false")
                $req = "&nbsp;<img title='".$language["TNR_REL_REQ"]."' src='images/req.gif' />";
            else
                $req = "";
            if($data["nuked"] != "false")
                $nuk = "&nbsp;<img title='".$data["nuke_reason"]."' src='images/nuked.gif' />";
            else
                $nuk = "";
        }
        //imdb rating
        if($btit_settings["fmhack_getIMDB_in_torrent_details"] == "enabled")
        {
            #Imdb Ratings
            require_once ("imdb/imdb.class.php");
            $movie = new imdb($data["imdb"]);
            $ratv_file = dirname(__file__).'/cache/'.$data["imdb"].'_torrents_IMDB_rating.txt';
            if(file_exists($ratv_file))
            {
                $ratv = unserialize(file_get_contents($ratv_file));
            }
            else
            {
                $ratv = $movie->rating();
                if($data["imdb"] != 0)
                    write_file($ratv_file, serialize($ratv));
            }

            if($ratv <= 0.4)
                $rat_img = "00";
            elseif($ratv >= 0.5 && $ratv <= 0.9)
                $rat_img = "05";
            elseif($ratv >= 1 && $ratv <= 1.4)
                $rat_img = "10";
            elseif($ratv >= 1.5 && $ratv <= 1.9)
                $rat_img = "15";
            elseif($ratv >= 2 && $ratv <= 2.4)
                $rat_img = "20";
            elseif($ratv >= 2.5 && $ratv <= 2.9)
                $rat_img = "25";
            elseif($ratv >= 3 && $ratv <= 3.4)
                $rat_img = "30";
            elseif($ratv >= 3.5 && $ratv <= 3.9)
                $rat_img = "35";
            elseif($ratv >= 4 && $ratv <= 4.4)
                $rat_img = "40";
            elseif($ratv >= 4.5 && $ratv <= 4.9)
                $rat_img = "45";
            elseif($ratv >= 5 && $ratv <= 5.4)
                $rat_img = "50";
            elseif($ratv >= 5.5 && $ratv <= 5.9)
                $rat_img = "55";
            elseif($ratv >= 6 && $ratv <= 6.4)
                $rat_img = "60";
            elseif($ratv >= 6.5 && $ratv <= 6.9)
                $rat_img = "65";
            elseif($ratv >= 7 && $ratv <= 7.4)
                $rat_img = "70";
            elseif($ratv >= 7.5 && $ratv <= 7.9)
                $rat_img = "75";
            elseif($ratv >= 8 && $ratv <= 8.4)
                $rat_img = "80";
            elseif($ratv >= 8.5 && $ratv <= 8.9)
                $rat_img = "85";
            elseif($ratv >= 9 && $ratv <= 9.4)
                $rat_img = "90";
            elseif($ratv >= 9.5 && $ratv <= 9.9)
                $rat_img = "95";
            elseif($ratv == 10)
                $rat_img = "100";
            $rater = "N/A";
            if(!empty($ratv))
            {
                $rater = "<img src='".$BASEURL."/imdb/imgs/showtimes/".$rat_img.".gif' alt='".$ratv."/10' title='".$ratv."/10'>";
                ++$rows;
            }
            $torrents[$i]["imdb"] = $rater;
            if($data["genre"]=='')
            {
                $in = $movie->genres();
                $find = array("|", "&nbsp;");
                $rep = array(",", "");
                $SAVE_ARRAY = str_replace($find, $rep, strip_tags(implode("|", $in)), $SAVE_ARRAY);
                $new_ARRAY= array_unique(explode(",",$SAVE_ARRAY));
                $FINAL=implode(",",$new_ARRAY);
                do_sqlquery("UPDATE {$TABLE_PREFIX}files set genre='".$FINAL."' where info_hash='".$data["hash"]."'", true);
            }
            $find = array(",");
            $rep = array("&nbsp;|&nbsp;");
            $list=str_replace($find, $rep, $data["genre"], $list);
            $torrents[$i]["imdb_genre"] = "<br />".$list;
        }
        else
            $torrents[$i]["imdb_genre"]="";
        //end imdb rating
        if($GLOBALS["usepopup"])
        {
            $torrents[$i]["filename"] = "<a href=\"javascript:popdetails('".(($btit_settings["fmhack_SEO_panel"] == "enabled" && $res_seo["activated"] == "true")?strtr($filename, $res_seo["str"], $res_seo["strto"]).
                "-".$data["seoid"].".html":"index.php?page=torrent-details&id=".$data["hash"])."');\"".(($btit_settings["fmhack_balloons_on_mouseover"] == "enabled")?"onmouseover=\" return overlib('<img src=".$balon.
                " width=200 border=0>', CENTER);\" onmouseout=\"return nd();\"":"title=\"".$language["VIEW_DETAILS"].": ".($data["filename"] != ""?$filename:$data["hash"])."\"").">".  unesc($filename_prefixcolor.$data["filename"].$filename_suffixcolor)."</a>".(($btit_settings["fmhack_teams"] ==
                "enabled" && $team != "")?"&nbsp;".$team."&nbsp;":"").($data["external"] == "no"?"":" (<span style=\"color:red\">".$language["SHORT_EXTERNAL"]."</span>)").(($btit_settings["fmhack_display_new_torrents_since_last_Visit"] ==
                "enabled" && $is_new != "")?"&nbsp;&nbsp;".$is_new:"").(($btit_settings["fmhack_show_if_seedbox_is_used"] == "enabled" && $sb != "")?"&nbsp;&nbsp;".$sb:"").(($btit_settings["fmhack_downloaded_torrents"] ==
                "enabled")?$dl:"").(($btit_settings["fmhack_torrent_nuked_and_requested"] == "enabled")?$nuk.$req:"").(($btit_settings["fmhack_upload_multiplier"] == "enabled" && $CURUSER["view_multi"] == "yes")?$mult:
                "");
        }
        else
        {
            $torrents[$i]["filename"] = "<a href=\"".(($btit_settings["fmhack_SEO_panel"] == "enabled" && $res_seo["activated"] == "true")?strtr($filename, $res_seo["str"], $res_seo["strto"])."-".$data["seoid"].
                ".html":"index.php?page=torrent-details&id=".$data["hash"])."\"".(($btit_settings["fmhack_balloons_on_mouseover"] == "enabled")?"onmouseover=\" return overlib('<img src=".$balon.
                " width=200 border=0>', CENTER);\" onmouseout=\"return nd();\"":"title=\"".$language["VIEW_DETAILS"].": ".$data["filename"]."\"").">".($data["filename"] != ""?unesc($filename_prefixcolor.$filename.$filename_suffixcolor):$data["hash"])."</a>".(($btit_settings["fmhack_teams"] ==
                "enabled" && $team != "")?"&nbsp;".$team."&nbsp;":"").($data["external"] == "no"?"":" (<span style=\"color:red\">".$language["SHORT_EXTERNAL"]."</span>)").(($btit_settings["fmhack_display_new_torrents_since_last_Visit"] ==
                "enabled" && $is_new != "")?"&nbsp;&nbsp;".$is_new:"").(($btit_settings["fmhack_show_if_seedbox_is_used"] == "enabled" && $sb != "")?"&nbsp;&nbsp;".$sb:"").(($btit_settings["fmhack_downloaded_torrents"] ==
                "enabled")?$dl:"").(($btit_settings["fmhack_torrent_nuked_and_requested"] == "enabled")?$nuk.$req:"").(($btit_settings["fmhack_upload_multiplier"] == "enabled" && $CURUSER["view_multi"] == "yes")?$mult:
                "");
        }
        if($btit_settings["fmhack_subtitles"] == "enabled")
            $torrents[$i]["filename"] .= (($sub != "")?"&nbsp;$sub&nbsp":"");
        if($btit_settings["fmhack_language_in_torrent_list_and_details"] == "enabled")
        {
            if($data["language"] == "0")
                $torrents[$i]["language"] = "<img src=\"images/flag/unknown.gif\" alt=\"".$language["UNKNOWN"]."\" title=\"".$language["UNKNOWN"]."\">";
            else if ($row["language"] == "1")
                        $torrenttpl->set("language","<img src=\"images/flag/us.png\" alt=\"".$language["LANG_ENG_USA"]."\" title=\"".$language["LANG_ENG_USA"]."\">");
            else if ($row["language"] == "2")
                        $torrenttpl->set("language","<img src=\"images/flag/gb.png\" alt=\"".$language["LANG_ENG_GB"]."\" title=\"".$language["LANG_ENG_GB"]."\">");
            else if ($row["language"] == "3")
                        $torrenttpl->set("language","<img src=\"images/flag/sa.png\" alt=\"".$language["LANG_ARB"]."\" title=\"".$language["LANG_ARB"]."\">");
            else if ($row["language"] == "4")
                        $torrenttpl->set("language","<img src=\"images/flag/bd.png\" alt=\"".$language["LANG_BAN"]."\" title=\"".$language["LANG_BAN"]."\">");
            else if ($row["language"] == "5")
                        $torrenttpl->set("language","<img src=\"images/flag/bg.png\" alt=\"".$language["LANG_BUL"]."\" title=\"".$language["LANG_BUL"]."\">");
            else if ($row["language"] == "6")
                        $torrenttpl->set("language","<img src=\"images/flag/cn.png\" alt=\"".$language["LANG_CHI"]."\" title=\"".$language["LANG_CHI"]."\">");
            else if ($row["language"] == "7")
                        $torrenttpl->set("language","<img src=\"images/flag/cz.png\" alt=\"".$language["LANG_CZE"]."\" title=\"".$language["LANG_CZE"]."\">");
            else if ($row["language"] == "8")
                        $torrenttpl->set("language","<img src=\"images/flag/dk.png\" alt=\"".$language["LANG_DAN"]."\" title=\"".$language["LANG_DAN"]."\">");
            else if ($row["language"] == "9")
                        $torrenttpl->set("language","<img src=\"images/flag/nl.png\" alt=\"".$language["LANG_DUT"]."\" title=\"".$language["LANG_DUT"]."\">");
            else if ($row["language"] == "10")
                        $torrenttpl->set("language","<img src=\"images/flag/fi.png\" alt=\"".$language["LANG_FIN"]."\" title=\"".$language["LANG_FIN"]."\">");
            else if ($row["language"] == "11")
                        $torrenttpl->set("language","<img src=\"images/flag/fr.png\" alt=\"".$language["LANG_FRE"]."\" title=\"".$language["LANG_FRE"]."\">");
            else if ($row["language"] == "12")
                        $torrenttpl->set("language","<img src=\"images/flag/qu.png\" alt=\"".$language["LANG_QUE"]."\" title=\"".$language["LANG_QUE"]."\">");
            else if ($row["language"] == "13")
                        $torrenttpl->set("language","<img src=\"images/flag/de.png\" alt=\"".$language["LANG_GER"]."\" title=\"".$language["LANG_GER"]."\">");
            else if ($row["language"] == "14")
                        $torrenttpl->set("language","<img src=\"images/flag/gr.png\" alt=\"".$language["LANG_GRE"]."\" title=\"".$language["LANG_GRE"]."\">");
            else if ($row["language"] == "15")
                        $torrenttpl->set("language","<img src=\"images/flag/hu.png\" alt=\"".$language["LANG_HUN"]."\" title=\"".$language["LANG_HUN"]."\">");
            else if ($row["language"] == "16")
                        $torrenttpl->set("language","<img src=\"images/flag/ie.png\" alt=\"".$language["LANG_IRI"]."\" title=\"".$language["LANG_IRI"]."\">");
            else if ($row["language"] == "17")
                        $torrenttpl->set("language","<img src=\"images/flag/it.png\" alt=\"".$language["LANG_ITA"]."\" title=\"".$language["LANG_ITA"]."\">");
            else if ($row["language"] == "18")
                        $torrenttpl->set("language","<img src=\"images/flag/pl.png\" alt=\"".$language["LANG_POL"]."\" title=\"".$language["LANG_POL"]."\">");
            else if ($row["language"] == "19")
                        $torrenttpl->set("language","<img src=\"images/flag/br.png\" alt=\"".$language["LANG_POR-BR"]."\" title=\"".$language["LANG_POR-BR"]."\">");
            else if ($row["language"] == "20")
                        $torrenttpl->set("language","<img src=\"images/flag/pt.png\" alt=\"".$language["LANG_POR-PT"]."\" title=\"".$language["LANG_POR-PT"]."\">");
            else if ($row["language"] == "21")
                        $torrenttpl->set("language","<img src=\"images/flag/ro.png\" alt=\"".$language["LANG_ROM"]."\" title=\"".$language["LANG_ROM"]."\">");
            else if ($row["language"] == "22")
                        $torrenttpl->set("language","<img src=\"images/flag/ru.png\" alt=\"".$language["LANG_RUS"]."\" title=\"".$language["LANG_RUS"]."\">");
            else if ($row["language"] == "23")
                        $torrenttpl->set("language","<img src=\"images/flag/ser.png\" alt=\"".$language["LANG_SER"]."\" title=\"".$language["LANG_SER"]."\">");
            else if ($row["language"] == "24")
                        $torrenttpl->set("language","<img src=\"images/flag/es.png\" alt=\"".$language["LANG_SPA"]."\" title=\"".$language["LANG_SPA"]."\">");
            else if ($row["language"] == "25")
                        $torrenttpl->set("language","<img src=\"images/flag/se.png\" alt=\"".$language["LANG_SWE"]."\" title=\"".$language["LANG_SWE"]."\">");
            else if ($row["language"] == "26")
                        $torrenttpl->set("language","<img src=\"images/flag/tr.png\" alt=\"".$language["LANG_TUR"]."\" title=\"".$language["LANG_TUR"]."\">");
            else if ($row["language"] == "27")
                        $torrenttpl->set("language","<img src=\"images/flag/vn.png\" alt=\"".$language["LANG_VIE"]."\" title=\"".$language["LANG_VIE"]."\">");
        }
        if($btit_settings["fmhack_uploader_size_and_comments_on_torrent_list"] == "enabled")
        {
            // search for comments
            $commentres = get_result("SELECT COUNT(*) as comments FROM {$TABLE_PREFIX}comments WHERE info_hash='".$data["hash"]."'", true);
            $commentdata = $commentres[0];
            if($commentdata["comments"] > 0)
            {
                if($GLOBALS["usepopup"])
                    $torrents[$i]["comments"] = "<a href=\"javascript:popdetails('".(($btit_settings["fmhack_SEO_panel"] == "enabled" && $res_seo["activated"] == "true")?strtr($filename, $res_seo["str"], $res_seo["strto"]).
                        "-".$data["seoid"].".html#comments":"index.php?page=torrent-details&id=".$data["hash"]."#comments")."');\" title=\"".$language["VIEW_DETAILS"].": ".$data["filename"]."\">".$commentdata["comments"].
                        "</a>";
                else
                    $torrents[$i]["comments"] = "<a href=\"".(($btit_settings["fmhack_SEO_panel"] == "enabled" && $res_seo["activated"] == "true")?strtr($filename, $res_seo["str"], $res_seo["strto"])."-".$data["seoid"].
                        ".html#comments":"index.php?page=torrent-details&id=".$data["hash"]."#comments")."\" title=\"".$language["VIEW_DETAILS"].": ".$data["filename"]."\">".$commentdata["comments"]."</a>";
            }
            else
                $torrents[$i]["comments"] = "---";
        }
        else
            $torrents[$i]["comments"] = "---";
        // commented out to lower unsed queries (standard template)
        $torrents[$i]["rating"] = $language["NA"];
        $torrenttpl->set("gast_enabled", (($btit_settings["fmhack_gold_and_silver_torrents"] == "enabled")?true:false), true);
        if($btit_settings["fmhack_gold_and_silver_torrents"] == "enabled")
        {
            //gold mod
            $silver_picture = '';
            $gold_picture = '';
            $bronze_picture = '';
            //$res_gold = get_result("SELECT * FROM {$TABLE_PREFIX}gold  WHERE id='1'", true, $btit_settings["cache_duration"]);
            if(count($res_gold) == 1)
            {
                $silver_picture = $res_gold[0]["silver_picture"];
                $gold_picture = $res_gold[0]["gold_picture"];
                $bronze_picture = $res_gold[0]["bronze_picture"];
                $silver_percentage = (100 - $res_gold[0]["silver_percentage"])."%";
                $gold_percentage = (100 - $res_gold[0]["gold_percentage"])."%";
                $bronze_percentage = (100 - $res_gold[0]["bronze_percentage"])."%";
            }
            $torrents[$i]["gold"] = '';
            if($data['gold'] == 1)
                $torrents[$i]["gold"] = '<img title="'.$language["IS_SILVER"].' '.$silver_percentage.' '.$language["IS_ALL"].'" src="images/'.$silver_picture.'" alt="'.$language["IS_SILVER"].' '.$silver_percentage.' '.$language["IS_ALL"].'" />';
            elseif($data['gold'] == 2)
                $torrents[$i]["gold"] = '<img title="'.$language["IS_GOLD"].' '.$gold_percentage.' '.$language["IS_ALL"].'" src="images/'.$gold_picture.'" alt="'.$language["IS_GOLD"].' '.$gold_percentage.' '.$language["IS_ALL"].'" src="images/'.$gold_picture.'" />';
            elseif($data['gold'] == 3)
                $torrents[$i]["gold"] = '<img title="'.$language["IS_BRONZE"].' '.$bronze_percentage.' '.$language["IS_ALL"].'" src="images/'.$bronze_picture.'" alt="'.$language["IS_BRONZE"].' '.$bronze_percentage.' '.$language["IS_ALL"].'" />';
        }
        //free leech hack
        $torrenttpl->set("free_leech_enabled", (($btit_settings["fmhack_free_leech_with_happy_hour"] == "enabled")?true:false), true);
        if($btit_settings["fmhack_free_leech_with_happy_hour"] == "enabled")
        {
            $torrents[$i]["free"] = '';
            if($data['free'] == 'yes')
                $torrents[$i]["free"] = '<img title="'.$language["FL_FREE_LEECH"].'" src="images/freeleech.gif" alt="'.$language["FL_FREE_LEECH"].'"/>';
        }
        // end free leech
        //waitingtime
        // display only if the curuser have some WT restriction
        if(((max(0, $CURUSER["WT"]) > 0 || max(0, $CURUSER["wait_time"]) > 0 || ($CURUSER["custom_wait_time"] == "yes" && max(0, $CURUSER["php_cust_wait_time"]) > 0))?true:false))
        {
            $wait = 0;
            if(intval($CURUSER['downloaded']) > 0)
                $ratio = number_format($CURUSER['uploaded'] / $CURUSER['downloaded'], 2);
            else
                $ratio = 0.0;
            $vz = $data["added"];
            $timer = floor((time() - $vz) / 3600);
            if($btit_settings["fmhack_enhanced_wait_time"] == "enabled")
            {
                if($XBTT_USE)
                {
                    if($CURUSER['uid'] != $data["uploader"])
                        $wait = ($CURUSER["wait_time"] / 3600);
                }
                else
                {
                    if($CURUSER["custom_wait_time"] == "yes")
                    {
                        if($ratio < 1.0 && $CURUSER['uid'] != $data["uploader"])
                            $wait = $CURUSER["php_cust_wait_time"];
                    }
                    else
                    {
                        if($ratio < 1.0 && $CURUSER['uid'] != $data["uploader"])
                            $wait = $CURUSER["WT"];
                    }
                }
            }
            else
            {
                if($ratio < 1.0 && $CURUSER['uid'] != $data["uploader"])
                {
                    $wait = $CURUSER["WT"];
                }
            }
            $wait -= $timer;
            if($wait <= 0)
                $wait = 0;
            if(strlen($data["hash"]) > 0)
                $torrents[$i]["waiting"] = ($wait > 0?$wait." h":"---");
            //end waitingtime
        }
        else
            $torrents[$i]["waiting"] = "";

        if($btit_settings["fmhack_download_ratio_checker"] == "enabled")
            $torrents[$i]["download"] = (($download_locked===true)?image_or_link("images/private2.png", "",
                "locked"):"<a href=\"index.php?page=downloadcheck&amp;id=".$data["hash"]."\" title=\"".(($btit_settings["fmhack_torrent_moderation"] == "enabled" && $btit_settings["mod_app_sa"] ==
                "yes" && $CURUSER["admin_access"] == "yes" && $data["approved_by"] != $language["SYSTEM_USER"])?" (".$language["TMOD_APPROVED_BY"]." ".$data["approved_by"].")":"")."\">".image_or_link("images/".(($btit_settings["fmhack_magnet_links"]=="enabled" && !$DHT_PRIVATE && !$PRIVATE_ANNOUNCE && $data["magnet"]!="")?"magnet":"download").".gif", "",
                (($btit_settings["fmhack_magnet_links"]=="enabled" && !$DHT_PRIVATE && !$PRIVATE_ANNOUNCE && $data["magnet"]!="")?$language["MAGNET_DOWN_USING"]:$language["DOWNLOAD_TORRENT"]))."</a>\n");
        else
            $torrents[$i]["download"] = (($download_locked===true)?image_or_link("images/private2.png", "",
                "locked"):"<a href=\"".(($btit_settings["fmhack_magnet_links"]=="enabled" && !$DHT_PRIVATE && !$PRIVATE_ANNOUNCE && $data["magnet"]!="")?base64_decode(stripslashes($data["magnet"])):"download.php?id=".$data["hash"]."&amp;f=".urlencode($data["filename"]).".torrent")."\">".
                image_or_link("images/".(($btit_settings["fmhack_magnet_links"]=="enabled" && !$DHT_PRIVATE && !$PRIVATE_ANNOUNCE && $data["magnet"]!="")?"magnet":"download").".gif", "", "". (($btit_settings["fmhack_magnet_links"]=="enabled" && !$DHT_PRIVATE && !$PRIVATE_ANNOUNCE && $data["magnet"]!="")?$language["MAGNET_DOWN_USING"]:$language["DOWNLOAD_TORRENT"]).(($btit_settings["fmhack_torrent_moderation"] ==
                "enabled" && $btit_settings["mod_app_sa"] == "yes" && $CURUSER["admin_access"] == "yes" && $data["approved_by"] != $language["SYSTEM_USER"])?" (".$language["TMOD_APPROVED_BY"]." ".$data["approved_by"].")":"")."")."</a>\n");
        include ("include/offset.php");
        $torrents[$i]["added"] = date("d/m/Y", $data["added"] - $offset); // data
        // Alternate date format requested by blubits
        $torrents[$i]["alt_added"] = date("H:i:s d/m/Y", $data["added"] - $offset);
        $torrents[$i]["size"] = makesize($data["size"]);
        //multi delete owner of torrent/staff
        if($btit_settings["fmhack_multi_delete_torrents"]=="enabled" || $btit_settings["fmhack_sticky_torrent"] == "enabled")
        {
		$uploader_allowed=(($CURUSER["uid"]>1 && $CURUSER["uid"]==$data["upname"])?"yes":"no");
        if($btit_settings["fmhack_uploader_rights"]=="enabled" && $uploader_allowed=="yes" && $btit_settings["ulri_delete"]=="no")
        $uploader_allowed="no";
            if ($uploader_allowed=="yes" || $CURUSER["delete_torrents"]=="yes")
            {
                $allow1="<td class='lista' style=\"text-align: center;width:50px;\"><input type='checkbox' name='msg[]' value='".$data["hash"]."'></td>";
                $owntor++;
            }
            else
            {
                $allow1="<td class='lista' style=\"text-align: center;width:50px;\"></td>";
            }
            $torrents[$i]["allow"]=$allow1;
        }
        else
            $torrents[$i]["allow"]="";
        //multi delete owner of torrent/staff
        //Uploaders nick details
        if($data["anonymous"] == "true")
            $torrents[$i]["uploader"] = (($CURUSER["edit_torrents"] == "yes")?"<a href='".(($btit_settings["fmhack_SEO_panel"] == "enabled" && $res_seo["activated_user"] == "true")?$data["upname"]."_".strtr($data["uploader"],
                $res_seo["str"], $res_seo["strto"]).".html":"index.php?page=userdetails&id=".$data["upname"])."'>".unesc($data["prefixcolor"].$data["uploader"].$data["suffixcolor"])."</a> (".$language["ANONYMOUS"].
                ")":$language["ANONYMOUS"]);
        elseif($data["anonymous"] == "false")
            $torrents[$i]["uploader"] = "<a href='".(($btit_settings["fmhack_SEO_panel"] == "enabled" && $res_seo["activated_user"] == "true")?$data["upname"]."_".strtr($data["uploader"], $res_seo["str"], $res_seo["strto"]).
                ".html":"index.php?page=userdetails&id=".$data["upname"])."'>".unesc($data["prefixcolor"].$data["uploader"].$data["suffixcolor"])."</a>";
        //Uploaders nick details
        if($data["external"] == "no")
        {
            if($GLOBALS["usepopup"])
            {
                $torrents[$i]["classe_seeds"] = linkcolor($data["seeds"]);
                $torrents[$i]["seeds"] = "<a href=\"javascript:poppeer('index.php?page=peers&amp;id=".$data["hash"]."');\" title=\"".$language["PEERS_DETAILS"]."\">".$data["seeds"]."</a>";
                $torrents[$i]["classe_leechers"] = linkcolor($data["leechers"]);
                $torrents[$i]["leechers"] = "<a href=\"javascript:poppeer('index.php?page=peers&amp;id=".$data["hash"]."');\" title=\"".$language["PEERS_DETAILS"]."\">".$data["leechers"]."</a>";
                if($data["finished"] > 0)
                    $torrents[$i]["complete"] = "<a href=\"javascript:poppeer('index.php?page=torrent_history&amp;id=".$data["hash"]."');\" title=\"History - ".$data["filename"]."\">".$data["finished"]."</a>";
                else
                    $torrents[$i]["complete"] = "---";
            }
            else
            {
                $torrents[$i]["classe_seeds"] = linkcolor($data["seeds"]);
                $torrents[$i]["seeds"] = "<a href=\"index.php?page=peers&amp;id=".$data["hash"]."\" title=\"".$language["PEERS_DETAILS"]."\">".$data["seeds"]."</a>";
                $torrents[$i]["classe_leechers"] = linkcolor($data["leechers"]);
                $torrents[$i]["leechers"] = "<a href=\"index.php?page=peers&amp;id=".$data["hash"]."\" title=\"".$language["PEERS_DETAILS"]."\">".$data["leechers"]."</a>";
                if($data["finished"] > 0)
                    $torrents[$i]["complete"] = "<a href=\"index.php?page=torrent_history&amp;id=".$data["hash"]."\" title=\"History - ".$data["filename"]."\">".$data["finished"]."</a>";
                else
                    $torrents[$i]["complete"] = "---";
            }
        }
        else
        {
            // linkcolor
            $torrents[$i]["classe_seeds"] = linkcolor($data["seeds"]);
            $torrents[$i]["seeds"] = $data["seeds"];
            $torrents[$i]["classe_leechers"] = linkcolor($data["leechers"]);
            $torrents[$i]["leechers"] = $data["leechers"];
            if($data["finished"] > 0)
                $torrents[$i]["complete"] = $data["finished"];
            else
                $torrents[$i]["complete"] = "---";
        }
        if($data["dwned"] > 0)
            $torrents[$i]["downloaded"] = makesize($data["dwned"]);
        else
            $torrents[$i]["downloaded"] = $language["NA"];
        if(!$XBTT_USE)
        {
            if($data["speed"] < 0 || $data["external"] == "yes")
            {
                $speed = $language["NA"];
            }
            else
                if($data["speed"] > 2097152)
                {
                    $speed = round($data["speed"] / 1048576, 2)." MB/sec";
                }
                else
                {
                    $speed = round($data["speed"] / 1024, 2)." KB/sec";
                }
        }
        $torrents[$i]["speed"] = $speed;
        // Split torrents by hasu
        if($btit_settings["fmhack_split_torrents_by_date"] == "enabled" && $data["sticky"] == 0)
        {
            $day_added = $data['added'];
            $day_show = date($day_added);
            $thisdate = date('M d Y', $day_show);
            /** If date already exist, disable $cleandate varible **/
            if(isset($prevdate) && $thisdate == $prevdate)
            {
                $cleandate = '';
                /** If date does not exist, make some varibles **/
            }
            else
            {
                $day_added = " Torrents Added on ".date("D M d Y", $data["added"]); // You can change this to something else
                $cleandate = "<tr><td align='center' class='header' colspan='15'><b>$day_added</b></td></tr>\n"; // This also...
                $torrents[$i]["dt"] = $cleandate;
            }
            /** Prevent that "torrents added..." wont appear again with the same date **/
            $prevdate = $thisdate;
            $man = array(
                'Jan' => 'January',
                'Feb' => 'February',
                'Mar' => 'March',
                'Apr' => 'April',
                'May' => 'May',
                'Jun' => 'June',
                'Jul' => 'July',
                'Aug' => 'August',
                'Sep' => 'September',
                'Oct' => 'October',
                'Nov' => 'November',
                'Dec' => 'December');
            foreach($man as $eng => $ger)
            {
                $cleandate = str_replace($eng, $ger, $cleandate);
            }
            $dag = array(
                'Mon' => 'Monday',
                'Tues' => 'Tuesday',
                'Wednes' => 'Wednesday',
                'Thurs' => 'Thursday',
                'Fri' => 'Friday',
                'Satur' => 'Saturday',
                'Sun' => 'Sunday');
            foreach($dag as $eng => $ger)
            {
                $cleandate = str_replace($eng.'day', $ger.'', $cleandate);
            }
        }
        else
        {
            $torrents[$i]["dt"] = "";
        }
        // END Split torrents by hasu
        // progress
        if($data["external"] == "yes")
            $prgsf = $language["NA"];
        else
        {
            $id = $data['hash'];
            if($XBTT_USE)
                $subres = get_result("SELECT sum(IFNULL(xfu.left,0)) as to_go, count(xfu.uid) as numpeers FROM xbt_files_users xfu INNER JOIN xbt_files xf ON xf.fid=xfu.fid WHERE xf.info_hash=UNHEX('$id') AND xfu.active=1", true,
                    $btit_settings['cache_duration']);
            else
                $subres = get_result("SELECT sum(IFNULL(bytes,0)) as to_go, count(*) as numpeers FROM {$TABLE_PREFIX}peers where infohash='$id'", true, $btit_settings['cache_duration']);
            $subres2 = get_result("SELECT size FROM {$TABLE_PREFIX}files WHERE info_hash ='$id'", true, $btit_settings['cache_duration']);
            $torrent = $subres2[0];
            $subrow = $subres[0];
            $tmp = 0 + $subrow["numpeers"];
            if($tmp > 0)
            {
                $tsize = (0 + $torrent["size"]) * $tmp;
                $tbyte = 0 + $subrow["to_go"];
                $prgs = (($tsize - $tbyte) / $tsize) * 100; //100 * (1-($tbyte/$tsize));
                $prgsf = floor($prgs);
            }
            else
                $prgsf = 0;
            $prgsf .= "%";
            if($btit_settings["fmhack_graphic_average_bar"] == "enabled")
            {
                if($prgsf <= 100)
                    $prgpic = "images/progbar-green.gif";
                if($prgsf == 0)
                    $bckgpic = "images/progbar-black.gif";
                else
                    $bckgpic = "images/progbar-red.gif";
                $progressbar = "<table border=0 width=44 cellspacing=0 cellpadding=0><tr><td align=right border=0 width=2><img src=\"images/bar_left.gif\">";
                $progressbar .= "<td align=left border=0 background=\"$bckgpic\" width=40><img height=9 width=".(number_format($prgsf, 0) / 2.5)." src=\"$prgpic\"></td><td align=right border=0 width=2><img src=\"images/bar_right.gif\"></td></tr></table>";
            }
        }
        $torrents[$i]["average"] = $prgsf.(($btit_settings["fmhack_graphic_average_bar"] == "enabled")?"<br />".$progressbar:"");
        if($btit_settings["fmhack_recommended_torrents"] == "enabled")
        {
            if(!is_null($data["recommended"]))
                $torrents[$i]["recommended"] = "<span style='color:red;'>".$language["RTORR_ALR"]."</span>";
            else
                $torrents[$i]["recommended"] = "<a href='index.php?page=torrents&action=add&info_hash=".$data["hash"]."'>".image_or_link("images/recomend.jpg", "", $language["RTORR_REC"])."</a>";
        }
        $i++;
    }
} // if count
// assign array to loop tag
$torrenttpl->set("usacotl1", (($btit_settings["fmhack_uploader_size_and_comments_on_torrent_list"] == "enabled")?true:false), true);
$torrenttpl->set("usacotl2", (($btit_settings["fmhack_uploader_size_and_comments_on_torrent_list"] == "enabled")?true:false), true);
$torrenttpl->set("usacotl3", (($btit_settings["fmhack_uploader_size_and_comments_on_torrent_list"] == "enabled")?true:false), true);
$torrenttpl->set("usacotl4", (($btit_settings["fmhack_uploader_size_and_comments_on_torrent_list"] == "enabled")?true:false), true);
//multi delete submit
if($btit_settings["fmhack_multi_delete_torrents"]=="enabled" || $btit_settings["fmhack_sticky_torrent"] == "enabled")
{

if ($owntor>0)
    {
        $delit="<select name='operation'>".($btit_settings["fmhack_multi_delete_torrents"]!="enabled"?"":"<option value='1'>Delete</option>")."".($btit_settings["fmhack_sticky_torrent"]!="enabled"?"":"<option value='2'>Set Sticky</option><option value='3'>Remove Sticky</option>")."</select><input class='btn' onclick=\"return confirm('".AddSlashes($language["DELETE_CONFIRM"])."')\" class=\"btn\" type=submit name=action value=Go>";
    }
    $torrenttpl->set("delit",$delit);
}
$torrenttpl->set("multi_del", (($btit_settings["fmhack_multi_delete_torrents"]=="enabled" || $btit_settings["fmhack_sticky_torrent"] == "enabled")?TRUE:FALSE),TRUE);
$torrenttpl->set("multi_del1", (($btit_settings["fmhack_multi_delete_torrents"]=="enabled" || $btit_settings["fmhack_sticky_torrent"] == "enabled" && $owntor>0)?TRUE:FALSE),TRUE);
$torrenttpl->set("multi_del3", (($btit_settings["fmhack_multi_delete_torrents"]=="enabled" || $btit_settings["fmhack_sticky_torrent"] == "enabled")?TRUE:FALSE),TRUE);
$torrenttpl->set("multi_del4", (($btit_settings["fmhack_multi_delete_torrents"]=="enabled" || $btit_settings["fmhack_sticky_torrent"] == "enabled")?TRUE:FALSE),TRUE);

//multi delete submit
$torrenttpl->set("torrents", $torrents);
$torrenttpl->set("ash_enabled_1", (($btit_settings["fmhack_advanced_torrent_search"] == "enabled")?true:false), true);
$torrenttpl->set("ash_enabled_2", (($btit_settings["fmhack_advanced_torrent_search"] == "enabled")?true:false), true);
$torrenttpl->set("imdb_enabled", (($btit_settings["fmhack_getIMDB_in_torrent_details"] == "enabled")?true:false), true);
$torrenttpl->set("imdb_enabled_2", (($btit_settings["fmhack_getIMDB_in_torrent_details"] == "enabled")?true:false), true);
$torrenttpl->set("imdb_enabled_3", (($btit_settings["fmhack_getIMDB_in_torrent_details"] == "enabled")?true:false), true);
$torrenttpl->set("gold_enabled", (($btit_settings["fmhack_gold_and_silver_torrents"] == "enabled")?true:false), true);
$torrenttpl->set("mult_enabled", (($btit_settings["fmhack_upload_multiplier"] == "enabled" && $CURUSER["view_multi"] == "yes")?true:false), true);
if($btit_settings["fmhack_advanced_torrent_search"] == "enabled")
{
    $torrenttpl->set("torrent_selected_file", ($options == 0?"selected=\"selected\"":""));
    $torrenttpl->set("torrent_selected_filedes", ($options == 1?"selected=\"selected\"":""));
    $torrenttpl->set("torrent_selected_des", ($options == 2?"selected=\"selected\"":""));
    $torrenttpl->set("torrent_selected_upl", ($options == 3?"selected=\"selected\"":""));
    $torrenttpl->set("torrent_selected_im", ($options == 4?"selected=\"selected\"":""));
    $torrenttpl->set("torrent_selected_gold", ($options == 5?"selected=\"selected\"":""));
    $torrenttpl->set("torrent_selected_silver", ($options == 6?"selected=\"selected\"":""));
    $torrenttpl->set("torrent_selected_bronze", ($options == 7?"selected=\"selected\"":""));
    $torrenttpl->set("torrent_selected_mul1", ($options == 8?"selected=\"selected\"":""));
    $torrenttpl->set("torrent_selected_mul2", ($options == 9?"selected=\"selected\"":""));
    $torrenttpl->set("torrent_selected_mul3", ($options == 10?"selected=\"selected\"":""));
    $torrenttpl->set("torrent_selected_mul4", ($options == 11?"selected=\"selected\"":""));
    $torrenttpl->set("torrent_selected_mul5", ($options == 12?"selected=\"selected\"":""));
    $torrenttpl->set("torrent_selected_mul6", ($options == 13?"selected=\"selected\"":""));
    $torrenttpl->set("torrent_selected_mul7", ($options == 14?"selected=\"selected\"":""));
    $torrenttpl->set("torrent_selected_mul8", ($options == 15?"selected=\"selected\"":""));
    $torrenttpl->set("torrent_selected_mul9", ($options == 16?"selected=\"selected\"":""));
    $torrenttpl->set("torrent_selected_mul10", ($options == 17?"selected=\"selected\"":""));
    $torrenttpl->set("torrent_selected_gen", ($options == 18?"selected=\"selected\"":""));
}
$torrenttpl->set("rtorr_enabled", (($btit_settings["fmhack_recommended_torrents"] == "enabled")?true:false), true);
$torrenttpl->set("show_recommended_1", (($btit_settings["fmhack_recommended_torrents"] == "enabled" && $CURUSER["edit_users"] == "yes")?true:false), true);
$torrenttpl->set("show_recommended_2", (($btit_settings["fmhack_recommended_torrents"] == "enabled" && $CURUSER["edit_users"] == "yes")?true:false), true);
if($btit_settings["fmhack_recommended_torrents"] == "enabled")
{
    $tora = array();
    $i = 0;
    if(isset($_GET["info_hash"]) && strlen($_GET["info_hash"]) == 40)
        $hash = addslashes($_GET["info_hash"]);
    else
        $hash = "";
    if(isset($_GET["action"]))
        $action = $_GET["action"];
    else
        $action = "";
    if(($hash != "") && ($action == "add"))
    {
        $check_count = get_result("SELECT COUNT(*) `count` FROM `{$TABLE_PREFIX}recommended`", true, $btit_settings["cache_duration"]);
        if($check_count[0]["count"] >= $btit_settings["recommended"])
            stderr($language["ERROR"], $language["RTORR_TOO_MANY_1"]." (<b>".$btit_settings["recommended"]."</b>) ".$language["RTORR_TOO_MANY_2"]);
        $affected = get_result("SELECT `id` FROM `{$TABLE_PREFIX}recommended` WHERE `info_hash`='".$hash."'", true, $btit_settings["cache_duration"]);
        if(count($affected) > 0)
            stderr($language["ERROR"], $language["RTORR_ALR_ADD"]);
        else
        {
            do_sqlquery("INSERT INTO `{$TABLE_PREFIX}recommended` (`info_hash`, `user_name`) VALUES ('".$hash."', '".mysqli_real_escape_string($GLOBALS['conn'],$CURUSER["username"])."')", true);
            success_msg($language["RTORR_SUC_ADD"], $language["RTORR_SUC_ADD"]);
            stdfoot();
            die();
        }
    }
    elseif(($hash != "") && ($action == "remove"))
    {
        do_sqlquery("DELETE FROM `{$TABLE_PREFIX}recommended` WHERE `info_hash`='".$hash."'", true);
        success_msg($language["RTORR_SUC_REM"], $language["RTORR_SUC_REM"]);
        stdfoot();
        die();
    }
    $limit = $btit_settings["recommended"];
    $req1_select = "";
    $req1_join = "";
    $req1_and = "";
    $req1_group = "";
    if($btit_settings["fmhack_gold_and_silver_torrents"] == "enabled")
        $req1_select .= "`f`.`gold`,";
    if($btit_settings["fmhack_free_leech_with_happy_hour"] == "enabled")
        $req1_select .= "`f`.`free`,";
    if($btit_settings["fmhack_show_if_seedbox_is_used"] == "enabled")
        $req1_select .= "`f`.`seedbox`,";
    if($btit_settings["fmhack_subtitles"] == "enabled")
    {
        $req1_select .= "`s`.`hash` `shash`,";
        $req1_join .= "LEFT JOIN `{$TABLE_PREFIX}subtitles` `s` ON `f`.`info_hash`=`s`.`hash` ";
        $req1_group .= "GROUP BY `f`.`info_hash` "; //stop major loop
    }
    if($btit_settings["fmhack_torrent_nuked_and_requested"] == "enabled")
        $req1_select .= "`f`.`requested`, `f`.`nuked`, `f`.`nuke_reason`,";
    if($btit_settings["fmhack_balloons_on_mouseover"] == "enabled")
        $req1_select .= "`f`.`image` `img`,";
    if($btit_settings["fmhack_teams"] == "enabled")
    {
        $req1_select .= "`u2`.`team` `userteam`, `t`.`id` `teamsid`, `t`.`name` `teamname`, `t`.`image` `teamimage`, `f`.`team`,";
        $req1_join .= "LEFT JOIN `{$TABLE_PREFIX}teams` `t` ON `f`.`team` = `t`.`id` ";
        if($btit_settings["team_state"] == "private")
        {
            $req1_and .= "AND (".$CURUSER['team']." = `f`.`team` OR `f`.`team` = 0 OR '".$CURUSER['all_teams']."'='yes' OR '".$CURUSER['sel_team']."'=`f`.`team`) ";
        }
    }
    if($btit_settings["fmhack_upload_multiplier"] == "enabled" && $CURUSER["view_multi"] == "yes")
        $req1_select .= "`f`.`multiplier`,";
    else
        $req1_and .= "AND `f`.`multiplier`=1 ";
    if($btit_settings["fmhack_SEO_panel"] == "enabled")
    {
        $req1_select .= "`f`.`id` `seoid`,";
    }
    if($btit_settings["fmhack_getIMDB_in_torrent_details"] == "enabled")
    {
        $req1_select .= "`f`.`imdb`,";
    }
    if($btit_settings["fmhack_downloaded_torrents"] == "enabled")
    {
        $req1_select.="IF(`d`.`id` IS NULL, 'no', 'yes') `has_downloaded`,";
        $req1_join .= "LEFT JOIN `{$TABLE_PREFIX}down_load` `d` ON (`f`.`info_hash`=`d`.`hash` AND `d`.`pid`='".$CURUSER["pid"]."') ";
    }
    if($btit_settings["fmhack_torrent_activity_colouring"]=="enabled")
    {
        if($XBTT_USE)
        {
            $req1_select.="`xfu`.`left` `have_left`, `xfu`.`active` `is_active`,";
            $req1_join.="LEFT JOIN `xbt_files_users` `xfu` ON (`xfu`.`fid`=`x`.`fid` AND `xfu`.`uid`=".$CURUSER["uid"].") ";
        }
        else
        {
            $req1_select.="`p`.`status` `seeder_status`,";
            $req1_join.="LEFT JOIN `{$TABLE_PREFIX}peers` `p` ON (`p`.`infohash`=`f`.`info_hash` AND `p`.`pid`='".$CURUSER["pid"]."') ";
        }
    }
    if($btit_settings["fmhack_grab_images_from_theTVDB"] == "enabled")
        $req1_select .= "`f`.`tvdb_id`,";
    $query = "SELECT ".$req1_select.
        " `f`.`size`, `r`.`info_hash`, `u1`.`id` `recommender_id`, `ul1`.`prefixcolor` `recommender_prefixcolor`, `r`.`user_name` `recommender_username`, `ul1`.`suffixcolor` `recommender_suffixcolor`, ".(($XBTT_USE)?
        "`x`.`seeders` `seeds`, `x`.`leechers`, `f`.`finished`+ifnull(`x`.`completed`,0) `finished`, ":"`f`.`seeds`, `f`.`leechers`, `f`.`finished` `finished`, f.speed, ").
        "`f`.`filename`, `f`.`anonymous`,  UNIX_TIMESTAMP(`f`.`data`) `added`, `c`.`image`, `c`.`name` `cname`, `f`.`category` `catid`, `f`.`external`, `f`.`uploader` `uploader_id`, `ul2`.`prefixcolor` `uploader_prefixcolor`, `u2`.`username` `uploader_username`, `ul2`.`suffixcolor` `uploader_suffixcolor` FROM `{$TABLE_PREFIX}recommended` `r` LEFT JOIN `{$TABLE_PREFIX}users` `u1` ON `r`.`user_name`=`u1`.`username` LEFT JOIN `{$TABLE_PREFIX}users_level` `ul1` ON `u1`.`id_level`=`ul1`.`id` LEFT JOIN `{$TABLE_PREFIX}files` `f` ON `r`.`info_hash` = `f`.`info_hash` LEFT JOIN `{$TABLE_PREFIX}categories` `c` ON `c`.`id` = `f`.`category` LEFT JOIN `{$TABLE_PREFIX}users` `u2` ON `u2`.`id` = `f`.`uploader` LEFT JOIN `{$TABLE_PREFIX}users_level` `ul2` ON `u2`.`id_level`=`ul2`.`id`".(($XBTT_USE)?
        " LEFT JOIN `xbt_files` `x` ON `f`.`bin_hash`=`x`.`info_hash`":"")." ".$req1_join." ".$req1_and." ".$req1_group." ORDER BY `r`.`id` DESC LIMIT ".$limit;
    $rtorr_res = get_result($query, true, $btit_settings["cache_duration"]);
    if(count($rtorr_res) > 0)
    {
        $torrenttpl->set("rtorr_del_1", (($CURUSER["edit_users"] == "yes")?true:false), true);
        $torrenttpl->set("rtorr_del_2", (($CURUSER["edit_users"] == "yes")?true:false), true);
        $torrenttpl->set("usepopup", (($GLOBALS["usepopup"])?true:false), true);
        $torrenttpl->set("dlcheck_enabled", (($btit_settings["fmhack_download_ratio_checker"] == "enabled")?true:false), true);
        foreach($rtorr_res as $rtorr_results)
        {
            $filename_prefixcolor="";
            $filename_suffixcolor="";
            if($btit_settings["fmhack_torrent_activity_colouring"] == "enabled")
            {
                if($XBTT_USE)
                {
                    if(!is_null($rtorr_results["have_left"]) && !is_null($rtorr_results["is_active"]))
                    {
                        if($rtorr_results["have_left"]==0 && $rtorr_results["is_active"]==1)
                        {
                            $filename_prefixcolor=$btit_settings["seeding_prefixcolor"];
                            $filename_suffixcolor=$btit_settings["seeding_suffixcolor"];
                        }
                        elseif($rtorr_results["have_left"]>0 && $rtorr_results["is_active"]==1)
                        {
                            $filename_prefixcolor=$btit_settings["leeching_prefixcolor"];
                            $filename_suffixcolor=$btit_settings["leeching_suffixcolor"];
                        }
                    }
                }
                else
                {
                    if(!is_null($rtorr_results["seeder_status"]))
                    {
                        if($rtorr_results["seeder_status"]=="seeder")
                        {
                            $filename_prefixcolor=$btit_settings["seeding_prefixcolor"];
                            $filename_suffixcolor=$btit_settings["seeding_suffixcolor"];
                        }
                        elseif($rtorr_results["seeder_status"]=="leecher")
                        {
                            $filename_prefixcolor=$btit_settings["leeching_prefixcolor"];
                            $filename_suffixcolor=$btit_settings["leeching_suffixcolor"];
                        }
                    }
                }
                if($filename_prefixcolor=="" && $filename_suffixcolor=="" && $btit_settings["fmhack_downloaded_torrents"]=="enabled")
                {
                    if(!is_null($rtorr_results["has_downloaded"]))
                    {
                        if($rtorr_results["has_downloaded"]=="yes")
                        {
                            $filename_prefixcolor=$btit_settings["snatched_prefixcolor"];
                            $filename_suffixcolor=$btit_settings["snatched_suffixcolor"];
                        }
                    }
                }
            }
            $tora[$i]["alt_image_imgup"] = $GLOBALS["uploaddir"]."nocover.jpg";
            $tora[$i]["alt_image_imdb"] = $GLOBALS["uploaddir"]."nocover.jpg";
            if($btit_settings["fmhack_getIMDB_in_torrent_details"] == "enabled" && $btit_settings["fmhack_torrent_image_upload"] == "enabled")
            {
                $imgup_img = ((isset($rtorr_results["img"]) && !empty($rtorr_results["img"]) && file_exists(dirname(__file__)."/".$GLOBALS["uploaddir"].$rtorr_results["img"]))?true:false);
                $imdb_img = ((isset($rtorr_results["imdb"]) && !empty($rtorr_results["imdb"]) && file_exists(dirname(__file__)."/imdb/images/".$rtorr_results["imdb"].".jpg"))?true:false);
                $tora[$i]["alt_image_imgup"] = (($imgup_img === true)?$GLOBALS["uploaddir"].$rtorr_results["img"]:(($imdb_img === true)?"imdb/images/".$rtorr_results["imdb"].".jpg":$GLOBALS["uploaddir"].
                    "nocover.jpg"));
                $tora[$i]["alt_image_imdb"] = (($imdb_img === true)?"imdb/images/".$rtorr_results["imdb"].".jpg":(($imgup_img === true)?$GLOBALS["uploaddir"].$rtorr_results["img"]:$GLOBALS["uploaddir"].
                    "nocover.jpg"));
            }
            if($btit_settings["fmhack_uploader_size_and_comments_on_torrent_list"] == "enabled")
            {
                // search for comments
                $commentres1 = get_result("SELECT COUNT(*) as comments FROM {$TABLE_PREFIX}comments WHERE info_hash='".$rtorr_results["info_hash"]."'", true);
                $commentdata1 = $commentres1[0];
                $fname = $rtorr_results["filename"];
                if($commentdata1["comments"] > 0)
                {
                    if($GLOBALS["usepopup"])
                        $tora[$i]["comments"] = "<a href=\"javascript:popdetails('".(($btit_settings["fmhack_SEO_panel"] == "enabled" && $res_seo["activated"] == "true")?strtr($fname, $res_seo["str"], $res_seo["strto"])."-".
                            $rtorr_results["seoid"].".html#comments":"index.php?page=torrent-details&id=".$rtorr_results["info_hash"]."#comments")."');\" title=\"".$language["VIEW_DETAILS"].": ".$rtorr_results["filename"]."\">".
                            $commentdata1["comments"]."</a>";
                    else
                        $tora[$i]["comments"] = "<a href=\"".(($btit_settings["fmhack_SEO_panel"] == "enabled" && $res_seo["activated"] == "true")?strtr($fname, $res_seo["str"], $res_seo["strto"])."-".$rtorr_results["seoid"].
                            ".html#comments":"index.php?page=torrent-details&id=".$rtorr_results["info_hash"]."#comments")."\" title=\"".$language["VIEW_DETAILS"].": ".$rtorr_results["filename"]."\">".$commentdata1["comments"].
                            "</a>";
                }
                else
                    $tora[$i]["comments"] = "---";
            }
            else
                $tora[$i]["comments"] = "---";
            if(!$XBTT_USE)
            {
                if($rtorr_results["speed"] < 0 || $rtorr_results["external"] == "yes")
                {
                    $speed = $language["NA"];
                }
                else
                    if($rtorr_results["speed"] > 2097152)
                    {
                        $speed = round($rtorr_results["speed"] / 1048576, 2)." MB/sec";
                    }
                    else
                    {
                        $speed = round($rtorr_results["speed"] / 1024, 2)." KB/sec";
                    }
            }
            $tora[$i]["speed"] = $speed;
            // progress
            if($rtorr_results["external"] == "yes")
                $prgsf = $language["NA"];
            else
            {
                $id = $rtorr_results['info_hash'];
                if($XBTT_USE)
                    $subres = get_result("SELECT sum(IFNULL(xfu.left,0)) as to_go, count(xfu.uid) as numpeers FROM xbt_files_users xfu INNER JOIN xbt_files xf ON xf.fid=xfu.fid WHERE xf.info_hash=UNHEX('$id') AND xfu.active=1", true,
                        $btit_settings['cache_duration']);
                else
                    $subres = get_result("SELECT sum(IFNULL(bytes,0)) as to_go, count(*) as numpeers FROM {$TABLE_PREFIX}peers where infohash='$id'", true, $btit_settings['cache_duration']);
                $subres2 = get_result("SELECT size FROM {$TABLE_PREFIX}files WHERE info_hash ='$id'", true, $btit_settings['cache_duration']);
                $torrent = $subres2[0];
                $subrow = $subres[0];
                $tmp = 0 + $subrow["numpeers"];
                if($tmp > 0)
                {
                    $tsize = (0 + $torrent["size"]) * $tmp;
                    $tbyte = 0 + $subrow["to_go"];
                    $prgs = (($tsize - $tbyte) / $tsize) * 100; //100 * (1-($tbyte/$tsize));
                    $prgsf = floor($prgs);
                }
                else
                    $prgsf = 0;
                $prgsf .= "%";
                if($btit_settings["fmhack_graphic_average_bar"] == "enabled")
                {
                    if($prgsf <= 100)
                        $prgpic = "images/progbar-green.gif";
                    if($prgsf == 0)
                        $bckgpic = "images/progbar-black.gif";
                    else
                        $bckgpic = "images/progbar-red.gif";
                    $progressbar1 = "<table border=0 width=44 cellspacing=0 cellpadding=0><tr><td align=right border=0 width=2><img src=\"images/bar_left.gif\">";
                    $progressbar1 .= "<td align=left border=0 background=\"$bckgpic\" width=40><img height=9 width=".(number_format($prgsf, 0) / 2.5)." src=\"$prgpic\"></td><td align=right border=0 width=2><img src=\"images/bar_right.gif\"></td></tr></table>";
                }
            }
            $tora[$i]["average"] = $prgsf.(($btit_settings["fmhack_graphic_average_bar"] == "enabled")?"<br />".$progressbar1:"");
            if($btit_settings["fmhack_upload_multiplier"] == "enabled" && $CURUSER["view_multi"] == "yes")
            {
                if($rtorr_results["multiplier"] > 1)
                    $mult1 = "<img alt='".$rtorr_results["multiplier"]."x ".$language["UPM_UPL_MULT"]."' title='".$rtorr_results["multiplier"]."x ".$language["UPM_UPL_MULT"]."' src='images/".$rtorr_results['multiplier'].
                        "x.gif' />";
                else
                    $mult1 = "";
            }
            if($btit_settings["fmhack_show_if_seedbox_is_used"] == "enabled")
            {
                //seedbox start
                if($rtorr_results["seedbox"] == "1")
                    $sb1 = "<img title='".$language["SB_HS_TORRENT"]."' src='images/seedbox.gif' alt='".$language["SB_HS_TORRENT"]."'>";
                else
                    $sb1 = '';
                //seedbox end
            }
            if($btit_settings["fmhack_downloaded_torrents"] == "enabled")
            {
                $dl="";
                if($btit_settings["fmhack_torrent_activity_colouring"] == "enabled" && $btit_settings["hide_down_img"]=="yes")
                {
                    // change nothing
                }
                elseif(!is_null($rtorr_results["has_downloaded"]))
                {
                    $dl = (($rtorr_results["has_downloaded"]=="yes")?"<img src='images/downloaded.gif' alt='".$language["GRAB_AL_DOWN"]."' title='".$language["GRAB_AL_DOWN"]."' />":"");
                }
            }
            if($btit_settings["fmhack_torrent_nuked_and_requested"] == "enabled")
            {
                //Torrent Nuke/Req Hack Start
                if($rtorr_results["requested"] != "false")
                    $req1 = "&nbsp;<img title='".$language["TNR_REL_REQ"]."' src='images/req.gif' />";
                else
                    $req1 = "";
                if($rtorr_results["nuked"] != "false")
                    $nuk1 = "&nbsp;<img title='".$rtorr_results["nuke_reason"]."' src='images/nuked.gif' />";
                else
                    $nuk1 = "";
            }
            $torrenttpl->set("gast_enabled_req", (($btit_settings["fmhack_gold_and_silver_torrents"] == "enabled")?true:false), true);
            if($btit_settings["fmhack_gold_and_silver_torrents"] == "enabled")
            {
                //gold mod
                $silver_picture = '';
                $gold_picture = '';
                $bronze_picture = '';
                if(count($res_gold) == 1)
                {
                    $silver_picture = $res_gold[0]["silver_picture"];
                    $gold_picture = $res_gold[0]["gold_picture"];
                    $bronze_picture = $res_gold[0]["bronze_picture"];
                    $silver_percentage = (100 - $res_gold[0]["silver_percentage"])."%";
                    $gold_percentage = (100 - $res_gold[0]["gold_percentage"])."%";
                    $bronze_percentage = (100 - $res_gold[0]["bronze_percentage"])."%";
                }
                $tora[$i]["gold"] = '';
                if($rtorr_results['gold'] == 1)
                    $tora[$i]["gold"] = '<img title="'.$language["IS_SILVER"].' '.$silver_percentage.' '.$language["IS_ALL"].'" src="images/'.$silver_picture.'" alt="'.$language["IS_SILVER"].' '.$silver_percentage.' '.$language["IS_ALL"].'" />';
                elseif($rtorr_results['gold'] == 2)
                    $tora[$i]["gold"] = '<img title="'.$language["IS_GOLD"].' '.$gold_percentage.' '.$language["IS_ALL"].'" src="images/'.$gold_picture.'" alt="'.$language["IS_GOLD"].' '.$gold_percentage.' '.$language["IS_ALL"].'" src="images/'.$gold_picture.'" />';
                elseif($rtorr_results['gold'] == 3)
                    $tora[$i]["gold"] = '<img title="'.$language["IS_BRONZE"].' '.$bronze_percentage.' '.$language["IS_ALL"].'" src="images/'.$bronze_picture.'" alt="'.$language["IS_BRONZE"].' '.$bronze_percentage.' '.$language["IS_ALL"].'" />';
            }
            //free leech hack
            $torrenttpl->set("free_leech_enabled_req", (($btit_settings["fmhack_free_leech_with_happy_hour"] == "enabled")?true:false), true);
            if($btit_settings["fmhack_free_leech_with_happy_hour"] == "enabled")
            {
                $tora[$i]["free"] = '';
                if($rtorr_results['free'] == yes)
                    $tora[$i]["free"] = '<img title="'.$language["FL_FREE_LEECH"].'" src="images/freeleech.gif" alt="'.$language["FL_FREE_LEECH"].'"/>';
            }
            // end free leech
            if($btit_settings["fmhack_balloons_on_mouseover"] == "enabled")
            {
                $balon="";
                $balloonPriority=explode(",", $btit_settings["balloontype"]);
                if(count($balloonPriority)>0)
                {
                    foreach($balloonPriority as $balloonValue)
                    {
                        if($balon=="")
                        {
                            if($balloonValue==1)
                            {
                                if(!empty($rtorr_results["img"]) && @file_exists($THIS_BASEPATH."/".$btit_settings["uploaddir"].$rtorr_results["img"]))
                                    $balon = $btit_settings["uploaddir"].$rtorr_results["img"];
                            }
                            elseif($balloonValue==2)
                            {
                                if($btit_settings["fmhack_getIMDB_in_torrent_details"] == "enabled" && !empty($rtorr_results["imdb"]) && @file_exists($THIS_BASEPATH."/imdb/images/".$rtorr_results["imdb"].".jpg"))
                                    $balon = "imdb/images/".$rtorr_results["imdb"].".jpg";
                            }
                            elseif($balloonValue==3)
                            {
                                if($btit_settings["fmhack_grab_images_from_theTVDB"] == "enabled" && !empty($rtorr_results["tvdb_id"]))
                                {
                                    $selectedPics=array();
                                    if(file_exists($THIS_BASEPATH."/thetvdb/".$rtorr_results["tvdb_id"]."/poster"))
                                    {
                                        foreach(glob($THIS_BASEPATH."/thetvdb/".$rtorr_results["tvdb_id"]."/poster/*.*") as $imageFilename)
                                            $selectedPics[]=str_replace($THIS_BASEPATH."/", "", $imageFilename);
                                    }
                                    if(count($selectedPics)>0)
                                    {
                                        $randomkey=array_rand($selectedPics, 1);
                                        if(file_exists($THIS_BASEPATH."/".$selectedPics[$randomkey]))
                                            $balon = $selectedPics[$randomkey];
                                    }
                                }
                            }
                        }
                    }
                }
                if($balon=="")
                    $balon = $btit_settings["uploaddir"]."nocover.jpg";
            }
            $tora[$i]["catid"] = $rtorr_results["catid"];
            $tora[$i]["image"] = image_or_link(($rtorr_results["image"] == ""?"":"$STYLEPATH/images/categories/".$rtorr_results["image"]), "", $rtorr_results["cname"]);
            $tora[$i]["hash"] = $rtorr_results["info_hash"];
            $tora[$i]["filename"] = "<a href=\"".(($btit_settings["fmhack_SEO_panel"] == "enabled" && $res_seo["activated"] == "true")?strtr($fname, $res_seo["str"], $res_seo["strto"])."-".$rtorr_results["seoid"].
                ".html":"index.php?page=torrent-details&id=".$rtorr_results["info_hash"])."\"".(($btit_settings["fmhack_balloons_on_mouseover"] == "enabled")?" onmouseover=\" return overlib('<img src=".$balon.
                " width=200 border=0>', CENTER);\" onmouseout=\"return nd();\"":"title=\"".$language["VIEW_DETAILS"].": ".$rtorr_results["filename"]."\"").">".($fname != ""?$fname:$rtorr_results["filename"])."</a>".(($btit_settings["fmhack_teams"] ==
                "enabled" && $team1 != "")?"&nbsp;".$team1."&nbsp;":"").($rtorr_results["external"] == "no"?"":" (<span style=\"color:red\">".$language["SHORT_EXTERNAL"]."</span>)").(($btit_settings["fmhack_display_new_torrents_since_last_Visit"] ==
                "enabled" && $is_new1 != "")?"&nbsp;&nbsp;".$is_new1:"").(($btit_settings["fmhack_show_if_seedbox_is_used"] == "enabled" && $sb1 != "")?"&nbsp;&nbsp;".$sb1:"").(($btit_settings["fmhack_downloaded_torrents"] ==
                "enabled")?$dl1:"").(($btit_settings["fmhack_torrent_nuked_and_requested"] == "enabled")?$nuk1.$req1:"").(($btit_settings["fmhack_upload_multiplier"] == "enabled" && $CURUSER["view_multi"] == "yes")?
                $mult1:"");
            $tora[$i]["filename_enc"] = urlencode($rtorr_results["filename"]);
            $tora[$i]["EXT"] = (($rtorr_results["external"] == "no")?"":" (<span style=\"color:red\">".$language["SHORT_EXTERNAL"]."</span>)");
            $tora[$i]["dl_img"] = (($download_locked===true)?image_or_link("images/private2.png", "", "locked"):image_or_link("images/download.gif", "", "torrent"));
            $tora[$i]["date"] = date("d/m/Y", $rtorr_results["added"]);
            $tora[$i]["size"] = makesize($rtorr_results["size"]);
            if($rtorr_results["anonymous"] == "true")
                $tora[$i]["uploader"] = (($CURUSER["edit_torrents"] == "yes")?"<a href='".(($btit_settings["fmhack_SEO_panel"] == "enabled" && $res_seo["activated_user"] == "true")?$rtorr_results["uploader_id"]."_".
                    strtr($rtorr_results["uploader_username"], $res_seo["str"], $res_seo["strto"]).".html":"index.php?page=userdetails&id=".$rtorr_results["uploader_id"])."'>".unesc($rtorr_results["uploader_prefixcolor"].
                    $rtorr_results["uploader_username"].$rtorr_results["uploader_suffixcolor"])."</a> (".$language["ANONYMOUS"].")":$language["ANONYMOUS"]);
            else
                $tora[$i]["uploader"] = "<a href='".(($btit_settings["fmhack_SEO_panel"] == "enabled" && $res_seo["activated_user"] == "true")?$rtorr_results["uploader_id"]."_".strtr($rtorr_results["uploader_username"],
                    $res_seo["str"], $res_seo["strto"]).".html":"index.php?page=userdetails&id=".$rtorr_results["uploader_id"])."'>".unesc($rtorr_results["uploader_prefixcolor"].$rtorr_results["uploader_username"].$rtorr_results["uploader_suffixcolor"]).
                    "</a>";
            $tora[$i]["recommender"] = "<a href='".(($btit_settings["fmhack_SEO_panel"] == "enabled" && $res_seo["activated_user"] == "true")?$rtorr_results["recommender_id"]."_".strtr($rtorr_results["recommender_username"],
                $res_seo["str"], $res_seo["strto"]).".html":"index.php?page=userdetails&id=".$rtorr_results["recommender_id"])."'>".unesc($rtorr_results["recommender_prefixcolor"].$rtorr_results["recommender_username"].
                $rtorr_results["recommender_suffixcolor"])."</a>";
            $tora[$i]["del_img"] = image_or_link("$STYLEPATH/images/delete.png", "", $language["DELETE"]);
            if($rtorr_results["external"] == "no")
            {
                if($GLOBALS["usepopup"])
                {
                    if($rtorr_results["finished"] > 0)
                        $tora[$i]["complete"] = "<a href=\"javascript:poppeer('index.php?page=torrent_history&amp;id=".$rtorr_results["info_hash"]."');\" title=\"History - ".$rtorr_results["filename"]."\">".$rtorr_results["finished"].
                            "</a>";
                    else
                        $tora[$i]["complete"] = "---";
                    $tora[$i]["rp17"] = ("<td align=\"center\" class=\"".linkcolor($rtorr_results["seeds"])."\"><a href=\"javascript:poppeer('index.php?page=peers&amp;id=".$rtorr_results["info_hash"]."');\" title=\"".$language["PEERS_DETAILS"].
                        "\">".$rtorr_results["seeds"]."</a></td>");
                    $tora[$i]["rp18"] = ("<td align=\"center\" class=\"".linkcolor($rtorr_results["leechers"])."\"><a href=\"javascript:poppeer('index.php?page=peers&amp;id=".$rtorr_results["info_hash"]."');\" title=\"".
                        $language["PEERS_DETAILS"]."\">".$rtorr_results["leechers"]."</a></td>");
                }
                else
                {
                    if($rtorr_results["finished"] > 0)
                        $tora[$i]["complete"] = "<a href=\"index.php?page=torrent_history&amp;id=".$rtorr_results["info_hash"]."\" title=\"History - ".$rtorr_results["filename"]."\">".$rtorr_results["finished"]."</a>";
                    else
                        $tora[$i]["complete"] = "---";
                    $tora[$i]["rp17"] = ("<td align=\"center\" class=\"".linkcolor($rtorr_results["seeds"])."\"><a href=\"index.php?page=peers&amp;id=".$rtorr_results["info_hash"]."\" title=\"".$language["PEERS_DETAILS"].
                        "\">".$rtorr_results["seeds"]."</a></td>");
                    $tora[$i]["rp18"] = ("<td align=\"center\" class=\"".linkcolor($rtorr_results["leechers"])."\"><a href=\"index.php?page=peers&amp;id=".$rtorr_results["info_hash"]."\" title=\"".$language["PEERS_DETAILS"].
                        "\">".$rtorr_results["leechers"]."</a></td>");
                }
            }
            else
            {
                $tora[$i]["rp17"] = ("<td align=\"center\" class=\"".linkcolor($rtorr_results["leechers"])."\">".$rtorr_results["seeds"]."</td>");
                $tora[$i]["rp18"] = ("<td align=\"center\" class=\"".linkcolor($rtorr_results["leechers"])."\">".$rtorr_results["leechers"]."</td>");
            }
            $i++;
        }
    }
    else
        $torrenttpl->set("rtorr_enabled", false, true);
    $torrenttpl->set("tora", $tora);
    $torrenttpl->set("XBTT_1", $XBTT_USE, true);
    $torrenttpl->set("XBTT_2", $XBTT_USE, true);
    $torrenttpl->set("req_header_comments", $language["COMMENT"]);
    $torrenttpl->set("req_header_complete", $language["SHORT_C"]);
    $torrenttpl->set("req_header_speed", $language["SPEED"]);
    $torrenttpl->set("req_header_average", $language["AVERAGE"]);
    $torrenttpl->set("reql1", (($btit_settings["fmhack_uploader_size_and_comments_on_torrent_list"] == "enabled")?true:false), true);
    $torrenttpl->set("reql2", (($btit_settings["fmhack_uploader_size_and_comments_on_torrent_list"] == "enabled")?true:false), true);
    $torrenttpl->set("reql3", (($btit_settings["fmhack_uploader_size_and_comments_on_torrent_list"] == "enabled")?true:false), true);
    $torrenttpl->set("reql4", (($btit_settings["fmhack_uploader_size_and_comments_on_torrent_list"] == "enabled")?true:false), true);
    $torrenttpl->set("download_locked1", (($download_locked===true)?true:false), true);
    $torrenttpl->set("download_locked2", (($download_locked===true)?true:false), true);
}

?>