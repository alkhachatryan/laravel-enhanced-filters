<?php

namespace Alkhachatryan\LaravelEnhancedFilters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class QueryBuilderEnhancedFilter
{
    public function filter(Builder $query, ?array $filters): void
    {
        if (empty($filters)) {
            return;
        }

        foreach ($filters as $column => $filter) {
            foreach ($filter['operators'] as $operator => $operatorValues) {
                foreach ($operatorValues as $operatorValue) {
                    $this->$operator($query, Str::snake($column), $operatorValue);
                }
            }
        }
    }

    protected function equals(Builder $query, string $column, mixed $value): void
    {
        $query->where($column, '=', $value);
    }

    protected function notEquals(Builder $query, string $column, mixed $value): void
    {
        $query->where($column, '!=', $value);
    }

    protected function isNull(Builder $query, string $column, mixed $value): void
    {
        $query
            ->when($value === '__true__', function ($query) use ($column) {
                $query->whereNull($column);
            })
            ->when($value === '__false__', function ($query) use ($column) {
                $query->whereNotNull($column);
            });
    }

    protected function isNotNull(Builder $query, string $column, mixed $value): void
    {
        $query
            ->when($value === '__true__', function ($query) use ($column) {
                $query->whereNotNull($column);
            })
            ->when($value === '__false__', function ($query) use ($column) {
                $query->whereNull($column);
            });
    }

    protected function contains(Builder $query, string $column, mixed $value): void
    {
        $query->where($column, 'LIKE', "%$value%");
    }

    protected function notContains(Builder $query, string $column, mixed $value): void
    {
        $query->whereNot($column, 'LIKE', "%$value%");
    }

    protected function startsWith(Builder $query, string $column, mixed $value): void
    {
        $query->where($column, 'LIKE', "$value%");
    }

    protected function notStartsWith(Builder $query, string $column, mixed $value): void
    {
        $query->whereNot($column, 'LIKE', "$value%");
    }

    protected function endsWith(Builder $query, string $column, mixed $value): void
    {
        $query->where($column, 'LIKE', "%$value");
    }

    protected function notEndsWith(Builder $query, string $column, mixed $value): void
    {
        $query->whereNot($column, 'LIKE', "%$value");
    }

    protected function lengthEquals(Builder $query, string $column, mixed $value): void
    {
        $query->whereRaw("LENGTH({$column}) = ?", [$value]);
    }

    protected function lengthNotEquals(Builder $query, string $column, mixed $value): void
    {
        $query->whereRaw("LENGTH({$column}) != ?", [$value]);
    }

    protected function lengthGreaterThan(Builder $query, string $column, mixed $value): void
    {
        $query->whereRaw("LENGTH({$column}) > ?", [$value]);
    }

    protected function lengthLessThan(Builder $query, string $column, mixed $value): void
    {
        $query->whereRaw("LENGTH({$column}) < ?", [$value]);
    }

    protected function isTrue(Builder $query, string $column, mixed $value): void
    {
        $query
            ->when($value === '__true__', function ($query) use ($column) {
                $query->where($column, true);
            })
            ->when($value === '__false__', function ($query) use ($column) {
                $query->where($column, false);
            });
    }

    protected function isFalse(Builder $query, string $column, mixed $value): void
    {
        $query
            ->when($value === '__true__', function ($query) use ($column) {
                $query->where($column, false);
            })
            ->when($value === '__false__', function ($query) use ($column) {
                $query->where($column, true);
            });
    }

    protected function before(Builder $query, string $column, mixed $value): void
    {
        $query->where($column, '<', $value);
    }

    protected function beforeOrEquals(Builder $query, string $column, mixed $value): void
    {
        $query->where($column, '<=', $value);
    }

    protected function after(Builder $query, string $column, mixed $value): void
    {
        $query->where($column, '>', $value);
    }

    protected function afterOrEquals(Builder $query, string $column, mixed $value): void
    {
        $query->where($column, '>=', $value);
    }

    // Date part filters
    protected function yearEquals(Builder $query, string $column, mixed $value): void
    {
        $query->whereYear($column, $value);
    }

    protected function notYearEquals(Builder $query, string $column, mixed $value): void
    {
        $query->whereYear($column, '!=', $value);
    }

    protected function monthEquals(Builder $query, string $column, mixed $value): void
    {
        $query->whereMonth($column, $value);
    }

    protected function notMonthEquals(Builder $query, string $column, mixed $value): void
    {
        $query->whereMonth($column, '!=', $value);
    }

    protected function dayEquals(Builder $query, string $column, mixed $value): void
    {
        $query->whereDay($column, $value);
    }

    protected function notDayEquals(Builder $query, string $column, mixed $value): void
    {
        $query->whereDay($column, '!=', $value);
    }

    protected function hourEquals(Builder $query, string $column, mixed $value): void
    {
        $query->whereRaw("HOUR({$column}) = ?", [$value]);
    }

    protected function notHourEquals(Builder $query, string $column, mixed $value): void
    {
        $query->whereRaw("HOUR({$column}) != ?", [$value]);
    }

    protected function minuteEquals(Builder $query, string $column, mixed $value): void
    {
        $query->whereRaw("MINUTE({$column}) = ?", [$value]);
    }

    protected function notMinuteEquals(Builder $query, string $column, mixed $value): void
    {
        $query->whereRaw("MINUTE({$column}) != ?", [$value]);
    }

    protected function secondEquals(Builder $query, string $column, mixed $value): void
    {
        $query->whereRaw("SECOND({$column}) = ?", [$value]);
    }

    protected function notSecondEquals(Builder $query, string $column, mixed $value): void
    {
        $query->whereRaw("SECOND({$column}) != ?", [$value]);
    }

    // Numeric comparisons
    protected function greaterThan(Builder $query, string $column, mixed $value): void
    {
        $query->where($column, '>', $value);
    }

    protected function greaterThanOrEquals(Builder $query, string $column, mixed $value): void
    {
        $query->where($column, '>=', $value);
    }

    protected function lessThan(Builder $query, string $column, mixed $value): void
    {
        $query->where($column, '<', $value);
    }

    protected function lessThanOrEquals(Builder $query, string $column, mixed $value): void
    {
        $query->where($column, '<=', $value);
    }
}
