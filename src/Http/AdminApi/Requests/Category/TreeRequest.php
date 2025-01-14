<?php

namespace Feelri\Core\Http\AdminApi\Requests\Category;

use Feelri\Core\Enums\Model\CategoryTypeEnum;
use Feelri\Core\Http\Api\Requests\BaseRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class TreeRequest extends BaseRequest
{

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, ValidationRule|array|string>
	 */
	public function rules(): array
	{
		$typeImplode = CategoryTypeEnum::implode();

		return [
			'type'       => "required|in:{$typeImplode}",
		];
	}

	/**
	 * 字段别名
	 * @return array
	 */
	public function attributes(): array
	{
		return [
			'type'       => __('validation.attributes.type'),
		];
	}
}
