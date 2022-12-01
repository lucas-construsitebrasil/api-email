<?php

namespace App\Http\Controllers\Email;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmailRequest;

class SendedEmailController extends Controller
{
    public function index(){
        return response()->json($this->business->index());
    }

    public function show(EmailRequest $request){
        return response()->json($this->business->show($request));
    }

    public function sendEmail(EmailRequest $request){
        return response()->json($this->business->sendEmail($request));
    }
}
