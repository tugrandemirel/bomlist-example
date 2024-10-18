<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BomChildren extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'parent_bom_id',
        'child_bom_id',
        'quantity',
    ];
}
