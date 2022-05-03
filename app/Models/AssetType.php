<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetType extends Model
{
    use HasFactory;

    protected $primaryKey = 'asset_type_id';
    protected $table = 'asset_types';
    public $timestamps = false;

    public function getAssetType(){
        return $this->asset_type_id . ':' . $this->asset_type_name ;
    }
}
