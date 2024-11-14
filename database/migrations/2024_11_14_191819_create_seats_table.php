<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeatsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('seats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cinema_hall_id'); // ID зала
            $table->integer('row'); // Номер ряда
            $table->integer('number'); // Номер места в ряду
            $table->enum('seat_type', ['regular', 'vip', 'none'])->default('regular'); // Тип места
            $table->timestamps();

            // Внешний ключ на таблицу cinema_halls
            $table->foreign('cinema_hall_id')
                ->references('id')
                ->on('cinema_halls')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('seats');
    }
}
