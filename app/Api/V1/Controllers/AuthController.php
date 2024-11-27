<?php
/**
 * Date: 17/10/12
 * Time: 01:07
 */

namespace App\Api\V1\Controllers;



use App\Http\Controllers\Controller;
use App\Http\Helpers\Log;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
//use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;



//统一响应
use App\Http\Helpers\ApiResponse;

use App\Http\Helpers\Encrypter;

/**
 * Class AuthController
 *
 */

class AuthController extends BaseController
{

    protected $guard = 'api';//设置使用guard为api选项验证，请查看config/auth.php的guards设置项，重要！

    /**
     * Create a new AuthController instance.
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['refresh','auth:api'], [
            'except' => [
                'login',
                'register',
                'sms',
                'forgetpwone'
            ],
        ]);
    }
    public function login(Request $request){
        $credentials = $request->only('email', 'password');
        // $pwd = bcrypt($credentials['password']);

        if ($token = $this->guard()->attempt($credentials)) {
            return $this->respondWithToken($token);
        }
        return ApiResponse::fail('COMMON_LOGIN_ERROR');
    }
    /**
     * Log the user out (Invalidate the token)
     * @return JsonResponse
     */
    public function logout()
    {
        $this->guard()->logout();

        return ApiResponse::success('COMMON_LOGOUT_SUCCESS');
    }

    /**
     * Refresh a token.
     * @return JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }
    public function me()
    {
        $user = $this->guard()->user();
        $info = [
            'id' => $user['id'],
            'email' => $user['email'],
        ];
        return ApiResponse::success('COMMON_HTTP_OK',$info);
//        return response(['success' => $this->guard()->user()], 400);
    }

    /**
     * Get the guard to be used during authentication.
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard($this->guard);
    }

    /**
     * Get the token array structure.
     * @param string $token
     * @return JsonResponse
     */
    protected function respondWithToken($token)
    {
        return ApiResponse::success('COMMON_TOKEN_GET_SUCCESS',[
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => strtotime('+'.($this->guard()->factory()->getTTL() * 60).' seconds',time()),
        ]);
    }



}
