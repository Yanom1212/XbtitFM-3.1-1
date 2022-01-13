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


//anonymous links by cooly
function anon_1($string)
{
    // [url=http://www.example.com]Text[/url]
    if(preg_match('|^http(s)?://'.$_SERVER['HTTP_HOST'].'?(/.*)?$|i',$string[1]))
    {
        $string[1]="<a href=\"$string[1]\" target=\"_blank\">$string[3]</a>";
    }
    else
    {
        $string[1]="<a href=\"http://anonym.to/?$string[1]\" target=\"_blank\">$string[3]</a>";
    }
    return $string[1];
}
function anon_2($string)
{
    // [url]http://www.example.com[/url]
    if(preg_match('|^http(s)?://'.$_SERVER['HTTP_HOST'].'?(/.*)?$|i',$string[1]))
    {
        $string[1]="<a href=\"$string[1]\" target=\"_blank\">$string[1]</a>";
    }
    else
    {
        $string[1]="<a href=\"http://anonym.to/?$string[1]\" target=\"_blank\">$string[1]</a>";
    }
    return $string[1];
}
function anon_3($string)
{
    // [url]www.example.com[/url]
    if(preg_match('|^http(s)?://'.$_SERVER['HTTP_HOST'].'?(/.*)?$|i',$string[1]))
    {
        $string[1]="<a href=\"http://".$string[1]."\" target=\"_blank\">$string[1]</a>";
    }
    else
    {
        $string[1]="<a href=\"http://anonym.to/?http://".$string[1]."\" target=\"_blank\">$string[1]</a>";
    }
    return $string[1];
}
function anon_4($string)
{
    // [url=www.example.com]Text[/url]
    if(preg_match('|^http(s)?://'.$_SERVER['HTTP_HOST'].'?(/.*)?$|i',$string[1]))
    {
        $string[1]="<a href=\"http://".$string[1]."\" target=\"_blank\">$string[2]</a>";
    }
    else
    {
        $string[1]="<a href=\"http://anonym.to/?http://".$string[1]."\" target=\"_blank\">$string[2]</a>";
    }
    return $string[1];
}
// end anonymous links by cooly

function format_shout($text, $strip_html = true) {

    global $smilies, $BASEURL, $privatesmilies, $SITENAME, $btit_settings, $radio_msg, $CURUSER;

    $s = $text;
    //$s = strip_tags($s);

  if ($strip_html)
    $s = htmlspecialchars($s);

    $s = unesc($s);

    # for main shout window
    $f = @fopen("../badwords.txt","r");

    if ($f && filesize("../badwords.txt") != 0) {

       $bw = fread($f, filesize("../badwords.txt"));
       $badwords = explode("\n",$bw);

       for ($i=0; $i<count($badwords); ++$i)
           $badwords[$i] = trim($badwords[$i]);
       $s = str_replace($badwords, "<img src='images/censored.png' border='0' alt='' />", $s);
    }
    @fclose($f);

    # for shout history window
    $f = @fopen("badwords.txt","r");

    if ($f && filesize("badwords.txt") != 0) {

       $bw = fread($f, filesize("badwords.txt"));
       $badwords = explode("\n",$bw);

       for ($i=0; $i<count($badwords); ++$i)
           $badwords[$i] = trim($badwords[$i]);
       $s = str_replace($badwords, "<img src='images/censored.png' border='0' alt='' />", $s);
    }
    @fclose($f);

      // [img]http://www/image.gif[/img]
    $s = preg_replace("/\[img\]((http)+(s)?:\/\/[^\s'\"<>]+(\.gif|\.jpg|\.png|\.php))\[\/img\]/", "<a href=\"\\1\" target=\"_new\" rel=\"thumbnail\"><img border=0 src=\"\\1\"></a>", $s);
    $s = preg_replace("/\[IMG\]((http)+(s)?:\/\/[^\s'\"<>]+(\.gif|\.jpg|\.png|\.php))\[\/IMG\]/", "<a href=\"\\1\" target=\"_new\" rel=\"thumbnail\"><img border=0 src=\"\\1\"></a>", $s);
    $s = preg_replace("/\[upimg\]((http)+(s)?:\/\/[^\s'\"<>]+(\.gif|\.jpg|\.png|\.php))\[\/upimg\]/", "<img border=0 src=\"\\1\">", $s);

    // [b]Bold[/b]
    $s = preg_replace("/\[b\]((\s|.)+?)\[\/b\]/", "<b>\\1</b>", $s);

  	$s = preg_replace("/\[radio\]\s*/i", "".$radio_msg."", $s);

    // [i]Italic[/i]
    $s = preg_replace("/\[i\]((\s|.)+?)\[\/i\]/", "<i>\\1</i>", $s);

    // [u]Underline[/u]
    $s = preg_replace("/\[u\]((\s|.)+?)\[\/u\]/", "<u>\\1</u>", $s);

    // [color=blue]Text[/color]
    $s = preg_replace(
        "/\[color=([a-zA-Z]+)\]((\s|.)+?)\[\/color\]/i",
        "<font color=\\1>\\2</font>", $s);

    // [color=#ffcc99]Text[/color]
    $s = preg_replace(
        "/\[color=(#[a-f0-9][a-f0-9][a-f0-9][a-f0-9][a-f0-9][a-f0-9])\]((\s|.)+?)\[\/color\]/i",
        "<font color=\\1>\\2</font>", $s);

    if($btit_settings["fmhack_anonymous_links"]=="enabled")
    {
        // [url=http://www.example.com]Text[/url]
        $s = preg_replace_callback(
            "/\[url=((http|ftp|https|ftps|irc):\/\/[^<>\s]+?)\]((\s|.)+?)\[\/url\]/i",
            "anon_1", $s);

        // [url]http://www.example.com[/url]
        $s = preg_replace_callback(
            "/\[url\]((http|ftp|https|ftps|irc):\/\/[^<>\s]+?)\[\/url\]/i",
            "anon_2", $s);

        // [url]www.example.com[/url]
        $s = preg_replace_callback(
            "/\[url\](www\.[^<>\s]+?)\[\/url\]/i",
            "anon_3", $s);

        // [url=www.example.com]Text[/url]
        $s = preg_replace_callback(
            "/\[url=(www\.[^<>\s]+?)\]((\s|.)+?)\[\/url\]/i",
            "anon_4", $s);
    }
    else
    {
        // [url=http://www.example.com]Text[/url]
        $s = preg_replace(
            "/\[url=((http|ftp|https|ftps|irc):\/\/[^<>\s]+?)\]((\s|.)+?)\[\/url\]/i",
            "<a href=\\1 target=_blank>\\3</a>", $s);

        // [url]http://www.example.com[/url]
        $s = preg_replace(
            "/\[url\]((http|ftp|https|ftps|irc):\/\/[^<>\s]+?)\[\/url\]/i",
            "<a href=\\1 target=_blank>\\1</a>", $s);

        // [url]www.example.com[/url]
        $s = preg_replace(
            "/\[url\](www\.[^<>\s]+?)\[\/url\]/i",
            "<a href='http://\\1' target='_blank'>\\1</a>", $s);

        // [url=www.example.com]Text[/url]
        $s = preg_replace(
            "/\[url=(www\.[^<>\s]+?)\]((\s|.)+?)\[\/url\]/i",
            "<a href='http://\\1' target='_blank'>\\2</a>", $s);
    }





    // [size=4]Text[/size]
    $s = preg_replace(
        "/\[size=([1-7])\]((\s|.)+?)\[\/size\]/i",
        "<font size=\\1>\\2</font>", $s);

    // [font=Arial]Text[/font]
    $s = preg_replace(
        "/\[font=([a-zA-Z ,]+)\]((\s|.)+?)\[\/font\]/i",
        "<font face=\"\\1\">\\2</font>", $s);
		
	    
//marquee
$s = preg_replace("/\[marquee\]\s*((\s|.)+?)\s*\[\/marquee\]\s*/i","<marquee scroll=left>\\1</marquee>", $s);
		
	$s = preg_replace("/^(.*?)youtube.*.*v=([^\s'\"<>]+)/ims", "<a href=\"javascript:popvideo('videopop.php?url=http://www.youtube.com/v/\\2');\"><img src=images/tube.gif></a>", $s);	

    // Linebreaks
    $s = nl2br($s);

    // Maintain spacing
    $s = str_replace("  ", " &nbsp;", $s);

     if($btit_settings["fmhack_custom_smileys"]=="enabled")
    {
    global $TABLE_PREFIX;
    $list=get_result("SELECT `key`,`value` FROM {$TABLE_PREFIX}smilies",true);

    foreach($list as $code=>$url)

        $s = str_replace($url['key'], "<img border='0' src='$BASEURL/images/smilies/".$url['value']."' alt='".$url['key']."' />", $s);
    }
    else{
	reset($smilies);
    foreach ($smilies as $code => $url)
    $s = str_replace($code, "<img border='0' src='$BASEURL/images/smilies/$url' alt='$code' />", $s);
	}

    reset($privatesmilies);
    foreach ($privatesmilies as $code => $url)    
        $s = str_replace($code, "<img border='0' src='$BASEURL/images/smilies/$url' alt='$code' />", $s);
// announce text
    $s = preg_replace("#^/announce(.*)$#", "<div style=\"background: #ffffdd; border: 2px solid #ffd700; padding-left: 5px; font-family:Sans; color:black;\">\\1</div>", $s);
	
	
	global $CURUSER, $btit_settings;
	$is_admin=$CURUSER[$btit_settings['is_admin']]=='yes';
	$is_mod=$CURUSER[$btit_settings['is_mod']]=='yes';
	

  if ((preg_match_all ('' . '#^/pruneshout(.*)$#', $s, $Matches, PREG_SET_ORDER) AND $is_mod))
  {
    return execcommand_pruneshout ($Matches);
  }elseif ((preg_match_all ('' . '#^/pruneshout(.*)$#', $s, $Matches, PREG_SET_ORDER) AND !$is_mod))
  {return execcommand_nopruneshout($Matches);}

  if ((preg_match_all ('' . '#^/prune(.*)$#', $s, $Matches, PREG_SET_ORDER) AND $is_admin))
  {
    return execcommand_prune ($Matches);
  }elseif ((preg_match_all ('' . '#^/prune(.*)$#', $s, $Matches, PREG_SET_ORDER) AND !$is_admin))
  {return execcommand_noprune($Matches);}
  
  if ((preg_match_all ('' . '#^/warn(.*)$#', $s, $Matches, PREG_SET_ORDER) AND $is_admin))
  {
    return execcommand_warn ($Matches);
  }elseif ((preg_match_all ('' . '#^/warn(.*)$#', $s, $Matches, PREG_SET_ORDER) AND !$is_admin))
  {return execcommand_nowarn($Matches);}

  if ((preg_match_all ('' . '#^/unwarn(.*)$#', $s, $Matches, PREG_SET_ORDER) AND $is_admin))
  {
    return execcommand_unwarn ($Matches);
  }elseif ((preg_match_all ('' . '#^/unwarn(.*)$#', $s, $Matches, PREG_SET_ORDER) AND !$is_admin))
  {return execcommand_nounwarn($Matches);}
    
  if ((preg_match_all ('' . '#^/alertstaff(.*)$#', $s, $Matches, PREG_SET_ORDER) AND $is_mod))
  {
    return execcommand_alertstaff ($Matches);
  }elseif ((preg_match_all ('' . '#^/alertstaff(.*)$#', $s, $Matches, PREG_SET_ORDER) AND !$is_mod))
  {return execcommand_noalertstaff($Matches);}
  
  if ((preg_match_all ('' . '#^/prewarnu(.*)$#', $s, $Matches, PREG_SET_ORDER) AND $is_mod))
  {
    return execcommand_prewarnu ($Matches);
  }elseif ((preg_match_all ('' . '#^/prewarnu(.*)$#', $s, $Matches, PREG_SET_ORDER) AND !$is_mod))
  {return execcommand_noprewarnu($Matches);}
  
  if ((preg_match_all ('' . '#^/shouton(.*)$#', $s, $Matches, PREG_SET_ORDER) AND $is_admin))
  {
    return execcommand_close ($Matches);
  }elseif ((preg_match_all ('' . '#^/shouton(.*)$#', $s, $Matches, PREG_SET_ORDER) AND !$is_admin))
  {return execcommand_noclose($Matches);}
	
	if ((preg_match_all ('' . '#^/staffpm(.*)$#', $s, $Matches, PREG_SET_ORDER) AND $is_admin))
  {
    return execcommand_staffpm ($Matches);
  }elseif ((preg_match_all ('' . '#^/staffpm(.*)$#', $s, $Matches, PREG_SET_ORDER) AND !$is_admin))
  {return execcommand_nostaffpm($Matches);}
  
  if ((preg_match_all ('' . '#^/stats(.*)$#', $s, $Matches, PREG_SET_ORDER) AND $is_mod))
  {
    return execcommand_stats ($Matches);
  }elseif ((preg_match_all ('' . '#^/stats(.*)$#', $s, $Matches, PREG_SET_ORDER) AND !$is_mod))
  {return execcommand_nostats($Matches);}
  
  if ((preg_match_all ('' . '#^/boot(.*)$#', $s, $Matches, PREG_SET_ORDER) AND $is_admin))
  {
    return execcommand_boot ($Matches);
  }elseif ((preg_match_all ('' . '#^/boot(.*)$#', $s, $Matches, PREG_SET_ORDER) AND !$is_admin))
  {return execcommand_noboot($Matches);}
  
  if ((preg_match_all ('' . '#^/unboot(.*)$#', $s, $Matches, PREG_SET_ORDER) AND $is_admin))
  {
    return execcommand_unboot ($Matches);
  }elseif ((preg_match_all ('' . '#^/unboot(.*)$#', $s, $Matches, PREG_SET_ORDER) AND !$is_admin))
  {return execcommand_nounboot($Matches);}
	
if ((preg_match_all ('' . '#^/ban(.*)$#', $s, $Matches, PREG_SET_ORDER) AND $is_admin))
  {
    return execcommand_ban ($Matches);
  }elseif ((preg_match_all ('' . '#^/ban(.*)$#', $s, $Matches, PREG_SET_ORDER) AND !$is_admin))
  {return execcommand_noban($Matches);}
  
  if ((preg_match_all ('' . '#^/unban(.*)$#', $s, $Matches, PREG_SET_ORDER) AND $is_admin))
  {
    return execcommand_unban ($Matches);
  }elseif ((preg_match_all ('' . '#^/unban(.*)$#', $s, $Matches, PREG_SET_ORDER) AND !$is_admin))
  {return execcommand_nounban($Matches);}
  
	if($btit_settings["fmhack_shoutbox_clean"]=="enabled")
    {
    $is_mod=$CURUSER["edit_users"]=="yes";
    if ((preg_match_all ('' . '#^/clean(.*)$#', $s, $Matches, PREG_SET_ORDER) AND $is_mod))
  {
    return execcommand_clean ($Matches);
  }elseif ((preg_match_all ('' . '#^/clean(.*)$#', $s, $Matches, PREG_SET_ORDER) AND !$is_mod))
  {return execcommand_noclean($Matches);}
    }


    return $s;
}
?>