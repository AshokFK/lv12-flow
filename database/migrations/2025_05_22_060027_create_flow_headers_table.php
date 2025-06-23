<?php

use App\Models\Lokasi;
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
        Schema::create('flow_header', function (Blueprint $table) {
            $table->id();
            $table->string('kontrak');
            $table->string('brand');
            $table->string('pattern');
            $table->string('style');
            $table->date('tgl_berjalan');
            $table->foreignIdFor(Lokasi::class)->constrained()->onDelete('restrict');
            $table->date('finished_at')->nullable();
            $table->string('wrapper_width')->nullable();
            $table->string('wrapper_height')->nullable();

            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->unique(['kontrak', 'brand', 'pattern', 'style', 'tgl_berjalan', 'lokasi_id'], 'unique_flow_header');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flow_header');
    }
};
