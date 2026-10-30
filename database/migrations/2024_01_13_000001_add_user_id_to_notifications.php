<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // Add user_id to custom_notifications
        if (!Schema::hasColumn("custom_notifications", "user_id")) {
            Schema::table("custom_notifications", function (Blueprint $table) {
                $table->foreignId("user_id")->nullable()->after("id")->constrained()->cascadeOnDelete();
            });
        }
    }
    public function down(): void {
        Schema::table("custom_notifications", function (Blueprint $table) {
            $table->dropForeign(["user_id"]);
            $table->dropColumn("user_id");
        });
    }
};