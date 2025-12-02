<?php

namespace Alkhachatryan\LaravelEnhancedFilters\FieldTypes;

class DateFieldType extends AbstractFieldType
{
    public function fieldTypeSpecificOperators(): array
    {
        return [
            'before' => ['date_format:Y-m-d\TH:i:sP'],
            'beforeOrEquals' => ['date_format:Y-m-d\TH:i:sP'],
            'after' => ['date_format:Y-m-d\TH:i:sP'],
            'afterOrEquals' => ['date_format:Y-m-d\TH:i:sP'],
            'yearEquals' => ['date_format:Y'],
            'notYearEquals' => ['date_format:Y'],
            'monthEquals' => ['date_format:m'],
            'notMonthEquals' => ['date_format:m'],
            'dayEquals' => ['integer', 'min:1', 'max:31'],
            'notDayEquals' => ['integer', 'min:1', 'max:31'],
            'hourEquals' => ['integer', 'min:0', 'max:23'],
            'notHourEquals' => ['integer', 'min:0', 'max:23'],
            'minuteEquals' => ['integer', 'min:0', 'max:59'],
            'notMinuteEquals' => ['integer', 'min:0', 'max:59'],
            'secondEquals' => ['integer', 'min:0', 'max:59'],
            'notSecondEquals' => ['integer', 'min:0', 'max:59'],
        ];
    }
}
