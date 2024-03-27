<?php

namespace GabrielBinottiEmail;

use Exception;
use PHPMailer\PHPMailer\SMTP;

trait TraitEmail
{
    public function setConfig($fileName)
    {
        $path = dirname(__FILE__) . "/config/";

        if (!file_exists($path . $fileName . ".ini")) {
            throw new Exception("O arquivo de configuração de email .ini não exite!");
        }

        $this->file = (object) parse_ini_file(
            $path . $fileName . ".ini"
        );
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
}