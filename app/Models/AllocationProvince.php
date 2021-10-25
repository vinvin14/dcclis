<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllocationProvince extends Model
{
    use HasFactory;

    public $table = 'allocation_list_for_province';
    protected $fillable = [
        'allocation_list_number',
        'ptr_number',
        'office',
        'created_by',
        'status',
        'created_at',
        'updated_at'
    ];

}
