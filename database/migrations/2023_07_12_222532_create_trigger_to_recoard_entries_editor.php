<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $query = "CREATE TRIGGER trigger_to_recoard_entries_editor AFTER INSERT ON vital_details FOR EACH ROW BEGIN
        INSERT INTO patients_registered_by (vital_id,registeredBy) VALUES (NEW.visit_id,USER());
        END";
        // DB::statement('DROP TRIGGER IF EXISTS trigger_to_recoard_entries_editor');
        DB::statement($query);
    }

    public function down(): void
    {
        DB::statement('DROP TRIGGER IF EXISTS trigger_to_recoard_entries_editor');
    }
};
