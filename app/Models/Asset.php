<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable; 

class Asset extends Model
{
    use HasFactory;
    use Sortable;

    protected $fillable = [
        'member_id',
        'asset_num',
        'asset_type_id',
        'asset_name',
        'balance',
        'asset_note',
    ];

    protected $primaryKey = 'asset_id';
    protected $table = 'assets';

    public function assettype(){
        return $this->belongsTo('App\Models\AssetType','asset_type_id');
    }

    public function getAssetType(){
        return  $this->assettype->asset_type_name ;
    }


}
