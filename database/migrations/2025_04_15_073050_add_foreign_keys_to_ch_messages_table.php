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
        Schema::table('ch_messages', function (Blueprint $table) {
            // Pastikan tipe data sesuai dengan users.id
            $table->bigInteger('from_id')->unsigned()->change();
            $table->bigInteger('to_id')->unsigned()->change();

            // Tambahkan foreign key
            $table->foreign('from_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('to_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('ch_messages', function (Blueprint $table) {
            // Hapus foreign key
            $table->dropForeign(['from_id']);
            $table->dropForeign(['to_id']);

            // Kembalikan tipe data ke semula jika diperlukan
            $table->bigInteger('from_id')->change();
            $table->bigInteger('to_id')->change();
        });
    }
};
