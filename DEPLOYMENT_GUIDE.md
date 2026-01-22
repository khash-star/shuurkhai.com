# Production Deployment Guide

## 🚀 Домайнтай Холбох Алхамууд

### 1. Server Requirements

- **PHP**: 7.4+ (PHP 8.1+ зөвлөмжлөгдөнө)
- **MySQL**: 5.7+ эсвэл MariaDB 10.3+
- **Apache**: 2.4+ (mod_rewrite идэвхтэй)
- **SSL Certificate**: HTTPS ашиглах (Let's Encrypt үнэгүй)

### 2. Files Upload

```bash
# Бүх файлуудыг server руу upload хийх
# FTP эсвэл SSH ашиглах
scp -r * user@your-server.com:/var/www/html/shuurkhai/
```

### 3. Database Setup

```sql
-- Database үүсгэх
CREATE DATABASE shuurkhai CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- User үүсгэх (production дээр root ашиглахгүй!)
CREATE USER 'shuurkhai_user'@'localhost' IDENTIFIED BY 'strong_password_here';
GRANT ALL PRIVILEGES ON shuurkhai.* TO 'shuurkhai_user'@'localhost';
FLUSH PRIVILEGES;

-- Database backup-аас restore хийх
mysql -u shuurkhai_user -p shuurkhai < backup.sql
```

### 4. Configuration Files

#### config.php засах

```php
// Production дээр эдгээрийг өөрчлөх:
$dbhost = 'localhost';
$dbuser = 'shuurkhai_user'; // root биш!
$dbpass = 'strong_password_here';
$dbname = 'shuurkhai';
```

#### Environment Variable тохируулах

```bash
# .htaccess эсвэл Apache config дээр:
SetEnv APP_ENV production
```

Эсвэл `config.php` дээр шууд:

```php
$is_production = true; // Production дээр
```

### 5. File Permissions

```bash
# Files болон folders-ийн permission тохируулах
find /var/www/html/shuurkhai -type f -exec chmod 644 {} \;
find /var/www/html/shuurkhai -type d -exec chmod 755 {} \;

# Writable folders (хэрэв байвал)
chmod 775 /var/www/html/shuurkhai/logs
chmod 775 /var/www/html/shuurkhai/uploads
```

### 6. SSL Certificate (HTTPS)

```bash
# Let's Encrypt ашиглах (Certbot)
sudo apt-get install certbot python3-certbot-apache
sudo certbot --apache -d shuurkhai.com -d www.shuurkhai.com
```

`.htaccess` дээр HTTPS enforcement идэвхжүүлэх:

```apache
# .htaccess дээр энэ мөрийг uncomment хийх:
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```

### 7. Security Checklist

- [ ] `config.php` дээр production mode идэвхжүүлсэн
- [ ] Database user нь root биш
- [ ] Strong database password ашиглаж байна
- [ ] `.htaccess` дээр HTTPS enforcement идэвхжүүлсэн
- [ ] `migrate_passwords.php` файлыг устгасан (migration хийгдсэний дараа)
- [ ] Error reporting production дээр хаагдсан
- [ ] Sensitive files (.htaccess, config.php) хамгаалагдсан
- [ ] File upload restrictions тохируулсан
- [ ] Rate limiting идэвхтэй

### 8. Password Migration

```bash
# 1. Database backup хийх
mysqldump -u shuurkhai_user -p shuurkhai > backup_before_migration.sql

# 2. Migration script ажиллуулах
php migrate_passwords.php

# 3. Login файлуудыг шинэчлэх (password_hash ашиглах)

# 4. Migration script устгах
rm migrate_passwords.php
```

### 9. Testing

Production дээр deploy хийсний дараа:

- [ ] Login тест хийх
- [ ] Database connection шалгах
- [ ] HTTPS ажиллаж байгаа эсэхийг шалгах
- [ ] Error pages (404) ажиллаж байгаа эсэхийг шалгах
- [ ] File upload (хэрэв байвал) тест хийх
- [ ] Performance шалгах

### 10. Monitoring

- Error logs шалгах: `/var/log/apache2/error.log`
- PHP error logs: `logs/php_errors.log` (config.php дээр тохируулсан)
- Database performance monitoring
- SSL certificate renewal (Let's Encrypt 90 хоногт)

## 🔧 Troubleshooting

### Database Connection Error

```php
// config.php дээр шалгах:
- Database host зөв эсэх
- Username/password зөв эсэх
- Database name зөв эсэх
- MySQL service ажиллаж байгаа эсэх
```

### 404 Errors

```apache
# .htaccess дээр RewriteBase зөв эсэхийг шалгах
RewriteBase /shuurkhai/  # эсвэл /
```

### Permission Errors

```bash
# Files ownership шалгах
ls -la /var/www/html/shuurkhai
# Apache user (www-data эсвэл apache) ownership байх ёстой
```

### SSL Certificate Issues

```bash
# Certificate renewal
sudo certbot renew

# Test SSL
openssl s_client -connect shuurkhai.com:443
```

## 📞 Support

Асуудал гарвал:
1. Error logs шалгах
2. Database connection шалгах
3. File permissions шалгах
4. .htaccess configuration шалгах
