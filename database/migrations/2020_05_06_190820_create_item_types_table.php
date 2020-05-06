<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateItemTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('item_type', 20);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });

        DB::table('item_types')
            ->insert([
                'id' => NULL,
                'item_type' => 'system',
                'created_at' => NULL,
                'updated_at' => NULL
            ]);
        DB::table('item_types')
            ->insert([
                'id' => NULL,
                'item_type' => 'component',
                'created_at' => NULL,
                'updated_at' => NULL
            ]);
        DB::table('item_types')
            ->insert([
                'id' => NULL,
                'item_type' => 'element',
                'created_at' => NULL,
                'updated_at' => NULL
            ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_types');
    }
}
