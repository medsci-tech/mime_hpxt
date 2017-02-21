<?php

namespace App\Http\Transformers;

use App\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{

    protected $availableIncludes = [];
    protected $defaultIncludes = [];

    public function transform(User $item)
    {
        return [
            'name' => $item->name,
            'phone' => $item->phone,
            'created_at'=>(string)$item->created_at,
        ];
    }

}