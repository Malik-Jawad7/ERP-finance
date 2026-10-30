<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table("transactions", function (Blueprint $table) {
            // Check karein ke column pehle se hai ya nahi
            if (!Schema::hasColumn("transactions", "account_id")) {
                $table->foreignId("account_id")->nullable()->after("reference")->constrained()->nullOnDelete();
            }
            if (!Schema::hasColumn("transactions", "vendor_id")) {
                $table->foreignId("vendor_id")->nullable()->after("account_id")->constrained()->nullOnDelete();
            }
            if (!Schema::hasColumn("transactions", "description")) {
                $table->text("description")->nullable()->after("vendor_id");
            }
            if (!Schema::hasColumn("transactions", "reference")) {
                $table->string("reference")->unique()->nullable()->after("id");
            }
            if (!Schema::hasColumn("transactions", "deleted_at")) {
                $table->softDeletes();
            }
        });
    }

    public function down(): void
    {
        Schema::table("transactions", function (Blueprint $table) {
            $table->dropForeign(["account_id"]);
            $table->dropForeign(["vendor_id"]);
            $table->dropColumn(["account_id", "vendor_id", "description"]);
        });
    }
};