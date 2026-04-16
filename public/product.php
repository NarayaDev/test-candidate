<?php

require_once __DIR__ . '/../vendor/autoload.php';

$envPath = __DIR__ . '/..';
$dotenv = Dotenv\Dotenv::createImmutable($envPath);
$dotenv->safeLoad();

function env(string $name): ?string
{
    $value = getenv($name);
    if ($value !== false) {
        return $value;
    }

    if (isset($_ENV[$name]) && $_ENV[$name] !== '') {
        return $_ENV[$name];
    }

    if (isset($_SERVER[$name]) && $_SERVER[$name] !== '') {
        return $_SERVER[$name];
    }

    return null;
}

$supabaseUrl = env('SUPABASE_URL');
$supabaseKey = env('SUPABASE_KEY');
$table = env('SUPABASE_TABLE') ?: 'products';

if (!$supabaseUrl || !$supabaseKey) {
    http_response_code(500);
    echo '<h1>Configuration error</h1>';
    echo '<p>SUPABASE_URL and SUPABASE_KEY must be set in .env.</p>';
    echo '<p>Expected .env path: ' . htmlspecialchars($envPath . '/.env', ENT_QUOTES, 'UTF-8') . '</p>';
    exit;
}

try {
    $client = new SupabaseExample\SupabaseClient($supabaseUrl, $supabaseKey);
    $products = $client->fetchTable($table, ['limit' => 50]);
} catch (Exception $exception) {
    http_response_code(500);
    echo '<h1>Supabase request failed</h1>';
    echo '<p>' . htmlspecialchars($exception->getMessage(), ENT_QUOTES, 'UTF-8') . '</p>';
    exit;
}

?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 2rem; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 0.75rem; text-align: left; }
        th { background: #f3f3f3; }
        tr:nth-child(even) { background: #fafafa; }
        .empty { color: #555; }
    </style>
</head>
<body>
    <h1>Products</h1>
    <p>  connected to database </p>
 
</body>
</html>
