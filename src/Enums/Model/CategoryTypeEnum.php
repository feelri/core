<?php

namespace Feelri\Core\Enums\Model;

use Feelri\Core\Enums\CollectTrait;

/**
 * 分类类型
 */
enum CategoryTypeEnum: string
{
    use CollectTrait;

    case FileUpload = 'file-upload'; // 文件上传
}
