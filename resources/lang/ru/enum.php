<?php
return [
    'COMMON_AUTHENTICATION_EXCEPTION' => ['Code'=>'400','Message'=>'未登录或登录状态失效'],
    'COMMON_MODEL_NOT_FOUND_EXCEPTION' => ['Code'=>'404','Message'=>'该模型未找到'],
    'COMMON_AUTHORIZATION_EXCEPTION' => ['Code'=>'403','Message'=>'没有此权限'],
    'COMMON_NOT_FOUND_EXCEPTION' => ['Code'=>'404','Message'=>'没有找到该页面'],
    'COMMON_METHOD_NOT_ALLOW_HTTP_EXCEPTION' => ['Code'=>'405','Message'=>'访问方式不正确'],
    'COMMON_AUTH_EXCEPTION' => ['Code'=>'400','Message'=>'未登录或登录状态失效'],

    'COMMON_HTTP_OK' => ['Code'=>'200000','Message'=>'操作成功'],
    'COMMON_TOKEN_GET_SUCCESS' => ['Code'=>'200001','Message'=>'获取token成功ru'],
    'COMMON_TOKEN_GET_ERROR' => ['Code'=>'200002','Message'=>'获取token失败'],

    'COMMON_REGISTER_SUCCESS' => ['Code'=>'200003','Message'=>'注册成功'],
    'COMMON_REGISTER_ERROR' => ['Code'=>'200004','Message'=>'注册失败'],

    'COMMON_LOGIN_SUCCESS' => ['Code'=>'200018','Message'=>'登录成功'],
    'COMMON_LOGIN_ERROR' => ['Code'=>'200019','Message'=>'账户或密码错误'],
    'COMMON_LOGOUT_SUCCESS' => ['Code'=>'200020','Message'=>'退出成功'],
    'COMMON_LOGOUT_ERROR' => ['Code'=>'2000021','Message'=>'退出失败'],
    'COMMON_FORGET_PASSWORDS_ERROR' => ['Code'=>'2000022','Message'=>'密码重置失败'],
    'COMMON_FORGET_PASSWORDS_SUCCESS' => ['Code'=>'2000022','Message'=>'密码重置成功'],
    'COMMON_SETTING_PASSWORDS_SUCCESS' => ['Code'=>'2000024','Message'=>'密码设置成功'],
    'COMMON_SETTING_PASSWORDS_ERROR' => ['Code'=>'2000025','Message'=>'密码设置失败']
];
