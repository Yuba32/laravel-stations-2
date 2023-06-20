<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id()->comment('ID');
            $table->date('screening_date')->comment('上映日');
            $table->unsignedBigInteger('schedule_id')->index()->comment('スケジュールID');
            $table->unsignedBigInteger('sheet_id')->index()->comment('シートID');
            $table->char('email', 255)->comment('予約者メールアドレス');
            $table->char('name', 255)->comment('予約者名');
            $table->boolean('is_canceled')->default(false)->comment('予約キャンセル済み');
            $table->timestamps();

            $table->foreign('schedule_id')->references('id')->on('schedules');
            $table->foreign('sheet_id')->references('id')->on('sheets');
            $table->unique(['schedule_id', 'sheet_id']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservations');
    }
}
