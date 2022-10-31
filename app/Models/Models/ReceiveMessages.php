<?php

namespace App\Models\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceiveMessages extends Model
{
    protected $fillable = ['email_id_message', 'subject_message', 'from_mail_message', 'from_fullname_message',
    'html_message', 'folder_message', 'received_message'];
}
