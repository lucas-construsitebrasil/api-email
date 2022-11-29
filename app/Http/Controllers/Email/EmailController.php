<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\SendMessages;
use Webklex\PHPIMAP\Query\WhereQuery;

use SebastianBergmann\Type\NullType;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmail;
use \Illuminate\Support\Facades\Schema;

class EmailController extends Controller
{
    private function storeSendedEmails($message){
        if (DB::table('send_messages')->insert($message)){
            return true;
        }
        
        return response()->json('Tabela não existe');
    }

    public function sendEmail(Request $request){
        $message['to_message'] = $request->destino;
        $message['content_message'] = $request->msg;
        $message['subject_message'] = $request->sub;
        $message['created_at'] = \Carbon\Carbon::now();
        $this->storeSendedEmails($message);
        Mail::to($message['to_message'])->send(new SendEmail($message['content_message'], $message['subject_message']));
    }

    public function getAllSendedEmails(){
        return response()->json(SendMessages::orderby('id', 'DESC')->get());
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
            default:
                echo "Tipo de filtro não encontrado";
        }
        return $this->getByFilter('send_messages', $column, $request->value);
    }
}
