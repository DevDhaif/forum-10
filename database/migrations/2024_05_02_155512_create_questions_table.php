<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('body');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('channel_id');
            $table->unsignedInteger('answers_count')->default(0);
            $table->unsignedInteger('votes_count')->default(0);
            $table->unsignedInteger('visits')->default(0);
            $table->unsignedInteger('is_answered')->default(0);
            $table->unsignedBigInteger('best_answer_id')->nullable();
            $table->boolean('is_solved')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('channel_id')->references('id')->on('channels')->onDelete('cascade');
            $table->foreign('best_answer_id')->references('id')->on('answers')->onDelete('set null');

            $table->index('user_id');
            $table->index('channel_id');
            $table->index('is_answered');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
