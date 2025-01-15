<?php

namespace Feelri\Core\Models\Dictionary;

use Feelri\Core\Models\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dictionary extends Model
{
	/**
	 * 明细
	 * @return HasMany
	 */
	public function items(): HasMany
	{
		return $this->hasMany(DictionaryItem::class);
	}
}
