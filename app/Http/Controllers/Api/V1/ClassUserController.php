<?php

namespace App\Http\Controllers\Api\V1;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Dingo\Api\Http\FormRequest;
use App\User;
use App\Model\Classes;
class ClassUserController extends BaseController
{

    /**
     * 申请加入班级.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $rules = [
            'openid'=>'required',
            'class_code'=>'required|between:1,20',
        ];
        $message = [
            'openid.required'=>'openid不能为空！',
            'class_code.required'=>'班级编号不能为空！',
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
        foreach ($messages->get('class_code') as $message) {
            return ['status_code' => 0,'message' =>$message];
        }
        /* 查询班级是否存在 */
        $class_code = Classes::where('class_code', $request->class_code)->first();
        if(!$class_code)
        {
            $response = [
                'status_code' => 0,
                'message' =>  '班级编号不存在!',
            ];
            return $response;
        }

        $response = [
            'status_code' => 200,
            'message' =>  '加入成功!!',
        ];
        return $response;
        $user = \App\User::where('openid', $request->openid)->first();
        if($user)
            $response = [
                'status_code' => 0,
                'message' =>  '用户已经注册!',
            ];
        else
            $response = [
                'status_code' => 200,
                'message' =>  '用户尚未注册!!',
            ];

        return $response;

    }


}
