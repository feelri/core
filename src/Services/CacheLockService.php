<?php

namespace Feelri\Core\Services;

use \Closure;
use \Exception;
use Illuminate\Support\Facades\Redis;

/**
 * Redis 锁
 * 保证原子性
 */
class CacheLockService
{
    /**
     * 随机值
     * @var string
     */
    private string $key = 'lock-token';

    /**
     * 设置 key
     *
     * @param string $key
     * @return $this
     */
    public function setKey(string $key): CacheLockService
	{
        $this->key = $key;
        return $this;
    }

	/**
	 * 加锁
	 *
	 * @param string $token
	 * @param int    $expire 过期时长
	 * @return mixed
	 */
    public function lock(string $token = '1', int $expire = 10): mixed
	{
		return Redis::set($this->key, $token, "ex", $expire, "nx");
    }

	/**
	 * 解锁
	 *
	 * @param string $token
	 * @return mixed
	 */
    public function unlock(string $token = '1'): mixed
	{
        // LUA 脚本
        $script = "
            if redis.call('get',KEYS[1]) == ARGV[1]
            then
                return redis.call('del',KEYS[1])
            else
                return 0
            end
        ";

		return Redis::eval($script, 1, $this->key, $token);
    }

	/**
	 * 事务操作
	 *
	 * @param Closure $callback
	 * @param string  $token
	 * @return mixed
	 * @throws Exception
	 */
    public function transaction(Closure $callback, string $token = '1'): mixed
	{
        try {
            if (!$this->lock($token)) {
                throw new Exception('您的操作过于频繁，请稍后重试', 10001);
            }

			$result = $callback();
        }
		finally {
            $this->unlock($token);
        }

		return $result;
    }
}