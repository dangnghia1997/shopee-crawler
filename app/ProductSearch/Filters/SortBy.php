<?php
declare(strict_types=1);

namespace App\ProductSearch\Filters;

use Illuminate\Database\Eloquent\Builder;

class SortBy implements Filter
{
    /**
     * @param Builder $builder
     * @param string|null $value
     * @return Builder
     */
    public static function apply(Builder $builder, string|null $value): Builder
    {
        $values = explode('.', $value);
        if (count($values) != 2) {
            return $builder->latest();
        }
        $column = $values[0];
        $direction = $values[1];
        return $builder->orderBy($column, $direction);
    }
}
