<?php

use App\Models\Faux\Group;
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
        Schema::create('students', function (Blueprint $table) {
            $table->id();

            /**
             * NOTE: constrained and cascade delete/update options wasn't used intentionally
             * because some of students may not belong to any group.
             * Moreover, according the task any group wasn't modified/deleted/updated after creating.
             */
            $table->foreignIdFor(Group::class)
                ->index()
                ->nullable();

            $table->string('first_name');
            $table->string('last_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
