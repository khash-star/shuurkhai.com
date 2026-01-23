# Fix 403 Forbidden Error - Production Server

## Асуудал
Production server дээр `https://shuurkhai.com/shuurkhai_new/` хандахад 403 Forbidden алдаа гарч байна.

## Шалтгаан
1. `.htaccess` файлын `RewriteBase` буруу байсан (одоо зассан)
2. `.htaccess` файлын permissions буруу байж магадгүй
3. Apache mod_rewrite идэвхгүй байж магадгүй

## Засах арга

### 1. cPanel дээр Git Pull хийх
cPanel → Git Version Control → `shuurkhai_new` → **"Pull or Deploy"** → **"Update from Remote"**

Эсвэл SSH ашиглах:
```bash
cd ~/public_html/shuurkhai_new
git pull new_origin main
```

### 2. .htaccess файлын permissions шалгах
```bash
cd ~/public_html/shuurkhai_new
chmod 644 .htaccess
```

### 3. Directory permissions шалгах
```bash
chmod 755 ~/public_html/shuurkhai_new
```

### 4. .htaccess файл шалгах
`.htaccess` файл дараах байдлаар байх ёстой:
```apache
DirectoryIndex index.php
RewriteEngine On
RewriteBase /shuurkhai_new/

# ... бусад rules
```

### 5. Apache mod_rewrite идэвхтэй эсэхийг шалгах
cPanel → **"Software"** → **"Select PHP Version"** → **"Extensions"** → `mod_rewrite` идэвхтэй эсэхийг шалгах

### 6. Error Log шалгах
cPanel → **"Metrics"** → **"Errors"** эсвэл **"Error Log"**
- Ямар алдаа гарч байгааг харах

## Хэрэв асуудал үргэлжлэх бол:

### Арга 1: .htaccess файлыг түр хасах
```bash
cd ~/public_html/shuurkhai_new
mv .htaccess .htaccess.bak
```
Дараа нь browser дээр шалгах. Хэрэв ажиллавал .htaccess файлд асуудал байна.

### Арга 2: .htaccess файлыг дахин үүсгэх
```bash
cd ~/public_html/shuurkhai_new
cat > .htaccess << 'EOF'
DirectoryIndex index.php
RewriteEngine On
RewriteBase /shuurkhai_new/

RewriteCond %{REQUEST_FILENAME} -f [OR]
RewriteCond %{REQUEST_FILENAME} -d
RewriteRule ^ - [L]

RewriteRule ^$ index.php [L]
RewriteRule ^login/?$ admin/login.php [L]
EOF
chmod 644 .htaccess
```

### Арга 3: cPanel Support-д хандах
Хэрэв дээрх аргууд ажиллахгүй бол hosting provider-ийн support-д хандах.

## Шалгах
Browser дээр:
- `https://shuurkhai.com/shuurkhai_new/` - нүүр хуудас
- `https://shuurkhai.com/shuurkhai_new/user/login` - login хуудас
