# cPanel дээр засах файлууд (localhost → production)

## Засах хэрэгтэй файлууд:

### 1. `index.php` файл
**Байршил:** `public_html/index.php`

**Засвар:**
- Мөр 20: `<base href="/shuurkhai/">` → `<base href="/">`
- Мөр 185: `actionUrl: '/shuurkhai/calculator'` → `actionUrl: '/calculator'`
- Мөр 198: `actionUrl: '/shuurkhai/calculator?type=sea'` → `actionUrl: '/calculator?type=sea'`

### 2. `home-test.php` файл (хэрэв байгаа бол)
**Байршил:** `public_html/home-test.php`

**Засвар:**
- Мөр 17: `<base href="/shuurkhai/">` → `<base href="/">`
- Мөр 182: `actionUrl: '/shuurkhai/calculator'` → `actionUrl: '/calculator'`
- Мөр 195: `actionUrl: '/shuurkhai/calculator?type=sea'` → `actionUrl: '/calculator?type=sea'`

### 3. `config.php` файл шалгах
**Байршил:** `public_html/config.php`

**Шалгах:**
- Файл байгаа эсэхийг шалгах
- Database мэдээлэл зөв эсэхийг шалгах

### 4. `shop.php` файл
**Байршил:** `public_html/shop.php`

**Шалгах:**
- Path-ууд зөв эсэхийг шалгах

## Хурдан засвар:

cPanel → File Manager → `public_html/` → файлуудыг Edit хийж засах

## Эсвэл би засаж өгье:

Би файлуудыг засаж, GitHub руу push хийж өгье. Дараа нь cPanel дээр upload хийх эсвэл GitHub Actions ашиглах.
