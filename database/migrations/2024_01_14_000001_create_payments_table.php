<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create("payments", function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId("invoice_id")->constrained()->cascadeOnDelete();
            $table->string("receipt_no")->unique();
            $table->decimal("amount", 15, 2);
            $table->enum("method", ["cash", "bank_transfer", "card", "cheque", "online"])->default("cash");
            $table->string("reference")->nullable();
            $table->date("paid_at");
            $table->text("notes")->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
    public function down(): void { Schema::dropIfExists("payments"); }
};