<?php

namespace Feelri\Core\Http\UserApi\Controllers;

use Feelri\Core\Enums\Model\UserOauthFromEnum;
use Feelri\Core\Exceptions\ParameterException;
use Feelri\Core\Exceptions\ResourceException;
use Feelri\Core\Http\UserApi\Requests\Auth\AuthLoginRequest;
use Feelri\Core\Models\User\User;
use Feelri\Core\Models\User\UserOauth;
use Feelri\Core\Services\Cloud\Tencent\WechatMiniProgramService;
use EasyWeChat\Kernel\Exceptions\BadResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

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
        $user = User::query()->where('account', $params['account'])->first();
        if (!$user) {
            throw new ResourceException(__('message.login.auth_fail'));
        }

        if (!Hash::check($params['password'], $user->password)) {
            throw new ResourceException(__('message.login.auth_fail'));
        }

        // 生成 token
        $token = Auth::guard('user')->login($user);
        $data = $this->dataWithToken($token);
        return $this->response($data, __('messages.login.success'));
    }

	/**
	 * 小程序登录
	 *
	 * @param Request $request
	 * @return JsonResponse
	 * @throws ParameterException
	 * @throws BadResponseException
	 * @throws ClientExceptionInterface
	 * @throws DecodingExceptionInterface
	 * @throws RedirectionExceptionInterface
	 * @throws ServerExceptionInterface
	 * @throws TransportExceptionInterface
	 */
	public function loginByMiniProgram(Request $request): JsonResponse
	{
		$code = $request->input('code');
		if (empty($code)) {
			throw new ParameterException();
		}
		$session = (new WechatMiniProgramService)->code2Session($code);

		$where = [
			'from'   => UserOauthFromEnum::WechatMiniProgram->value,
			'openid' => $session['openid'],
		];
		$oauth = UserOauth::query()->with('user')->where($where)->first();
		$user = $oauth->user;
		if (!$oauth) {
			$user = DB::transaction(function () use ($session, $where) {
				$user = (new User)->createDefault();
				$user->oauth()->create([...$where, 'unionid' => $session['unionid']]);
				return $user;
			});
		}

		// 生成 token
		$token = Auth::guard('user')->login($user);
		$data = $this->dataWithToken($token);
		return $this->response($data, __('messages.login.success'));
	}

    /**
     * Refresh a token.
     * @return JsonResponse
     */
    public function refresh(): JsonResponse
    {
        $data = $this->dataWithToken(Auth::guard('user')->refresh());
        return $this->response($data);
    }

    /**
     * Get the authenticated User.
     * @return JsonResponse
     */
    public function me(): JsonResponse
    {
        return $this->response(request()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        Auth::guard('user')->logout();
        return $this->response(__('messages.login.out'));
    }

    /**
     * Get the token array structure.
     * @param string $token
     * @return array
     */
    protected function dataWithToken(string $token): array
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::guard('user')->factory()->getTTL() * 60
        ];
    }
}
