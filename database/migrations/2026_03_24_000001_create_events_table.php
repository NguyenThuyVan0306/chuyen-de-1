<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('events')) {
            Schema::create('events', function (Blueprint $table) {
                $table->id();
                $table->foreignId('club_id')->constrained('clubs')->onDelete('cascade');
                $table->string('title');
                $table->text('description')->nullable();
                $table->dateTime('start_time');
                $table->dateTime('end_time');
                $table->string('location');
                $table->unsignedInteger('max_participants');
                $table->enum('status', ['upcoming', 'ongoing', 'finished'])->default('upcoming');
                $table->timestamps();
            });
        } else {
            // Nếu bảng đã có, bổ sung club_id nếu thiếu
            Schema::table('events', function (Blueprint $table) {
                if (!Schema::hasColumn('events', 'club_id')) {
                    $table->foreignId('club_id')->after('id')->nullable()->constrained('clubs')->onDelete('cascade');
                }
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
