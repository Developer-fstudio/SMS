<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{

    public function clients()
    {
        return $this->belongsToMany(Client::class);
    }
    use HasFactory;


}
