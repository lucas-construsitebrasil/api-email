<?php

use Webklex\PHPIMAP\Client;
use Webklex\PHPIMAP\ClientManager;

$cm = new ClientManager($options = []);

$client = $cm->make([
    'host' => 'outlook.office365.com',
    'port' => '993',
    'encryption' => 'TLS',
    'validade_cert' => true,
    'username' => 'caio.magalhaes@construsitebrasil.com.br',
    'password' => '01052003Cc@',
    'protocol' => 'imap'
]);

$client->connect();

$folders = $client->getFolders();
foreach($folders as $folder) {
    $messages = $folder->messages()->all()->get();
    echo $messages;
}









?>
