<?php

namespace App\Traits;

trait UsesCustomSearchOptions
{
    public function getSearchWithOptions(): \Closure
    {
        return function ($meiliSearch, $query, array $options = []) {
            $options['hitsPerPage'] = (int) config('scout.scout_search_limit', 500);
            return $meiliSearch->search($query, $options);
        };
    }
}