<?php

namespace Feelri\Core\Http\UserApi\Requests\Auth;

use Feelri\Core\Http\Api\Requests\BaseRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class AuthLoginRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'account'       => 'required|string',
            'password'      => 'required|string',
            'verify_token'  => 'required|verify',
        ];
    }

    /**
     * 字段别名
     * @return array
     */
    public function attributes(): array
    {
        return [
            'account'  => __('validation.attributes.账号'),
            'password'  => __('validation.attributes.密码'),
            'verify_token'  => __('validation.attributes.人机验证'),
        ];
    }
}
