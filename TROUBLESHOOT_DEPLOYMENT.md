# GitHub Actions Deployment Алдааны Шийдэл

## Алдаа: Workflow Failed

### Шалтгаан 1: FTP Account Directory зөв тохируулаагүй

**Шийдэл:**
1. **cPanel → FTP Accounts** руу орох
2. **GitHub Actions-д ашиглаж байгаа FTP account-ийг олох**
3. **"Change Path" эсвэл "Configure" дарах**
4. **Directory-г `/public_html` болгох** (absolute path - энэ нь чухал!)
5. **Save хийх**

### Шалтгаан 2: GitHub Secrets зөв тохируулаагүй

**Шийдэл:**
1. **GitHub → Settings → Secrets and variables → Actions**
2. **3 secrets байгаа эсэхийг шалгах:**
   - `CPANEL_FTP_HOST` = `shuurkhai.com`
   - `CPANEL_FTP_USER` = FTP username (яг cPanel дээрх username)
   - `CPANEL_FTP_PASSWORD` = FTP password (яг cPanel дээрх password)
3. **Хэрэв байхгүй бол нэмэх**

### Шалтгаан 3: FTP Connection алдаа

**Шалгах:**
1. **GitHub → Actions → Failed workflow → "deploy" job → Log шалгах**
2. **Алдааны мэдээлэл харах:**
   - "Can't change directory" → FTP account directory зөв биш
   - "Authentication failed" → Username/password буруу
   - "Connection timeout" → FTP host буруу

---

## Хурдан Шийдэл:

### Алхам 1: FTP Account үүсгэх (Шинэ)

1. **cPanel → FTP Accounts**
2. **Add FTP Account:**
   - **Log In:** `github_deploy`
   - **Password:** Хүчтэй нууц үг (жишээ: `MyStr0ng!P@ssw0rd`)
   - **Directory:** `/public_html` (absolute path - энэ нь чухал!)
   - **Quota:** Unlimited
3. **Create FTP Account**

### Алхам 2: GitHub Secrets нэмэх/засах

1. **GitHub → Settings → Secrets and variables → Actions**
2. **Хэрэв байгаа бол устгах, дараа нь нэмэх:**
   - `CPANEL_FTP_HOST` = `shuurkhai.com`
   - `CPANEL_FTP_USER` = `github_deploy` (эсвэл cPanel username)
   - `CPANEL_FTP_PASSWORD` = FTP password (яг cPanel дээрх)

### Алхам 3: Test хийх

1. **Local дээр:**
   ```bash
   git commit --allow-empty -m "Test deployment"
   git push
   ```
2. **GitHub → Actions** - Workflow ажиллаж байгааг харах
3. **Log шалгах** - Амжилттай эсэхийг харах

---

## Хэрэв асуудал байсаар байвал:

### GitHub Actions Log-ийг шалгах:

1. **GitHub → Actions tab**
2. **Failed workflow-ийг дарах**
3. **"deploy" job-ийг дарах**
4. **"Deploy to cPanel via FTP" step-ийг дарах**
5. **Log-ийг унших** - Алдааны мэдээлэл харах

### Алдааны төрлүүд:

- **"550 Can't change directory"** → FTP account directory `/public_html` биш
- **"530 Login incorrect"** → Username/password буруу
- **"Connection timeout"** → FTP host буруу эсвэл firewall

---

## Альтернатив: Гараар Deploy хийх

Хэрэв GitHub Actions ажиллахгүй бол:

1. **cPanel → File Manager**
2. **`public_html` directory руу орох**
3. **Local дээрх файлуудыг zip хийх**
4. **cPanel → Upload → Extract хийх**

---

## Хамгийн чухал зүйл:

✅ **FTP Account Directory:** `/public_html` (absolute path)  
✅ **GitHub Secrets:** 3 secrets байх ёстой  
✅ **FTP Username/Password:** cPanel дээрх username/password яг адил байх ёстой
