<?php
/////////////////////////////////////////////////////////////////////////////////////
// xbtit - Bittorrent tracker/frontend
//
// Copyright (C) 2004 - 2019  xbtitFM Team
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
$language['ACCOUNT_CREATED']='Account Created';
$language['USER_NAME']='User';
$language['USER_PWD_AGAIN']='Repeat password';
$language['USER_PWD']='Password';
$language['USER_STYLE']='Style';
$language['USER_LANGUE']='Language';
$language['IMAGE_CODE']='Image Code';
$language['INSERT_USERNAME']='You must insert a username!';
$language['INSERT_PASSWORD']='You must insert a password!';
$language['DIF_PASSWORDS']='The passwords don&rsquo;t match!';
$language['ERR_NO_EMAIL']='You must enter a valid email address';
$language['USER_EMAIL_AGAIN']='Repeat email';
$language['ERR_NO_EMAIL_AGAIN']='Repeat email';
$language['DIF_EMAIL']='The emails don&rsquo;t match!';
$language['SECURITY_CODE']='Answer the question';
# Password strength
$language['WEEK']='Weak';
$language['MEDIUM']='Medium';
$language['SAFE']='Safe';
$language['STRONG']='Strong';
$language["ERR_GENERIC"]='Generic Error: '.mysqli_error($GLOBALS['conn']);
//INVITATION SYSTEM
global $SITENAME, $BASEURL, $SITEEMAIL;
$language['INVIT_MSGINFO']='You have requested a new account on '.$SITENAME;
$language['INVIT_MSGINFO1']="\n\n".'Your account is awaiting confirmation from the member who invited you. Until your account is confirmed you won\'t have full access to the site.';
$language['INVIT_MSGINFO2A']="\n\n".'Account info:'."\n".'Username:';
$language['INVIT_MSGINFO2B']='Password:';
$language["INVIT_MSGINFO3"]="\n\n".'----------------'."\n\n".'If you did not register for '.$SITENAME.', please forward this email to '.$SITEEMAIL;
$language['INVIT_MSG_AUTOCONFIRM3']="\n\n".'----------------'."\n\n".'You can now visit'."\n\n".$BASEURL.'/index.php?page=login'.
									"\n\n".'and use your login information to log in.'."\n\n".
									'Good luck and have fun on '.$SITENAME.'!'."\n\n\n".'----------------'."\n\n".
									'If you did not register for '.$SITENAME.', please forward this email to '.$SITEEMAIL;
$language['REG_CONFIRM']='Account Confirmation';
$language['INVITATION_ONLY']='Sorry, but registrations are closed.<br>You need an invitation in order to signup.';
$language['WELCOME_INVITE']='Welcome! You have accepted an invitation from one of our users.<br />You may now sign-up.';
$language['INVITE_EMAIL_SENT1']='A confirmation e-mail has been sent to the address you specified';
$language['INVITE_EMAIL_SENT2']='<br />You will need to wait until your inviter confirms your account.';
$language['INVITE_EMAIL_SENT3']='An e-mail has been sent to the address you specified';
$language['INVITE_EMAIL_SENT4']='<br />You may now <a href="index.php?page=login">LOGIN</a>. Good luck and have fun on '.$SITENAME.'!';
$language['INVALID_INVITATION']='Your invitation code is invalid.';
$language['ERR_INVITATION']='<br />Request a new invitation from your inviter.';

$language["DOMAIN_BANNED"]="No disposable E-Mail Accounts allowed. Use a real E-Mail Account.";

$language["UN_INV_ACC_1"] = "Invitation from";
$language["UN_INV_ACC_2"] = "accepted and account created";

$language["RREG_CLOSED_1"] = "Registrations are currently closed and will reopen at random intervals, please try later.";
$language["RREG_CLOSED_2"] = "If you have an invitation you can bypass this by following the link in the email.";
$language["ERR_IP_ALREADY_EXISTS_1"] = "Your IP Address";
$language["ERR_IP_ALREADY_EXISTS_2"] = "is already in use on this site.<br /><br />If you use a shared IP please contact the site administrator.";
$language["OASED_ERR_MSG_1"] = "The email address you entered is invalid. We only accept emails from the following";
$language["OASED_ERR_MSG_2"] = "domain";
$language["OASED_ERR_MSG_3"] = "domains";
$language["CSIGN_ERR"]="You are not permitted to create an account on this tracker!"; // Probably best to keep the error message vague. ;)

?>