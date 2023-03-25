<?php

namespace Zkood\DeliveryPortal\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $casts = [
        'header' => 'json',
        'body' => 'json',
        'disclosure' => 'json',
    ];

    protected $table = 'dep_logs';

    protected $fillable = ['order_id', 'url', 'method', 'header', 'body', 'disclosure'];
}
