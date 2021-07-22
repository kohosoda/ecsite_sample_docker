<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SoldItem extends Model
{
    protected $fillable = [
        'user_id',
        'item_id',
        'quantity',
    ];

    // Itemモデルへのリレーション
    public function item(): BelongsTo
    {
        return $this->BelongsTo('App\Models\Item');
    }
}
