# Example using PHP-Mailer to send email in PHP

## Require
* PHP >= 7.0
* Composer installed
* A server mail

## Install 
You can install this class using the line-command
```php
composer require gabriel-binotti/email
```

## Step 0
You need config the file email.ini in <b>vendor/appEmail/config/email.ini</b>
```php
host = nameserve
username = user
password = password
auth = 'true' or 'false'
port = 587 or 465
charset = 'UTF-8'
secure = 'false' or 'true'
```

After you can to use that class by examples above.

<b>index.php</b>

```php
use GabrielBinottiEmail\Email;

require_once "vendor/autoload.php";

try {

    Email::email('email')                       // name file .ini
        ->debug()                               // active show debug (server, client or off "default is off")
        ->from("email", "name")                 // sender's email , name (Can your name or you company...)
        ->reply("email", "name ")               // answer email (optional)
        ->destination("email", 'name')          // recipient email , name
        ->subject("subject email")              // subject email
        ->bodyHtml('text body')                 // text body
        ->options([
            "ssl" => [
                'verify_peer'       => false,   
                'verify_peer_name'  => false,   
                'allow_self_signed' => true    
            ]
        ])
        ->send();                               // send email
        
} catch (Exception $e) {
    echo $e->getMessage();
}
```

options() is configured based in your server if they have SSL or not.

You can to use template HTML in body email, change <b> bodyHtml()</b> to <b>template()</b>
```php        
    template('template.html');                    
```
The template you create in <b>vendor/appEmail/template/</b>, by default the second parameter ir an array empty, but you can 
send an array to replace.
```php
$arrayReplace = [
    [
        "before" => "value",
        "after" => "value",
    ],
    [
        "before" => "value",
        "after" => "value",
    ]
];

 template('template.html', $arrayReplace);
```

