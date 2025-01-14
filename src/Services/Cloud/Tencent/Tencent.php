<?php

namespace Feelri\Core\Services\Cloud\Tencent;

use Feelri\Core\Enums\Model\ConfigKeyEnum;
use Feelri\Core\Services\Model\ConfigService;

class Tencent
{
	/**
	 * 配置信息
	 * @var array|mixed
	 */
	public array $config;

	/**
	 * constructor
	 */
	public function __construct()
	{
		$this->config = ConfigService::static()
			->key(ConfigKeyEnum::TencentCloud)
			->get();
	}
}
