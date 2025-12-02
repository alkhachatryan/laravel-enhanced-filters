# Laravel Enhanced Filters 🛠️
<div align="center">
<img width="492" height="267" alt="image" src="https://github.com/user-attachments/assets/ad67ac96-6916-4043-ac2f-b497f94068a6" />

**Want to have a filters like this? Go ahead**😎
</div>

<br><br>


Enhanced Filters for Laravel provide a flexible, **AWS-like filtering system** for filtering. You can define fields, operators, and their validation rules, then use them to filter queries efficiently. ✅

It supports multiple field types, each with their own operators. The package handles validation, ensures only supported operators are used, and integrates seamlessly with Laravel request classes. 💡

Perfect for building advanced search and filter systems without writing repetitive query logic. 🚀
<br><br>
**This is an API(backend, no UI) implementation only**
<br><br>

## Usage

### Define Enhanced Filters in your Request Class

Your request class should implement `HasEnhancedFilters` and use `EnhancedFilters` trait:

```php
<?php
use Alkhachatryan\LaravelEnhancedFilters\HasEnhancedFilters;
use Alkhachatryan\LaravelEnhancedFilters\Traits\EnhancedFilters;
use Alkhachatryan\LaravelEnhancedFilters\FieldTypes\{
    BooleanFieldType,
    DateFieldType,
    NumericFieldType,
    StringFieldType
};

class ListBlogPostsRequest extends FormRequest implements HasEnhancedFilters
{
    use EnhancedFilters;

    public function rules(): array
    {
        return [
            // your basic rules
            'enhancedFilters' => [new EnhancedFilterRule($this->enhancedFilters())],
        ];
    }

    public function enhancedFilters(): array
    {
        return [
            'title' => new StringFieldType(['nullable', 'max:255']),
            'body' => new StringFieldType(['nullable', 'max:5000']),
            'author_id' => new NumericFieldType(['nullable', 'int'),
            'rating' => new NumericFieldType(['nullable', 'float']),
            'is_active' => new BooleanFieldType(['nullable']),
            'created_at' => new DateFieldType(['nullable']),
        ];
    }
}
```

### Call the filter class in your controller/service/business logic class
```php
        use Alkhachatryan\LaravelEnhancedFilters\QueryBuilderEnhancedFilter;

        // Later in the method
        $queryBuilderEnhancedFilter = app(QueryBuilderEnhancedFilter::class);
        $enhancedFilters = $request->enhancedFiltersWithValues();
        $query = BlogPost::query();

        // Your specific querying
        
        $queryBuilderEnhancedFilter->filter($query, $enhancedFilters);

        // Your ordering staff

        return $query->get(); // or whatever
```

### Send your enhanced request
The example in postman below
<img width="1451" height="643" alt="image" src="https://github.com/user-attachments/assets/9ca01fe4-68e6-4d58-9315-047092e2de11" />

## Installation
```composer require alkhachatryan/laravel-enhanced-filters```

That's it.

## More about the package
So the package provides the extension for your request classes for filtering.

You will be able to filter like: **FIELD - FILTERING_OPERATOR - VALUE**

The package provides the following field-types:
1. BooleanFieldType
2. DateFieldType
3. NumericFieldType
4. StringFieldType

Each of them have their own specific filtering operators, but also have the common ones.

**(not that true and false values(i.e. boolean) should be sent as a \_\_true\_\_ or \_\_false\_\_ strings**

### Common filtering operators for all field types
- equals - string/numberic value
- notEquals - string/numberic value
- isNull - **\_\_true\_\_** or **\_\_false\_\_**
- isNotNull - **\_\_true\_\_** or **\_\_false\_\_**


### Boolean filtering operators
- isTrue - **\_\_true\_\_** or **\_\_false\_\_**
- isFalse - **\_\_true\_\_** or **\_\_false\_\_**


### Date filtering operators
- before - a date formatted Y-m-d\TH:i:sP
- beforeOrEquals - a date formatted Y-m-d\TH:i:sP
- after - a date formatted Y-m-d\TH:i:sP
- afterOrEquals - a date formatted Y-m-d\TH:i:sP
- yearEquals - a date formatted Y
- notYearEquals - a date formatted Y
- monthEquals - a date formatted m
- notMonthEquals - a date formatted m
- dayEquals - an integer [1-31]
- notDayEquals - an integer [1-31]
- hourEquals - an integer [0-23]
- notHourEquals - an integer [0-23]
- minuteEquals - an integer [0-59]
- notMinuteEquals - an integer [0-59]
- secondEquals - an integer [0-59]
- notSecondEquals - an integer [0-59]


### Numeric filtering operators
- greaterThan - numeric value
- greaterThanOrEquals - numeric value
- lessThan - numeric value
- lessThanOrEquals - numeric value


### String filtering operators
- contains - string value
- notContains - string value
- startsWith - string value
- notStartsWith - string value
- endsWith - string value
- notEndsWith - string value
- lengthEquals - integer value
- lengthNotEquals - integer value
- lengthGreaterThan - integer value
- lengthLessThan - integer value


