<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('settings', static function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->bigInteger('balance_credit_card_full')->nullable()
                ->comment('Сколько должно быть на кредитке денег');
            $table->jsonb('expend_category_main')
                ->comment('Какие категории расхода нужно показывать на главной');
            $table->jsonb('income_category_main')
            ->comment('Какие категории дохода нужно показывать на главной');
            $table->jsonb('expend_category_active')->comment('Какие категории расхода активные');
            $table->jsonb('income_category_active')->comment('Какие категории дохода активные');
            $table->boolean('dark_mode')->default(false)->comment('Включить темный режим');


            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('settings');
    }
};
