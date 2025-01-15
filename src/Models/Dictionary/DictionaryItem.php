<?php

namespace Feelri\Core\Models\Dictionary;

use Feelri\Core\Models\Model;
use Kalnoy\Nestedset\NodeTrait;

class DictionaryItem extends Model
{
	use NodeTrait;

	protected $hidden = ['left', 'right', 'created_at', 'updated_at'];

	public function getLftName(): string
	{
		return 'left';
	}

	public function getRgtName(): string
	{
		return 'right';
	}

	public function getParentIdName(): string
	{
		return 'parent_id';
	}
}
