# 🎯 Санал болгох Deployment Арга

## ✅ Арга 1: SSH ашиглах (ХАМГИЙН САЙН) ⭐

### Яагаад энэ арга?

**Давуу тал:**
- ✅ **Хурдан** - Шууд Git commands ашиглах боломжтой
- ✅ **Найдвартай** - Command line-аас бүрэн хяналт
- ✅ **Auto deployment** - Webhook ашиглах боломжтой
- ✅ **Version control** - Git pull/push хийх боломжтой
- ✅ **Flexible** - Ямар ч Git operation хийх боломжтой
- ✅ **SSH access идэвхтэй** - Одоо бэлэн байна

**Сул тал:**
- ⚠️ SSH command line мэдлэг шаардлагатай (гэхдээ хялбар)

### Хэрхэн хийх:

```bash
# 1. SSH ашиглан server-тэй холбогдох
ssh r2c69it0btr1@198.12.239.156

# 2. Website root directory руу орох
cd ~/public_html
# эсвэл
cd /home/r2c69it0btr1/public_html

# 3. Одоогийн файлуудыг backup хийх (хэрэв байгаа бол)
mv shuurkhai shuurkhai_backup_$(date +%Y%m%d)

# 4. GitHub repository clone хийх
git clone git@github.com:khash-star/shuurkhai.com.git shuurkhai

# 5. Configuration засах
cd shuurkhai
nano config.php  # Database credentials засах

# 6. Composer install (хэрэв шаардлагатай бол)
composer install --no-dev --optimize-autoloader

# 7. Permissions засах
chmod -R 755 cache/ logs/
```

### Дараа нь шинэчлэлт хийх:

```bash
# SSH ашиглан server дээр
cd ~/public_html/shuurkhai
git pull origin main
composer install --no-dev --optimize-autoloader
```

---

## 🟡 Арга 2: cPanel Git Version Control

### Яагаад энэ арга?

**Давуу тал:**
- ✅ **Хялбар** - GUI ашиглах, command line мэдлэг шаардлагагүй
- ✅ **cPanel дээр шууд** - Web interface-аас хийх боломжтой

**Сул тал:**
- ⚠️ **Хувилбар хамаарна** - Зарим cPanel хувилбар дээр байхгүй байж магадгүй
- ⚠️ **Хязгаарлагдмал** - Зарим advanced Git operations хийх боломжгүй
- ⚠️ **Auto deployment хязгаартай** - Webhook тохируулах хэцүү

### Хэрхэн хийх:

1. cPanel нээх
2. "Git Version Control" эсвэл "Git" хэсэг олох
3. "Create" эсвэл "Clone" дарах
4. Repository URL: `https://github.com/khash-star/shuurkhai.com.git`
5. Clone Path: `public_html/shuurkhai`
6. "Create" хийх

---

## 🟢 Арга 3: Auto Deployment (Webhook)

### Яагаад энэ арга?

**Давуу тал:**
- ✅ **Автомат** - GitHub дээр push хийхэд автоматаар deploy хийгдэнэ
- ✅ **Цаг хэмнэдэг** - Manual deployment хийх шаардлагагүй

**Сул тал:**
- ⚠️ **SSH шаардлагатай** - Webhook script ажиллахад Git command шаардлагатай
- ⚠️ **Security** - Webhook endpoint хамгаалах шаардлагатай
- ⚠️ **Debugging хэцүү** - Алдаа гарвал шалгах хэцүү

### Хэрхэн хийх:

1. SSH ашиглан `deploy.php` файлыг server дээр байрлуулах
2. GitHub → Settings → Webhooks → Add webhook
3. Payload URL: `https://shuurkhai.com/deploy.php`
4. Secret key тохируулах

---

## 🎯 Миний Санал

### **SSH ашиглах (Арга 1)** ⭐⭐⭐⭐⭐

**Шалтгаан:**
1. **SSH access идэвхтэй** - Одоо бэлэн байна
2. **Хамгийн хурдан** - Шууд Git commands
3. **Найдвартай** - Бүрэн хяналт
4. **Auto deployment боломжтой** - Дараа нь webhook нэмэх боломжтой
5. **Flexible** - Ямар ч Git operation

### Алхам алхмаар:

#### Эхлээд: SSH Key үүсгэх (Local machine дээр)

```bash
# Windows PowerShell эсвэл Git Bash дээр
ssh-keygen -t ed25519 -C "your_email@example.com"
# Enter дарах (default location)
# Password оруулах (optional)

# Public key-г харах
cat ~/.ssh/id_ed25519.pub
# эсвэл Windows дээр
type %USERPROFILE%\.ssh\id_ed25519.pub
```

#### Дараа нь: cPanel дээр SSH Key нэмэх

1. cPanel нээх: `https://shuurkhai.com:2083` (эсвэл hosting provider URL)
2. "SSH Access" эсвэл "SSH Keys" хэсэг олох
3. "Import Key" эсвэл "Add Key" дарах
4. Public key-г paste хийх
5. "Authorize" хийх

#### Дараа нь: GitHub дээр SSH Key нэмэх

1. GitHub → Settings → SSH and GPG keys
2. "New SSH key" дарах
3. Title: "Production Server" (эсвэл хүссэн нэр)
4. Key: Public key paste хийх
5. "Add SSH key" дарах

#### Эцэст нь: Server дээр Git Clone

```bash
# SSH ашиглан server-тэй холбогдох
ssh r2c69it0btr1@198.12.239.156

# Website root directory руу орох
cd ~/public_html

# Backup хийх (хэрэв байгаа бол)
mv shuurkhai shuurkhai_backup_$(date +%Y%m%d)

# GitHub repository clone хийх
git clone git@github.com:khash-star/shuurkhai.com.git shuurkhai

# Configuration засах
cd shuurkhai
nano config.php  # Database credentials засах
```

---

## 📊 Харьцуулалт

| Арга | Хурдан | Хялбар | Найдвартай | Auto Deploy |
|------|--------|--------|------------|-------------|
| **SSH** | ⭐⭐⭐⭐⭐ | ⭐⭐⭐ | ⭐⭐⭐⭐⭐ | ✅ |
| **cPanel Git** | ⭐⭐⭐ | ⭐⭐⭐⭐⭐ | ⭐⭐⭐ | ❌ |
| **Webhook** | ⭐⭐⭐⭐ | ⭐⭐ | ⭐⭐⭐ | ✅ |

---

## 🎯 Эцсийн Санал

**SSH ашиглах (Арга 1)** - Энэ нь хамгийн сайн арга!

**Яагаад?**
- SSH access идэвхтэй байна
- Хамгийн хурдан, найдвартай
- Дараа нь auto deployment нэмэх боломжтой
- Бүрэн хяналт

**Дараагийн алхам:**
1. SSH key үүсгэх (local machine дээр)
2. cPanel дээр SSH key нэмэх
3. GitHub дээр SSH key нэмэх
4. Server дээр `git clone` хийх
5. Configuration засах
6. Тест хийх

Дэлгэрэнгүй заавар: `GITHUB_DEPLOYMENT_GUIDE.md`
