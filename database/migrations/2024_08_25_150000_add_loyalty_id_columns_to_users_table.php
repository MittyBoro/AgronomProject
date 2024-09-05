<?php

use App\Models\Loyalty;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table
                ->foreignId('loyalty_id')
                ->after('role')
                ->nullable()
                ->constrained()
                ->nullOnDelete();
            //
        });

        $loyalty = Loyalty::orderBy('percent', 'asc')->first();
        if ($loyalty) {
            User::query()->update(['loyalty_id' => $loyalty->id]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->dropForeign(['loyalty_id']);
            $table->dropColumn('loyalty_id');
        });
    }
};
