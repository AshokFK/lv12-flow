<?php

use App\Models\FlowItem;
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
        Schema::create('masalah', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(FlowItem::class)->constrained()
                ->comment('id item flow yang terkait dengan masalah');
            $table->string('type')->comment('type masalah: orang, mesin, material');
            $table->text('deskripsi');
            $table->text('penanganan')->nullable();
            $table->dateTimeTz('done_at')->nullable()->comment('waktu masalah ditandai sebagai selesai');
            $table->dateTimeTz('saved_at')->nullable()->comment('masalah sudah dipilih oleh spv');
            $table->dateTimeTz('posted_at')->nullable()->comment('masalah sudah dipilih oleh chief');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('masalah');
    }
};
