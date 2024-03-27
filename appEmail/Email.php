<?php

namespace GabrielBinottiEmail;

use GabrielBinottiEmail\AbstractEmail;
use PHPMailer\PHPMailer\PHPMailer;


class Email extends AbstractEmail
{
    use TraitEmail;

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

        if (!empty($replace)) {

            $template = file_get_contents(dirname(__FILE__) . "/template/{$templateName}");
            $template = $this->replace($template, $replace);
            $this->mail->msgHTML($template);
        } else {
            $this->mail->msgHTML(file_get_contents(dirname(__FILE__) . "/template/{$templateName}"));
        }
        return $this;
    }

    private function replace($templateName, $replace)
    {
        foreach ($replace as $key => $value) {

            $templateName = str_replace(
                $value['before'],
                $value['after'],
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

    public function options($array)
    {
        $this->mail->SMTPOptions = $array;
        return $this;
    }

    public function send()
    {
        $this->mail->send();
    }
}
