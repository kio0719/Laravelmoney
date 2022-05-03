<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class division extends Model
{
    use HasFactory;

    protected $primaryKey = 'division_id';
    protected $table = 'divisions';
    public $timestamps = false;
}
