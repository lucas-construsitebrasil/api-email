<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Webklex\PHPIMAP\Client;
use Webklex\PHPIMAP\ClientManager;
use App\Models\Models\ReceiveMessages;

class EmailController extends Controller
{
    private $client;

    public function index(){

        return ReceiveMessages::all();

        /*$folders = $this->client->getFolders();
        foreach($folders as $folder) {
            $messages = $folder->messages()->all()->get();

            foreach ($messages as $message){
                //echo $message->getSubject(). '<br />';
                var_dump($message->getAttributes());
            }
        }*/
    }

    public function store(Request $request){
        ReceiveMessages::create($request->all());
    }

    public function show($id){

    }

    public function update(Request $request, $id){

    }

    public function destroy($id){
        
    }

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

    public function indexs(){
        $folders = $this->client->getFolders();
        foreach($folders as $folder) {
            $messages = $folder->messages()->all()->get();

            foreach ($messages as $message){
                echo $message->getSubject(). '<br />';
                echo $message->getHTMLBody();
            }
        }
        //return view('index', ['messages' => $messages]);
    }
}
