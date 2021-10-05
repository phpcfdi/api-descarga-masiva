<?php

declare(strict_types=1);

use App\Models\Business;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * @see \App\Models\Petition
 */
class CreatePetitionsTable extends Migration
{
    public function up(): void
    {
        Schema::create('petitions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Business::class)
                ->constrained()
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
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
                'completed',
                'error',
            ]);
            $table->lineString('sat_request')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('petitions');
    }
}
