<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('income_categories', static function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Название категории');
            $table->integer('user_id')->nullable()->comment('Пользователь который создал категорию');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('income_categories');
    }
};
