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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->string('title');
            $table->text('content');
            $table->string('image')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('inactive');
            $table->timestamps();

            // Note: We can add the following index (it is depands on system requirements)
            /*$table->unique([
                'user_id',
                'content'
            ]);*/

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
