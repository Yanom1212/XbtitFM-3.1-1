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

if (!defined("IN_ACP"))
      die("non direct access!");


include(load_language('lang_usercp.php'));

if (!function_exists('get_user_combo'))
{
  function get_user_combo($select, $opts=array()) {
    $name=(isset($opts['name']))?' name="'.$opts['name'].'" id="'.$opts['name'].'"':'';
    $complete=(isset($opts['complete']))?(bool)$opts['complete']:false;
    $default=(isset($opts['default']))?$opts['default']:NULL;
    $id=(isset($opts['id']))?$opts['id']:'id';
    $value=(isset($opts['value']))?$opts['value']:'value';
    $combo='';

    if ($complete)
      $combo.='<select'.$name.'>';

    foreach ($select as $option) {
      $combo.="\n".'<option ';
      if ( (!is_null($default)) && ($option[$id]==$default) )
        $combo.='selected="selected" ';
      $combo.='value="'.$option[$id].'">'.unesc($option[$value]).'</option>';
    }

    if ($complete)
      $combo.='</select>';

    return $combo;
  }
}



switch ($action) {
    case 'save_ok':
         success_msg($language['SUCCESS'], 'New user has been added in our database<br /><a href="index.php?page=admin&amp;user='.$CURUSER['uid'].'&amp;code='.$CURUSER['random'].'">'.$language['MNU_ADMINCP'].'</a>');
         stdfoot(true,false);
         die();
         break;

    case 'save_pb':
         information_msg($language['SUCCESS'], 'New user has been added in our database<br />but a problem occured sending him the confirm email<br /><a href="index.php?page=admin&amp;user='.$CURUSER['uid'].'&amp;code='.$CURUSER['random'].'">'.$language['MNU_ADMINCP'].'</a>');
         stdfoot(true,false);
         die();
         break;

    case '':
    default:
         # init options
         $opts['name']='level';
         $opts['id']='id';
         $opts['value']='level';
         $opts['complete']=true;
         $opts['default']=3;
         # rank list
         $ranks=rank_list();
         $admintpl->set('rank_combo',get_user_combo($ranks, $opts));
      if($btit_settings["add_new_user_language"]!="disabled")
      {
         # lang list
         $opts['name']='language';
         $opts['id']='id';
         $opts['value']='language';
         $opts['default']=$btit_settings['default_language'];
         $opts['complete']=true;
         $langs=language_list();
         $admintpl->set('language_combo',get_user_combo($langs, $opts));
      }
      if($btit_settings["add_new_user_style"]!="disabled")
      {
         # style list
         $opts['name']='style';
         $opts['id']='id';
         $opts['value']='style';
         $opts['default']=$btit_settings['default_style'];
         $opts['complete']=true;
         $styles=style_list();
         $admintpl->set('style_combo',get_user_combo($styles, $opts));
      }
         break;
}

# set template info
$admintpl->set('frm_action','index.php?page=admin&amp;user='.$CURUSER['uid'].'&amp;code='.$CURUSER['random'].'&amp;do=newuser');
$admintpl->set('frm_cancel','index.php?page=admin&user='.$CURUSER['uid'].'&code='.$CURUSER['random']);
$admintpl->set('insert_ok','index.php?page=admin&user='.$CURUSER['uid'].'&code='.$CURUSER['random'].'&do=newuser&action=save_ok');
$admintpl->set('insert_pb','index.php?page=admin&user='.$CURUSER['uid'].'&code='.$CURUSER['random'].'&do=newuser&action=save_pb');
if($btit_settings["fmhack_force_ssl"]=="enabled" && $CURUSER["force_ssl"]=="yes")
{
$btit_settings['url']=str_replace("http","https",$btit_settings['url']);
}
$admintpl->set('tracker_url',$btit_settings['url']);
$admintpl->set('user_id',$CURUSER['uid']);
$admintpl->set('user_code',$CURUSER['random']);
$admintpl->set('language',$language);
$admintpl->set('edit_user',$edit,true);
$admintpl->set("add_new_user_language_enabled", (($btit_settings["add_new_user_language"]=="disabled")?false:true), true);
$admintpl->set("add_new_user_style_enabled", (($btit_settings["add_new_user_style"]=="disabled")?false:true), true);
$admintpl->set("lang_form", "<input type='hidden' name='language' id='language' value='".$btit_settings["default_language"]."' />");
$admintpl->set("style_form", "<input type='hidden' name='style' id='style' value='".$btit_settings["default_style"]."' />");

?>