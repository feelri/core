<?php

namespace Feelri\Core\Http\AdminApi\Middleware;

use Feelri\Core\Enums\Model\PermissionTypeEnum;
use Feelri\Core\Exceptions\ForbiddenException;
use Feelri\Core\Services\Model\PermissionService;
use \Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PermissionMiddleware
{
	/**
	 * Handle an incoming request.
	 *
	 * @param Request $request
	 * @param Closure $next
	 * @return Response
	 * @throws ForbiddenException
	 */
	public function handle(Request $request, Closure $next): Response
	{
		$admin = $request->user();
		if (empty($admin)) {
			return $next($request);
		}

		$permissionService = (new PermissionService())->from($admin);
		$hasTopLevelRole = $permissionService->hasTopLevelRole();

		// 是否拥有最高权限
		if (!$hasTopLevelRole) {
			$permissions = $permissionService->getTypePermissions(PermissionTypeEnum::Permission);
			$permissionCodes = array_column($permissions, 'permission_code');
			$code = "{$request->route()->uri()}:{$request->method()}";
			if (!in_array($code, $permissionCodes)) {
				throw new ForbiddenException(__('messages.permission.not'));
			}
		}

		return $next($request);
	}
}
