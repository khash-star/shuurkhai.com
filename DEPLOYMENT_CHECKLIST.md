# Deployment Checklist

## ✅ Workflow файл тохиргоо:

- [x] `server-dir: /public_html/` - зөв тохируулсан
- [x] Directory creation step нэмэгдсэн
- [x] Exclude patterns зөв тохируулсан

## ⚠️ cPanel дээр шалгах:

### 1. FTP Account Directory:
- [ ] FTP account-ийн directory нь `/public_html` байна (absolute path)
- [ ] Хэрэв буруу бол: cPanel → FTP Accounts → Change Path → `/public_html`

### 2. GitHub Secrets:
- [x] `CPANEL_FTP_HOST` = `shuurkhai.com`
- [x] `CPANEL_FTP_USER` = FTP username
- [x] `CPANEL_FTP_PASSWORD` = FTP password

### 3. Remote Directories:
- [ ] `public_html` directory байгаа эсэхийг шалгах
- [ ] Хэрэв байхгүй бол: cPanel → File Manager → Create directory

### 4. FTP User Permissions:
- [ ] FTP account-д `/public_html` directory руу write access байгаа эсэхийг шалгах

## 🧪 Test хийх:

### Dry-run test (өөрчлөлт хийхгүйгээр шалгах):

Workflow файлд `dry-run: true` болгож test хийх:

```yaml
dry-run: true
```

Дараа нь:
```bash
git commit --allow-empty -m "Test deployment with dry-run"
git push
```

### Production deploy:

Dry-run амжилттай бол:
```yaml
dry-run: false
```

Дараа нь:
```bash
git commit --allow-empty -m "Deploy to production"
git push
```

## 📋 Deployment алхмууд:

1. ✅ Workflow файл зассан
2. ⏳ FTP account directory шалгах
3. ⏳ GitHub Secrets шалгах
4. ⏳ Remote directories шалгах
5. ⏳ Dry-run test хийх
6. ⏳ Production deploy хийх

## 🔍 Алдаа гарвал:

1. **GitHub Actions log шалгах:**
   - "550 Can't change directory" → FTP account directory буруу
   - "530 Login incorrect" → Username/password буруу
   - "Connection timeout" → FTP host буруу

2. **cPanel дээр шалгах:**
   - FTP account directory
   - File permissions
   - Directory existence
