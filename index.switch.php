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


// assign main content
switch ($pageID) {

    case 'modules':
        $module_name=htmlspecialchars($_GET["module"]);
        $modules=get_result("SELECT * FROM {$TABLE_PREFIX}modules WHERE name=".sqlesc($module_name)." LIMIT 1",true,$btit_settings["cache_duration"]);
        if (count($modules)<1) // MODULE NOT SET
           stderr($language["ERROR"],$language["MODULE_NOT_PRESENT"]);

        if ($modules[0]["activated"]=="no") // MODULE SET BUT NOT ACTIVED
           stderr($language["ERROR"],$language["MODULE_UNACTIVE"]);

        $module_out="";
        if (!file_exists("$THIS_BASEPATH/modules/$module_name/index.php")) // MODULE SET, ACTIVED, BUT WRONG FOLDER??
           stderr($language["ERROR"],$language["MODULE_LOAD_ERROR"]."<br />\n$THIS_BASEPATH/modules/$module_name/index.php");

        // ALL OK, LET GO :)
        require("$THIS_BASEPATH/modules/$module_name/index.php");
        $tpl->set("main_content",set_block(ucfirst($module_name),"center",$module_out));
        $tpl->set("main_title","Index->Modules->".ucfirst($module_name));
        break;

    case 'admin':
        require("$THIS_BASEPATH/admin/admin.index.php");
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->Admin");
        // the main_content for current template is setting within admin/index.php
        break;
                
    case 'forum':
        if($btit_settings["fmhack_xbtit_->_SMF_style_bridge"]=="enabled" && substr($GLOBALS["FORUMLINK"],0,3)=="smf")
        {
            //just incase they switch back to internal!
            $switch=get_result("SELECT `smf_style` FROM `{$TABLE_PREFIX}style_bridge` WHERE `xbtit_style`=".$CURUSER["style"],false,$btit_settings['cache_duration']);
            $toswitch=$switch[0]["smf_style"];
            quickquery("UPDATE `{$db_prefix}members` SET ".(($GLOBALS["FORUMLINK"]=="smf")?"`ID_THEME`":"`id_theme`")."=$toswitch WHERE ".(($GLOBALS["FORUMLINK"]=="smf")?"`ID_MEMBER`":"`id_member`")."=".$CURUSER["smf_fid"]);
        }
        require("$THIS_BASEPATH/forum/forum.index.php");
        $tpl->set("main_title","Index->Forum");
        break;

    //grabbed
    case 'grabbed':
        require("$THIS_BASEPATH/grabbed.php");
        $tpl->set("main_content",set_block($language["GRAB_YDT"],"center",$grabbedtpl->fetch(load_template("grabbed.tpl"))));
        $tpl->set("main_title","Index->Grabbed Torrents");
        break;
    //end grabbed

        // Donation History by DiemThuy -->
        case 'don_hist':
        require("$THIS_BASEPATH/don_hist.php");
        break;

        case 'don_historie':
        require("$THIS_BASEPATH/don_historie.php");
        $tpl->set("main_content",set_block($language["DON_HISTORIE"],"center",$don_historietpl->fetch(load_template("don_historie.tpl"))));
        $tpl->set("main_title","Index->".$language["DON_HIST"]);
        break;
        // <-- Donation History by DiemThuy

        case 'donate':
        require("$THIS_BASEPATH/pp.php");        
        if($btit_settings["donate_mode"]=="custom")
        {
        $tpl->set("main_content",set_block($language["DONATE"],"center",$pptpl->fetch(load_template("pp_new.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->Donate");
        }
        else{
        $tpl->set("main_content",set_block($language["DONATE"],"center",$pptpl->fetch(load_template("pp.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->Donate");        	
        }
        break;

        case 'donatepz':
        require("$THIS_BASEPATH/pz.php");
        if($btit_settings["donate_mode"]=="custom")
        {        
        $tpl->set("main_content",set_block($language["DONATE"],"center",$aptpl->fetch(load_template("pz_new.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->Donate");
        }
        else{        
        $tpl->set("main_content",set_block($language["DONATE"],"center",$aptpl->fetch(load_template("pz.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->Donate");
        }
        break;

        case 'donatebc':
        require("$THIS_BASEPATH/bc.php");
        if($btit_settings["donate_mode"]=="custom")
        {         
        $tpl->set("main_content",set_block($language["DONATE"],"center",$bctpl->fetch(load_template("bc_new.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->Donate");
        }
        else{        
        $tpl->set("main_content",set_block($language["DONATE"],"center",$bctpl->fetch(load_template("bc.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->Donate");
        }
        break;
        
        case 'take':
        if($CURUSER["can_upload"]=="yes")
        $id=(isset($_GET["id"]) && is_numeric($_GET["id"])?intval($_GET["id"]):$id=0);
        do_sqlquery("UPDATE `{$TABLE_PREFIX}requests` SET `job`=".$CURUSER["uid"]." WHERE `id`=".$id."");
        redirect("index.php?page=viewrequests");
        break;
        
        case 'take2':
        if($CURUSER["can_upload"]=="yes")
        $id=(isset($_GET["id"]) && is_numeric($_GET["id"])?intval($_GET["id"]):$id=0);
        do_sqlquery("UPDATE `{$TABLE_PREFIX}requests` SET `job`=".$CURUSER["uid"]." WHERE `id`=".$id."");
        redirect("index.php?page=reqdetails&id=$id");
        break;

        case 'torrents':
        require("$THIS_BASEPATH/torrents.php");
        if($btit_settings["torrent_list"]=="classic")
        {
        $tpl->set("main_content",set_block($language["TORRENT_LIST"],"center",$torrenttpl->fetch(load_template("torrent.list.tpl")),($GLOBALS["usepopup"]?false:true)));
        }
        else{
        $tpl->set("main_content",set_block($language["TORRENT_LIST"],"center",$torrenttpl->fetch(load_template("torrent_list.tpl")),($GLOBALS["usepopup"]?false:true)));        	
        }
        $tpl->set("main_title",$title2);        
        break;;
//file host start
        case 'file_hosting':
        require("$THIS_BASEPATH/file_hosting.php");
        $tpl->set("main_content",set_block($language["FHOST"],"center",$file_hostingtpl->fetch(load_template("file_hosting.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->".$language["FHOST"]."");
        break;
        
        case 'get_file_hosting':
        require("$THIS_BASEPATH/get_file_hosting.php");
        break;
//file host end        
//apply for membership
        case 'apply':
        require(load_language("lang_apply_membership.php"));
        require("$THIS_BASEPATH/apply.php");
        $tpl->set("main_content",set_block($language['APPLY_MEMBERSHIP'],"center",$applytpl->fetch(load_template("apply.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->".$language['APPLY_MEMBERSHIP']."");
        break;
        
        case 'applysend':
        require("$THIS_BASEPATH/applysend.php");
        break;
//apply for membership                
// shouthistory
    case 'allshout':
        ob_start();
        require("$THIS_BASEPATH/ajaxchat/getHistoryChatData.php");
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->Shout History");
        $out=ob_get_contents();
        ob_end_clean();
        $tpl->set("main_content",set_block($language["SHOUTBOX"]." ".$language["HISTORY"],"left",$out));
        break;

    case 'comment':
        require("$THIS_BASEPATH/comment.php");
        $tpl->set("main_content",set_block($language["COMMENTS"],"center",$tpl_comment->fetch(load_template("comment.tpl")),false));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->Torrent->Comment");
        break;

    case 'notepad':
        require("$THIS_BASEPATH/notepad.php");
        $tpl->set("main_content",set_block($CURUSER["username"].$language["NOTEPAD"].$language["NOTEPAD1"].$arrnotes.$language["NOTEPAD3"].$language["NOTEPAD2"],"center",$notepadtpl->fetch(load_template("notepad.tpl"))));
        $tpl->set("main_title","Index->Notepad");
        break;

    case 'delete':
        require("$THIS_BASEPATH/delete.php");
        $tpl->set("main_content",set_block($language["DELETE_TORRENT"],"center",$torrenttpl->fetch(load_template("torrent.delete.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->Torrent->Delete");
        break;

    case 'edit':
        require("$THIS_BASEPATH/edit.php");
        $tpl->set("main_content",set_block($language["EDIT_TORRENT"],"center",$torrenttpl->fetch(load_template("torrent.edit.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->Torrent->Edit");
        break;

    case 'extra-stats':
        require("$THIS_BASEPATH/extra-stats.php");
        $tpl->set("main_content",set_block($language["MNU_STATS"],"center",$out));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->Statistics");
        break;
//uploadrequest
    case 'uploadrequest':
        require("$THIS_BASEPATH/uploadrequest.php");
        $tpl->set("main_content",set_block($language["ULR"],"center",$uploadrequesttpl->fetch(load_template("uploadrequest.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->".$language["ULR"]."");
        break;

        case 'uploadrequest2':
        require("$THIS_BASEPATH/uploadrequest2.php");
        break;
//end uploadrequest        
// DT reputaton systen start
        case 'reputation':
        require(load_language("lang_reputation.php"));
        require("$THIS_BASEPATH/reputation.php");
        $tpl->set("main_content",set_block($language["REPUTATION"],"center",$reputationpagetpl->fetch(load_template("reputation.tpl"))));
        $tpl->set("main_title","Index->Reputation");
        break;
        
        case 'reputationpage':
        require(load_language("lang_reputation.php"));
        require("$THIS_BASEPATH/reputationpage.php");
        $tpl->set("main_content",set_block($language["REPUTATION"],"center",$reputationpagetpl->fetch(load_template("reputationpage.tpl"))));
        $tpl->set("main_title","Index->Reputation");
        break;

        case 'plusmin':        
        require(load_language("lang_reputation.php"));
        require("$THIS_BASEPATH/plusmin.php");
        break;
// DT reputaton systen end
    // DT request hack start

    case 'addrequest':
        require("$THIS_BASEPATH/addrequest.php");
        break;

    case 'reqedit':
        require("$THIS_BASEPATH/reqedit.php");
        $tpl->set("main_content",set_block($language["RE"],"center",$reqedittpl->fetch(load_template("reqedit.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->reqedit");
        break;

    case 'reqreset':
        require("$THIS_BASEPATH/reqreset.php");
        break;

    case 'takedelreq':
        require("$THIS_BASEPATH/takedelreq.php");
        break;

    case 'takerequest':
        require("$THIS_BASEPATH/takerequest.php");
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->takerequest");
        break;

    case 'votesview':
        require("$THIS_BASEPATH/votesview.php");
        $tpl->set("main_content",set_block($language["VV"],"center",$votesviewtpl->fetch(load_template("votesview.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->votesview");
        break;

    case 'reqdetails':
        require("$THIS_BASEPATH/reqdetails.php");
        $tpl->set("main_content",set_block($language["RD"],"center",$reqdetailstpl->fetch(load_template("reqdetails.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->reqdetails");
        break;

    case 'reqfilled':
        require("$THIS_BASEPATH/reqfilled.php");
        $tpl->set("main_content",set_block($language["RF"],"center",$reqfilledtpl->fetch(load_template("reqfilled.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->reqfilled");
        break;

    case 'requests':
        require("$THIS_BASEPATH/requests.php");
        $tpl->set("main_content",set_block($language["R"],"center",$requeststpl->fetch(load_template("requests.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->requests");
        break;

    case 'takereqedit':
        require("$THIS_BASEPATH/takereqedit.php");
        break;

    case 'viewrequests':
        require("$THIS_BASEPATH/viewrequests.php");
        $tpl->set("main_content",set_block($language["VR"],"center",$viewrequeststpl->fetch(load_template("viewrequests.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->viewrequests");
        break;

    // DT request hack end

    case 'timedrank':
        require("$THIS_BASEPATH/timedrank.php");
        break;

    case 'history':
    case 'torrent_history':
        require("$THIS_BASEPATH/torrent_history.php");
        $tpl->set("main_content",set_block($language["MNU_TORRENT"],"center",$historytpl->fetch(load_template("torrent_history.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->Torrent->History");
        break;

    case 'login':
        require("$THIS_BASEPATH/login.php");
        $tpl->set("main_content",set_block($language["LOGIN"],"center",$logintpl->fetch(load_template("login.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->Login");
        break;

    case 'moresmiles':
        require("$THIS_BASEPATH/moresmiles.php");
        $tpl->set("main_content",set_block($language["MORE_SMILES"],"center",$moresmiles_tpl->fetch(load_template("moresmiles.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." "."More Smilies");
        break;

   case 'news':
        require("$THIS_BASEPATH/news.php");
        $tpl->set("main_content",set_block($language["MANAGE_NEWS"],"center",$newstpl->fetch(load_template("news.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->News");
        break;

    case 'peers':
        require("$THIS_BASEPATH/peers.php");
        $tpl->set("main_content",set_block($language["MNU_TORRENT"],"center",$peerstpl->fetch(load_template("peers.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->Torrent->Peers");
        break;

    case 'recover':
        require("$THIS_BASEPATH/recover.php");
        $tpl->set("main_content",set_block($language["RECOVER_PWD"],"center",$recovertpl->fetch(load_template("recover.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->Recover");
        break;

    case 'account':
    case 'signup':
    case 'invite':
        require("$THIS_BASEPATH/account.php");
        $tpl->set("more_css","<link rel=\"stylesheet\" type=\"text/css\" href=\"$BASEURL/jscript/passwdcheck.css\" />");
        $tpl->set("main_content",set_block($language["ACCOUNT_CREATE"],"center",$tpl_account->fetch(load_template("account.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->Signup");
        break;

    case 'torrent-details':
    case 'details':
        require("$THIS_BASEPATH/details.php");
        if($btit_settings["torrent_details"]=="classic")
        {
        $tpl->set("main_content",set_block($language["TORRENT_DETAIL"],"center",$torrenttpl->fetch(load_template("torrent.details.tpl")),($GLOBALS["usepopup"]?false:true)));
        }
        else{
        $tpl->set("main_content",set_block($language["TORRENT_DETAIL"],"center",$torrenttpl->fetch(load_template("torrent_details.tpl")),($GLOBALS["usepopup"]?false:true)));        	
        }
        $tpl->set("main_title",$title2);        
        break;

    case 'users':
        require("$THIS_BASEPATH/users.php");
        $tpl->set("main_content",set_block($language["MEMBERS_LIST"],"center",$userstpl->fetch(load_template("users.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->Users");
        break; 
//sb control
    case 'sb_control':
        require("$THIS_BASEPATH/sb_control.php");
        $tpl->set("main_content",set_block($language["SB_CONTROL"],"center",$sb_controltpl->fetch(load_template("sb_control.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->Seed Bonus Control");
        break;
//sb control
   
    case 'usercp':
        require("$THIS_BASEPATH/user/usercp.index.php");
        // the main_content for current template is setting within users/index.php
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->My Panel");
        break;

    case 'upload':
        require("$THIS_BASEPATH/upload.php");
        $tpl->set("main_content",set_block($language["MNU_UPLOAD"],"center",$uploadtpl->fetch(load_template("$tplfile.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->Torrent->Upload");
        break;

    case 'userdetails':
        require("$THIS_BASEPATH/userdetails.php");
        $tpl->set("main_content",set_block($language["USER_DETAILS"],"center",$userdetailtpl->fetch(load_template("userdetails.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->Users->Details");
        break;

    // Report users & Torrents by DiemThuy -->
    case 'report':
        require("$THIS_BASEPATH/report.php");
        $tpl->set("main_content",set_block($language["REP_ALLUSERS"],"center",$reporttpl->fetch(load_template("report.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->".$language["REP_ALLUSERS"]."");
        break;

    case 'reports':
        require("$THIS_BASEPATH/reports.php");
        $tpl->set("main_content",set_block($language["REP_ADMIN"],"center",$reportstpl->fetch(load_template("reports.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->".$language["REP_ADMIN"]."");
        break;

    case 'takedelreport':
        require("$THIS_BASEPATH/takedelreport.php");
        break;
    // <-- Report users & Torrents by DiemThuy

    // FMreseed hack
    case 'reseed':
        require("$THIS_BASEPATH/reseed.php");
        $tpl->set("main_content",set_block($language["AFR_RESEED"],"center",$torrenttpl->fetch(load_template("reseed.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->reseed");
        break;
    // FM end reseed hack

    case 'viewnews':
        require("$THIS_BASEPATH/viewnews.php");
        $tpl->set("main_content",set_block($language["LAST_NEWS"],"center",$viewnewstpl->fetch(load_template("viewnews.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->News");
        break;
    case 'lottery_tickets':
        require("$THIS_BASEPATH/lottery.tickets.php");
        $tpl->set("main_content",set_block($language["LOTTERY"],"center",$ticketstpl->fetch(load_template("lottery.tickets.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->".$language["LOTTERY"]."");
        break;

    case 'lottery_winners':
        require("$THIS_BASEPATH/lottery.winners.php");
        $tpl->set("main_content",set_block($language["LOTTERY"],"center",$ticketstpl->fetch(load_template("lottery.winners.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->".$language["LOTTERY"]."");
        break;

    case 'lottery_purchase':
        require("$THIS_BASEPATH/lottery.purchase.php");
        $tpl->set("main_content",set_block($language["LOTTERY"],"center",$ticketstpl->fetch(load_template("lottery.purchase.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->".$language["LOTTERY"]."");
        break;
 
    case 'booted':
        require("$THIS_BASEPATH/booted.php");
        break;

    case 'rebooted':
        require("$THIS_BASEPATH/rebooted.php");
        break;        
         
    case 'warn':
        require("$THIS_BASEPATH/warn.php");
        $tpl->set("main_content",set_block($language["WS_WARN"],"center",$warntpl->fetch(load_template("warn.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->".$language["WS_WARN"]);
        break;

    case 'warnlog':
        require("$THIS_BASEPATH/warnlog.php");
        $tpl->set("main_content",set_block($language["WS_WARNLOG"],"center",$warnlogtpl->fetch(load_template("warnlog.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->".$language["WS_WARNLOG"]);
        break;

    case 'rewarn':
        require("$THIS_BASEPATH/rewarn.php");
        break;        
        
    case 'downloadcheck':
        require("$THIS_BASEPATH/downloadcheck.php");
        $tpl->set("main_content",set_block($language["DOWNLOAD_CHECK"],"center",$dlchecktpl->fetch(load_template("downloadcheck.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->Download Check");
        break;

    /*Mod by losmi - rules mod*/
    case 'rules':
        require("$THIS_BASEPATH/rules.php");
        $tpl->set("main_content",set_block($language["RULES"],"center",$rulestpl->fetch(load_template("rules.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->Rules");
        break;
    /*End mod by losmi rules - mod*/

	case 'dj':
		require(load_language("lang_shoutcast.php"));
        require("$THIS_BASEPATH/dj.php");
        $tpl->set("main_content",set_block($language["djhead"],"center",$djtpl->fetch(load_template("dj.tpl"))));
        $tpl->set("main_title","Index->".$language["djhead"]."");
        break;
		
	case 'dj_faq':
		require(load_language("lang_shoutcast.php"));
        require("$THIS_BASEPATH/dj_faq.php");
        $tpl->set("main_content",set_block($language["faq"],"center",$djfaqtpl->fetch(load_template("djfaq.tpl"))));
        $tpl->set("main_title","Index->".$language["faq"]."");
        break;

	case 'listeners':
		require(load_language("lang_shoutcast.php"));
        require("$THIS_BASEPATH/whos_listening.php");
        $tpl->set("main_content",set_block($language["list"],"center",$listennowtpl->fetch(load_template("listen.tpl"))));
        $tpl->set("main_title","Index->".$language["list"]."");
        break;

    // betting mod start 
    case 'bet':
        require("$THIS_BASEPATH/bet.php");
        $tpl->set("main_content",set_block($language["BETTING"],"center",$bettpl->fetch(load_template("bet.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->Betting");
        break;
        
    case 'betinfo':
        require("$THIS_BASEPATH/bet_info.php");
        $tpl->set("main_content",set_block($language["BETTING"],"center",$betinfotpl->fetch(load_template("bet_info.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->Betting");
        break;
        
    case 'betgameinfo':
        require("$THIS_BASEPATH/bet_gameinfo.php");
        $tpl->set("main_content",set_block($language["BETTING"],"center",$betgameinfotpl->fetch(load_template("bet_gameinfo.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->Betting");
        break;
        
    case 'betadmin':
        require("$THIS_BASEPATH/bet_admin.php");
        $tpl->set("main_content",set_block($language["BETTING"],"center",$betadmintpl->fetch(load_template("bet_admin.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->Betting");
        break;
        
    case 'bettakeedit':
        require("$THIS_BASEPATH/bet_takeedit.php");
        break;
        
    case 'betactive':
        require("$THIS_BASEPATH/bet_active.php");
        break;
        
    case 'betaddoption':
        require("$THIS_BASEPATH/bet_addopt.php");
        break;
        
    case 'betdelgame':
        require("$THIS_BASEPATH/bet_delgame.php");
        break;
        
    case 'betdelopt':
        require("$THIS_BASEPATH/bet_delopt.php");
        break;
        
    case 'betopttwee':
        require("$THIS_BASEPATH/bet_opt2.php");
        $tpl->set("main_content",set_block($language["BETTING"],"center",$betopttweetpl->fetch(load_template("bet_opt2.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->Betting");
        break;
        
    case 'betodds':
        require("$THIS_BASEPATH/bet_odds.php");
        $tpl->set("main_content",set_block($language["BETTING"],"center",$betoddstpl->fetch(load_template("bet_odds.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->Betting");
        break;
        
    case 'betoddstwo':
        require("$THIS_BASEPATH/bet_odds2.php");
        break;
        
    case 'betaddonetwo':
        require("$THIS_BASEPATH/bet_add1x2.php");
        break;
        
    case 'bettakenew':
        require("$THIS_BASEPATH/bet_takenew.php");
        break;
        
    case 'betcoupon':
        require("$THIS_BASEPATH/bet_coupon.php");
        $tpl->set("main_content",set_block($language["BETTING"],"center",$betcoupontpl->fetch(load_template("bet_coupon.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->Betting");
        break;

    case 'betoption':
        require("$THIS_BASEPATH/bet_opt.php");
        $tpl->set("main_content",set_block($language["BETTING"],"center",$betopttpl->fetch(load_template("bet_opt.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->Betting");
        break;
        
    case 'betbonustop':
        require("$THIS_BASEPATH/bet_bonustop.php");
        $tpl->set("main_content",set_block($language["BETTING"],"center",$betbonustpl->fetch(load_template("bet_bonustop.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->Betting");
        break;
        
    case 'betback':
        require("$THIS_BASEPATH/bet_nullbet.php");
        $tpl->set("main_content",set_block($language["BETTING"],"center",$betbacktpl->fetch(load_template("bet_nullbet.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->Betting");
        break;
        
    case 'betfinish':
        require("$THIS_BASEPATH/bet_gamefinish.php");
        $tpl->set("main_content",set_block($language["BETTING"],"center",$betfinishtpl->fetch(load_template("bet_gamefinish.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->Betting");
        break;
        
    case 'betfinishtwo':
        require("$THIS_BASEPATH/bet_gamefinish2.php");
        $tpl->set("main_content",set_block($language["BETTING"],"center",$betfintwotpl->fetch(load_template("bet_gamefinish2.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->Betting");
        break;
    // betting mod end

    //ban button
    case 'banbutton':
        require("$THIS_BASEPATH/banbutton.php");
        $tpl->set("main_content",set_block($language["DTBAN"],"center",$banbuttontpl->fetch(load_template("banbutton.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->".$language["DTBAN"]."");
        break;
    //end ban button

    case 'subtitles':
        require("$THIS_BASEPATH/subtitles.php");
        $tpl->set("main_content",set_block($language['SUB_T_H'],"center",$substpl->fetch(load_template("subs.tpl"))));
        $tpl->set("main_title","Index->Subtitles");
        break; 
    case 'subsearch':
        require("$THIS_BASEPATH/subtitles_search.php");
        $tpl->set("main_content",set_block($language['SUB_T_S'],"center",$subsearchtpl->fetch(load_template("subsearch.tpl"))));
        $tpl->set("main_title","Index->Subtitles Search");
        break; 
    case 'subadd':
        require("$THIS_BASEPATH/subtitle_add.php");
        $tpl->set("main_content",set_block($language['SUB_ADD_H'],"center",$subsaddtpl->fetch(load_template("subadd.tpl"))));
        $tpl->set("main_title","Index->Add Subtitle");
        break;
    case 'subedit':
        require("$THIS_BASEPATH/subs_edit.php");
        $tpl->set("main_content",set_block($language['SUB_T_E'],"center",$subsedittpl->fetch(load_template("subsedit.tpl"))));
        $tpl->set("main_title","Index->Edit Subtitle");
        break;              
    case 'moder':
        require("$THIS_BASEPATH/moder.php");
        $tpl->set("main_content",set_block($language["MODERATE_TORRENT"],"center",$torrenttpl->fetch(load_template("admin.moder.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->Torrent->Moderate");
        break;

    // private history
    case 'allPshout':
        ob_start();
        require("$THIS_BASEPATH/ajaxchat/getHistoryPChatData.php");
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->Shout History");
        $out=ob_get_contents();
        ob_end_clean();
        $tpl->set("main_content",set_block($language["SHOUTBOX"]." ".$language["HISTORY"],"left",$out));
        break;

    // private shout
    case 'Pshout':
        ob_start();
        require("$THIS_BASEPATH/shoutp.php");
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->".$language['SHOUTBOXP']."");
        $out=ob_get_contents();
        ob_end_clean();
        $tpl->set("main_content",set_block($language['SHOUTBOXP'],"left",$out));
        break;

    case 'comment-edit':
        require("$THIS_BASEPATH/commedit.php");
        $tpl->set("main_content",set_block($language["COMMENTS"],"center",$tpl_comment->fetch(load_template("comment.edit.tpl")),false));
        $tpl->set("main_title",$btit_settings["name"]." .::. ".$language["NCL_COM_EDIT"]);
        break;

    /*Mod by losmi - faq mod*/
    case 'faq':
        require("$THIS_BASEPATH/faq.php");
        $tpl->set("main_content",set_block($language["MNU_FAQ"],"center",$faqtpl->fetch(load_template("faq.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->F.A.Q.");
        break;
    /*End mod by losmi faq - mod*/

    //Bookmark
    case 'bookmark':
        require("$THIS_BASEPATH/bookmark.php");
        $tpl->set("main_content",set_block($language["BOOKMARK"],"center",$bookmarktpl->fetch(load_template("bookmark.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->".$language["BOOKMARK"]."");
        break;
    //end Bookmark

    case 'success':
        redirect("paypalsynch.php?tx=".$_GET["tx"]."&st=".$_GET["st"]."&amt=".$_GET["amt"]."&cc=".$_GET["cc"]."&cm=".$_GET["cm"]."&item_number=".$_GET["item_number"]);
        break;

    case 'complete':
        require("$THIS_BASEPATH/paypalsynchcp.php");
        $tpl->set("main_content",set_block($language["AADS_COOLY_THANKS"],"center",$synchtpl->fetch(load_template("ppsynch.tpl"))));
        $tpl->set("main_title","Index->".$language["SUCCESS"]);
        break;

	// user images       
    case 'user_img':
        require("$THIS_BASEPATH/user_img.php");
        $tpl->set("main_content",set_block($language["UIMG"],"center",$user_imgtpl->fetch(load_template("user_img.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. ".$language["UIMG"]);
        break;
    // user images

	case 'watch':
        if($CURUSER["delete_users"]!=="yes")
		    redirect("index.php");
		$wid=(isset($_GET["wid"])?intval($_GET["wid"]):$wid=0);
		$do=(isset($_GET["do"])?htmlentities($_GET["do"]):$do='');
		if($do=="on")
        {
		    do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `IS_WATCHED`='yes' WHERE id=".$wid);
		}
        elseif($do=="off")
        {
		    do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `IS_WATCHED`='no' WHERE id=".$wid);
		}
		redirect("index.php?page=userdetails&id=".$wid."");
        break;

      //Partners
    case 'partners':
        require("$THIS_BASEPATH/partners.php");
        $tpl->set("main_content",set_block($language["PARTNERS"],"center",$partnerstpl->fetch(load_template("partners.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->".$language["PARTNERS"]);
        break;
        //Partners

    case 'teams':
      require_once(load_language("lang_teams.php"));
      include("$THIS_BASEPATH/teams-view.php");
      $tpl->set("main_content",set_block($language["TEAM_HEAD_PUB"],"center",$teampubtpl->fetch(load_template("teampub.tpl"))));
      break;

    case 'teaminfo':
      require_once(load_language("lang_teams.php"));
      include("$THIS_BASEPATH/team-stats.php");
      $tpl->set("main_content",set_block($language["TEAM_INFO"],"center",$teamstatstpl->fetch(load_template("teamstats.tpl"))));
      break;
        
    case 'sbg_login':
      require("$THIS_BASEPATH/sbg_login.php");
      $tpl->set("main_content",set_block($language["LOGIN"],"center",$sbg_logintpl->fetch(load_template("sbg_login.tpl"))));
      $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->Login");
      break;
        
    case 'rbg_login':
      require("$THIS_BASEPATH/rbg_login.php");
      $tpl->set("main_content",set_block($language["LOGIN"],"center",$sbg_logintpl->fetch(load_template("rbg_login.tpl"))));
      $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->Login");
      break;

    case 'private':
      require("$THIS_BASEPATH/private.php");
      $tpl->set("main_content",set_block($language["PRIVATE"],"center",$privatetpl->fetch(load_template("private.tpl"))));
      $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->Private");
      break;
    
    case 'agree':
      require(load_language("lang_agree.php"));
      require("$THIS_BASEPATH/agree.php");
      $tpl->set("main_content",set_block($language["AGREE"],"center",$agreetpl->fetch(load_template("agree.tpl"))));
      $tpl->set("main_title","Index->Agree");
      break;
       
// Social Network DT
    case 'friendlist':
        require("$THIS_BASEPATH/friendlist.php");
        $tpl->set("main_content",set_block($language["FRIENDLIST"],"center",$friendtpl->fetch(load_template("friendlist.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->".$language["FL_FRIENDLIST"]."");
        break;
        
    case 'friends':
        require("$THIS_BASEPATH/friends.php");
        $tpl->set("main_content",set_block($language["FRIENDS"],"center",$friendstpl->fetch(load_template("friends.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->".$language["FL_FRIENDS"]);
        break;   
//End Social Network DT

    case 'fls':
        require("$THIS_BASEPATH/fls.php");
        break; 

		//Hack made by hasu
    case 'coins':
        require("$THIS_BASEPATH/coins.php");
        $tpl->set("main_title","Index->".$language["SEND_POINTS"]);
        break;  
    //Hack made by hasu
    //Referral System
        case 'referral':
        require(load_language("lang_main.php"));
        require("$THIS_BASEPATH/admin/admin.referral.php");
        $tpl->set("main_content",set_block($language['REFERRAL_SYSTEM_SETTINGS'],"center",$referraltpl->fetch(load_template("admin.referral.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->".$language['REFERRAL_SYSTEM_SETTINGS']."");
        break;
        
    case 'index':
    case '':
    default:
        $tpl->set("main_content",center_menu());
        break;
}


?>