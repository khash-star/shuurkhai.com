# Fix 403 Forbidden - .htaccess File Issue

## Асуудал
"Server unable to read htaccess file, denying access to be safe" - 403 Forbidden алдаа

## Шалтгаан
1. `.htaccess` файлын permissions буруу
2. `.htaccess` файлд syntax алдаа
3. Directory permissions буруу

## Засах арга

### Арга 1: cPanel File Manager ашиглах

1. **cPanel → File Manager**
2. **`public_html/shuurkhai_new/.htaccess`** файлыг олох
3. **Right-click → Change Permissions**
4. **Permissions: `644`** тохируулах
5. **Save**

### Арга 2: SSH/Terminal ашиглах

```bash
cd ~/public_html/shuurkhai_new
chmod 644 .htaccess
chmod 755 .
```

### Арга 3: .htaccess файлыг дахин үүсгэх

Хэрэв дээрх аргууд ажиллахгүй бол .htaccess файлыг дахин үүсгэх:

**cPanel File Manager дээр:**
1. `.htaccess` файлыг устгах (эсвэл `.htaccess.bak` болгож backup хийх)
2. Шинэ `.htaccess` файл үүсгэх
3. Дараах агуулгыг оруулах:

```apache
DirectoryIndex index.php
RewriteEngine On
RewriteBase /shuurkhai_new/

# --- STOP rewriting if real file or directory ---
RewriteCond %{REQUEST_FILENAME} -f [OR]
RewriteCond %{REQUEST_FILENAME} -d
RewriteRule ^ - [L]

# --- ROOT ---
RewriteRule ^$ index.php [L]

# --- PUBLIC PAGES ---
RewriteRule ^index/?$ index.php [L]
RewriteRule ^contact/?$ contact.php [L]
RewriteRule ^faqs/?$ faqs.php [L]
RewriteRule ^news/?$ news.php [L]
RewriteRule ^about/?$ about.php [L]
RewriteRule ^shop/?$ shop.php [QSA,L]
RewriteRule ^calculator/?$ calculator.php [L]
RewriteRule ^qpay/?$ qpay.php [L]
RewriteRule ^privacy/?$ privacy.php [L]

# --- LOGIN ---
RewriteRule ^login/?$ admin/login.php [L]

# --- AGENT / ADMIN ---
RewriteRule ^agent/?$ admin/agents.php [L]

# --- HOME NEW (optional direct access) ---
RewriteRule ^home-new/?$ shuurkhai-home/home-test.php [L]
```

4. **Permissions: `644`** тохируулах
5. **Save**

### Арга 4: .htaccess файлыг түр хасах (Test)

```bash
cd ~/public_html/shuurkhai_new
mv .htaccess .htaccess.bak
```

Browser дээр шалгах. Хэрэв ажиллавал .htaccess файлд асуудал байна.

## Шалгах

1. **Permissions шалгах:**
   ```bash
   ls -la ~/public_html/shuurkhai_new/.htaccess
   # Output: -rw-r--r-- (644) байх ёстой
   ```

2. **Browser дээр шалгах:**
   - `https://shuurkhai.com/shuurkhai_new/`
   - Хэрэв ажиллавал ✅
   - Хэрэв 403 алдаа үргэлжлэх бол дараагийн алхмууд

## Хэрэв асуудал үргэлжлэх бол:

### 1. Apache mod_rewrite идэвхтэй эсэхийг шалгах
cPanel → **"Software"** → **"Select PHP Version"** → **"Extensions"** → `mod_rewrite` идэвхтэй эсэхийг шалгах

### 2. Error Log шалгах
cPanel → **"Metrics"** → **"Errors"** эсвэл **"Error Log"**
- Ямар алдаа гарч байгааг харах

### 3. Directory permissions шалгах
```bash
chmod 755 ~/public_html/shuurkhai_new
chmod 755 ~/public_html/shuurkhai_new/admin
chmod 755 ~/public_html/shuurkhai_new/user
```

### 4. cPanel Support-д хандах
Хэрэв дээрх бүх аргууд ажиллахгүй бол hosting provider-ийн support-д хандах

## Анхаарах зүйлс

- `.htaccess` файлын permissions: **644** (readable by web server)
- Directory permissions: **755** (executable by web server)
- `.htaccess` файлд syntax алдаа байх ёсгүй
- RewriteBase path зөв байх ёстой: `/shuurkhai_new/`
