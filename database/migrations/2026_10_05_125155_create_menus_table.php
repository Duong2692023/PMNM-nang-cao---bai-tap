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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('ten');
            // Đường dẫn: '/lophoc' (nội bộ) hoặc 'https://...' (bên ngoài). Menu nhóm thì để trống.
            $table->string('duong_dan')->nullable();
            // Menu 2 cấp: parent_id = null là NHÓM (tiêu đề), có parent_id là MỤC trong nhóm.
            // Khóa ngoại trỏ về chính bảng menus, xóa nhóm thì xóa luôn các mục con.
            $table->foreignId('parent_id')->nullable()->constrained('menus')->cascadeOnDelete();
            $table->integer('thu_tu')->default(0);
            $table->boolean('trang_thai')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
