<script type="text/javascript">
function ShowHide(id,id1) {
    obj = document.getElementsByTagName("div");
    if (obj[id].style.display == 'block'){
     obj[id].style.display = 'none';
     obj[id1].style.display = 'block';
    }
    else {
     obj[id].style.display = 'block';
     obj[id1].style.display = 'none';
    }
}

function windowunder(link)
{
  window.opener.document.location=link;
  window.close();
}

function disable_button(state)
{
 document.getElementById('ty').disabled=(state=='1'?true:false);
}

at=new sack();

function ShowUpdate()
{
  var mytext=at.response + '';
  var myout=mytext.split('|');
  document.getElementById('thanks_div').style.display='block';
  document.getElementById('loading').style.display='none';
  document.getElementById('thanks_div').innerHTML = myout[0]; //at.response;
  disable_button(myout[1]);
}

function thank_you(ia)
{
  disable_button('1');
  at.resetData();
  at.onLoading=show_wait;
  at.requestFile='thanks.php';
  at.setVar('infohash',"'"+ia+"'");
  at.setVar('thanks',1);
  at.onCompletion = ShowUpdate;
  at.runAJAX();
}

function ShowThank(ia)
{
  at.resetData();
  at.onLoading=show_wait;
  at.requestFile='thanks.php';
  at.setVar('infohash',"'"+ia+"'");
  at.onCompletion = ShowUpdate;
  at.runAJAX();
}

function show_wait()
{
  document.getElementById('thanks_div').style.display='none';
  document.getElementById('loading').style.display='block';
}

function dt_disable_button(state)
{
 document.getElementById('tys').disabled=(state=='1'?true:false);
}

tat=new sack();

function dt_ShowUpdate()
{
  var mytexta=tat.response + '';
  var myouta=mytexta.split('|');
  document.getElementById('reencode_div').style.display='block';
  document.getElementById('loadinga').style.display='none';
  document.getElementById('reencode_div').innerHTML = myouta[0]; //at.response;
  dt_disable_button(myouta[1]);
}

function dt_thank_you(ia)
{
  dt_disable_button('1');
  tat.resetData();
  tat.onLoading=dt_show_wait;
  tat.requestFile='reencode.php';
  tat.setVar('infohash',"'"+ia+"'");
  tat.setVar('reencode',1);
  tat.onCompletion = dt_ShowUpdate;
  tat.runAJAX();
}

function dt_ShowThank(ia)
{
  tat.resetData();
  tat.onLoading=dt_show_wait;
  tat.requestFile='reencode.php';
  tat.setVar('infohash',"'"+ia+"'");
  tat.onCompletion = dt_ShowUpdate;
  tat.runAJAX();
}

function dt_show_wait()
{
  document.getElementById('reencode_div').style.display='none';
  document.getElementById('loadinga').style.display='block';
}

function dt_disable_buttonb(state)
{
 document.getElementById('tyt').disabled=(state=='1'?true:false);
}

fat=new sack();

function dt_ShowUpdateb()
{
  var mytextb=fat.response + '';
  var myoutb=mytextb.split('|');
  document.getElementById('reencodeb_div').style.display='block';
  document.getElementById('loadingb').style.display='none';
  document.getElementById('reencodeb_div').innerHTML = myoutb[0]; //at.response;
  dt_disable_buttonb(myoutb[1]);
}

function dt_thank_youb(ia)
{
  dt_disable_buttonb('1');
  fat.resetData();
  fat.onLoading=dt_show_waitb;
  fat.requestFile='reencodeb.php';
  fat.setVar('infohashb',"'"+ia+"'");
  fat.setVar('reencodeb',1);
  fat.onCompletion = dt_ShowUpdateb;
  fat.runAJAX();
}

function dt_ShowThankb(ia)
{
  fat.resetData();
  fat.onLoading=dt_show_waitb;
  fat.requestFile='reencodeb.php';
  fat.setVar('infohashb',"'"+ia+"'");
  fat.onCompletion = dt_ShowUpdateb;
  fat.runAJAX();
}

function dt_show_waitb()
{
  document.getElementById('reencodeb_div').style.display='none';
  document.getElementById('loadingb').style.display='block';
}

function refresh_peers(myvar)
{
    var xhReq = new XMLHttpRequest();
    xhReq.open("GET", "refresh_peers.php?id="+myvar, false);
    xhReq.send(null);
    var serverResponse = xhReq.responseText;
    var new_peers=serverResponse.split('[*]');
    document.getElementById("peer_counts").innerHTML = "<tag:language.SEEDERS />: <a href='index.php?page=peers&amp;id=<tag:torrent.info_hash />'>"+new_peers[0]+"</a>, <tag:language.LEECHERS />:  <a href='index.php?page=peers&amp;id=<tag:torrent.info_hash />'>"+new_peers[1]+"</a> = <a href='index.php?page=peers&amp;id=<tag:torrent.info_hash />'>"+new_peers[2]+"</a> <tag:language.PEERS />&nbsp;&nbsp;&nbsp;<img src='<tag:BASEURL />/images/refresh.gif' border='0' onclick='refresh_peers(\"<tag:torrent.info_hash />\")' title='<tag:language.REFRESH_PEERS />' />";
}

</script>

<if:imageup_enabled>
<link rel="stylesheet" href="jscript/jquery.lightbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="jscript/jquery.lightbox.js"></script>
<script type="text/javascript">
var $q=jQuery.noConflict()
$q(function() {

	$q('a.lightbox').lightBox();

});
</script>
</if:imageup_enabled>


    <div align="center">

      <tag:TheTVDBExtra />

      <table width="100%" class="lista" border="0" cellspacing="5" cellpadding="5">
        <tr>
          <td align="right" class="header"><tag:language.FILE />
          <if:MOD>
          <tag:mod_task />
          </if:MOD>
          </td>
          <td class="lista" style="text-align:left;"><tag:torrent.filename2 /></td>
        </tr>
        <if:fls_enabled>
          <tr>
            <td align="right" class="header"><tag:language.FLS_CUSTOM_FL /></td>
            <td class="lista" style="text-align:left;" valign="middle"><if:hash_found><img src="images/fls_unlocked.png" border="0" alt="<tag:language.FLS_UNLOCKED />" title="<tag:language.FLS_UNLOCKED />" /><else:hash_found><if:have_slots1><a href="index.php?page=fls&id=<tag:torrent.info_hash />"></if:have_slots1><img src="images/fls_locked.png" border="0" alt="<tag:language.FLS_LOCKED />" title="<tag:language.FLS_LOCKED />" /><if:have_slots2></a></if:have_slots2></if:hash_found></td>
          </tr>
        </if:fls_enabled>
        <if:tmod1_enabled>
        <if:MODER>
            <tr>
              <td align="right" class="header"><tag:language.TORRENT_MODERATION /></td>
              <td class="lista" align="center"><tag:torrent.moderation /></td>
            </tr>
        </if:MODER>
        </if:tmod1_enabled>

        <if:download_locked>
        <if:need_intro>
        <tr>
          <td align="right" class="header"><tag:language.TORRENT /></td>
          <td class="lista"><span style="font-weight:bold;"><tag:language.IBD_NEED_TO_INTRODUCE_1 /> <if:newThread><tag:language.IBD_NEED_TO_INTRODUCE_2A /><else:newThread><tag:language.IBD_NEED_TO_INTRODUCE_2B /></if:newThread> <tag:language.IBD_NEED_TO_INTRODUCE_3 /> <tag:introForumLink /><tag:language.HERE /></a></span>.</td>
        </tr>
        </if:need_intro>
        <else:download_locked>
          <tr>
            <td align="right" class="header"><tag:language.TORRENT /></td>
            <if:dlratiocheck>
              <td class="lista" align="center" style="text-align:left;" valign="top"><if:magnet_enabled1><a href="<tag:magnetLink />"><img src="images/magnet.gif" alt="<tag:language.MAGNET_DOWN_USING />" title="<tag:language.MAGNET_DOWN_USING />" /></a><else:magnet_enabled1><a href="index.php?page=downloadcheck&amp;id=<tag:torrent.info_hash />"><tag:torrent.filename /></a></if:magnet_enabled1></td>
            <else:dlratiocheck>
              <td class="lista" align="center" style="text-align:left;" valign="top"><if:magnet_enabled2><a href="<tag:magnetLink />"><img src="images/magnet.gif" alt="<tag:language.MAGNET_DOWN_USING />" title="<tag:language.MAGNET_DOWN_USING />" /></a><else:magnet_enabled2><a href="download.php?id=<tag:torrent.info_hash />&amp;f=<tag:down_filename />.torrent"><tag:torrent.filename /></a></if:magnet_enabled2></td>
            </if:dlratiocheck>
          </tr>
        </if:download_locked>

        <if:ddl_enabled>
        <if:has_direct_link>
        <tr>
          <td align="right" class="header"><tag:language.DIRECT_DOWNLOAD /></td>
          <td class="lista" align="center" style="text-align:left;" valign="top"><a href="<tag:direct_link />" target="_blank"><img src="<tag:BASEURL />/images/ddl.png" border="0" alt="<tag:language.DIRECT_DOWNLOAD />" title="<tag:language.DIRECT_DOWNLOAD />" /></a></td>
        </tr>
        </if:has_direct_link>
        </if:ddl_enabled>

        <if:mult_enabled>
        <tr>
          <td align='right' class='header'><tag:language.UPM_UPL_MULT /></td>
          <td align='left' class='lista' colspan='2'><tag:mult /></td>
        </tr>
        </if:mult_enabled>

        <if:auto_topic_enabled>
        <if:FORUM_LNK>
        <tr>
          <td align="right" class="header"><tag:language.FORUM /></td>
          <td class="lista" align="center"><tag:torrent.topicid /></td>
        </tr>
        </if:FORUM_LNK>
        </if:auto_topic_enabled>

        <tr>
          <td align="right" class="header"><tag:language.INFO_HASH /></td>
          <td class="lista" align="center" style="text-align:left;" valign="top"><tag:torrent.info_hash /></td>
        </tr>

		<if:addthis_enabled>
        <tr>
          <td align="right" class="header"><tag:language.ADDTHIS_SHARE2 /></td>
		  <td class="lista" align="center" style="text-align:left;" valign="top"><tag:show_addthis /></td>
        </tr>
		</if:addthis_enabled>

        <if:reenc_enabled>
        <tr>
          <td align="right" class="header" valign="top"><tag:language.REENCODE /></td>
          <td class="lista" align="center">
              <form action="reencode.php" method="post" onsubmit="return false">
              <div id="reencode_div" name="reencode_div" style="display:block;"></div>
              <div id="loadinga" name="loadinga" style="display:none;"><img src="images/ajax-loader.gif" alt="" title="ajax-loader" /></div>
              <input type="button" id="tys" disabled="disabled" value="<tag:language.REENCODER />" onclick="dt_thank_you('<tag:torrent.info_hash />')" />
              </form>
              <script type="text/javascript">dt_ShowThank('<tag:torrent.info_hash />');</script>


                        <form action="reencodeb.php" method="post" onsubmit="return false">
              <div id="reencodeb_div" name="reencodeb_div" style="display:block;"></div>
              <div id="loadingb" name="loadingb" style="display:none;"><img src="images/ajax-loader.gif" alt="" title="ajax-loader" /></div>
              <input type="button" id="tyt" disabled="disabled" value="<tag:language.REENCODERB />" onclick="dt_thank_youb('<tag:torrent.info_hash />')" />
              </form>
              <script type="text/javascript">dt_ShowThankb('<tag:torrent.info_hash />');</script>
          </td>
          </tr>
          </if:reenc_enabled>

        <if:teams_enabled>
        <tag:teamview />
        </if:teams_enabled>

         <if:thanks_enabled>
         <tr>
          <td align="right" class="header" valign="top"><tag:language.THANKS_USERS /></td>
          <td class="lista" align="center">
              <form action="thanks.php" method="post" onsubmit="return false">
              <div id="thanks_div" name="thanks_div" style="display:block;"></div>
              <div id="loading" name="loading" style="display:none;"><img src="images/ajax-loader.gif" alt="" title="ajax-loader" /></div>
              <input type="button" id="ty" disabled="disabled" value="<tag:language.THANKS_YOU />" onclick="thank_you('<tag:torrent.info_hash />')" />
              </form>
              <script type="text/javascript">ShowThank('<tag:torrent.info_hash />');</script>
          </td>
        </tr>
        </if:thanks_enabled>

        <!--

        NOTE: If using both the IMDB and image upload hacks you can replace "<tag:uploaddir /><tag:torrent.image />" with
              <tag:torrent.alt_image_imgup /> to get an either/or image with Image upload having priority. To have IMDB with
              priority use <tag:torrent.alt_image_imdb /> instead.

        -->
        <if:give_points_enabled>
        <tr>
         <td align="right" class="header" valign="top"><tag:language.SEND_POINTS /></td>
         <td class="lista" align="center" style="text-align:left;" valign="top"><tag:coin /></td>
        </tr>
        </if:give_points_enabled> 
        <if:imageup_enabled2>
        <if:IMAGEIS>
        <tr>
          <td align="right" class="header" valign="top"><tag:language.IMAGE /></td>
          <td class="lista" align="center"><a href="<tag:uploaddir /><tag:torrent.image />" title="view image" class="lightbox"><img src="<tag:uploaddir /><tag:torrent.image />" width=<tag:width />></a></td>
        </tr>
        </if:IMAGEIS>
        </if:imageup_enabled2>

        <tr>
          <td align="right" class="header" valign="top"><tag:language.DESCRIPTION /></td>
          <td class="lista" align="center" style="text-align:left;" valign="top">

            <if:nfo_enabled>
            <if:view_nfo>
            <if:nfo_exists>
              <div align=right><a href='#nfo' onclick='javascript:ShowHide("slidenfo","");'><tag:language.NFO_SHOW_HIDE /></a></div>
                <div align='center' style='display:none' id='slidenfo'>
                  <img src='nfo/nfogen.php?nfo=rep/<tag:torrent.info_hash />.nfo&colour=1'>
                </div>
              </div>
            </if:nfo_exists>
            </if:view_nfo>
            </if:nfo_enabled>

          <tag:torrent.description /></td>
        </tr>

        <if:media_enabled>
        <tr>
          <td align="right" class="header" valign="top"><tag:language.MPLAYER /></td>
          <td class="lista" align="center"><tag:torrent.mplayer /></td>
        </tr>
        </if:media_enabled>

        <if:torlang>
        <tr>
          <td align="right" class="header"><tag:language.LANGUAGE /></td>
          <td class="lista" align="center"><tag:language /></td>
        </tr>
        </if:torlang>

        <if:st_comm_enabled>
        <if:LEVEL_SC>
        <tr>
          <td align="right" class="header" ><tag:language.STAFF_COMMENT /></td>
          <td class="lista" align="center"><tag:torrent_staff_comment /></td>
        </tr>
        </if:LEVEL_SC>
        </if:st_comm_enabled>

        <if:imdb_enabled>
        <if:imdb>
        <tr>
          <td align="right" class="header" valign="top">IMDB</td>
          <td class="lista" align="center" style="text-align:left;" valign="top"><tag:frameit /></td>
        </tr>
        <tag:extra1 />
        </if:imdb>
        </if:imdb_enabled>

      <if:imageup_enabled3>
      <tr>
      <td align="right" class="header" valign="top"><tag:language.SCREEN /></td>
      <td class="lista">
      <table class="lista" border="0" cellspacing="0" cellpadding="0">
        <if:SCREENIS1>
          <td class="lista" align="center"><a href="<tag:uploaddir /><tag:torrent.screen1 />" title="view image" class="lightbox"><img src="thumbnail.php?size=150&path=<tag:uploaddir /><tag:torrent.screen1 />"></a></td>
        </if:SCREENIS1>
        <if:SCREENIS2>
          <td class="lista" align="center"><a href="<tag:uploaddir /><tag:torrent.screen2 />" title="view image" class="lightbox"><img src="thumbnail.php?size=150&path=<tag:uploaddir /><tag:torrent.screen2 />"></a></td>
        </if:SCREENIS2>
        <if:SCREENIS3>
          <td class="lista" align="center"><a href="<tag:uploaddir /><tag:torrent.screen3 />" title="view image" class="lightbox"><img src="thumbnail.php?size=150&path=<tag:uploaddir /><tag:torrent.screen3 />"></a></td>
        </if:SCREENIS3>
      </table>
      </td>
      </tr>
      </if:imageup_enabled3>

<tr>
          <td align="right" class="header"><tag:language.CATEGORY_FULL /></td>
          <td class="lista" align="center" style="text-align:left;" valign="top"><tag:torrent.cat_name /></td>
        </tr>
        <tr>
          <td align="right" class="header"><tag:language.RATING /></td>
          <td class="lista" align="center" style="text-align:left;" valign="top"><tag:torrent.rating /></td>
        </tr>
        <tr>
          <td align="right" class="header"><tag:language.SIZE /></td>
          <td class="lista" align="center" style="text-align:left;" valign="top"><tag:torrent.size /></td>
        </tr>

        <if:sub_enabled>
        <if:HAVE_SUBTITLE>
        <tr>
          <td align="right" class="header"><tag:language.SUB_T_H /></td>
          <td class="lista" align="center">
              <table>
                <loop:subs>
                <tr>
                  <td align="center"><tag:subs[].flag /></td>
                  <td align="center"><tag:subs[].name /></td>
                </tr>
                </loop:subs>
              </table>
          </td>
        </tr>
        </if:HAVE_SUBTITLE>
        </if:sub_enabled>

        <if:DISPLAY_FILES>
        <tr>
        <td align="right" class="header" valign="top"><a name="expand" href="#expand" onclick="javascript:ShowHide('files','msgfile');"><tag:language.SHOW_HIDE /></a></td>
        <td align="left" class="lista">
        <div style="display:none" id="files">
          <table class="lista">
            <tr>
              <td align="center" class="header"><tag:language.FILE /></td>
              <td align="center" class="header" style="text-align:left;" valign="top"><tag:language.SIZE /></td>
            </tr>
            <loop:files>
            <tr>
              <td align="center" class="lista" style="text-align:left;" valign="top"><tag:files[].filename /></td>
              <td align="center" class="lista" style="text-align:left;" valign="top"><tag:files[].size /></td>
            </tr>
            </loop:files>
          </table>
        </div>
        <div style="display:block" id="msgfile" align="left"><tag:torrent.numfiles /></div>
        </td>
        </tr>
        </if:DISPLAY_FILES>
        <tr>
          <td align="right" class="header"><tag:language.ADDED /></td>
          <td class="lista" style="text-align:left;" valign="top"><tag:torrent.date /></td>
        </tr>
        <if:SHOW_UPLOADER>
        <tr>
          <td align="right" class="header"><tag:language.UPLOADER /></td>
          <td class="lista" align="center" style="text-align:left;" valign="top"><tag:torrent.uploader /></td>
        </tr>
        </if:SHOW_UPLOADER>
        <if:NOT_XBTT>
        <tr>
          <td align="right" class="header"><tag:language.SPEED /></td>
          <td class="lista" align="center" style="text-align:left;" valign="top"><tag:torrent.speed /></td>
        </tr>
        </if:NOT_XBTT>
        <if:viewcount_enabled>
        <tr>
          <td align="right" class="header"><tag:language.TORRENT_VIEWS /></td>
          <td class="lista" align="center" style="text-align:left;" valign="top"><tag:torrent.viewcount /></td>
        </tr>
        </if:viewcount_enabled>
        <tr>
          <td align="right" class="header"><tag:language.DOWNLOADED /></td>
          <td class="lista" align="center" style="text-align:left;" valign="top"><tag:torrent.downloaded /></td>
        </tr>
        <tr>
          <td align="right" class="header"><tag:language.PEERS /></td>
          <td class="lista" align="center" style="text-align:left;" valign="top"><div id="peer_counts"><tag:torrent.seeds />, <tag:torrent.leechers /> = <tag:torrent.peers /><if:refresh_peers_enabled>&nbsp;&nbsp;&nbsp;<img src="<tag:BASEURL />/images/refresh.gif" border="0" onclick="refresh_peers('<tag:torrent.info_hash />')" title="<tag:language.REFRESH_PEERS />" /></if:refresh_peers_enabled></div></td>
        </tr>

        <if:bookmark_enabled>
        <tr>
          <td align="right" class="header"><tag:language.ADDB /></td>
          <td class="lista" align="center"><a href="index.php?page=bookmark&do=add&torrent_id=<tag:id />"><span style="color:green;"><tag:language.TB_BOOKMARK /></span></a></td>
        </tr>
        </if:bookmark_enabled>

      <if:AFR>
        <if:reseed_possible>
          <tr>
            <td align="right" class="header"><tag:language.AFR_RESEED /></td>
            <td class="lista" align="center" style="text-align:left;" valign="top"><tag:reseed /></td>
          </tr>
        </if:reseed_possible>
      </if:AFR>

             <!-- Report users & Torrents by DiemThuy - Start -->
             <if:ruat>
             <tr>
              <td align="right" class="header"><tag:language.REP_TORR /></td>
              <td align="center" class="lista" style="text-align:left;" valign="top"><tag:rep /></td>
            </tr>
            </if:ruat>
            <!-- Report users & Torrents by DiemThuy - End -->


        <if:similar_enabled>
        <tr>
          <td align="right" class="header"><tag:language.details_similar_torrents /></td>
          <td class="lista" style="text-align:center;">
            <table width="100%" class="main" border="1" cellspacing="0" cellpadding="1">
              <tr>
                <td class="header" style="text-align:center;"><tag:language.details_name /></td>
                <td class="header" style="text-align:center;"><tag:language.details_date /></td>
                <td class="header" style="text-align:center;"><tag:language.details_size /></td>
                <td class="header" style="text-align:center;"><tag:language.details_seeders /></td>
                <td class="header" style="text-align:center;"><tag:language.details_leechers /></td>
              </tr>
              <loop:similar_torrents>
              <tr>
                <td class="lista" style="text-align:center;"><a href="index.php?page=torrent-details&id=<tag:similar_torrents[].info_hash />&hit=1"><b><tag:similar_torrents[].name /></b></a></td>
                <td class="lista" style="text-align:center;"><tag:similar_torrents[].date /></td>
                <td class="lista" style="text-align:center;"><tag:similar_torrents[].size /></td>
                <td class="lista" style="text-align:center;"><span style="color:<tag:similar_torrents[].sc />"><tag:similar_torrents[].seeds /></span></td>
                <td class="lista" style="text-align:center;"><span style="color:<tag:similar_torrents[].lc />"><tag:similar_torrents[].leechers /></span></td>
              </tr>
              </loop:similar_torrents>
            </table>
          </td>
        </tr>
        </if:similar_enabled>

<if:EXTERNAL>
        <tr>
          <td valign="middle" align="right" class="header"><tag:torrent.update_url /></td>
          <td class="lista" align="center" style="text-align:left;" valign="top"><tag:torrent.announce_url /></td>
        </tr>
        <tr>
          <td valign="middle" align="right" class="header"><tag:language.LAST_UPDATE /></td>
          <td class="lista" align="center" style="text-align:left;" valign="top"><tag:torrent.lastupdate /> (<tag:torrent.lastsuccess />)</td>
        </tr>
        </if:EXTERNAL>
      </table>
<if:show_all_uploads_per_user_enabled>
<table width="100%" align="center">
<tr>
<td class="header"><tag:language.ALL_USER_UPLOADS /></td>
</tr><td class="lista">
<marquee onmouseover=this.stop() onmouseout=this.start()  scrollAmount=6 direction=left >
<loop:upl>
<font size = 2><b><tag:upl[].filename /></b>
</loop:upl>
</marquee>
</td></tr>
 </table>
</if:show_all_uploads_per_user_enabled>

      <if:vedsc_enabled_1>
      <!-- #######################################################
      # view/edit/delete shout, comments -->

       <if:VIEW_COMMENTS>

            <script type="text/javascript">
                <!--
                function SetAllCheckBoxes(FormName, FieldName, CheckValue) {
                  if(!document.forms[FormName])
                  return;
                  var objCheckBoxes = document.forms[FormName].elements[FieldName];
                  if(!objCheckBoxes)
                  return;
                  var countCheckBoxes = objCheckBoxes.length;
                  if(!countCheckBoxes)
                  objCheckBoxes.checked = CheckValue;
                  else
                  // set the check value for all check boxes
                  for(var i = 0; i < countCheckBoxes; i++)
                  objCheckBoxes[i].checked = CheckValue;
                  document.forms[FormName].elements['all_down'].checked = CheckValue;
                }
                -->
            </script>

      <form name="deleteallcomments" method="post" action="index.php?page=torrent-details&id=<tag:torrent.info_hash />">

      <!-- # End
      ####################################################### -->
      <br/>
      </if:vedsc_enabled_1>
      <if:comments_above_en>
 <tag:comments_above />
</if:comments_above_en>
      <a name="comments" /></a> <!---otherwise leaks-->
      <br />
      <br />
      <table width="100%" class="lista">


        <if:pager_1>
        <tr><td class='blocklist' colspan='3' align='center'><tag:p_top /></td></tr>
        </if:pager1>

        <if:lock_comments_enabled>
        <tr>
        <td align="center" colspan="3"><tag:lock /></td>
        </tr>
        </if:lock_comments_enabled>

        <if:NO_COMMENTS>
        <tr>
          <td colspan="3" class="lista" align="center"><tag:language.NO_COMMENTS /></td>
        </tr>
        <else:NO_COMMENTS>

        <if:com_lay_1>
       <loop:comments>
        <tr>
        <td align="left" class="header" colspan="2">
        <table width="100%"><tr>
         <td align="right"><tag:comments[].edit.delete />
        </tr></table>
        </td>
        </tr>
        <tr>
        <td class="header" align="left" valign="top">
        <table width="140">
        <tr>
          <td>
          <tag:comments[].user />
          <br />
          <if:comments_reputation>
          <tag:language.REP />: <tag:comments[].reputation />
          <br />
          <else:comments_reputation>
          </if:comments_reputation>
          <tag:comments[].date />
          <br />
          <tag:comments[].elapsed />
          <br />
          <tag:comments[].avatar />
          <br />
          <tag:comments[].ratio />
          <br />
          <tag:comments[].uploaded />
          <br />
          <tag:comments[].downloaded />
          </td>
        </tr>
        </table>
        </td>
        <td class="lista" width="100%" valign="top" style="padding:10px">
        <tag:comments[].comment /><if:avatar_signature_sync_enabled_1><br><br><br><br><center><tag:comments[].comm_sig /></center></if:avatar_signature_sync_enabled_1></td>
        </tr>
        </loop:comments>
        <else:com_lay_1>
        <loop:comments>
        <tr>
          <td class="header"><tag:comments[].user /></td>
          <td class="header"><tag:comments[].date /></td>
          <td class="header" align="right"><if:vedsc_enabled_2><tag:comments[].edit.delete /><else:vedsc_enabled_2><tag:comments[].delete /></if:vedsc_enabled_2></td>
        </tr>
        <tr>
          <td colspan="3" class="lista" align="center" style="text-align:left;" valign="top"><tag:comments[].comment /><if:avatar_signature_sync_enabled><br><center><tag:comments[].comm_sig /></center></if:avatar_signature_sync_enabled></td>
        </tr>
        </loop:comments>
        </if:com_lay_1>
        </if:NO_COMMENTS>

        <if:vedsc_enabled_3>
        <!-- #######################################################
        # view/edit/delete shout, comments -->
        <if:MASSDEL_COMMENTS>
                            <br /><div align="right" style="margin-right:8px;">
                            <input type="submit" class="btn" value="<tag:language.FRM_DELETE />" onclick="return confirm('If you are really sure you want to delete selected comments click OK, othervise Cancel!')" />
                            <input type="checkbox" class="btn" name="all_down" onclick="SetAllCheckBoxes('deleteallcomments','delcomment[]',this.checked)" />
                            </div>
        </if:MASSDEL_COMMENTS>

        </form>
        </if:VIEW_COMMENTS>


        <!-- # End
        ####################################################### -->
        </if:vedsc_enabled_3>

        <if:pager2>
        <tr><td class='blocklist' colspan='3' align='center'><tag:p_bottom /></td></tr>
        </if:pager2>

      <if:VIEW_COMMENTS_2>
      </table>
      </if:VIEW_COMMENTS_2>
    </div>
    <br />

<hr>


<div align="center">
  <form enctype="multipart/form-data" name="comment" method="post" action="index.php?page=comment&id=<tag:comment_id /><if:vedsc_enabled><tag:cid /><tag:edit /></if:vedsc_enabled>">
  <input type="hidden" name="info_hash" value="<tag:comment_id />" />
    <table class="lista" border="0" cellpadding="10">
      <tr>
        <td align="left" class="header"><tag:language.USER_NAME /></td>
        <td class="lista" align="left" ><input name="user" TYPE="text" size="20" value="<tag:comment_username />" maxlength="100" disabled; readonly /></td>
      </tr>
      <tr>
        <td align="left" class="header"><tag:language.COMMENT_1 />:</td>
        <td class="lista" align="left"><tag:comment_comment /></td>
      </tr>
      <if:capcha_enabled>
     <tr>
        <td class="lista" colspan="2" align="center" style="text-align:center;">
        <div align="center"><tag:captcha /></div>
        </td>
      </tr>
     </if:capcha_enabled>
      <tr>
        <td class="header" colspan="2" align="center">
        <input type="submit" class="btn" name="confirm" value="<tag:language.FRM_CONFIRM />" />
        &nbsp;&nbsp;&nbsp;
        <input type="submit" class="btn" name="confirm" value="<tag:language.FRM_PREVIEW />" />
        </td>
      </tr>
    </table>
  </form>      
    </div>
    <br />
    <div align="center">
      <tag:torrent_footer /> | <tag:to_top />
    </div>
    <br />