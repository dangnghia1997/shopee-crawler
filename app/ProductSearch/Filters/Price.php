<?php
declare(strict_types=1);

namespace App\ProductSearch\Filters;

use Illuminate\Database\Eloquent\Builder;

class Price implements Filter
{
    /**
     * @param Builder $builder
     * @param string|null $value
     * @return Builder
     */
    public static function apply(Builder $builder, string|null $value): Builder
    {
        if (!$value) {
            return $builder;
        }

        $values = explode(',', $value);
        $from = $values[0] ?? 0;
        $to = $values[1] ?? 0;
        if (count($values) >= 2 && $to) {
            return $builder->whereBetween('price', [$from, $to]);
        }
        return $builder->where('price', '>=', $from);
    }
}
