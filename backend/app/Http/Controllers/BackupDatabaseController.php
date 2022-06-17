<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;

class BackupDatabaseController extends Controller
{
    public function backup(Request $request)
    {
        //Database backup
        // try {

            // SQL

            // \Spatie\DbDumper\Databases\MySql::create()
            // ->setDbName(env('DB_DATABASE'))
            // ->setUserName(env('DB_USERNAME'))
            // ->setPassword(env('DB_PASSWORD'))
            // ->dumpToFile('dump.sql');

            // POSTGRE

            // \Spatie\DbDumper\Databases\PostgreSql::create()
            //     ->setDumpBinaryPath('D:\\2021')
            //     ->setDbName(env('DB_DATABASE'))
            //     ->setUserName(env('DB_USERNAME'))
            //     ->setPassword(env('DB_PASSWORD'))
            //     ->dumpToFile('dump.sql');

            // $filename = 'dump.sql';
            
            \Spatie\DbDumper\Databases\Sqlite::create()
                ->setDbName(database_path('database.sqlite'))
                ->dumpToFile('dump.sql');
            $file = 'dump.sql';

            return response()->json(['statuscode' => 200, 'file' => $file]);

        // } catch (Exception $e) {
        //     return response()->json(['statuscode' => $e]);
        // }
    }

}
