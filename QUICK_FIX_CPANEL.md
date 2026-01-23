# ⚡ Хурдан засах - cPanel File Manager

## 📍 Алхам 1: cPanel нээх
1. `https://shuurkhai.com:2083` нээх
2. cPanel username/password-оор нэвтрэх
3. **"File Manager"** олох

## 📍 Алхам 2: admin/login.php засах

1. `public_html/shuurkhai_git/admin/login.php` файлыг олох
2. Right-click → **"Edit"** (эсвэл **"Code Editor"**)
3. Эхний 5 мөрийг доорх байдлаар засах:

```php
<?php
    require_once(__DIR__ . "/../config.php");
    require_once(__DIR__ . "/views/helper.php");
    require_once(__DIR__ . "/views/init.php");
?>
```

4. **"Save Changes"** дарах

---

## 📍 Алхам 3: admin/views/helper.php засах

1. `public_html/shuurkhai_git/admin/views/helper.php` файлыг олох
2. Right-click → **"Edit"** (эсвэл **"Code Editor"**)
3. **Ctrl+F** дарах, `name;break` хайх
4. 392-р мөрийг олох:

**Хуучин (буруу):**
```php
case "name": return $data["name;break"];
```

**Шинэ (зөв):**
```php
case "name": return $data["name"]; break;
```

5. Засах, **"Save Changes"** дарах

---

## ✅ Тест хийх

Browser дээр: `https://shuurkhai.com/shuurkhai_git/login`

Одоо HTTP 500 алдаа засагдах ёстой! 🎉

---

## 🔍 Хэрэв асуудал гарвал

cPanel → **"Error Log"** эсвэл **"Metrics"** → **"Errors"** шалгах
