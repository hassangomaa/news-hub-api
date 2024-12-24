<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Author extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    public $incrementing = false;

    protected $fillable = [
        'name',
    ];
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->id = Str::uuid()->toString();
        });
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}
