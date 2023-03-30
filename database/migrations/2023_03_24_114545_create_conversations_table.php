<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('conversations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignUuid('group_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->integer('group_privilege');
//            $table->foreignUuid('group_privilege_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->boolean('is_mute')->default(false);
            $table->boolean('is_favorite')->default(false);
            $table->integer('status');
            $table->float('rate')->default(0);
            $table->timestamp('last_time_open_group')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conversations');
    }
};
