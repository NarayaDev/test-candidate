<?php

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->safeLoad();

$supabaseUrl = getenv('SUPABASE_URL');
$supabaseKey = getenv('SUPABASE_KEY');
$table = getenv('SUPABASE_TABLE') ?: 'your_table_name';

if (!$supabaseUrl || !$supabaseKey) {
    fwrite(STDERR, "ERROR: SUPABASE_URL and SUPABASE_KEY must be set in .env\n");
    exit(1);
}

try {
    $client = new SupabaseExample\SupabaseClient($supabaseUrl, $supabaseKey);
    $rows = $client->fetchTable($table);

    echo "Connected to Supabase and fetched " . count($rows) . " row(s) from table '$table'.\n\n";
    echo json_encode($rows, JSON_PRETTY_PRINT) . "\n";
} catch (Exception $exception) {
    fwrite(STDERR, "ERROR: " . $exception->getMessage() . "\n");
    exit(1);
}
