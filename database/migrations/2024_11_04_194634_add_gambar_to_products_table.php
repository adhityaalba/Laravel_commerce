<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('gambar')->nullable()->after('kategori'); // Menambah kolom 'gambar' setelah 'kategori'
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('gambar'); // Menghapus kolom 'gambar' jika rollback
        });
    }
};
