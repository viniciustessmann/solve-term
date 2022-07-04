<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotTerm extends Model
{

    protected $table = 'not_terms';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'term',
    ];
}
