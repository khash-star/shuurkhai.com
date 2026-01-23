# Deploy хийх зааварчилгаа

## Арга 1: GitHub Actions (Автомат Deploy) - Зөвлөмж ⭐

### Алхам 1: GitHub Secrets тохируулах (Зөвхөн нэг удаа)

1. **GitHub repository руу орох:** `https://github.com/khash-star/shuurkhai_new`
2. **Settings → Secrets and variables → Actions**
3. **3 secrets нэмэх:**
   - `CPANEL_FTP_HOST` = `shuurkhai.com`
   - `CPANEL_FTP_USER` = cPanel FTP username
   - `CPANEL_FTP_PASSWORD` = cPanel FTP password

### Алхам 2: cPanel дээр FTP Account үүсгэх (Зөвхөн нэг удаа)

1. **cPanel → FTP Accounts**
2. **Add FTP Account:**
   - **Log In:** `github_deploy` (эсвэл өөр нэр)
   - **Password:** Хүчтэй нууц үг
   - **Directory:** `/public_html` (absolute path - энэ нь чухал!)
3. **Create FTP Account**

### Алхам 3: Deploy хийх (Хугацаа бүрт)

Local дээр засвар хийсний дараа:

```bash
git add .
git commit -m "Засварын тайлбар"
git push
```

**Дараа нь:**
- GitHub Actions автоматаар ажиллана
- 1-2 минутын дотор файлууд `public_html` руу хуулагдана
- Сайт автоматаар шинэчлэгдэнэ

### Шалгах:

1. **GitHub → Actions tab** - Workflow ажиллаж байгааг харах
2. **cPanel → File Manager → public_html** - Файлууд хуулагдсан эсэхийг шалгах
3. **Browser:** `https://shuurkhai.com/` - Сайт ажиллаж байгааг шалгах

---

## Арга 2: Гараар Deploy (Хэрэв GitHub Actions ажиллахгүй бол)

### Алхам 1: cPanel File Manager ашиглах

1. **cPanel → File Manager**
2. **`public_html`** directory руу орох
3. **Бүх файлуудыг сонгох** (Ctrl+A)
4. **Delete хийх** (эсвэл backup хийх)
5. **Local дээрх файлуудыг zip хийх**
6. **cPanel → File Manager → Upload** - zip файлыг upload хийх
7. **Extract хийх**

### Алхам 2: Git Clone ашиглах (cPanel дээр SSH байвал)

1. **cPanel → Git Version Control**
2. **Create Repository:**
   - **Repository URL:** `https://github.com/khash-star/shuurkhai_new.git`
   - **Repository Path:** `public_html`
   - **Repository Name:** `shuurkhai_production`
3. **Create** дарах
4. **Pull хийх** (эсвэл automatic pull идэвхжүүлэх)

---

## Арга 3: FTP Client ашиглах (FileZilla, WinSCP, гэх мэт)

1. **FTP Client нээх**
2. **Connection тохируулах:**
   - **Host:** `shuurkhai.com`
   - **Username:** FTP username
   - **Password:** FTP password
   - **Port:** 21
3. **Local files-ийг сонгох**
4. **Remote:** `/public_html` directory руу drag & drop хийх

---

## Хамгийн хялбар арга (Одоогийн тохиргоо):

✅ **GitHub Actions тохируулсан байна**

Дараа нь зүгээр л:
```bash
git push
```

Автоматаар deploy хийгдэнэ! 🚀

---

## Анхаарах зүйлс:

1. **config.php файл:**
   - Git дээр байхгүй (security)
   - cPanel дээр гараар үүсгэх хэрэгтэй
   - `config.example.php`-аас copy хийж database credentials засах

2. **.htaccess файл:**
   - `RewriteBase /` байх ёстой (root domain-д зориулсан)

3. **Database connection:**
   - `config.php` файлд зөв database credentials байх ёстой

---

## Асуудал гарвал:

1. **GitHub Actions log шалгах** - Алдааны мэдээлэл харах
2. **FTP account directory шалгах** - `/public_html` байх ёстой
3. **GitHub Secrets шалгах** - 3 secrets байх ёстой
