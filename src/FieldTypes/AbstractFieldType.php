<?php

namespace Alkhachatryan\LaravelEnhancedFilters\FieldTypes;

abstract class AbstractFieldType implements FieldTypeContract
{
    public function __construct(
        public array $rules = [],
    ) {}

    abstract public function fieldTypeSpecificOperators(): array;

    public function operators(): array
    {
        return array_merge($this->fieldTypeSpecificOperators(), [
            'equals' => ['nullable'],
            'notEquals' => ['nullable'],
            'isNull' => ['nullable', 'in:__true__,__false__'],
            'isNotNull' => ['nullable', 'in:__true__,__false__'],

            // todo add in and not in (arrays, validate and filter)
        ]);
    }
}
