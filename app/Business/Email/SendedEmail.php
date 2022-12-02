<?php 
namespace App\Business\Email;


use App\Models\SendMessages;
use App\Business\Business;
use App\Business\Email\FilterEmail;

class SendedEmail
{
    use Business;
    
    public function index(){
        return SendMessages::orderby('id', 'DESC')->get();
    }

    public function show($request){
        return (new FilterEmail('send_messages'))->filter($request, 'send_messages');
    }
}