<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Debt extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'uuid',
        'government_id',
        'name',
        'email',
        'amount',
        'due_date',
    ];
}
