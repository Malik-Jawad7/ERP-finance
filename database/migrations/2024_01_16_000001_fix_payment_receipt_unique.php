<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {
        // Purana global unique constraint hatayein
        try {
            DB::statement("ALTER TABLE payments DROP INDEX payments_receipt_no_unique");
        } catch (\Exception $e) {}

        // Naya composite unique lagayein (user_id + receipt_no)
        try {
            Schema::table("payments", function (Blueprint $table) {
                $table->unique(["user_id", "receipt_no"], "user_payment_receipt_unique");
            });
        } catch (\Exception $e) {}
    }

    public function down(): void {
        Schema::table("payments", function (Blueprint $table) {
            $table->dropUnique("user_payment_receipt_unique");
        });
        Schema::table("payments", function (Blueprint $table) {
            $table->unique("receipt_no");
        });
    }
};