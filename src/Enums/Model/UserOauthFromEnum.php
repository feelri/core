<?php

namespace Feelri\Core\Enums\Model;

use Feelri\Core\Enums\CollectTrait;

/**
 * oauth 授权应用来源
 */
enum UserOauthFromEnum: string
{
	use CollectTrait;

	case WechatMiniProgram = 'wechat_mini_program';
}