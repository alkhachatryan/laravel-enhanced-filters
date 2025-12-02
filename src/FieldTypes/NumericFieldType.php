<?php

namespace Alkhachatryan\LaravelEnhancedFilters\FieldTypes;

class NumericFieldType extends AbstractFieldType
{
    public function fieldTypeSpecificOperators(): array
    {
        return [
            'greaterThan' => ['numeric'],
            'greaterThanOrEquals' => ['numeric'],
            'lessThan' => ['numeric'],
            'lessThanOrEquals' => ['numeric'],
        ];
    }
}
