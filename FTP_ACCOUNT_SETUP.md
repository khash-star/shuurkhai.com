# FTP Account Directory Тохируулах (Чухал!)

## Алдаа:
```
FTPError: 550 Can't change directory to css: No such file or directory
```

## Шалтгаан:
FTP account-ийн directory зөв тохируулаагүй байна. FTP account-ийн root directory нь `/public_html` байх ёстой.

## Шийдэл:

### Алхам 1: cPanel дээр FTP Account шалгах

1. **cPanel → FTP Accounts** руу орох
2. **GitHub Actions-д ашиглаж байгаа FTP account-ийг олох**
3. **Directory-г шалгах:**
   - ✅ **Зөв:** `/public_html` (absolute path)
   - ❌ **Буруу:** `/public_html/shuurkhai_new`
   - ❌ **Буруу:** `/home/username/public_html`
   - ❌ **Буруу:** `public_html` (relative path)

### Алхам 2: Directory засах (хэрэв буруу бол)

1. **FTP account-ийн хажууд "Change Path" эсвэл "Configure" дарах**
2. **Directory-г `/public_html` болгох** (absolute path - энэ нь чухал!)
3. **Save хийх**

### Алхам 3: Шинэ FTP Account үүсгэх (Хэрэв хэцүү бол)

1. **cPanel → FTP Accounts**
2. **Add FTP Account:**
   - **Log In:** `github_deploy`
   - **Password:** Хүчтэй нууц үг
   - **Directory:** `/public_html` (absolute path - энэ нь чухал!)
   - **Quota:** Unlimited
3. **Create FTP Account**
4. **GitHub Secrets дээр энэ username/password нэмэх:**
   - `CPANEL_FTP_USER` = `github_deploy`
   - `CPANEL_FTP_PASSWORD` = шинэ password

---

## Workflow файл дахь тохиргоо:

```yaml
server-dir: /
```

Энэ нь FTP account-ийн **root directory** руу deploy хийх гэсэн үг. Тэгэхээр FTP account-ийн directory нь `/public_html` байх ёстой.

---

## Хэрэв FTP Account Directory `/public_html` байвал:

✅ Workflow амжилттай ажиллах ёстой  
✅ Файлууд `public_html` root directory руу хуулагдана  
✅ `https://shuurkhai.com/` дээр сайт ажиллах ёстой  

---

## Хэрэв FTP Account Directory буруу байвал:

❌ "Can't change directory" алдаа гарна  
❌ Файлууд хуулагдахгүй  
❌ Workflow failed болно  

---

## Хурдан шалгах:

1. **cPanel → FTP Accounts**
2. **FTP account-ийн directory-г харах**
3. **Хэрэв `/public_html` биш бол засах**

---

## Анхаарах зүйл:

- **Absolute path:** `/public_html` ✅
- **Relative path:** `public_html` ❌
- **Subdirectory:** `/public_html/shuurkhai_new` ❌

**FTP account-ийн directory нь яг `/public_html` байх ёстой!**
