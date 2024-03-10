<?php
declare(strict_types=1);

namespace App\ProductSearch;

use App\ProductSearch\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ProductSearch
{
    /**
     * @param Request $filters
     * @param Builder $query
     * @return Builder
     */
    public static function apply(Request $filters, Builder $query): Builder
    {
        return static::applyDecoratorsFromRequest($filters, $query);
    }

    /**
     * @param Request $request
     * @param Builder $query
     * @return Builder
     */
    private static function applyDecoratorsFromRequest(Request $request, Builder $query): Builder
    {
        foreach ($request->all() as $filterName => $value) {

            $decorator = static::createFilterDecorator($filterName);

            if (static::isValidDecorator($decorator)) {
                $query = $decorator::apply($query, $value);
            }

        }
        return $query;
    }

    /**
     * @param $name
     * @return string
     */
    private static function createFilterDecorator($name): string
    {
        return __NAMESPACE__ . '\\Filters\\' .
            str_replace(' ', '',
                ucwords(str_replace('_', ' ', $name)));
    }

    /**
     * @param $decorator
     * @return bool
     */
    private static function isValidDecorator($decorator): bool
    {
        return class_exists($decorator) && (new $decorator) instanceof Filter;
    }
}
