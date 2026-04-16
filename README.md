# PHP Supabase Connection Example

This workspace demonstrates how to connect to Supabase from PHP using the REST API.

## Setup

1. Install dependencies:
   ```bash
   composer install
   ```

2. Copy the example environment file:
   ```bash
   cp .env.example .env
   ```

3. Update `.env` with your Supabase project values:
   - `SUPABASE_URL`
   - `SUPABASE_KEY`
   - `SUPABASE_TABLE`

## Run

```bash
php src/connect.php
```

## Product page

1. Install dependencies:
   ```bash
   composer install
   ```
2. Run the built-in PHP server from the project root:
   ```bash
   php -S localhost:8000 -t public
   ```
3. Open in your browser:
   ```text
   http://localhost:8000/product.php
   ```

## Notes

- Use the `anon` or `service_role` key based on the operation and permissions needed.
- `SUPABASE_TABLE` should match a table in your Supabase project.
- This example queries the first 5 rows from the configured table and prints the result.
