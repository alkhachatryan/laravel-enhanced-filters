<?php

namespace Alkhachatryan\LaravelEnhancedFilters\FieldTypes;

class BooleanFieldType extends AbstractFieldType
{
    public function fieldTypeSpecificOperators(): array
    {
        return [
            'isTrue' => ['nullable', 'in:__true__,__false__'],
            'isFalse' => ['nullable', 'in:__false__,__true__'],
        ];
    }
}
