

## 安装

#### 1、【必须】安装扩展包
```bash
composer require feelri/core
```

#### 2、【必须】配置 .env 文件，更新 DB_ 相关
```bash
cp .env.example .env
```

#### 3、【必须】安装api相关（默认使用 Laravel Sanctum 授权）
```bash
php artisan install:api
```
>【可选】发布 Sanctum 相关文件
```bash
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider" 
```

#### 4、【必须】发布结构文件（配置、迁移、模型、控制器、路由等）
>会覆盖掉你的文件，请做好备份
```bash
php artisan vendor:publish --provider="Feelri\Core\Provider" --force
```

#### 5、【必须】执行迁移文件
```bash
php artisan migrate
```

#### 6、【可选】填充默认数据
```bash
php artisan db:seed
```