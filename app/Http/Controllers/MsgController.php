<?php

namespace App\Http\Controllers;
use Cache;
use Illuminate\Http\Request;
class MsgController extends Controller
{

    /**
     * 短信发送
     * @author      lxhui<772932587@qq.com>
     * @since 1.0
     * @return array
     */
    public function send(Request $request)
    {

        $method=$request->method();
        if($request->isMethod('post')){
            $validator = \Validator::make($request->all(), [
                'phone'   => 'required|digits:11'
            ]);
            if ($validator->fails()) {
                return ['status_code' => 200, 'message' => $validator->errors()->first('phone')];
            }
            $phone  = $request->phone;
            $code   = \MessageSender::generateMessageVerify();
            \MessageSender::sendMessageVerify($phone, $code);
            try {
                Cache::put($phone, $code,1);
            } catch (\Exception $e) {
                return ['status_code' => 0, 'message' => $e->getMessage()];
            }
            return ['status_code' => 200, 'message' => '发送成功!','code'=> $code];
        }
        else{
            return ['status_code' => 0, 'message' => '发送失败!','code'=> null];
        }
    }
}
