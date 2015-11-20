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
        $command = "sudo psql -h localhost -U " . env('DB_USERNAME') . " -d " . env('DB_DATABASE') . " -a -W -f ";
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
        $command = "sudo psql -h localhost -U " . env('DB_USERNAME') . " -d " . env('DB_DATABASE') . " -a -W -f ";
        shell_exec($command . $script_path . '/drop_tables.sql');
    }
}
