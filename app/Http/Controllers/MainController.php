<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Webklex\PHPIMAP\Client;
use Webklex\PHPIMAP\ClientManager;

class MainController extends Controller
{
    private $client;

    public function __construct(){
        $client = (new ClientManager($options = []))->make([
            'host' => 'outlook.office365.com',
            'port' => '993',
            'encryption' => 'TLS',
            'validade_cert' => true,
            'username' => 'caio.magalhaes@construsitebrasil.com.br',
            'password' => '01052003Cc@',
            'protocol' => 'imap'
        ]);
        $client->connect();
        $this->client = $client;
    }

    public function index(){
        $folders = $this->client->getFolders();

        foreach($folders as $folder) {
            $messages = $folder->messages()->all()->get();
            return view('index', ['messages' => $messages]);    
        }
    }
    
}
