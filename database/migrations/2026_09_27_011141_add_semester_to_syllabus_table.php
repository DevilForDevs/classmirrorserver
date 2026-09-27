<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('syllabus', function (Blueprint $table) {
            $table->unsignedTinyInteger('semester')->after('session');
        });
    }

    public function down(): void
    {
        Schema::table('syllabus', function (Blueprint $table) {
            $table->dropColumn('semester');
        });
    }
};
