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

global $TABLE_PREFIX, $btit_settings, $res_seo, $CURUSER, $THIS_BASEPATH;
if ($btit_settings["fmhack_last_download_block"] == "enabled" && $btit_settings["fmhack_IP_to_country"] ==
    "enabled")
{
    $query = "SELECT `u`.`id`, `u`.`username`, `u`.`country_name`, `u`.`country_flag`, `u`.`lip`, `ul`.`prefixcolor`, `ul`.`suffixcolor`, `f`.`id` `fileid`, `f`.`info_hash`, `f`.`filename`, `f`.`imdb`, `f`.`image`, `f`.`external`, UNIX_TIMESTAMP(`d`.`date`) `date` FROM `{$TABLE_PREFIX}downloads` `d` LEFT JOIN `{$TABLE_PREFIX}users` `u` ON `d`.`uid`=`u`.`id` LEFT JOIN `{$TABLE_PREFIX}users_level` `ul` ON `u`.`id_level`=`ul`.`id` LEFT JOIN `{$TABLE_PREFIX}files` `f` ON `d`.`info_hash`=`f`.`info_hash` " . (($btit_settings["fmhack_show_or_hide_porn"] ==
        "enabled" && $CURUSER["showporn"] == "no") ? "WHERE `f`.`category` NOT IN(" . $btit_settings["porncat"] .
        ") " : "") . " ORDER BY `d`.`id` DESC LIMIT 10";
    $result = get_result($query, true, $btit_settings["cache_duration"]);
    echo "<center>";
    echo "<table border=\"1\" cellspacing=\"1\" cellpadding=\"1\"><center><b>";
    echo "<tr><td><b>" . ucfirst($language["TRAV_AGO"]) . "</td><td><b>" . $language["COUNTRY"] .
        "</td><td><b>" . $language["USER"] . "</td><td><center><b>" . $language["TORRENT_FILE"] .
        "</center></td></tr>";
    if (count($result) > 0)
    {
        foreach ($result as $row)
        {
            if (strpos($row["country_flag"], ".") > 0)
            {
                $flag_exp = explode(".", $row["country_flag"]);
                $country_code = strtoupper($flag_exp[0]);
            }
            else
                $country_code = "AA";
            if ($btit_settings["fmhack_balloons_on_mouseover"] == "enabled")
            {
                if ($btit_settings["fmhack_getIMDB_in_torrent_details"] == "enabled" && $btit_settings["balloontype"] ==
                    "imdb")
                {
                    if (@file_exists($THIS_BASEPATH . "/imdb/images/" . $row["imdb"] . ".jpg"))
                        $balon = "imdb/images/" . $row["imdb"] . ".jpg";
                    else
                    {
                        if (!isset($row["image"]) || empty($row["image"]))
                            $balon = $btit_settings["uploaddir"] . "nocover.jpg";
                        else
                            $balon = $btit_settings["uploaddir"] . $row["image"];
                    }
                }
                else
                {
                    if (!isset($row["image"]) || empty($row["image"]))
                        $balon = $btit_settings["uploaddir"] . "nocover.jpg";
                    else
                        $balon = $btit_settings["uploaddir"] . $row["image"];
                }
            }
            echo "<tr><td>" . NewDateFormat(time() - $row["date"]) . "</td><td>" . $country_code .
                " <img src=\"images/flag/" . (($row["country_flag"] == "unknown") ?
                "unknown.gif" : $row["country_flag"]) . "\" alt=\"" . $row["country_name"] . "\" title=\"" .
                $row["country_name"] . "\" /> " . $row["country_name"] . "</td>";
            echo "<td><b><font face=\"Verdana\" color=\"#254117\"><a href=\"" . (($btit_settings["fmhack_SEO_panel"] ==
                "enabled" && $res_seo["activated_user"] == "true") ? $row["id"] . "_" . strtr($row["username"],
                $res_seo["str"], $res_seo["strto"]) . ".html" : "index.php?page=userdetails&id=" .
                $row["id"]) . "\">" . stripslashes($row["prefixcolor"] . $row["username"] . $row["suffixcolor"]) .
                "</font></td>";
            echo "<td align=left><b><font face=\"Verdana\" color=\"#254117\"><a href=\"" . (($btit_settings["fmhack_SEO_panel"] ==
                "enabled" && $res_seo["activated"] == "true") ? strtr($row["filename"], $res_seo["str"],
                $res_seo["strto"]) . "-" . $row["fileid"] . ".html" :
                "index.php?page=torrent-details&id=" . $row["info_hash"]) . "\" " . (($btit_settings["fmhack_balloons_on_mouseover"] ==
                "enabled") ? " onmouseover=\" return overlib('<img src=" . $balon .
                " width=200 border=0>', CENTER);\" onmouseout=\"return nd();\"" : "title=\"" . $language["VIEW_DETAILS"] .
                ": " . $row["filename"] . "\"") . ">" . $row["filename"] . "</a>" . (($row["external"] ==
                "yes") ? " (<span style=\"color:red\">" . $language["SHORT_EXTERNAL"] .
                "</span>)" : "") . "</font></td></tr>";
        }
    }
    else
    {
        echo "<div align=\"center\">" . $language["LDB_DB_EMPTY"] . "</div>";
    }
    echo "</b></center></td></tr></table>";
    echo "<b>" . $language["LDB_AGO_LEG"] . "</b>";
    echo "<center><table border=\"0\" cellspacing=\"0\" cellpadding=\"1\">";
    echo "</table>";
}
else
{
    echo "<div align=\"center\">" . $language["LDB_AGO_NTSH"] . "</div>";
}

?>