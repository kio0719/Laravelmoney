<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use HasFactory;

    protected $primaryKey = 'division_id';
    protected $table = 'divisions';
    public $timestamps = false;

    public function getDivision(){
        return $this->division_id . ' : ' . $this->division_name ;
    }

    
}
