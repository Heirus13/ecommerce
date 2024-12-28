<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveNameFromProductsTable extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('name'); // Remove the name column
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('name')->nullable(); // Add the column back if needed
        });
    }
}
