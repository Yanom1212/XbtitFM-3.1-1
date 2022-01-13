<?php
/////////////////////////////////////////////////////////////////////////////////////
// xbtit - Bittorrent tracker/frontend
//
// Copyright (C) 2004 - 2020  xbtitFM Team
//
//    This file is part of xbtitFM.
//
//  User Agree , first made for Truc,s Saigon Tracker , by DiemThuy - may 2009
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

require_once("include/functions.php");

global $BASEURL, $CURUSER, $language, $btit_settings, $SITENAME;

if(!isset($CURUSER) || !is_array($CURUSER))
{
   
    session_start();
    $CURUSER=$_SESSION["CURUSER"];
}

$agreetpl=new bTemplate();
$agreetpl->set("language",$language);

$agreetpl->set("ua1","<table width=95% cellspacing=0 cellpadding=5 border=0 align=center>");
$agreetpl->set("ua2","<tr>");
$agreetpl->set("ua3","<td valign=top width=63%>");
$agreetpl->set("ua4",$btit_settings["oa_one_text"]);
$agreetpl->set("ua5",$btit_settings["oa_two_text"]);
$agreetpl->set("ua8",$btit_settings["oa_three_text"]);
$agreetpl->set("ua9",$btit_settings["oa_four_text"]);
require_once ("include/offset.php");
$now=time();
$date=date('l jS \of F Y h:i:s A',$now-$offset);
$agreetpl->set("ua6",$date);
$agreetpl->set("ua7",$SITENAME);
?>