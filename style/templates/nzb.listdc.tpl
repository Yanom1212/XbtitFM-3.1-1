<script>
		var load = false;
		window.onload = function(){
			if(!load) {
				wmark.init({
					/* config goes here */
					"position": "top-right", // default "bottom-right"
					"opacity": 50, // default 50
					"className": "watermark", // default "watermark"
					"path": "images/wms.png"
				});
			
				load = true;
			}
		}
</script>

<if:DCCAT>

<div align="center">
<form action="<tag:torrent_script />" method="get" name="torrent_search">
  <input type="hidden" name="page" value="nzb" />
  <table border="0" class="lista" align="center">
    <tr>
<if:swit>   
      <td class="block"><tag:language.PAGELAYOUT /></td>
</if:swit>  
      <td class="block"><tag:language.TORRENT_SEARCH /></td>
      <td class="block"><tag:language.CATEGORY_FULL /></td>

      <td class="block">&nbsp;</td>
    </tr>
    <tr>
    <tag:switch />
      <td><input type="text" name="search" size="25" maxlength="50" value="<tag:torrent_search />" /></td>
      <td>
        <tag:torrent_categories_combo />
      </td>

      <td><input type="submit" class="btn" value="<tag:language.SEARCH />" /></td>
     </tr>
  </table>
</form>
</div>
</if:DCCAT>

<if:DTCAP>
<!-- begin category checks -->
<script type="text/javascript">
<!--
function AddCategories()
      {
      var catadd="";
      for (i=0;i<document.tcategories.elements.length;i++)
        {
          if (document.tcategories.elements[i].checked)
             catadd+=";"+document.tcategories.elements[i].value;
      }
      // create hidden field
      if (catadd.length>0)
        {
        var field = document.createElement("input");
        field.setAttribute("type","hidden");
        field.setAttribute("value",catadd.substr(1));
        field.setAttribute("name","category");
        document.torrent_search.appendChild(field);
      }
}
-->
</script>
<div align="center">
<table border="0" class="lista" align="center">
<tr>
  <td class="block" colspan="2" style="text-align: center"><tag:language.TORRENT_SEARCH /></td>
       <if:swit>  
   <td class="block" colspan="1" style="text-align: left"><tag:language.PAGELAYOUT /></td>
    </if:swit>  
</tr>
<tr>
<td>
<form name="tcategories" action="index.php" method="post">
<div style="width: 600px; height:60px; overflow-y: scroll;">
<table >
  <tr>
    <td><tag:category_checks /></td>
  </tr>
</table>
</form>
</td>
<td>
<form action="<tag:torrent_script />" method="get" name="torrent_search" onsubmit="AddCategories()">
  <input type="hidden" name="page" value="nzb" />
  <table border="0" align="center">
    <tr>
      <td colspan="2"><input type="text" name="search" size="25" maxlength="50" value="<tag:torrent_search />" /></td>
    </tr>
    <tr>

      <td><input type="submit" class="btn" value="<tag:language.SEARCH />" /></td>
     </tr>
  </table> </div>
</form>
<tag:switch />
</td>
</tr>
</table>
</div>
</if:DTCAP>

<table width="100%">
  <tr>
    <td colspan="2" align="center"> <tag:torrent_pagertop /></td>
  </tr>
  <tr>
    <td>
      <table width="100%" class="lista">      
    
        <loop:torrents>
        <tr><TABLE width="100%" style="border: solid 1px #ffffff " class="header" border="0">
        <td height="10" width="350" colspan="3" align=left  class="lista" style="<tag:torrents[].color /> border: solid 1px #ffffff"><div align="left">
        <font size=2 color=steelblue >&nbsp;<font size="2" color="#4E4E9C"><tag:torrents[].filename /><tag:torrents[].quality /></font>
     	</div></td>
	    <td width="17" style="<tag:torrents[].color /> border: solid 1px #ffffff " class="lista" ><div align="center"> 
		<font size="2" ></font><tag:torrents[].category />
		</div></td>
		<td width="175" style="<tag:torrents[].color /> border: solid 1px #ffffff" class="lista"><div align="center">
		<font size=2 color=steelblue>&nbsp;Uploader : <tag:torrents[].uploader />
		</div></td>
        <td  width="130" style="<tag:torrents[].color /> border: solid 1px #ffffff" class="lista"><div align="center">
	    <font size=2 color=steelblue>&nbsp;Size : </font><tag:torrents[].size />
	    </div></td>
	    <td width="130" height="22" style="<tag:torrents[].color /> border: solid 1px #ffffff" class="lista"><div align="center">
	    <font size=2 color=steelblue>&nbsp;Price : </font><tag:torrents[].dc /> DC
	    </td></tr>  
        <tr>
        <td height="150"  width="140"  rowspan="1" valign="center" class="lista" style="border: solid 1px #ffffff"><div align="center">
		<tag:torrents[].image />
		</div></td>
		<td  height="156" colspan="<tag:col />" style="border: solid 1px #ffffff"><div align="center">
		<table width="99%" border="0" align="center">
		<tr><td>
        <tag:torrents[].comment />
        </td></tr></table>
        </div></td>
        <if:topb>
        <td height="150"  width="10"  rowspan="1" valign="center" class="lista" style="border: solid 1px #ffffff"><div align="center">
		<tag:torrents[].top />
		</div></td>
        </if:topb>
        </tr>
        <tr>
     	</div></td>
        <td height="22" colspan="3" style="border: solid 1px #ffffff" class="lista"><div align="center">
        <tag:torrents[].rating />
    	</div></td>
        <td colspan="3"  style="border: solid 1px #ffffff" class="lista"><div align="center">
        <font size=2 color=steelblue>Added: </font><tag:torrents[].added />
        </div></td>

        <td style="border: solid 1px #ffffff" class="lista"><div align="center">
        <tag:torrents[].download />
		</div></td><br>      
        </tr>
        </loop:torrents>
      </table>
    </td>
  </tr>
  <tr>
    <td colspan="2" align="center"> <tag:torrent_pagerbottom /></td>
  </tr>
</table>