<?php

namespace Feelri\Core\Http\AdminApi\Controllers;

use Feelri\Core\Enums\PaginateEnum;
use Feelri\Core\Models\Dictionary;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * 配置
 */
class DictionaryController extends Controller
{
	/**
	 * 列表
	 *
	 * @param Request $request
	 * @return JsonResponse
	 */
	public function index(Request $request): JsonResponse
	{
		$params = $request->only(['limit', 'type', 'parent_id', 'keyword']);
		$dictionaries = Dictionary::query()->where('type', $params['type'] ?? '');

		if (!empty($params['type'])) {
			$dictionaries->where('type', $params['type']);
		}

		if (!empty($params['parent_id'])) {
			$dictionaries->where('parent_id', $params['parent_id']);
		}

		if (!empty($params['keyword'])) {
			$dictionaries->where(function ($query) use ($params) {
				$query->where('label', 'like', "%{$params['keyword']}%")
					->orWhere('key', 'like', "%{$params['keyword']}%")
					->orWhere('value', 'like', "%{$params['keyword']}%");
			});
		}

		$result = $dictionaries->paginate($params['limit'] ?? PaginateEnum::Default->value);
		return $this->response($result);
	}

	/**
	 * 创建
	 *
	 * @param Request $request
	 * @return JsonResponse
	 */
	public function store(Request $request): JsonResponse
	{
		$params = $request->only(['type', 'parent_id', 'key', 'value', 'label']);
		$dictionary = Dictionary::query()->create($params);
		return $this->response(['id'=>$dictionary]);
	}

	/**
	 * 保存
	 *
	 * @param Request $request
	 * @param int     $id
	 * @return JsonResponse
	 */
	public function update(Request $request, int $id): JsonResponse
	{
		$dictionary = Dictionary::query()->findOrFail($id);
		$params = $request->only(['type', 'parent_id', 'key', 'value', 'label']);

		$dictionary->type = $params['type'] ?? '';
		$dictionary->parent_id = $params['parent_id'] ?? 0;
		$dictionary->key = $params['key'];
		$dictionary->value = $params['value'];
		$dictionary->label = $params['label'] ?? $params['value'];
		$dictionary->save();

		return $this->response(['id'=>$dictionary]);
	}

	/**
	 * 删除
	 *
	 * @param int $id
	 * @return Response
	 */
	public function destroy(int $id): Response
	{
		$dictionary = Dictionary::query()->findOrFail($id);
		$dictionary->delete();
		return $this->noContent();
	}
}