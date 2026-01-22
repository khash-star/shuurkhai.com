-- =====================================================
-- Database Indexing Script for Shuurkhai
-- Performance Optimization - Add indexes to frequently queried columns
-- =====================================================
-- 
-- IMPORTANT: Backup your database before running this script!
-- 
-- Usage:
-- 1. Backup database: mysqldump -u root -p shuurkhai > backup.sql
-- 2. Run this script: mysql -u root -p shuurkhai < database_indexing.sql
-- 3. Or run in phpMyAdmin SQL tab
--
-- =====================================================

-- =====================================================
-- 1. CUSTOMER TABLE
-- =====================================================

-- Primary key index (usually already exists)
-- ALTER TABLE customer ADD PRIMARY KEY (customer_id);

-- Index on frequently queried customer_id
CREATE INDEX IF NOT EXISTS idx_customer_id ON customer(customer_id);

-- Index on email for login/authentication
CREATE INDEX IF NOT EXISTS idx_customer_email ON customer(email);

-- Index on tel (phone) for lookups
CREATE INDEX IF NOT EXISTS idx_customer_tel ON customer(tel);

-- =====================================================
-- 2. ORDERS TABLE
-- =====================================================

-- Primary key index (usually already exists)
-- ALTER TABLE orders ADD PRIMARY KEY (order_id);

-- Index on order_id (foreign key lookups)
CREATE INDEX IF NOT EXISTS idx_orders_order_id ON orders(order_id);

-- Index on third_party (track number) - VERY FREQUENTLY QUERIED
CREATE INDEX IF NOT EXISTS idx_orders_third_party ON orders(third_party);

-- Index on created_date for date range queries
CREATE INDEX IF NOT EXISTS idx_orders_created_date ON orders(created_date);

-- Composite index for track search (third_party + created_date)
CREATE INDEX IF NOT EXISTS idx_orders_track_date ON orders(third_party, created_date);

-- Index on receiver (customer_id foreign key)
CREATE INDEX IF NOT EXISTS idx_orders_receiver ON orders(receiver);

-- Index on status for filtering
CREATE INDEX IF NOT EXISTS idx_orders_status ON orders(status);

-- Index on proxy_id for proxy lookups
CREATE INDEX IF NOT EXISTS idx_orders_proxy_id ON orders(proxy_id);

-- Composite index for receiver + status queries
CREATE INDEX IF NOT EXISTS idx_orders_receiver_status ON orders(receiver, status);

-- Composite index for receiver + proxy_id + status
CREATE INDEX IF NOT EXISTS idx_orders_receiver_proxy_status ON orders(receiver, proxy_id, status);

-- =====================================================
-- 3. CONTAINER_ITEM TABLE
-- =====================================================

-- Index on track number - FREQUENTLY QUERIED
CREATE INDEX IF NOT EXISTS idx_container_item_track ON container_item(track);

-- Index on created_date for date range queries
CREATE INDEX IF NOT EXISTS idx_container_item_created_date ON container_item(created_date);

-- Composite index for track search (track + created_date)
CREATE INDEX IF NOT EXISTS idx_container_item_track_date ON container_item(track, created_date);

-- =====================================================
-- 4. BRANCH_INVENTORIES TABLE
-- =====================================================

-- Index on track number
CREATE INDEX IF NOT EXISTS idx_branch_inventories_track ON branch_inventories(track);

-- Index on branch (branch_id)
CREATE INDEX IF NOT EXISTS idx_branch_inventories_branch ON branch_inventories(branch);

-- Index on status for filtering
CREATE INDEX IF NOT EXISTS idx_branch_inventories_status ON branch_inventories(status);

-- Composite index for track + branch lookups
CREATE INDEX IF NOT EXISTS idx_branch_inventories_track_branch ON branch_inventories(track, branch);

-- Composite index for branch + status filtering
CREATE INDEX IF NOT EXISTS idx_branch_inventories_branch_status ON branch_inventories(branch, status);

-- =====================================================
-- 5. SETTINGS TABLE
-- =====================================================

-- Primary key index (usually already exists)
-- ALTER TABLE settings ADD PRIMARY KEY (id);

-- Index on id for lookups
CREATE INDEX IF NOT EXISTS idx_settings_id ON settings(id);

-- Index on shortname - FREQUENTLY QUERIED
CREATE INDEX IF NOT EXISTS idx_settings_shortname ON settings(shortname);

-- =====================================================
-- 6. PROXIES TABLE
-- =====================================================

-- Index on customer_id (foreign key)
CREATE INDEX IF NOT EXISTS idx_proxies_customer_id ON proxies(customer_id);

-- Index on code for lookups
CREATE INDEX IF NOT EXISTS idx_proxies_code ON proxies(code);

-- Index on status for filtering
CREATE INDEX IF NOT EXISTS idx_proxies_status ON proxies(status);

-- Composite index for customer_id + code lookups
CREATE INDEX IF NOT EXISTS idx_proxies_customer_code ON proxies(customer_id, code);

-- Composite index for customer_id + status
CREATE INDEX IF NOT EXISTS idx_proxies_customer_status ON proxies(customer_id, status);

-- =====================================================
-- 7. PROXIES_PUBLIC TABLE
-- =====================================================

-- Index on status for filtering
CREATE INDEX IF NOT EXISTS idx_proxies_public_status ON proxies_public(status);

-- =====================================================
-- 8. APPLOGS TABLE (if exists)
-- =====================================================

-- Index on page for filtering logs
CREATE INDEX IF NOT EXISTS idx_applogs_page ON applogs(page);

-- Index on method for filtering
CREATE INDEX IF NOT EXISTS idx_applogs_method ON applogs(method);

-- =====================================================
-- 9. CUSTOMER_LOGGING TABLE (if exists)
-- =====================================================

-- Index on customer_id
CREATE INDEX IF NOT EXISTS idx_customer_logging_customer_id ON customer_logging(customer_id);

-- Index on created_date for date range queries
CREATE INDEX IF NOT EXISTS idx_customer_logging_created_date ON customer_logging(created_date);

-- =====================================================
-- NOTES:
-- =====================================================
-- 
-- 1. Indexes improve SELECT query performance but slightly slow down INSERT/UPDATE
-- 2. Most frequently queried columns should have indexes
-- 3. Composite indexes are useful for queries with multiple WHERE conditions
-- 4. Foreign keys should always have indexes
-- 5. Date columns used in WHERE clauses should have indexes
--
-- =====================================================
-- VERIFICATION QUERIES
-- =====================================================
-- 
-- Check existing indexes:
-- SHOW INDEX FROM orders;
-- SHOW INDEX FROM customer;
-- SHOW INDEX FROM branch_inventories;
--
-- Check table structure:
-- DESCRIBE orders;
-- DESCRIBE customer;
--
-- Analyze query performance:
-- EXPLAIN SELECT * FROM orders WHERE third_party = '22ABC123';
-- EXPLAIN SELECT * FROM orders WHERE receiver = 123 AND status = 'new';
--
-- =====================================================
