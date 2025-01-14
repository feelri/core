<?php

namespace Feelri\Core\Services\Cloud\Huawei;

use Feelri\Core\Enums\Model\ConfigKeyEnum;
use Feelri\Core\Services\Model\ConfigService;

class Huawei
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
			->key(ConfigKeyEnum::HuaweiCloud)
			->get();
	}
}
