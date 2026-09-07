<?php

use App\Models\Project;
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
        Schema::create('projects_users', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Project::class, 'project_id')
                ->constrained('projects')
                ->cascadeOnDelete();
            $table->foreignIdFor(User::class, 'member_id')
                ->constrained('users')
                ->cascadeOnDelete();
            $table->unique(['project_id', 'member_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects_users');
    }
};
