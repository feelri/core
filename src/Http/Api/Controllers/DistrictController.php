<?php

namespace Feelri\Core\Http\Api\Controllers;

use Feelri\Core\Models\District;
use Feelri\Core\Services\ToolService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

/**
 * 地区
 */
class DistrictController extends Controller
{
	/**
	 * 列表
	 *
	 * @param Request $request
	 * @return JsonResponse
	 */
	public function index(Request $request): JsonResponse
	{
		$params = $request->only(['keyword', 'parent_code']);
		$districts = District::query();

		if (!empty($params['keyword'])) {
			$districts = $districts->where(function ($query) use ($params) {
				$query->where('name', 'like', "%{$params['keyword']}%")
					->orWhere('short_name', 'like', "%{$params['keyword']}%")
					->orWhere('merger_name', 'like', "%{$params['keyword']}%");
			});
		}

		if ($params['parent_code'] ?? false) {
			$districts = $districts->where('parent_code', $params['parent_code']);
		}

		$districts = $districts->get();

		return $this->response($districts);
	}

    /**
     * 树状结构数据
     * @return JsonResponse
     */
    public function tree(): JsonResponse
    {
		$cacheKey = 'district-tree';
        $districts = District::query()->get();

		$data = Cache::get($cacheKey);
		if (empty($data)) {
			$data = ToolService::static()->tree($districts->toArray(), 'area_code', 'parent_code');
			Cache::set($cacheKey, $data);
		}

        return $this->response($data);
    }
}
