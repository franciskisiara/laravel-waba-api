<?php

namespace App\Http\Filters;

use Agog\Osmose\Library\OsmoseFilter;
use Agog\Osmose\Library\Services\Contracts\OsmoseFilterInterface;

class MeterReadingFilter extends OsmoseFilter implements OsmoseFilterInterface
{
    /**
     * Defines compulsory filter rules
     * @return array
     */
    public function bound () :array
    {
        $apartment = request()->route('apartment');

        return [
            function ($query) use($apartment) {
                return $query->whereHas('tenancy.house', function ($builder) use($apartment) {
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
