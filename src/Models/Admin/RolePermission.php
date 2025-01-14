<?php

namespace Feelri\Core\Models\Admin;

use Feelri\Core\Models\Model;
use Feelri\Core\Models\Permission\Permission;
use Feelri\Core\Traits\Model\ModelTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RolePermission extends Model
{
	use ModelTrait;

	public $timestamps = false;

	/**
	 * 权限
	 * @return BelongsTo
	 */
	public function permission(): BelongsTo
	{
		return $this->belongsTo(Permission::class, 'permission_id', 'id');
	}
}
