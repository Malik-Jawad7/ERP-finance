<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {
        // Pehle purana unique index hatao
        try {
            DB::statement('ALTER TABLE invoices DROP INDEX invoices_invoice_no_unique');
        } catch (\Exception $e) {
            // Agar index pehle se nahi hai, toh ignore karo
        }
        
        // Ab ek composite unique index lagao (user_id + invoice_no)
        // Isse har user ke paas apna INV-0001 ho sakta hai, lekin ek user ke andar duplicate nahi hoga
        try {
            Schema::table("invoices", function (Blueprint $table) {
                $table->unique(["user_id", "invoice_no"], "user_invoice_unique");
            });
        } catch (\Exception $e) {
            // Ignore if already exists
        }
    }
    public function down(): void {
        Schema::table("invoices", function (Blueprint $table) {
            $table->dropUnique("user_invoice_unique");
        });
        Schema::table("invoices", function (Blueprint $table) {
            $table->unique("invoice_no");
        });
    }
};