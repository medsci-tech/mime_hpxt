<?php

namespace App\Http\Controllers\Api\V1;
use App\User;
//use Illuminate\Http\Request;
use Dingo\Api\Http\FormRequest;
use Illuminate\Support\Collection;
use App\Http\Transformers\UserTransformer;
class TestsController extends BaseController
{
    public function index()
    {
       // $tests = User::findOrFail(1)->toArray();

        return ['status'=>'success','message'=>'ok'];
    }


    public function users()
    {
        $str = 'php教程编程';
        $a ='p';
        $b = '程';
        $pattern = "/^".$a.".*".$b."$/";//求。匹配指定字符开头，指定字符结尾。中间，任意字符，的正则怎么写。
  $res = preg_match_all($pattern, $str, $matches);
     print_r($res);
        ;exit;

        return $this->response->error('This is an error here a iam.', 404);
        $users = User::all();
        return $this->response->item($users, new UserTransformer)->withHeader('X-Foo', 'Bar');
        return $this->response->collection($users, new UserTransformer);

        $user = User::findOrFail(1);

        return $this->response->array($user->toArray());
        $users = User::where('id', 1)->get();
        return $this->response->item($users, new UserTransformer);
    }
}
