CREATE TABLE `users` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nama` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `role` ENUM('mahasiswa','asisten') NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;






CREATE TABLE `praktikum` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `nama_praktikum` VARCHAR(100) NOT NULL,
  `deskripsi` TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;




CREATE TABLE praktikum_mahasiswa (
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_praktikum INT NOT NULL,
  id_mahasiswa INT NOT NULL,
  UNIQUE KEY (id_praktikum, id_mahasiswa),
  CONSTRAINT fk_pm_praktikum FOREIGN KEY (id_praktikum) REFERENCES praktikum(id) ON DELETE CASCADE,
  CONSTRAINT fk_pm_mahasiswa FOREIGN KEY (id_mahasiswa) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


INSERT INTO `praktikum` (`nama_praktikum`, `deskripsi`)
VALUES ('Pemrograman Web', 'Dasar HTML CSS PHP');

CREATE TABLE `modul` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `id_praktikum` INT,
  `nama_modul` VARCHAR(100),
  `file_materi` VARCHAR(255),
  FOREIGN KEY (`id_praktikum`) REFERENCES `praktikum`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `laporan` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `id_modul` INT,
  `id_mahasiswa` INT,
  `file_laporan` VARCHAR(255),
  `nilai` INT,
  `feedback` TEXT,
  FOREIGN KEY (`id_modul`) REFERENCES `modul`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`id_mahasiswa`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



INSERT INTO `users` (`nama`, `email`, `password`, `role`) VALUES
('Budi Mahasiswa', 'budi@example.com', '$2y$10$DqV1gbFXAo4nMZLxf59RIuGxXh6IJMnAFs8gNzIgHvtMqt8PHm7RK', 'mahasiswa'),
('Sari Mahasiswa', 'sari@example.com', '$2y$10$DqV1gbFXAo4nMZLxf59RIuGxXh6IJMnAFs8gNzIgHvtMqt8PHm7RK', 'mahasiswa'),
('Aldi Asisten', 'aldi@example.com', '$2y$10$DqV1gbFXAo4nMZLxf59RIuGxXh6IJMnAFs8gNzIgHvtMqt8PHm7RK', 'asisten');


INSERT INTO `praktikum` (`nama_praktikum`, `deskripsi`) VALUES
('Pemrograman Web', 'Modul HTML, CSS, PHP'),
('Jaringan Komputer', 'Modul TCP/IP, Routing');



INSERT INTO `modul` (`id_praktikum`, `nama_modul`, `file_materi`) VALUES
(1, 'Modul 1: HTML Dasar', 'html_dasar.pdf'),
(1, 'Modul 2: PHP Dasar', 'php_dasar.pdf'),
(2, 'Modul Jaringan 1', 'jaringan1.pdf');


INSERT INTO `laporan` (`id_modul`, `id_mahasiswa`, `file_laporan`, `nilai`, `feedback`) VALUES
(1, 1, 'laporan1_budi.pdf', 85, 'Struktur rapi, bagus.'),
(2, 2, 'laporan2_sari.pdf', NULL, NULL),
(3, 1, 'laporan3_budi.pdf', 90, 'Sudah benar semua.');
