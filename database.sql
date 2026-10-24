CREATE DATABASE IF NOT EXISTS student_tools_ph CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE student_tools_ph;

CREATE TABLE IF NOT EXISTS users (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(190) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('admin','student') NOT NULL DEFAULT 'student',
  status ENUM('active','disabled') NOT NULL DEFAULT 'active',
  last_seen_at DATETIME NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_users_role_status (role,status),
  INDEX idx_users_last_seen (last_seen_at),
  INDEX idx_users_created (created_at)
);

CREATE TABLE IF NOT EXISTS activity_logs (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT UNSIGNED NULL,
  event_type VARCHAR(60) NOT NULL,
  details VARCHAR(255) NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_activity_created (created_at),
  INDEX idx_activity_type (event_type),
  CONSTRAINT fk_activity_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS tool_usage (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT UNSIGNED NULL,
  tool_key VARCHAR(60) NOT NULL,
  used_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_tool_used (tool_key,used_at),
  INDEX idx_tool_user (user_id),
  CONSTRAINT fk_tool_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);
