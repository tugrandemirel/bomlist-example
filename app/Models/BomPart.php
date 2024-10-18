<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BomPart extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'bom_id',
        'part_id',
        'quantity',
    ];
}
