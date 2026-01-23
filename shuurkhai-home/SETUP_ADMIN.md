# Admin болон Agents засах заавар

## Асуудал
`/admin/` руу ороход хоосон хуудас гарч байна. Энэ нь admin directory дээр `index.php` файл байхгүйтэй холбоотой.

## Шийдэл

### 1. Admin index.php файл үүсгэх

Production server дээр дараах командыг ажиллуулаарай:

```bash
cd ~/public_html/shuurkhai_git/admin

# Хэрэв admin directory байхгүй бол үүсгэх
mkdir -p admin

# Admin index.php файл үүсгэх
cat > admin/index.php << 'EOFPHP'
<?php
// Admin directory index.php
// Redirects to the main admin page

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in as admin
$is_admin = false;
if (isset($_SESSION['logged']) && $_SESSION['logged'] === true) {
    if (isset($_SESSION['customer_id']) && $_SESSION['customer_id'] == 0) {
        $is_admin = true;
    } elseif (isset($_SESSION['name']) && !empty($_SESSION['name'])) {
        $is_admin = true;
    }
}

// Redirect based on admin status
if ($is_admin) {
    // Redirect to main admin page
    header('Location: /shuurkhai_git/admin/online?action=all');
} else {
    // Redirect to login page
    header('Location: /shuurkhai_git/login');
}
exit;
EOFPHP
```

### 2. Admin файлууд байгаа эсэхийг шалгах

```bash
cd ~/public_html/shuurkhai_git

# Admin directory байгаа эсэхийг шалгах
ls -la admin/

# Admin файлууд байгаа эсэхийг шалгах
ls -la admin/*.php
```

### 3. Хэрэв admin файлууд байхгүй бол

Admin файлууд production server дээр байх ёстой. Хэрэв байхгүй бол:

1. Хуучин сайтаас admin файлуудыг хуулах
2. Эсвэл admin файлуудыг өөр газар байгаа эсэхийг шалгах

```bash
# Бүх admin файлуудыг хайх
find ~/public_html -name "admin" -type d
find ~/public_html -name "*admin*.php" -type f
```

### 4. Agents хуудас

Agents хуудас `.htaccess` дээр дараах байдлаар route хийгдсэн байх ёстой:
```
RewriteRule ^agent/?$ admin/agents.php [L]
```

Тиймээс agents руу орох:
- URL: `https://shuurkhai.com/shuurkhai_git/agent`
- Эсвэл: `https://shuurkhai.com/shuurkhai_git/admin/agents.php`

### 5. .htaccess шалгах

`.htaccess` файл дээр дараах route-ууд байх ёстой:

```apache
RewriteRule ^agent/?$ admin/agents.php [L]
RewriteRule ^login/?$ admin/login.php [L]
```

Хэрэв байхгүй бол нэмэх:

```bash
cd ~/public_html/shuurkhai_git
nano .htaccess
```

## Шалгах

Дараах URL-ууд ажиллах ёстой:

1. **Admin (нэвтрэсэн):** `https://shuurkhai.com/shuurkhai_git/admin/` → `/admin/online?action=all` руу redirect
2. **Admin (нэвтрээгүй):** `https://shuurkhai.com/shuurkhai_git/admin/` → `/login` руу redirect
3. **Agents:** `https://shuurkhai.com/shuurkhai_git/agent`
4. **Login:** `https://shuurkhai.com/shuurkhai_git/login`

## Хэрэв асуудал үргэлжилвэл

Error log шалгах:
```bash
tail -50 ~/logs/error_log
tail -50 /var/log/apache2/error.log
```
