<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('income_transactions', static function (Blueprint $table) {
            $table->id();

            $table->integer('user_id');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->integer('income_category_id')->nullable();

            $table->foreign('income_category_id')
                ->references('id')
                ->on('hb__income_categories')
                ->onDelete('cascade');

            $table->bigInteger('money')->comment('Кол-во потраченных денег');
            $table->timestamp('date_transaction')
                ->comment('Когда были потрачены деньги');

            $table->text('comment')->comment('Комментарий')->nullable();
            $table->boolean('credit')->default(0)->comment('Траты с кредитной карты');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('income_transactions');
    }
};
