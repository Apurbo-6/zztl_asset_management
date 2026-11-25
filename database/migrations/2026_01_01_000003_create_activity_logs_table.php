<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $t->string('module', 100);
            $t->string('action', 100);
            $t->text('description')->nullable();
            $t->json('old_values')->nullable();
            $t->json('new_values')->nullable();
            $t->string('ip_address', 45)->nullable();
            $t->timestamp('created_at')->useCurrent();
            $t->index(['module', 'action', 'created_at']);
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
