<?php

namespace Feelri\Core\Enums\Model;

use Feelri\Core\Enums\CollectTrait;

/**
 * 权限菜单类型
 */
enum PermissionTypeEnum: int
{
	use CollectTrait;

	case Menu = 1; // 菜单
	case Permission = 2; // 权限

	/**
	 * 枚举文本转换
	 * @return string
	 */
	public function label(): string
	{
		return match ($this) {
			self::Menu => __('messages.permission.menu'),
			self::Permission => __('messages.permission.permission'),
		};
	}
}
