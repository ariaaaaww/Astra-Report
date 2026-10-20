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
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'role')) {
                $table->string('role')->after('password')->change();
            }
            if (Schema::hasColumn('users', 'dealer_id')) {
                $table->dropForeign(['dealer_id']);

                $table->foreignId('dealer_id')
                    ->nullable()
                    ->after('role')
                    ->change()
                    ->constrained('dealers');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'dealer_id')) {
                $table->dropForeign(['dealer_id']);
                $table->dropColumn('dealer_id');
            }
            if (Schema::hasColumn('users', 'role')) {
                $table->dropColumn('role');
            }
        });
    }
};
