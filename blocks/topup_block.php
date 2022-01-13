<?php
/////////////////////////////////////////////////////////////////////////////////////
// xbtit - Bittorrent tracker/frontend
//
// Copyright (C) 2004 - 2020  xbtitFM Team
//
//    This file is part of xbtitFM.
//
// Top Uploader / Medals Block by DiemThuy Feb 2010
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

global $TABLE_PREFIX,$btit_settings, $CURUSER, $language, $res_seo;

if (!$CURUSER || $CURUSER["view_torrents"]=="no")
{
    // do nothing
}
else
{
    $time_B=(86400 * $btit_settings["UPD"]);
    $time_E = strtotime('now');
    $time_D =  ($time_E - $time_B);

    $res=get_result("SELECT `u`.`id`, `u`.`id_level`, `ul`.`prefixcolor`, `u`.`username`, `ul`.`suffixcolor`, `u`.`up_med` FROM `{$TABLE_PREFIX}users` `u` LEFT JOIN `{$TABLE_PREFIX}users_level` `ul` ON `u`.`id_level`=`ul`.`id` WHERE `u`.`up_med`>0 ORDER by `u`.`up_med` DESC LIMIT ".$btit_settings["UPBL"],true,$btit_settings["cache_duration"]);
    $num = count($res);

    if($num>0)
    {
        ?>
        <table width=100% border=0 cellspacing=1 cellpadding=1>
        <tr>
        <td class='header'><?php echo $language["UM_MED"]; ?></td>
        <td class='header'><?php echo $language["UM_NICK"]; ?></td>
        <td class='header'><?php echo $language["UM_TOR"]; ?></td>
        </tr>
        <?php

        foreach ($res as $fetch_U)
        {
            if ($btit_settings["UPC"]==false)
            {
                $T= $fetch_U["id_level"]!="4";
            }
            else
            {
                $T ="";
            }
            if  ($fetch_U["up_med"] < $btit_settings["UPB"] OR $T)
            {
                // Do nothing
            }
            else
            {
                if  ($fetch_U["up_med"] >= $btit_settings["UPB"] AND $fetch_U["up_med"] < $btit_settings["UPS"])
                {
                    $upr= "<img src='images/goblet/medaille_bronze.gif' alt='".$language["UM_BRONZE"]."' title='".$language["UM_BRONZE"]."' />";
                }
                if ($fetch_U["up_med"] >= $btit_settings["UPS"] AND $fetch_U["up_med"] < $btit_settings["UPG"])
                {
                    $upr= "<img src='images/goblet/medaille_argent.gif' alt='".$language["UM_SILVER"]."' title='".$language["UM_SILVER"]."' />";
                }
                elseif ($fetch_U["up_med"] >= $btit_settings["UPG"])
                {
                    $upr= "<img src='images/goblet/medaille_or.gif' alt='".$language["UM_GOLD"]."' title='".$language["UM_GOLD"]."' />";
                }
                else
                {
                    // Do nothing
                }

                $namee=unesc($fetch_U["prefixcolor"] . $fetch_U["username"] . $fetch_U["suffixcolor"]);

                echo"<tr align=\"left\"><td class=\"lista\" style=\"text-align:center;\">$upr</td><td class=\"lista\" style=\"text-align:center;\"><a href='".(($btit_settings["fmhack_SEO_panel"]=="enabled" && $res_seo["activated_user"]=="true")?$fetch_U["id"]."_".strtr($fetch_U["username"], $res_seo["str"], $res_seo["strto"]).".html":"index.php?page=userdetails&id=".$fetch_U["id"])."'>".$namee."</a></td><td class=\"lista\" style=\"text-align:center;\">".$fetch_U["up_med"]."</td></tr>";
            }
        }
        print ("<tr><td class=\"blocklist\" colspan=\"3\" style=\"text-align:center;\">".$language["UM_UP_COUNT_1"]." ".$btit_settings["UPD"]." ".$language["UM_UP_COUNT_2"]."</td></tr>");
        print("</table>");
    }
    else
    {
        print("<table width=100%><tr><td class='blocklist' align='center'>".$language["UM_NOTHING_TO_SEE"]."</td></tr></table>");
    }
}

?>