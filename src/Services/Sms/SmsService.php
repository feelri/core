<?php

namespace Feelri\Core\Services\Sms;

use Feelri\Core\Enums\Model\ConfigKeyEnum;
use Feelri\Core\Enums\Model\SmsDriverEnum;
use Feelri\Core\Services\Model\ConfigService;
use \Exception;

class SmsService
{
	/**
	 * 驱动
	 * @var mixed
	 */
	public mixed $driver;

	/**
	 * constructor
	 *
	 * @param string $sign
	 * @param string $code
	 * @throws Exception
	 */
	public function __construct(string $sign = '', string $code = '')
	{
		$driver = ConfigService::static()->key(ConfigKeyEnum::Sms)->get('driver');
		if (empty($driver)) {
			throw new Exception('未设置上传驱动');
		}
		$driver = SmsDriverEnum::tryFrom($driver)->driverClass();
		$driver = (new $driver)->sign($sign)->code($code);
		$this->driver = $driver;
	}

	/**
	 * 发送
	 *
	 * @param string $mobile
	 * @param array  $params
	 * @return array
	 */
	public function sendByMobile(string $mobile, array $params): array
	{
		return $this->driver->sendByMobile($mobile, $params);
	}
}