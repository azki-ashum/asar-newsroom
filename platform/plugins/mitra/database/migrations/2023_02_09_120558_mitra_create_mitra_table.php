<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('mitras', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('status', 60)->default('published');
            $table->timestamps();
        });

        Schema::create('mitras_translations', function (Blueprint $table) {
            $table->string('lang_code');
            $table->integer('mitras_id');
            $table->string('name', 255)->nullable();

            $table->primary(['lang_code', 'mitras_id'], 'mitras_translations_primary');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mitras');
        Schema::dropIfExists('mitras_translations');
    }
};
