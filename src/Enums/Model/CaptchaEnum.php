<?php

namespace Feelri\Core\Enums\Model;

use Feelri\Core\Enums\CollectTrait;

/**
 * 人机验证枚举
 */
enum CaptchaEnum: string
{
	use CollectTrait;

	case Captcha = 'captcha'; // 图形验证码
	case Cloudflare = 'cloudflare'; // cloudflare 人机验证

	/**
	 * 枚举文本转换
	 * @return string
	 */
	public function label(): string
	{
		return match ($this) {
			self::Captcha => '图形验证码',
			self::Cloudflare => 'cloudflare人机验证',
		};
	}
}
