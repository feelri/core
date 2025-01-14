<?php

namespace Feelri\Core\Services\Upload;

use Feelri\Core\Models\FileUpload;

/**
 * 所发送的资源契约
 */
interface AsyncUploadInterface
{
    /**
     * 授权信息
     * @return mixed
     */
    public function credentials(): array;

    /**
     * 回调
     * @param array $params
     * @return FileUpload
     */
    public function callback(array $params): FileUpload;
}
