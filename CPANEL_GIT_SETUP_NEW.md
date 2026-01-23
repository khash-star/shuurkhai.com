# cPanel Git Repository Setup - shuurkhai_new

## Шинэ Repository-г cPanel-д холбох

### Арга 1: cPanel Git Version Control ашиглах (Хамгийн хялбар)

1. **cPanel руу нэвтрэх**
   - cPanel → Files → Git Version Control

2. **Шинэ Repository нэмэх**
   - "Create" товч дарна
   - Repository Name: `shuurkhai_new`
   - Repository URL: `https://github.com/khash-star/shuurkhai_new.git`
   - Repository Path: `public_html/shuurkhai_new` (эсвэл хүссэн path)
   - Branch: `main`
   - "Create" товч дарна

3. **Repository Clone хийх**
   - cPanel автоматаар clone хийх эсвэл та "Clone" товч дарж болно

### Арга 2: Terminal/SSH ашиглах (Хэрэв SSH access байвал)

```bash
# SSH руу нэвтрэх
ssh username@yourdomain.com

# public_html руу очих
cd ~/public_html

# Шинэ directory үүсгэх (эсвэл одоогийн directory-г ашиглах)
mkdir -p shuurkhai_new
cd shuurkhai_new

# Git repository clone хийх
git clone https://github.com/khash-star/shuurkhai_new.git .

# Эсвэл одоогийн directory-д clone хийх
cd ~/public_html/shuurkhai
git remote add new_origin https://github.com/khash-star/shuurkhai_new.git
git fetch new_origin
git checkout -b main new_origin/main
```

### Арга 3: cPanel File Manager ашиглах

1. **cPanel → File Manager**
   - `public_html` directory руу очих
   - Шинэ folder үүсгэх: `shuurkhai_new`

2. **Terminal ашиглах** (File Manager дотор Terminal байвал)
   ```bash
   cd public_html/shuurkhai_new
   git clone https://github.com/khash-star/shuurkhai_new.git .
   ```

### Production Server дээр тохируулах

Clone хийсний дараа:

1. **config.php файл үүсгэх**
   ```bash
   cd ~/public_html/shuurkhai_new
   cp config.example.php config.php
   # Дараа нь config.php файлыг edit хийж database connection тохируулах
   ```

2. **Permissions тохируулах**
   ```bash
   chmod 644 config.php
   chmod 755 cache/
   chmod -R 755 admin/
   chmod -R 755 user/
   ```

3. **.htaccess шалгах**
   - `.htaccess` файл зөв байгаа эсэхийг шалгах
   - RewriteBase зөв тохируулагдсан эсэхийг шалгах

### Auto-pull Setup (Сонголт)

Production server дээр автоматаар pull хийхийн тулд:

1. **cPanel Cron Jobs ашиглах**
   - cPanel → Advanced → Cron Jobs
   - Command: `cd ~/public_html/shuurkhai_new && git pull new_origin main`
   - Frequency: Daily эсвэл хүссэн frequency

2. **GitHub Webhook ашиглах** (Илүү дэвшилтэт)
   - GitHub repository → Settings → Webhooks
   - Payload URL: `https://yourdomain.com/git-webhook.php`
   - Webhook script үүсгэх хэрэгтэй

### Шалгах

1. **Browser дээр шалгах**
   - `https://yourdomain.com/shuurkhai_new/`
   - Login хуудас: `https://yourdomain.com/shuurkhai_new/user/login`

2. **Git status шалгах**
   ```bash
   cd ~/public_html/shuurkhai_new
   git status
   git remote -v
   ```

### Анхаарах зүйлс

- `config.php` файл `.gitignore`-д байгаа тул production server дээр үүсгэх хэрэгтэй
- `cache/` directory-д write permissions байх хэрэгтэй
- Database connection зөв тохируулагдсан эсэхийг шалгах
- `.htaccess` файл зөв ажиллаж байгаа эсэхийг шалгах

### Troubleshooting

**Хэрэв 404 алдаа гарвал:**
- `.htaccess` файл байгаа эсэхийг шалгах
- RewriteBase зөв тохируулагдсан эсэхийг шалгах
- Apache mod_rewrite идэвхтэй эсэхийг шалгах

**Хэрэв database connection алдаа гарвал:**
- `config.php` файл зөв тохируулагдсан эсэхийг шалгах
- Database credentials зөв эсэхийг шалгах
