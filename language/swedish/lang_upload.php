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

$language['NOT_SHA']='SHA1-funktionen är inte tillgänglig. Du behöver PHP 4.3.0 eller högre.';
$language['NOT_AUTHORIZED_UPLOAD']='Du har inte tillstånd att ladda upp!';
$language['FILE_UPLOAD_ERROR_1']='Går ej att läsa in den uppladdade filen';
$language['FILE_UPLOAD_ERROR_3']='Filen saknar storlek';
$language['FACOLTATIVE']='valfritt';
$language['FILE_UPLOAD_ERROR_2']='Uppladdningsfel';
$language['ERR_PARSER']='Det verkar vara ett fel i din torrent.Det gick inte att läsa in datafil/er.';
$language['WRITE_CATEGORY']='Specificera torrentkategori...';
$language['DOWNLOAD']='Ladda ner';
$language['MSG_UP_SUCCESS']='Uppladdning lyckades! Torrenten har lagts till.';
$language['MSG_DOWNLOAD_PID']='PID-systemet är aktiverat, hämta dina torrenter med din PID';
$language['MSG_AUTO_ANNOUNCE']='På grund av ett system i användning på denna tracker, måste du ladda ner din torrentfil på nytt här:<br /><br />';
$language['EMPTY_DESCRIPTION']='lägg till en beskrivning!';
$language['EMPTY_ANNOUNCE']='Meddelanderutan är tom';
$language['FILE_UPLOAD_ERROR_1']='Det går inte att läsa in den uppladdade filen.';
$language['FILE_UPLOAD_ERROR_2']='Uppladdningsfel';
$language['FILE_UPLOAD_ERROR_3']='Filen har inget innehåll';
$language['NO_SHA_NO_UP']='Tjänsten filuppladdning är inte tillgänglig - ingen SHA1-funktion.';
$language['NOT_SHA']='SHA1-funktionen är inte tillgänglig. PHP 4.3.0 eller högre krävs.';
$language['ERR_PARSER']='Det verkar vara ett fel i din torrent.Det gick inte att läsa in datafil/er.';
$language['WRITE_CATEGORY']='Du måste specificera en torrentkategori...';
$language['ERR_HASH']='Info hash MÅSTE vara exakt 40 hex bytes.';
$language['ERR_EXTERNAL_NOT_ALLOWED']='Externa torrenter är inte tillåtna';
$language['ERR_MOVING_TORR']='Det går inte att flytta torrenten...';
$language['ERR_ALREADY_EXIST']='Denna torrent kanske redan finns i vår databas.';
$language['MSG_DOWNLOAD_PID']='PID-systemet är aktiverat, hämta dina torrenter med din PID';
$language['MSG_UP_SUCCESS']='Uppladdningen lyckades. Torrenten har lagts till.';


$language["FILE_UPLOAD_TO_BIG"]="Filen är för stor för att kunna laddas upp!! Gräns";
$language["IMAGE_WAS"]="Bildstorlek";
$language["MOVE_IMAGE_TO"]="Det gick inte att flytta bilden till";
$language["CHECK_FOLDERS_PERM"]="Kontrollera mappbehörighet och försök igen.";
$language["ILEGAL_UPLOAD"]="Otillåten uppladdning!! Detta är inte en bild<br>Klicka bakåt och försök igen";
$language["IMAGE"]="Bild";
$language["SCREEN"]="Skärmdump";

// Twitter Update
$language["TWIT_UNABLE"] = "Det gick inte att uppdatera Twitter, cURL-extension kunde inte hittas!";
$language["TWIT_NT"] = "Ny torrent";

// Preview
$language["UP_PREV"] = "Förhandsgranska";

// Auto announce - Start -->

// I'm not entirely sure exactly what this is meant to say as the original hack was in Hungarian

// Google Translation of original Hungarian text:
// In the case of any other torrent site if you want to upload a torrent to download, you need not announce to the URL rewrite, in any event, it will be overwritten by the correct URL!
$language["AUTO_ANNOUNCE"]="Alla uppladdade torrentfiler kommer automatiskt få meddelar-URL överskriven till vår primära meddelar-URL";

// Google Translation of original Hungarian text:
// Thus, any downloaded file tracker. torrent file upload!
$language["AUTO_ANNOUNCE2"]="<b>Därför går det bra att ladda upp torrenter från andra trackrar här.</b>";

// <-- End - Auto announce

?>