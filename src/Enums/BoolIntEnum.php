<?php

namespace Feelri\Core\Enums;

/**
 * bool 整型
 */
enum BoolIntEnum: int
{
	use CollectTrait;

	case True = 1;
	case False = 0;
}
