CREATE DATABASE IF NOT EXISTS tegal_portal;
USE tegal_portal;

DROP TABLE IF EXISTS destination_images;
DROP TABLE IF EXISTS destinations;
DROP TABLE IF EXISTS messages;
DROP TABLE IF EXISTS categories;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  role VARCHAR(20) NOT NULL DEFAULT 'admin',
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  slug VARCHAR(120) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE destinations (
  id INT AUTO_INCREMENT PRIMARY KEY,
  category_id INT NOT NULL,
  name VARCHAR(150) NOT NULL,
  slug VARCHAR(180) NOT NULL UNIQUE,
  location VARCHAR(120) NOT NULL,
  short_desc VARCHAR(255) NOT NULL,
  content TEXT NOT NULL,
  thumbnail VARCHAR(255) DEFAULT NULL,
  is_featured TINYINT(1) NOT NULL DEFAULT 0,
  views INT NOT NULL DEFAULT 0,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_dest_category FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE destination_images (
  id INT AUTO_INCREMENT PRIMARY KEY,
  destination_id INT NOT NULL,
  file_name VARCHAR(255) NOT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_image_destination FOREIGN KEY (destination_id) REFERENCES destinations(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE messages (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(120) NOT NULL,
  subject VARCHAR(150) NOT NULL,
  message TEXT NOT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO users (id, username, password_hash, role, created_at) VALUES
(1, 'admin', '$2y$10$9OMxmkNWPlcMrxau6nDnNO08xBQKKD.tc5Lmzds0BOFvz1bSrMH/u', 'admin', NOW());

INSERT INTO categories (id, name, slug) VALUES
(1, 'Wisata Alam', 'wisata-alam'),
(2, 'Budaya', 'budaya'),
(3, 'Kuliner', 'kuliner'),
(4, 'Event', 'event');

INSERT INTO destinations (id, category_id, name, slug, location, short_desc, content, thumbnail, is_featured, views, created_at) VALUES
(1, 1, 'Guci Hot Spring', 'guci-hot-spring', 'Bumijawa', 'Pemandian air panas di kaki Gunung Slamet dengan udara sejuk.', 'Guci dikenal sebagai ikon wisata alam Tegal dengan sumber air panas alami, area camping, serta panorama pegunungan yang menenangkan.', 'placeholder-card.svg', 1, 245, NOW()),
(2, 1, 'Waduk Cacaban', 'waduk-cacaban', 'Kedungbanteng', 'Danau buatan luas dengan pemandangan perbukitan hijau.', 'Waduk Cacaban cocok untuk rekreasi keluarga, memancing, dan menikmati sunset di tepi danau.', 'placeholder-card.svg', 1, 180, NOW()),
(3, 1, 'Pantai Alam Indah', 'pantai-alam-indah', 'Tegal Barat', 'Pantai tepi kota dengan dermaga dan kuliner laut.', 'Pantai Alam Indah menjadi destinasi favorit untuk menikmati angin laut, fasilitas rekreasi, dan spot foto keluarga.', 'placeholder-card.svg', 0, 130, NOW()),
(4, 1, 'Curug Cantel', 'curug-cantel', 'Bumijawa', 'Air terjun alami dengan trekking ringan di tengah hutan.', 'Curug Cantel menawarkan petualangan singkat dengan udara segar dan aliran air jernih yang menyejukkan.', 'placeholder-card.svg', 0, 95, NOW()),
(5, 2, 'Batik Tegalan', 'batik-tegalan', 'Tegal Kota', 'Motif batik pesisir dengan warna hangat khas Tegal.', 'Batik Tegalan dikerjakan oleh perajin lokal dengan kombinasi motif flora-fauna dan garis tegas yang kuat.', 'placeholder-card.svg', 1, 210, NOW()),
(6, 2, 'Makam Ki Gede Sebayu', 'makam-ki-gede-sebayu', 'Tegal Selatan', 'Situs sejarah pendiri Tegal yang sarat nilai budaya.', 'Makam Ki Gede Sebayu sering dikunjungi untuk mengenang sejarah berdirinya Tegal dan tradisi lokal.', 'placeholder-card.svg', 0, 64, NOW()),
(7, 3, 'Teh Poci', 'teh-poci', 'Tegal Kota', 'Tradisi minum teh wangi dengan poci tanah liat.', 'Teh Poci menjadi ikon kuliner Tegal dengan poci tanah liat dan gula batu yang khas.', 'placeholder-card.svg', 1, 300, NOW()),
(8, 3, 'Kupat Glabed', 'kupat-glabed', 'Tegal Kota', 'Kupat dengan kuah kuning kental bercita rasa gurih.', 'Kupat Glabed wajib dicoba saat berkunjung ke Tegal karena rasanya unik dan kaya rempah.', 'placeholder-card.svg', 0, 220, NOW()),
(9, 3, 'Tahu Aci', 'tahu-aci', 'Slawi', 'Camilan tahu isi aci renyah dan gurih.', 'Tahu Aci banyak dijumpai di pusat kuliner Slawi dengan sambal pedas khas.', 'placeholder-card.svg', 0, 155, NOW()),
(10, 3, 'Rujak Teplak', 'rujak-teplak', 'Slawi', 'Rujak sayur dengan bumbu kacang kental.', 'Rujak Teplak cocok untuk pencinta rasa segar dan pedas dengan sayuran lokal pilihan.', 'placeholder-card.svg', 0, 98, NOW()),
(11, 4, 'Festival Teh Poci', 'festival-teh-poci', 'Tegal Kota', 'Event tahunan yang merayakan budaya minum teh.', 'Festival Teh Poci menampilkan demo seduh teh, pameran UMKM, dan hiburan musik tradisional.', 'placeholder-card.svg', 1, 75, NOW()),
(12, 4, 'Pasar Malam Bahari', 'pasar-malam-bahari', 'Tegal Barat', 'Pasar malam dengan atraksi, kuliner, dan kerajinan lokal.', 'Pasar Malam Bahari menjadi ruang berkumpul warga dengan ragam jajanan, permainan, dan pertunjukan seni.', 'placeholder-card.svg', 0, 60, NOW());

INSERT INTO destination_images (destination_id, file_name, created_at) VALUES
(1, 'gallery-1.svg', NOW()),
(1, 'gallery-2.svg', NOW()),
(1, 'gallery-3.svg', NOW()),
(5, 'gallery-2.svg', NOW()),
(5, 'gallery-1.svg', NOW()),
(7, 'gallery-3.svg', NOW());
