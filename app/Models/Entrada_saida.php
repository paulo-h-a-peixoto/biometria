<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class entrada_saida extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'entrada_saida';

    public function teste(){
        return ['ok'];
    }
}
