<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Iar extends Model
{
    use HasFactory;

    public $table = 'iar_table';
    protected $fillable = [
        'iar_number',
        'pr_id',
        'ptr_number',
        'logistics_officer',
        'created_at',
        'updated_at'
    ];
}
