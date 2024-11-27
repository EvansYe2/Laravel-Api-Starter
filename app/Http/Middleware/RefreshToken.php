<?php

/**
 * Created by PhpStorm.
 * User: OrangeSix
 * Date: 2021/1/18
 * Time: 3:46 下午
 */

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class RefreshToken extends BaseMiddleware
{
    /**
     * @param $request
     * @param Closure $next
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|mixed
     * @throws JWTException
     * @author: zhaogx
     */
    public function handle($request, Closure $next)
    {
        // 检查此次请求中是否带有 token，如果没有则抛出异常。
        $this->checkForToken($request);

        // 使用 try 包裹，以捕捉 token 过期所抛出的 TokenExpiredException  异常
        try {
            // 检测用户的登录状态，如果正常则通过
            if ($this->auth->parseToken()
                ->authenticate()) {
                return $next($request);
            }
            throw new UnauthorizedHttpException('jwt-auth', '未登录');
        } catch (TokenExpiredException $exception) {
            // 此处捕获到了 token 过期所抛出的 TokenExpiredException 异常，我们在这里需要做的是刷新该用户的 token 并将它添加到响应头中
            try {
                // 刷新用户的 token
                $token = $this->auth->refresh();
                // 使用一次性登录以保证此次请求的成功
                if($request->is("api/renter/*")){
                    \Auth::guard('renter')
                        ->onceUsingId($this->auth->manager()
                            ->getPayloadFactory()
                            ->buildClaimsCollection()
                            ->toPlainArray()['sub']);
                }else{
                    \Auth::guard('api')
                        ->onceUsingId($this->auth->manager()
                            ->getPayloadFactory()
                            ->buildClaimsCollection()
                            ->toPlainArray()['sub']);
                }

            } catch (JWTException $exception) {
                // 如果捕获到此异常，即代表 refresh 也过期了，用户无法刷新令牌，需要重新登录。
                throw new UnauthorizedHttpException('jwt-auth', $exception->getMessage());
            }
        }

        return $next($request)->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ]);
    }
}
