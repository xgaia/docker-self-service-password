<?php
#==============================================================================
# LTB Self Service Password
#
# Copyright (C) 2009 Clement OUDOT
# Copyright (C) 2009 LTB-project.org
#
# This program is free software; you can redistribute it and/or
# modify it under the terms of the GNU General Public License
# as published by the Free Software Foundation; either version 2
# of the License, or (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# GPL License: http://www.gnu.org/licenses/gpl.txt
#
#==============================================================================

#==============================================================================
# All the default values are kept here, you should not modify it but use
# config.inc.local.php file instead to override the settings from here.
#==============================================================================

#==============================================================================
# Configuration
#==============================================================================

# Debug mode
# true: log and display any errors or warnings (use this in configuration/testing)
# false: log only errors and do not display them (use this in production)
$debug = false;

# LDAP
$ldap_url = getenv('LDAP_URL') ?: 'ldap://localhost';
$ldap_starttls = false;
$ldap_binddn = getenv('LDAP_BINDDN') ?: "cn=manager,dc=example,dc=com";
$ldap_bindpw = getenv('LDAP_BINDPW') ?: "secret";
$ldap_base = getenv('LDAP_BASE') ?: "dc=example,dc=com";
$ldap_login_attribute = getenv('LDAP_LOGIN_ATTRIBUTE') ?: "uid";
$ldap_fullname_attribute = getenv('LDAP_FULLNAME_ATTRIBUTE') ?: "cn";
$ldap_filter = getenv('LDAP_FILTER') ?: "(&(objectClass=person)($ldap_login_attribute={login}))";

# Active Directory mode
# true: use unicodePwd as password field
# false: LDAPv3 standard behavior
$ad_mode = getenv('AD_MODE') === "true" ?: false;
# Force account unlock when password is changed
$ad_options['force_unlock'] = getenv('AD_OPTIONS_FORCE_UNLOCK') === "true" ?: false;
# Force user change password at next login
$ad_options['force_pwd_change'] = getenv('AD_OPTIONS_FORCE_PWD_CHANGE') === "true" ?: false;
# Allow user with expired password to change password
$ad_options['change_expired_password'] = getenv('AD_OPTIONS_CHANGE_EXPIRED_PASSWORD') === "true" ?: false;

# Samba mode
# true: update sambaNTpassword and sambaPwdLastSet attributes too
# false: just update the password
$samba_mode = getenv('SAMBA_MODE') === "true" ?: false;
# Set password min/max age in Samba attributes
#$samba_options['min_age'] = 5;
#$samba_options['max_age'] = 45;

# Shadow options - require shadowAccount objectClass
# Update shadowLastChange
$shadow_options['update_shadowLastChange'] = getenv('SHADOW_OPTIONS_UPDATE_SHADOWLASTCHANGE') === "true" ?: false;
$shadow_options['update_shadowExpire'] = getenv('SHADOW_OPTIONS_UPDATE_SHADOWEXPIRE') === "true" ?: false;

# Default to -1, never expire
$shadow_options['shadow_expire_days'] = intval(getenv('SHADOW_OPTIONS_SHADOW_EXPIRE_DAYS')) ?: -1;

# Hash mechanism for password:
# SSHA, SSHA256, SSHA384, SSHA512
# SHA, SHA256, SHA384, SHA512
# SMD5
# MD5
# CRYPT
# clear (the default)
# auto (will check the hash of current password)
# This option is not used with ad_mode = true
$hash = getenv('HASH') ?: "clear";

# Prefix to use for salt with CRYPT
$hash_options['crypt_salt_prefix'] = getenv('HASH_OPTIONS_CRYPT_SALT_PREFIX') ?: "$6$";
$hash_options['crypt_salt_length'] = getenv('HASH_OPTIONS_CRYPT_SALT_LENGTH') ?: "6";

# Local password policy
# This is applied before directory password policy
# Minimal length
$pwd_min_length =intval(getenv('PWD_MIN_LENGTH')) ?: 0;
# Maximal length
$pwd_max_length =intval(getenv('PWD_MAX_LENGTH')) ?: 0;
# Minimal lower characters
$pwd_min_lower =intval(getenv('MINIMAL')) ?: 0;
# Minimal upper characters
$pwd_min_upper =intval(getenv('PWD_MIN_UPPER')) ?: 0;
# Minimal digit characters
$pwd_min_digit =intval(getenv('PWD_MIN_DIGIT')) ?: 0;
# Minimal special characters
$pwd_min_special =intval(getenv('PWD_MIN_SPECIAL')) ?: 0;
# Definition of special characters
$pwd_special_chars = getenv('PWD_SPECIAL_CHARS') ?: "^a-zA-Z0-9";
# Forbidden characters
#$pwd_forbidden_chars = "@%";
# Don't reuse the same password as currently
$pwd_no_reuse =getenv('PWD_NO_REUSE') === "true" ?: true;
# Check that password is different than login
$pwd_diff_login =getenv('PWD_DIFF_LOGIN') === "true" ?: true;
# Complexity: number of different class of character required
$pwd_complexity =intval(getenv('PWD_COMPLEXITY')) ?: 0;
# use pwnedpasswords api v2 to securely check if the password has been on a leak
$use_pwnedpasswords =getenv('USE_PWNEDPASSWORDS') === "true" ?: false;
# Show policy constraints message:
# always
# never
# onerror
$pwd_show_policy = getenv('PWD_SHOW_POLICY') ?: "never";
# Position of password policy constraints message:
# above - the form
# below - the form
$pwd_show_policy_pos = getenv('PWD_SHOW_POLICY_POS') ?: "above";

# Who changes the password?
# Also applicable for question/answer save
# user: the user itself
# manager: the above binddn
$who_change_password = getenv('WHO_CHANGE_PASSWORD') ?: "user";

## Standard change
# Use standard change form?
$use_change = getenv('USE_CHANGE') === "true" ?: true;

## SSH Key Change
# Allow changing of sshPublicKey?
$change_sshkey = getenv('CHANGE_SSHKEY') === "true" ?: false;

# What attribute should be changed by the changesshkey action?
$change_sshkey_attribute = getenv('CHANGE_SSHKEY_ATTRIBUTE') ?: "sshPublicKey";

# Who changes the sshPublicKey attribute?
# Also applicable for question/answer save
# user: the user itself
# manager: the above binddn
$who_change_sshkey = getenv('WHO_CHANGE_SSHKEY') ?: "user";

# Notify users anytime their sshPublicKey is changed
## Requires mail configuration below
$notify_on_sshkey_change = getenv('NOTIFY_ON_SSHKEY_CHANGE') === "true" ?: false;

## Questions/answers
# Use questions/answers?
# true (default)
# false
$use_questions = getenv('USE_QUESTIONS') === "true" ?: true;

# Answer attribute should be hidden to users!
$answer_objectClass = getenv('ANSWER_OBJECTCLASS') ?: "extensibleObject";
$answer_attribute = getenv('ANSWER_ATTRIBUTE') ?: "info";

# Crypt answers inside the directory
$crypt_answers = getenv('CRYPT_ANSWERS') === "true" ?: true;

# Extra questions (built-in questions are in lang/$lang.inc.php)
#$messages['questions']['ice'] = "What is your favorite ice cream flavor?";

## Token
# Use tokens?
# true (default)
# false
$use_tokens = getenv('USE_TOKENS') === "true" ?: true;
# Crypt tokens?
# true (default)
# false
$crypt_tokens = getenv('CRYPT_TOKENS') === "true" ?: true;
# Token lifetime in seconds
$token_lifetime = getenv('TOKEN_LIFETIME') ?: "3600";

## Mail
# LDAP mail attribute
$mail_attribute = getenv('MAIL_ATTRIBUTE') ?: "mail";
# Get mail address directly from LDAP (only first mail entry)
# and hide mail input field
# default = false
$mail_address_use_ldap = getenv('MAIL_ADDRESS_USE_LDAP') === "true" ?: false;
# Who the email should come from
$mail_from = getenv('MAIL_FROM') ?: "admin@example.com";
$mail_from_name = getenv('MAIL_FROM_NAME') ?: "Self Service Password";
$mail_signature = getenv('MAIL_SIGNATURE') ?: "";
# Notify users anytime their password is changed
$notify_on_change = getenv('NOTIFY_ON_CHANGE') === "true" ?: false;
# PHPMailer configuration (see https://github.com/PHPMailer/PHPMailer)
$mail_sendmailpath = getenv('MAIL_SENDMAILPATH') ?: '/usr/sbin/sendmail';
$mail_protocol = getenv('MAIL_PROTOCOL') ?: 'smtp';
$mail_smtp_debug = intval(getenv('MAIL_SMTP_DEBUG')) ?: 0;
$mail_debug_format = getenv('MAIL_DEBUG_FORMAT') ?: 'error_log';
$mail_smtp_host = getenv('MAIL_SMTP_HOST') ?: 'localhost';
$mail_smtp_auth = getenv('MAIL_SMTP_AUTH') === "true" ?: false;
$mail_smtp_user = getenv('MAIL_SMTP_USER') ?: '';
$mail_smtp_pass = getenv('MAIL_SMTP_PASS') ?: '';
$mail_smtp_port = intval(getenv('MAIL_SMTP_PORT')) ?: 25;
$mail_smtp_timeout = intval(getenv('MAIL_SMTP_TIMEOUT')) ?: 30;
$mail_smtp_keepalive = getenv('MAIL_SMTP_KEEPALIVE') === "true" ?: false;
$mail_smtp_secure =getenv('MAIL_SMTP_SECURE') ?: 'tls';
$mail_smtp_autotls = getenv('MAIL_SMTP_AUTOTLS') === "true" ?: true;
$mail_contenttype =getenv('MAIL_CONTENTTYPE') ?: 'text/plain';
$mail_wordwrap = intval(getenv('MAIL_WORDWRAP')) ?: 0;
$mail_charset =getenv('MAIL_CHARSET') ?: 'utf-8';
$mail_priority = intval(getenv('MAIL_PRIORITY')) ?: 3;
$mail_newline = PHP_EOL;

## SMS
# Use sms
$use_sms = getenv('USE_SMS') === "true" ?: true;
# SMS method (mail, api)
$sms_method = getenv('SMS_METHOD') ?: "mail";
$sms_api_lib = getenv('SMS_API_LIB') ?: "lib/smsapi.inc.php";
# GSM number attribute
$sms_attribute = getenv('SMS_ATTRIBUTE') ?: "mobile";
# Partially hide number
$sms_partially_hide_number = getenv('SMS_PARTIALLY_HIDE_NUMBER') === "true" ?: true;
# Send SMS mail to address
$smsmailto = getenv('SMSMAILTO') ?: "{sms_attribute}@service.provider.com";
# Subject when sending email to SMTP to SMS provider
$smsmail_subject = getenv('SMSMAIL_SUBJECT') ?: "Provider code";
# Message
$sms_message = getenv('SMS_MESSAGE') ?: "{smsresetmessage} {smstoken}";
# Remove non digit characters from GSM number
$sms_sanitize_number = getenv('SMS_SANITIZE_NUMBER') === "true" ?: false;
# Truncate GSM number
$sms_truncate_number = getenv('SMS_TRUNCATE_NUMBER') === "true" ?: false;
$sms_truncate_number_length = intval(getenv('SMS_TRUNCATE_NUMBER_LENGTH')) ?: 10;
# SMS token length
$sms_token_length = intval(getenv('SMS_TOKEN_LENGTH')) ?: 6;
# Max attempts allowed for SMS token
$max_attempts = intval(getenv('MAX_ATTEMPTS')) ?: 3;

# Encryption, decryption keyphrase, required if $crypt_tokens = true
# Please change it to anything long, random and complicated, you do not have to remember it
# Changing it will also invalidate all previous tokens and SMS codes
$keyphrase = getenv('KEYPHRASE') ?: "secret";

# Reset URL (if behind a reverse proxy)
#$reset_url = $_SERVER['HTTP_X_FORWARDED_PROTO'] . "://" . $_SERVER['HTTP_X_FORWARDED_HOST'] . $_SERVER['SCRIPT_NAME'];

# Display help messages
$show_help = getenv('SHOW_HELP') === "true" ?: true;

# Default language
$lang = getenv('LANG') ?: "en";

# List of authorized languages. If empty, all language are allowed.
# If not empty and the user's browser language setting is not in that list, language from $lang will be used.
$allowed_lang = array();

# Display menu on top
$show_menu = getenv('SHOW_MENU') === "true" ?: true; getenv('HASH_OPTIONS_CRYPT_SALT_PREFIX') ?:

# Logo
if (getenv('LOGO') != "false") {
    $logo = getenv('LOGO') ?: "images/ltb-logo.png";
}

# Background image
if (getenv('BACKGROUND_IMAGE') != "false") {
    $background_image = getenv('BACKGROUND_IMAGE') ?: "images/unsplash-space.jpeg";
}
# Where to log password resets - Make sure apache has write permission
# By default, they are logged in Apache log
#$reset_request_log = "/var/log/self-service-password";

# Invalid characters in login
# Set at least "*()&|" to prevent LDAP injection
# If empty, only alphanumeric characters are accepted
$login_forbidden_chars = getenv('LOGIN_FORBIDDEN_CHARS') ?: "*()&|";

## CAPTCHA
# Use Google reCAPTCHA (http://www.google.com/recaptcha)
$use_recaptcha = getenv('USE_RECAPTCHA') === "true" ?: false;
# Go on the site to get public and private key
$recaptcha_publickey = getenv('RECAPTCHA_PUBLICKEY') ?: "";
$recaptcha_privatekey = getenv('RECAPTCHA_PRIVATEKEY') ?: "";
# Customization (see https://developers.google.com/recaptcha/docs/display)
$recaptcha_theme = getenv('RECAPTCHA_THEME') ?: "light";
$recaptcha_type = getenv('RECAPTCHA_TYPE') ?: "image";
$recaptcha_size = getenv('RECAPTCHA_SIZE') ?: "normal";
# reCAPTCHA request method, null for default, Fully Qualified Class Name to override
# Useful when allow_url_fopen=0 ex. $recaptcha_request_method = '\ReCaptcha\RequestMethod\CurlPost';
$recaptcha_request_method = null;

## Default action
# change
# sendtoken
# sendsms
$default_action = getenv('DEFAULT_ACTION') ?: "change";

## Extra messages
# They can also be defined in lang/ files
#$messages['passwordchangedextramessage'] = NULL;
#$messages['changehelpextramessage'] = NULL;

# Launch a posthook script after successful password change
#$posthook = "/usr/share/self-service-password/posthook.sh";
#$display_posthook_error = true;

# Hide some messages to not disclose sensitive information
# These messages will be replaced by badcredentials error
#$obscure_failure_messages = array("mailnomatch");

# Allow to override current settings with local configuration
if (file_exists (__DIR__ . '/config.inc.local.php')) {
    require __DIR__ . '/config.inc.local.php';
}
