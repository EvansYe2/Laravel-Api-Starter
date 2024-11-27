<?php

namespace App\Http\Helpers;


use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\LineFormatter;



/**
 * Log.
 *
 */
class Log {

    /**
     * Detailed debug information
     */
    const DEBUG = 100;

    /**
     * Interesting events
     *
     * Examples: User logs in, SQL logs.
     */
    const INFO = 200;

    /**
     * Uncommon events
     */
    const NOTICE = 250;

    /**
     * Exceptional occurrences that are not errors
     *
     * Examples: Use of deprecated APIs, poor use of an API,
     * undesirable things that are not necessarily wrong.
     */
    const WARNING = 300;

    /**
     * Runtime errors
     */
    const ERROR = 400;

    /**
     * Critical conditions
     *
     * Example: Application component unavailable, unexpected exception.
     */
    const CRITICAL = 500;

    /**
     * Action must be taken immediately
     *
     * Example: Entire website down, database unavailable, etc.
     * This should trigger the SMS alerts and wake you up.
     */
    const ALERT = 550;

    /**
     * Urgent alert.
     */
    const EMERGENCY = 600;
	//worker
	private $logger_worker = null;
	//日志文件缓存
	private static $logerlist = array();
	//收集日志的级别
	public static $logger_level = Logger::INFO;
	//终端显示的级别
	public static $terminal_level = Logger::INFO;

    /**
     *
     * Log::emergency($message);
     * Log::alert($message);
     * Log::critical($message);
     * Log::error($message);
     * Log::warning($message);
     * Log::notice($message);
     * Log::info($message);
     * Log::debug($message);
     */

    public static function warning($message,$prefix='meter'){
        Log::write(Log::WARNING,$message,$prefix,date('YmdH'));
    }
    public static function notice($message,$prefix='meter'){
        Log::write(Log::NOTICE,$message,$prefix,date('YmdH'));
    }
    public static function info($message,$prefix='meter'){
        Log::write(Log::INFO,$message,$prefix,date('YmdH'));
    }
    public static function debug($message,$prefix='meter'){
        Log::write(Log::DEBUG,$message,$prefix,date('YmdH'));
    }

    public static function emergency($message,$prefix='meter'){
        Log::write(Log::EMERGENCY,$message,$prefix,date('YmdH'));
    }
    public static function alert($message,$prefix='meter'){
        Log::write(Log::ALERT,$message,$prefix,date('YmdH'));
    }
    public static function critical($message,$prefix='meter'){
        Log::write(Log::CRITICAL,$message,$prefix,date('YmdH'));
    }
    public static function error($message,$prefix='meter'){
        Log::write(Log::ERROR,$message,$prefix,date('YmdH'));
    }


    public static function write($echo_level, $logger_message,$prefix='meter',$logger_name='local') {

        //得到日志句柄
        $logger = self::getLoger($prefix,$logger_name);

        //记录到日志中
        $res = $logger->addRecord($echo_level, Log::udate().'--'.$logger_message);
//        $res = $logger->warning(self::udate('Y-m-d H:i:s.u').'----'.$logger_message);
        //终端显示
//        if ($echo_level >= self::$terminal_level) {
//            echo "\n". date('Y-m-d H:i:s') ." ". $logger_message;
//        }
    }

    //得到日志
    private  static function getLoger($prefix='',$loger_name) {
        if (! array_key_exists ( $loger_name, self::$logerlist )) {
            $logger_day = date('Y-m-d');
            $logger_time = date('Y-m-d-H');
            //把记录写进PHP流，主要用于日志文件。
//			$stream = new StreamHandler ( __DIR__ . "/../../../appservice/storage/logs/meter/$logger_day/$logger_time.log" );

            $stream = new StreamHandler (storage_path("logs/$logger_day/$prefix-$logger_time.log"));
            //把日志记录格式化成一行字符串。
            $stream->setFormatter ( new LineFormatter(
                null,
                'Y-m-d H:i:s',
                true,
                true
            ));
//            $stream->setFormatter ( new LineFormatter(
//                "[%datetime%] %channel%.%level_name%: %message% %context% %extra%\n\n",
//                date('Y-m-d H:i:s'),
//                true,
//                true
//            ));
            $logger = new Logger ( $loger_name );
            $logger->pushHandler ( $stream );

            //清除日志缓存，因为按时间分组
            self::$logerlist =null;
            self::$logerlist [$loger_name] = $logger;
        }
        return self::$logerlist [$loger_name];
    }

    /**
     * 输出毫秒
     */
    public static function udate($format = 'u', $utimestamp = null) {

        if (is_null($utimestamp)) {
            $utimestamp = microtime(true);
        }

        $timestamp = floor($utimestamp);

        $milliseconds = round(($utimestamp - $timestamp) * 1000000);

        return date(preg_replace('`(?<!\\\\)u`', $milliseconds, $format), $timestamp);

    }

}
