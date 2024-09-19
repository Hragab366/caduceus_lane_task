<?php

namespace App\Models;

use App\Models\Scopes\BookAuthorScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use PharIo\Manifest\Author;

class Book extends Model
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();

        if(Auth::check()){
            static::creating(function ($book) {
                $book->user_id = Auth::id();
            });
        }
    }
    protected static function booted()
    {
        parent::booted();
        self::addGlobalScope(new BookAuthorScope());
    }


    protected $fillable = ['cover','title','published_at','user_id','description','bio'];

    public function author():BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function scopeFilter($query,$filters)
    {
     return $filters->apply($query);
    }
}
