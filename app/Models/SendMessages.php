<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SendMessages extends Model
{
    protected $fillable = ['subject_message', 'to_message', 'content_message'];
}
