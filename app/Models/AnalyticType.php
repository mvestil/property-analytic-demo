<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AnalyticType
 */
class AnalyticType extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'units', 'is_numeric', 'num_decimal_places'];

    public function properties()
    {
        return $this->belongsToMany(Property::class, 'property_analytics')
            ->withPivot('value')
            ->withTimestamps();
    }

    public function isNumeric(): bool
    {
        return (bool) $this->is_numeric;
    }
}
