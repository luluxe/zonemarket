<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    public $fillable = [
        'product_id', 'category_id', 'promotion_percent', 'start_at', 'end_at',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
    ];

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }
}
