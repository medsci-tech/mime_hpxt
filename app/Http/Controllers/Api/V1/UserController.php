<?php

namespace App\Http\Controllers\Api\V1;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Dingo\Api\Http\FormRequest;

class UserController extends BaseController
{

    /**
     * 注册新用户密码.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $rules = [
            'phone'=>'required|digits:11|unique:users,phone',
            'password'=>'required|between:6,20',
            'code'=>'required|between:6,6'
        ];
        $message = [
            'phone.required'=>'电话号码不能为空！',
            'phone.digits'=>'电话号码必须11位！',
            'phone.unique'=>'该手机号已经存在！',
            'password.required'=>'密码不能为空！',
            'password.between'=>'密码必须在6-20位之间！',
            'code.required'=>'验证码不能为空！',
            'code.between'=>'验证码必须为6位！',
        ];

        $validator = \Validator::make($request->all(),$rules,$message);
        //$messages = $validator->messages();
        $messages = $validator->errors();
        /* 输出错误消息 */
        foreach ($messages->get('phone') as $message) {
            return $message;
        }
        foreach ($messages->get('password') as $message) {
            return $message;
        }
        foreach ($messages->get('code') as $message) {
            return $message;
        }



        return $request->phone;

        $validator = \Validator::make($request->all(), [
            'phone' => 'required|digits:11',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error_messages' => '无效的手机号码!'
            ]);
        }
        $newUser = [
            'phone' => $request->get('phone'),
            'user_name' => $request->get('name'),
            'password' => bcrypt($request->get('password'))
        ];
        $user = Client::create($newUser);
        $token = JWTAuth::fromUser($user);
        return $token;
    }
    public function show($id)
    {
        $user = User::findOrFail($id);

        return $this->response->array($user->toArray());
    }
}
