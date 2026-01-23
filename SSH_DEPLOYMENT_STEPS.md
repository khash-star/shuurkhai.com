# SSH Deployment - Алхам Алхмаар Заавар

## 📋 Алхам 1: SSH Key үүсгэх (Local Machine дээр)

### Windows PowerShell эсвэл Git Bash дээр:

```powershell
# SSH key үүсгэх
ssh-keygen -t ed25519 -C "your_email@example.com"

# Enter дарах (default location: C:\Users\YourName\.ssh\id_ed25519)
# Password оруулах (optional, гэхдээ сайн байх)

# Public key-г харах (copy хийх)
type %USERPROFILE%\.ssh\id_ed25519.pub
```

**Эсвэл Git Bash дээр:**
```bash
ssh-keygen -t ed25519 -C "your_email@example.com"
cat ~/.ssh/id_ed25519.pub
```

**Public key нь иймэрхүү харагдана:**
```
ssh-ed25519 AAAAC3NzaC1lZDI1NTE5AAAAI... your_email@example.com
```

---

## 📋 Алхам 2: cPanel дээр SSH Key нэмэх

1. **cPanel нээх:**
   - `https://shuurkhai.com:2083` (эсвэл hosting provider-ийн URL)
   - cPanel login: `r2c69it0btr1`

2. **SSH Keys хэсэг олох:**
   - cPanel дээр "SSH Access" эсвэл "SSH Keys" хайх
   - Эсвэл "Security" → "SSH Access"

3. **SSH Key нэмэх:**
   - "Import Key" эсвэл "Add Key" товч дарах
   - "Public Key" талбарт public key-г paste хийх
   - "Key Name" (optional): "My Local Machine"
   - "Authorize" эсвэл "Save" хийх

---

## 📋 Алхам 3: GitHub дээр SSH Key нэмэх

1. **GitHub нээх:**
   - https://github.com → Settings → SSH and GPG keys

2. **SSH Key нэмэх:**
   - "New SSH key" товч дарах
   - **Title:** "Production Server" (эсвэл хүссэн нэр)
   - **Key:** Public key paste хийх (Алхам 1-ээс)
   - "Add SSH key" дарах

---

## 📋 Алхам 4: Server дээр Git Clone хийх

### SSH ашиглан server-тэй холбогдох:

```bash
# SSH connection
ssh r2c69it0btr1@198.12.239.156

# Password оруулах (cPanel password)
```

### Website root directory руу орох:

```bash
# Public_html directory руу орох
cd ~/public_html
# эсвэл
cd /home/r2c69it0btr1/public_html

# Одоогийн directory-г шалгах
pwd
ls -la
```

### Backup хийх (хэрэв байгаа бол):

```bash
# Одоогийн shuurkhai directory backup хийх
mv shuurkhai shuurkhai_backup_$(date +%Y%m%d_%H%M%S)

# Эсвэл хэрэв байхгүй бол энэ алхам алгасах
```

### GitHub repository clone хийх:

```bash
# GitHub repository clone хийх
git clone git@github.com:khash-star/shuurkhai.com.git shuurkhai

# Эсвэл HTTPS ашиглах (SSH key ажиллахгүй бол)
git clone https://github.com/khash-star/shuurkhai.com.git shuurkhai
```

### Clone хийгдсэн эсэхийг шалгах:

```bash
cd shuurkhai
ls -la
git status
```

---

## 📋 Алхам 5: Configuration засах

### Database credentials засах:

```bash
# config.php файл засах
nano config.php
# эсвэл
vi config.php
```

**Production database credentials оруулах:**
```php
$dbhost = 'localhost'; // эсвэл production database host
$dbuser = 'production_db_user';
$dbpass = 'production_db_password';
$dbname = 'shuurkhai';
```

**Environment variables тохируулах:**
```php
// Production mode идэвхжүүлэх
$is_production = true; // эсвэл
// .htaccess дээр: SetEnv APP_ENV production
```

### .htaccess файл шалгах:

```bash
nano .htaccess
```

**HTTPS enforcement uncomment хийх (хэрэв шаардлагатай бол):**
```apache
RewriteEngine On
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```

---

## 📋 Алхам 6: Composer Install (хэрэв шаардлагатай бол)

```bash
cd ~/public_html/shuurkhai

# Composer install (production mode)
composer install --no-dev --optimize-autoloader

# Эсвэл хэрэв composer байхгүй бол
php composer.phar install --no-dev --optimize-autoloader
```

---

## 📋 Алхам 7: File Permissions засах

```bash
# Cache directory үүсгэх
mkdir -p cache logs
chmod -R 755 cache/ logs/

# File permissions засах
find . -type d -exec chmod 755 {} \;
find . -type f -exec chmod 644 {} \;

# Owner засах (хэрэв шаардлагатай бол)
chown -R r2c69it0btr1:r2c69it0btr1 .
```

---

## 📋 Алхам 8: Database Indexing (Optional)

```bash
# Database indexing script ажиллуулах
mysql -u production_db_user -p shuurkhai < database_indexing.sql
```

**Эсвэл phpMyAdmin ашиглах:**
1. phpMyAdmin нээх
2. `shuurkhai` database сонгох
3. SQL tab дээр `database_indexing.sql` файлын агуулгыг paste хийх
4. "Go" дарах

---

## 📋 Алхам 9: Тест хийх

### Website ажиллаж байгаа эсэхийг шалгах:

1. Browser дээр: `https://shuurkhai.com`
2. Login хийх
3. Database connection шалгах
4. Error logs шалгах: `logs/php_errors.log`

### SSH ашиглан error logs шалгах:

```bash
# Error logs харах
tail -f logs/php_errors.log

# Эсвэл хэрэв байхгүй бол
tail -f ~/logs/error_log
```

---

## 🔄 Дараа нь Шинэчлэлт хийх

### Шинэ код deploy хийх:

```bash
# SSH ашиглан server дээр
ssh r2c69it0btr1@198.12.239.156

# Website directory руу орох
cd ~/public_html/shuurkhai

# GitHub-аас шинэ код татах
git pull origin main

# Composer update (хэрэв шаардлагатай бол)
composer install --no-dev --optimize-autoloader

# Cache цэвэрлэх (хэрэв шаардлагатай бол)
rm -rf cache/*
```

---

## ⚠️ Анхааруулга

1. **Backup хийх** - Production дээр өөрчлөлт хийхээс өмнө backup хийх
2. **Database credentials** - Production database credentials зөв оруулах
3. **File permissions** - Permissions зөв тохируулах
4. **Error logs** - Error logs шалгах

---

## 🐛 Troubleshooting

### SSH connection алдаа:
```bash
# SSH key test хийх
ssh -T git@github.com

# Хэрэв "Permission denied" гэж гарвал SSH key зөв нэмэгдээгүй байна
```

### Git clone алдаа:
```bash
# HTTPS ашиглах (SSH ажиллахгүй бол)
git clone https://github.com/khash-star/shuurkhai.com.git shuurkhai
```

### Permission алдаа:
```bash
# Permissions засах
chmod -R 755 ~/public_html/shuurkhai
chown -R r2c69it0btr1:r2c69it0btr1 ~/public_html/shuurkhai
```

### Database connection алдаа:
- Database credentials шалгах
- Database user permissions шалгах
- Firewall rules шалгах

---

## ✅ Дүгнэлт

SSH ашиглах нь хамгийн сайн арга:
- ✅ Хурдан
- ✅ Найдвартай
- ✅ Auto deployment боломжтой
- ✅ Бүрэн хяналт

**Дараа нь:**
- `git pull` ашиглан шинэчлэлт хийх
- Эсвэл GitHub Webhook ашиглах (auto deployment)
