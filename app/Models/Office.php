<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    use HasFactory;

    protected $connection = 'gatekeeper';
    
    public function iar_item()
    {
        return $this->belongsToMany(IarItem::class, 'receiving_office');
    }
}
