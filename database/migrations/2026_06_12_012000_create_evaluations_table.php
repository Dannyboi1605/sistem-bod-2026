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
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Section B: General Assessment (1-4 scale)
            $table->unsignedTinyInteger('b1');
            $table->unsignedTinyInteger('b2');
            $table->unsignedTinyInteger('b3');
            $table->unsignedTinyInteger('b4');
            $table->unsignedTinyInteger('b5');
            $table->unsignedTinyInteger('b6');
            $table->unsignedTinyInteger('b7');
            $table->unsignedTinyInteger('b8');
            $table->unsignedTinyInteger('b9');
            $table->unsignedTinyInteger('b10');

            // Section C: Speaker Assessment (1-4 scale)
            $table->unsignedTinyInteger('c1_idris_jala');
            $table->unsignedTinyInteger('c2_fuad_bee');
            $table->unsignedTinyInteger('c3_petrus_gimbad');
            $table->unsignedTinyInteger('c4_lee_min_onn');
            $table->unsignedTinyInteger('c5_khairunnizat');
            $table->unsignedTinyInteger('c6_saravana_kumar');

            // Section D: Subjective Comments (nullable text)
            $table->text('d1_beneficial')->nullable();
            $table->text('d2_improvements')->nullable();
            $table->text('d3_future_topics')->nullable();

            // Section E: Overall Program Rating (1-4 scale)
            $table->unsignedTinyInteger('e_overall');

            // Section F: Future Interest
            $table->boolean('f_interested')->default(false);
            $table->string('f_field')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};
