<?php

use GabrielBinottiEmail\Email;

require_once "vendor/autoload.php";

try {

    Email::email('email')
        ->debug('server')
        ->from("cobranca@netwave.com.br", "netwave teção")
        ->reply("gabriel.binotti1992@gmail.com", "Gabriel ")
        ->destination("desenvolvimentonetwave@gmail.com", 'Gabriel')
        ->subject("Aqui esta atenção tes de email")
        ->template('temp.html')
        ->addImage("teste.jpeg", "teste")
        ->options([
            "ssl" => [
                'verify_peer'       => false,
                'verify_peer_name'  => false,
                'allow_self_signed' => true
            ]
        ])
        ->send();
} catch (Exception $e) {
    echo $e->getMessage();
}
