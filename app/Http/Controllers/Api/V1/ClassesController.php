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

    public function show(Request $request)
    {
        $rules = [
            'openid'=>'required',
            'c_id'=>'required|exists:classes,c_id',
        ];
        $message = [
            'openid.required'=>'openid不能为空！',
            'c_id.required'=>'班级c_id不能为空！',
            'c_id.exists'=>'班级c_id不存在！',
        ];
        $validator = \Validator::make($request->all(),$rules,$message);
        $messages = $validator->messages()->first();
        $response = [
            'status_code' => 200,
            'message' =>  $messages.$request->openid,
        ];
        $messages = $validator->errors();
        /* 输出错误消息 */
        foreach ($messages->get('openid') as $message) {
            return ['status_code' => 0,'message' =>$message];
        }
        foreach ($messages->get('c_id') as $message) {
            return ['status_code' => 0,'message' =>$message];
        }

        $lists =  Classes::where('c_id', $request->c_id)->first();
        return ['status_code' => 200,'message' =>'班级列表','data'=> $lists];
    }

}
