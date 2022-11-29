<?php

namespace App\Http\Controllers\Email;

use App\Http\Controllers\Controller;
use Webklex\PHPIMAP\Client;
use Illuminate\Http\Request;
use Webklex\PHPIMAP\ClientManager;
use App\Http\Requests\EmailRequest;



class ReceivedEmailController extends Controller
{
    public function index(){
        return response()->json($this->business->index());
    }

    public function show(EmailRequest $request){
        return response()->json($this->business->show($request));
    }
}