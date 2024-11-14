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
        Schema::create('mainreports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Пользователь, подавший жалобу
            $table->foreignId('reported_user_id')->constrained('users')->onDelete('cascade'); // Пользователь, на которого подана жалоба
            $table->string('reason'); // Причина жалобы
            $table->text('description')->nullable(); // Описание (необязательно)
            $table->string('status')->default('pending'); // Статус жалобы (например, pending, reviewed, resolved)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mainreports');
    }
};
