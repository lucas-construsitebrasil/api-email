<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Webklex\PHPIMAP\Client;
use Webklex\PHPIMAP\ClientManager;
use App\Models\Models\ReceiveMessages;
use Webklex\PHPIMAP\Query\WhereQuery;
use Illuminate\Support\Facades\DB;
use SebastianBergmann\Type\NullType;

class EmailController extends Controller
{
    private $client;

    public function index(){
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

    public function store(Request $request){
        /*$received = new ReceiveMessages();
        $received->email_id_message = $request->uid;
        $received->subject_message = $request->subject;
        $received->from_mail_message;
        $received->from_fullname_message;
        $received->html_message;
        $received->folder_message;
        $received->received_message;*/
    }

    public function getBy(Request $request){
       return DB::table('receive_messages')->where($request->column, 'LIKE', "%{$request->value}%")->get();
    }

    public function show($id){

    }

    public function update(Request $request, $id){

    }

    public function destroy($id){
        
    }

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

    public function indexs(){
        $folders = $this->client->getFolders();
        foreach($folders as $folder) {
            if ($folder->path == 'INBOX') {
                $messages = $folder->messages()->all()->get();

                foreach ($messages as $message){
                    echo $message->getFlags();
                }
            }
        }
        //return view('index', ['messages' => $messages]);
    }
}
