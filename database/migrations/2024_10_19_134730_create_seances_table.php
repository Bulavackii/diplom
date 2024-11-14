<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('seances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cinema_hall_id')->constrained('cinema_halls')->onDelete('cascade');
            $table->foreignId('movie_id')->constrained('movies')->onDelete('cascade');
            $table->dateTime('start_time');
            $table->decimal('price_regular', 8, 2);
            $table->decimal('price_vip', 8, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('seances');
    }
};
