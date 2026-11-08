-- Import this in cPanel → phpMyAdmin after creating the empty database.
-- Do NOT run the CREATE DATABASE line on cPanel (you already created the DB there).
-- Select your database first (example: youruser_tau), then import.

SET NAMES utf8mb4;
SET time_zone = '+00:00';

CREATE TABLE IF NOT EXISTS newsletter_subscribers (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(190) NOT NULL,
  source VARCHAR(80) NOT NULL DEFAULT 'footer',
  consent TINYINT(1) NOT NULL DEFAULT 1,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY uq_newsletter_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS contact_messages (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  email VARCHAR(190) NOT NULL,
  category VARCHAR(120) NOT NULL,
  subject VARCHAR(160) NOT NULL,
  message TEXT NOT NULL,
  consent TINYINT(1) NOT NULL DEFAULT 1,
  status VARCHAR(40) NOT NULL DEFAULT 'new',
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY idx_contact_status_created (status, created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS welfare_reports (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  reference_code VARCHAR(32) NOT NULL,
  status VARCHAR(40) NOT NULL DEFAULT 'received',
  animal_type VARCHAR(80) NOT NULL,
  concern_types JSON NOT NULL,
  observations TEXT NOT NULL,
  event_date DATE NULL,
  event_time TIME NULL,
  not_sure_when TINYINT(1) NOT NULL DEFAULT 0,
  county VARCHAR(120) NOT NULL,
  area VARCHAR(160) NOT NULL,
  precise_location VARCHAR(255) NULL,
  immediate_danger VARCHAR(40) NOT NULL,
  contact_name VARCHAR(120) NULL,
  contact_email VARCHAR(190) NULL,
  contact_phone VARCHAR(60) NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY uq_report_reference (reference_code),
  KEY idx_report_status_created (status, created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS community_stories (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  status VARCHAR(40) NOT NULL DEFAULT 'pending_moderation',
  title VARCHAR(140) NOT NULL,
  body TEXT NOT NULL,
  animal_type VARCHAR(80) NOT NULL,
  location VARCHAR(120) NULL,
  display_name VARCHAR(80) NOT NULL,
  category VARCHAR(120) NULL,
  photo_path VARCHAR(255) NULL,
  consent TINYINT(1) NOT NULL DEFAULT 1,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY idx_story_status_created (status, created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
