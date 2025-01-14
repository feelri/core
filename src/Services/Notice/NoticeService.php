<?php

namespace Feelri\Core\Services\Notice;

use Feelri\Core\Enums\Model\ConfigKeyEnum;
use Feelri\Core\Enums\Model\NotifyDriverEnum;
use Feelri\Core\Services\Model\ConfigService;
use Feelri\Core\Traits\StaticTrait;
use \Exception;

/**
 * 通知服务
 */
class NoticeService implements NoticeInterface
{
	use StaticTrait;

	/**
	 * 驱动
	 * @var mixed
	 */
	public mixed $driver;

	/**
	 * constructor
	 * @throws Exception
	 */
	public function __construct()
	{
		$driver = ConfigService::static()->key(ConfigKeyEnum::Notice)->get('driver');
		if (empty($driver)) {
			throw new Exception('未设置通知驱动');
		}
		$driver = NotifyDriverEnum::tryFrom($driver)->driverClass();
		$this->driver = new $driver;
	}

	/**
	 * 通知
	 *
	 * @param mixed $params
	 * @return array
	 */
	public function notify(mixed $params): array
	{
		if (is_string($params)) {
			$params = ['content' => $params];
		}
		return $this->driver->notify($params);
	}
}
