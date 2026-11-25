<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {

        Schema::table('categories', function (Blueprint $table) {
            $table->string('code', 20)->nullable()->unique();
            $table->boolean('serial_required')->default(false);
        });

        Schema::table('assets', function (Blueprint $table) {
            $table->string('asset_code', 40)->nullable()->unique();
        });

        Schema::table('purchases', function (Blueprint $table) {
            $table->dateTime('purchased_at')->nullable();
            $table->decimal('shipping_charge', 14, 2)->default(0);
            $table->decimal('extra_charge', 14, 2)->default(0);
            $table->string('extra_charge_description', 255)->nullable();
        });

        Schema::create('purchase_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_id')->constrained()->cascadeOnDelete();
            $table->string('original_file_name')->nullable();
            $table->string('stored_file_name');
            $table->string('file_path', 500);
            $table->string('mime_type', 100)->nullable();
            $table->unsignedBigInteger('original_size')->nullable();
            $table->unsignedBigInteger('compressed_size')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        // Backfill readable category codes and permanent asset tags for existing records.
        foreach (DB::table('categories')->orderBy('id')->get() as $category) {
            $base = strtoupper(preg_replace('/[^A-Z0-9]/', '', $category->name));
            $code = substr($base ?: 'CAT', 0, 20);
            $candidate = $code;
            $suffix = 1;
            while (DB::table('categories')->where('code', $candidate)->exists()) {
                $tail = (string) $suffix++;
                $candidate = substr($code, 0, 20 - strlen($tail)) . $tail;
            }
            DB::table('categories')->where('id', $category->id)->update(['code' => $candidate]);
        }

        foreach (DB::table('assets')->orderBy('id')->get() as $asset) {
            $code = DB::table('categories')->where('id', $asset->category_id)->value('code') ?: 'CAT';
            DB::table('assets')->where('id', $asset->id)->update([
                'asset_code' => 'ZZTL-' . $code . '-' . str_pad((string) $asset->id, 7, '0', STR_PAD_LEFT),
            ]);
        }

        foreach (DB::table('purchases')->whereNull('purchased_at')->get(['id', 'purchase_date']) as $purchase) {
            DB::table('purchases')->where('id', $purchase->id)->update([
                'purchased_at' => $purchase->purchase_date . ' 00:00:00',
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase_attachments');
        Schema::table('purchases', function (Blueprint $table) {
            $table->dropColumn(['purchased_at', 'shipping_charge', 'extra_charge', 'extra_charge_description']);
        });
        Schema::table('assets', function (Blueprint $table) {
            $table->dropUnique(['asset_code']);
            $table->dropColumn('asset_code');
        });
        Schema::table('categories', function (Blueprint $table) {
            $table->dropUnique(['code']);
            $table->dropColumn(['code', 'serial_required']);
        });
    }
};
