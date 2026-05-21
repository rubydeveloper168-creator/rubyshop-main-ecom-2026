<?php

namespace Botble\Blog\Http\Requests;

use Botble\Support\Http\Requests\Request;

class PostUpdateOrderByRequest extends Request
{
    public function rules(): array
    {
        return [
            'pk' => ['required', 'integer', 'min:1'],
            'value' => ['required', 'numeric', 'min:0', 'max:100000'],
        ];
    }
}
