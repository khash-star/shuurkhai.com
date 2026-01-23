# Missing JavaScript Assets засах

## 🔴 Асуудал:
Login хуудас ажиллаж байгаа боловч зарим JavaScript файлууд олдож байгаагүй (404):
- `assets/vendors/core/core.js`
- `assets/vendors/feather-icons/feather.min.js`
- `assets/js/template.js`

## ✅ Шийдэл:

### Production server дээр шалгах:

```bash
cd ~/public_html/shuurkhai_git

# Assets directory байгаа эсэхийг шалгах
ls -la admin/assets/

# Тодорхой файлууд байгаа эсэхийг шалгах
ls -la admin/assets/vendors/core/core.js
ls -la admin/assets/vendors/feather-icons/feather.min.js
ls -la admin/assets/js/template.js
```

### Хэрэв файлууд байхгүй бол:

**Сонголт 1: Локал дээр байгаа assets-уудыг upload хийх**

1. Локал дээр `admin/assets/` directory-г олох
2. FTP эсвэл cPanel File Manager ашиглан production server руу upload хийх
3. Path: `~/public_html/shuurkhai_git/admin/assets/`

**Сонголт 2: Script-уудыг comment хийх (хэрэв шаардлагагүй бол)**

`admin/login.php` файлын 60-70-р мөрүүдийг comment хийх:

```php
<!-- core:js -->
<!-- <script src="assets/vendors/core/core.js"></script> -->
<!-- endinject -->
<!-- plugin js for this page -->
<!-- end plugin js for this page -->
<!-- inject:js -->
<!-- <script src="assets/vendors/feather-icons/feather.min.js"></script> -->
<!-- <script src="assets/js/template.js"></script> -->
<!-- endinject -->
```

**Сонголт 3: CDN ашиглах (хэрэв боломжтой бол)**

Feather icons-ийн хувьд CDN ашиглах:

```php
<!-- Feather Icons CDN -->
<script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
<script>
    feather.replace();
</script>
```

## 📝 Тайлбар:

Эдгээр JavaScript файлууд нь:
- **core.js**: Admin template-ийн core JavaScript
- **feather.min.js**: Icon library (feather icons)
- **template.js**: Admin template JavaScript

Эдгээр файлууд login хуудсын үндсэн ажиллагаанд нөлөөлөхгүй, гэхдээ зарим JavaScript функц (icon animation, template behavior гэх мэт) ажиллахгүй байж болно.

**Анхаарах:** Login form ажиллаж байгаа тул эдгээр файлуудыг засах нь сонголттой. Хэрэв login хуудас зөв ажиллаж байгаа бол эдгээр 404 алдаануудыг үл тоомсорлож болно.

## ✅ Шалгах:

Browser дээр login хуудсыг тест хийх:
```
https://shuurkhai.com/shuurkhai_git/login
```

Login form ажиллаж байгаа эсэхийг шалгах (username/password оруулах, submit хийх).
