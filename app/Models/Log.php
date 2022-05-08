<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'use_date',
        'withdrawal_date',
        'account_id',
        'Asset_id',
        'amount',
        'log_note',
        'asset_balance'
    ];

    protected function account(){
        return $this->belongsTo('App\Models\Account','account_id');
    }

    protected function asset(){
        return $this->belongsTo('App\Models\Asset','Asset_id');
    }

    public function getDivisionName(){
        return $this->account->getdivision();
    }


    
}
