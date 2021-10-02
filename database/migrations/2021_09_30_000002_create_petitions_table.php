<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePetitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('petitions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id');
            $table->enum('download_service', ['cfdi', 'retentions']);
            $table->enum('download_type', ['cfdi', 'metadata']);
            $table->enum('download_nature', ['issued', 'received']);
            $table->dateTime('period_since');
            $table->dateTime('period_until');
            $table->enum('status', [
                'created',
                'presented',
                'verified',
                'empty',
                'downloading',
                'completed',
                'error',
            ]);
            $table->lineString('sat_request')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('petitions');
    }
}
