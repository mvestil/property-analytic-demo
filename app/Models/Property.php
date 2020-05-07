<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Property
 */
class Property extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['guid', 'suburb', 'state', 'country'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function analytics()
    {
        return $this->belongsToMany(AnalyticType::class, 'property_analytics')
            ->withPivot('value')
            ->withTimestamps();
    }
}
