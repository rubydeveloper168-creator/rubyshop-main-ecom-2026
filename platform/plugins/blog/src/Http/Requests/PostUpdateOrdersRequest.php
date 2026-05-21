<?php

namespace Botble\Blog\Http\Requests;

use Botble\Support\Http\Requests\Request;

class PostUpdateOrdersRequest extends Request
{
    public function rules(): array
    {
        return [
            'orders' => ['required', 'array', 'min:1'],
            'orders.*.id' => ['required', 'integer', 'min:1'],
            'orders.*.order' => ['required', 'integer', 'min:0', 'max:100000'],
        ];
    }
}
