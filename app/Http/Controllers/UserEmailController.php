<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Webklex\PHPIMAP\Client;
use Webklex\PHPIMAP\ClientManager;
use Illuminate\Http\Request;

class UserEmailController extends Controller
{
    private $client;

    /* Isso deveria ser uma BUSINESS, apenas as informações que o usuário teria controlle estariam aqui. 
       CONTROLLER são unicamente para controlar as informações que serão enviadas para o usuário.
       Como isso tem total relação com a regra de negócio da aplicação (Conectar com o Servidor De E-mail)
       Deveria estar na BUSINESS.   
    */
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
            // Não está retornando código de erro, o correto nesse caso é o ABORT.
            return response()->json('Não foi possível conectar, verifique as credenciais');
        }
    }

    public function getClient(){
        return $this->client;
    }
}