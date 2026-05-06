-- ============================================
-- HAPUS DATABASE LAMA (jika ada)
-- ============================================
DROP DATABASE IF EXISTS rental_game;

-- ============================================
-- BUAT DATABASE BARU
-- ============================================
CREATE DATABASE rental_game
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE rental_game;

-- ============================================
-- TABEL USERS
-- ============================================
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20) DEFAULT NULL,
    address TEXT DEFAULT NULL,
    role ENUM('admin','user') DEFAULT 'user',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================
-- TABEL GAMES
-- ============================================
CREATE TABLE games (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    genre VARCHAR(100) DEFAULT NULL,
    platform VARCHAR(100) DEFAULT NULL,
    price_per_day DECIMAL(10,2) NOT NULL DEFAULT 0,
    stock INT NOT NULL DEFAULT 1,
    status ENUM('tersedia','disewa','habis') DEFAULT 'tersedia',
    image VARCHAR(255) DEFAULT NULL,
    description TEXT DEFAULT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================
-- TABEL TRANSACTIONS
-- ============================================
CREATE TABLE transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    game_id INT NOT NULL,
    rental_date DATE NOT NULL,
    return_date DATE NOT NULL,
    actual_return_date DATE DEFAULT NULL,
    total_days INT NOT NULL DEFAULT 1,
    total_price DECIMAL(10,2) NOT NULL DEFAULT 0,
    status ENUM('ongoing','returned','overdue') DEFAULT 'ongoing',
    notes TEXT DEFAULT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_transaction_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_transaction_game FOREIGN KEY (game_id) REFERENCES games(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================
-- DATA USERS
-- password semua = "password"
-- hash: $2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi
-- ============================================
INSERT INTO users (username, email, password, phone, role) VALUES
('admin', 'admin@rentalgame.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '081234567890', 'admin'),
('budi', 'budi@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '081234567891', 'user'),
('sari', 'sari@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '081234567892', 'user'),
('andi', 'andi@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '081234567893', 'user');

-- ============================================
-- DATA GAMES
-- ============================================
INSERT INTO games (title, genre, platform, price_per_day, stock, status, description) VALUES
('God of War Ragnarok', 'Action Adventure', 'PS5', 15000, 3, 'tersedia', 'Petualangan epik Kratos dan Atreus di dunia Norse mythology. Lanjutan dari God of War 2018 dengan gameplay yang lebih seru dan cerita yang mendebarkan.'),
('FIFA 24', 'Sports', 'PS5', 10000, 5, 'tersedia', 'Game sepak bola terbaru dari EA Sports dengan mode Ultimate Team, Career Mode, dan gameplay yang lebih realistis dari sebelumnya.'),
('The Legend of Zelda: Tears of the Kingdom', 'Action RPG', 'Nintendo Switch', 12000, 2, 'tersedia', 'Petualangan Link di kerajaan Hyrule yang luas dengan kemampuan baru Ultrahand, Fuse, dan Ascend yang memukau.'),
('Spider-Man 2', 'Action Adventure', 'PS5', 15000, 3, 'tersedia', 'Bermain sebagai Peter Parker dan Miles Morales melawan ancaman baru Venom dan Kraven di New York City yang epik.'),
('Elden Ring', 'Action RPG', 'PS5', 12000, 4, 'tersedia', 'Open world RPG kolaborasi FromSoftware dan George R.R. Martin. Jelajahi Lands Between yang misterius dan penuh bahaya.'),
('Mario Kart 8 Deluxe', 'Racing', 'Nintendo Switch', 8000, 4, 'tersedia', 'Game balapan seru dengan karakter Mario dan kawan-kawan. Cocok untuk dimainkan bersama keluarga dan teman.'),
('Hogwarts Legacy', 'Action RPG', 'PS5', 13000, 3, 'tersedia', 'Petualangan di dunia sihir Harry Potter sebagai murid baru Hogwarts di abad ke-19. Jelajahi kastil dan dunia yang menakjubkan.'),
('Resident Evil 4 Remake', 'Horror', 'PS5', 14000, 2, 'tersedia', 'Remake dari game horror klasik RE4 dengan grafis modern, gameplay yang diperbarui, dan cerita yang lebih dalam.'),
('Gran Turismo 7', 'Racing', 'PS5', 11000, 3, 'tersedia', 'Simulator balap mobil terbaik dengan grafis fotorealistis, koleksi mobil terlengkap, dan trek balapan ikonik dari seluruh dunia.'),
('Tekken 8', 'Fighting', 'PS5', 13000, 3, 'tersedia', 'Game fighting terbaru seri Tekken dengan Heat System baru, roster karakter yang beragam, dan visual yang memukau.');

-- ============================================
-- DATA TRANSAKSI CONTOH
-- ============================================
INSERT INTO transactions (user_id, game_id, rental_date, return_date, actual_return_date, total_days, total_price, status) VALUES
(2, 1, '2024-01-10', '2024-01-13', '2024-01-13', 3, 45000, 'returned'),
(3, 2, '2024-01-12', '2024-01-15', '2024-01-15', 3, 30000, 'returned'),
(4, 3, '2024-01-15', '2024-01-18', NULL, 3, 36000, 'ongoing'),
(2, 5, '2024-01-16', '2024-01-19', NULL, 3, 36000, 'ongoing');

-- ============================================
-- UPDATE STATUS GAME YANG SEDANG DISEWA
-- ============================================
UPDATE games SET status = 'disewa', stock = stock - 1 WHERE id = 3;
UPDATE games SET status = 'disewa', stock = stock - 1 WHERE id = 5;

-- ============================================
-- VERIFIKASI DATA
-- ============================================
SELECT 'USERS' as tabel, COUNT(*) as jumlah FROM users
UNION ALL
SELECT 'GAMES', COUNT(*) FROM games
UNION ALL
SELECT 'TRANSACTIONS', COUNT(*) FROM transactions;