<?php
namespace App\Http\Helpers;

use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Arr;

/**
 * 当高并发访问同一资源(ActiveRecord)时，利用redis的乐观锁减少数据库的访问次数
 * 使用示例：
 * $key = 'withdraw_'.$user['id'].':lock';
 * $bool = RedisCache::lockEntrust($key);
 * if (!$bool){
 * return ApiResponse::fail(ApiResponse::$WITHDRAW_APPLY_ERROR);
 * }
 * 结合try()catch (\Exception $e){
 * DB::rollBack();
 * return ApiResponse::fail(ApiResponse::$COMMON_WITHDRAW_ERROR);
 * } finally {
 * RedisCache::unlockEntrust($key);
 * }
 *
 * 一定要在finally里面释放掉锁
 */
class RedisCache
{
    protected static $redis;
    const LOCK_SUCCESS = 'OK';
    const RELEASE_SUCCESS = 1;

    public function __construct()
    {
        self::$redis = app('redis.connection');
    }


    /**
     * 尝试获取锁
     * @param String $key               锁
     * @param String $requestId         请求id
     * @param int $expireTime           过期时间
     * @return bool                     是否获取成功
     */
    public static function lockEntrust( $key,  $expireTime=null,  $requestId='locked') {

        if($expireTime){
            $lua ="return redis.call('SET', KEYS[1], ARGV[1], 'NX', 'EX', ARGV[2])";

            $result = Redis::eval($lua, 1,$key, $requestId, $expireTime);
        }else{
            $lua ="return redis.call('SET', KEYS[1], ARGV[1], 'NX')";

            $result = Redis::eval($lua, 1,$key, $requestId);
        }



//        if ($expireTime) {
//            return Redis::command('SET', [$key, $requestId, ['nx', 'ex' => $expireTime]]);
//        } else {
//            return Redis::command('SET', [$key, $requestId, 'NX']);
//        }
        return $result;
//        return self::LOCK_SUCCESS === (String)$result;
    }

    /**
     * 解除锁
     * @param String $key               锁
     * @param String $requestId         请求id
     */
    public static function unlockEntrust(  $key,  $requestId='locked') {
        $lua = "if redis.call('get', KEYS[1]) == ARGV[1] then return redis.call('del', KEYS[1]) else return 0 end";

        $result = Redis::eval($lua, 1, $key, $requestId);
        return $result;
    }
}
