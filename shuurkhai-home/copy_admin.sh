#!/bin/bash
# Production server дээр ажиллуулах скрипт
# Admin directory-г хуучин сайтаас хуулах

cd ~/public_html/shuurkhai_git

echo "=== Admin directory хуулах ==="

# 1. Хуучин сайтаас admin хуулах
if [ -d ~/public_html/shuurkhai/admin ]; then
    echo "Хуучин сайтаас admin хуулж байна..."
    cp -r ~/public_html/shuurkhai/admin ./
    echo "✓ Admin directory хуулагдлаа"
elif [ -d ~/public_html/admin ]; then
    echo "~/public_html/admin-аас хуулж байна..."
    cp -r ~/public_html/admin ./
    echo "✓ Admin directory хуулагдлаа"
else
    echo "⚠ Хуучин admin directory олдсонгүй"
    echo "Хуучин сайтын байршлыг шалгана уу:"
    find ~/public_html -name "admin" -type d 2>/dev/null | head -5
    exit 1
fi

# 2. Эрх өгөх
chmod -R 755 admin/
find admin -type f -exec chmod 644 {} \;
echo "✓ Эрх өгөгдлөө"

# 3. admin/login.php path-уудыг засах
if [ -f admin/login.php ]; then
    echo "admin/login.php path-уудыг засаж байна..."
    
    # Backup хийх
    cp admin/login.php admin/login.php.backup
    
    # Path-уудыг засах
    sed -i "s|require_once(\"config.php\");|require_once(__DIR__ . \"/../config.php\");|g" admin/login.php
    sed -i "s|require_once(\"views/helper.php\");|require_once(__DIR__ . \"/../views/helper.php\");|g" admin/login.php
    sed -i "s|require_once(\"views/init.php\");|require_once(__DIR__ . \"/../views/init.php\");|g" admin/login.php
    
    echo "✓ admin/login.php path-ууд засагдлаа"
else
    echo "⚠ admin/login.php олдсонгүй"
fi

# 4. Шалгах
echo ""
echo "=== Шалгалт ==="
if [ -d admin ]; then
    echo "✓ admin/ directory байна"
    ls -la admin/ | head -10
else
    echo "✗ admin/ directory байхгүй"
fi

if [ -f admin/login.php ]; then
    echo "✓ admin/login.php байна"
    echo "Эхний мөрүүд:"
    head -5 admin/login.php
else
    echo "✗ admin/login.php байхгүй"
fi

echo ""
echo "=== Бүх зүйл бэлэн! ==="
echo "Browser дээр test хийгээрэй: https://shuurkhai.com/shuurkhai_git/login"
