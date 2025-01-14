<?php

namespace Feelri\Core\Enums\Model;

use Feelri\Core\Enums\CollectTrait;
use Feelri\Core\Services\Upload\Alibaba;
use Feelri\Core\Services\Upload\Local;
use Feelri\Core\Services\Upload\Qiniu;
use Exception;

/**
 * 文件上传来源
 */
enum FileUploadFromEnum: string
{
    use CollectTrait;

    case Local = 'local'; // 本地
    case AliYun = 'aliyun'; // 阿里云
    case QiNiu = 'qiniu'; // 七牛云

    /**
     * 枚举文本转换
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            self::Local => __('messages.file_upload.local'),
            self::AliYun => __('messages.file_upload.aliyun'),
            self::QiNiu => __('messages.file_upload.qiniu'),
        };
    }

	/**
	 * 驱动上传类
	 *
	 * @return string
	 * @throws Exception
	 */
	public function driverClass(): string
	{
		return match ($this) {
			self::AliYun => Alibaba::class,
			self::QiNiu  => Qiniu::class,
			self::Local  => Local::class
		};
	}
}
