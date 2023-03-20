<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Musicband extends Model
{
    use HasFactory;

    protected $table = 'musicbands';

    public function scopeSearch($query, $terms)
    {
        collect(explode(" ", $terms))
        ->filter()
        ->each(function($term) use ($query){
        $term = "%" . $term . "%";

        $query->where('name', 'like', $term);
        });
    }
}
