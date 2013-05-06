<?php

namespace core\util;

use core\system\ClassLoader;
use core\system\URL;

/**
 * Perform mail send/receive actions.
 * @author anza
 * @version 11-06-2011
 */
class Mailer
{
    // this is dirty version and must be improved!
    // NB! SERVER MUST HAVE THE BELOW LINE IN php.ini file:
    // extension=php_openssl.dll
    public static function send($email, $subject, $message)
    {
        ClassLoader::addPath('lib/phpmailer');
        
        $mail = new \PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch
        $mail->IsSMTP(); // telling the class to use SMTP
        try
        {
            $mail->SMTPAuth   = true;                  // enable SMTP authentication
            $mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
            $mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
            $mail->Port       = 465;                   // set the SMTP port for the GMAIL server
            $mail->Username   = "your_gmail_account";  // GMAIL username
            $mail->Password   = "your_gmail_password";            // GMAIL password
            $mail->AddReplyTo('name@yourdomain.com', '');
            $mail->AddAddress($email, '');
            $mail->SetFrom('from_account', '');
            $mail->AddReplyTo('reply_account', '');
            $mail->Subject = $subject;
            $mail->AltBody = ''; // optional - MsgHTML will create an alternate automatically
            $mail->MsgHTML($message);
            $mail->Send();
        }
        catch (phpmailerException $e)
        {
            $e->errorMessage(); //Pretty error messages from PHPMailer
        }
        catch (Exception $e)
        {
            $e->getMessage(); //Boring error messages from anything else!
        }
    }
}

?>