<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sinh_viens', function (Blueprint $table) {
            $table->id();
            $table->string('ma_sv', 20)->unique();
            $table->string('ho_ten', 100);
            $table->foreignId('lop_hoc_id')->constrained('lop_hocs')->restrictOnDelete();
            $table->string('email', 150)->unique();
            $table->boolean('trang_thai')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sinh_viens');
    }
};
