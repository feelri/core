<?php

namespace Feelri\Core\Http\Api\Controllers;

use Feelri\Core\Enums\Model\ConfigKeyEnum;
use Feelri\Core\Services\Model\ConfigService;
use \Exception;
use Illuminate\Http\JsonResponse;
use Mews\Captcha\Captcha;

/**
 * 图形验证码
 */
class CaptchaController extends Controller
{
	/**
	 * index
	 *
	 * @param Captcha $captcha
	 * @return JsonResponse
	 * @throws Exception
	 */
	public function index(Captcha $captcha): JsonResponse
	{
		$driver = ConfigService::static()->key(ConfigKeyEnum::System)->get('captcha');
		if ($driver !== 'captcha') {
			throw new Exception("captcha 驱动未启用");
		}

		$data = $captcha->create(config('captcha.driver'), true);
		return $this->response($data);
	}
}