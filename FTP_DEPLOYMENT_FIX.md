# FTP Deployment Алдааны Шийдэл

## Алдаа:
```
FTPError: 550 Can't change directory to home: No such file or directory
```

## Шалтгаан:
FTP `server-dir` path зөв тохируулаагүй байна. cPanel дээр FTP account үүсгэхэд directory нь `/public_html` байх ёстой.

## Шийдэл:

### Сонголт 1: FTP Account Directory-г `/public_html` болгох (Зөвлөмж)

1. **cPanel → FTP Accounts** руу орох
2. **FTP account олох** (GitHub Actions-д ашиглаж байгаа)
3. **"Change Path" эсвэл "Configure" дарах**
4. **Directory-г `/public_html` болгох** (absolute path)
5. **Save хийх**

### Сонголт 2: Workflow файлд `server-dir`-ийг засах

Workflow файлд:
```yaml
server-dir: ./public_html/  # Relative path
```

Эсвэл:
```yaml
server-dir: /  # Root directory (хэрэв FTP account root дээр байвал)
```

### Сонголт 3: FTP Account-ийн Root Directory-г ашиглах

Хэрэв FTP account `/home/username/public_html` дээр байвал:
```yaml
server-dir: ./
```

---

## Хамгийн зөв арга:

1. **cPanel → FTP Accounts**
2. **FTP account үүсгэх:**
   - **Log In:** `github_deploy`
   - **Password:** Хүчтэй нууц үг
   - **Directory:** `/public_html` (absolute path)
3. **Create FTP Account**
4. **GitHub Secrets дээр энэ username/password нэмэх**
5. **Workflow файлд `server-dir: ./` эсвэл `server-dir: /` ашиглах**

---

## Test хийх:

1. **FTP client ашиглаж test хийх:**
   - Host: `shuurkhai.com`
   - Username: FTP username
   - Password: FTP password
   - Directory: `/public_html` эсвэл FTP account-ийн root directory

2. **Хэрэв connection амжилттай бол workflow ажиллах ёстой**
