<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu', function (Blueprint $table) {
            $table->id();
            $table->integer('parent_id');
            $table->tinyInteger('is_section');
            $table->String('title');
            $table->String('bullet')->nullable();
            $table->String('icon');
            $table->tinyInteger('has_submenu');
            $table->String('page')->nullable();
            $table->integer('order');
            $table->tinyInteger('is_active');
            $table->timestamps();
            $table->softDeletes('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menu');
    }
}
