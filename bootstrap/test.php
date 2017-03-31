<?php

require 'autoload.php';

if (! exec('php ' . __DIR__ . '/../artisan migrate:refresh --database=testing --seeder="Tests\Database\Seeds\TestDatabaseSeeder"', $output)) {
    echo "There was an error bootstraping the tests:\n";
    echo implode("\n", $output);
    die();
}
