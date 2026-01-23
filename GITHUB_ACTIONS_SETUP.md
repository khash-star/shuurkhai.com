# GitHub Actions ашиглан cPanel руу Автомат Deploy хийх

## Алхам 1: GitHub Secrets тохируулах

1. **GitHub repository руу орох:** `https://github.com/khash-star/shuurkhai_new`
2. **Settings → Secrets and variables → Actions** руу орох
3. **New repository secret** дарах
4. Дараах 3 secrets нэмэх:

### Secret 1: CPANEL_FTP_HOST
- **Name:** `CPANEL_FTP_HOST`
- **Value:** `shuurkhai.com` (эсвэл FTP server address)

### Secret 2: CPANEL_FTP_USER
- **Name:** `CPANEL_FTP_USER`
- **Value:** cPanel username (жишээ: `r2c69it0btr1`)

### Secret 3: CPANEL_FTP_PASSWORD
- **Name:** `CPANEL_FTP_PASSWORD`
- **Value:** cPanel FTP password

---

## Алхам 2: cPanel дээр FTP Account үүсгэх

1. **cPanel → FTP Accounts** руу орох
2. **Add FTP Account:**
   - **Log In:** `github_deploy` (эсвэл өөр нэр)
   - **Password:** Хүчтэй нууц үг үүсгэх
   - **Directory:** `/public_html` (root directory)
   - **Quota:** Unlimited (эсвэл хязгаар тавих)
3. **Create FTP Account** дарах
4. **Энэ FTP username болон password-ийг GitHub Secrets дээр нэмэх**

---

## Алхам 3: Test хийх

1. **Local дээр засвар хийх**
2. **Git commit хийх:**
   ```bash
   git add .
   git commit -m "Test auto deploy"
   git push
   ```
3. **GitHub → Actions tab** руу орох
4. **Deploy workflow ажиллаж байгааг харах**
5. **5-10 секундын дараа cPanel дээр файлууд шинэчлэгдсэн эсэхийг шалгах**

---

## Анхаарах зүйлс

✅ **Автомат deploy:** `main` branch руу push хийхэд автоматаар deploy хийх
✅ **Байгаа файлууд:** `.git`, `node_modules`, `cache` зэрэг файлуудыг exclude хийх
✅ **Безопас:** FTP password нь GitHub Secrets дээр нууцлагдсан байна
✅ **Хурдан:** Push хийсний дараа 1-2 минутын дотор сайт шинэчлэгдэнэ

---

## Асуудал гарвал

### FTP connection алдаа:
- FTP host зөв эсэхийг шалгах
- FTP username/password зөв эсэхийг шалгах
- cPanel дээр FTP access идэвхтэй эсэхийг шалгах

### Files deploy хийгдээгүй:
- GitHub Actions → Workflow runs → Failed job-ийг шалгах
- Logs дээрх алдааны мэдээллийг унших

---

## Өөр сонголт: Git Hook ашиглах (Илүү хурдан)

Хэрэв cPanel дээр SSH access байвал Git hook ашиглаж болно:

1. **cPanel → Git Version Control**
2. **Repository үүсгэх:**
   - Path: `public_html`
   - Remote: `https://github.com/khash-star/shuurkhai_new.git`
3. **Post-receive hook нэмэх:**
   ```bash
   cd /home/r2c69it0btr1/public_html
   git pull origin main
   ```
4. **GitHub → Settings → Webhooks → Add webhook:**
   - Payload URL: `https://shuurkhai.com/cpanel-git-hook.php` (эсвэл cPanel webhook URL)
   - Content type: `application/json`
   - Events: `Just the push event`

---

## Хамгийн хялбар арга (Одоогийн тохиргоо)

Одоо таны код аль хэдийн GitHub дээр байна. Дээрх алхмуудыг дагаад:
1. GitHub Secrets тохируулах (5 минут)
2. FTP account үүсгэх (2 минут)
3. Test хийх (1 минут)

**Нийт: 8 минут** - Дараа нь засвар хийх бүртээ зүгээр л `git push` хийхэд автоматаар deploy хийгдэнэ! 🚀
