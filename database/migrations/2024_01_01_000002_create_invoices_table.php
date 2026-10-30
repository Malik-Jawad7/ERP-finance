<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create("invoices", function (Blueprint $table) {
            $table->id();
            $table->string("invoice_no")->unique();
            $table->foreignId("client_id")->constrained()->cascadeOnDelete();
            $table->decimal("amount", 12, 2);
            $table->decimal("tax", 12, 2)->default(0);
            $table->decimal("total", 12, 2);
            $table->enum("status", ["draft","sent","paid","overdue","cancelled"])->default("draft");
            $table->date("issued_at");
            $table->date("due_at")->nullable();
            $table->timestamps();
            $table->softDeletes(); // Added here safely
        });
    }
    public function down(): void { Schema::dropIfExists("invoices"); }
};