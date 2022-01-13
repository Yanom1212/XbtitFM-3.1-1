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
require("include/functions.php");
dbconn(true);

global $btit_settings, $BASEURL, $SITENAME, $CURUSER;

$THIS_BASEPATH=dirname(__FILE__);

// get user's style
$resheet=do_sqlquery("SELECT * FROM {$TABLE_PREFIX}style where id=".$CURUSER["style"]."");
if (!$resheet)
   {

   $STYLEPATH="$THIS_BASEPATH/style/xbtitFM";
   $STYLEURL="$BASEURL/style/xbtitFM";
}
else
    {
        $resstyle=mysqli_fetch_array($resheet);
        $STYLEPATH="$THIS_BASEPATH/".$resstyle["style_url"];
        $STYLEURL="$BASEURL/".$resstyle["style_url"];
}



$listenlnk="http://".$btit_settings["radio_ip"].":".$btit_settings["radio_port"]."";
$listenamp="http://".$btit_settings["radio_ip"].":".$btit_settings["radio_port"]."/listen.pls";
  if ($_GET['type'] == 'mp')
  {
    echo '
	<html>
	<head>
	<title>' . $SITENAME . ' Media Player</title>
	<link rel="stylesheet" type="text/css" href="'.$STYLEURL.'/main.css" />
	</head>
	<body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0">
	<table class="main" cellpadding="6" cellspacing="1" border="0" width="100%" align="center">

		<tr>
			<td class="block">
				<div align="center">' . $SITENAME . ': Media Player</div></td>
		</tr>

		<tr>
	<td class="blocklist" align="center" id="radio">
	<OBJECT 
	  ID="MediaPlayer"  classid="CLSID:22d6f312-b0f6-11d0-94ab-0080c74c7e95" 
	  CODEBASE=
	   "http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=5,1,52,701"
	  width=320 height=50
	  standby="Loading Microsoft Windows Media Player components..." 
	  type="application/x-oleobject">
		<PARAM NAME="FileName"           VALUE="' . $listenlnk . '">
		<PARAM NAME="TransparentAtStart" Value="true">
		<PARAM NAME="AutoStart"          Value="true">
		<PARAM NAME="AnimationatStart"   Value="false">
	  <PARAM NAME="ShowStatusBar"      Value="true">	
	  <PARAM NAME="ShowControls"       Value="true">
		<PARAM NAME="autoSize" 		 Value="false">
		<PARAM NAME="displaySize" 	 Value="0">
		<Embed type="application/x-mplayer2"
		  pluginspage="http://www.microsoft.com/Windows/MediaPlayer/"
		  src="' . $listenlnk . '"
		  Name=MediaPlayer
		  AutoStart=1
		  Width=320
		  Height=50
		  transparentAtStart=0
		  autostart=1
		  animationAtStart=0
		  ShowStatusBar=1
		  ShowControls=1
		  autoSize=0
		  displaySize=0></embed>
	</OBJECT>
	</td>
	</tr>
	</table>
	</body>
	</html>';
  }

  if ($_GET['type'] == 'rp')
  {
    echo '
	<html>
	<head>
	<link rel="stylesheet" type="text/css" href="'.$STYLEURL.'/main.css" />
	<title>' . $SITENAME . ' Real Player</title>
	</head>
	<body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0">
	<table class="main" cellpadding="6" cellspacing="1" border="0" width="100%" align="center">
		<tr>
			<td class="block">
				<div align="center">' . $SITENAME . ': Real Player</div></td>
		</tr>
	<tr>
	<td class="blocklist" align="center" id="radio">
	<OBJECT ID=RVOCX CLASSID="clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA" WIDTH=375 HEIGHT=100>                
		<param name="src" value="' . $listenlnk . '">                
		<param name="autostart" value="-1">                
		<param name="console" value="one">
			<param name="controls" value="all">                
		<embed type="audio/x-pn-realaudio-plugin" SRC="' . $listenlnk . '" WIDTH=375 HEIGHT=100 NOJAVA=true AUTOSTART=true CONTROLS=All CONSOLE=one>
			</embed>
		</OBJECT>	
	</td>
	</tr>
	</table>
	</body>
	</html>';
  }

  if ($_GET['type'] == 'qt')
  {
    echo '
	<html>
	<head>
	<link rel="stylesheet" type="text/css" href="'.$STYLEURL.'/main.css" />
	<title>' . $SITENAME . ' Quicktime</title>
	</head>
	<body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0">
	<table class="main" cellpadding="6" cellspacing="1" border="0" width="100%" align="center">

		<tr>
			<td class="block">
				<div align="center">' . $SITENAME . ': QuickTime</div></td>
		</tr>
	<tr>

	<td class="blocklist" align="center" id="radio">
		<object classid="clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B" width="300" height="30" codebase="http://www.apple.com/qtactivex/qtplugin.cab">
			  <param name="src" value="' . $listenamp. '" />
			  <param name="autoplay" value="true" />
			  <param name="controller" value="true" />
			  <embed height="30" width="300" src="' . $listenamp . '" pluginspage="http://www.apple.com/quicktime/download/" type="video/quicktime" controller="true" autoplay="true" />
		</object>	
	</td>
	</tr>
	</table>
	</body>
	</html>';
  }

?>