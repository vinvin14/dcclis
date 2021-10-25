<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ics extends Model
{
    use HasFactory;
    public $table = 'ict_table';

    protected $fillable = [
        'ics_number',
        'is_subject_for_assembly',
        'qty',
        'ris_item_id',
        'property_number',
        'created_at',
        'updated_at'
    ];
}
