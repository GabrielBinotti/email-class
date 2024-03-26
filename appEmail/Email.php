<?php

namespace GabrielBinottiEmail;

use GabrielBinottiEmail\AbstractEmail;
use Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class Email extends AbstractEmail
{

    private $mail;
    private $file;
    private static $emailObj;

    private function __construct($fileName)
    {
        $this->mail = new PHPMailer;
        $this->setConfig($fileName);
        $this->mail->isSMTP();
        $this->mail->Host           = $this->file->host;
        $this->mail->Port           = $this->file->port;
        $this->mail->SMTPSecure     = $this->file->secure;
        $this->mail->SMTPAuth       = $this->file->auth;
        $this->mail->Username       = $this->file->username;
        $this->mail->Password       = $this->file->password;
        $this->mail->CharSet        = $this->file->charset;
    }

    public static function email($fileName)
    {
        self::$emailObj = new Email($fileName);
        return self::$emailObj;
    }

    protected function setConfig($fileName)
    {
        $path = dirname(__FILE__) . "/config/";

        if (!file_exists($path . $fileName . ".ini")) {
            throw new Exception("O arquivo de configuração de email .ini não exite!");
        }

        $this->file = (object) parse_ini_file(
            $path . $fileName . ".ini");
    }

    public function debug($type = 'off')
    {
        switch ($type) {
            case 'server':
                $this->mail->SMTPDebug = SMTP::DEBUG_SERVER;
                break;
            case 'client':
                $this->mail->SMTPDebug = SMTP::DEBUG_CLIENT;
                break;
            case 'off':
                $this->mail->SMTPDebug = SMTP::DEBUG_OFF;
                break;
        }
        return $this;
    }

    public function from($email, $name)
    {
        $this->mail->setFrom($email, $name);
        return $this;
    }

    public function destination($emailTo, $name)
    {
        $this->mail->addAddress($emailTo, $name);
        return $this;
    }

    public function reply($email, $name)
    {
        $this->mail->addReplyTo($email, $name);
        return $this;
    }

    public function subject($subject)
    {
        $this->mail->Subject = $subject;
        return $this;
    }

    public function bodyHtml($body)
    {
        $this->mail->isHTML(true);
        $this->mail->Body = $body;
        return $this;
    }

    public function template($templateName, $replace = [])
    {

        if(!empty($replace)){
            
        }else{
            $this->mail->msgHTML(file_get_contents(dirname(__FILE__) . "/template/{$templateName}"));
        }
        return $this;
    }

    private function replace($templateName, $replace)
    {
        foreach ($replace as $key => $value) {

            $templateName = str_replace(
                $replace[$key]->valueBefore,
                $replace[$key]->valueAfter,
                $templateName
            );
        }

        return $templateName;
    }

    public function addFile($file, $fileName)
    {
        $this->mail->addAttachment(dirname(__FILE__) . "/files/{$file}", $fileName);
        return $this;
    }

    public function addImage($image, $cid)
    {

        $path = dirname(__FILE__) . "/images/{$image}";
        $this->mail->addEmbeddedImage($path, $cid);
        return $this;
    }

    public function send()
    {
        $this->mail->send();
    }

    public function options($array)
    {
        $this->mail->SMTPOptions = $array;
        return $this;
    }
}
