<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asset_assignments', function (Blueprint $table) {

            $table->id();

            $table->foreignId('asset_id')
                ->constrained('assets')
                ->cascadeOnDelete();

            $table->foreignId('department_id')
                ->nullable()
                ->constrained('departments')
                ->nullOnDelete();

            $table->string('assigned_to', 150)->nullable();

            $table->date('assigned_date');

            $table->date('returned_date')->nullable();

            $table->enum('status', [
                'assigned',
                'returned'
            ])->default('assigned');

            $table->text('remarks')->nullable();

            $table->foreignId('assigned_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            $table->index(['asset_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asset_assignments');
    }
};
