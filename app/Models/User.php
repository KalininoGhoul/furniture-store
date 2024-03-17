<?php

namespace App\Models;

use App\Models\Order\Cart;
use App\Models\Order\Order;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property string $login
 * @property string $password
 * @property Role $role
 * @property Cart[]|\App\Models\Collection\Collection $cart
 * @property Cart $activeCart
 * @property Order $orders
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guarded = ['id'];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function hasAccess(string $permission): bool
    {
        return in_array($permission, $this->role->permissions ?? []);
    }

    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class);
    }

    public function activeCart(): HasOne
    {
        return $this->hasOne(Cart::class)->where('is_active', true);
    }

    public function orders(): HasManyThrough
    {
        return $this->hasManyThrough(Order::class, Cart::class);
    }
}
