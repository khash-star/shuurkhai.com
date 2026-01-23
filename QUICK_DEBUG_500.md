# HTTP 500 Error Хурдан Debug

## Арга 1: cPanel Error Log (Хамгийн хурдан) ⭐

1. **cPanel → Error Log** руу орох
2. **Сүүлийн алдаануудыг харах**
3. **Алдааны мэдээлэл унших**

Энэ нь хамгийн хурдан арга - файл upload хийх шаардлагагүй!

---

## Арга 2: DEBUG_500_ERROR.php файл гараар upload хийх

1. **Local дээрх `DEBUG_500_ERROR.php` файлыг олох**
2. **cPanel → File Manager → public_html**
3. **Upload → Choose File → DEBUG_500_ERROR.php**
4. **Browser дээр:** `https://shuurkhai.com/DEBUG_500_ERROR.php`

---

## Арга 3: GitHub Actions workflow хүлээх

1. **GitHub → Actions tab**
2. **Workflow ажиллаж байгааг харах**
3. **Workflow дууссаны дараа (1-2 минут)**
4. **Browser дээр:** `https://shuurkhai.com/DEBUG_500_ERROR.php`

---

## Хамгийн их магадлалтай шалтгаан:

### 1. Database Connection алдаа (90%)

**Шалгах:**
- cPanel → Error Log
- "Access denied for user" эсвэл "Unknown database" гэсэн алдаа харагдана

**Засвар:**
- `config.php` файлд database credentials зөв эсэхийг шалгах
- cPanel → MySQL Databases → Database user байгаа эсэхийг шалгах

### 2. Missing File (5%)

**Шалгах:**
- cPanel → Error Log
- "Failed to open stream" эсвэл "No such file or directory" гэсэн алдаа

**Засвар:**
- Алдааны мэдээлэлд заасан файлыг шалгах

### 3. PHP Syntax Error (3%)

**Шалгах:**
- cPanel → Error Log
- "Parse error" эсвэл "syntax error" гэсэн алдаа

**Засвар:**
- Алдааны мэдээлэлд заасан файл, мөр шалгах

---

## Хурдан шалгах:

**cPanel → Error Log** руу ороод сүүлийн алдааны мэдээлэл хараарай!
