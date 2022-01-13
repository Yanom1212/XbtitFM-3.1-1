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
global $users, $torrents, $seeds, $leechers, $percent, $FORUMLINK, $BASEURL, $SITENAME;
// $language['rtl']='rtl'; // if your language is  right to left then uncomment this line
// $language['charset']='ISO-8859-1'; // uncomment this line with specific language charset if different than tracker's one
$language['ACCOUNT_CONFIRM']='Kontobekräftelse för '.$SITENAME.' sida.';
$language['ACCOUNT_CONGRATULATIONS']='Grattis ditt konto är nu aktiverat!<br />Du kan nu <a href="index.php?page=login">logga in</a> på sidan och använda ditt konto.';
$language['ACCOUNT_CREATE']='Skapa Konto';
$language['ACCOUNT_DELETE']='Ta bort Konto';
$language['ACCOUNT_DETAILS']='Konto detaljer';
$language['ACCOUNT_EDIT']='Ändra konto';
$language['ACCOUNT_MGMT']='Konto Hantering';
$language['ACCOUNT_MSG']='Hej,'."\n\n".'Detta mail är skickat för att någon har begärt ett konto på våran sida med denna adress.'."\n".'Om du inte gjort det vänligen ignorera detta mail..Annars vänligen bekräfta ditt Konto.'."\n\n".'Med vänliga hälsningar Staff.';
$language['ACTION']='Action';
$language['ACTIVATED']='Aktiv';
$language['ACTIVE']='Status';
$language['ACTIVE_ONLY']='Aktiv endast';
$language['ADD']='Lägg till';
$language['ADDED']='Tillagd';
$language['ADMIN_CPANEL']='Admin Kontroll Panel';
$language['ADMINCP_NOTES']='Här kan du ändra alla inställningar på trackern...';
$language['ALL']='Torrents';
$language['ALL_SHOUT']='Alla Shouts';
$language['ANNOUNCE_URL']='Tracker announce url:';
$language['ANONYMOUS']='Anonym';
$language['ANSWER']='Svar';
$language['AUTHOR']='Ägare';
$language['AVATAR_URL']='Avatar (url): ';
$language['AVERAGE']='Medelvärde';
$language['BACK']='Bakåt';
$language['BAD_ID']='Fel ID!';
$language['BCK_USERCP']='Tillbaka till användar panel';
$language['BLOCK']='Block';
$language['BODY']='Body';
$language['BOTTOM']='botten';
$language['BY']='Av';
$language['CANT_DELETE_ADMIN']='Det går inte ta bort en annan Admin!';
$language['CANT_DELETE_NEWS']='Du har inte behörighet att ta bort nyheter!';
$language['CANT_DELETE_TORRENT']='Du har inte behörighet att ta bort torrenter!...';
$language['CANT_DELETE_USER']='Du har inte behörighet att ta bort användare!';
$language['CANT_DO_QUERY']='Kan inte köra SQL fråga - ';
$language['CANT_EDIT_TORR']='Du kan inte ändra torrenter!';
$language['CANT_FIND_TORRENT']='Kan inte hitta torrentfilen!';
$language['CANT_READ_LANGUAGE']='Kan inte läsa språkfilen!';
$language['CANT_SAVE_CONFIG']='Kan inte spara inställningar i config.php';
$language['CANT_SAVE_LANGUAGE']='Kan inte spara språkfilen';
$language['CANT_WRITE_CONFIG']='Varning!!! kan inte spara config.php!';
$language['CATCHUP']='Markera alla som lästa';
$language['CATEGORY']='Kat.';
$language['CATEGORY_FULL']='Kategori';
$language['CENTER']='center';
$language['CHANGE_PID']='Ändra PID';
$language['CHARACTERS']='tecken';
$language['CHOOSE']='Välj';
$language['CHOOSE_ONE']='Välj en';
$language['CLICK_HERE']='Klicka här';
$language['CLOSE']='Stäng';
$language['COMMENT']='Kom.';
$language['COMMENT_1']='Kommentar';
$language['COMMENT_PREVIEW']='Förhandsvisning Kommentar';
$language['COMMENTS']='Komentarer';
$language['CONFIG_SAVED']='Grattis!! Nya inställningar sparade';
$language['COUNTRY']='Land';
$language['CURRENT_DETAILS']='Nuvarande uppgifter';
$language['DATABASE_ERROR']='Databas fel.';
$language['DATE']='Datum';
$language['DB_ERROR_REQUEST']='Databas fel. Kan inte fullfölja.';
$language['DB_SETTINGS']='Databas inställningar';
$language['DEAD_ONLY']='Endast döda';
$language['DELETE']='Ta bort';
$language['DELETE_ALL_READED']='Ta bort alla lästa';
$language['DELETE_CONFIRM']='Är du säker på att du vill ta bort?';
$language['DELETE_TORRENT']='Ta bort Torrent';
$language['DELFAILED']='Ta bort Misslyckades';
$language['DESCRIPTION']='Beskrivning';
$language['DONT_NEED_CHANGE']='Du behöver inte ändra dom här inställningarna!';
$language['DOWN']='Dl';
$language['DOWNLOAD']='Ladda ner';
$language['DOWNLOAD_TORRENT']='Ladda ner Torrent';
$language['DOWNLOADED']='Nerladdat';
$language['EDIT']='Ändra';
$language['EDIT_LANGUAGE']='Ändra Språk';
$language['EDIT_POST']='Ändra Post';
$language['EDIT_TORRENT']='Ändra torrent';
$language['EMAIL']='E-post';
$language['EMAIL_SENT']='Ett meddelande har skickat till anvgien adress<br />Klicka på länken för att bekräfta kontot.';
$language['EMAIL_VERIFY']='e-post adress ändrad på '.$SITENAME;
$language['EMAIL_VERIFY_BLOCK']='Bekräftelse meddelandet har skickats';
$language['EMAIL_VERIFY_MSG']='Hej,'."\n\n".'Detta mail har skickat för att du vill ändra din adress som finns registrerad på ditt konto, vänligen klicka på länken för att bekräfta ändringen.'."\n\n".'Med vänliga hälsningar staff.';
$language['EMAIL_VERIFY_SENT1']='<br /><center>Ett bekräftelse meddelande har skickats till:<br /><br /><strong><font color="red">';
$language['EMAIL_VERIFY_SENT2']='</font></strong><br /><br />Du måste klicka på länken i meddelandet för att<br />Updatera din e-post adress. Det borde komma inom 10 minuter<br />(oftast direkt) Vissa e-post klienter kan markera det som spam SPAM<br />Så vänligen kontrollera din skräppost mapp om du inte ser det.<br /><br />';
$language['ERR_500']='HTTP/1.0 500 Unauthorized access!';
$language['ERR_AVATAR_EXT']='Tyvärr antingen finns inte bilden eller så är den i fel format (endast gif, jpg, bmp och png bilder är tillåtet).';
$language['ERR_BAD_LAST_POST']='';
$language['ERR_BAD_NEWS_ID']='Fel nyhets ID!';
$language['ERR_BODY_EMPTY']='Body Kan inte va tomt!';
$language['ERR_CANT_CONNECT']='Kan inte ansluta till lokal MySQL server';
$language['ERR_CANT_OPEN_DB']='Kan inte öppna databasen';
$language['ERR_COMMENT_EMPTY']='Kommentar kan inte va tomt!';
$language['ERR_DB_ERR']='Databas Fel. Vänligen kontakta en administratör angående felet.';
$language['ERR_DELETE_POST']='Ta bort post. Kontroll: Du håller på att ta bort en post. Klicka';
$language['ERR_DELETE_TOPIC']='Ta bort ämne. Kontroll: Du håller på ta bort ett ämne. Klicka';
$language['ERR_EMAIL_ALREADY_EXISTS']='Denna e-post finns redan ivårat system!';
$language['ERR_EMAIL_NOT_FOUND_1']='E-post adressen';
$language['ERR_EMAIL_NOT_FOUND_2']='Hittades inte i databasen.';
$language['ERR_ENTER_NEW_TITLE']='Du måste skriva en titel!';
$language['ERR_FORUM_NOT_FOUND']='Forum hittades inte';
$language['ERR_FORUM_UNKW_ACT']='Forum Fel: Okänd händelse';
$language['ERR_GUEST_EXISTS']='"Guest" är ett skyddat namn. Du kan inte registrera dig som "Guest"';
$language['ERR_IMAGE_CODE']='Säkerhets koden stämmer inte';
$language['ERR_INS_TITLE_NEWS']='Du måste skriva både titel OCH nyhet';
$language['ERR_INV_NUM_FIELD']='Invalid numerical field(s) from client';
$language['ERR_INVALID_CLIENT_EVENT']='Ogiltig händelse= från klient.';
$language['ERR_INVALID_INFO_BT_CLIENT']='Ogilltig information mottagen av bittorent klient';
$language['ERR_INVALID_IP_NUMB'] = 'Ogiltig IP adress. Enbart standard ip nummer i punktform tillåts (värd namn inte tillåten)';
$language['ERR_LEVEL']='Tyvärr, Din rank ';
$language['ERR_LEVEL_CANT_POST']='Du har inte tillåtelse att skriva här.';
$language['ERR_LEVEL_CANT_VIEW']='Du har inte tillåtelse att se denna tråd.';
$language['ERR_MISSING_DATA']='Data saknas!';
$language['ERR_MUST_BE_LOGGED_SHOUT']='Du måste logga in för att skriva...';
$language['ERR_NO_BODY']='Ingen bröd text';
$language['ERR_NO_NEWS_ID']='Nyhets ID fanns inte!';
$language['ERR_NO_POST_WITH_ID']='Ingen tråd med detta ID ';
$language['ERR_NO_SPACE']='Användarnamn kan inte ha mellanslag, använd understreck typ:<br /><br />';
$language['ERR_NO_TOPIC_ID']='Ingen Tråd ID visades';
$language['ERR_NO_TOPIC_POST_ID']='Ingen titel associerad med tråd ID';
$language['ERR_NOT_AUTH']='Du har inte behörighet!';
$language['ERR_NOT_FOUND']='Hitades ej...';
$language['ERR_NOT_PERMITED']='Ingen tillåtelse';
$language['ERR_PASS_LENGTH_1']='Lösenordet måste var minst';
$language['ERR_PASS_LENGTH_2']='tecken långt.';
$language['ERR_PASSWORD_INCORRECT']='Fel lösenord';
$language['ERR_PERM_DENIED']='Tillträde nekat';
$language['ERR_PID_NOT_FOUND']='Ladda ner torrenten igen. PID system är aktiv  och ingen PID hittades i torrenten';
$language['ERR_RETR_DATA']='Kan inte ta emot data!';
$language['ERR_SEND_EMAIL']='Kunde inte skicka mail.Vänligen kontakta admin för felet';
$language['ERR_SERVER_LOAD']='Server belastning är hög för tillfället. Provar igen, vänligen vänta...';
$language['ERR_SPECIAL_CHAR']='<font color="black">Användar namnet kan inte innehålla speialtecken som:<br /><br /><font color="red"><strong>* &#63; &#60; &#62; &#64; &#36; &#38; &#37; etc.</strong></font></font><br />';
$language['ERR_SQL_ERR']='SQL Fel';
$language['ERR_SUBJECT']='Du måste ange ett ämne.';
$language['ERR_TOPIC_ID_NA']='Ämnes ID är inte tillgängligt';
$language['ERR_TOPIC_LOCKED']='Ämnet Låst';
$language['ERR_TORRENT_IN_BROWSER']='Denna fil är för bittorrent klienter.';
$language['ERR_UPDATE_USER']='Kunde inte uppdatera användar data. Vänligen kontakta en administratör angående felet.';
$language['ERR_USER_ALREADY_EXISTS']='Detta användarnamn finns redan!';
$language['ERR_USER_NOT_FOUND']='Tyvärr, användaren hittades inte';
$language['ERR_USER_NOT_USER']='Du har inte tillgång till andra användares inställningar !';
$language['ERR_USERNAME_INCORRECT']='Felaktigt användarnamn';
$language['ERROR']='Fel';
$language['ERROR_ID']='Fel ID';
$language['FACOLTATIVE']='Valfritt';
$language['FILE']='Fil';
$language['FILE_CONTENTS']='Fil Innehåll';
$language['FILE_NAME']='Fil Namn';
$language['FIND_USER']='Sök Användare';
$language['FINISHED']='Klar';
$language['FORUM']='Forum';
$language['FORUM_ERROR']='Forum Fel';
$language['FORUM_INFO']='Forum Info';
$language['FORUM_MIN_CREATE']='Min.. Klass skapa';
$language['FORUM_MIN_READ']='Min.. Klass Läsa';
$language['FORUM_SEARCH']='Forum Sök';
$language['FORUM_N_TOPICS']='N. Ämnen';
$language['FORUM_N_POSTS']='N. Inlägg';
$language['FRM_DELETE']='Ta bort';
$language['FRM_LOGIN']='Logga in';
$language['FRM_PREVIEW']='Förhandsvisning';
$language['FRM_REFRESH']='Ladda Om';
$language['FRM_RESET']='Återställ';
$language['FRM_SEND']='Skicka';
$language['FRM_CONFIRM']='Bekräfta';
$language['FRM_CANCEL']='Avbryt';
$language['FRM_CLEAN']='Rensa';
$language['GLOBAL_SERVER_LOAD']='Global Server Belastning (Alla sidor på servern)';
$language['GO']='Kör';
$language['GROUP']='Grupp';
$language['GUEST']='Gäst';
$language['GUESTS']='Gäster';
$language['HERE']='Här';
$language['HISTORY']='Historik';
$language['HOME']='Hem';
$language['IF_YOU_ARE_SURE']='om du är säker.';
$language['IM_SURE']='Jag är säker';
$language['IN']='in';
$language['INF_CHANGED']='Information ändrad!';
$language['INFINITE']='Inf.';
$language['INFO_HASH']='Info Hash';
$language['INS_NEW_PWD']='Skriv NYTT lösenord!';
$language['INS_OLD_PWD']='Skriv GAMMALT lösenord!';
$language['INSERT_DATA']='Ange data för uppladning.';
$language['INSERT_NEW_FORUM']='Lägg till Forum';
$language['INVALID_ID']='Är inte ett riktigt ID. Tyvärr!';
$language['INVALID_INFO_HASH']='Felaktig info hash värde.';
$language['INVALID_PID']='Felaktig PID';
$language['INVALID_TORRENT']='Tracker fel: ogiltig torrent';
$language['KEYWORDS']='Huvudord';
$language['LAST_EXTERNAL']='Senaste External Torrents Uppdatering gjordes ';
$language['LAST_NEWS']='Senaste Nyhter ';
$language['LAST_POST_BY']='Senaste inlägg av';
$language['LAST_SANITY']='Senaste Sanity Check gjordes ';
$language['LAST_TORRENTS']='Senaste Torrents';
$language['LAST_UPDATE']='Senaste Uppdatering';
$language['LASTPOST']='Senaste inlägg';
$language['LEECHERS']='Tankare';
$language['LEFT']='Vänster';
$language['LOGIN']='Logga in';
$language['LOGOUT']='Logga ut';
$language['MAILBOX']='Brevlåda';
$language['MANAGE_NEWS']='Hantera Nyheter';
$language['MEMBER']='Användare';
$language['MEMBERS']='Användare';
$language['MEMBERS_LIST']='Användar Lista';
$language['MINIMUM_100_DOWN']='(med minst 100 MB nerladdat)';
$language['MINIMUM_5_LEECH']='med minst 5 leechers, inte med döda torrents';
$language['MINIMUM_5_SEED']='med minst 5 seeders';
$language['MKTOR_INVALID_HASH']='skapa torrent: Tog emot felaktig hash';
$language['MNU_ADMINCP']='Admin Panel';
$language['MNU_FORUM']='Forum';
$language['MNU_INDEX']='Index';
$language['MNU_MEMBERS']='Medlemmar';
$language['MNU_NEWS']='Nyheter';
$language['MNU_STATS']='Fler Stats';
$language['MNU_TORRENT']='Torrents';
$language['MNU_UCP_CHANGEPWD']='Byt Lösenord';
$language['MNU_UCP_HOME']='Profil Panel';
$language['MNU_UCP_IN']='Din PM inkorg';
$language['MNU_UCP_INFO']='Ändra Profil';
$language['MNU_UCP_NEWPM']='Nytt PM';
$language['MNU_UCP_OUT']='Din PM utkorg';
$language['MNU_UCP_PM']='Din PM låda';
$language['MNU_UPLOAD']='Ladda upp';
$language['MORE_SMILES']='Fler Smileys';
$language['MORE_THAN']='Mer än ';
$language['MORE_THAN_2']='saker hittade, visar dom första';
$language['NA']='N/A';
$language['NAME']='Namn';
$language['NEED_COOKIES']='Notera: kakor måste tillåtas för att logga in.';
$language['NEW_COMMENT']='Skriv din kommenter...';
$language['NEW_COMMENT_T']='Ny Kommentar';
$language['NEWS']='Nyheterna';
$language['NEWS_DESCRIPTION']='Nyheter:';
$language['NEWS_INSERT']='Skriv Nyheterna';
$language['NEWS_PANEL']='Nyhets Panel';
$language['NEWS_TITLE']='Titel:';
$language['NEXT']='Nästa';
$language['NO']='Nej';
$language['NO_BANNED_IPS']='Finns inga bannade IP';
$language['NO_COMMENTS']='Inga kommentarer...';
$language['NO_FORUMS']='Inga Forums hittades!';
$language['NO_MAIL']='Du har inga nya meddelanden.';
$language['NO_MESSAGES']='Inget PM hittades...';
$language['NO_NEWS']='Inga Nyheter';
$language['NO_PEERS']='Inga peers';
$language['NO_RECORDS']='Tyvärr, listan är tom...';
$language['NO_TOPIC']='Inga ämnen hittades';
$language['NO_TORR_UP_USER']='Inga torrents uppladdade av användaren';
$language['NO_TORRENTS']='Inga torrents här...';
$language['NO_USERS_FOUND']='Ingen användare hittades!';
$language['NOBODY_ONLINE']='Ingen Ansluten';
$language['NONE']='Ingen';
$language['NOT_ADMIN_CP_ACCESS']='Du har inte behörighet till admin panelen!';
$language['NOT_ALLOW_DOWN'] = 'det är inte tillåtet att ladda ner ifrån';
$language['NOT_AUTH_DOWNLOAD'] = 'Du har inte behörighet att ladda hem. ledsen...';
$language['NOT_AUTH_VIEW_NEWS'] = 'Du har inte behörighet att visa nyheterna!';
$language['NOT_AUTHORIZED'] = 'Du har inte behörighet att visa';
$language['NOT_AUTHORIZED_UPLOAD'] = 'Du har inte behörighet att ladda upp saker!';
$language['NOT_AVAILABLE'] = 'Inte tillgänglig';
$language['NOT_MAIL_IN_URL'] = 'Detta är inte e-mail adressen som är i url:n';
$language['NOT_POSS_RESET_PID'] = 'Det är inte möjligt att ändra din PID! <br />Kontakta Staff...';
$language['NOW_LOGIN'] = 'Nu kommer du uppmanas logga in';
$language['NUMBER_SHORT'] = '#';
$language['OLD_PWD']='Gammalt Lösenord';
$language['ONLY_REG_COMMENT']='Endast registrerade användare kan skriva Kommentarer!';
$language['OPT_DB_RES']='Optimering av db resultat';
$language['OPTION']='Inställningar';
$language['PASS_RESET_CONF']='Bekräftelse för återställning av lösenord';
$language['PEER_CLIENT']='Klient';
$language['PEER_COUNTRY']='Land';
$language['PEER_ID']='Peer ID';
$language['PEER_LIST']='Peer Lista';
$language['PEER_PORT']='Port';
$language['PEER_PROGRESS']='Framsteg';
$language['PEER_STATUS']='Status';
$language['PEERS']='peers';
$language['PEERS_DETAILS']='Klicka för att se peer detaljer';
$language['PICTURE']='Bild';
$language['PID']='PID';
$language['PLEASE_WAIT']='Vänta...';
$language['PM']='PM';
$language['POSITION']='Position';
$language['POST_REPLY']='Skriv svar';
$language['POSTED_BY']='Skrivet av';
$language['POSTED_DATE']='Skrivet den';
$language['POSTS']='Inlägg';
$language['POSTS_PER_DAY']='%s inlägg per dag';
$language['POSTS_PER_PAGE']='Inlägg per sida';
$language['PREVIOUS']='Föreg.';
$language['PRIVATE_MSG']='Privat Meddelande';
$language['PWD_CHANGED']='Lösenord ändrat!';
$language['QUESTION']='Fråga';
$language['QUICK_JUMP']='Snabb Navigering';
$language['QUOTE']='Citera';
$language['RANK']='Klass';
$language['RATIO']='Ratio';
$language['REACHED_MAX_USERS']='Användar gräns uppfylld';
$language['READED']='Läs';
$language['RECEIVER']='Mottagare';
$language['RECOVER_DESC'] = 'Använd formuläret nedanför för att återställa ditt lösenord. Uppgifter för kontot och detaljer kommer att skickas till dig.(Du kommer få svara på brevet med en länk som finns i e-posten)';
$language['RECOVER_PWD'] = 'Återställ lösenord';
$language['RECOVER_TITLE'] = 'Återställ Förlorat Användarnamn eller Lösenord';
$language['REDIRECT']='Om din webbläsare inte har javascript aktivterat, Klicka';
$language['REDIRECT2']='Om din webbläsare inte har javascipt aktiverad Klicka,<a href="%s">HÄR</a>.';
$language['REDOWNLOAD_TORR_FROM']='Ladda ner torrent igen från';
$language['REGISTERED']='Registrerad';
$language['REGISTERED_EMAIL']='Registrerad e-post';
$language['REMOVE']='Ta bort';
$language['REPLIES']='Svar';
$language['REPLY']='Svara';
$language['RESULT']='Resultat';
$language['RETRY']='Försök igen';
$language['RETURN_TORRENTS']='Tillbaka till torrent listan';
$language['REVERIFY_CONGRATS1'] = '<center><br />Grattis, Ditt email har blivit verifierat och lyckades byta<br/><br/><strong>Från: <font color=\'red\'>';
$language['REVERIFY_CONGRATS2'] = '</strong></font><br /><strong>Till: <font color=\'red\'>';
$language['REVERIFY_CONGRATS3'] = '</strong></font><br /><br />';
$language['REVERIFY_FAILURE'] = '<center><br /><strong><font color=\'red\'><u>Ledsen men url finns inte</u></strong></font><br /><br />Varje gång du försöker ändra din email adress så görs en ny url och den gammla raderas<br />Ser du detta meddelande är det störst chans att du har fösökt ändra din email adress<br />mer än 1 gång och du använder en gammal url.<br /><br /><strong>Snälla vänta på att begära ny och va säker på att du inte har fått något<br />före du begär ett nytt bekräftelse mail före  du försöker att byta ditt email igen.</strong><br /><br />';
$language['REVERIFY_MSG'] = 'Ifall du försöker ändra din e-mail adress så kommer en verifikationslänk skickas till den e-post address du önskar att byta till.<br /><br /><font color=\'red\'><strong>E-post adressen för ditt konto kommer inte bli ändrat förän Du Verfierar den nya address genom att klicka på länken.</strong></font>';
$language['RIGHT']='Höger';
$language['SEARCH']='Sök';
$language['SEEDERS']='seedare';
$language['SEEN']='Sedd';
$language['SELECT']='Välj...';
$language['SENDER']='Avsändare';
$language['SENT_ERROR']='Sent Error';
$language['SHORT_C']='F'; //Shortname for Completed-Färdig
$language['SHORT_L']='L'; //Shortname for Leechers
$language['SHORT_S']='S'; //Shortname for Seeders
$language['SHOUTBOX']='Skrik låda';
$language['SIZE']='Storlek';
$language['SORRY']='Tyvärr';
$language['SORTID']='Sorterings id';
$language['SPEED']='Hastighet';
$language['STICKY']='Klistrad';
$language['SUB_CATEGORY']='Under-Kategori';
$language['SUBJECT']='Ämne';
$language['SUBJECT_MAX_CHAR']='Ämne är begränsat till ';
$language['SUC_POST_SUC_EDIT']='Ändring av inlägg lyckades.';
$language['SUC_SEND_EMAIL'] = 'ett bekräftelsebrev har skickats till';
$language['SUC_SEND_EMAIL_2'] = 'Vänligen låt det ta ett par minuter för mailet att komma fram';
$language['SUCCESS']='Success';
$language['SUMADD_BUG']='Tracker bug calling summaryAdd';
$language['TABLE_NAME']='Tabell namn';
$language['TIMEZONE']='Tidszon';
$language['TITLE']='Titel';
$language['TOP']='Bäst';
$language['TOP_10_ACTIVE']='10 Mest aktiva torrents';
$language['TOP_10_BEST_SEED']='10 Bäst Seedade torrents';
$language['TOP_10_BSPEED']='10 Snabbaste torrents';
$language['TOP_10_DOWNLOAD']='Topp 10 Nerladdare';
$language['TOP_10_SHARE']='Topp 10 Bästa delare';
$language['TOP_10_UPLOAD']='Topp 10 Uppladdare';
$language['TOP_10_WORST']='Topp 10 Sämsta Delare';
$language['TOP_10_WORST_SEED']='10 Torrents sämsta Seeders';
$language['TOP_10_WSPEED']='10 Långsamaste Torrents';
$language['TOP_TORRENTS']='Mest Populära Torrents';
$language['TOPIC']='Ämne';
$language['TOPICS']='Ämnen';
$language['TOPICS_PER_PAGE']='Ämnen per sida';
$language['TORR_PEER_DETAILS']='Torrent peers detaljer';
$language['TORRENT']='Torrent';
$language['TORRENT_ANONYMOUS'] = 'Skicka som anonym';
$language['TORRENT_CHECK'] = 'Tillåt trackern att ta emot och använda information från torrentfil.';
$language['TORRENT_DETAIL'] = 'Torrent Information';
$language['TORRENT_FILE'] = 'Torrent Fil';
$language['TORRENT_SEARCH'] = 'Sök Torrents';
$language['TORRENT_STATUS'] = 'Status';
$language['TORRENT_UPDATE'] = 'Uppdaterar, vänligen vänta...';
$language['TORRENTS'] = 'Torrents';
$language['TORRENTS_PER_PAGE'] = 'Torrents per sida';
$language['TRACK_DB_ERR'] = 'Tracker/databas fel. Detaljerad information finns i loggfilerna.';
$language['TRACKER_INFO'] = '$users users, tracking $torrents torrents ($seeds seeds e $leechers leechers, $percent%)';
$language['TRACKER_LOAD'] = 'Tracker belastning';
$language['TRACKER_SETTINGS'] = 'Tracker Inställningar';
$language['TRACKER_STATS'] = 'Tracker status';
$language['TRACKING'] = 'Spårar';
$language['TRAFFIC'] = 'Trafik';
$language['UCP_NOTE_1'] = 'Här kontrollerar du din Postlåda, skriv PM till andra användare,';
$language['UCP_NOTE_2'] = 'inställningar för dig etc...';
$language['UNAUTH_IP'] = 'Otillåten IP address.';
$language['UNKNOWN']='okänd';
$language['UPDATE']='Uppdatera';
$language['UPFAILED']='Uppladdningen misslyckades';
$language['UPLOAD_IMAGE']='Ladda upp Bild';
$language['UPLOAD_LANGUAGE_FILE']='Ladda upp språkfil';
$language['UPLOADED']='Uppladdad';
$language['UPLOADER']='Uppladdare';
$language['UPLOADS']='Uppladdat';
$language['URL']='URL';
$language['USER']='Användare';
$language['USER_CP'] = 'Kontrollpanel';
$language['USER_CP_1'] = 'Kontrollpanelen';
$language['USER_DETAILS'] = 'Användar Profil';
$language['USER_EMAIL'] = 'E-post';
$language['USER_ID'] = 'Användar ID';
$language['USER_JOINED'] = 'Blev medlem';
$language['USER_LASTACCESS'] = 'Senast inloggad';
$language['USER_LEVEL'] = 'Klass';
$language['USER_LOCAL_TIME'] = 'Användarens Tidszon';
$language['USER_NAME'] = 'Användare';
$language['USER_PASS_RECOVER'] = 'Glömt Lösenord/Användare';
$language['USER_PWD'] = 'Lösenord';
$language['USERS_SEARCH'] = 'Användare Sök';
$language['VIEW_DETAILS']='Se detaljer';
$language['VIEW_TOPIC']='Se ämne';
$language['VIEW_UNREAD']='Se olästa';
$language['VIEWS']='Visningar';
$language['VISITOR']='Besökare';
$language['VISITORS']='Besökare';
$language['WAIT_ADMIN_VALID']='Du får vänta till en Administratör bekräftat ditt konto...';
$language['WARNING']='Varning!';
$language['WELCOME']='Välkommen';
$language['WELCOME_ADMINCP']='Välkommen till Admin Kontroll Panel';
$language['WELCOME_BACK']='Välkommen tillbaka';
$language['WELCOME_UCP']='Välkommen till din Kontrollpanel';
$language['WORD_AND']='och';
$language['WORD_NEW']='Ny';
$language['WROTE']='Skrev';
$language['WT']='WT';
$language['X_TIMES']='gånger';
$language['YES']='Ja';
$language['LAST_IP']='Senaste IP';
$language['FIRST_UNREAD']='Gå till första olästa inlägg';
$language['MODULE_UNACTIVE']='Modulen som krävs är inte aktiverad!';
$language['MODULE_NOT_PRESENT']='Modulen som krävs finns inte!';
$language['MODULE_LOAD_ERROR']='Modulen som krävs verkar ha ett fel!';

// Custom title -->
$language["CUSTOM_TITLE"]="Anpassad titel";
// <-- Custom title

// Seed Bonus -->    
$language["BONUS_INFO1"]="Här kan du byta bort Bonus Poäng (Nuvarande) ";
$language["BONUS_INFO2"]="(Om knapparna inte fungerar har du inte nog med poäng !)";
$language["BONUS_INFO3"]="Vad får jag poäng för?";
$language["BONUS_INFO3a"]="För varje timme systemet ser dig som seeder";
$language["BONUS_INFO3b"]="<b>(Laddar upp i";
$language["BONUS_INFO3c"]="KB/s elr snabbare)</b>";
$language["BONUS_INFO3d"]="får du";
$language["BONUS_INFO3e"]="<b>(Upp till maximalt";
$language["BONUS_INFO3f"]="poäng per timme)</b>";
$language["BONUS_INFO4"]="poäng";
$language["BONUS_INFO4a"]="poäng";
$language["BONUS_INFO5"]="per torrent";
$language["BONUS_INFO6"]="Får du";
$language["BONUS_INFO7"]="För varje ny torrent du lägger upp. <b>(Med en";
$language["BONUS_INFO8"]="timmars fördröjning för att ge oss möjlighet att kontrollera.)</b>";
$language["BONUS_INFO9"]="för varje kommentar du gör på torrent.";
$language["BONUS_INFO10"]="för varje inlägg du gör i forumet.";
$language["BONUS_INFO11"]="för varje inlägg i shoutbox.";
$language["BONUS_INFO12"]="för varje timme du lyssnar på radion.";
$language["WHAT_ABOUT"]="Vad är det här om?";
$language["POINTS"]="Poäng";
$language["EXCHANGE"]="Byt in";
$language["GB_UPLOAD"]=" GB Uppladdat";
$language["CHANGE_CUSTOM_TITLE"]="Byt Custom title (pris - ";
$language["NO_CUSTOM_TITLE"]="ingen";
$language["UP_TO_VIP"]="Uppgradera till VIP";
$language["FOR"]="för";
$language["NEED_MORE_POINTS"]="[måste ha mer poäng]";
$language["CHANGE_USERNAME"]="Byt användar namn (pris - ";
$language["NEVER_EXPIRE"]="Går aldrig ut";
$language["SB_MAKE_A_GIFT"]="Ge bort poäng till annan medlemm";
$language["BAD_DATA"]="Felaktiga data!";
$language["GIFT_TOO_BIG"]="Din gåva är för stor, Du kan som mest Ge bort";
$language["GIFT_USER_NOT_FOUND"]="Användaren du vill ge poäng finns inte i databasen!";
$language["GIFT_NOT_ENOUGH"]="Du har inte så många poäng!";
$language["GIFT_PM_SUBJ_1"]="Du har fått en gåva!";
$language["GIFT_PM_SUBJ_2"]="Du har skickat en gåva!";
$language["GIFT_PM_REC_1"]="har gett dig en gåva värd";
$language["GIFT_PM_REC_2"]="bonus poäng. Glöm inte säga tack."."\n\n".((substr($FORUMLINK,0,3)=="smf" || $FORUMLINK=="ipb")?"[img]".$BASEURL."/images/smilies/thumbsup.gif[/img]":":thumbsup:");
$language["GIFT_PM_SEND_1"]="Detta PM bekräftar att du skickat ";
$language["GIFT_PM_SEND_2"]="en gåva värd";
$language["GIFT_PM_SEND_3"]="bonus poäng. Dom har nu dragits från din totala summa å skickats till";
$language["GIFT_PM_SEND_4"]="\n\n".((substr($FORUMLINK,0,3)=="smf" || $FORUMLINK=="ipb")?"[img]".$BASEURL."/images/smilies/thumbsup.gif[/img]":":thumbsup:");
$language["GIFT_PM_SYS"]="\n\n"."[b][color=red]Detta är ett system PM Vänligen svara inte på detta![/color][/b]";
$language["BONUS_VIP_CONFIRM"]="Är du säker du vill spendera för";
// <-- Seed Bonus

// Donation History by DiemThuy -->
$language['DON_HISTORIE']='Dessa medlemmar har donerat till oss..Tack Ska ni ha';
$language['NO_DON_HIST'] = 'Ingen Donations historia än';
$language['DON_HIST'] = 'Donations Historia';
$language['DON_AMT'] = 'Donations Storlek';
$language['DONATIONS'] = 'Donationer';
$language['DON_CONFIRM'] = 'Vi har fått din Donation, Tack Så Mycket!!';
$language['DONATION'] = 'Donation';
$language['USERNAME'] = 'Användarnamn';
$language['AMOUNT'] = 'Storlek';
// <-- Donation History by DiemThuy


$language['TR_TIMED_RANK_SET'] = 'Inställningar tidsbaserad Klass';
$language['TR_NEW_RANK'] = 'Ny Klass';
$language['TR_OLD_RANK'] = 'Gammal Klass';
$language['TR_TIME_TO_EXP'] = 'Utgår den';
$language['TR_WEEK'] = 'Vecka';
$language['TR_WEEKS'] = 'Veckor';
$language['TR_ONE_MONTH'] = 'En Månad';
$language['TR_HALF_YEAR'] = 'Halv år';
$language['TR_ONE_YEAR'] = 'Ett år';
$language['TR_TWO_YEARS'] = 'Två År';
$language['TR_SUBJECT'] = 'Din klass har ändrats!';
$language['TR_MSG_PART_1'] = 'Din klass har ändrats till';
$language['TR_MSG_PART_2'] = 'detta är en tidsbaserad Klass tiden för den går ut den';
$language['TR_MSG_PART_3'] = 'efter det får du tillbaka din gammla klass';
$language['TR_MSG_PART_4'] = 'Tillbaka';
$language['TR_MSG_PART_5'] = 'Detta är ett automatiskt system meddelande, Vänligen svara inte på det!';
$language['TR_UNAUTH'] = 'obehörig axess!';
$language['TR_ID_OR_LEV_INV'] = 'id eller klass felaktig!';
$language['TR_NOT_OWN_RANK'] = "Du kan inte ändra din egen klass";
$language['TR_NOT_HIGHER'] = "Du kan inte ändra någon till en högre klass än din egen.";
$language['TR_NOT_HIGHER_2'] = "Du kan inte ändra någon med samma klass eller högre än din egen.";
$language['TR_BOTH_THE_SAME'] = "Kan inte ändra till samma klass som användaren redan är.";
$language["TR_EXP_SUBJ"] = "Din tidsbaserad Klass har gått ut!";
$language["TR_EXP_MSG_1"] = "Din klass har ändrats tillbaka till";
$language["TR_EXP_MSG_2"] = "[color=red][b]Automatiskt meddelande, Vänligen svara inte på detta![/b][/color]";
$language['TR_MONTH'] = 'Månad';
$language['TR_MONTHS'] = 'Månader';
$language['TR_YEAR'] = 'År';
$language['TR_YEARS'] = 'År';
$language['TR_DAY'] = 'Dag';
$language['TR_DAYS'] = 'Dagar';


// GOLD
$language["GOLD_TYPE"]="Torrent typ";
$language["GOLD_PICTURE"]="Guld bild";
$language["SILVER_PICTURE"]="Silver bild";
$language["BRONZE_PICTURE"]="Brons bild";
$language["GOLD_DESCRIPTION"]="Guld beskrivning";
$language["SILVER_DESCRIPTION"]="Silver beskrivning";
$language["BRONZE_DESCRIPTION"]="Brons beskrivning";
$language["CLASSIC_DESCRIPTION"]="Vanlig beskrivning";
$language["GOLD_LEVEL"]="Vem kan lägga till guld/silver torrents";
$language["IS_GOLD"]="Guld";
$language["IS_SILVER"]="Silver";
$language["IS_BRONZE"]="Brons";
$language["IS_ALL"]="Fri";
$language["GOLD_PERCENT"]="Guld nerladdnings procent";
$language["SILVER_PERCENT"]="Silver nerladdnings procent";
$language["BRONZE_PERCENT"]="Brons nerladdnings procent";
$language["GOLD_FL"]="Fri Nerladdning";

$language['FL_TO'] = 'till';
$language['FL_NOT_TODAY'] = 'Ej Aktiv';
$language['FL_FREE_LEECH'] = 'Fri Nerladdning';
$language['FL_START_TIME'] = 'Nästa Happy Hour Startar';
$language['FL_ITS_HH'] = 'Nu är det Happy Hour';


$language["FILE_UPLOAD_TO_BIG"]="Filen är för stor att ladda upp!! Gör den mindre";
$language["IMAGE_WAS"]="Bild storlek";
$language["MOVE_IMAGE_TO"]="Kunde inte flytta bild till";
$language["CHECK_FOLDERS_PERM"]="Vänligen kontrollera mapp rättigher och prova igen.";
$language["ILEGAL_UPLOAD"]="Förbjuden Uppladning!! Detta är ingen bild<br>Klicka bakåt ock brova igen";
$language["IMAGE"]="Bild";
$language["SCREEN"]="Screenshots";

$language["AFR_PM_1"] = "För en tid sedan laddade du ner";
$language["AFR_PM_2"] = "Den saknar nu seedare och";
$language["AFR_PM_3"] = "Vill gärna ladda ner den har du filerna kvar får du gärna hoppa in som seedare.".'\n\n'."Tack".'\n\n'."[color=red][b]Detta är et automatiskt meddelande vänligen svara inte på det[/b][/color]".'\n';
$language["AFR_PM_SUBJ"] = "Åter seed önskas";
$language["AFR_INFO_1"] = "Åter seed önskad";
$language["AFR_INFO_2"] = "Ett PM har skickats till alla som har laddat ner denna.";
$language["AFR_ERR_1"] = "Åter seed Fel";
$language["AFR_ERR_2"] = "Någon har redan begärt åter seed av denna torrent de senaste 5 dagarna.";
$language["AFR_RESEED"] = "Önska en åter seed";

$language['AUTORANK_STATE']='Auto Klass State';
$language['AUTORANK_POSITION']='Auto Klass Position';
$language['AUTORANK_MIN_UPLOAD']='Auto Klass (Upp/ner)laddat utlösare ';
$language['AUTORANK_IN_BYTES']=' (i bytes)';
$language['AUTORANK_MIN_RATIO']='AutoKlass Ratio Utlösare';
$language['AUTORANK_SMF_MIRROR']='SMF Forums Klass Spegling';
$language['AUTORANK_IPB_MIRROR']='IPB Forums Klass Spegling';
$language['AUTORANK_SMF_LIST']='<b><u>Nuvarande SMF Klass Lista från databasen</u></b><br />';
$language['AUTORANK_IPB_LIST']='<b><u>Nuvarande IPB klass Lista från databasen</u></b><br />';

$language['AUTORANK_PM_DEMOTE_SUBJ']='Du har blivit nergraderad';
$language['AUTORANK_PM_PROMOTE_SUBJ']='Du har blivit uppgraderad';

$language['AUTORANK_PM_GREET']='Hej';

$language['AUTORANK_PM_DEMOTE_1']='Som ett resultat av att dina tracker stats sjunkit har du blivit degraderad från';
$language['AUTORANK_PM_DEMOTE_2']='till klass';
/* If you want to add some kind of "get your act together" type message, you can add it below. */
$language['AUTORANK_PM_DEMOTE_3']='Vänligen försök öka din status igen';

$language['AUTORANK_PM_PROMOTE_1']='Som ett resultat av att dina tracker stats ökat har du blivit uppgraderad ';
$language['AUTORANK_PM_PROMOTE_2']='till klass';
/* If you want to add some kind of "congratulations, keep it up" type message, you can add it below. */
$language['AUTORANK_PM_PROMOTE_3']='Grattis bra jobbat';

// Report users & Torrents by DiemThuy -->
$language["REP_ALLUSERS"] = "Skapa anmälan";
$language["REP_ADMIN"]="Anmälda Användare & Torrent Administration";
$language["REP_SUC_REP"] = "Anmälan Lyckades";
$language["REP_STAFF_WILL_CHECK"] = "Någon ur staff kommer titta på problemet så snart som möjligt";
$language["REP_ALR_REP"] = "Du har redan anmält";
$language["REP_ERR"] = "Anmälnings Fel";
$language["REP_INV_ID"] = "Felaktigt användar ID";
$language["REP_NO_STAFF"] = "Kan inte anmäla Staff";
$language["REP_NOT_SELF"] = "Kan inte anmäla dig själv";
$language["REP_USER"] = "Anmäl Användare";
$language["REP_TORR"] = "Anmäl Torrent";
$language["REP_CONF_1"] = "Vill du verkligen anmäla";
$language["REP_CONF_2"] = "Vänligen notera använd inte <b>detta</b> För att anmäla Hit n Run, Trackern har eget system för det<br /><br /><b>Orsak</b>";
$language["REP_CONF_3"] = "Orsak";
$language["REP_INV_TORR"] = "Ogiltigt Torrent ID";
$language["REP_NEED_REASON"] = "Du måste ange orsak för denna anmälan";
$language['REP_BY'] = 'Anmäld av';
$language['REP_REPORTING'] = 'Anmäler';
$language['REP_TYPE'] = 'Typ';
$language['REP_REASON'] = 'Orsak';
$language['REP_DEALT_WITH'] = 'Avklarad';
$language['REP_MARK'] = 'Markera som avklarad';
$language['REP_REPORTS'] = 'Anmälningar';
// <-- Report users & Torrents by DiemThuy
$language['BOOT_EXP'] = 'Din tids ban är slut!';
$language['BOOT_EXP_MSG'] = 'Du är inte längre bannad, Vänligen gör inte om samma misstag igen!';
$language['BOOT_GIVE'] = 'Du är bannad!';
$language['BOOT_GIVE_REA'] = 'Orsaken till ban är:';
$language['BOOT_GIVE_WHO'] = 'Av:';
$language['BOOT_GIVE_EXP'] = 'Avslutas den';
$language['BOOT_RM_SUB'] = 'Din ban är hävd!';
$language['BOOT_RM_MSG'] = 'Din ban är nu hävd!';
$language['BOOT_DISABLED'] = 'Användare avaktiverad!';
$language['BD'] = 'Ban Data';
$language['RFB'] = 'Orsak till Ban';
$language['ET'] = 'Ban avslutas';
$language['AB'] = 'Tillagd av';
$language["RB"] = "Ta bort Ban";
$language["BS"] = "Ban Inställningar";
$language["AM"] = "Admin Meny";
$language["BT"] = "Ban Tid";
$language["BM"] = "Ban Motivering";

$language["IMDB_UL_FORM"] = "&nbsp;(optional)&nbsp;<b>tt<b><input type='text' name='imdb' size='10' maxlength='200' />&nbsp; siffror efter tt i länken.";
$language["IMDB_EDIT_FORM"] = "Siffrorna efter tt i länken.";
$language["IMDB_NOT_ADDED"] = "Inget IMDB ID tillagt..";
$language["IMDB_RESIZE_ERR"] = "Storleks ändring av fönstret fungerar inte utan Javascript.<br />Vänligen aktivera Javascript eller se informationen i nytt fönster";
$language["IMDB_EXTRA"] = "IMDB Extra";
$language["IMDB_MORE_INFO"] = "Mer Info";
$language["IMDB_COVER"] = "Omslag";
$language["IMDB_NO_PHOTO"] = "Ingen bild finns";
$language["IMDB_LANGUAGES"] = "Språk";
$language["IMDB_GENRE"] = "Genre";
$language["IMDB_ALL_GENRES"] = "Alla Genre";
$language["IMDB_RATING"] = "Rating";
$language["IMDB_VOTES"] = "Röster";
$language["IMDB_TAGLINE"] = "Rubrik";
$language["IMDB_PLOT_OUTLINE"] = "Plot Outline";
$language["IMDB_PLOT"] = "Plot";
$language["IMDB_TAGLINES"] = "Taglines";
$language["IMDB_YEAR"] = "År";
$language["IMDB_RUNTIME"] = "Längd";
$language["IMDB_MINUTES"] = "minuter";
$language["IMDB_CACHE_CON"] = "IMDB Cache Innehåll";
$language["IMDB_MOV_DET"] = "Film Detaljer";
$language["IMDB_PAGE"] = "IMDB page";
$language["IMDB_NO_PHOTO"] = "Ingen bild finns";
$language["IMDB_AKA"] = "Även känd som";
$language["IMDB_SEASONS"] = "Säsonger";
$language["IMDB_AGE_CLASS"] = "Ålders rekomendation";
$language["IMDB_COUNTRY"] = "Land";
$language["IMDB_COLORS"] = "Färger";
$language["IMDB_SOUND"] = "Ljud";
$language["IMDB_DIRECTOR"] = "Director";
$language["IMDB_WRITING_BY"] = "Skriven av";
$language["IMDB_WRITER"] = "Författare";
$language["IMDB_ROLE"] = "Roll";
$language["IMDB_PRODUCED_BY"] = "Producerad av";
$language["IMDB_PRODUCER"] = "Producent";
$language["IMDB_MUSIC"] = "Musik";
$language["IMDB_MUSICIAN"] = "Musiker";
$language["IMDB_ACTOR"] = "Skådespelare";
$language["IMDB_CAST"] = "Rollbesättning";
$language["IMDB_PLOT_OUTLINE"] = "Plot Outline";
$language["IMDB_PLOT"] = "Plot";
$language["IMDB_EPISODE"] = "Avsnitt";
$language["IMDB_EPISODES"] = "Avsnitt";
$language["IMDB_SEASON"] = "Säsong";
$language["IMDB_ORIG_AIR_DATE"] = "Original Sändnings datum";
$language["IMDB_USER_COMMENTS"] = "Användar Kommentarer";
$language["IMDB_MOVIE_QUOTES"] = "Movie Quotes";
$language["IMDB_TRAILERS"] = "Trailers";
$language["IMDB_CR_CRED"] = "Crazy Credits";
$language["IMDB_CR_CRED_1"] = "We know about";
$language["IMDB_CR_CRED_2"] = "One of them reads";
$language["IMDB_GOOFS"] = "Goofs";
$language["IMDB_GOOFS_1"] = "Here comes one of them";
$language["IMDB_TRIVIA"] = "Trivia";
$language["IMDB_TRIVIA_1"] = "There are";
$language["IMDB_TRIVIA_2"] = "entries in the trivia list - like these";
$language["IMDB_TRIVIA_3"] = "trivia records. Some examples";
$language["IMDB_SOUNDTRACKS"] = "Soundtracks";
$language["IMDB_SOUNDTRACK"] = "Soundtrack";
$language["IMDB_SOUNDTRACKS_1"] = "soundtracks listed - like these";
$language["IMDB_CREDIT"] = "Credit";
$language["IMDB_CAUSE"] = "Cause";
$language["IMDB_BIRTH_NAME"] = "Födelse namn";
$language["IMDB_NICKNAMES"] = "Nicknamn";
$language["IMDB_BODY_HEIGHT"] = "Body Height";
$language["IMDB_SPOUSES"] = "Spouse(s)";
$language["IMDB_SPOUSE"] = "Spouse";
$language["IMDB_PERIOD"] = "Period";
$language["IMDB_COMMENT"] = "Comment";
$language["IMDB_KIDS"] = "Kids";
$language["IMDB_MINI_BIO"] = "Mini Bio";
$language["IMDB_TM"] = "Trademarks";
$language["IMDB_SALARY"] = "Salary";
$language["IMDB_MOVIE"] = "Film";
$language["IMDB_CHAR"] = "Karaktär";
$language["IMDB_PUBL"] = "Publikationer";
$language["IMDB_AUTHOR"] = "Author";
$language["IMDB_TITLE"] = "Titel";
$language["IMDB_ISBN"] = "ISBN";
$language["IMDB_BIO_MOVIES"] = "Biograf filmer";
$language["IMDB_INTERVIEW"] = "Intervjuer";
$language["IMDB_INTERVIEWS"] = "Intervjuer";
$language["IMDB_DETAILS"] = "Detaljer";
$language["IMDB_PERF_SEARCH"] = "Genomför IMDB sök för";
$language["IMDB_NAME"] = "Namn";
$language["IMDB_SCAN"] = "Söker av IMDB...";
$language["IMDB_SEARCH"] = "Imdb";
$language["IMDB_VIEW"]="Se på IMDB";
$language["IMDB_GENRE"]="Genre";

//RULES
$language["RULES_SORT"]="Regel num(sort)";
$language["RULES"]="Regler";
$language["RULE"]="Regel";
$language["RULE_ALL"]="Alla regler";
$language["MNU_RULES"]="Regler";
$language["RULES_ADD"]="Ange regel";


// Seedbox
$language["SB_HS_TORRENT"] = "för snabb torrent";
$language["SB_SEEDBOX"] = "Seedbox";
$language["SB_SS_SETTINGS"] = "Visa Seedbox Inställningar";
$language["SB_MITU"] = "Min ID at använda";
// Seedbox

$language["ANN_NEW_USER"] = "[color=red]Välkommen[/color] till senaste medlemmen:";
$language["ANN_NEW_TORR"] = "[color=red]NY UPPLADDNING[/color]:";
$language["ANN_ADDED_BY"] = "[color=red]TILLAGD AV[/color]:";

$language["DOB"]="Födelse datum";
$language["STICKY_TORRENT"]="<b>Klistrad</b>";
$language["STICKY_TORRENT_EXPLAIN"]="(Altid högst upp på torrent lista)";


// Helpdesk
$language["HELPDESK"]="HjälpKonsol";
$language["HD_WEEK"]="vecka";
$language["HD_WEEKS"]="veckor";
$language["HD_DAY"]="dag";
$language["HD_DAYS"]="dagar";
$language["HD_HOUR"]="timme";
$language["HD_HOURS"]="timmar";
$language["HD_MIN"]="minut";
$language["HD_MINS"]="minuter";
$language["HD_SORRY"]="Tyvärr";
$language["HD_NOT_AUTHORIZED"]="Du får inte se detta.";
$language["HD_RTF"]="Läs FAQ";
$language["HD_RTF2"]="Läs [b]FAQ[/b] Innan du börjar fråga!";
$language["HD_STF"]="Sök i forumet";
$language["HD_STF2"]="Vänligen sök i [b]FORUMET[/b].";
$language["HD_DN"]="Är du n00b";
$language["HD_DN2"]="Är du n00b! min farmor kan detta!";
$language["HD_ON"]="på";
$language["HD_PROBLEM"]="Problemet";
$language["HD_SOLVED"]="Löst";
$language["HD_ANSWER"]="Svar";
$language["HD_IGNORED"]="Ignorerat";
$language["HD_BB"]="<b>BB tags</b> är <b>tillåtet</b>";
$language["HD_IGNORE"]="IGNORERA";
$language["HD_ADDED"]="Tillagd";
$language["HD_ADDEDBY"]="Tillagd av";
$language["HD_SOLVEDBY"]="Löst - av";
$language["HD_SOLVEDIN"]="Löst På";
$language["HD_DELPROB"]="Ta bort lösta och ingnorerade problem";
$language["HD_S_FAST"]="Löst snabbt";
$language["HD_S_INTIME"]="Löst i tid";
$language["HD_S_LATE"]="Löst för sent";
$language["HD_S_REPLIES"]="Standard Svar";
$language["HD_USE"]="Använd";
$language["HD_MSG1"]="[color=red][b]Från $SITENAME Hjälp konsol [/b][/color]";
$language["HD_MSG2"]="hälsningar";
$language["HD_MSG3"]="staff medlemm";
$language["HD_HELP_DESK"]="Hjälp Konsol";
$language["HD_MSG_SENT"]="Meddelandet skickat! Vänligen invänta svar.";
$language["HD_WELCOME_1"]="Välkommen staff medelemm";
$language["HD_WELCOME_2"]="det finns";
$language["HD_WELCOME_3"]="Obesvarade frågor som väntar";
$language["HD_WELCOME_MSG"]="Här kan du beskriva dina problem men innan du använder <b>Hjälp Konsolen</b> titta så inte ditt problem redan är löst i <a href=index.php?page=forum><b>Forumet</b></a> först.";
$language["HD_HELPME"]="Hjälp mig!";
// Helpdesk


// Torrent Request
$language['RF']='Fyllda requester';
$language['VR']='Requester';
$language['R']='Lägg till request';
$language['VV']='Se röster';
$language['RD']='Requestdetaljer';
$language['RE']='Ändra request';
$language['TJ']='Ta jobb';
$language['RS']='Återställ';
$language['FTJ']='fyllt jobbet!';
$language['OTJ']='är under arbete!';
$language['RDT']='Datum:';
$language['RTT']='Tack';
$language['RFU']='Fylld URL';
$language['R_EMPTY_HASH']='Info hash inte uppfylld!';
$language['R_EMPTY_URL']='Skriv torrentens hela direktURL dvs. http://www.mysite.com/index.php?page=torrent-details&id=813.. (Det går bara att kopiera och klistra från ett annat fönster) eller ändra befintliga  URL-n till torrentID';
$language['R_HASH_INFO']=''.$BASEURL.'/index.php?page=torrent-details&id=<font color=red>5bdf70f0ec21084be7edc0754157e5058441cebf</font>';
$language["TRAV_AV_REQ"] = "Tillgängliga requester för";
$language["TRAV_POS_REQ"] = "Postade Requester";
$language["TRAV_REM"] = "Återstående";
$language["TRAV_IYFAR"] = "Om du fyller en request, får du";
$language["TRAV_ANR"] = "Lägg till ny request";
$language["TRAV_VMR"] = "Se mina requester";
$language["TRAV_HFR"] = "Dölj fyllda requester";
$language["TRAV_SEEDB_P"] = "seedbonuspoäng";
$language["TRAV_SORTBY"] = "Sortera med";
$language["TRAV_NAME"] = "Namn";
$language["TRAV_VOTES"] = "Röster";
$language["TRAV_TYPE"] = "Skriv";
$language["TRAV_DATE_A"] = "Datum tillagt";
$language["TRAV_ADDEDBY"] = "Tillagd av";
$language["TRAV_FILLED"] = "Fylld";
$language["TRAV_FILLEDBY"] = "Fylld av";
$language["TRAV_DISPLAY"] = "Visa";
$language["TRAV_SEARCH"] = "Sök";
$language["TRAV_GO"] = "Kör";
$language["TRAV_NOBODY"] = "ingen";
$language["TRAV_OFF_MESS"] = "Offlinemeddelande";
$language["TRAV_REQ_OFF"] = "Requestsektionen är offline just nu";
$language["TRAV_ALREADY_VOTED"] = "<p>Du har redan röstat på denna request, Det är bara tillåtet att rösta en gång per </p><p>Tillbaka till <a href=index.php?page=viewrequests><b>se requester</b></a></p>";
$language["TRAV_SUC_VOTED"] = "Röstningen lyckades";
$language["TRAV_SUC_VOTED_1"] = "Röstningen på requesten lyckades";
$language["TRAV_SUC_VOTED_2"] = "Tillbaka till <a href=index.php?page=viewrequests><b>Se requester</b></a>";
$language["TRAV_REQUEST"] = "Request";
$language["TRAV_EDIT"] = "ändra";
$language["TRAV_INFO"] = "Info";
$language["TRAV_ADDED"] = "Tillagd";
$language["TRAV_REQBY"] = "Requestad av";
$language["TRAV_VOTE_FT"] = "Rösta på den här";
$language["TRAV_HTFAR"] = "Hur man fyller en request";
$language["TRAV_HTFAR_1"] = "Skriv <b>full</b> direkt torrentURL, dvs. http://www.mysite.com/index.php?page=torrent-details&id=813.. (Det går bara att kopiera och klistra från ett annat fönster) eller ändra befintliga  URL-n till torrentID...";
$language["TRAV_VOTE"] = "Rösta";
$language["TRAV_TDTUH"] = "SKRIV-DIREKT-TORRENT-URL-HÄR";
$language["TRAV_SEND"] = "Skicka";
$language["TRAV_ED_REQ"] = "Ändra Request";
$language["TRAV_CATEG"] = "Kategori";
$language["TRAV_DESC"] = "Beskrivning";
$language["TRAV_TORR_FILE"] = "Torrentfil";
$language["TRAV_DESC2"] = "description";
$language["TRAV_EDIT"] = "ändra";
$language["TRAV_SUBMIT"] = "Lämna";
$language["TRAV_NOTAUTH"] = "Antingen är du inte auktoriserad, eller också är det en bugg,var snäll och rapportera det till staffen!";
$language["TRAV_WAS_FB"] = "fylldes av";
$language["TRAV_TORR_DL1"] = "Torrenten kan laddas ner från denna länk";
$language["TRAV_TORR_DL2"] = "Glöm inte att tacka uppladdaren."."\n\n"."Om, av någon anledning, det inte är vad du önskade, återställ det genom att klicka";
$language["TRAV_TORR_DL3"] = "Klicka[b]INTE[/b] på länken om du inte är helt säker att du vill återställa requesten.";
$language["TRAV_HERE"] = "HÄR!";
$language["TRAV_REQFILLED"] = "Din torrentrequest har fyllts!";
$language["TRAV_HNBSF_1"] = "har framgångsrikt fyllts här";
$language["TRAV_HNBSF_2"] = "Användare";
$language["TRAV_HNBSF_3"] = "har mottagit ett PM om denna uppladdning.<br /><br /><b>är detta ett olycksfall?</b><br /><br />Inget bekymmer, men snälla";
$language["TRAV_HNBSF_4"] = "<b>KLICKA HÄR</b></a> för att återställa denna request.<br /><b>Varning</b> Klicka inte här om du inte är helt säker att du återställa denna request!";
$language["TRAV_THANKS"] = "<br /><br />Tack för att du lade upp denna request :)<br /><br />Gå tillbaka till<a href=index.php?page=viewrequests><b>Se request</b></a>";
$language["TRAV_SUC_RESET"] = "återställningen lyckades";
$language["TRAV_CANNOT"] = "går inte att återställa en icke-lagd request";
$language["TRAV_TOP5"] = "Topp 5 Requester";
$language["TRAV_CAT"] = "Kat";
$language["TRAV_REQBY2"] = "Request av";
$language["TRAV_REQDET"] = "Requestdetaljer";
$language["TRAV_REQNAME"] = "Requestnamn";
$language["TRAV_NOADD1"] = "Tyvärr är din rang";
$language["TRAV_NOADD2"] = "är inte tillåtet att posta requester";
$language["TRAV_SEARCHFIRST"] = "Innan du lägger en request, gör en sökning om den redan finns";
$language["TRAV_IN"] = "i";
$language["TRAV_ALL"] = "alla";
$language["TRAV_INCDEAD"] = "Inklusive döda torrenter";
$language["TRAV_SEARCH"] = "Sök";
$language["TRAV_ADDNEW"] = "Lägg till en ny request";
$language["TRAV_SELCAT"] = "Välj kategori";
$language["TRAV_MUSTSELECTONE"] = "Du måste välja åtminstone en request att ta bort.";
$language["TRAV_REQDELETED"] = "Requesten borttagen";
$language["TRAV_GOBACK"] = "Gå tillbaka till<a href=index.php?page=viewrequests><b>Requests</b></a>";
$language["TRAV_NOAUTH"] = "Ej auktoriserad";
$language["TRAV_NOTALLOWED"] = "Ej tillåtet";
$language["TRAV_REACHEDMAX"] = "Du har tyvärr redan nått maximalt antal Requester";
$language["TRAV_MUSTADDTITLE"] = "Du måste lägga till en titel!";
$language["TRAV_MUSTCHOOSECAT"] = "Du måste välja en kategori!";
$language["TRAV_MUSTADDDESC"] = "Du måste lägga till en beskrivning!";
$language["TRAV_NEWREQUEST"] = "Ny Request";
$language["TRAV_WATTRS"] = "lades till i Requestsektionen";
$language["TRAV_VOTEFORTHIS"] = "Rösta på denna";
$language["TRAV_NOWTFOUND"] = "Inget hittades";
$language["TRAV_AGO"] = "sedan";
$language["DOH_URL"]="Skriv in hela direktlänken till torrenten, dvs. ".$BASEURL."/index.php?page=torrent-details&id=813.. (Det går bara att kopiera och klistra från ett annat fönster) eller ändra befintliga  URL-n till torrentID!"; 
// Torrent Request



$language["NOT_USER_CLASS"]="<h2>Tyvärr</h2><p>Du måste vara registrerad för att kunna köpa biljetter.</p>";
$language["CANNOT_SELL_CLOSED"]="Tyvärr kan jag inte sälja någon biljett till dig. Lotteriet är stängt!";
$language["LOTTERY"]="Lotteri";
$language["LOTT_LIMIT_PURCHASE"]="Högsta antalet biljetter du kan förvärva är";
$language["LOTT_LIMIT_BUY"]="Högsta antalet biljetter du kan köpa är";
$language["LOTTERY_PM_SUBJECT"]="Du har vunnit ett pris i lotteriet";
$language["LOTTERY_PM_MESSAGE"]="Gratulerar, du har vunnit ett pris i vå lotteri. Priset har lagts till ditt konto.";
$language['RESET_PID'] = 'Återställ PID';

$language["SB_BANNED"] = "<br /><center><img src='images/denied.gif'><br />Du är tyvärr avstängd från att använda ShoutBoxen!<br />Du måste fråga någon i staffen";


$language["LED_WELCOME"] = '** Välkommen **';
$language["LED_TO"] = '++ Till ++';
$language["LED_UPLOADED"] = 'Du har laddat upp';
$language["LED_ERR"] = 'Om du använder en Javastödd webbläsare, borde du se en rörlig text som ser ut så här:';
$language["LED_ACT_TOR"] = 'Activa torrenter';
$language["LED_LAST_VISIT"] = 'Senaste besök';
$language["LED_CURRTIME"] = 'Aktuell tid är';
$language["LED_TODAYIS"] = 'Idag är det';

$language["GRAB_YDT"] = "Dina nerladdade torrenter";
$language["GRAB_AL_DOWN"] = "Redan nerladdad!!";
$language["GRAB_STILL_ACTIVE"] = "fortfarande aktiv";
$language["GRAB_NOT_ACTIVE"] = "ej aktiv";

$language['TORRENT_OPTIONS']='Sök i';
$language['FIL']='Filnamn';
$language['FILDES']='Fil & Beskr';
$language['DES']='Beskrivning';
$language['SUBC']='Sub Cat.';

# Language definitions added by TreetopClimber.
$language['EXTRA']='extra';
$language['DROPDOWN']='rullgardin';
$language['TORRENT_MENU']='Meny';
$language['USER_MENU']='Användarmeny';
$language['ADMIN_ACCESS']='Adminåtkomst';
$language['STAFF_ACCESS']='Staff';
$language['UPLOAD_LINK']='Torrentuppladdning';
$language['ADAREA']='annons';
# End

// Sport Betting - Start
$language["SB_BETTING"] = "Betting";
$language["SB_SITE_BETTING"] = "Site Betting";
$language["SB_NO_BETS_ATM"] = "Inga insatser för närvarande";
$language["SB_CURR_BETS"] = "Nuvarande spel";
$language["SB_BET_ADMIN"] = "Speladmin";
$language["SB_WAGERS"] = "Satsningar";
$language["SB_TL"] = "Topplista";
$language["SB_INFO"] = "Info";
$language["SB_BET"] = "Insats";
$language["SB_CHECK_LATER"] = "<i>Tyvärr finns inga aktiva spel just nu. Återkom senare! :)</i>";
$language["SB_TGCTNO"] = "Detta Spel Stänger För Nya Satsningar:";
$language["SB_TIME_LEFT"] = "Kvarvarande Tid";
$language["SB_MINUTES"] = "Minuter";
$language["SB_ACC_DEN"] = "Tillträde nekat!!";
$language["SB_SILLY_RABBIT"] = "Dumspån";
$language["SB_NO_OPT"] = "Ta åtminstone ett alternativ ditt pucko!";
$language["SB_ADMIN"] = "Admin";
$language["SB_BET_INFO"] = "Spelinfo";
$language["SB_END_BETS"] = "Spelet avslutas";
$language["SB_BET_TITLE"] = "Sastningsrubrik";
$language["SB_BETTING_ON"] = "Spelar på";
$language["SB_ENTER_WAGER"] = "Lägg din insats här";
$language["SB_ENDTIME"] = "Stopptid";
$language["SB_MINS"] = "minuter";
$language["SB_HOUR"] = "timme";
$language["SB_HOURS"] = "timmar";
$language["SB_DAY"] = "dag";
$language["SB_DAYS"] = "dagar";
$language["SB_WEEK"] = "vecka";
$language["SB_WEEKS"] = "veckor";
$language["SB_ORDERING"] = "Beställning";
$language["SB_BY_ID"] = "med ID";
$language["SB_BY_ODDS"] = "Med oddset";
$language["SB_SUBMIT"] = "Lämna";
$language["SB_CREATOR"] = "Skapare";
$language["SB_SET_ACTIVE"] = "Sätt aktiv";
$language["SB_ADD_OPTIONS"] = "Lägg till alternativ";
$language["SB_GAMES"] = "Spel";
$language["SB_TOP_LIST"] = "Topplista";
$language["SB_POINTS"] = "Poäng";
$language["SB_WINNER"] = "Vinnare";
$language["SB_LOSER"] = "Förlorare";
$language["SB_POSITION"] = "Position";
$language["SB_SORRY"] = "Tyvärr";
$language["SB_NO_ACCESS"] = "Du har inte tillstånd att se denna sida.";
$language["SB_NO_ACT_GAMES"] = "Du har inga aktiva spel.";
$language["SB_BET_OPT"] = "Valmöjligheter";
$language["SB_ODDS"] = "Odds";
$language["SB_POY_PAY"] = "Potentiell utbetalning";
$language["SB_AMOUNT_WAGERED"] = "Summa satsat";
$language["SB_CANT_DEL_1"] = "Det går inte att ta bort ett spel som man redan satsat på.";
$language["SB_CANT_DEL_2"] = "Klicka här";
$language["SB_CANT_DEL_3"] = "att ta bort spelet och återbetala insatser som redan är gjorda.";
$language["SB_CANT_DEL_4"] = "Du försöker ta bort ett alternativ som man redan satsat på. Du måste";
$language["SB_CANT_DEL_5"] = "När du gjort detta kan du återskapa spelet med nya alternativ.";
$language["SB_ADD_BETS"] = "Fler satsningar";
$language["SB_WARNING"] = "! Varning !";
$language["SB_CLICK_TO_PAY"] = "Klicka på det vinnande valet för att betala vinnarna!";
$language["SB_BET_RES"] = "Vadslagningsresultat";
$language["SB_NO_POST"] = "Ingen post hittad";
$language["SB_BET_WIN"] = "Satsning vinner!";
$language["SB_BET_PROFIT"] = "Vadslagningsvinst +";
$language["SB_PM_MESS_1"] = "Du har just erhållit";
$language["SB_PM_MESS_2"] = "Bonuspoäng i insats!"."\n"."Du spelade";
$language["SB_PM_MESS_3"] = "poäng på";
$language["SB_PM_MESS_4"] = "Alternativ";
$language["SB_PM_MESS_5"] = "vilket gav";
$language["SB_PM_MESS_6"] = "gånger insatsen!"."\n\n";
$language["SB_PM_MESS_7"] = "\n\n"."För att se hela resultatet av vadslagningen, följ denna länk:"."\n\n";
$language["SB_FOR_MESS_1"] = "Antal vad som satsats i spelet";
$language["SB_FOR_MESS_2"] = "Totalt bonuspoäng i omsättning i spelet";
$language["SB_FOR_MESS_3"] = "Vinstval";
$language["SB_FOR_MESS_4"] = "Spelet avslutades av";
$language["SB_FOR_MESS_5"] = "Valmöjligheter och odds";
$language["SB_FOR_MESS_6"] = "Topp 20 vinnare";
$language["SB_FOR_MESS_7"] = "Bonuspoäng";
$language["SB_FOR_MESS_8"] = "till";
$language["SB_FOR_MESS_9"] = "vem satsade";
$language["SB_FOR_MESS_10"] = "Topp 20 förlorare";
$language["SB_PM_MESS2_1"] = "Tyvärr visade det sig att din insats i";
$language["SB_PM_MESS2_2"] = "gav ingen utdelning!"."\n"."Bättre lycka nästa gång!"."\n\n";
$language["SB_BET_LOSS"] = "Vadförlust!";
$language["SB_CREATE_BETS"] = "Skapa vad";
$language["SB_BONUS"] = "Bonus";
$language["SB_BETINF"] = "Vadslagningsinformation!";
$language["SB_BETINF_MSG"] = "Site-Bet är ett odds/vadslagningssystem som liknar andra vadslagningssidor på webben.<br />Om du är obekant med vadslagningssystemet så är det ändå lätt att förstå.<br /><br /><li>På Site-Bet använder du bara din poäng du fått som seedbonus.</li><li>När du satsar poäng på resultat, kommer du få de poäng du satsat multiplicerat med oddset för ditt val.</li><li>Din satsning är bindande och kan ej ångras.</li><li>Oddsen varierar.</li><li>Oddset och den vinstsumma som betalas ut kan ökas eller minskas när du gjort din satsning.</li><br />Det är resultatet efter full tid som räknas, så vad väntar du på? Satsa nu!<br /><br /><b>Banken behåller 3% av vinstsumman så det inte går inflation i bonuspoäng.</b>";
$language["SB_BAD_ID"] = "Inget spel med sådant ID.";
$language["SB_NO_BON_LOG"] = "Ingen bonuslogg med liknande meddelande.";
$language["SB_OP_LOG_1"] = "Antalet operationer och bonusloggar matchar inte.";
$language["SB_OP_LOG_2"] = "vs."; // Short for versus
$language["SB_OP_LOG_3"] = "Fan också...";
$language["SB_OP_LOG_4"] = "Gör det i alla fall";
$language["SB_RET_POINTS_1"] = "Du har fått tillbaka";
$language["SB_RET_POINTS_2"] = "Poäng du satsat";
$language["SB_RET_POINTS_3"] = "På grund av fel i oavslutade/ospelade matcher återställdes det.";
$language["SB_BET_REBATE"] = "Satsningsrabatt";
$language["SB_BBAS"] = "Betbonus i potten";
$language["SB_SOFTBET"] = "Softbet";
$language["SB_MY_GAMES"] = "Mina spel";
$language["SB_AMOUNT"] = "Summa";
$language["SB_CANT_UNDO"] = "Observera att du inte kan ångra detta";
$language["SB_NOT_ENOUGH_POINTS"] = "Du har inte tillräckligt med bonuspoäng!";
$language["SB_BET_TOO_LOW"] = "Du får inte satsa noll eller mindre!";
$language["SB_MAX_BET_1"] = "Maximalt bet är";
$language["SB_MAX_BET_2"] = "bonuspoäng!";
$language["SB_ALREADY_BET"] = "Du har redan satsat i det här spelet!";
$language["SB_ADD_OPT_TO_BET"] = "Lägg till valmöjligheter till din satsning!";
$language["SB_OPT_TXT"] = "Tillvalstext";
$language["SB_ADD_TO_GAME"] = "Lägg till i spelet";
$language["SB_ADD_1X2"] = "Lägg till 1, X, 2";
$language["SB_SAVE_CHANGES"] = "Spara ändringar";
$language["SB_CLICK"] = "Klicka";
$language["SB_HERE"] = "Här";
$language["SB_DEL_GAME"] = "för att ta bort spelet.";
$language["SB_DEL_AND_REPAY"] = "för att ta bort spelet och återbetala poäng till alla.";
$language["SB_SHOUT_1"] = "[color=red]Nytt vad[/color]";
$language["SB_SHOUT_2"] = " - Sluttid: ";
$language["SB_SHOUT_3"] = "Gå till vadslagning";
$language["SB_OPTIONS"] = "Tillval";
// Sport Betting - End

// Torrents Limit
$language["TORRENTS_LIMIT"] = "Torrentgräns";
$language["ENTER_NEG"] = "Lägg in ett negativt värde, t.ex <b><span style='color:#0000FF'>-1</span></b> för att återgå till standard för rangen";

// Enhanced Waiting Time
$language["WAITING_TIME"] = "Väntetid (timmar)";

// Auto Duplicate Torrent Checker
$language["TOP_MATCHES"] = "Dessa är de bäst jämförbara i vår databas baserat på torrentnamn, kontrollera att du inte lägger  upp en dublett innan du fortsätter.";

// Whois
$language["WHOIS"] = "Whois";

// Ban Button
$language["ERR_REG_IP_BANNED"] = "Registreringar från din IP-adress är för närvarande bannade på grund av missbruk, tyvärr!";
$language["DTBAN"]="IP Ban";

// Torrent Nuked/Requested
$language["TNR_REL_REQ"]="Denna release är requestad.";
$language["TNR_REQUESTED"]="Requested";
$language["TNR_NUKED"]="Nuked";

// Torrent moderation
$language["TMOD_APR1"] = "din torrent";
$language["TMOD_APR2"] = "är godkänd!";
$language["TMOD_APR3"] = "\n\n"."[color=red][b]Detta är ett automatiskt meddelande, svara inte.[/b][/color]";
$language["TMOD_SOR1"] = "Tyvärr";
$language["TMOD_SOR2"] = "men";
$language["TMOD_SOR3"] = "har förkastats av följande skäl";
$language["TMOD_SOR4"] = "\n\n"."[color=red][b]Detta är ett automatiskt meddelande, svara inte.[/b][/color]";
$language["TMOD_SEN1"] = "Ditt meddelande har skickats.";
$language["TMOD_SEN2"] = "Du måste ange ett skäl.";
$language["TMOD_OK"] = "OK";
$language["TMOD_BAD"] = "Bad";
$language["TMOD_UM"] = "Omodifierad";
$language["TMOD_S_MOD"] = "Mod.";
$language["TMOD_S_CAT"] = "Kat.";
$language["TMOD_Dl"] = "Dl";
$language["TMOD_NOTORR"] = "Inga torrenter omodifierade.";
$language["ACP_ADD_WARN"]="Orsak till torrentmodifiering";
$language["WARN_TITLE"]="Benämning på orsak";
$language["WARN_TEXT"]="Förklara orsak";
$language["WARN_ADD_REASON"]="Lägg till ny orsak";
$language["TRUSTED"]="Säker";
$language["TRUSTED_MODERATION"]="Säker modifiering";
$language["TORRENT_STATUS"]="Torrent status";
$language["TORRENT_MODERATION"]="Modifiering";
$language["MODERATE_TORRENT"] = "Modifiera";
$language["MODERATE_STATUS_OK"] = "Ok";
$language["MODERATE_STATUS_BAD"] = "Bad";
$language["MODERATE_STATUS_UN"] = "Omodifierad";
$language["FRM_CONFIRM_VALIDATE"] = "Återställ till omodifierad";
$language["MODERATE_PANEL"] = "Mod Torrent Panel";
$language["TMOD_EDIT_TO_RESEND"] = "<br/>(ändra för att returnera till validering)";
$language["TMOD_APPROVED_BY"] = "Godkänd Av";
$language["TMOD_REJECTED_BY"] = "Nekad Av";
// Uploader Medals
$language["UM_BRONZE"] = "Bronsmedalj";
$language["UM_SILVER"] = "Silvermedalj";
$language["UM_GOLD"] = "Guldmedalj";
$language["UM_UPL_MED"] = "Uppladdningsmedalj";
$language["UM_MED"] = "Med";
$language["UM_NICK"] = "Nickname";
$language["UM_TOR"] = "Tor";
$language["UM_UP_COUNT_1"] = "Uppladdningsberäkning (senaste";
$language["UM_UP_COUNT_2"] = "dagar)";
$language["UM_NOTHING_TO_SEE"] = "Inget att se här!";

// NFO Hack
$language["NFO_NFO"] = "NFO";
$language["NFO_NOT_NFO"] = "Inte en nfo-fil!";
$language["NFO_NOT_VALID"] = "Ogiltig eller för liten nfo!";
$language["NFO_CANT_MOVE"] = "Det gick inte att flytta nfo-filen!";
$language["NFO_UNCHECK"] = "<b>Avmarkera</b> ta bort eller ladda upp en ny nfo-fil";
$language["NFO_OPTION"] = "Alternativt väljer att leta efter en nfo-fil";
$language["NFO_SHOW_HIDE"] = "Visa | Dölj NFO";

// Teams Hack
$language["TEAMS_TEAM"]="Grupp";

$language['WS_WARNED_USER'] = 'Varnad användare!';
$language['WS_WARN_REMOVED_SUBJECT'] = 'Din varningstid har löpt ut!!';
$language['WS_WARN_REMOVED_MESSAGE'] = 'Du är inte längre varnad, var försiktig så du inte gör samma misstag igen!!';
$language['WS_WD'] = 'Varningsdata';
$language['WS_RFW'] = 'Skäl för att öka varning';
$language['WS_ET'] = 'Löptid';
$language['WS_WT_PLURAL'] = 'varnad gånger';
$language['WS_WAB'] = 'Varning tillagd av';
$language['WS_AM'] = 'Admin Meny';
$language['WS_RW'] = 'Ta bort varning';
$language['WS_WS'] = 'Varningsinställning';
$language['WS_WT'] = 'Varningstid';
$language['WS_D'] = 'Dag';
$language['WS_W'] = 'Vecka';
$language['WS_W_PLURAL'] = 'Veckor';
$language['WS_Y'] = 'År';
$language['WS_WM'] = 'motiv för varning';
$language['WS_WC_SUBJ'] = 'Sänkt varningsnivå';
$language['WS_WC_MSG'] = 'Vi har minskat din varningsnivå av följande skäl';
$language['WS_WCF'] = 'Varningen upphävd därför att';
$language['WS_WR'] = 'Varningen borttagen';
$language['WS_YHRAW'] = 'Ökad varningsnivå';
$language['WS_TRFW'] = 'Vi har ökat din varningsnivå av följande skäl';
$language['WS_EDFW'] = 'Varningen utgår den';
$language['WS_WU'] = 'Varnad användare';
$language['WS_R'] = 'Orsak';
$language['WS_WARNED_USERS'] = 'Varnade användare';
$language['WS_WL'] = 'Varningsnivå';
$language['WS_WARN'] = 'Varning';

// More Warn system definitions
$language['WS_SEND_PM'] = "PM användare";
$language['WS_CANT_WARN'] = "Du kan inte varna dig själv!";
$language["WS_UNK_TYPE"] = "Okänd typ!";
$language['WS_SUBMIT'] = "Lämna";
$language['WS_MUST_GIVE_REASON'] = "Du måste ange ett skäl för varningen!";
$language['WS_RFRW'] = 'Anledning till att minska varning';
$language["WS_CANT_DEC"] = "Du kan inte minska varningsnivån ytterligare!";
$language["WS_CANT_INC"] = "Du kan inte öka varningsnivån ytterligare!";
$language["WS_WARN_EXP"] = "Varningen försvinner (dagar)";
$language["WS_BLANK_4_INF"] = "(Lämna tomt för permanent varning)";
$language["WS_AUTO_MSG"] = "[b][color=red]Detta är ett automatiskt meddelande, var vänlig svara inte[/color][/b]";
$language["WS_YOUR_CUR_LEV"] = "Nuvarande varningsnivå är";
$language["WS_DEC_IN_DAYS_1"] = "Om du inte får fler varningar kommer din varningsnivå automatiskt minska";
$language["WS_DEC_IN_DAYS_2"] = "dagar.";
$language["WS_WARNLOG"] = "Varningslogg";
$language["WS_NEXT_AUTO_DOWNGRADE"] = "Nästa automatiska nergradering";
$language["WS_WARNED_BY"] = "Varnad av";
$language["WS_NOTES"] = "Anteckningar";
$language["WS_NOTHING_2_C"] = "Inget att se här!";
$language["WS_LOGS_4"] = "Sparat varninglogg för";
$language["WS_INC_WL"] = "Ökad varningsnivå";
$language["WS_DEC_WL"] = "Minskad varningsnivå";
$language['WS_INC'] = "Öka varningsnivå";
$language['WS_DEC'] = "Sänk varningsnivå";
$language["WS_AUTO_REASON"] = "Automatisk varningsnivåminskning";
$language["WS_WARNED_ON"] = "Varnat på";
$language["WS_REP_ON"] = "Respit på";
$language["WS_REP_BY"] = "Respit av";
$language["WS_WHY_BOOTED"] = "Automatisk start för att ha uppnått maximal varningsnivå";

// Circling Last Torrents
$language["CIRC_NEW_REL"] = "Senaste releaser";
$language["CIRC_NO_TORR"] = "För närvarande inga torrenter...";
$language["CIRC_SEEDERS"] = "Seeders";
$language["CIRC_LEECHERS"] = "Leechers";

//Private Shouts
$language['SHOUTBOXP']='Privat Shouts';

// Block Comments
$language["BC_AB_ERR"] = "Missbruksfel";
$language["BC_U_R_BANNED"] = "På grund av missbruk är du bannad från kommentarer!! Om du anser att det är ett misstag, kontakta någon i staffen.";
$language["BC_COM_LOCKED"] = "Kommentarer låsta";
$language["BC_OVERALL_ABUSE"] = "På grund av missbruk har kommentarsfunktionen tagits bort på denna torrent!";

// Account Parked
$language["PARK_PARKED"] = "(Parkerat)";
$language["PARK_ACC_PARKED"] = "Account Parked";
$language["PARK_ACC_PARKED_INFO_1"] = "Ditt konto är för närvarande parkerat. För att koppla ur parkeringsfunktionen";
$language["PARK_ACC_PARKED_INFO_2"] = "klicka här";
$language["PARK_PARK_ACC"] = "Parkera konto";

// Hit & Run
$language["HNR_BLOCK_SETTINGS"] = "Hit & Run Blockeringsinställning";
$language["HNR_EVENT_DATE"] = "Gjorde HIT & RUN på";
$language["USERNAME"] = "Användarnamn";
$language["SEEDING_TIME"] = "Seedar tid";
$language["NO_HR"] = "Inga Hit & Runners hittade";
$language["HNR_WARN_DEC"] = "Automatisk Hit & Run minskning!";
$language["HNR_WARN_INC"] = "Automatisk Hit & Run ökning!";
$language["HNR_CANT_DOWN"] = "Du får inte ladda ner nya torrenter på grund av din Hit & Run lista, för att låsa upp torrentnerladdningen måste du seeda det du redan laddat ner!";

// Low Ratio Warn & Ban System
$language["RAT_SUBJ"] = "Varning för låg ratio!";
$language["RAT_SUBJ_2"] = "Andra varningen för låg ratio!";
$language["RAT_SUBJ_3"] = "Sista varningen för låg ratio!";
$language["RAT_NOTHING_YET"] = "Inget att se ännu";
$language["RAT_WARN_X"] = "varna x";
$language["RAT_BANNED"] = "banaed";

// Hide Online Status
$language["HOS_INV_2_OTHERS"] = "Osynlig för andra användare";
$language["HOS_HIDDEN"] = "Dold";

// Upload Multiplier
$language["UPM_UPL_MULT"] = "Uppladdningsmultiplikator";
$language["UPM_RANK_INV"] = "Ogiltig rang";

// Proxy / Blacklist
$language['CHANGE_CONFIRM']='Är det säkert du vill ändra denna användares nerladdningsrättigheter?';
$language['CHANGED']='Växla';

//Auto Images
$language["IMG_SUCCESS"]="<center><h4>Bilden är framgångsrikt behandlad!<br>Klicka på bilden för att sätta in i beskrivningen.</h4></center>";
$language["IMG_INFO"]="<center>Bilder sökta mot ditt filnamn. Klicka för att använda.</center>";

// New Comment Layout
$language["NCL_COM_EDIT"] = "Kommentera Ändra";

//FAQ
$language["MNU_FAQ"]="F.A.Q.";
$language["FAQ_NAME"]="FAQ-grupp, namn";
$language["FAQ_TEXT"]="FAQ-grupp, beskrivning";
$language["FAQ_SORT_INDEX"]="FAQ-gruppens sorteringsindex";
$language["FAQ_ADD"]="Sätt in i FAQ-gruppen";
$language["FAQ_QUESTION"]="FAQ fråga";
$language["FAQ_ANSWER"]="Svar";
$language["FAQ_QUESTION_ADD"]="Sätt in FAQ frågor/svar";
$language["FAQ_QUESTION_SEARCH_ALL"]="Sök alla...";
$language["FAQ_AGREE"]="Jag har läst och samtycker till att följa de villkor som anges i denna FAQ.";

// Torrent Bookmarks
$language["TB_FAV"] = "Bokmärkta torrenter";
$language["TB_BOOKMARK"] = "Bokmärk denna torrent";
$language["BOOKMARK"]="Dina bokmärkta torrenter";
$language["ADDB"]="Bokmärk";
$language["TB_DOWN"] = "Nere";
$language["TB_BOOKMARKED"] = "Bokmärkt";
$language["TB_ALREADY_BOOK"] = "Torrenten är redan bokmärkt";
$language["TB_NO_TORR_EXISTS"] = "Det finns ingen torrent för den angivna info hashen";
$language["TB_NOTHING_TO_SEE"] = "Finns inget att se här än";

// Birthday hack
$language["DOB"]="Födelsedatum";
$language["DOB_FORMAT"]="<b>Dag (DD) / Månad (MM) / År (YYYY)</b>";
$language["USER_AGE"]="Ålder";
$language["HB_SUBJECT"]="Grattis på födelsedagen";
$language["HB_MESSAGE_1"]=":hbd:\n\nDitt konto har krediterats med ";
$language["HB_MESSAGE_2"]=" av uppladdat krediteras. (";
$language["HB_MESSAGE_3"]=" GB för varje år av ditt liv). staffen på $SITENAME önskar dig all lycka i framtiden.\n\n:yay:";
$language["ERR_BORN_IN_FUTURE"]="Tidsresenär, va? Du kan inte vara född i framtiden!";
$language["ERR_DOB_1"]="Det tror jag inte du är";
$language["ERR_DOB_2"]=" år gammal.";
$language["INVALID_DOB_1"]="Lagt in fdelsedatum (";
$language["INVALID_DOB_2"]=") är ogiltig";

$language["CANT_VIEW_PAGE"] = "Tyvärr har du inte tillstånd att besöka denna sida!";

$language["UN_ADDED_BY"] = "Tillagd av";
$language["UN_NOTE"] = "Anteckning";
$language["UN_NOTES"] = "Anteckningar";
$language["UN_ADD_NOTE"] = "Lägg till anteckning";

$language['REALCOUNTRY']='IP-land';
//advanced torrent search extra 
$language['UPLS']='Uppladdare'; 

$language["UN_BONUS_GENERAL_1"]="har använt";
$language["UN_BONUS_GENERAL_2"]="bonuspoäng på";
$language["UN_VIP_RANK"]=" Vip-rang.";
$language["UN_ONE_INV"]="en inbjudan.";
$language["UN_THREE_INV"]="tre inbjudningar.";
$language["UN_FIVE_INV"]="fem inbjudningar.";
$language["UN_GIFT_SEND_1"]="har skickat";
$language["UN_GIFT_SEND_2"]="en gåva";
$language["UN_GIFT_SEND_3"]="bonuspoäng.";
$language["UN_GIFT_REC_1"]="har fått en gåva av";
$language["UN_GIFT_REC_2"]="bonuspoäng från";
$language["UN_UL_CREDIT"]="av uppladdning krediterad.";
$language["UN_UL_USERNAME"]="ett användarnamnbyte till";
$language["UN_UL_TITLE"]="custom title till";
$language["UN_DONATE_1"]="har donerat";
$language["UN_DONATE_2"]="och mottaget";
$language["UN_DONATE_3"]="av uppladdning krediterad";
$language["UN_DONATE_4"]="VIP rang tills ";
$language["UN_DONATE_5"]="dagar";
$language["UN_DONATE_6"]="VIP rang tills vidare";
$language["UN_DONATE_7"]="eftersom denne medlem sitter med i staff, påverkas inte hans/hennes rang.";
$language["UN_WLEV_INC"]="Varningsnivå ökad, se varningsloggen för mer detaljer";
$language["UN_WLEV_DEC"]="Varningsnivå minskad, se varningsloggen för mer detaljer";
$language["UN_AUTORANK_1"]="har fått sin rang automatiskt ändrad från";
$language["UN_AUTORANK_2"]="till";
$language["UN_AUTORANK_3"]="av Autorank";
$language["UN_AUTORANK_4"]="U";    // Short for Uploaded
$language["UN_AUTORANK_5"]="D";    // Short for Downloaded
$language["UN_AUTORANK_6"]="SR";   // Short for Share Ratio
$language["UN_AUTORANK_7"]="Inf."; // Short for Infinite
$language["UN_BOOTED"]="har automatiskt startats för att maximal varningsnivå är uppnådd";
$language["UN_MAN_BOOTED_1"]="har startats manuellt tills";
$language["UN_MAN_BOOTED_2"]="för";
$language["UN_UNBOOTED"]="har manuellt kopplats ner";
$language["UN_BAN_BUT_1"]="har bannats via Banknappen för att";

//end of month paypal setting diemthuy
$language["AADS_AUTO"] ="Auto set ny månad"; 
//for forced faq. 
$language["SUBMIT"] ="Lämna";

$language["STAFF_COMMENT"]="Staffkommentar";

$language["QUAR_PM_SUBJ"]="Misstänkt hackerförsök";
$language["QUAR_PM_MSG_1"]="försökte ladda upp en fil med php-kod. Filen har satts i karantän";
$language["QUAR_PM_MSG_2"]="Det är dock möjligt att det är falskt negativt, så kontrollera denna fil med hex-editorn eller något innan användaren bannas."."\n\n"."Försöket gjordes via";
$language["QUAR_OUTPUT"]="Försöket att ladda upp en fil med php-kod förhindrades och du har rapporterats till sidans ägare!";
$language["QUAR_ERR"]=" Fel i karantänkatalogen";

$language["QUAR_DIR_PROBLEM_1"]="Karantänkatalog";
$language["QUAR_DIR_PROBLEM_2"]="finns inte, lägg in en giltig karantänkatalog i [b]Admin Panel-->Security Suite Settings[/b]";
$language["QUAR_DIR_PROBLEM_3"]="är inte skrivbar, vänligen CHMOD till 0777";
$language["QUAR_UNABLE"]="På grund av ett oförutsett fel går det inte att skicka filen till karantän, vänligen se igenom dina övriga PM för att kunna lösa problemet";
$language["QUAR_NOT_SET"]="Katalog ej vald";

$language["QUAR_TMP_FILE_MISS"]="Går inte att hitta tempfilen!";


$language["UIMG"]="User Images & Titles";
$language["UIMG_NO_ICONS"]="Du har inga användarikoner ännu";
$language["UIMG_TM_NO_ICONS"]="Den här medlemmen har inga användarikoner än";
$language["UIMG_MSG_1"]="Välkommen";
$language["UIMG_MSG_2"]="här kan du se alla tillgängliga bilder/titlar inklusive din egen (om du har någon)";
$language["UIMG_MSG_3"]="Dina användarbilder";
$language["UIMG_USR_ICONS"]="Användarikoner";
$language["UIMG_USR_IMGS"]="Användarbild";

//shoutbox clean 
$language["SHOUT_CLEANED"]="[b]Shoutboxen har just städats![/b][IMG]".$BASEURL."/images/sweep.gif[/IMG]";

$language["ERR_PASS_TOO_WEAK_1"]="Ditt lösenord är för svagt.<br />Av säkerhetsskäl måste det innehålla";
$language["ERR_PASS_TOO_WEAK_1A"]="Lösenordet är för svagt.<br />Av säkerhetsskäl måste det innehålla";
$language["ERR_PASS_TOO_WEAK_2"]="liten bokstav";
$language["ERR_PASS_TOO_WEAK_2A"]="små bokstäver";
$language["ERR_PASS_TOO_WEAK_3"]="stor bokstav";
$language["ERR_PASS_TOO_WEAK_3A"]="stora bokstäver";
$language["ERR_PASS_TOO_WEAK_4"]="nummer";
$language["ERR_PASS_TOO_WEAK_4A"]="nummer";
$language["ERR_PASS_TOO_WEAK_5"]="symbol";
$language["ERR_PASS_TOO_WEAK_5A"]="symboler";
$language["ERR_PASS_TOO_WEAK_6"]="Ett starkt lösenord till dig";
$language["SECSUI_ACC_PWD_1"]="Ditt lösenord måste:";
$language["SECSUI_ACC_PWD_1A"]="Lösenordet måste:";
$language["SECSUI_ACC_PWD_2"]="Åtminstone";
$language["SECSUI_ACC_PWD_3"]="teckenlängd";
$language["SECSUI_ACC_PWD_3A"]="teckenlängd";
$language["SECSUI_ACC_PWD_4"]="Åtminstone";
$language["SECSUI_ACC_PWD_5"]="liten bokstav";
$language["SECSUI_ACC_PWD_5A"]="små bokstäver";
$language["SECSUI_ACC_PWD_6"]="stor bokstav";
$language["SECSUI_ACC_PWD_6A"]="stora bokstäver";
$language["SECSUI_ACC_PWD_7"]="nummer";
$language["SECSUI_ACC_PWD_7A"]="nummer";
$language["SECSUI_ACC_PWD_8"]="symbol";
$language["SECSUI_ACC_PWD_8A"]="symboler";

$language["DIRECT_LINK"]="Direkt nerladdning<br />(valid url)";
$language["DIRECT_DOWNLOAD"]="Direkt nerladdning";

$language["AM_ABOUT_ME"] = "Om mig";

$language["MTS_ANNURL"] = "Announce URL";
$language["MTS_SEED"] = "Seeders";
$language["MTS_LEECH"] = "Leechers";
$language["MTS_DOWN"] = "Nerladdad";

$language["LAST_LOCATION"]="Senaste plats";
$language["WHEN_LOCATION"]="När";
$language["WATCH_LOG"]="Watch Log";

$language["PARTNERS"]="Våra partners";
$language["PAR_SURE_DEL"]="Är det säkert att du vill ta bort denna partner?";
$language["PAR_BANNER"]="Banner";
$language["PAR_NAME"]="Namn";
$language["PAR_LINK"]="Länk";
$language["PAR_ADDEDBY"]="Tillagd av";
$language["PAR_EDDEL"]="Ändra/Ta bort";
$language["PAR_NO_PART"]="Ingen partner ännu...";
$language["PAR_NO_PART_2"]="Ingen partner med detta ID";
$language["PAR_ADD_NEW"]="Lägg till en ny partner";
$language["PAR_TITLE"]="Titel";
$language["PAR_BAN_URL"]="Banner URL";
$language["PAR_LINK"]="Link";
$language["PAR_3RD_PARTY"]="Vissa sajter stänger av möjligheten att snabbkoppla bilder, så det rekommenderas att hosta dem på en tredje-partssida.";
$language["PAR_UPDATE"]="Uppdatera";
$language["PAR_ED_PART"]="Redigera partner";
$language["PAR_CUR_BAN"]="Nuvarande Banner";
$language["PAR_BACK"]="Back";

$language['details_similar_torrents'] = "Liknande torrenter";
$language['details_name'] = "Namn";
$language['details_seeders'] = "Seeders";
$language['details_leechers'] = "Leechers";
$language['details_size'] = "Storlek";
$language['details_date'] = "Tillagd";

$language["SHORT_EXTERNAL"]="EXT";
$language["LOGS_PHP"]="PHP fellogg";
$language["LOGS_LINE_AMT"]="<b>Antal linjer:</b>";
$language["LOGS_LINE_AMT_1"]="<b>Hur många linjer för att visa loggen</b>";
$language["LOGS_COOLY_NAME"]="<b>Logg namn:</b>eller vad du önskar kalla dina loggar. Tänk på något autentiskt.";
$language["LOGS_COOLY_NAMES"]="Det kommer vara samma namn för varje logg med undantag för datumstämpeln.";
$language["LOGS_COOLY_PATH"]="<b>Log Path/b>&nbsp;Above doc root would be a good choice \"if possible\" no forward slash<br /> and folder must be writable.If you have an open basedir restriction you are best to keep the current path.";
$language["LOGS_COOLY_PATHS"]="Rekommenderad:";
$language["LOGS_COOLY_NOTE"]="<b>Om du ändrar sökväg till en annan dokumentrootkatalog, kom ihåg att kopiera .htaccess till den nya katalogen.</b>";
$language["LOGS_COOLY_LIST"]="Listan på gamla loggar i din mapp.";
$language["LOGS_COOLY_FLUSH"]="Rensa</a> gamla loggar";
$language['SSL'] = "Tvinga SSL:";
$language['SSL_DESC'] = "eller; Tvinga en säker anslutningpå sidan.";
$language['ADDTHIS_SHARE']='Dela';
$language['ADDTHIS_SHARE2']='Dela med vänner';

$language["REFRESH_PEERS"]="Uppdatera antal Peers";

$language["SB_GET_1_INV"]="Erhåll 1 inbjudan";
$language["SB_GET_3_INV"]="Erhåll 3 inbjudningar";
$language["SB_GET_5_INV"]="Erhåll 5 inbjudningar";
$language["SB_SHORT_MAXIMUM"]="Max.";
$language["SB_DECREASE_HNR"]="Ta bort äldsta Hit & Run";
$language["SB_OLDEST_HNR"]="Din äldsta Hit & Run";
$language["SB_NO_HNR"]="Ingen Hit & Run hittad";

$language["HNR_NOT_ENOUGH"]="Det finns inte tillräckligt med bonuspoäng för att köpa bort en Hit & Run";
$language["HNR_ABBREVIATION"]="H&Rs";

$language["SP_SHOW_PORN"] = "Visa porr?";

$language["PRIVATE"]="Privat Profil";
$language["PP_PRIVATE"]="Privat";
$language["PP_PUBLIC"]="Offentlig";
$language["PP_PROFILE"]="Profil";

$language["LANGUAGE"]="Språk";
$language["LANG_ENG"]="Engelska";
$language["LANG_FRE"]="Franska";
$language["LANG_DUT"]="Holländska";
$language["LANG_GER"]="Tyska";
$language["LANG_SPA"]="Spanska";
$language["LANG_ITA"]="Italienska";

$language['MPLAYER']='Media Clip';
$language['MPLAYERNON']='Media Clip inte tillgänglig';

$language["SIGNATURE"]="Forum Signatur";

$language["TOT_MOST_ONLINE"]="Top 10 Online Tider";
$language["TOT_TIME_IS"]="Total online tid är";
$language["TOT_ONLINE_TIME"]="Online Tid";

$language["LDB_AGO_LEG"]="Förklaring: d=dag, v=vecka, m=min, t=timme, s=sekund.";
$language["LDB_AGO_NTSH"]="Det finns inget att se här";
$language["LDB_DB_EMPTY"]="Databasen är tom";
$language['ULR']='Bli Uppladdare';
$language['FRIEDNLIST']='Vänner';
$language["IMGUP_DIM_TOO_BIG_1"]="Din bild är för stor.<br />Max storlek är:";
$language["IMGUP_DIM_TOO_BIG_2"]="Pixels.<br /><br />Din bild är:";
$language["IMGUP_DIM_TOO_BIG_3"]="Pixels.<br /><br />Ändra storleken å försök igen.";

# Language expected torrents start
$language['VOTE_EXPECTED_NO']='Rösta MOT detta ';
$language['viewexpected']='Se Erbjudna Torrents';
$language['EXPECTED_V']='Erbjudna Torrents';
$language['EXPECTED_VV']='Se röster På Erbjudna';
$language['EX_NAME']='Erbjud';
$language['EXPECTED_D']='Erjuden Torrents Detaljer';
$language['EXPECTED_E']='Ändra erbjudna Torrents';
$language['INC_DEAD']='Inc. dead';
$language['ADD_EXPECTED']='Lägg till ny erbjuden torrent';
$language['EXPECTED']='Väntande';
$language['EXPECVOTE']='Väntande/Rösta';
$language['OFFER']='Erbjudande';
$language['VIEW_MY_EXPECTED']='Se min erbjudna torrents';
$language['VIEW_ONLY']='Bara se';
$language['TYPE']='Skriv';
$language['FIND_EXPECT']='Hitta';
$language['GO']='Kör';
$language['WRITE_CATEGORY']='Välj Kategori!';
$language['NO_NAME']='Inget Namn!';
$language['NO_DESCR']='Beskrivning Tom!';
$language['EXP_ADD_SUCCES']='Flyttad till Väntande Sektion';
$language['MUST_SEL_EXP']='Måste välja mins en väntande för att ta bort.';
$language['DELETED']='Borttagen';
$language['RETURN_EXPECT']='Tillbaka till';
$language['DATE_EXPECTED']='Datum Väntande';
$language['TORR_LINK']='Torrent Länk';
$language['TORR_CLICK']='Klicka här för att se torrent';
$language['FILL_INFO']='Om du laddat upp torrenten , Fyll i Info här under';
$language['VOTE_EXPECTED']='Rösta på denna';
$language['OFFER_A']='Rösta';
$language['OFFER_N']='Inget här än';
$language['OF_USER']='Användar namn';
$language['TEXT_DTA']='<p>Du har redan röstat på denna endast en röst på varje erbjudning</p></b>';
$language['TEXT_DTB']='Röstning OK';
$language['TEXT_DTC']='Din röst är tillagd på denna';
$language['TEXT_DTD']='Behövs bara för väntande torrents!';
# Language expected torrents end

// Friends DT
$language["FL_FRIENDLIST"]="Vänlista";
$language["FL_UNFRIEND"]="Vill du ta bort medlem som vän?";
$language["FL_REFRIEND"]="Vill du bli vän med denna medlem?";
$language["FL_REJECT"]="Vill du neka medlemen att bli vän med dig?";
$language["FL_REMOVE"]="Vil du tabort denna väntande förfrågning?";
$language["FL_FPENDING"]="Väntande förfrågningar";
$language["FL_FFRIEND"]="Vänförfrågningar";
$language["FL_FAVATAR"]="Avatar";
$language["FL_FUN"]="Namn";
$language["FL_FUL"]="Klass";
$language["FL_FRD"]="Förfrågnings Datum";
$language["FL_FFD"]="Vän Sedan";
$language["FL_FFF"]="Vän med";
$language["FL_FRDD"]="Datum nekad";
$language["FL_FRU"]="Neka medlem";
$language["FL_FCONF"]="Bekräftade Vänner";
$language["FL_FREJ"]="Nekade Medlemar";
$language["FL_FRR"]="Tabort förfrågan";
$language["FL_FSTAT"]="Status";
$language["FL_FRE"]="Återaktivera vän";
$language["FL_FUF"]="Inaktivera vän";
$language["FL_FATF"]="Lägg till vän";
$language["FL_FMF"]="Gemensam vän";
$language["FL_W2BF"]="Vill bli vän";
$language["FL_FRREQ"]="Vänförfrågan!";
$language["FL_W2BF2"]="vill bli vän med dig."."\n\n"."Gå till din vänlista för att acceptera eller neka förfrågan";
$language["FL_AUTOMSG"]="\n\n"."[b][color=red]AUTOMATIC SYSTEM MESSAGE - PLEASE DON'T REPLY !![/color][/b]";
$language["FL_ALRFR"]="Denna medlem är redan vän med dig.";
$language["FL_SELFFR"]="EGO Du kan inte bli vän med dig själv, OK?";
$language["FL_REQDEL"]="Vänförfrågan borttagen!";
$language["FL_DELREQ_1"]="har tagit bort vänförfrågan."."\n\n"."Det är därför stor risk att";
$language["FL_DELREQ_2"]="inte vill va vän med dig."."\n\n"."Av den orsaken kan du inte längre se";
$language["FL_DELREQ_3"]="i din föfrågningslista längre.";
$language["FL_FRACC_SUBJ"]="Vänförfrågning Accepterad!";
$language["FL_FRACC_MSG"]="har accepterat din vänförfrågan.";
$language["FL_FRCOMMON"]="\n\n"."Du kan se i din vänlista att statusen ändrats.";
$language["FL_CHANGEDMIND"]="vill bli din vän igen"."\n\n"."Gå till din vänlista för att acceptera eller neka";
$language["FL_FRREJ_SUBJ"]="Vänförfrågning Nekad!";
$language["FL_FRREJ_MSG"]="har nekat din förfrågan."."\n\n"."Du kan se i din vänlista att statusen ändrats.";
$language["FL_NOPENFRO"]="Du har inga Skickade förfrågningar just nu!";
$language["FL_NOPENFRI"]="Du har inga mottagna förfrågningar just nu!";
$language["FL_OFFLINE"]="Ej ansluten";
$language["FL_ONLINE"]="Ansluten";
$language["FL_NOFRIENDS"]="Du har inga vänner än!";
$language["FL_NOREJECTS"]="Du har inga nekade eller föredetta vänner just nu!";
$language["FL_FRIENDS"]="Vänner";
$language["FL_THISISU"]="Detta är du!";
$language["FL_HASNOFRIENDS"]="Medlemen har inga vänner än!";

$language["BUMP_THIS_TORR"]="Flytta till toppen";

$language["ARC_NEW"]="Ny";
$language["ARC_ARC"]="Arkiverad";
$language["ARC_UPLOAD_TYPE"]="Uppladdnings Sort ";
$language["ARC_ERR_NO_ARC"]="Du kan inte se detaljer i Arkiv torrents!";
$language["ARC_ERR_NO_NEW"]="Du kan inte se detaljer i Nya torrents!";
$language["ARC_ERR_NO_BOTH"]="Du kan inte se detaljer i Nya elr Arkiv Torrents!";

$language["FLS_FREE_SLOTS"]="Frileech Slots";
$language["FLS_DONATE_INFO_1"]="Få <span style='color:red;'>one</span> Freeleech slot för varje";
$language["FLS_DONATE_INFO_2"]="du donerar.<br />(These can be used to create Custom Free torrents of your own choosing)";
$language["FLS_LOCKED"]="Låst";
$language["FLS_UNLOCKED"]="Öppen";
$language["FLS_CUSTOM_FL"]="Modifierad fri leech";
$language["FLS_ALREADY_HAVE"]="Du har redan denna torrent som modifierad fri leech torrent";
$language["FLS_NONE_REMAINING"]="Du har ingen fri leech slot kvar";
$language["FLS_FREE_BY_OTHER"]="Den torrent är redan fri.";
$language["FLS_PLS_CONFIRM"]="Vänligen Bekräfta åtgärden";
$language["FLS_R_U_SURE1"]="Vill du använda en fri leech slot?<br />Du har";
$language["FLS_R_U_SURE2A"]="fri leech slot kvar.";
$language["FLS_R_U_SURE2B"]="fri leech slots kvar.";
$language["FLS_USED_SLOT1"]="Använt fri leech slot på";
$language["FLS_USED_SLOT2"]="torrent";
$language["FLS_USED_SLOT3"]="Tillbaka till torrents";
$language["TOW_NONE_ATM"]="<b>Ingen MOTW just nu!</b>";
$language["TOW_SEEDS"]="seeds";
$language["TOW_LEECH"]="leechers";
$language["TOW_EXPIRES"]="Avslutas:";
$language["CAPTCHA_ERROR"]="The reCAPTCHA wasn't entered correctly. Go back and try it again." ."(reCAPTCHA said:";
$language["TCOM_AUTOPM_1"]="har gjort en kommentar på din uppladdning";
$language["TCOM_AUTOPM_2"]="Automatiskt system meddelande."."\n"."Vill du inte ha det stäng av funktionen i din profil.";
$language["TCOM_AUTOPM_SUBJ"]="Torrent Kommentar Tillagd";
$language["TCOM_COMMENTPM"]="Kommentar Notis";
$language["ERR_NAME_BANNED"]="Användarnamnet förbjudet";
$language["NO_POLLS"]="<b>Ingen Omröstning Just Nu!</b>";
$language["TOTAL_VOTES"]="Totala Röster";
$language["DISCUSS_POLL"]="Diskutera/Rösta I denna omröstning";
$language["BONUS_INFO13"]="Du kommer få extra";
$language["BONUS_INFO14"]="peer timme du seedar arkiv torrents.";
$language["FLS_BONUS_GET"]="Få 1 Frileech slot";
$language["FLS_NOT_ENOUGH"]="Du har inte nog med poäng för att få en Frileech slot!";
$language["TVDB_EP_NAME"]="Avsnitts Namn";
$language["TVDB_GUESTS"]="Gäst stjärnor";
$language["TVDB_AIRED"]="Sänt";
$language["TVDB_NETWORK"]="Bolag";
$language["TVDB_SHOW_AIRS"]="Serien sänds";
$language["TVDB_AIRS_1"]="vid";
$language["TVDB_AIRS_2"]="i";
$language["TVDB_AIRS_3"]="minuter";
$language["TVDB_NO_OVERVIEW"]="[Ingen info för avsnitt]";
$language["TVDB_UL_TITLE"]="Seriens ID på TVDB";
$language["TVDB_UL_1"]="(Tillval)";
$language["TVDB_UL_2"]="Nummret efter <span style='color:lime;font-weight:bold;'>&id=</span>, ex för <a href='http://thetvdb.com/?tab=series&id=79349' target='_blank'>Dexter</a> (http://thetvdb.com/?tab=series&id=<span style='color:lime;font-weight:bold;'>79349</span>).";
$language["SYSTEM_USER"]="System";
$language["PRUNE_WARN_SUBJ"]="Varning Konto inaktivitet";
$language["PRUNE_WARN_SUBJ2"]="Kontot Avslutat";
$language["PREUS_PKA"]="<span style='color:lime;'>Tidigare känd som:</span>";
$language["PREUS_PUN"]="Tidigare nick?";
$language["IBD_NEED_TO_INTRODUCE_1"]="För att kunna ladda ner från denna sida måste du först";
$language["IBD_NEED_TO_INTRODUCE_2A"]="skapa en ny";
$language["IBD_NEED_TO_INTRODUCE_2B"]="lägg till i";
$language["IBD_NEED_TO_INTRODUCE_3"]="Introduktions post.<br /><br />Du kan göra detta";
$language["MAGNET_DOWN_USING"]="Ladda ner via magnetlänk";
$language["PFET_NO_UPLOAD_1"]="Din klass (";
$language["PFET_NO_UPLOAD_2"]=") kan inte ladda upp externa torrenter på denna sida.";
$language["ETH_START_DATE"]="Startad";
$language["ETH_COMP_DATE"]="Färdig";
$language["ETH_LAST_ACTION"]="Senast aktiv";

###Translators own things you can remove this
$language["DIV_MENU"]='Nöje';
$language["MNU_DONATE"]='Donera';
$language["PCHECK"]='Port Kontroll';
$language["ALL2"]='Alla Torrents';
$language["ARC2"]='Arkiv';
$language['CL_BAN_HEAD']="Banna Klient";
$language["IRC_SETTINGS"]="Irc Konfig";
$language["SETTING_IRC_SERVER"]="Irc Server (utan irc://)";
$language["SETTING_IRC_PORT"]="Irc Port";
$language["SETTING_IRC_CHANNEL"]="Irc Kanal (utan #)";
$language["MNU_IRC"]="Irc";
$language['VIDEO_URL'] = 'Video Url (http://site.com/film.mp4)';
$language['VIDEO_TITLE'] = 'Image Title (http://site.com/pic.jpg)';
$language['VIDEO_TYPE']='Choose Version';
$language['VIDEO_TYPE_1']='Jquery Version';
$language['VIDEO_TYPE_2']='Quicktime Version';
$language["RSS_MY_PERS_FEED"] = "Personlig RSS";
$language["MOV"]='Film';
$language["MUS"]='Musik';
$language["MIX"]='Övriga';
$language["TEVE"]='TV';
?>