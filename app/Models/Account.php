<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'account_num',
        'account_name',
        'division_id',
        'account_note',
    ];

    protected $primaryKey = 'account_id';
    protected $table = 'accounts';
    public $timestamps = false;

    public function division(){
        return $this->belongsTo('App\Models\Division','division_id');
    }

    public function getdivision(){
        return $this->division->division_name;
    }

    public function getdivisionid(){
        return $this->division->division_id;
    }
}
