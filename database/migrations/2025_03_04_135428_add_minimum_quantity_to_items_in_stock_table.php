<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMinimumQuantityToItemsInStockTable extends Migration
{
    public function up()
    {
        Schema::table('items_in_stock', function (Blueprint $table) {
            $table->unsignedInteger('minimum_quantity')->nullable()->default(0);
        });
    }

    public function down()
    {
        Schema::table('items_in_stock', function (Blueprint $table) {
            $table->dropColumn('minimum_quantity');
        });
    }
}
