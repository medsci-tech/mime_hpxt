<?php

namespace App\Http\Controllers\Api\V1;

//use Illuminate\Http\Request;
use Dingo\Api\Http\FormRequest;

class UserController extends BaseController
{
    public function show($id)
    {
        $user = User::findOrFail($id);

        return $this->response->array($user->toArray());
    }
}
