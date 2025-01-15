<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('dictionary', function (Blueprint $table) {
            $table->id();
            $table->integer('category_id')->nullable()->comment('分类编号：关联 category.id');
			$table->integer('parent_id')->nullable()->comment('父级编号');
			$table->string('key', 50)->default('')->comment('键');
			$table->string('value')->nullable()->comment('值');
			$table->string('label', 50)->default('')->comment('名称');
			$table->dateTime('created_at')->nullable()->comment('创建时间');
			$table->dateTime('updated_at')->nullable()->comment('修改时间');

			$table->unique(['key']);
        });

		DB::unprepared('ALTER TABLE `config` comment "字典"');
	}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dictionary');
    }
};
