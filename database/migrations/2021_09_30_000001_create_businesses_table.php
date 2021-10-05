<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * @see \App\Models\Business
 */
class CreateBusinessesTable extends Migration
{
    public function up(): void
    {
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            $table->string('rfc')->unique();
            $table->string('legal_name');
            $table->string('common_name');
            $table->text('certificate');
            $table->text('private_key');
            $table->string('passphrase');
            $table->dateTime('valid_until');

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
        Schema::dropIfExists('businesses');
    }
}
