# Production Deployment Checklist

## Pre-Deployment

### Code
- [x] Error reporting production дээр хаагдсан
- [x] SQL Injection засварласан (prepared statements)
- [x] .htaccess security headers нэмэгдсэн
- [x] Session security сайжруулсан
- [x] Security functions үүсгэсэн (lib/security.php)
- [ ] Password migration script ажиллуулсан
- [ ] Login файлууд password_hash ашиглах болгосон

### Configuration
- [ ] `config.php` дээр production database credentials
- [ ] `APP_ENV=production` тохируулсан
- [ ] Database user нь root биш
- [ ] Strong database password

### Files
- [ ] `migrate_passwords.php` устгасан (migration хийгдсэний дараа)
- [ ] Sensitive files permissions зөв
- [ ] Logs folder үүсгэсэн (chmod 775)

## Server Setup

### Server Requirements
- [ ] PHP 7.4+ суусан
- [ ] MySQL 5.7+ суусан
- [ ] Apache mod_rewrite идэвхтэй
- [ ] SSL Certificate суусан

### Apache Configuration
- [ ] Virtual host тохируулсан
- [ ] Document root зөв
- [ ] .htaccess ажиллаж байна

### Database
- [ ] Database үүсгэсэн
- [ ] Database user үүсгэсэн (root биш)
- [ ] Database backup хийсэн
- [ ] Database restore хийсэн

## Security

### HTTPS
- [ ] SSL Certificate суусан
- [ ] HTTPS enforcement идэвхтэй (.htaccess)
- [ ] Mixed content асуудал байхгүй

### File Permissions
- [ ] Files: 644
- [ ] Folders: 755
- [ ] Writable folders: 775

### Access Control
- [ ] Sensitive files хамгаалагдсан
- [ ] Directory listing хаагдсан
- [ ] .htaccess files хамгаалагдсан

## Post-Deployment

### Testing
- [ ] Homepage ажиллаж байна
- [ ] Login ажиллаж байна
- [ ] Database queries ажиллаж байна
- [ ] File upload (хэрэв байвал) ажиллаж байна
- [ ] HTTPS redirect ажиллаж байна
- [ ] 404 page ажиллаж байна

### Monitoring
- [ ] Error logs шалгаж байна
- [ ] Database performance monitoring
- [ ] SSL certificate renewal reminder тохируулсан

## Maintenance

### Regular Tasks
- [ ] Database backup (өдөр бүр)
- [ ] Error logs шалгах (долоо хоног бүр)
- [ ] SSL certificate renewal (3 сар бүр)
- [ ] Security updates (сар бүр)

### Updates
- [ ] PHP хувилбар шинэчлэх
- [ ] Dependencies шинэчлэх
- [ ] Security patches хийх
