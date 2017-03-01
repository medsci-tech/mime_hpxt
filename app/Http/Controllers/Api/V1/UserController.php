<?php

namespace App\Http\Controllers\Api\V1;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Dingo\Api\Http\FormRequest;
use App\User;
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
            //'password'=>'required|between:6,20',
            'code'=>'required|between:6,6'
        ];
        $message = [
            'phone.required'=>'电话号码不能为空！',
            'phone.digits'=>'电话号码必须11位！',
            'phone.unique'=>'该手机号已经存在！',
           // 'password.required'=>'密码不能为空！',
           // 'password.between'=>'密码必须在6-20位之间！',
            'code.required'=>'验证码不能为空！',
            'code.between'=>'验证码必须为6位！',
        ];

        $validator = \Validator::make($request->all(),$rules,$message);
        //$messages = $validator->messages();
        $messages = $validator->errors();
        /* 输出错误消息 */
        foreach ($messages->get('phone') as $message) {
            return ['status_code' => 0,'message' =>$message];
        }
        foreach ($messages->get('password') as $message) {
            return ['status_code' => 0,'message' =>$message];
        }
        foreach ($messages->get('code') as $message) {
            return ['status_code' => 0,'message' =>$message];
        }
        /* 验证码验证 */
        $auth_code = \Cache::get($request->phone);
        if ($request->code != $auth_code || $request->input('code') == '000000') {
            return ['status_code' => 0,'message' =>'验证码不匹配'];
        }

        /* 注册用用户 */
        $data = $request->all();
        $data = array_except($data, ['password','code']);
        $data['password'] = Hash::make(env('SECRET_DEFAULT'));
        $model = new \App\User();
        $model->fill($data);
        $model->save();
        $insertedId = $model->id;
        $response = [
            'status_code' => 200,
            'message' => '注册成功!',
            'data' =>  [
                'uid'=>$insertedId,
                'openid'=>$model->openid,
                'nickname'=>$model->nickname,
                'headimgurl'=>$model->headimgurl,
            ],
        ];
        return $response;
    }

    /**
     * 检查用户是否注册.
     *
     * @param  Request  $request
     * @return Response
     */
    public function isRegister(Request $request) {
        $rules = [
            'openid'=>'required',
           // 'unionid'=>'required|between:6,20',
        ];
        $message = [
            'openid.required'=>'openid不能为空！',
        ];
        $validator = \Validator::make($request->all(),$rules,$message);
        $messages = $validator->messages()->first();
        $response = [
            'status_code' => 200,
            'message' =>  $messages.$request->openid,
        ];
        $user = \App\User::select(['id as uid','openid','nickname','headimgurl'])->where('openid', $request->openid)->first();
        if($user)
            $response = [
                'status_code' => 0,
                'message' =>  '用户已经注册!',
                'data' =>  $user,
            ];
        else
            $response = [
                'status_code' => 200,
                'message' =>  '用户尚未注册!!',
            ];

        return $response;

    }

    public function show($id)
    {
        $user = User::findOrFail($id);

        return $this->response->array($user->toArray());
    }

}
