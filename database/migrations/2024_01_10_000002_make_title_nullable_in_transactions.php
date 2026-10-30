<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        if (Schema::hasColumn("transactions", "title")) {
            Schema::table("transactions", function (Blueprint $table) {
                $table->string("title")->nullable()->change();
            });
        }
    }
    public function down(): void {}
};