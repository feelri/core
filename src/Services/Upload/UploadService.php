<?php

namespace Feelri\Core\Services\Upload;

use Feelri\Core\Enums\Model\ConfigKeyEnum;
use Feelri\Core\Enums\Model\FileUploadFromEnum;
use Feelri\Core\Models\FileUpload;
use Feelri\Core\Services\Model\ConfigService;
use \Exception;

class UploadService implements AsyncUploadInterface
{
    /**
     * 驱动
     * @var AsyncUploadInterface
     */
    private AsyncUploadInterface $driver;

	/**
	 * constructor
	 * @throws Exception
	 */
    public function __construct()
    {
		$driver = ConfigService::static()->key(ConfigKeyEnum::System)->get('file_upload.driver');
		if (empty($driver)) {
			throw new \Exception('未设置上传驱动');
		}

		$driver = FileUploadFromEnum::tryFrom($driver)->driverClass();
        $this->driver = new $driver;
    }

    /**
     * 授权信息
     * @return array
     * @throws Exception
     */
    public function credentials(): array
    {
        return [
            'driver'    => config('app.file_upload.driver'),
            'data'      => $this->driver->credentials()
        ];
    }

	/**
	 * 回调
	 *
	 * @param array $params
	 * @return FileUpload
	 */
    public function callback(array $params): FileUpload
    {
        return $this->driver->callback($params);
    }
}
