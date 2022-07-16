<?php

namespace App\Http\Filters;

use Agog\Osmose\Library\OsmoseFilter;
use Agog\Osmose\Library\Services\Contracts\OsmoseFilterInterface;

class HouseFilter extends OsmoseFilter implements OsmoseFilterInterface
{
    /**
     * Defines compulsory filter rules
     * @return array
     */
    public function residue () :array
    {
        return [
            'search' => function ($query, $value) {
                return $query->where('house_number', 'like', "$value%");
            }
        ];
    }

    /**
     * Defines form elements and sieve values
     * @return array
     */
    public function bound () : array
    {
        $apartment = request()->route('apartment');

        return [
            "column:apartment_id,$apartment->id"
        ];
    }
}
