<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $t) {
            $t->id();
            $t->string('name', 150)->unique();
            $t->boolean('is_active')->default(true);
            $t->timestamps();
        });
        Schema::create('suppliers', function (Blueprint $t) {
            $t->id();
            $t->string('name', 200);
            $t->string('contact_person', 150)->nullable();
            $t->string('phone', 30)->nullable();
            $t->string('email', 150)->nullable();
            $t->text('address')->nullable();
            $t->boolean('is_active')->default(true);
            $t->timestamps();
            $t->softDeletes();
        });
        Schema::create('assets', function (Blueprint $t) {
            $t->id();
            $t->foreignId('category_id')->constrained()->restrictOnDelete();
            $t->foreignId('supplier_id')->nullable()->constrained()->nullOnDelete();
            $t->string('particular_items', 255);
            $t->date('purchase_date');
            $t->string('invoice_no', 100)->nullable();
            $t->string('serial_number', 255)->nullable();
            $t->string('brand_name', 150)->nullable();
            $t->decimal('qty', 12, 2)->default(1);
            $t->decimal('unit_price', 14, 2)->default(0);
            $t->decimal('total_price', 14, 2)->default(0);
            $t->string('warranty', 100)->nullable();
            $t->string('received_by', 150)->nullable();
            $t->text('remarks')->nullable();
            $t->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $t->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $t->timestamps();
            $t->softDeletes();
            $t->index(['category_id', 'purchase_date']);
            $t->index('supplier_id');
            $t->index('invoice_no');
            $t->index('serial_number');
            $t->index('brand_name');
        });
        Schema::create('asset_attachments', function (Blueprint $t) {
            $t->id();
            $t->foreignId('asset_id')->constrained()->cascadeOnDelete();
            $t->enum('attachment_type', ['invoice', 'item_image']);
            $t->string('original_file_name')->nullable();
            $t->string('stored_file_name');
            $t->string('file_path', 500);
            $t->string('mime_type', 100)->nullable();
            $t->unsignedBigInteger('original_size')->nullable();
            $t->unsignedBigInteger('compressed_size')->nullable();
            $t->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $t->timestamps();
            $t->index(['asset_id', 'attachment_type']);
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('asset_attachments');
        Schema::dropIfExists('assets');
        Schema::dropIfExists('suppliers');
        Schema::dropIfExists('categories');
    }
};
