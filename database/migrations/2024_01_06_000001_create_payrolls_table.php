<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create("payrolls", function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->constrained()->cascadeOnDelete();
            $table->string("month"); // e.g., "October 2026"
            $table->decimal("basic_salary", 12, 2);
            $table->decimal("allowances", 12, 2)->default(0);
            $table->decimal("deductions", 12, 2)->default(0);
            $table->decimal("net_salary", 12, 2);
            $table->enum("status", ["pending", "paid"])->default("pending");
            $table->date("payment_date")->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
    public function down(): void { Schema::dropIfExists("payrolls"); }
};