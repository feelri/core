<?php

namespace Feelri\Core\Http\AdminApi\Controllers;

use Feelri\Core\Exceptions\ForbiddenException;
use Feelri\Core\Exceptions\ResourceException;
use Feelri\Core\Http\AdminApi\Requests\Auth\AuthLoginRequest;
use Feelri\Core\Http\AdminApi\Requests\Auth\RepassRequest;
use Feelri\Core\Http\AdminApi\Requests\Auth\UpdateMeRequest;
use Feelri\Core\Models\Admin\Admin;
use Feelri\Core\Services\Model\PermissionService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * 授权
 */
class AuthController extends Controller
{
	/**
	 * 登录
	 *
	 * @param AuthLoginRequest $request
	 * @return JsonResponse
	 * @throws ResourceException
	 */
	public function login(AuthLoginRequest $request): JsonResponse
	{
		$params = $request->only(['account', 'password']);
		$admin  = Admin::query()->where('account', $params['account'])->first();
		if (!$admin) {
			throw new ResourceException(__('message.login.auth_fail'));
		}

		if (!Hash::check($params['password'], $admin->password)) {
			throw new ResourceException(__('messages.login.auth_fail'));
		}


		// 生成 token
		$token = Auth::guard('admin')->login($admin);
		$data  = $this->dataWithToken($token);

		// 记录登录时间
		$admin->last_login_at = now();
		$admin->save();

		return $this->response($data, __('messages.login.success'));
	}

	/**
	 * 刷新 token
	 * @return JsonResponse
	 */
	public function refresh(): JsonResponse
	{
		$data = $this->dataWithToken(Auth::guard('admin')->refresh());
		return $this->response($data);
	}

	/**
	 * 当前用户信息
	 * @return JsonResponse
	 */
	public function me(): JsonResponse
	{
		$admin = Auth::guard('admin')->user();
		$admin->load(['roles']);
		return $this->response($admin);
	}

	/**
	 * 更新当前用户信息
	 *
	 * @param UpdateMeRequest $request
	 * @return JsonResponse
	 */
	public function updateMe(UpdateMeRequest $request): JsonResponse
	{
		$params          = $request->only(['name', 'nickname', 'avatar', 'gender']);
		$admin           = Auth::guard('admin')->user();
		$admin->name     = $params['name'];
		$admin->nickname = $params['nickname'] ?? '';
		$admin->avatar   = $params['avatar'] ?? '';
		$admin->gender   = $params['gender'] ?? 0;
		$admin->save();

		return $this->success();
	}

	/**
	 * 修改密码
	 *
	 * @param RepassRequest $request
	 * @return JsonResponse
	 */
	public function repass(RepassRequest $request): JsonResponse
	{
		$params          = $request->only(['old_password', 'new_password']);
		$admin           = Auth::guard('admin')->user();
		$admin->password = Hash::make($params['new_password']);
		$admin->save();

		return $this->success();
	}

	/**
	 * 修改手机号
	 *
	 * @param Request $request
	 * @return JsonResponse
	 */
	public function updateMobile(Request $request): JsonResponse
	{
		$params         = $request->only(['mobile', 'sms_code']);
		$admin          = Auth::guard('admin')->user();
		$admin->account = $params['mobile'];
		$admin->mobile  = $params['mobile'];
		$admin->save();
		return $this->success();
	}

	/**
	 * 退出登录
	 * @return JsonResponse
	 */
	public function logout(): JsonResponse
	{
		Auth::guard('admin')->logout();
		return $this->response(__('messages.login.out'));
	}

	/**
	 * 用户权限
	 *
	 * @return JsonResponse
	 * @throws ForbiddenException
	 */
	public function permissions(): JsonResponse
	{
		$admin             = Auth::guard('admin')->user();
		$permissionService = new PermissionService();
		return $this->response($permissionService->from($admin)->getAllPermissions());
	}

	/**
	 * 获取 token
	 * @param string $token
	 * @return array
	 */
	protected function dataWithToken(string $token): array
	{
		return [
			'access_token' => $token,
			'token_type'   => 'bearer',
			'expires_in'   => Auth::guard('admin')->factory()->getTTL() * 60
		];
	}
}
