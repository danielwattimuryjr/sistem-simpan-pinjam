<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SchemaController extends Controller
{
    public function getTables()
    {
        $tables = DB::select('SHOW TABLES');

        $exclude = [
            "cache",
            "cache_locks",
            "failed_jobs",
            "job_batches",
            "jobs",
            "migrations",
            "password_reset_tokens",
            "permission_role",
            "permission_user",
            "permissions",
            "role_user",
            "roles",
            "sessions",
        ];

        $tableNames = [];

        foreach ($tables as $table) {
            foreach ($table as $name) {
                if (!in_array($name, $exclude)) {
                    $tableNames[] = $name;
                }
            }
        }

        return response()->json($tableNames);
    }

    public function getColumns($table)
    {
        if (!Schema::hasTable($table)) {
            return response()->json(['error' => 'Table not found'], 404);
        }

        $columns = Schema::getColumnListing($table);

        return response()->json($columns);
    }
}
