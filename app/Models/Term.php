<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Term extends Model
{

    protected $table = 'terms';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'term',
    ];
}
