<?php

namespace App\Http\Controllers\Login;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PCenter\Models\UserManage;
use PCenter\Modules\User\UserModule;

class ApiLoginController extends Controller
{
    /**
     * 验证账号密码
     *
     * @param Request $request
     * @param UserModule $userModule
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function check(Request $request, UserModule $userModule)
    {
        $this->validate($request, [
            'email' => '',
            'password' => '',
        ]);

        $user = $userModule->newQuery()->where('email', $request->input('email'))->first();

        if (!$user) {
            return api_response(404, '请检查用户名或密码');
        }

        $has_pass = $userModule->checkPassword($user, $request->input('password'));

        return api_data([
            'passed' => $has_pass ? 1 : 0
        ]);
    }

    //发送登录短信
}
