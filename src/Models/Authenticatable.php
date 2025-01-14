<?php

namespace Feelri\Core\Models;

use Feelri\Core\Enums\Model\FileUploadFromEnum;
use Feelri\Core\Traits\Model\ModelTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Config;
use Laravel\Sanctum\HasApiTokens;

class Authenticatable extends User
{
    use ModelTrait;
    use HasApiTokens;

    /**
     * avatar 获取/访问器
     *
     * @return Attribute
     */
    public function avatar(): Attribute
    {
        return new Attribute(
            get: function ($value)  {
                $value = $value ?? Config::get('app.avatar');
                $driver = Config::get('app.file_upload_driver');
                $baseUrl = match ($driver) {
                    FileUploadFromEnum::QiNiu->value => Config::get('qi-niu.koDo.staticUrl'),
                    FileUploadFromEnum::AliYun->value => Config::get('ali-yun.OSS.staticUrl'),
                    default => Config::get('app.asset_url'),
                };
                return  trim($baseUrl, '/') . '/' . trim($value, '/');
            }
        );
    }
}
