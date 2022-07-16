<?php

namespace App\Http\Filters;

use Agog\Osmose\Library\OsmoseFilter;
use Agog\Osmose\Library\Services\Contracts\OsmoseFilterInterface;

class TenancyFilter extends OsmoseFilter implements OsmoseFilterInterface
{
    /**
     * Defines compulsory filter rules
     * @return array
     */
    public function bound () :array
    {
        return [
            function ($query) {
                return $query->whereHas('house', function ($builder) {
                    $apartment = request()->route('apartment');
                    $builder->where('houses.apartment_id', $apartment->id);
                });
            }
        ];
    }

    /**
     * Defines form elements and sieve values
     * @return array
     */
    public function residue () :array
    {
        return [

        ];
    }
}
