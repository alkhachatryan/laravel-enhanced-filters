<?php

namespace Alkhachatryan\LaravelEnhancedFilters\Traits;

trait EnhancedFilters
{
    public function enhancedFiltersWithValues(): array
    {
        if ($this->isNotFilled('enhancedFilters')) {
            return [];
        }

        $enhancedFiltersValues = $this->get('enhancedFilters');
        $enhancedFilters = $this->enhancedFilters();
        $enhancedFiltersWithValuesAndTypes = [];

        foreach ($enhancedFiltersValues as $field => $enhancedFiltersValue) {

            $enhancedFiltersWithValuesAndTypes[$field] = [
                'type' => $enhancedFilters[$field],
                'operators' => $enhancedFiltersValue,
            ];
        }

        return $enhancedFiltersWithValuesAndTypes;
    }
}
