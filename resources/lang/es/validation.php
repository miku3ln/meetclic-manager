<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | El following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'El :attribute debe ser aceptado. Es ',
    'active_url' => 'El :attribute is not a valid URL. Es ',
    'after' => 'El :attribute must be a date after :date. Es ',
    'after_or_equal' => 'El :attribute must be a date after or equal to :date. Es ',
    'alpha' => 'El :attribute may only contain letters. Es ',
    'alpha_dash' => 'El :attribute may only contain letters, numbers, dashes and underscores. Es ',
    'alpha_num' => 'El :attribute may only contain letters and numbers. Es ',
    'array' => 'El :attribute must be an array. Es ',
    'before' => 'El :attribute must be a date before :date. Es ',
    'before_or_equal' => 'El :attribute must be a date before or equal to :date. Es ',
    'between' => [
        'numeric' => 'El :attribute must be between :min and :max. Es ',
        'file' => 'El :attribute must be between :min and :max kilobytes. Es ',
        'string' => 'El :attribute must be between :min and :max characters. Es ',
        'array' => 'El :attribute must have between :min and :max items. Es ',
    ],
    'boolean' => 'El :attribute field must be true or false. Es ',
    'confirmed' => 'El :attribute confirmation does not match. Es ',
    'date' => 'El :attribute is not a valid date. Es ',
    'date_equals' => 'El :attribute must be a date equal to :date. Es ',
    'date_format' => 'El :attribute does not match the format :format. Es ',
    'different' => 'El :attribute and :other must be different. Es ',
    'digits' => 'El :attribute must be :digits digits. Es ',
    'digits_between' => 'El :attribute must be between :min and :max digits. Es ',
    'dimensions' => 'El :attribute has invalid image dimensions. Es ',
    'distinct' => 'El :attribute field has a duplicate value. Es ',
    'email' => 'El :attribute must be a valid email address. Es ',
    'ends_with' => 'El :attribute must end with one of the following: :values Es ',
    'exists' => 'El selected :attribute is invalid. Es ',
    'file' => 'El :attribute must be a file. Es ',
    'filled' => 'El :attribute field must have a value. Es ',
    'gt' => [
        'numeric' => 'El :attribute must be greater than :value. Es ',
        'file' => 'El :attribute must be greater than :value kilobytes. Es ',
        'string' => 'El :attribute must be greater than :value characters. Es ',
        'array' => 'El :attribute must have more than :value items. Es ',
    ],
    'gte' => [
        'numeric' => 'El :attribute must be greater than or equal :value. Es ',
        'file' => 'El :attribute must be greater than or equal :value kilobytes. Es ',
        'string' => 'El :attribute must be greater than or equal :value characters. Es ',
        'array' => 'El :attribute must have :value items or more. Es ',
    ],
    'image' => 'El :attribute must be an image. Es ',
    'in' => 'El selected :attribute is invalid. Es ',
    'in_array' => 'El :attribute field does not exist in :other. Es ',
    'integer' => 'El :attribute must be an integer. Es ',
    'ip' => 'El :attribute must be a valid IP address. Es ',
    'ipv4' => 'El :attribute must be a valid IPv4 address. Es ',
    'ipv6' => 'El :attribute must be a valid IPv6 address. Es ',
    'json' => 'El :attribute must be a valid JSON string. Es ',
    'lt' => [
        'numeric' => 'El :attribute must be less than :value. Es ',
        'file' => 'El :attribute must be less than :value kilobytes. Es ',
        'string' => 'El :attribute must be less than :value characters. Es ',
        'array' => 'El :attribute must have less than :value items. Es ',
    ],
    'lte' => [
        'numeric' => 'El :attribute must be less than or equal :value. Es ',
        'file' => 'El :attribute must be less than or equal :value kilobytes. Es ',
        'string' => 'El :attribute must be less than or equal :value characters. Es ',
        'array' => 'El :attribute must not have more than :value items. Es ',
    ],
    'max' => [
        'numeric' => 'El :attribute may not be greater than :max. Es ',
        'file' => 'El :attribute may not be greater than :max kilobytes. Es ',
        'string' => 'El :attribute may not be greater than :max characters. Es ',
        'array' => 'El :attribute may not have more than :max items. Es ',
    ],
    'mimes' => 'El :attribute must be a file of type: :values. Es ',
    'mimetypes' => 'El :attribute must be a file of type: :values. Es ',
    'min' => [
        'numeric' => 'El :attribute must be at least :min. Es ',
        'file' => 'El :attribute must be at least :min kilobytes. Es ',
        'string' => 'El :attribute must be at least :min characters. Es ',
        'array' => 'El :attribute must have at least :min items. Es ',
    ],
    'not_in' => 'El selected :attribute is invalid. Es ',
    'not_regex' => 'El :attribute format is invalid. Es ',
    'numeric' => 'El :attribute must be a number. Es ',
    'present' => 'El :attribute field must be present. Es ',
    'regex' => 'El :attribute format is invalid. Es ',
    'required' => 'El :attribute campo es requerido.',
    'required_if' => 'El :attribute campo es requerido when :other is :value. Es ',
    'required_unless' => 'El :attribute campo es requerido unless :other is in :values. Es ',
    'required_with' => 'El :attribute campo es requerido when :values is present. Es ',
    'required_with_all' => 'El :attribute campo es requerido when :values are present. Es ',
    'required_without' => 'El :attribute campo es requerido when :values is not present. Es ',
    'required_without_all' => 'El :attribute campo es requerido when none of :values are present. Es ',
    'same' => 'El :attribute and :other must match. Es ',
    'size' => [
        'numeric' => 'El :attribute must be :size. Es ',
        'file' => 'El :attribute must be :size kilobytes. Es ',
        'string' => 'El :attribute must be :size characters. Es ',
        'array' => 'El :attribute must contain :size items. Es ',
    ],
    'starts_with' => 'El :attribute must start with one of the following: :values Es ',
    'string' => 'El :attribute must be a string. Es ',
    'timezone' => 'El :attribute must be a valid zone. Es ',
    'unique' => 'El :attribute valor ha sido tomado.!',
    'uploaded' => 'El :attribute failed to upload. Es ',
    'url' => 'El :attribute format is invalid. Es ',
    'uuid' => 'El :attribute must be a valid UUID. Es ',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message Es ',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | El following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
