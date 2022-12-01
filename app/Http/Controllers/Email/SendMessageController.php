<?php

namespace App\Http\Controllers\Email;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmailRequest;


class SendMessageController extends Controller
{
    public function store(EmailRequest $request){
        return response()->json($this->business->store($request));
    }
}
