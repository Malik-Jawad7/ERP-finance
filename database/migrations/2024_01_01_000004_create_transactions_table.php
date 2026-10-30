<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create("transactions", function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->string("reference")->nullable();
            $table->enum("type", ["income","expense","payout"]);
            $table->decimal("amount", 12, 2);
            $table->date("occurred_at");
            $table->timestamps();
            $table->softDeletes(); // Added here safely
        });
    }
    public function down(): void { Schema::dropIfExists("transactions"); }
};