<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $fillable = [
        'item_img', 'item_name', 'brand_name', 'description', 'condition', 'price',
    ];
    public const CONDITIONS = [
        'excellent' => '良好',
        'good' => '目立った傷や汚れなし',
        'fair' => 'やや傷や汚れあり',
        'poor' => '状態が悪い',
    ];

    public function getConditionLabelAttribute() {
        return self::CONDITIONS[$this->condition] ?? '';
    }

    public function likedUsers() {
        return $this->belongsToMany(User::class, 'likes')->withTimestamps();
    }
    public function isLikedBy(?User $user) {
        if (!$user) {
            return false;
        }

        return $this->likedUsers()->where('user_id', $user->id)->exists();
    }
}
