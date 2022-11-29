<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Webklex\PHPIMAP\Client;
use Webklex\PHPIMAP\ClientManager;
use Illuminate\Http\Request;

class UserEmailController extends Controller
{
    private $client;

    public function __construct($username, $password){
        $client = (new ClientManager($options = []))->make([
            'host' => 'mail.construsitebrasil.com.br',
            'port' => '993',
            'encryption' => 'TLS',
            'validade_cert' => true,
            'username' => $username,
            'password' => $password,
            'protocol' => 'imap'
        ]);
        if ($client->connect()){
            $this->client = $client;
        } else {
            return response()->json('Não foi possível conectar, verifique as credenciais');
        }
    }

    public function getClient(){
        return $this->client;
    }
}