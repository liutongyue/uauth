<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function feIndex()
    {
        return view('index.index');
    }

    /**
     * 本地首页
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        if (Auth::user()) {
            return redirect('/');
        }

        return '你好';
    }

    public function common(\PCenter\SDK\PCenterManage $pcenter_sdk)
    {

        if ($user = Auth::user()) {

            //已登录的情况下
            $common = [
                'project_name' => config('apps.config.project_name'),
                //当前登录的用户信息
                'user_info' => [
                    "id" => $user['id'],
                    "display_name" => $user['display_name'],
                    "email" => $user['email'],
                    "mobile_phone" => $user['mobile_phone'],
                    "status" => $user['status'],
                ],
            ];

            //带缓存的菜单列表
            $common['menu'] = \Cache::get("user:{$user['id']}:menu", function () use ($pcenter_sdk, $user) {
                $menu = $pcenter_sdk->getUserMenu($user->id);

                if (!empty($menu)) {
                    \Cache::put("user:{$user['id']}:menu", $menu, 15);
                }

                return $menu;
            });

//            //TODO 临时
//            $common['menu'] = [
//                [
//                    'route_uri' => '/fe/personal',
//                    'display_name' => '个人信息',
//                    'children_count' => 0,
//                    'is_menu' => 1,
//                    'menu_icon' => '',
//                    'type' => 2
//                ],
//                [
//                    'route_uri' => '/fe/system/platform/list',
//                    'display_name' => '应用管理',
//                    'children_count' => 0,
//                    'is_menu' => 1,
//                    'menu_icon' => '',
//                    'type' => 2
//                ],
//                [
//                    'route_uri' => '/fe/system/user/list',
//                    'display_name' => '用户管理',
//                    'children_count' => 0,
//                    'is_menu' => 1,
//                    'menu_icon' => '',
//                    'type' => 2
//                ],
//            ];

            //权限列表
            $common['perms'] = $pcenter_sdk->getUserPermission($user)->pluck('name');
        } else {

            //未登录的情况下
            $common = [
                'user_info' => null,
                'menu' => []
            ];
        }

        return ajax_data($common);
    }

    /**
     * 登出
     */
    public function logout(Request $request, \PCenter\SDK\PCenterManage $pcenter_sdk)
    {
        //本地登出
        Auth::guard()->logout();

        //跳转SSO登出
        return redirect($pcenter_sdk->buildLogoutRedirectUrl(url('/index')));
    }
}
