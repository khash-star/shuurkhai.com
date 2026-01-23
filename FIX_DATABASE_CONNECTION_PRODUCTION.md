# 🔧 Database Connection Fix - Production Server

## ⚠️ Problem
Error: `Access denied for user 'root'@'localhost' (using password: NO)`

The production server is using an old version of `admin/config.php` that has hardcoded empty password.

## ✅ Solution

### Step 1: Pull Latest Changes from Git

**Option A: Using cPanel Git Version Control**
1. Login to cPanel: `https://shuurkhai.com:2083`
2. Go to **"Git Version Control"** or **"Software"** → **"Git Version Control"**
3. Find `shuurkhai_git` repository
4. Click **"Pull or Deploy"** or **"Update"**
5. Select branch: `main`
6. Click **"Update"** or **"Pull"**

**Option B: Using cPanel Terminal**
```bash
cd ~/public_html/shuurkhai_git
git pull origin main
```

### Step 2: Configure Database Password

After pulling, you need to set the database password. Choose one method:

#### Method 1: Update config.php directly (Easiest)

1. Go to cPanel → **"File Manager"**
2. Navigate to: `public_html/shuurkhai_git/config.php`
3. Right-click → **"Edit"** or **"Code Editor"**
4. Find line 19:
   ```php
   $dbpass = getenv('DB_PASS') ?: '';
   ```
5. Change it to:
   ```php
   $dbpass = getenv('DB_PASS') ?: 'YOUR_ACTUAL_DATABASE_PASSWORD';
   ```
   Replace `YOUR_ACTUAL_DATABASE_PASSWORD` with your actual MySQL password.

6. **Save Changes**

#### Method 2: Set Environment Variables (Recommended for security)

1. Go to cPanel → **"File Manager"**
2. Navigate to: `public_html/shuurkhai_git/`
3. Create or edit `.htaccess` file
4. Add these lines:
   ```apache
   SetEnv DB_HOST localhost
   SetEnv DB_USER your_database_user
   SetEnv DB_PASS your_database_password
   SetEnv DB_NAME shuurkhai
   ```
5. Replace the values with your actual database credentials
6. **Save Changes**

### Step 3: Verify the Fix

1. Check that `admin/config.php` now includes the root config:
   ```php
   require_once(__DIR__ . "/../config.php");
   ```
   (Should be on line 7)

2. Test the login page:
   ```
   https://shuurkhai.com/shuurkhai_git/admin/login
   ```

## 🔍 Verification

After pulling and configuring, verify these files:

**admin/config.php** (should look like this):
```php
<?php
ob_start();
@date_default_timezone_set("Asia/Ulaanbaatar");

// Include root config.php for database connection
require_once(__DIR__ . "/../config.php");

//GLOBAL VARIABLES
$g_title="Шуурхай админ";
...
```

**config.php** (line 19 should have password):
```php
$dbpass = getenv('DB_PASS') ?: 'your_password_here';
```

## ⚠️ Important Notes

- The fix we pushed makes `admin/config.php` use the root `config.php` which supports environment variables
- You MUST configure the database password on production (either in config.php or via environment variables)
- The old `admin/config.php` had hardcoded empty password, which is why it failed

## 🆘 If Still Not Working

1. Check error logs: cPanel → **"Error Log"**
2. Verify database credentials are correct
3. Test database connection manually:
   ```php
   <?php
   $conn = mysqli_connect('localhost', 'your_user', 'your_password', 'shuurkhai');
   if ($conn) {
       echo "Connected!";
   } else {
       echo "Error: " . mysqli_connect_error();
   }
   ?>
   ```
