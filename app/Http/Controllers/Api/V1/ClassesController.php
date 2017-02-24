<?php

namespace App\Http\Controllers\Api\V1;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Dingo\Api\Http\FormRequest;
use App\User;
use App\Model\Classes;
class ClassesController extends BaseController
{

    public function lists(Request $request)
    {
        $model = new \App\Model\Classes;
        $lists =  $model->orderBy('id', 'desc')->take(10)->get()->toArray();
        return ['status_code' => 200,'message' =>'班级列表','data'=> $lists];
    }

    public function show(Request $request)
    {
        $model = new \App\Model\Classes;
        $lists =  $model->orderBy('id', 'desc')->take(10)->get()->toArray();
        return ['status_code' => 200,'message' =>'班级列表','data'=> $lists];
    }

}
