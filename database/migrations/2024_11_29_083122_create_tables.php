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
        Schema::create('pharmacies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->double('cash_balance')->default(0.0);
            $table->timestamps();
        });
        Schema::create('pharmacy_opening_hours', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pharmacy_id');
            $table->json('day_of_week');
            $table->time('open_time');
            $table->time('close_time');
            $table->timestamps();

            $table->foreign('pharmacy_id')->references('id')->on('pharmacies')->onDelete('cascade')->onUpdate('cascade');
        });
        Schema::create('masks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pharmacy_id');
            $table->string('name');
            $table->double('price')->default(0.0);
            $table->timestamps();

            $table->foreign('pharmacy_id')->references('id')->on('pharmacies')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::create('purchase_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('pharmacy_id');
            $table->unsignedBigInteger('mask_id');
            $table->string('pharmacy_name');
            $table->string('mask_name');
            $table->double('transaction_amount')->default(0.0);
            $table->dateTime('transaction_date');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('pharmacy_id')->references('id')->on('pharmacies')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('mask_id')->references('id')->on('masks')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pharmacies');
        Schema::dropIfExists('masks');
        Schema::dropIfExists('purchase_histories');
    }
};
