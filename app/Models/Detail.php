<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    use HasFactory;

    protected $primaryKey = 'detail_id';
    protected $table = 'details';
    public $timestamps = false;
}
