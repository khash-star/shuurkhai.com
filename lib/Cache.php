<?php
/**
 * Simple Cache Class
 * File-based caching for settings and frequently accessed data
 * PHP 8.1+ compatible
 */

namespace Shuurkhai\Core;

class Cache
{
    private static string $cacheDir;
    private static int $defaultTtl = 3600; // 1 hour
    
    /**
     * Initialize cache directory
     */
    public static function init(): void
    {
        self::$cacheDir = __DIR__ . '/../cache/';
        if (!is_dir(self::$cacheDir)) {
            mkdir(self::$cacheDir, 0755, true);
        }
    }
    
    /**
     * Get cached value
     * @param string $key Cache key
     * @return mixed|null Cached value or null if not found/expired
     */
    public static function get(string $key): mixed
    {
        self::init();
        $file = self::$cacheDir . md5($key) . '.cache';
        
        if (!file_exists($file)) {
            return null;
        }
        
        $data = unserialize(file_get_contents($file));
        
        // Check if expired
        if (isset($data['expires']) && $data['expires'] < time()) {
            unlink($file);
            return null;
        }
        
        return $data['value'] ?? null;
    }
    
    /**
     * Set cached value
     * @param string $key Cache key
     * @param mixed $value Value to cache
     * @param int|null $ttl Time to live in seconds (null = use default)
     * @return bool Success status
     */
    public static function set(string $key, mixed $value, ?int $ttl = null): bool
    {
        self::init();
        $file = self::$cacheDir . md5($key) . '.cache';
        $ttl = $ttl ?? self::$defaultTtl;
        
        $data = [
            'value' => $value,
            'expires' => time() + $ttl,
            'created' => time()
        ];
        
        return file_put_contents($file, serialize($data)) !== false;
    }
    
    /**
     * Delete cached value
     * @param string $key Cache key
     * @return bool Success status
     */
    public static function delete(string $key): bool
    {
        self::init();
        $file = self::$cacheDir . md5($key) . '.cache';
        
        if (file_exists($file)) {
            return unlink($file);
        }
        
        return true;
    }
    
    /**
     * Clear all cache
     * @return bool Success status
     */
    public static function clear(): bool
    {
        self::init();
        $files = glob(self::$cacheDir . '*.cache');
        
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
        
        return true;
    }
    
    /**
     * Check if key exists and is valid
     * @param string $key Cache key
     * @return bool True if exists and valid
     */
    public static function has(string $key): bool
    {
        return self::get($key) !== null;
    }
}
