# GitHub Secrets Тохируулах Зааварчилгаа

## Алхам 1: GitHub Repository руу орох

1. **Browser дээр нээх:** `https://github.com/khash-star/shuurkhai_new`
2. **Settings** tab дээр дарах (repository-ийн дээд хэсэгт)

## Алхам 2: Secrets Section руу орох

1. **Зүүн талын menu-аас:**
   - **Secrets and variables** → **Actions** дарах
2. Эсвэл шууд URL: `https://github.com/khash-star/shuurkhai_new/settings/secrets/actions`

## Алхам 3: 3 Secrets нэмэх

### Secret 1: CPANEL_FTP_HOST

1. **New repository secret** товч дарах
2. **Name:** `CPANEL_FTP_HOST` (яг энэ нэр байх ёстой)
3. **Secret:** `shuurkhai.com` (эсвэл FTP server address)
4. **Add secret** дарах

### Secret 2: CPANEL_FTP_USER

1. **New repository secret** товч дарах
2. **Name:** `CPANEL_FTP_USER` (яг энэ нэр байх ёстой)
3. **Secret:** cPanel username (жишээ: `r2c69it0btr1`)
   - Энэ нь cPanel login username байна
   - Эсвэл FTP account username (хэрэв тусдаа FTP account үүсгэсэн бол)
4. **Add secret** дарах

### Secret 3: CPANEL_FTP_PASSWORD

1. **New repository secret** товч дарах
2. **Name:** `CPANEL_FTP_PASSWORD` (яг энэ нэр байх ёстой)
3. **Secret:** cPanel password (эсвэл FTP account password)
4. **Add secret** дарах

---

## Алхам 4: cPanel дээр FTP Account үүсгэх (Хэрэв байхгүй бол)

### Сонголт A: cPanel Main FTP Account ашиглах

Хэрэв та cPanel-ийн main FTP account ашиглахыг хүсвэл:
- **Username:** cPanel username (жишээ: `r2c69it0btr1`)
- **Password:** cPanel password
- **Directory:** `/public_html` (root directory)

### Сонголт B: Тусдаа FTP Account үүсгэх (Зөвлөмж)

1. **cPanel → FTP Accounts** руу орох
2. **Add FTP Account:**
   - **Log In:** `github_deploy` (эсвэл өөр нэр)
   - **Password:** Хүчтэй нууц үг үүсгэх (жишээ: `MyStr0ng!P@ssw0rd`)
   - **Directory:** `/public_html` (root directory)
   - **Quota:** Unlimited (эсвэл хязгаар тавих)
3. **Create FTP Account** дарах
4. **Энэ username болон password-ийг GitHub Secrets дээр нэмэх**

---

## Алхам 5: Test хийх

1. **GitHub → Actions tab** руу орох
2. **"Deploy to cPanel" workflow-ийг олох**
3. **"Re-run jobs"** дарах (хэрэв алдаа гарсан бол)
4. **Эсвэл шинэ commit push хийх:**
   ```bash
   git commit --allow-empty -m "Test deployment"
   git push
   ```
5. **Workflow амжилттай ажиллаж байгааг харах**

---

## Хэрэв алдаа гарвал:

### "Error: Input required and not supplied: server"
- **Шалтгаан:** `CPANEL_FTP_HOST` secret нэмэгдээгүй байна
- **Шийдэл:** Дээрх Алхам 3-ийг дагах

### "FTP connection failed"
- **Шалтгаан:** FTP username/password буруу байна
- **Шийдэл:** 
  - cPanel дээр FTP account зөв эсэхийг шалгах
  - GitHub Secrets дээрх username/password зөв эсэхийг шалгах

### "Permission denied"
- **Шалтгаан:** FTP account-д `/public_html` directory руу access байхгүй
- **Шийдэл:** FTP account-ийн directory-г `/public_html` болгох

---

## Secrets-ийн нэрүүд (Яг энэ байх ёстой):

✅ `CPANEL_FTP_HOST`  
✅ `CPANEL_FTP_USER`  
✅ `CPANEL_FTP_PASSWORD`  

**Анхаар:** Нэрүүд нь том жижиг үсэгт мэдрэмтгий байна!

---

## Хурдан шалгах:

GitHub дээр:
1. `https://github.com/khash-star/shuurkhai_new/settings/secrets/actions`
2. Дээрх 3 secrets байгаа эсэхийг шалгах
3. Хэрэв байхгүй бол нэмэх
