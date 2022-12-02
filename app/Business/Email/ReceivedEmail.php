<?php 
namespace App\Business\Email;

use App\Business\Business;
use App\Http\Controllers\UserEmailController;
use Illuminate\Support\Facades\DB;
use App\Models\ReceiveMessages;
use App\Business\Email\FilterEmail;

class ReceivedEmail
{
    use Business;

    public function index(){
        $this->storeEmails();
        return ReceiveMessages::orderby('id', 'DESC')->get();
    }

    public function show($request){
        return (new FilterEmail('receive_messages'))->filter($request, 'receive_messages');
    }

    private function storeEmails(){ 
        $user = new UserEmailController();
        $folders = $user->getClient()->getFolders();
        foreach($folders as $folder) {
            $query = $folder->messages();
            $uids = $user->getClient()->getConnection()->search(["ALL"], $query->getSequence());
            foreach ($uids as $uid) {
                if (DB::table('receive_messages')->where('email_id_message', $uid)->first() == NULL){
                    $message = $query->getMessageByUid($uid);
                    $attributes = $message->getAttributes();
                    $received['email_id_message'] = $attributes['uid'];
                    $received['subject_message'] = $message->getSubject();
                    $received['from_mail_message'] = $attributes['from']->values[0]->mail;
                    $received['from_fullname_message'] = $attributes['from']->values[0]->personal;
                    $received['html_message'] = $message->getHTMLBody();
                    $received['folder_message'] = $folder->path;
                    $received['received_message'] = $message->getDate()->toString();
                    DB::table('receive_messages')->insert($received);    
                }
            }
        }
    }
}
