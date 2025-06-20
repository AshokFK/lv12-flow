<?php

use App\Models\FlowHeader;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('flow_item', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(FlowHeader::class, 'header_id')
                ->constrained()->onDelete('restrict')
                ->comment('id header flow');
            $table->morphs('itemable');
            $table->string('next_to')->nullable()->comment('id next item untuk menunjukkan proses selanjutnya');
            $table->string('proses_type')->nullable()->comment('type proses standar atau custom');
            
            $table->json('operator')->nullable();
            $table->json('mesin')->nullable();
            $table->boolean('is_active')->default(1);

            $table->string('left')->nullable()->comment('posisi item di kiri');
            $table->string('top')->nullable()->comment('posisi item di atas');

            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flow_item');
    }
};
