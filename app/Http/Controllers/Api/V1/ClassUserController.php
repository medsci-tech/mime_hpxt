<?php

namespace App\Http\Controllers\Api\V1;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Dingo\Api\Http\FormRequest;
use App\User;
use App\Model\Classes;
use App\Model\ClassUsers;
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
            'class_code'=>'required|between:1,20|exists:classes,class_code',
        ];
        $message = [
            'openid.required'=>'openid不能为空！',
            'class_code.required'=>'班级编号不能为空！',
            'class_code.exists'=>'班级编号不存在！',
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
        $class_info = Classes::where('class_code', $request->class_code)->first();
        /* 验证用户是否已经加入过本班级 */
        $c_id = $class_info->c_id;
        $user = User::where('openid', $request->openid)->first();
        if($user)
        {
            $uid = $user->id;
            $model =  new ClassUsers;
            $joinInfo = $model->where(['uid'=>$uid,'c_id'=>$c_id])->first();
            if(!$joinInfo)
            {
                $model->uid = $uid;
                $model->c_id = $c_id;
                $model->save();
            }
        }
        else
        {
            $response = [
                'status_code' => 0,
                'message' =>  '用户不存在!',
            ];
            return $response;

        }
        $response = [
            'status_code' => 200,
            'message' =>  '加入成功!!',
        ];
        return $response;

    }

    /**
     * 加入的班级列表
     *
     * @param  Request  $request
     * @return Response
     */
    public function lists(Request $request)
    {
        $openid = $request->openid;
        $user = User::where('openid', $openid)->first();
        if($user)
        {
            $model =  new ClassUsers;
            $lists =  $model->where('uid', $user->id)->orderBy('id', 'desc')->get()->toArray();
            $c_id_arr = array_pluck($lists, 'c_id');
            $data = Classes::whereIn('c_id', $c_id_arr)->get()->toArray();
            if(!$data) $data = null;
            $response = [
                'status_code' => 200,
                'message' =>  '班级列表!',
                'data' =>  $data,
            ];
        }
        else
            $response = [
                'status_code' => 0,
                'message' =>  '用户不存在!',
            ];

        return $response;
    }

    /**
     * 班级下的用户
     *
     * @param  Request  $request
     * @return Response
     */
    public function allUsers(Request $request)
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
        $model =  new ClassUsers;
        $lists =  $model->where('c_id', $request->c_id)->orderBy('id', 'desc')->get()->toArray();
        $uid_arr = array_pluck($lists, 'uid'); // 班级所有用户
        if($uid_arr)
        {
            $data = User::select(['id as uid','openid','nickname','headimgurl'])->whereIn('id', $uid_arr)->get()->toArray();
            $classes = Classes::where('c_id', $request->c_id)->first();
            $response = [
                'status_code' => 200,
                'message' =>  '班级用户!',
                'class_name' => $classes->class_name,
                'data' =>  $data,
            ];
        }
        else
            $response = [
                'status_code' => 0,
                'message' =>  '班级用户为空!',
                'data' =>  null,
            ];

        return $response;
    }


}
