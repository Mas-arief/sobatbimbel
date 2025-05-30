<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProfileFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('name')->nullable()->after('username');
            $table->string('alamat')->nullable()->after('email');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->nullable()->after('alamat');
            $table->string('telepon')->nullable()->after('jenis_kelamin');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['name', 'alamat', 'jenis_kelamin', 'telepon']);
        });
    }
}
