<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        $tables = ["clients", "invoices", "expenses", "transactions", "payrolls", "accounts", "vendors", "departments", "employees", "projects"];
        
        foreach ($tables as $tableName) {
            if (Schema::hasTable($tableName) && !Schema::hasColumn($tableName, "user_id")) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->foreignId("user_id")->nullable()->after("id")->constrained()->cascadeOnDelete();
                });
            }
        }
    }
    public function down(): void {
        $tables = ["clients", "invoices", "expenses", "transactions", "payrolls", "accounts", "vendors", "departments", "employees", "projects"];
        foreach ($tables as $tableName) {
            if (Schema::hasColumn($tableName, "user_id")) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->dropForeign(["user_id"]);
                    $table->dropColumn("user_id");
                });
            }
        }
    }
};