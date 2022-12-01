<?php

namespace App\Business\Email;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmail;

class SendMessage {

    private $fields;

    public function store($request){
        $this->setFields($request);
        $this->sendEmail();
    }

    public function sendEmail(){
        $this->storeSendedEmails();
        Mail::to($this->fields['to_message'])->send(new SendEmail($this->fields['content_message'], $this->fields['subject_message']));
    }

    private function storeSendedEmails(){
        if (DB::table('send_messages')->insert($this->fields)){
            return true;
        }
        return response()->json('Tabela não existe');
    }

    private function setFields($request){
        $this->fields['to_message'] = $request->destino;
        $this->fields['content_message'] = $request->mensagem;
        $this->fields['subject_message'] = $request->assunto;
        $this->fields['created_at'] = \Carbon\Carbon::now();
    }


}