<?php

namespace Feelri\Core\Exceptions;

use Feelri\Core\Enums\HTTPCodeEnum;
use Feelri\Core\Enums\HTTPStatusEnum;
use \Throwable;

class AuthException extends BaseException
{
    /**
     * constructor
     *
     * @param string $message 消息
     * @param HTTPCodeEnum $error 错误码
     * @param Throwable|null $previous 异常类
     * @param HTTPStatusEnum $status HTTP status
     * @param string $info 其他信息
     * @param string $link 参考文档链接
     */
    public function __construct(
        /**
         * 消息
         * @var string
         */
        string $message = "",

        /**
         * HTTP 状态码
         * @var HTTPCodeEnum
         */
        HTTPCodeEnum $error = HTTPCodeEnum::ErrorAuth,

        /**
         * 异常
         * @var null|Throwable
         */
        null|Throwable $previous = null,

        /**
         * 自定义参数 status（HTTP状态码）
         * @var HTTPCodeEnum
         */
        protected HTTPStatusEnum $status = HTTPStatusEnum::Unauthorized,

        /**
         * 自定义参数 info （其他信息）
         * @var string
         */
        protected string $info = "",

        /**
         * 自定义参数 link （帮助链接）
         * @var string
         */
        protected string $link = ""
    ) {
		$message = empty($message) ? __('messages.login.not_token') : $message;
        parent::__construct($message, $error, $previous, $status, $info, $link);
    }
}
