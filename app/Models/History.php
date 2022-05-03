<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Histor extends Model
{
    use HasFactory;

    protected $primaryKey = 'history_id';
    protected $table = 'history';
    public $timestamps = false;
}
