<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Store extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'address',
        'opening_time',
        'closing_time',
        'full_week',
        'working_days',
        'status'
    ];

    const CONST_ENABLE = 1;
    const CONST_DISABLE = 0;

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function setWorkingDaysAttribute($value)
    {
        $this->attributes['working_days'] = json_encode($value);
    }

    public function getWorkingDaysAttribute($value)
    {
        return json_decode($value);
    }
}
