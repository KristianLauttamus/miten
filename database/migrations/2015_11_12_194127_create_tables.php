<?php

use Illuminate\Database\Migrations\Migration;

class CreateTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $script_path = "database/sql";
        $command = "mysql -U " . env('DB_USERNAME') . " -P " . env('DB_PASSWORD') . " -D " . env('DB_DATABASE') . " -a -f ";
        shell_exec($command . $script_path . '/create_tables.sql');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $script_path = "database/sql";
        $command = "mysql -U " . env('DB_USERNAME') . " -P " . env('DB_PASSWORD') . " -D " . env('DB_DATABASE') . " -a -f ";
        shell_exec($command . $script_path . '/drop_tables.sql');
    }
}
