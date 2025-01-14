<?php

namespace Feelri\Core\Models\User;

use Feelri\Core\Models\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserOauth extends Model
{
	/**
	 * 关联用户
	 * @return BelongsTo
	 */
	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}
}
