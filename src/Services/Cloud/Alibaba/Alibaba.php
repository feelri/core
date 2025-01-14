<?php

namespace Feelri\Core\Services\Cloud\Alibaba;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use Feelri\Core\Enums\Model\ConfigKeyEnum;
use Feelri\Core\Services\Model\ConfigService;

class Alibaba
{
    /**
     * 配置信息
     * @var array|mixed
     */
    public array $config;

	/**
	 * constructor
	 * @throws ClientException
	 */
	public function __construct()
	{
		$this->config = ConfigService::static()
			->key(ConfigKeyEnum::AlibabaCloud)
			->get();

		AlibabaCloud::accessKeyClient($this->config['accessKeyId'], $this->config['accessKeySecret'])
			->regionId($this->config['region'])
			->asDefaultClient();
	}
}
