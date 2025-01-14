<?php

namespace Feelri\Core\Services\Cloud\Qiniu;

use Feelri\Core\Enums\Model\ConfigKeyEnum;
use Feelri\Core\Services\Model\ConfigService;

class Qiniu
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
			->key(ConfigKeyEnum::QiniuCloud)
			->get();
	}
}
