<?php

namespace Feelri\Core\Enums\Model;

use Feelri\Core\Enums\CollectTrait;
use Feelri\Core\Services\Sms\Alibaba;
use Feelri\Core\Services\Sms\Huawei;
use Feelri\Core\Services\Sms\Qiniu;
use Feelri\Core\Services\Sms\Tencent;

/**
 * 短信驱动
 */
enum SmsDriverEnum: string
{
	use CollectTrait;

	case Alibaba = 'alibaba';
	case Tencent = 'tencent';
	case Huawei  = 'huawei';
	case Qiniu   = 'qiniu';

	/**
	 * 枚举文本转换
	 * @return string
	 */
	public function label(): string
	{
		return match ($this) {
			self::Alibaba => __('enum.sms.alibaba'),
			self::Tencent => __('enum.sms.tencent'),
			self::Huawei  => __('enum.sms.huawei'),
			self::Qiniu   => __('enum.sms.qiniu'),
		};
	}

	/**
	 * 驱动上传类
	 * @return string
	 */
	public function driverClass(): string
	{
		return match ($this) {
			self::Alibaba => Alibaba::class,
			self::Tencent => Tencent::class,
			self::Huawei  => Huawei::class,
			self::Qiniu   => Qiniu::class,
		};
	}
}
