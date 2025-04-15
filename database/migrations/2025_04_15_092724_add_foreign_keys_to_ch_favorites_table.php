<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('ch_favorites', function (Blueprint $table) {
            // Pastikan tipe data sesuai dengan users.id
            $table->bigInteger('user_id')->unsigned()->change();
            $table->bigInteger('favorite_id')->unsigned()->change();

            // Tambahkan foreign key
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('favorite_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('ch_favorites', function (Blueprint $table) {
            // Hapus foreign key
            $table->dropForeign(['user_id']);
            $table->dropForeign(['favorite_id']);

            // Kembalikan tipe data ke semula jika diperlukan
            $table->bigInteger('user_id')->change();
            $table->bigInteger('favorite_id')->change();
        });
    }
};
