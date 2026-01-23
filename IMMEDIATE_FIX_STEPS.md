# 🚨 IMMEDIATE FIX - Follow These Steps Now

## Step 1: Fix admin/config.php (2 minutes)

1. **Login to cPanel:** `https://shuurkhai.com:2083`

2. **Open File Manager**

3. **Navigate to:** `public_html/shuurkhai_git/admin/config.php`

4. **Right-click → Edit** (or click Edit button)

5. **DELETE all current content** and **PASTE this:**

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

6. **Click "Save Changes"**

---

## Step 2: Configure Database Password (1 minute)

1. **Still in File Manager, navigate to:** `public_html/shuurkhai_git/config.php`

2. **Right-click → Edit**

3. **Find line 19** (should say):
   ```php
   $dbpass = getenv('DB_PASS') ?: '';
   ```

4. **Change it to:**
   ```php
   $dbpass = getenv('DB_PASS') ?: 'YOUR_DATABASE_PASSWORD_HERE';
   ```
   **Replace `YOUR_DATABASE_PASSWORD_HERE` with your actual MySQL database password**

5. **Click "Save Changes"**

---

## Step 3: Test

Open in browser: `https://shuurkhai.com/shuurkhai_git/admin/login`

**The error should be fixed!** ✅

---

## ⚠️ If You Don't Know Your Database Password

1. Go to cPanel → **MySQL Databases**
2. Find your database user (usually `root` or similar)
3. Click **"Change Password"** to set/reset password
4. Use that password in Step 2 above

---

## ✅ Done!

After these 2 steps, your database connection error will be resolved.
