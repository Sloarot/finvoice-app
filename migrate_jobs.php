<?php

/**
 * Migration script to transfer job data from old database to new Laravel database
 * Run this ONCE via command line: php migrate_jobs.php
 * Or access via browser: https://fintrasc.be/finvoice2026/migrate_jobs.php
 */

// Old database connection
$old_host = "localhost";
$old_username = "u993307518_old_user";
$old_password = "Lehendakari83@";
$old_dbname = "u993307518_old";

// New database connection
$new_host = "localhost";
$new_username = "u993307518_fin";
$new_password = "QeJB5/4Q2A8q";
$new_dbname = "u993307518_fin";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    // Connect to old database
    $old_conn = new PDO("mysql:host=$old_host;dbname=$old_dbname;charset=utf8mb4", $old_username, $old_password);
    $old_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✓ Connected to old database\n<br>";

    // Connect to new database
    $new_conn = new PDO("mysql:host=$new_host;dbname=$new_dbname;charset=utf8mb4", $new_username, $new_password);
    $new_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✓ Connected to new database\n<br>";

    // First, build a mapping of client names to client IDs
    echo "\nBuilding client name to ID mapping...\n<br>";
    $client_map = [];

    // Get all clients from new database
    $stmt = $new_conn->query("SELECT id, client_name FROM clients");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $client_map[$row['client_name']] = $row['id'];
    }
    echo "✓ Found " . count($client_map) . " clients in new database\n<br>";

    // Fetch all jobs from old database
    $stmt = $old_conn->query("SELECT * FROM jobs ORDER BY job_id");
    $jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "✓ Found " . count($jobs) . " jobs in old database\n<br><br>";

    // Prepare insert statement for new database
    $insert_sql = "INSERT INTO translation_jobs
        (po_number, service, title, quantity, price, vat, total_price, deadline, completed_at, client_id, invoice_id, is_on_invoice, created_at, updated_at)
        VALUES
        (:po_number, :service, :title, :quantity, :price, :vat, :total_price, :deadline, :completed_at, :client_id, :invoice_id, :is_on_invoice, :created_at, :updated_at)";

    $insert_stmt = $new_conn->prepare($insert_sql);

    $success_count = 0;
    $error_count = 0;
    $skipped_count = 0;

    // Process each job
    foreach ($jobs as $job) {
        // Look up client_id from client name
        $client_name = $job['selected_client'];

        if (!isset($client_map[$client_name])) {
            echo "⚠ Skipped job #{$job['job_id']}: Client '{$client_name}' not found in new database\n<br>";
            $skipped_count++;
            continue;
        }

        $client_id = $client_map[$client_name];

        // Prepare data for insertion
        $data = [
            ':po_number' => $job['PO_number'] ?: null,
            ':service' => $job['services'] ?: null,
            ':title' => $job['project_name'] ?: null,
            ':quantity' => $job['number_of_words'] ?: 0,
            ':price' => $job['price_per_words'] ?: 0,
            ':vat' => $job['vat_job'] ?: 0,
            ':total_price' => $job['total_price_job'] ?: 0,
            ':deadline' => $job['deadline'] ?: null,
            ':completed_at' => $job['completion_date'] ?: null,
            ':client_id' => $client_id,
            ':invoice_id' => null, // Not on any invoice yet
            ':is_on_invoice' => null, // Not on any invoice yet
            ':created_at' => $job['starting_date'] ?: date('Y-m-d H:i:s'),
            ':updated_at' => date('Y-m-d H:i:s')
        ];

        try {
            $insert_stmt->execute($data);
            $success_count++;
            echo "✓ Migrated job #{$job['job_id']}: {$job['project_name']}\n<br>";
        } catch (PDOException $e) {
            echo "✗ Error migrating job #{$job['job_id']}: " . $e->getMessage() . "\n<br>";
            $error_count++;
        }
    }

    echo "\n<br><br><strong>Migration Summary:</strong>\n<br>";
    echo "✓ Successfully migrated: $success_count jobs\n<br>";
    echo "⚠ Skipped (client not found): $skipped_count jobs\n<br>";
    echo "✗ Errors: $error_count jobs\n<br>";
    echo "\n<br><strong>Migration complete!</strong>\n";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;
}
