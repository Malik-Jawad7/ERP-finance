<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {
        // Purane enum ko update karke 'partial' add karein
        DB::statement("ALTER TABLE invoices MODIFY status ENUM('draft','sent','paid','overdue','cancelled','partial') NOT NULL DEFAULT 'draft'");
    }
    public function down(): void {
        DB::statement("ALTER TABLE invoices MODIFY status ENUM('draft','sent','paid','overdue','cancelled') NOT NULL DEFAULT 'draft'");
    }
};