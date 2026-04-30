<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketFront extends Model
{

    protected $table = 'tickets';

    protected $fillable = [

        'ticket',
        'nama',
        'email',
        'whatsapp_number',
        'subject',
        'issuetype',
        'department',
        'priority',
        'description',
        'attachments',
        'status',
        'reason',
        'notes'

    ];
}
