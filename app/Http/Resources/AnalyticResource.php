<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class AnalyticResource
 */
class AnalyticResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $value = $this->pivot->value;

        return [
            'analytic_type_id'   => $this->id,
            'analytic_type_name' => $this->name,
            'num_decimal_places' => $this->num_decimal_places,
            'units'              => $this->units,
            'value'              => $this->is_numeric ? ((float) number_format($value, $this->num_decimal_places)) : $value,
            'original_value'     => $this->is_numeric ? ((float) $value): $value,
            'is_numeric'         => (bool)$this->is_numeric,
        ];
    }
}
