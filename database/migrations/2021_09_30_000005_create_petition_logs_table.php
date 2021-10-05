<?php

declare(strict_types=1);

use App\Models\Petition;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * @see \App\Models\PetitionLog
 */
class CreatePetitionLogsTable extends Migration
{
    public function up(): void
    {
        Schema::create('petition_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Petition::class)
                ->constrained()
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
            $table->dateTime('occurred_at');
            $table->lineString('message');
            $table->text('request');
            $table->text('response');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('petition_logs');
    }
}
