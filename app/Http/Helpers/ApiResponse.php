<?php

namespace App\Http\Helpers;

use Jiannei\Response\Laravel\Support\Facades\Response;

class ApiResponse
{
    //return success
    public static function success($code,$data=[]){
        $message = __('enum.'.$code.'.Message');
        $data['lang'] = app()->getLocale();
        return Response::success($data,$message);
    }

    //return fail
    public static function fail($code,$data = []){
        $message = __('enum.'.$code.'.Message');
        $code = __('enum.'.$code.'.Code');
        if (strlen($code) == 3){
            return Response::success($data,$message,$code);
        }else{
            return Response::success($data,$message,$code)->setStatusCode(200);
        }
        // return Response::fail($message,$commonInfo['Code']);
    }

    public static function getMsg($commonInfo,$message = '',$data = []){
        if(empty($message)){
            $message = $commonInfo['Message'];
        }
        return $message;
    }
}
