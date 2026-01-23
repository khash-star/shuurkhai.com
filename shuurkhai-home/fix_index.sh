#!/bin/bash
# Production server дээр ажиллуулах скрипт
# Ашиглах: bash fix_index.sh

cd ~/public_html/shuurkhai_git

# Хуучин файлыг backup хийх
if [ -f index.php ]; then
    cp index.php index.php.old.$(date +%Y%m%d_%H%M%S)
    echo "✓ Хуучин index.php backup хийгдлээ"
fi

# Git-аас шинэ код татах
echo "Git-аас шинэ код татаж байна..."
git fetch origin
git checkout origin/main -- index.php

if [ $? -eq 0 ]; then
    echo "✓ index.php файл амжилттай шинэчлэгдлээ!"
    echo "✓ Browser дээр refresh хийгээрэй: https://shuurkhai.com/shuurkhai_git/"
else
    echo "✗ Алдаа гарлаа. Git status шалгана уу."
    exit 1
fi
