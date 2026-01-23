<?php
/**
 * Modern Helper Class
 * Replaces procedural functions with class-based methods
 * PHP 8.1+ compatible with type hints and return types
 */

namespace Shuurkhai\Core;

use Shuurkhai\Core\Database;
use Shuurkhai\Core\Cache;

class Helpers
{
    /**
     * Clean string - remove special characters
     * @param string $string Input string
     * @return string Cleaned string
     */
    public static function stringClean(string $string): string
    {
        $string = str_replace(' ', '', $string);
        return preg_replace('/[^A-Za-z0-9\-]/', '', $string);
    }
    
    /**
     * Get customer information
     * @param int $customerId Customer ID
     * @param string $parameter Parameter name
     * @return string|int|float|null
     */
    public static function customer(int $customerId, string $parameter): string|int|float|null
    {
        if ($customerId < 0) {
            return null;
        }
        
        if ($customerId == 0) {
            // Admin/Default values
            return match($parameter) {
                'name' => 'Shuurkhai.com',
                'surname' => '',
                'rd' => '',
                'address' => '4712 OAKTON STREET, 60076, Chicago IL',
                'address_extra' => '',
                'tel' => '773-621-6807',
                'last_log' => '',
                'email' => '',
                'full_name' => 'Shuurkhai.com',
                'cent' => 0,
                default => null
            };
        }
        
        // Fetch customer data
        $data = Database::fetchOne(
            "SELECT * FROM customer WHERE customer_id = ? LIMIT 1",
            [$customerId]
        );
        
        if (!$data) {
            return null;
        }
        
        return match($parameter) {
            'name' => $data['name'] ?? '',
            'surname' => $data['surname'] ?? '',
            'rd' => $data['rd'] ?? '',
            'address' => $data['address'] ?? '',
            'address_extra' => $data['address_extra'] ?? '',
            'tel' => $data['tel'] ?? '',
            'last_log' => $data['address'] ?? '',
            'email' => $data['email'] ?? '',
            'full_name' => trim(($data['name'] ?? '') . ' ' . ($data['surname'] ?? '')),
            'cent' => (float)($data['cent'] ?? 0),
            default => null
        };
    }
    
    /**
     * Search track in orders
     * @param string $track Track number
     * @return string|int Order ID or empty string
     */
    public static function trackSearch(string $track): string|int
    {
        $filterDate = date('Y-m-d', strtotime('-2 months'));
        $track = str_replace(' ', '', $track);
        
        $trackPrefix = substr($track, 0, 2);
        
        if ($trackPrefix === '22' || $trackPrefix === 'ES') {
            $data = Database::fetchOne(
                "SELECT * FROM orders WHERE third_party = ? AND created_date >= ? LIMIT 1",
                [$track, $filterDate]
            );
        } else {
            $trackEliminated = substr($track, -8, 8);
            $data = Database::fetchOne(
                "SELECT * FROM orders WHERE SUBSTRING(third_party, -8, 8) = ? AND created_date >= ? LIMIT 1",
                [$trackEliminated, $filterDate]
            );
        }
        
        return $data ? (string)$data['order_id'] : '';
    }
    
    /**
     * Search track in container items
     * @param string $track Track number
     * @return string|int Container item ID or empty string
     */
    public static function trackSearchContainer(string $track): string|int
    {
        $filterDate = date('Y-m-d', strtotime('-6 months'));
        $track = str_replace(' ', '', $track);
        
        $trackPrefix = substr($track, 0, 2);
        
        if ($trackPrefix === '22' || $trackPrefix === 'ES') {
            $data = Database::fetchOne(
                "SELECT * FROM container_item WHERE track = ? AND created_date >= ? LIMIT 1",
                [$track, $filterDate]
            );
        } else {
            $trackEliminated = substr($track, -8, 8);
            $data = Database::fetchOne(
                "SELECT * FROM container_item WHERE SUBSTRING(track, -8, 8) = ? AND created_date >= ? LIMIT 1",
                [$trackEliminated, $filterDate]
            );
        }
        
        return $data ? (string)$data['id'] : '';
    }
    
    /**
     * Get setting value (with caching)
     * @param int|string $idOrShortname Setting ID or shortname
     * @return string Setting value or empty string
     */
    public static function settings(int|string $idOrShortname): string
    {
        $cacheKey = 'setting_' . (is_int($idOrShortname) ? 'id_' : 'name_') . $idOrShortname;
        
        // Try to get from cache first (if Cache class is available)
        if (class_exists('Shuurkhai\Core\Cache')) {
            try {
                $cached = Cache::get($cacheKey);
                if ($cached !== null) {
                    return (string)$cached;
                }
            } catch (\Exception $e) {
                // Cache error, continue to database
            }
        }
        
        // Fetch from database
        if (is_int($idOrShortname)) {
            $data = Database::fetchOne(
                "SELECT * FROM settings WHERE id = ? LIMIT 1",
                [$idOrShortname]
            );
        } else {
            $data = Database::fetchOne(
                "SELECT * FROM settings WHERE shortname = ? LIMIT 1",
                [$idOrShortname]
            );
        }
        
        $value = $data ? (string)($data['value'] ?? '') : '';
        
        // Cache for 1 hour (if Cache class is available)
        if (class_exists('Shuurkhai\Core\Cache')) {
            try {
                Cache::set($cacheKey, $value, 3600);
            } catch (\Exception $e) {
                // Cache error, ignore
            }
        }
        
        return $value;
    }
    
    /**
     * Log application activity
     * @param string $name Page/action name
     * @param string $request Request data
     * @param string $response Response data
     * @param string $method HTTP method
     * @return bool Success status
     */
    public static function msLog(string $name, string $request, string $response, string $method): bool
    {
        $result = Database::execute(
            "INSERT INTO applogs (page, input, output, method) VALUES (?, ?, ?, ?)",
            [$name, $request, $response, $method]
        );
        
        return $result !== false;
    }
    
    /**
     * Calculate price based on weight
     * @param float $weight Weight in kg
     * @return float Price
     */
    public static function cfgPrice(float $weight): float
    {
        $paymentRate = (float)self::settings('paymentrate');
        $paymentRateMin = (float)self::settings('paymentrate_min');
        
        if ($weight > 1) {
            return $paymentRate * $weight;
        } elseif ($weight >= 0.5) {
            return $paymentRate;
        } elseif ($weight == 0) {
            return 0;
        } else {
            return $paymentRateMin;
        }
    }
    
    /**
     * Fix image path for base href
     * @param string $path Image path
     * @return string Fixed path
     */
    public static function fixImagePath(string $path): string
    {
        if (empty($path)) {
            return '';
        }
        
        $path = trim($path);
        
        // If path is already a full URL, return as is
        if (preg_match('/^https?:\/\//', $path)) {
            return $path;
        }
        
        // Remove leading slash if present
        $path = ltrim($path, '/');
        
        // If path starts with shuurkhai/, remove it
        if (str_starts_with($path, 'shuurkhai/')) {
            $path = substr($path, 10);
        }
        
        // Check if uploads file exists
        if (str_starts_with($path, 'uploads/')) {
            $filePath = dirname(__DIR__) . DIRECTORY_SEPARATOR . $path;
            if (!file_exists($filePath)) {
                return '';
            }
        }
        
        return $path;
    }
}
