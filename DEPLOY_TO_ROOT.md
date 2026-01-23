# Root Domain руу Deploy хийх (shuurkhai.com)

## Сонголт 1: shuurkhai_new-ийн файлуудыг Root руу Copy хийх (Зөвлөмж)

### Алхам 1: Backup хийх
```bash
cd ~/public_html
# Одоогийн файлуудыг backup хийх (хэрэв хэрэгтэй бол)
cp -r . ../backup_$(date +%Y%m%d)
```

### Алхам 2: shuurkhai_new-ийн файлуудыг Root руу Copy хийх
```bash
cd ~/public_html
# shuurkhai_new-ийн бүх файлуудыг root руу copy хийх
cp -r shuurkhai_new/* .
cp -r shuurkhai_new/.[!.]* . 2>/dev/null || true  # Hidden files
```

### Алхам 3: .htaccess файлыг Root-д тохируулах
Root `.htaccess` файл (`public_html/.htaccess`) дараах байдлаар байх ёстой:

```apache
DirectoryIndex index.php
RewriteEngine On
RewriteBase /

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

### Алхам 4: Бүх замуудыг `/` болгох
Бүх PHP файлууд дээрх `/shuurkhai_new/` замуудыг `/` болгох хэрэгтэй.

---

## Сонголт 2: Symbolic Link ашиглах (Илүү хурдан)

### Алхам 1: Root directory-ийн файлуудыг backup хийх
```bash
cd ~/public_html
mv index.php index.php.old
mv .htaccess .htaccess.old
```

### Алхам 2: Symbolic link үүсгэх
```bash
cd ~/public_html
ln -s shuurkhai_new/index.php index.php
ln -s shuurkhai_new/.htaccess .htaccess
```

### Алхам 3: .htaccess файлыг засах
`shuurkhai_new/.htaccess` файлд:
```apache
RewriteBase /
```

---

## Сонголт 3: Git Repository-г Root руу Clone хийх (Хамгийн цэвэрхэн)

### Алхам 1: Root directory-г цэвэрлэх (болгоомжтой!)
```bash
cd ~/public_html
# Зөвхөн хэрэгтэй файлуудыг backup хийх
mkdir -p ../backup_root
mv config.php ../backup_root/ 2>/dev/null || true
```

### Алхам 2: Git Repository-г Root руу Clone хийх
cPanel Git Version Control:
- Repository URL: `https://github.com/khash-star/shuurkhai_new.git`
- Repository Path: `public_html` (root directory)
- Repository Name: `shuurkhai_root`

Эсвэл SSH:
```bash
cd ~/public_html
git clone https://github.com/khash-star/shuurkhai_new.git temp
mv temp/* .
mv temp/.[!.]* . 2>/dev/null || true
rmdir temp
```

### Алхам 3: .htaccess файлыг засах
```apache
RewriteBase /
```

### Алхам 4: Бүх замуудыг `/` болгох
Бүх PHP файлууд дээрх `/shuurkhai_new/` замуудыг `/` болгох.

---

## Анхаарах зүйлс

1. **config.php файл** - Root дээр байх ёстой
2. **.htaccess файл** - RewriteBase `/` байх ёстой
3. **Бүх замууд** - `/shuurkhai_new/` биш `/` байх ёстой
4. **Backup хийх** - Одоогийн файлуудыг backup хийх

---

## Хамгийн хялбар арга (cPanel File Manager)

1. **cPanel → File Manager**
2. **`public_html/shuurkhai_new`** directory-г нээх
3. **Бүх файлуудыг сонгох** (Ctrl+A)
4. **Copy хийх**
5. **`public_html` root directory руу буцах**
6. **Paste хийх**
7. **`.htaccess` файлыг edit хийж RewriteBase `/` болгох**
8. **Бүх PHP файлууд дээрх `/shuurkhai_new/` замуудыг `/` болгох**
