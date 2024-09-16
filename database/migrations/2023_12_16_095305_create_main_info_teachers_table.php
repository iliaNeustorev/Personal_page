<?php

use App\Models\User;
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
        Schema::create('main_info_teachers', function (Blueprint $table) {
            $table->id();
            $table->text('quotes')->nullable();
            $table->text('education')->nullable();
            $table->text('teaching_experience')->nullable();
            $table->text('teaching_category')->nullable();
            $table->text('personal_slogan')->nullable();
            $table->text('credo')->nullable();
            $table->json('working_principles')->nullable();
            $table->json('personal_qualities')->nullable();
            $table->string('personal_email_teacher', 64)->nullable();
            $table->text('kindergarten_in_place_work')->nullable();
            $table->string('address_kindergarten', 255)->nullable();
            $table->string('phone_kindergarten', 64)->nullable();
            $table->boolean('active')->default(0);
            $table->foreignIdFor(User::class)
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('main_info_teachers');
    }
};
