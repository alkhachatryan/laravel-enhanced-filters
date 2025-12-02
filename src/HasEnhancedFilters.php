<?php

namespace Alkhachatryan\LaravelEnhancedFilters;

interface HasEnhancedFilters
{
    public function enhancedFilters(): array;

    public function enhancedFiltersWithValues(): array;
}
