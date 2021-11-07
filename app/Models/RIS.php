<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RIS extends Model
{
    use HasFactory;
    public $table = 'ris_table';

    protected $fillable = [
        'ris_number', 
        'requesting_office',
        'approved_by',
        'date_approved',
        'status',
        'reason_for_status',
        'issuance_status',
        'created_at',
        'updated_at'
    ];

    public function items()
    {
        return $this->hasMany(RisItem::class);
    }
}
