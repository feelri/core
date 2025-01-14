<?php

namespace Feelri\Core\Exceptions;

use Illuminate\Http\JsonResponse;

interface ExceptionInterface
{
    /**
     * 将异常渲染至 HTTP 响应值中
     * @return JsonResponse
     */
    public function render(): JsonResponse;
}
