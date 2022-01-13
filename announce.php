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

ignore_user_abort(1);

$GLOBALS["peer_id"] = "";
$summaryupdate = array();

$BASEPATH=dirname(__FILE__);
require("$BASEPATH/include/config.php");
require("$BASEPATH/include/common.php");

error_reporting(E_ALL ^ E_NOTICE);

// check if we are using standard php tracker or xbtt backend
// if using xbbt we will make a redirect to xbtt announce using
// informations given in config + pid if private
// thank you petr1fied for the code.
if ($XBTT_USE)
{
    function implode_with_keys($glue, $array)
    {
        $output = array();
        foreach( $array as $key => $item )
            $output[] = $key . "=" . $item;

        return implode($glue, $output);
    }

    if (isset ($_GET["pid"]))
    {
        $pid = $_GET["pid"];
        if (strpos($pid , "?")!==false)
            $pid  = substr($pid , 0,strpos($pid , "?"));
        unset($_GET["pid"]);
    }
    else
        $pid = "";

    if (isset($_SERVER['QUERY_STRING']))
        $query_string = substr($_SERVER['QUERY_STRING'], strpos($_SERVER['QUERY_STRING'], "?")+1);
    else
        $query_string=implode_with_keys("&", $_GET);

    if ($pid!="") // private announce
    {
        header("Location: $XBTT_URL/$pid/announce?" . $query_string);
    }
    else // public
    {
        header("Location: $XBTT_URL/announce?" . $query_string);
    }
    exit;
}

// not using xbtt, let us go ;)

// Schedules an update to the table. It gets so much traffic
// that we do all our changes at once.
// When called, the column $column for the current info_hash is incremented
// by $value, or set to exactly $value if $abs is true.
function summaryAdd($column, $value, $abs = false)
{
    if (isset($GLOBALS["summaryupdate"][$column]))
    {
        if (!$abs)
            $GLOBALS["summaryupdate"][$column][0] += $value;
        else
            show_error("Tracker bug calling summaryAdd");
    }
    else
    {
        $GLOBALS["summaryupdate"][$column][0] = $value;
        $GLOBALS["summaryupdate"][$column][1] = $abs;
    }
}

// connect to db
$GLOBALS['conn']=mysqli_connect($dbhost, $dbuser, $dbpass) or show_error("Tracker error - mysqli_connect: " . mysqli_error($GLOBALS['conn']));

mysqli_select_db($GLOBALS['conn'],$database) or show_error("Tracker error - $database - ".mysqli_error($GLOBALS['conn']));

// connection is done ok
if (isset ($_GET["pid"]))
    $pid = $_GET["pid"];
else
    $pid = "";

if (strpos($pid, "?"))
{
    $tmp = substr($pid , strpos($pid , "?"));
    $pid  = substr($pid , 0,strpos($pid , "?"));
    $tmpname = substr($tmp, 1, strpos($tmp, "=")-1);
    $tmpvalue = substr($tmp, strpos($tmp, "=")+1);
    $_GET[$tmpname] = $tmpvalue;
}

// Many thanks to KktoMx for figuring out this head-ache causer,
// and to bideomex for showing me how to do it PROPERLY... :)
if (get_magic_quotes_gpc())
{
    $info_hash = bin2hex(stripslashes($_GET["info_hash"]));
    $peer_id = bin2hex(stripslashes($_GET["peer_id"]));
}
else
{
    $info_hash = bin2hex($_GET["info_hash"]);
    $peer_id = bin2hex($_GET["peer_id"]);
}

$iscompact=(isset($_GET["compact"])?$_GET["compact"]=='1':false);

include($THIS_BASEPATH.'/index.begin.php');

header("Content-type: text/plain");
header("Pragma: no-cache");

// Error: no web browsers allowed
$agent = mysqli_real_escape_string($GLOBALS['conn'],$_SERVER["HTTP_USER_AGENT"]);
// Deny access made with a browser...

if (preg_match("/^Mozilla|^Opera|^Links|^Lynx/i", $agent))
{
    header("HTTP/1.0 500 Bad Request");
    die("This a a bittorrent application and can't be loaded into a browser");
}

if($btit_settings["fmhack_ban_client"]=="enabled")
{
    $sqlquery ="SELECT client_name, reason ";
    $sqlquery.="FROM {$TABLE_PREFIX}bannedclient ";
    $sqlquery.="WHERE peer_id='".substr($peer_id, 0, 16)."' ";
    $sqlquery.=" OR peer_id='".substr($peer_id, 0, 6)."'";

    // Check if client is banned
    $client_ban=mysqli_fetch_array(do_sqlquery($sqlquery));
    if($client_ban)
        show_error("I'm sorry, $client_ban[0] is banned from this tracker (".stripslashes($client_ban[1]).")");
}

// check if al needed information is sent by the client
if (!isset($_GET["port"]) || !isset($_GET["downloaded"]) || !isset($_GET["uploaded"]) || !isset($_GET["left"]))
    show_error("Invalid information received from BitTorrent client");

$port = $_GET["port"];
$ip = getip();

// IP Banned ??
$nip = ip2long($ip);
$res = do_sqlquery("SELECT * FROM {$TABLE_PREFIX}bannedip WHERE $nip >= first AND $nip <= last") or error_log(__FILE__." - ".__LINE__);
if (mysqli_num_rows($res) > 0)
{
    show_error("You are not authorized to use this tracker (".$SITENAME.") -- Your IP address (".$ip.") is BANNED.");
    die();
}
// end banned IP

// only for internal tracked torrent!
$res_tor =do_sqlquery("SELECT exclusive, UNIX_TIMESTAMP(data) as data, uploader FROM {$TABLE_PREFIX}files WHERE external='no' AND info_hash='".$info_hash."'");
if (mysqli_num_rows($res_tor)==0)
    show_error("Torrent is not authorized for use on this tracker.");

// whitelist users
$row_tor=mysqli_fetch_assoc($res_tor);
$exclusive=$row_tor['exclusive'];
// whitelist users

$downloaded = (float)($_GET["downloaded"]);
$real_downloaded = $downloaded;
$uploaded = (float)($_GET["uploaded"]);
$real_uploaded = $uploaded;
$left = (float)($_GET["left"]);

// Gold & Silver torrents / Free Leech / Upload Multiplier
function checkGold($info_hash, $downloaded=0, $uploaded=0)
{
    global $TABLE_PREFIX, $btit_settings;

    if($btit_settings["fmhack_gold_and_silver_torrents"]=="enabled" || $btit_settings["fmhack_free_leech_with_happy_hour"]=="enabled" || $btit_settings["fmhack_upload_multiplier"]=="enabled")
    {
        $re=do_sqlquery("SELECT f.`gold`, f.`free`, f.`happy`, f.`multiplier`, `g`.`gold_percentage`, `g`.`silver_percentage`, `g`.`bronze_percentage` FROM `{$TABLE_PREFIX}files` `f`, `{$TABLE_PREFIX}gold` `g` WHERE `f`.`info_hash`='".$info_hash."' AND `g`.`id`=1");
        $gold=mysqli_fetch_assoc($re);

        if($btit_settings["fmhack_gold_and_silver_torrents"]=="enabled" || $btit_settings["fmhack_free_leech_with_happy_hour"]=="enabled")
        {
            if($gold['free']=="yes" || $gold['happy']=="yes")
                $downloaded = 0;
            else
            {
                if ($gold['gold']==1)
                {
                    // silver torrent
                    $division_factor=(($gold["silver_percentage"]>0)?(100/$gold["silver_percentage"]):0);
                    $downloaded=(($division_factor>0)?(($downloaded>0)?floor((float)($downloaded/$division_factor)):0):0);
                }
                elseif($gold['gold']==2)
                {
                    // gold torrent
                    $division_factor=(($gold["gold_percentage"]>0)?(100/$gold["gold_percentage"]):0);
                    $downloaded=(($division_factor>0)?(($downloaded>0)?floor((float)($downloaded/$division_factor)):0):0);
                }
                elseif($gold['gold']==3)
                {
                    // bronze torrent
                    $division_factor=(($gold["bronze_percentage"]>0)?(100/$gold["bronze_percentage"]):0);
                    $downloaded=(($division_factor>0)?(($downloaded>0)?floor((float)($downloaded/$division_factor)):0):0);
                }
            }
        }
        if($btit_settings["fmhack_upload_multiplier"]=="enabled")
        {
            if($gold["multiplier"]>1)
                $uploaded=(float)($uploaded*$gold["multiplier"]);
        }
    }
    return array("uploaded"=>$uploaded,"downloaded"=>$downloaded);
}

if($btit_settings["fmhack_gold_and_silver_torrents"]=="enabled" || $btit_settings["fmhack_free_leech_with_happy_hour"]=="enabled" || $btit_settings["fmhack_upload_multiplier"]=="enabled")
{
    $modifier=checkGold($info_hash, $downloaded, $uploaded);
    $downloaded=$modifier["downloaded"];
    $uploaded=$modifier["uploaded"];
}
// End Gold & Silver torrents / Free Leech

// if private announce turned on
if ($PRIVATE_ANNOUNCE)
{
    $pid = AddSlashes(StripSlashes($pid));

    // if PID empty string or not send by client
    if ($pid=="" || !$pid)
        show_error("Please redownload the torrent. PID system is active and pid was not found in the torrent");
}

$query1_select="";
$query1_join="";
if($btit_settings["fmhack_torrents_limit"]=="enabled")
    $query1_select.="`ul`.`torrents_limit`,";
if($btit_settings["fmhack_anti_hit_and_run_system"]=="enabled")
{
    $query1_select.="`h`.`block_leech`,";
    $query1_join.="LEFT JOIN `{$TABLE_PREFIX}hnr` `h` ON `u`.`id_level`=`h`.`id_level` ";
}

// PID turned on
if ($PRIVATE_ANNOUNCE)
{
    $respid = do_sqlquery("SELECT ".$query1_select." `u`.*, `ul`.`level`, `ul`.`can_download`, `ul`.`WT`, `ul`.`freeleech` FROM `{$TABLE_PREFIX}users` `u` LEFT JOIN `{$TABLE_PREFIX}users_level` `ul` on `u`.`id_level`=`ul`.`id` ".$query1_join." WHERE `u`.`pid`='".$pid."' LIMIT 1");
    if (!$respid || mysqli_num_rows($respid)!=1)
        show_error("Invalid PID (private announce): $pid. Please redownload torrent from $BASEURL.");
    else
    {
        $rowpid=mysqli_fetch_assoc($respid);

        // whitelist users
        if ($exclusive) {
            // is current user authorized for download
            $rowexclusive=get_result("SELECT users, groups FROM {$TABLE_PREFIX}files_whitelisted WHERE info_hash='".$info_hash."' LIMIT 1");
            $rowexclusive=$rowexclusive[0];
            if (in_array($rowpid['id'],explode(',',$rowexclusive['users']),true))
                $exclusive_user=true;
            else
                $exclusive_user=($rowpid["id"]==$row_tor["uploader"] || $rowpid["id_level"]==8);

        // groups
        // check only if user not in user list
        if (!$exclusive_user) {
            $rowsgroupexclusive=get_result("SELECT users FROM {$TABLE_PREFIX}whitelisted_groups WHERE id IN (".$rowexclusive['groups'].")");
            $users_str='';
            foreach ($rowsgroupexclusive as $id => $rowgroup) {
                if ($users_str!='')
                    $users_str.=',';
                $users_str.=$rowgroup['users'];
            } 
            // check is current user is IN
            if (in_array($rowpid['id'],explode(',',$users_str),true))
                $exclusive_user=true;
            else
                $exclusive_user=($rowpid["id"]==$row_tor["uploader"] || $rowpid["id_level"]==8);;
    
        }

        
        if (!$exclusive_user){
            show_error("Sorry this torrent is private and reserved to exclusive users");
            die();
        }
        
        }
        // whitelist users

        if($btit_settings["fmhack_freeleech_slots"]=="enabled" && !empty($rowpid["freeleech_slot_hashes"]) && $downloaded>0)
        {
            $hashes=explode(",", $rowpid["freeleech_slot_hashes"]);
            if(isset($hashes) && is_array($hashes) && in_array($info_hash, $hashes))
                $downloaded=0;
        }
        if($btit_settings["fmhack_VIP_freeleech"]=="enabled" && $rowpid["freeleech"]=="yes" && $downloaded>0)
        {
            $downloaded=0;
        }
        if($btit_settings["fmhack_anti_hit_and_run_system"]=="enabled" && !is_null($rowpid["block_leech"]) && $rowpid["block_leech"]>0)
        {
            if ($rowpid["hnr_count"]>=$rowpid["block_leech"] && $left>0 && !$exclusive)
            {
                show_error("Sorry ".$rowpid["username"].", due to Hitting & Running you are only allowed to seed!");
                die();
            }
        }

        if($btit_settings["fmhack_ban_button"]=="enabled")
        {
            if ($rowpid["ban"]=="yes")
            {
                show_error("You are not authorized to use this tracker (".$SITENAME.") -- You are BANNED.");
                die();
            }
        }
        
        if ($rowpid["can_download"]!="yes" && $PRIVATE_ANNOUNCE && !$exclusive)
            show_error("Sorry your level ($rowpid[level]) is not allowed to download from $BASEURL.");
        //waittime
        elseif ($rowpid["WT"]>0)
        {
            $wait=0;
            if (intval($rowpid['downloaded'])>0)
                $ratio=number_format($rowpid['uploaded']/$rowpid['downloaded'],2);
            else
                $ratio=0.0;

            $added=mysqli_fetch_assoc($res_tor);
            $vz = $added["data"];
            $timer = floor((time() - $vz) / 3600);
            if($ratio<1.0 && $rowpid['id']!=$added["uploader"])
            {
                if($btit_settings["fmhack_enhanced_wait_time"]=="enabled")
                {
                    if($rowpid["custom_wait_time"]=="yes")
                        $wait=$rowpid["php_cust_wait_time"];
                    else
                        $wait=$rowpid["WT"];
                }
                else
                    $wait=$rowpid["WT"];
            }
            $wait -=$timer;
            if ($wait<=0)
                $wait=0;
            elseif($wait!=0 && $left!=0 && !$exclusive)
                show_error($rowpid["username"]." your Waiting Time = ".$wait." h");
        }
        //end

        if($btit_settings["fmhack_torrents_limit"]=="enabled")
        {
            $group_max=$rowpid["torrents_limit"];
            $custom_enabled=$rowpid["custom_torr_limit"];
            $custom_max=$rowpid["php_cust_torr_limit"];
            if($group_max==0)
                $group_max=9999;
            if($custom_enabled && $custom_max==0)
                $custom_max=9999;
            
            $petr1=do_sqlquery("SELECT COUNT(*) `count` FROM `{$TABLE_PREFIX}peers` WHERE `pid`='".$pid."' AND `infohash`!='".$info_hash."' AND `status`='leecher'");

            if(@mysqli_num_rows($petr1)>0)
            {
                $fied=mysqli_fetch_assoc($petr1);
                $torrcount=$fied["count"];
            }
            else
                $torrcount=0;
            
            if($custom_enabled=="yes")
            {
                if($torrcount>=$custom_max && !$exclusive)
                    show_error($rowpid["username"].", you can only leech $custom_max torrent".(($custom_max==1)?"":"s")." at any one time!");
            }
            else
            {
                if($torrcount>=$group_max && !$exclusive)
                    show_error($rowpid["username"].", you can only leech $group_max torrent".(($group_max==1)?"":"s")." at any one time!");
            }
        }
    }
}
else
{
    // PID turned off
    $respid = do_sqlquery("SELECT ".$query1_select." `u`.*, `ul`.`level`, `ul`.`can_download`, `ul`.`WT`, `ul`.`freeleech` FROM `{$TABLE_PREFIX}users` `u` LEFT JOIN `{$TABLE_PREFIX}users_level` `ul` ON `u`.`id_level`=`ul`.`id` ".$query1_join." WHERE `u`.`cip`='$ip' LIMIT 1");
    if (!$respid || mysqli_num_rows($respid)!=1)
        // maybe it's guest with new query I must found at least guest user
        $respid = do_sqlquery("SELECT ".$query1_select." `u`.*, `ul`.`level`, `ul`.`can_download`, `ul`.`WT` FROM `{$TABLE_PREFIX}users` `u` LEFT JOIN `{$TABLE_PREFIX}users_level` `ul` ON `u`.`id_level`=`ul`.`id` ".$query1_join." WHERE `u`.`id`=1 LIMIT 1");
    if (!$respid || mysqli_num_rows($respid)!=1)
    {
        // do nothing but tracker is misconfigured!!!
        // guest user not found...
    }
    else
    {
        $rowpid=mysqli_fetch_assoc($respid);

        if($btit_settings["fmhack_freeleech_slots"]=="enabled" && !empty($rowpid["freeleech_slot_hashes"]) && $downloaded>0)
        {
            $hashes=explode(",", $rowpid["freeleech_slot_hashes"]);
            if(isset($hashes) && is_array($hashes) && in_array($info_hash, $hashes))
                $downloaded=0;
        }
        if($btit_settings["fmhack_VIP_freeleech"]=="enabled" && $rowpid["freeleech"]=="yes" && $downloaded>0)
        {
            $downloaded=0;
        }
        if($btit_settings["fmhack_anti_hit_and_run_system"]=="enabled" && !is_null($rowpid["block_leech"]))
        {
            if ($rowpid["hnr_count"]>=$rowpid["block_leech"] && $left>0)
            {
                show_error("Sorry ".$row["username"].", due to Hitting & Running you are only allowed to seed!");
                die();
            }
        }

        if($btit_settings["fmhack_ban_button"]=="enabled")
        {
            if ($rowpid["ban"]=="yes")
            {
                show_error("You are not authorized to use this tracker (".$SITENAME.") -- You are BANNED.");
                die();
            }
        }

        if ($rowpid["can_download"]!="yes")
            show_error("Sorry your level ($rowpid[level]) is not allowed to download from $BASEURL.");
      //waittime
        elseif ($rowpid["WT"]>0)
        {
            $wait=0;
            if (intval($rowpid['downloaded'])>0)
                $ratio=number_format($rowpid['uploaded']/$rowpid['downloaded'],2);
            else
                $ratio=0.0;

            $added=mysqli_fetch_assoc($res_tor);
            $vz = $added["data"];
            $timer = floor((time() - $vz) / 3600);
            if($ratio<1.0 && $rowpid['id']!=$added["uploader"])
            {
                if($btit_settings["fmhack_enhanced_wait_time"]=="enabled")
                {
                    if($rowpid["custom_wait_time"]=="yes")
                        $wait=$rowpid["php_cust_wait_time"];
                    else
                        $wait=$rowpid["WT"];
                }
                else
                    $wait=$rowpid["WT"];
            }
            $wait -=$timer;
            if ($wait<=0)
                $wait=0;
            elseif($wait!=0 && $left!=0)
                show_error($rowpid["username"]." your Waiting Time = ".$wait." h");
        }
        //end

        if($btit_settings["fmhack_torrents_limit"]=="enabled")
        {
            $group_max=$rowpid["torrents_limit"];
            $custom_enabled=$rowpid["custom_torr_limit"];
            $custom_max=$rowpid["php_cust_torr_limit"];
            if($group_max==0)
                $group_max=9999;
            if($custom_enabled && $custom_max==0)
                $custom_max=9999;
            
            $petr1=do_sqlquery("SELECT COUNT(*) `count` FROM `{$TABLE_PREFIX}peers` WHERE `ip`='".$ip."' AND `infohash`!='".$info_hash."'  AND `status`='leecher'");
            if(@mysqli_num_rows($petr1)>0)
            {
                $fied=mysqli_fetch_assoc($petr1);
                $torrcount=$fied["count"];
            }
            else
                $torrcount=0;
            
            if($custom_enabled=="yes")
            {
                if($torrcount>=$custom_max)
                    show_error($rowpid["username"].", you can only leech $custom_max torrent".(($custom_max==1)?"":"s")." at any one time!");
            }
            else
            {
                if($torrcount>=$group_max)
                    show_error($rowpid["username"].", you can only leech $group_max torrent".(($group_max==1)?"":"s")." at any one time!");
            }
        }
    }
}

logclientinfo($agent, $peer_id, $port, $ip, $rowpid["clientinfo"], $rowpid["id"]);

if (isset($_GET["event"]))
    $event = $_GET["event"];
else
    $event = "";

if (!isset($GLOBALS["ip_override"]))
    $GLOBALS["ip_override"] = true;

if (isset($_GET["numwant"]))
    if ($_GET["numwant"] < $GLOBALS["maxpeers"] && $_GET["numwant"] >= 0)
        $GLOBALS["maxpeers"]=$_GET["numwant"];

if (isset($_GET["trackerid"]))
{
    if (is_numeric($_GET["trackerid"]))
        $GLOBALS["trackerid"] = mysqli_real_escape_string($GLOBALS['conn'],$_GET["trackerid"]);
}
if (!is_numeric($port) || !is_numeric($downloaded) || !is_numeric($uploaded) || !is_numeric($left))
    show_error("Invalid numerical field(s) from client");


/////////////////////////////////////////////////////
// Checks

// Upgrade holdover: check for unset directives
if (!isset($GLOBALS["countbytes"]))
    $GLOBALS["countbytes"] = true;


/* Returns true if the user is firewalled, NAT'd, or whatever.
 * The original tracker had its --nat_check parameter, so
 * here is my version.
 */
function isFireWalled($hash, $peerid, $ip, $port)
{

    // NAT checking off?
    if (!$GLOBALS["NAT"])
        return false;

    $protocol_name = 'BitTorrent protocol';
    $theError = "";
    // Hoping 10 seconds will be enough
    $fd = fsockopen($ip, $port, $errno, $theError, 10);
    if (!$fd)
        return true;

    fclose($fd);
    return false;
}


// Returns info on one peer
function getPeerInfo($user, $hash)
{

  global $TABLE_PREFIX;

    // If "trackerid" is set, let's try that
    if (isset($GLOBALS["trackerid"]))
    {
        $query = "SELECT peer_id,bytes,ip,port,status,lastupdate,sequence FROM {$TABLE_PREFIX}peers WHERE sequence=\"".$GLOBALS["trackerid"]."\" AND infohash=\"$hash\"";
        $results = do_sqlquery($query) or show_error("Tracker error: invalid torrent");
        $data = mysqli_fetch_assoc($results);
        if (!$data || $data["peer_id"] != $user)
        {
            // Damn, but don't crash just yet.
            $query = "SELECT peer_id,bytes,ip,port,status,lastupdate,sequence from {$TABLE_PREFIX}peers where peer_id=\"$user\" AND infohash=\"$hash\"";
            $results = do_sqlquery($query) or show_error("Tracker error: invalid torrent");
            $data = mysqli_fetch_assoc($results);
        }
    }
    else
    {
        $query = "SELECT peer_id,bytes,ip,port,status,lastupdate,sequence from {$TABLE_PREFIX}peers where peer_id=\"$user\" AND infohash=\"$hash\"";
        $results = do_sqlquery($query) or show_error("Tracker error: invalid torrent");
        $data = mysqli_fetch_assoc($results);
    }

    if (!($data))
        return false;

    $GLOBALS["trackerid"] = $data["sequence"];
    return $data;
}

/////////////////////////////////////////////////////
// Any section of code might need to make a new peer, so this is a function here.
// I don't want to put it into funcsv2, even though it should, just for consistency's sake.

function start($info_hash, $ip, $port, $peer_id, $left, $downloaded=0, $uploaded=0, $real_downloaded=0, $real_uploaded=0, $upid="")
{
  global $BASEURL, $TABLE_PREFIX, $btit_settings, $PRIVATE_ANNOUNCE;

    if (isset($_GET["ip"]) && $GLOBALS["ip_override"])
    {
        // compact check: valid IP address:
        if ($_GET["ip"]!=long2ip(ip2long($_GET["ip"])))
            show_error("Invalid IP address. Must be standard dotted decimal (hostnames not allowed)");

        $ip = mysqli_real_escape_string($GLOBALS['conn'],$_GET["ip"]);
    }
    else
        $ip = getip();

    $ip = mysqli_real_escape_string($GLOBALS['conn'],$ip);
    $agent = mysqli_real_escape_string($GLOBALS['conn'],$_SERVER["HTTP_USER_AGENT"]);
    $remotedns = gethostbyaddr($ip);

    if (isset($_GET["ip"])) $nuIP = $_GET["ip"];
      else $nuIP = "";
    if ($remotedns == $nuIP)
      $remotedns = "AA";
    else
        {
        $remotedns = strtoupper($remotedns);
        preg_match('/^(.+)\.([A-Z]{2,3})$/', $remotedns, $tldm);
    if (!empty($tldm[2]))
          $remotedns = mysqli_real_escape_string($GLOBALS['conn'],$tldm[2]);
    else
      $remotedns = "AA";
      }

    if ($left == 0)
        $status = "seeder";
    else
        $status = "leecher";

    if (@isFireWalled($info_hash, $peer_id, $ip, $port))
        $nat = "Y";
    else
        $nat = "N";



    $compact = mysqli_real_escape_string($GLOBALS['conn'],str_pad(pack('Nn', ip2long($ip), $port),6));
    $peerid = mysqli_real_escape_string($GLOBALS['conn'],'2:ip' . strlen($ip) . ':' . $ip . '7:peer id20:' . hex2bin($peer_id) . "4:porti{$port}e");
    $no_peerid = mysqli_real_escape_string($GLOBALS['conn'],'2:ip' . strlen($ip) . ':' . $ip . "4:porti{$port}e");

    $results = @do_sqlquery("INSERT INTO {$TABLE_PREFIX}peers SET infohash=\"$info_hash\", peer_id=\"$peer_id\", port=\"$port\", ip=\"$ip\", lastupdate=UNIX_TIMESTAMP(), bytes=\"$left\", status=\"$status\", natuser=\"$nat\", client=\"$agent\", dns=\"$remotedns\", downloaded=$downloaded, uploaded=$uploaded, real_downloaded=$real_downloaded, real_uploaded=$real_uploaded, pid=\"$upid\"");


    // Special case: duplicated peer_id.
    if (!$results)
    {
        if (mysqli_errno($GLOBALS['conn'])==1062)
        {
            // Duplicate peer_id! Check IP address
            $peer = getPeerInfo($peer_id, $info_hash);
            if ($ip == $peer["ip"])
            {
                // Same IP address. Tolerate this error.
                return "WHERE natuser='N'";
            }
            // Different IP address. Assume they were disconnected, and alter the IP address.
            quickQuery("UPDATE {$TABLE_PREFIX}peers SET ip=\"$ip\", compact=\"$compact\", with_peerid=\"$peerid\", without_peerid=\"$no_peerid\" WHERE peer_id=\"$peer_id\"  AND infohash=\"$info_hash\"");
            return "WHERE natuser='N'";
        }
        error_log("BtiTracker: start: ".mysqli_error($GLOBALS['conn']));
        show_error("Tracker/database error. The details are in the error log.");
    }
    $GLOBALS["trackerid"] = mysqli_insert_id($GLOBALS['conn']);

    @do_sqlquery("UPDATE {$TABLE_PREFIX}peers SET sequence=\"".$GLOBALS["trackerid"]."\", compact=\"$compact\", with_peerid=\"$peerid\", without_peerid=\"$no_peerid\" WHERE peer_id=\"$peer_id\" AND infohash=\"$info_hash\"");

    if ($left == 0)
    {
        summaryAdd("seeds", 1);
        return "WHERE status=\"leecher\" AND natuser='N'";
    }
    else
    {
        summaryAdd("leechers", 1);
        return "WHERE natuser='N'";
    }
}

/// End of function start

// default for max peers with same pid/ip
if (!isset($GLOBALS["maxseeds"])) $GLOBALS["maxseeds"]=2;
if (!isset($GLOBALS["maxleech"])) $GLOBALS["maxleech"]=2;

// send random peers to client (direct print)
function sendRandomPeers($info_hash)
{

  global $TABLE_PREFIX;



    if ($GLOBALS["NAT"])
        $where="WHERE infohash=\"$info_hash\" AND natuser = 'N'";
    else
        $where="WHERE infohash=\"$info_hash\"";

    $query = "SELECT ".((isset($_GET["no_peer_id"]) && $_GET["no_peer_id"] == 1) ? "" : "peer_id,")."ip, port FROM {$TABLE_PREFIX}peers ".$where." ORDER BY RAND() LIMIT ".$GLOBALS["maxpeers"];

    echo "d";
    echo "8:intervali".$GLOBALS["report_interval"]."e";
    if (isset($GLOBALS["min_interval"]))
        echo "12:min intervali".$GLOBALS["min_interval"]."e";
    echo "5:peers";

    $result = @do_sqlquery($query);

    if (isset($_GET["compact"]) && $_GET["compact"] == '1')
      {
        $p='';
        while ($row = mysqli_fetch_assoc($result))
            $p .= str_pad(pack("Nn", ip2long($row["ip"]), $row["port"]), 6);
        echo strlen($p).':'.$p;
    }
    else // no_peer_id or no feature supported
    {
        echo 'l';
        while ($row = mysqli_fetch_assoc($result))
        {
            echo "d2:ip".strlen($row["ip"]).":".$row["ip"];
            if (isset($row["peer_id"]))
                echo "7:peer id20:".hex2bin($row["peer_id"]);
            echo "4:porti".$row["port"]."ee";
        }
        echo "e";
    }
    if (isset($GLOBALS["trackerid"]))
        echo "10:tracker id".strlen($GLOBALS["trackerid"]).":".$GLOBALS["trackerid"];
    echo "e";

    mysqli_free_result($result);
}


// Deletes a peer from the system and performs all cleaning up
//
//  $assumepeer contains the result of getPeerInfo, or false
//  if we should grab it ourselves.
function killPeer($userid, $hash, $left, $assumepeer = false)
{

  global $TABLE_PREFIX;

    if (!$assumepeer)
    {
        $peer = getPeerInfo($userid, $hash);
        if (!$peer)
            return;
        if ($left != $peer["bytes"])
            $bytes = bcsub($peer["bytes"], $left);
        else
            $bytes = 0;
    }
    else
    {
        $bytes = 0;
        $peer = $assumepeer;
    }

    quickQuery("DELETE FROM {$TABLE_PREFIX}peers WHERE peer_id=\"$userid\" AND infohash=\"$hash\"");
    if (mysqli_affected_rows($GLOBALS['conn']) == 1)
    {
        if ($peer["status"] == "leecher")
            summaryAdd("leechers", -1);
        else
            summaryAdd("seeds", -1);
        if ($GLOBALS["countbytes"] && ((float)$bytes) > 0)
            summaryAdd("dlbytes",$bytes);
        if ($peer["bytes"] != 0 && $left == 0)
            summaryAdd("finished", 1);

        summaryAdd("lastcycle", "UNIX_TIMESTAMP()", true);
    }
}


// Transfers bytes from "left" to "dlbytes" when a peer reports in.




function collectBytes($peer, $hash, $left, $downloaded=0, $uploaded=0, $real_downloaded=0, $real_uploaded=0, $pid="")
{

  global $TABLE_PREFIX, $btit_settings;

    $peerid=$peer["peer_id"];

    ################################################################################################
    # Speed stats in peers with filename
       
    $row=mysqli_fetch_assoc(do_sqlquery("SELECT lastupdate, uploaded, downloaded FROM {$TABLE_PREFIX}peers WHERE infohash=\"$hash\" AND " . (isset($GLOBALS["trackerid"]) ? "sequence=\"${GLOBALS["trackerid"]}\"" : "peer_id=\"$peerid\"")));    
 
        $annint=time()-$row["lastupdate"];
        $updiff=$uploaded-$row["uploaded"];
        $dldiff=$downloaded-$row["downloaded"];
        
    # End       
    ################################################################################################

    if (!$GLOBALS["countbytes"])
    {

    ################################################################################################
    # Speed stats in peers with filename

        quickQuery("UPDATE {$TABLE_PREFIX}peers SET lastupdate=UNIX_TIMESTAMP(), downloaded=$downloaded, uploaded=$uploaded, real_downloaded=$real_downloaded, real_uploaded=$real_uploaded, pid=\"$pid\", announce_interval=$annint, upload_difference=$updiff, download_difference=$dldiff where infohash=\"$hash\" AND " . (isset($GLOBALS["trackerid"]) ? "sequence=\"${GLOBALS["trackerid"]}\"" : "peer_id=\"$peerid\""));

    # End       
    ################################################################################################

        return;
    }
    $diff = bcsub($peer["bytes"], $left);

    ################################################################################################
    # Speed stats in peers with filename

    quickQuery("UPDATE {$TABLE_PREFIX}peers set " . (($diff != 0) ? "bytes=\"$left\"," : ""). " lastupdate=UNIX_TIMESTAMP(), downloaded=$downloaded, uploaded=$uploaded, real_downloaded=$real_downloaded, real_uploaded=$real_uploaded, pid=\"$pid\", announce_interval=$annint, upload_difference=$updiff, download_difference=$dldiff where infohash=\"$hash\" AND " . (isset($GLOBALS["trackerid"]) ? "sequence=\"".$GLOBALS["trackerid"]."\"" : "peer_id=\"$peerid\""));

    # End       
    ################################################################################################

    // Anti-negative clause
    if (((float)$diff) > 0)
        summaryAdd("dlbytes", $diff);
}

function runSpeed($info_hash, $delta)
{

  global $TABLE_PREFIX;

        //stick in our latest data before we calc it out
        quickQuery("INSERT IGNORE INTO {$TABLE_PREFIX}timestamps (info_hash, bytes, delta, sequence) SELECT '$info_hash' AS info_hash, dlbytes, UNIX_TIMESTAMP() - lastSpeedCycle, NULL FROM {$TABLE_PREFIX}files WHERE info_hash=\"$info_hash\"");

        // mysql blows sometimes so we have to read the data into php before updating it
        $results = do_sqlquery('SELECT (MAX(bytes)-MIN(bytes))/SUM(delta), COUNT(*), MIN(sequence) FROM '.$TABLE_PREFIX.'timestamps WHERE info_hash="'.$info_hash.'"' );
        $data = mysqli_fetch_row($results);

        summaryAdd("speed", $data[0], true);
        summaryAdd("lastSpeedCycle", "UNIX_TIMESTAMP()", true);

        // if we have more than 20 drop the rest
        if ($data[1] == 21)
            quickQuery("DELETE FROM {$TABLE_PREFIX}timestamps WHERE info_hash=\"$info_hash\" AND sequence=${data[2]}");
        else if ($data[1] > 21)
        // This query requires MySQL 4.0.x, but should rarely be used.
        quickQuery ('DELETE FROM '.$TABLE_PREFIX.'timestamps WHERE info_hash="'.$info_hash.'" ORDER BY sequence LIMIT '.($data['1'] - 20));
}

// select how many users with same pid or ip
$results = do_sqlquery("SELECT status, count(status) FROM {$TABLE_PREFIX}peers WHERE ".($PRIVATE_ANNOUNCE?"pid=\"$pid\"":"ip=\"$ip\"")." AND infohash=\"$info_hash\" AND peer_id<>\"$peer_id\" GROUP BY status") or show_error("Tracker error: invalid torrent");
$status = array();

while ($resstat = mysqli_fetch_row($results))
  $status[$resstat[0]]=$resstat[1];

if (!isset($status["leecher"]))
    $status["leecher"]=0;
if (!isset($status["seeder"]))
    $status["seeder"]=0;

if ($status["seeder"]>=$GLOBALS["maxseeds"] || $status["leecher"]>=$GLOBALS["maxleech"])
   show_error("Sorry max peers reached! Redownload torrent from $BASEURL");
// end select

unset($status);
mysqli_free_result($results);

// UPDATE users ratio down/up for every event on every announce
// only with the difference between stored down/up and sended by client
if ($LIVESTATS)
  {
     $resstat = do_sqlquery("SELECT `uploaded`, `downloaded`, `real_downloaded`, `real_uploaded` FROM `{$TABLE_PREFIX}peers` WHERE ".(($PRIVATE_ANNOUNCE)?"`pid`='".$pid."'":"`ip`='".$ip."'")." AND `infohash`='".$info_hash."' AND `peer_id`='".$peer_id."'");
     if ($resstat && mysqli_num_rows($resstat)>0)
         {
         $livestat=mysqli_fetch_assoc($resstat);

         $newup=max(0,($uploaded-$livestat["uploaded"]));
         $real_newup=max(0,($real_uploaded-$livestat["real_uploaded"]));
         $newdown=max(0,($downloaded-$livestat["downloaded"]));
         $real_newdown=max(0,($real_downloaded-$livestat["real_downloaded"]));

         if($newdown>0 && $newdown>$real_newdown)
             $newdown=$real_newdown;
         if($newup==0 && $real_newup>0)
             $newup=$real_newup;

quickquery("UPDATE {$TABLE_PREFIX}users SET downloaded=IFNULL(downloaded,0)+$newdown, uploaded=IFNULL(uploaded,0)+$newup WHERE ".($PRIVATE_ANNOUNCE?"pid='$pid'":"cip='$ip'")."");
         }
       mysqli_free_result($resstat);

       // begin history - also this is registered live or not
       if ($LOG_HISTORY)
         {
          $resu=do_sqlquery("SELECT id FROM {$TABLE_PREFIX}users WHERE ".($PRIVATE_ANNOUNCE?"pid='$pid'":"cip='$ip'") ." ORDER BY lastconnect DESC LIMIT 1");
          // if found at least one user should be 1
          if ($resu && mysqli_num_rows($resu)==1)
            {
              $curuid=mysqli_fetch_assoc($resu);
              
              quickQuery("UPDATE {$TABLE_PREFIX}history set uploaded=IFNULL(uploaded,0)+$newup, downloaded=IFNULL(downloaded,0)+$newdown".(($btit_settings["fmhack_anti_hit_and_run_system"]=="enabled")?(($left > 0)?", `completed`='no', `seed`=0":", `completed='yes'"):"")." WHERE uid=".$curuid["id"]." AND infohash='$info_hash'");
            }
          mysqli_free_result($resu);
       }
       // end history    }
}

switch ($event)
{
    // client sent start
    case "started":

       $start = start($info_hash, $ip, $port, $peer_id, $left, $downloaded, $uploaded, $real_downloaded, $real_uploaded, $pid);

       sendRandomPeers($info_hash);

       // begin history
       if ($LOG_HISTORY)
         {
          $resu=do_sqlquery("SELECT id FROM {$TABLE_PREFIX}users WHERE ".($PRIVATE_ANNOUNCE?"pid='$pid'":"cip='$ip'") ." ORDER BY lastconnect DESC LIMIT 1");
          // if found at least one user should be 1
          if ($resu && mysqli_num_rows($resu)==1)
            {
              $curuid=mysqli_fetch_assoc($resu);

              quickQuery("UPDATE {$TABLE_PREFIX}history set active='yes',agent='".getagent($agent,$peer_id)."' WHERE uid=".$curuid["id"]." AND infohash='$info_hash'");
              // record is not present, create it (only if not seeder: original seeder don't exist in history table, other already exists)
              if (mysqli_affected_rows($GLOBALS['conn'])==0)
              {
                 quickQuery("INSERT INTO {$TABLE_PREFIX}history (uid,infohash,active,agent".(($btit_settings["fmhack_torrent_times"]=="enabled")?",` started_time`":"").") VALUES (".$curuid["id"].",'$info_hash','yes','".getagent($agent,$peer_id)."'".(($btit_settings["fmhack_torrent_times"]=="enabled")?",UNIX_TIMESTAMP()":"").")");
              }
            }
          mysqli_free_result($resu);
       }
       // end history
    break;

    // client sent stop
    case "stopped":

       killPeer($peer_id, $info_hash, $left);

       sendRandomPeers($info_hash);

       // update user uploaded/downloaded
       if (!$LIVESTATS)
           @do_sqlquery("UPDATE {$TABLE_PREFIX}users SET uploaded=IFNULL(uploaded,0)+$uploaded, downloaded=IFNULL(downloaded,0)+$downloaded, real_uploaded=IFNULL(real_uploaded,0)+$real_uploaded, real_downloaded=IFNULL(real_downloaded,0)+$real_downloaded WHERE ".($PRIVATE_ANNOUNCE?"pid='$pid'":"cip='$ip'")." AND id>1 LIMIT 1");

       // begin history - if LIVESTAT, only the active/agent part
       if ($LOG_HISTORY)
         {
          $resu=do_sqlquery("SELECT id FROM {$TABLE_PREFIX}users WHERE ".($PRIVATE_ANNOUNCE?"pid='$pid'":"cip='$ip'") ." ORDER BY lastconnect DESC LIMIT 1");
          // if found at least one user should be 1
          if ($resu && mysqli_num_rows($resu)==1)
            {
              $curuid=mysqli_fetch_assoc($resu);
              quickQuery("UPDATE {$TABLE_PREFIX}history set active='no',".($LIVESTATS?"":" uploaded=IFNULL(uploaded,0)+$uploaded, downloaded=IFNULL(downloaded,0)+$downloaded,")." agent='".getagent($agent,$peer_id)."' WHERE uid=".$curuid["id"]." AND infohash='$info_hash'");
            }
          mysqli_free_result($resu);
       }
       // end history    }
    break;

    // client sent complete
    case "completed":

        $peer_exists = getPeerInfo($peer_id, $info_hash);

        if (!is_array($peer_exists))
            start($info_hash, $ip, $port, $peer_id, $left, $downloaded, $uploaded, $real_downloaded, $real_uploaded, $pid);
        else
        {
            quickQuery("UPDATE {$TABLE_PREFIX}peers SET bytes=0, status=\"seeder\", lastupdate=UNIX_TIMESTAMP(), downloaded=$downloaded, uploaded=$uploaded, real_downloaded=$real_downloaded, real_uploaded=$real_uploaded, pid=\"$pid\" WHERE sequence=\"".$GLOBALS["trackerid"]."\" AND infohash=\"$info_hash\"");

            // Race check
            if (mysqli_affected_rows($GLOBALS['conn']) == 1)
              {
                summaryAdd("leechers", -1);
                summaryAdd("seeds", 1);
                summaryAdd("finished", 1);
                summaryAdd("lastcycle", "UNIX_TIMESTAMP()", true);
            }
            else
              collectBytes($peer_exists, $info_hash, $left, $downloaded, $uploaded, $real_downloaded, $real_uploaded, $pid);
        }


        sendRandomPeers($info_hash);

        // begin history
        if ($LOG_HISTORY)
          {
           $resu=do_sqlquery("SELECT id FROM {$TABLE_PREFIX}users WHERE ".($PRIVATE_ANNOUNCE?"pid='$pid'":"cip='$ip'") ." ORDER BY lastconnect DESC LIMIT 1");
           // if found at least one user should be 1
           if ($resu && mysqli_num_rows($resu)==1)
             {
               $curuid=mysqli_fetch_assoc($resu);
               // if user has already completed this torrent, mysql will give error because of unique index (uid+infohash)
               // upload/download will be updated on stop event...
               // record should already exist (created on stated event)
               quickQuery("UPDATE {$TABLE_PREFIX}history SET date=UNIX_TIMESTAMP(),active='yes',agent='".getagent($agent,$peer_id)."'".(($btit_settings["fmhack_anti_hit_and_run_system"]=="enabled")?", `completed`='yes'":"").(($btit_settings["fmhack_torrent_times"]=="enabled")?", `completed_time`=UNIX_TIMESTAMP()":"")." WHERE uid=".$curuid["id"]." AND infohash='$info_hash'");
               // record is not present, create it
               if (mysqli_affected_rows($GLOBALS['conn'])==0)
                  quickQuery("INSERT INTO {$TABLE_PREFIX}history (uid,infohash,date,active,agent".(($btit_settings["fmhack_anti_hit_and_run_system"]=="enabled")?",`completed`":"").(($btit_settings["fmhack_torrent_times"]=="enabled")?", `completed_time`":"").") VALUES (".$curuid["id"].",'$info_hash',UNIX_TIMESTAMP(),'yes','".getagent($agent,$peer_id)."'".(($btit_settings["fmhack_anti_hit_and_run_system"]=="enabled")?",'yes'":"").(($btit_settings["fmhack_torrent_times"]=="enabled")?", UNIX_TIMESTAMP()":"").")");
             }
           mysqli_free_result($resu);
        }
        // end history
    break;

    // client sent no event
    case "":

        $peer_exists = getPeerInfo($peer_id, $info_hash);
        $where = "WHERE natuser='N'";

        if (!is_array($peer_exists))
            $where = start($info_hash, $ip, $port, $peer_id, $left, $downloaded, $uploaded, $real_downloaded, $real_uploaded, $pid);

        if ($peer_exists["bytes"] != 0 && $left == 0)
        {
            quickQuery("UPDATE {$TABLE_PREFIX}peers SET bytes=0, status=\"seeder\", lastupdate=UNIX_TIMESTAMP(), downloaded=$downloaded, uploaded=$uploaded, real_downloaded=$real_downloaded, real_uploaded=$real_uploaded, pid=\"$pid\" WHERE sequence=\"".$GLOBALS["trackerid"]."\" AND infohash=\"$info_hash\"");
            if (mysqli_affected_rows($GLOBALS['conn']) == 1)
            {
                summaryAdd("leechers", -1);
                summaryAdd("seeds", 1);
                summaryAdd("finished", 1);
                summaryAdd("lastcycle", "UNIX_TIMESTAMP()", true);
            }
            else
              collectBytes($peer_exists, $info_hash, $left, $downloaded, $uploaded, $real_downloaded, $real_uploaded, $pid);
        }
        else
          collectBytes($peer_exists, $info_hash, $left, $downloaded, $uploaded, $real_downloaded, $real_uploaded, $pid);


       sendRandomPeers($info_hash);

    break;

    // not valid event
    default:
        show_error("Invalid event from client.");

}


if ($GLOBALS["countbytes"])
{
    // Once every minute or so, we run the speed update checker.
    $query = @do_sqlquery("SELECT UNIX_TIMESTAMP() - lastSpeedCycle FROM {$TABLE_PREFIX}files WHERE info_hash=\"$info_hash\"");
    $results = mysqli_fetch_row($query);
    if ($results[0] >= 120)
       @runSpeed($info_hash, $results[0]);
}


// Finally, it's time to do stuff to the summary table.
if (!empty($summaryupdate))
{
    $stuff = "";
    foreach ($summaryupdate as $column => $value)
    {
        $stuff .= ', '.$column. ($value[1] ? "=".$value[0] : "=IF(($column<" . abs($value[0])." AND ".$value[0]."<0),0,$column+".$value[0].")");
    }
    do_sqlquery("UPDATE {$TABLE_PREFIX}files SET ".substr($stuff, 1)." WHERE info_hash=\"$info_hash\"");
}

// generaly not needed, but
// just in case server don't close connection
mysqli_close($GLOBALS['conn']);

include($THIS_BASEPATH.'/index.end.php');

?>