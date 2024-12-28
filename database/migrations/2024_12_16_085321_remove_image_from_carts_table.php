<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveImageFromCartsTable extends Migration
{
    public function up()
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->dropColumn('image'); // Remove the image column
        });
    }

    public function down()
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->string('image'); // Restore the image column if needed
        });
    }
}