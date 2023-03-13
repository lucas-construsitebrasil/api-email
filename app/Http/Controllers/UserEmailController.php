<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Webklex\PHPIMAP\Client;
use Webklex\PHPIMAP\ClientManager;
use Illuminate\Http\Request;

class UserEmailController extends Controller
{
    private $client;

    public function __construct(){
        $client = (new ClientManager($options = []))->make([
            'host' => 'mail.construsitebrasil.com.br',
            'port' => '993',
            'encryption' => 'TLS',
            'validade_cert' => true,
            'username' => $this->username,
            'password' => $this->password,
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

    private $username = 'squad.verde@construsitebrasil.com.br';
    private $password = '~glLGfFG+Noj(Z[rO1';
}
