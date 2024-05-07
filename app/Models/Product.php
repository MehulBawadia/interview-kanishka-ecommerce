<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'price', 'images', 'status',
    ];

    /**
     * Fetch the products whose status is set to active or true.
     *
     * @return void
     */
    public function scopeActive()
    {
        $this->where('status', true);
    }
}
