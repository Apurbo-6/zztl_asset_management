<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('assets', function (Blueprint $table) {

            $table->foreignId('purchase_id')
                ->nullable()
                ->after('id')
                ->constrained('purchases')
                ->nullOnDelete();

            $table->enum('status', [
                'available',
                'assigned',
                'maintenance',
                'damaged',
                'disposed'
            ])
                ->default('available')
                ->after('remarks');
        });
    }

    public function down(): void
    {
        Schema::table('assets', function (Blueprint $table) {

            $table->dropForeign(['purchase_id']);

            $table->dropColumn([
                'purchase_id',
                'status'
            ]);
        });
    }
};
