<?php
declare(strict_types=1);

namespace App\ProductSearch\Filters;

use Illuminate\Database\Eloquent\Builder;

class Brand implements Filter
{
    /**
     * @param Builder $builder
     * @param string|null $value
     * @return Builder
     */
    public static function apply(Builder $builder, string|null $value): Builder
    {
        return $builder->where('brand_key', $value);
    }
}
