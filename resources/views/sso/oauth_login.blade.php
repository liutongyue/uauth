<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $app->name }} </title>
    <style>
        .alert-warning {
            background: yellow;
            padding: 10px;
            border-radius: 5px;
        }

        .dark {
            background-color: #324157;
        }

        .wrap {
            width: 400px;
            margin: 230px auto;
        }

        .ms-title {
            text-align: center;
            font-size: 30px;
            margin-bottom: 40px;
            color: #fff;
        }

        .ms-login {
            height: 160px;
            padding: 40px;
            border-radius: 5px;
            background: #fff;
        }

        .login-btn {
            text-align: center;
            border-color: #20a0ff;
        }

        .login-btn button {
            font-size: 14px;
            display: inline-block;
            background-color: #20a0ff;
            width: 100%;
            color: #fff;
            height: 36px;
            line-height: 32px;
            white-space: nowrap;
            cursor: pointer;
            border: 1px solid #c4c4c4;
            color: #fff;
            margin: 0;
            border-radius: 4px;
            -webkit-appearance: none;
            -moz-user-select: none;
            -webkit-user-select: none;
            -ms-user-select: none;
            outline: 0;
        }

        .input-c {
            margin-bottom: 22px;
            height: 36px
        }

        .input-c input {
            display: inline-block;
            width: 100%;
            height: 36px;
            line-height: 36px;
            padding: 3px 10px;
            border-radius: 4px;
            border: 1px solid #bfcbd9;
            box-sizing: border-box;
            color: #1f2d3d;
            font-size: 14px;
        }
    </style>
</head>
<body class="dark">
<div class="wrap">
    <div class="ms-title">统一登录中心</div>
    <div>
        @if(isset($errors))
            @foreach($errors->all() as $error)
                <div class="alert-warning">
                    {{ $error }}
                </div>
            @endforeach
        @endif
    </div>
    <div class="ms-login">
        <form action="/sso/oauth/login" method="POST" class="el-form demo-ruleForm">
            {{ csrf_field() }}
            <input type="hidden" name="redirect_url" value="{{\Request::get('redirect_url', '')}}">
            <input type="hidden" name="app_id" value="{{ $app->app_id }}">
            <div class="input-c">
                <input type="text" name="username" id="username" placeholder="请输入用户名" value="{{ old('username') }}"/>
            </div>
            <div class="input-c">
                <input type="password" name="password" id="password" placeholder="请输入密码">
            </div>
            <div class="login-btn">
                <button type="submit">登录</button>
            </div>
        </form>
        <div style="margin-top: 10px;">
            {{--            <a href="{{ route('password.request') }}">忘记密码？</a>--}}
        </div>
    </div>
</div>
</body>
</html>