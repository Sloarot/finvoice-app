#!/bin/bash
# Server Refresh Script - Run this after git pull on your server

echo "=== Clearing Laravel Caches ==="
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

echo ""
echo "=== Clearing OPcache (if enabled) ==="
# This will work if you have a web-accessible script
# Or run: sudo systemctl reload php8.x-fpm (adjust version)

echo ""
echo "=== Verifying files exist ==="
ls -la resources/views/translation-jobs/index.blade.php
ls -la resources/views/components/table.blade.php

echo ""
echo "=== Checking for sorting code ==="
grep -q "@push('scripts')" resources/views/translation-jobs/index.blade.php && echo "✓ JavaScript found" || echo "✗ JavaScript NOT found"
grep -q "sortable-table" resources/views/components/table.blade.php && echo "✓ Table ID found" || echo "✗ Table ID NOT found"

echo ""
echo "=== Done! Now try hard-refresh in browser (Ctrl+F5) ==="
