# GitHub Deployment Guide - shuurkhai.com

## 🚀 GitHub-тай Холбох Аргууд

### Арга 1: SSH ашиглах (Хамгийн сайн) ✅

#### 1. SSH Key үүсгэх (Local machine дээр)

```bash
# SSH key үүсгэх (хэрэв байхгүй бол)
ssh-keygen -t ed25519 -C "your_email@example.com"

# Public key-г харах
cat ~/.ssh/id_ed25519.pub
```

#### 2. SSH Key-г cPanel дээр нэмэх

1. cPanel нээх: `https://shuurkhai.com:2083` (эсвэл hosting provider-ийн URL)
2. "SSH Access" эсвэл "SSH Keys" хэсэг олох
3. "Import Key" эсвэл "Add Key" дарах
4. Public key-г paste хийх
5. "Authorize" хийх

#### 3. GitHub дээр SSH Key нэмэх

1. GitHub → Settings → SSH and GPG keys
2. "New SSH key" дарах
3. Public key-г paste хийх
4. Save хийх

#### 4. Server дээр Git Clone хийх

```bash
# SSH ашиглан server-тэй холбогдох
ssh r2c69it0btr1@198.12.239.156

# Public_html эсвэл website root directory руу орох
cd public_html
# эсвэл
cd ~/public_html
# эсвэл
cd /home/r2c69it0btr1/public_html

# Одоогийн файлуудыг backup хийх (хэрэв байгаа бол)
mv shuurkhai shuurkhai_backup_$(date +%Y%m%d)

# GitHub repository clone хийх
git clone git@github.com:khash-star/shuurkhai.com.git shuurkhai

# эсвэл HTTPS ашиглах (SSH key байхгүй бол)
git clone https://github.com/khash-star/shuurkhai.com.git shuurkhai

# Directory руу орох
cd shuurkhai

# .env файл үүсгэх (хэрэв шаардлагатай бол)
cp .env.example .env
# Database credentials оруулах
nano .env
```

### Арга 2: cPanel Git Version Control ашиглах

1. cPanel нээх
2. "Git Version Control" эсвэл "Git" хэсэг олох
3. "Create" эсвэл "Clone" дарах
4. Repository URL оруулах: `https://github.com/khash-star/shuurkhai.com.git`
5. Clone Path: `public_html/shuurkhai` (эсвэл хүссэн path)
6. "Create" хийх

### Арга 3: Manual Deployment (FTP/File Manager)

1. Local дээр Git pull хийх:
```bash
cd C:\xampp\htdocs\shuurkhai
git pull origin main
```

2. cPanel File Manager ашиглах:
   - cPanel → File Manager
   - `public_html` directory руу орох
   - Бүх файлуудыг upload хийх

3. Эсвэл FTP client ашиглах (FileZilla, WinSCP)

## ⚙️ Configuration

### 1. Database Configuration

Production server дээр `.env` файл эсвэл `config.php` засах:

```php
// config.php
$dbhost = getenv('DB_HOST') ?: 'localhost';
$dbuser = getenv('DB_USER') ?: 'production_user';
$dbpass = getenv('DB_PASS') ?: 'production_password';
$dbname = getenv('DB_NAME') ?: 'shuurkhai';
```

### 2. Environment Variables

cPanel дээр environment variables тохируулах:
- cPanel → "Environment Variables" эсвэл ".htaccess" дээр нэмэх

```apache
# .htaccess
SetEnv APP_ENV production
SetEnv DB_HOST localhost
SetEnv DB_USER production_user
SetEnv DB_PASS production_password
SetEnv DB_NAME shuurkhai
```

### 3. Composer Install

```bash
# SSH ашиглан server дээр
cd ~/public_html/shuurkhai
composer install --no-dev --optimize-autoloader
```

### 4. File Permissions

```bash
# Cache directory permissions
chmod -R 755 cache/
chown -R r2c69it0btr1:r2c69it0btr1 cache/

# Logs directory permissions
chmod -R 755 logs/
chown -R r2c69it0btr1:r2c69it0btr1 logs/
```

## 🔄 Auto Deployment (Optional)

### GitHub Webhook ашиглах

1. GitHub → Repository → Settings → Webhooks
2. "Add webhook" дарах
3. Payload URL: `https://shuurkhai.com/deploy.php` (эсвэл custom endpoint)
4. Content type: `application/json`
5. Events: "Just the push event"
6. Save хийх

### deploy.php үүсгэх

```php
<?php
// deploy.php (secure location, not in public_html)
$secret = 'your_secret_key';
$payload = file_get_contents('php://input');
$signature = $_SERVER['HTTP_X_HUB_SIGNATURE_256'] ?? '';

if (hash_equals('sha256=' . hash_hmac('sha256', $payload, $secret), $signature)) {
    $output = shell_exec('cd /home/r2c69it0btr1/public_html/shuurkhai && git pull origin main 2>&1');
    error_log("Deployment: " . $output);
    http_response_code(200);
} else {
    http_response_code(403);
}
?>
```

## 📋 Deployment Checklist

### Pre-Deployment:
- [ ] Database backup хийсэн
- [ ] Local дээр тест хийсэн
- [ ] Environment variables бэлтгэсэн
- [ ] SSH access идэвхжүүлсэн

### Deployment:
- [ ] Git clone/pull хийсэн
- [ ] Database connection шалгасан
- [ ] Composer install хийсэн
- [ ] File permissions тохируулсан
- [ ] Cache directory үүсгэсэн
- [ ] Logs directory үүсгэсэн

### Post-Deployment:
- [ ] Website ажиллаж байгаа эсэхийг шалгасан
- [ ] Database connection шалгасан
- [ ] Error logs шалгасан
- [ ] Performance шалгасан

## 🔐 Security

### 1. .htaccess дээр sensitive files хамгаалах

```apache
# .htaccess
<FilesMatch "^(config\.php|\.env|composer\.json|composer\.lock)$">
    Order allow,deny
    Deny from all
</FilesMatch>
```

### 2. Production mode идэвхжүүлэх

```bash
# .htaccess эсвэл environment variable
SetEnv APP_ENV production
```

### 3. HTTPS идэвхжүүлэх

```apache
# .htaccess
RewriteEngine On
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```

## 🐛 Troubleshooting

### Git clone алдаа:
```bash
# Permission алдаа
chmod -R 755 ~/public_html/shuurkhai

# SSH key алдаа
ssh-add ~/.ssh/id_ed25519
```

### Database connection алдаа:
- Database credentials шалгах
- Database user permissions шалгах
- Firewall rules шалгах

### File permission алдаа:
```bash
# Owner засах
chown -R r2c69it0btr1:r2c69it0btr1 ~/public_html/shuurkhai

# Permissions засах
find ~/public_html/shuurkhai -type d -exec chmod 755 {} \;
find ~/public_html/shuurkhai -type f -exec chmod 644 {} \;
```

## 📝 Дүгнэлт

**Хамгийн сайн арга: SSH ашиглах**

1. SSH key үүсгэх
2. cPanel дээр SSH key нэмэх
3. GitHub дээр SSH key нэмэх
4. Server дээр `git clone` хийх
5. Configuration засах
6. Composer install хийх

**Дараа нь:**
- `git pull` ашиглан шинэчлэлт хийх
- Эсвэл GitHub Webhook ашиглах (auto deployment)
