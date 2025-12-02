<?php

namespace Alkhachatryan\LaravelEnhancedFilters\FieldTypes;

class StringFieldType extends AbstractFieldType
{
    public function fieldTypeSpecificOperators(): array
    {
        return [
            'contains' => ['string'],
            'notContains' => ['string'],
            'startsWith' => ['string'],
            'notStartsWith' => ['string'],
            'endsWith' => ['string'],
            'notEndsWith' => ['string'],
            'lengthEquals' => ['integer'],
            'lengthNotEquals' => ['integer'],
            'lengthGreaterThan' => ['integer'],
            'lengthLessThan' => ['integer'],
        ];
    }
}
