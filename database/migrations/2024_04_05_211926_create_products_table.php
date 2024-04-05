<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id("id_products");
            $table->string("name");
            $table->string("model");
            $table->integer("price");
            $table->integer("stock");
            $table->string("mark");

            $table->unsignedBigInteger("id_categories");
            $table->foreign("id_categories")->references("id_categories")->on("categories");

            $table->unsignedBigInteger("id_users");
            $table->foreign("id_users")->references("id_users")->on("users");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
