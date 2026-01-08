<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   // database/migrations/xxxx_xx_xx_xxxxxx_add_alasan_penolakan_to_appointments_table.php

public function up(): void
{
    Schema::table('appointments', function (Blueprint $table) {
        $table->text('alasan_penolakan')->nullable()->after('status'); // Tambah kolom ini
    });
}

public function down(): void
{
    Schema::table('appointments', function (Blueprint $table) {
        $table->dropColumn('alasan_penolakan'); // Untuk rollback
    });
}
};
