<?php
/**
 * Modern Database Class
 * Replaces global $conn with dependency injection pattern
 * PHP 8.1+ compatible with type hints
 */

namespace Shuurkhai\Core;

class Database
{
    private static ?\mysqli $connection = null;
    
    /**
     * Get database connection (singleton pattern)
     * @return \mysqli
     * @throws \Exception
     */
    public static function getConnection(): \mysqli
    {
        if (self::$connection === null) {
            // Try to get existing connection from global scope
            global $conn;
            
            // If config.php hasn't been loaded yet, load it
            if (!isset($conn)) {
                $configPath = __DIR__ . '/../config.php';
                if (file_exists($configPath)) {
                    require_once($configPath);
                }
            }
            
            // Check if connection exists
            if (isset($conn) && $conn instanceof \mysqli) {
                self::$connection = $conn;
            } else {
                throw new \Exception('Database connection not available. Make sure config.php is loaded first.');
            }
        }
        return self::$connection;
    }
    
    /**
     * Execute prepared statement
     * @param string $sql SQL query with placeholders
     * @param array $params Parameters to bind
     * @return \mysqli_result|false
     */
    public static function execute(string $sql, array $params = []): \mysqli_result|false
    {
        $conn = self::getConnection();
        $stmt = mysqli_prepare($conn, $sql);
        
        if (!$stmt) {
            return false;
        }
        
        if (!empty($params)) {
            $types = '';
            $values = [];
            foreach ($params as $param) {
                if (is_int($param)) {
                    $types .= 'i';
                } elseif (is_float($param)) {
                    $types .= 'd';
                } else {
                    $types .= 's';
                }
                $values[] = $param;
            }
            mysqli_stmt_bind_param($stmt, $types, ...$values);
        }
        
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);
        
        return $result;
    }
    
    /**
     * Fetch single row
     * @param string $sql SQL query
     * @param array $params Parameters
     * @return array|null
     */
    public static function fetchOne(string $sql, array $params = []): ?array
    {
        $result = self::execute($sql, $params);
        if ($result && mysqli_num_rows($result) > 0) {
            return mysqli_fetch_array($result, MYSQLI_ASSOC);
        }
        return null;
    }
    
    /**
     * Fetch all rows
     * @param string $sql SQL query
     * @param array $params Parameters
     * @return array
     */
    public static function fetchAll(string $sql, array $params = []): array
    {
        $result = self::execute($sql, $params);
        $rows = [];
        if ($result) {
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $rows[] = $row;
            }
        }
        return $rows;
    }
}
