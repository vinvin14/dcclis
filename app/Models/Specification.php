<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specification extends Model
{
    use HasFactory;
    public $table = 'specifications_table';

    protected $fillable = [
        'api_spec_id',
        'api_po_id',
        'date_fetched',
        'specification_title',
        'specification_category',
        'specification_details',
        'created_at',
        'updated_at'
    ];
    
}
