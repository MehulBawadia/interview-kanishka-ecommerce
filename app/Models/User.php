<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * A user has many products in their cart.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cartProducts()
    {
        return $this->hasMany(CartProduct::class);
    }

    /**
     * Add a product in the cart of the auth user with a default quantity of 1.
     *
     * @param  \App\Models\Product  $product
     * @param  int  $quantity
     * @return \App\Models\CartProduct
     */
    public function addProductInCart($product, $quantity = 1)
    {
        return $this->cartProducts()->create([
            'product_id' => $product->id,
            'product_name' => $product->name,
            'product_image' => $product->images,
            'quantity' => $quantity,
            'price' => $product->price,
            'amount' => (float) ($product->price * (int) $quantity),
        ]);
    }
}
