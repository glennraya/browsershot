<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'quantity', 'price', 'is_expired'];

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function createdAt(): Attribute
    {
        return new Attribute(
            get: fn ($value) => Carbon::parse($value)->format('l, F j, Y'),
            // get: fn ($value) => Carbon::parse($this->attributes['created_at'])->diffForHumans(),
        );
    }
}
