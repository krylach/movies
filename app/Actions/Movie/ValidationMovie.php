<?php

namespace App\Actions\Movie;

use App\Rules\IsNotEmpty;

class ValidationMovie
{
    public function execute($data)
    {
        $rules = [
            'title' => ['required', IsNotEmpty::class],
            'release_year' => ['required', 'numeric', 'between:1900, 2024'],
            'format_id' => ['required', 'numeric'],
            'stars' => [],
        ];

        $validator = new \Engine\Validator($rules, $data);

        return $validator;
    }
}
