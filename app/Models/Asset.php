<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'asset_type_id',
        'asset_name',
        'balance',
        'note',
    ];

    protected $primaryKey = 'asset_id';
    protected $table = 'assets';
}
