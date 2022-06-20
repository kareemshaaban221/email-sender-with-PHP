<?php

$redirectUri = 'http://localhost/mailsender/get_auth_token.php';
$clientId = 'secret';
$clientSecret = 'secret';

require_once __DIR__ . '/vendor/phpmailer/phpmailer/get_oauth_token.php';
