<?php

namespace App\Http\Controllers\Email;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmailRequest;

class SendedEmailController extends Controller
{
    // Faltou tipagem de retorno 

    public function index(){
        return response()->json($this->business->index()); // CRIAR UM RESOURCE 
    }

    // Faltou tipagem de retorno 
    public function show(EmailRequest $request){
        return response()->json($this->business->show($request)); // CRIAR UM RESOURCE
    }

    // Faltou tipagem de retorno 
    public function sendEmail(EmailRequest $request){
        return response()->json($this->business->sendEmail($request)); 
    }
}
