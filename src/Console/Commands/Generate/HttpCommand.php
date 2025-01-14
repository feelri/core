<?php

namespace Feelri\Core\Console\Commands\Generate;

use Illuminate\Console\Command;

class HttpCommand extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'feelri:generate-http';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Command description';

	/**
	 * Execute the console command.
	 */
	public function handle(): void
	{
        $this->createDir('Http/Api');
        $this->createDir('Http/AdminApi');
        $this->createDir('Http/UserApi');
	}

    /**
     * 创建目录
     *
     * @param [type] $path
     * @return void
     */
    public function createDir($path): void
	{
        // 首先创建基础目录
		$baseAdminApi = app_path($path);
		if (!file_exists($baseAdminApi)) {
			mkdir($baseAdminApi, 0755, true);
		}

		// 定义需要创建的子目录
		$directories = [
			$baseAdminApi . '/Controllers',
			$baseAdminApi . '/Middleware',
			$baseAdminApi . '/Requests'
		];

		foreach ($directories as $directory) {
			if (!file_exists($directory)) {
				mkdir($directory, 0755, true);
			}
		}

		$this->info("模块结构创建成功: " . $path);
    }
}
