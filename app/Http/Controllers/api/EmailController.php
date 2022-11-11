<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Webklex\PHPIMAP\Client;
use Webklex\PHPIMAP\ClientManager;
use App\Models\ReceiveMessages;
use Webklex\PHPIMAP\Query\WhereQuery;
use Illuminate\Support\Facades\DB;
use SebastianBergmann\Type\NullType;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmail;

class EmailController extends Controller
{
    private $client;

    public function __construct(){
        $client = (new ClientManager($options = []))->make([
            'host' => 'mail.construsitebrasil.com.br',
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

    public function getAll(){
        die('123');
        return ReceiveMessages::all();
    }

    public function storeEmails(){ 
        $folders = $this->client->getFolders();
        foreach($folders as $folder) {
            $messages = $folder->messages()->all()->get();
            foreach ($messages as $message){
                $attributes = $message->getAttributes();
                if (DB::table('receive_messages')->where('email_id_message', $attributes['uid'])->first() == NULL){
                    $received = array();
                    $received['email_id_message'] = $attributes['uid'];
                    $received['subject_message'] = $message->getSubject();
                    $received['from_mail_message'] = $attributes['from']->values[0]->mail;
                    $received['from_fullname_message'] = $attributes['from']->values[0]->personal;
                    $received['html_message'] = $message->getHTMLBody();
                    $received['folder_message'] = $folder->path;
                    $received['received_message'] = $attributes['delivery_date']->values[0];
                    DB::table('receive_messages')->insert($received);
                }
            }
        }
    }

    public function sendEmail(Request $request){
        $message['to_message'] = $request->destino;
        $message['content_message'] = $request->msg;
        $message['subject_message'] = $request->sub;

        DB::table('send_messages')->insert($message);
        Mail::to($message['to_message'])->send(new SendEmail($message['content_message'], $message['subject_message']));
    }

    public function filterReceived(Request $request, $filtro){
        switch($filtro) {
            case 'data':
                $column = 'received_message';
                break;
            case 'remetente':
                $column = 'from_fullname_message';
                break;
            case 'conteudo':
                $column = 'html_message';
                break;
        }
        return $this->getByFilter('receive_messages', $column, $request->value);
    
    }

    public function filterSended(Request $request, $filtro){
        switch($filtro) {
            case 'data':
                $column = 'sended_message';
                break;
            case 'remetente':
                $column = 'to_message';
                break;
            case 'conteudo':
                $column = 'content_message';
                break;
        }
        return $this->getByFilter('send_messages', $column, $request->value);
    }

    public function getByFilter($table, $column, $string){
        return DB::table($table)->where($column, 'LIKE', "%{$string}%")->get();
    }
}
