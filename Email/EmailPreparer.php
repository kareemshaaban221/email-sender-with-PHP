<?php

namespace App\Email;

use BadMethodCallException;
use Exception;
use League\OAuth2\Client\Provider\Google;
use PHPMailer\PHPMailer\OAuth;
use PHPMailer\PHPMailer\PHPMailer;

class EmailPreparer {
    private $mail;
    private array $credentials;

    public function __construct(array $credentials) {
        $this->mail = new PHPMailer();
        if(!$this->setCredentials($credentials)) {
            throw new BadMethodCallException('Wrong Credentials!');
        }
    }

    public function prepare(string $senderEmail, string $senderName) {
        $this->mail->SMTPDebug  = 2;  // log the errors                                     
        $this->mail->isSMTP();                                          
        $this->mail->Host       = 'smtp.gmail.com;';                    
        $this->mail->SMTPAuth   = true;                   
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;                 
        $this->mail->Port       = 465;
        $this->mail->AuthType   = 'XOAUTH2';      // tell the mailer that we use Oauth 2.0 google protocol

        $this->from($senderEmail, $senderName);

        return $this->mail;
    }

    private function setCredentials(array $credentials) {
        if (isset($credentials['clientId']) && isset($credentials['clientSecret']) && isset($credentials['refreshToken'])) {
            $this->credentials = $credentials;
            return true;
        } else return false;
    }

    private function getProvider(string $provider) {
        if($provider === 'Google' || $provider === 'google') {
            return new Google([
                'clientId' => $this->credentials['clientId'],
                'clientSecret' => $this->credentials['clientSecret']
            ]);
        } else throw new Exception('Not Found Provider!');
    }

    private function from(string $senderEmail, string $senderName = '') {
        $this->mail->setOAuth(
            new OAuth(
                [
                    'provider' => $this->getProvider('google'),
                    'clientId' => $this->credentials['clientId'],
                    'clientSecret' => $this->credentials['clientSecret'],
                    'refreshToken' => $this->credentials['refreshToken'],
                    'userName' => $senderEmail
                ]
            )
        );

        return $this->mail->setFrom($senderEmail, $senderName);
    }
}