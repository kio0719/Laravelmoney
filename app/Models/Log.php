<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable; 

class Log extends Model
{
    use HasFactory;
    use Sortable;

    protected $primaryKey = 'log_id';
    protected $table = 'logs';
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

    protected $dates = [
        'use_date',
        'withdrawal_date',
    ];

    public function account(){
        return $this->belongsTo('App\Models\Account','account_id');
    }

    protected function asset(){
        return $this->belongsTo('App\Models\Asset','Asset_id');
    }

    public function getDivisionName(){
        return $this->account->getdivision();
    }

    public function getDivisionId(){
        return $this->account->getdivisionid();
    }


    
}
