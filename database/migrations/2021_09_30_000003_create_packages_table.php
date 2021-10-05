<?php

declare(strict_types=1);

use App\Models\Petition;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * @see \App\Models\Package
 */
class CreatePackagesTable extends Migration
{
    public function up(): void
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Petition::class)
                ->constrained()
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
            $table->lineString('sat_package');
            $table->enum('status', ['pending', 'downloaded', 'error']);
            $table->lineString('path');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
}
