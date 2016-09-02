<?php

namespace TypeRocket\Console\Commands;

use TypeRocket\Console\Command;

class Migrate extends Command
{
    protected $command = [
        'wp:sql',
        'WordPress database SQL script',
        'This command runs a WordPress database SQL script.',
    ];

    protected function config()
    {
        $this->addArgument('name', self::REQUIRED, 'The name of the SQL script to run.');
    }

    /**
     * Execute Command
     *
     * Example command: php galaxy wp:sql my_script
     *
     * @return int|null|void
     */
    protected function exec()
    {
        /** @var \wpdb $wpdb */
        global $wpdb;

        $name = $this->getArgument('name');

        $file_sql = TR_PATH . '/sql/' . $name . '.sql';

        if( ! file_exists( $file_sql ) ) {
            $this->error('Not Found: SQL '. $name .' failed to run.');
            return;
        }

        $sql = file_get_contents($file_sql);

        if ( $wpdb->query( $sql ) ) {
            $this->success('SQL '. $name .' successfully run.');
        } else {
            $this->error('Query Error: SQL '. $name .' failed to run.');
        }
    }
}