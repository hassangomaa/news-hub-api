<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'api_key',
        'base_url',
    ];

    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}
