<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserVertical extends Model
{
    use HasFactory;

    public function vertical()
    {
        return $this->belongsTo(Vertical::class);
    }
}
