<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Currency extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'rate'];

    /**
     * Define a one-to-many relationship to currency histories.
     *
     * @return HasMany
     */
    public function histories(): HasMany
    {
        return $this->hasMany(CurrencyHistory::class);
    }
}
