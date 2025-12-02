<?php

namespace Alkhachatryan\LaravelEnhancedFilters\Rules;

use Alkhachatryan\LaravelEnhancedFilters\FieldTypes\FieldTypeContract;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Validator;

class EnhancedFilterRule implements ValidationRule
{
    /**
     * @param  FieldTypeContract[]  $fields
     */
    public function __construct(protected array $fields) {}

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $this->validateFieldTypes($fail);
        $this->validateFieldsOperators($value, $fail);
        $this->validateOperatorValues($value, $fail);
    }

    /**
     * Validating the values of filters. Despite validating by the rules from a request (where this rule is used)
     * each field type has its own common validation rules.
     * For example check: DateFieldType::fieldTypeSpecificOperators
     *
     * So in the request where this rule is used, the ID may have a rule like: max:255,
     * but since the ID is a string and has an operator startsWith, the value of ID should be validated with the
     * rules of startsWith operator.
     */
    protected function validateOperatorValues(array $value, Closure $fail): void
    {
        $errors = [];

        foreach ($value as $field => $filters) {
            $fieldRulesFromRequest = $this->fields[$field]->rules;

            foreach ($filters as $operator => $filterValues) {
                $fieldTypeRules = $this->fields[$field]->operators()[$operator] ?? [];
                $joinedRules = array_unique(array_merge($fieldTypeRules, $fieldRulesFromRequest));

                foreach ($filterValues as $filterValue) {
                    $validation = Validator::make(
                        [$operator => $filterValue],
                        [$operator => $joinedRules]
                    );

                    if ($validation->fails()) {
                        // Collect all error messages for this operator
                        $errors[$field][$operator] = array_merge(
                            $errors[$field][$operator] ?? [],
                            $validation->errors()->get($operator)
                        );
                    }
                }
            }
        }

        if (! empty($errors)) {
            foreach ($errors as $field => $operators) {
                foreach ($operators as $operator => $messages) {
                    foreach ($messages as $message) {
                        $fail("$field.$operator: $message");
                    }
                }
            }
        }
    }

    /**
     * Each field type has its own operators. So the string has startsWith, boolean has isTrue, etc
     */
    protected function validateFieldsOperators(array $value, Closure $fail): void
    {
        $incomingFieldsFromRequest = array_keys($value);
        $registeredFieldsFromRequest = array_keys($this->fields);
        $notRegisteredFields = array_diff($incomingFieldsFromRequest, $registeredFieldsFromRequest);

        // Validating incoming fields
        // If they are not registered in a request where this rule is used, the validation error will be returned
        if (! empty($notRegisteredFields)) {
            $implodedFields = implode(', ', $notRegisteredFields);
            $fail("Fields $implodedFields should not be filled.");

            return;
        }

        foreach ($value as $field => $filters) {
            $fieldType = $this->fields[$field];
            $fieldTypeSupportedOperators = array_keys($fieldType->operators());
            foreach ($filters as $operator => $filterValue) {
                if (! in_arrayi($operator, $fieldTypeSupportedOperators)) {
                    $fail("Unsupported operator $operator for field $field");

                    return;
                }
            }
        }
    }

    /**
     * Validating the types of the rules. They must be FieldTypeContract type to later use in backend
     */
    protected function validateFieldTypes(Closure $fail): void
    {
        foreach ($this->fields as $key => $rule) {
            if (! $rule instanceof FieldTypeContract) {
                $fail("$key should be an instance of FieldTypeContract");
            }
        }
    }
}
