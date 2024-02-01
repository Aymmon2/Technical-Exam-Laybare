<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('category_name')->unique();
            $table->text('category_description')->nullable();
            $table->text('product_manager')->nullable();
            $table->softDeletes();
            $table->timestamps();


        });
    }

    public function down()
    {
        Schema::dropIfExists('categories');
    }
};
