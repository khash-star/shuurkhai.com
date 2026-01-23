# 🚨 QUICK FIX - Database Connection Error

## The Error
```
Access denied for user 'root'@'localhost' (using password: NO)
in /home/r2c69it0btr1/public_html/shuurkhai_git/admin/config.php:15
```

## ⚡ Fastest Solution (2 minutes)

### Option 1: Use Fix Script (Easiest)

1. **Upload fix script to production:**
   - Go to cPanel → File Manager
   - Navigate to: `public_html/shuurkhai_git/`
   - Upload `fix_admin_config.php` (from this repo)

2. **Run the script:**
   - Open browser: `https://shuurkhai.com/shuurkhai_git/fix_admin_config.php`
   - The script will automatically fix `admin/config.php`

3. **Configure database password:**
   - Edit `config.php` (in same directory)
   - Find line 19: `$dbpass = getenv('DB_PASS') ?: '';`
   - Change to: `$dbpass = getenv('DB_PASS') ?: 'YOUR_DATABASE_PASSWORD';`
   - Replace `YOUR_DATABASE_PASSWORD` with actual password

4. **Delete fix script:**
   - Delete `fix_admin_config.php` for security

---

### Option 2: Manual Fix via cPanel File Manager

1. **Go to cPanel → File Manager**

2. **Edit admin/config.php:**
   - Navigate to: `public_html/shuurkhai_git/admin/config.php`
   - Right-click → **Edit**

3. **Replace entire file content with:**
   ```php
   <?php
   ob_start();
   @date_default_timezone_set("Asia/Ulaanbaatar");

   // Include root config.php for database connection
   require_once(__DIR__ . "/../config.php");

   //GLOBAL VARIABLES
   $g_title="Шуурхай админ";
   $g_icon="assets/images/favicon.png";

   define ("USA_OFFICE_name","www.SHuurkhai.com");
   define ("USA_OFFICE_id","0");
   define ("USA_OFFICE_tel","773-621-6807");
   define ("USA_OFFICE_address","1888 S Elmhurst rd, Mount prospect, IL, 60056");
   define ("MNG_OFFICE_address","БЗД 14-р хороо, 13-р хороолол");
   define ("USA_OFFICE_zip","60026");
   ?>
   ```

4. **Save the file**

5. **Configure database password in config.php:**
   - Navigate to: `public_html/shuurkhai_git/config.php`
   - Edit line 19:
   ```php
   $dbpass = getenv('DB_PASS') ?: 'YOUR_ACTUAL_PASSWORD_HERE';
   ```
   - Save

---

### Option 3: Pull from Git + Configure Password

1. **Pull latest code:**
   - cPanel → Git Version Control
   - Find `shuurkhai_git` repository
   - Click **Pull** or **Update**

2. **Configure database password:**
   - Edit `config.php` as shown in Option 2, step 5

---

## ✅ Verify Fix

After fixing, test:
- `https://shuurkhai.com/shuurkhai_git/admin/login`

The error should be gone!

---

## 🔍 If Still Not Working

1. **Check config.php has password:**
   - Line 19 should have: `$dbpass = getenv('DB_PASS') ?: 'your_password';`

2. **Verify admin/config.php is fixed:**
   - Should contain: `require_once(__DIR__ . "/../config.php");`
   - Should NOT contain: `mysqli_connect($dbhost, $dbuser, $dbpass);`

3. **Check database credentials:**
   - Make sure username and password are correct
   - Test connection manually if needed

---

## 📝 Notes

- The fix makes `admin/config.php` use the root `config.php`
- Root `config.php` supports environment variables
- You MUST provide the database password (either in config.php or via .htaccess)
