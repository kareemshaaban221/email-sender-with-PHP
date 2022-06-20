<?php

require_once __DIR__ . '/vendor/autoload.php';

use PHPMailer\PHPMailer\Exception;

extract($_POST);

session_start();

validate($_POST);
  
try {
    $credentials = [
        'clientId' => 'secret',
        'clientSecret' => 'secret',
        'refreshToken' => 'secret'
    ];

    $preparer = new App\Email\EmailPreparer($credentials);

    $mail = $preparer->prepare('phptest221@gmail.com', 'PHP AI');

    $mail->addAddress($to);
       
    $mail->isHTML(true);                                  
    $mail->Subject = $subject;
    $mail->Body    = $msg;
    $mail->AltBody = "ERROR";

    $mail->send();

    $_SESSION['done'] = true;
} catch (Exception $e) {
    $_SESSION['done'] = false;
    // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
} finally {
    header('location: http://localhost/mailsender');
}

//! Before google removing less secure app option

// $mail = new PHPMailer();

// $mail->From = 'krkr.egj5@gmail.com';
// $mail->FromName = 'test test test';

// $mail->addAddress("kareemshaaban221@gmail.com", "Kareem");

// $mail->addReplyTo("krkr.egj5@gmail.com", "Reply");

// $mail->isHTML(true);

// $mail->Subject = 'test';
// $mail->Body = '<h1 style="color: red">Hello World</h1>';
// $mail->AltBody = 'Lol';

// // $mail->addCC('krkr.egj5@gmail.com');
// // $mail->addBCC('kareemshaaban221@gmail.com');

// try {
//     $mail->send();
//     echo "Message has been sent successfully";
// } catch (Exception $e) {
//     echo "Mailer Error: " . $mail->ErrorInfo;
// }

// $headers = "From: phptest221@gmail.com";

// if(mail($to, $subject, $msg, $headers)) {
//     $_SESSION['done'] = true;
//     header('location: http://locahost/mailsender');
// } else {
//     echo 'lol'; die;
//     $_SESSION['done'] = false;
//     header('location: http://localhost/mailsender');
// }


function validate(array $data) {
    if(!$data['msg'] || !$data['to'] || !$data['subject']) {
        $_SESSION['error'] = true;
        header('location: http://localhost/mailsender');
        exit;
    }
}
