CREATE DATABASE financesku;
USE financesku;


USE financesku;
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    PASSWORD VARCHAR(255) NOT NULL
);

-- =====================================================
-- SISTEM TRANSAKSI
-- =====================================================

-- Tabel transaksi
CREATE TABLE transaksi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_transaksi VARCHAR(20) NOT NULL UNIQUE,
    tanggal DATETIME NOT NULL,
    siswa VARCHAR(100) NOT NULL,
    jenis_pembayaran VARCHAR(100) NOT NULL,
    jumlah DECIMAL(10,0) NOT NULL,
    STATUS ENUM('Berhasil', 'Pending', 'Gagal') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Menambahkan index untuk optimasi query
CREATE INDEX idx_id_transaksi ON transaksi(id_transaksi);
CREATE INDEX idx_tanggal ON transaksi(tanggal);
CREATE INDEX idx_status ON transaksi(STATUS);
CREATE INDEX idx_siswa ON transaksi(siswa);

-- Insert data sesuai dengan gambar
INSERT INTO transaksi (id_transaksi, tanggal, siswa, jenis_pembayaran, jumlah, STATUS) VALUES
('TX-240001', '2024-04-10 10:30:00', 'Ahmad Rizki', 'SPP Bulan Maret', 350000, 'Berhasil'),
('TX-240002', '2024-04-10 09:15:00', 'Siti Nurhaliza', 'Uang Gedung', 2500000, 'Berhasil'),
('TX-240003', '2024-04-10 08:45:00', 'Budi Santoso', 'Seragam', 150000, 'Pending'),
('TX-240004', '2024-04-10 08:30:00', 'Rina Maharani', 'SPP Bulan Februari', 350000, 'Berhasil'),
('TX-240005', '2024-04-10 07:45:00', 'Dedi Kurniawan', 'Praktikum', 100000, 'Gagal');

-- Query untuk melihat semua transaksi (sesuai tampilan di gambar)
SELECT 
    id_transaksi AS 'ID Transaksi',
    DATE_FORMAT(tanggal, '%Y-%m-%d %H:%i') AS 'Tanggal',
    siswa AS 'Siswa',
    jenis_pembayaran AS 'Jenis Pembayaran',
    CONCAT('Rp ', FORMAT(jumlah, 0)) AS 'Jumlah',
    STATUS AS 'Status'
FROM transaksi 
ORDER BY tanggal DESC;

-- Query untuk transaksi berhasil saja
SELECT * FROM transaksi WHERE STATUS = 'Berhasil';

-- Query untuk menghitung total per status
SELECT 
    STATUS,
    COUNT(*) AS jumlah_transaksi,
    SUM(jumlah) AS total_nominal
FROM transaksi 
GROUP BY STATUS;

-- Query untuk transaksi hari ini
SELECT * FROM transaksi 
WHERE DATE(tanggal) = CURDATE();

-- Query untuk mencari transaksi berdasarkan nama siswa
SELECT * FROM transaksi 
WHERE siswa LIKE '%nama_siswa%';

-- Query untuk transaksi dalam rentang tanggal
SELECT * FROM transaksi 
WHERE tanggal BETWEEN '2024-04-01' AND '2024-04-30';

-- Stored procedure untuk menambah transaksi baru
DELIMITER //
CREATE PROCEDURE TambahTransaksi(
    IN p_id_transaksi VARCHAR(20),
    IN p_tanggal DATETIME,
    IN p_siswa VARCHAR(100),
    IN p_jenis_pembayaran VARCHAR(100),
    IN p_jumlah DECIMAL(10,0),
    IN p_status ENUM('Berhasil', 'Pending', 'Gagal')
)
BEGIN
    INSERT INTO transaksi (id_transaksi, tanggal, siswa, jenis_pembayaran, jumlah, STATUS)
    VALUES (p_id_transaksi, p_tanggal, p_siswa, p_jenis_pembayaran, p_jumlah, p_status);
END //
DELIMITER ;

-- Function untuk generate ID transaksi otomatis
DELIMITER //
CREATE FUNCTION GenerateTransactionID() RETURNS VARCHAR(20)
READS SQL DATA
DETERMINISTIC
BEGIN
    DECLARE next_num INT;
    DECLARE new_id VARCHAR(20);
    
    SELECT COALESCE(MAX(CAST(SUBSTRING(id_transaksi, 4) AS UNSIGNED)), 240000) + 1 
    INTO next_num 
    FROM transaksi 
    WHERE id_transaksi LIKE 'TX-%';
    
    SET new_id = CONCAT('TX-', LPAD(next_num, 6, '0'));
    
    RETURN new_id;
END //
DELIMITER ;

-- =====================================================
-- SISTEM MANAJEMEN SISWA
-- =====================================================

-- Tabel kelas
CREATE TABLE kelas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_kelas VARCHAR(10) NOT NULL,
    tingkat INT NOT NULL,
    jurusan VARCHAR(50),
    wali_kelas VARCHAR(100),
    kapasitas INT DEFAULT 40,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel jenis kelamin (lookup)
CREATE TABLE jenis_kelamin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kode VARCHAR(1) NOT NULL,
    nama VARCHAR(20) NOT NULL
);

-- Tabel status siswa (lookup)  
CREATE TABLE status_siswa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kode VARCHAR(20) NOT NULL,
    nama VARCHAR(50) NOT NULL,
    warna VARCHAR(20)
);

-- Tabel siswa
CREATE TABLE siswa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nisn BIGINT(10) NOT NULL UNIQUE,
    nis INT(6) NOT NULL UNIQUE,
    nama_lengkap VARCHAR(100) NOT NULL,
    kelas_id INT,
    jenis_kelamin_id INT,
    tanggal_lahir DATE,
    alamat TEXT,
    no_telepon VARCHAR(15),
    nama_ayah VARCHAR(100),
    nama_ibu VARCHAR(100),
    pekerjaan_ortu VARCHAR(100),
    status_id INT,
    tunggakan DECIMAL(10,0) DEFAULT 0,
    foto VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (kelas_id) REFERENCES kelas(id),
    FOREIGN KEY (jenis_kelamin_id) REFERENCES jenis_kelamin(id),
    FOREIGN KEY (status_id) REFERENCES status_siswa(id)
);

-- Insert data master untuk kelas
INSERT INTO kelas (nama_kelas, tingkat, jurusan) VALUES
('XII IPA 1', 12, 'IPA'),
('XII IPS 1', 12, 'IPS'),
('X IPA 2', 10, 'IPA'),
('XII IPS 2', 12, 'IPS'),
('XII IPA 1', 12, 'IPA');

-- Insert data master jenis kelamin
INSERT INTO jenis_kelamin (kode, nama) VALUES
('L', 'Laki-laki'),
('P', 'Perempuan');

-- Insert data master status siswa
INSERT INTO status_siswa (kode, nama, warna) VALUES
('aktif', 'Aktif', 'green'),
('tidak_aktif', 'Tidak Aktif', 'yellow'),
('lulus', 'Lulus', 'blue'),
('pindah', 'Pindah', 'red'),
('dropout', 'Dropout', 'gray');

-- Insert data siswa sesuai gambar
INSERT INTO siswa (nisn, nis, nama_lengkap, kelas_id, jenis_kelamin_id, nama_ayah, nama_ibu, pekerjaan_ortu, status_id, tunggakan) VALUES
(0012345678, 202401, 'Ahmad Rizki Pratama', 1, 1, 'Budi Pratama', 'Siti Aminah', 'Wiraswasta', 1, 0),
(0012345679, 202402, 'Siti Nurhaliza', 2, 2, 'Ahmad Salim', 'Fatimah', 'PNS', 1, 350000),
(0012345680, 202403, 'Budi Santoso', 3, 1, 'Santoso', 'Maryam', 'Petani', 1, 150000),
(0012345681, 202404, 'Rina Maharani', 4, 2, 'Joko Susilo', 'Ratna Sari', 'Pedagang', 2, 700000),
(0012345682, 202405, 'Dedi Kurniawan', 1, 1, 'Kurniawan', 'Sri Lestari', 'Buruh', 1, 0);

-- Update relasi kelas pada siswa
UPDATE siswa SET kelas_id = 1 WHERE nis = 202401;
UPDATE siswa SET kelas_id = 2 WHERE nis = 202402;
UPDATE siswa SET kelas_id = 3 WHERE nis = 202403;
UPDATE siswa SET kelas_id = 4 WHERE nis = 202404;
UPDATE siswa SET kelas_id = 1 WHERE nis = 202405;

-- View untuk dashboard statistics
CREATE VIEW dashboard_stats AS
SELECT 
    (SELECT COUNT(*) FROM siswa WHERE status_id = 1) AS total_siswa_aktif,
    (SELECT COUNT(*) FROM siswa WHERE status_id = 1 AND DATE(created_at) = CURDATE()) AS siswa_baru_hari_ini,
    (SELECT COUNT(*) FROM siswa WHERE tunggakan > 0) AS siswa_menunggak,
    (SELECT COUNT(*) FROM siswa WHERE status_id IN (4,5)) AS siswa_tidak_aktif;

-- Query untuk menampilkan daftar siswa (sesuai tampilan di gambar)
SELECT 
    s.nisn AS NISN,
    s.nis AS NIS,
    s.nama_lengkap AS Nama,
    k.nama_kelas AS Kelas,
    jk.kode AS 'L/P',
    CASE 
        WHEN ss.kode = 'aktif' THEN 'Aktif'
        WHEN ss.kode = 'tidak_aktif' THEN 'Tidak Aktif'
        ELSE ss.nama
    END AS STATUS,
    CONCAT('Rp ', FORMAT(s.tunggakan, 0)) AS Tunggakan
FROM siswa s
LEFT JOIN kelas k ON s.kelas_id = k.id
LEFT JOIN jenis_kelamin jk ON s.jenis_kelamin_id = jk.id
LEFT JOIN status_siswa ss ON s.status_id = ss.id
ORDER BY s.nis;

-- Query dashboard statistics
SELECT * FROM dashboard_stats;

-- Stored procedure untuk tambah siswa baru
DELIMITER //
CREATE PROCEDURE TambahSiswa(
    IN p_nisn BIGINT(10),
    IN p_nis INT(6),
    IN p_nama_lengkap VARCHAR(100),
    IN p_kelas VARCHAR(10),
    IN p_jenis_kelamin VARCHAR(1),
    IN p_tanggal_lahir DATE,
    IN p_alamat TEXT,
    IN p_no_telepon VARCHAR(15),
    IN p_nama_ayah VARCHAR(100),
    IN p_nama_ibu VARCHAR(100),
    IN p_pekerjaan_ortu VARCHAR(100)
)
BEGIN
    DECLARE kelas_id_var INT;
    DECLARE jk_id_var INT;
    DECLARE status_id_var INT DEFAULT 1; -- Default aktif
    
    -- Get kelas ID
    SELECT id INTO kelas_id_var FROM kelas WHERE nama_kelas = p_kelas LIMIT 1;
    
    -- Get jenis kelamin ID
    SELECT id INTO jk_id_var FROM jenis_kelamin WHERE kode = p_jenis_kelamin;
    
    -- Insert siswa baru
    INSERT INTO siswa (
        nisn, nis, nama_lengkap, kelas_id, jenis_kelamin_id, 
        tanggal_lahir, alamat, no_telepon, nama_ayah, nama_ibu, 
        pekerjaan_ortu, status_id, tunggakan
    ) VALUES (
        p_nisn, p_nis, p_nama_lengkap, kelas_id_var, jk_id_var,
        p_tanggal_lahir, p_alamat, p_no_telepon, p_nama_ayah, p_nama_ibu,
        p_pekerjaan_ortu, status_id_var, 0
    );
END //
DELIMITER ;

-- Query untuk pencarian siswa
DELIMITER //
CREATE PROCEDURE CariSiswa(IN search_term VARCHAR(100))
BEGIN
    SELECT 
        s.nisn,
        s.nis,
        s.nama_lengkap,
        k.nama_kelas,
        jk.nama AS jenis_kelamin,
        ss.nama AS STATUS,
        s.tunggakan
    FROM siswa s
    LEFT JOIN kelas k ON s.kelas_id = k.id
    LEFT JOIN jenis_kelamin jk ON s.jenis_kelamin_id = jk.id
    LEFT JOIN status_siswa ss ON s.status_id = ss.id
    WHERE s.nama_lengkap LIKE CONCAT('%', search_term, '%')
       OR s.nisn LIKE CONCAT('%', search_term, '%')
       OR s.nis LIKE CONCAT('%', search_term, '%')
       OR k.nama_kelas LIKE CONCAT('%', search_term, '%');
END //
DELIMITER ;

-- Index untuk optimasi
CREATE INDEX idx_siswa_nisn ON siswa(nisn);
CREATE INDEX idx_siswa_nis ON siswa(nis);
CREATE INDEX idx_siswa_nama ON siswa(nama_lengkap);
CREATE INDEX idx_siswa_kelas ON siswa(kelas_id);
CREATE INDEX idx_siswa_status ON siswa(status_id);

-- Query laporan tunggakan
SELECT 
    s.nama_lengkap,
    k.nama_kelas,
    s.tunggakan,
    CASE 
        WHEN s.tunggakan = 0 THEN 'Lunas'
        WHEN s.tunggakan > 0 AND s.tunggakan <= 500000 THEN 'Tunggakan Ringan'
        ELSE 'Tunggakan Berat'
    END AS kategori_tunggakan
FROM siswa s
LEFT JOIN kelas k ON s.kelas_id = k.id
WHERE s.tunggakan > 0
ORDER BY s.tunggakan DESC;

-- =====================================================
-- SISTEM PEMBAYARAN LENGKAP
-- =====================================================

-- Tabel jenis pembayaran
CREATE TABLE jenis_pembayaran (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kode VARCHAR(20) NOT NULL UNIQUE,
    nama VARCHAR(100) NOT NULL,
    nominal_default DECIMAL(10,0) DEFAULT 0,
    periode ENUM('Bulanan', 'Semesteran', 'Tahunan', 'Sekali') DEFAULT 'Sekali',
    aktif BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel metode pembayaran
CREATE TABLE metode_pembayaran (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kode VARCHAR(20) NOT NULL,
    nama VARCHAR(50) NOT NULL,
    biaya_admin DECIMAL(10,0) DEFAULT 0,
    aktif BOOLEAN DEFAULT TRUE
);

-- Update tabel transaksi untuk relasi yang lebih baik
ALTER TABLE transaksi 
ADD COLUMN siswa_id INT,
ADD COLUMN jenis_pembayaran_id INT,
ADD COLUMN metode_pembayaran_id INT,
ADD COLUMN periode VARCHAR(50),
ADD COLUMN terbayar DECIMAL(10,0) DEFAULT 0,
ADD COLUMN keterangan TEXT,
ADD FOREIGN KEY (siswa_id) REFERENCES siswa(id),
ADD FOREIGN KEY (jenis_pembayaran_id) REFERENCES jenis_pembayaran(id),
ADD FOREIGN KEY (metode_pembayaran_id) REFERENCES metode_pembayaran(id);

-- Insert data master jenis pembayaran
INSERT INTO jenis_pembayaran (kode, nama, nominal_default, periode) VALUES
('SPP', 'SPP', 350000, 'Bulanan'),
('UANG_GEDUNG', 'Uang Gedung', 2500000, 'Tahunan'),
('SERAGAM', 'Seragam', 150000, 'Sekali'),
('PRAKTIKUM', 'Praktikum', 100000, 'Semesteran'),
('UJIAN', 'Biaya Ujian', 200000, 'Semesteran');

-- Insert data metode pembayaran
INSERT INTO metode_pembayaran (kode, nama, biaya_admin) VALUES
('TUNAI', 'Tunai', 0),
('TRANSFER', 'Transfer Bank', 2500),
('QRIS', 'QRIS', 1000),
('E_WALLET', 'E-Wallet', 1500);

-- Tabel tagihan untuk tracking pembayaran per siswa
CREATE TABLE tagihan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    siswa_id INT NOT NULL,
    jenis_pembayaran_id INT NOT NULL,
    periode VARCHAR(50) NOT NULL,
    jumlah_tagihan DECIMAL(10,0) NOT NULL,
    terbayar DECIMAL(10,0) DEFAULT 0,
    sisa_tagihan DECIMAL(10,0) GENERATED ALWAYS AS (jumlah_tagihan - terbayar) STORED,
    tanggal_jatuh_tempo DATE,
    status_tagihan ENUM('Belum Dibayar', 'Sebagian', 'Lunas', 'Terlambat') DEFAULT 'Belum Dibayar',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (siswa_id) REFERENCES siswa(id),
    FOREIGN KEY (jenis_pembayaran_id) REFERENCES jenis_pembayaran(id)
);

-- Insert tagihan sample untuk siswa
INSERT INTO tagihan (siswa_id, jenis_pembayaran_id, periode, jumlah_tagihan, terbayar, tanggal_jatuh_tempo, status_tagihan) VALUES
(2, 1, 'Februari 2024', 350000, 0, '2024-02-28', 'Belum Dibayar'),
(3, 3, 'Seragam 2024', 150000, 0, '2024-05-01', 'Belum Dibayar'),
(4, 1, 'Januari 2024', 350000, 0, '2024-01-31', 'Terlambat');

-- View untuk dashboard pembayaran
CREATE VIEW dashboard_pembayaran AS
SELECT 
    (SELECT SUM(jumlah) FROM transaksi WHERE STATUS = 'Berhasil') AS total_pembayaran_sukses,
    (SELECT COUNT(*) FROM transaksi WHERE DATE(tanggal) = CURDATE() AND STATUS = 'Berhasil') AS transaksi_berhasil_hari_ini,
    (SELECT COUNT(*) FROM transaksi WHERE STATUS = 'Pending') AS pembayaran_pending,
    (SELECT SUM(sisa_tagihan) FROM tagihan WHERE status_tagihan IN ('Belum Dibayar', 'Sebagian', 'Terlambat')) AS total_tunggakan;

-- Update data transaksi untuk relasi dengan siswa
UPDATE transaksi t 
JOIN siswa s ON s.nama_lengkap = t.siswa 
SET t.siswa_id = s.id;

UPDATE transaksi t 
JOIN jenis_pembayaran jp ON jp.nama = t.jenis_pembayaran
SET t.jenis_pembayaran_id = jp.id;

-- Query untuk proses pembayaran baru (sesuai form di gambar)
DELIMITER //
CREATE PROCEDURE ProsesPembayaranBaru(
    IN p_cari_siswa VARCHAR(100),
    IN p_metode_pembayaran VARCHAR(20),
    IN p_jenis_pembayaran VARCHAR(100),
    IN p_periode VARCHAR(50),
    IN p_jumlah DECIMAL(10,0),
    IN p_keterangan TEXT
)
BEGIN
    DECLARE v_siswa_id INT;
    DECLARE v_jenis_id INT;
    DECLARE v_metode_id INT;
    DECLARE v_id_transaksi VARCHAR(20);
    
    -- Cari siswa berdasarkan nama/NISN/NIS
    SELECT id INTO v_siswa_id 
    FROM siswa 
    WHERE nama_lengkap LIKE CONCAT('%', p_cari_siswa, '%')
       OR nisn = p_cari_siswa
       OR nis = p_cari_siswa
    LIMIT 1;
    
    -- Get jenis pembayaran ID
    SELECT id INTO v_jenis_id 
    FROM jenis_pembayaran 
    WHERE nama = p_jenis_pembayaran;
    
    -- Get metode pembayaran ID
    SELECT id INTO v_metode_id 
    FROM metode_pembayaran 
    WHERE nama = p_metode_pembayaran;
    
    -- Generate ID transaksi
    SET v_id_transaksi = (SELECT GenerateTransactionID());
    
    -- Insert transaksi
    INSERT INTO transaksi (
        id_transaksi, tanggal, siswa_id, jenis_pembayaran_id, 
        metode_pembayaran_id, periode, jumlah, terbayar, 
        STATUS, keterangan
    ) VALUES (
        v_id_transaksi, NOW(), v_siswa_id, v_jenis_id,
        v_metode_id, p_periode, p_jumlah, p_jumlah,
        'Berhasil', p_keterangan
    );
    
    -- Update tagihan jika ada
    UPDATE tagihan 
    SET terbayar = terbayar + p_jumlah,
        status_tagihan = CASE 
            WHEN (terbayar + p_jumlah) >= jumlah_tagihan THEN 'Lunas'
            WHEN (terbayar + p_jumlah) > 0 THEN 'Sebagian'
            ELSE 'Belum Dibayar'
        END
    WHERE siswa_id = v_siswa_id 
      AND jenis_pembayaran_id = v_jenis_id 
      AND periode = p_periode;
    
    SELECT v_id_transaksi AS id_transaksi;
END //
DELIMITER ;

-- Query riwayat pembayaran (sesuai tabel di gambar)
SELECT 
    t.id_transaksi AS 'ID Transaksi',
    DATE_FORMAT(t.tanggal, '%d/%m/%Y %H:%i') AS 'Tanggal',
    s.nama_lengkap AS 'Siswa',
    jp.nama AS 'Jenis Pembayaran',
    t.periode AS 'Periode',
    CONCAT('Rp ', FORMAT(t.jumlah, 0)) AS 'Jumlah',
    mp.nama AS 'Metode',
    CASE 
        WHEN t.status = 'Berhasil' THEN 'Berhasil'
        WHEN t.status = 'Pending' THEN 'Pending'
        ELSE 'Gagal'
    END AS 'Status'
FROM transaksi t
LEFT JOIN siswa s ON t.siswa_id = s.id
LEFT JOIN jenis_pembayaran jp ON t.jenis_pembayaran_id = jp.id
LEFT JOIN metode_pembayaran mp ON t.metode_pembayaran_id = mp.id
ORDER BY t.tanggal DESC;

-- Query untuk tanggungan pembayaran (tabel bawah di gambar)
SELECT 
    s.nama_lengkap AS 'Siswa',
    k.nama_kelas AS 'Kelas',
    jp.nama AS 'Jenis Pembayaran',
    t.periode AS 'Periode',
    CONCAT('Rp ', FORMAT(t.jumlah_tagihan, 0)) AS 'Jumlah',
    CONCAT(DATEDIFF(CURDATE(), t.tanggal_jatuh_tempo), ' hari') AS 'Terlambat'
FROM tagihan t
JOIN siswa s ON t.siswa_id = s.id
JOIN kelas k ON s.kelas_id = k.id
JOIN jenis_pembayaran jp ON t.jenis_pembayaran_id = jp.id
WHERE t.status_tagihan IN ('Belum Dibayar', 'Terlambat')
ORDER BY t.tanggal_jatuh_tempo ASC;

-- Query dashboard stats (sesuai cards di atas)
SELECT 
    CONCAT('Rp ', FORMAT(
        (SELECT COALESCE(SUM(jumlah), 0) FROM transaksi WHERE STATUS = 'Berhasil'), 0)
    ) AS 'Pembayaran Sukses',
    
    (SELECT COUNT(*) FROM transaksi 
     WHERE DATE(tanggal) = CURDATE() AND STATUS = 'Berhasil'
    ) AS 'Transaksi Berhasil',
    
    (SELECT COUNT(*) FROM transaksi WHERE STATUS = 'Pending') AS 'Pembayaran Pending',
    
    CONCAT('Rp ', FORMAT(
        (SELECT COALESCE(SUM(sisa_tagihan), 0) FROM tagihan 
         WHERE status_tagihan IN ('Belum Dibayar', 'Sebagian', 'Terlambat')), 0)
    ) AS 'Total Tunggakan';

-- Function untuk generate nomor referensi/bukti
DELIMITER //
CREATE FUNCTION GenerateNomorReferensi() RETURNS VARCHAR(20)
READS SQL DATA
DETERMINISTIC
BEGIN
    DECLARE next_num INT;
    DECLARE new_ref VARCHAR(20);
    
    SELECT COALESCE(MAX(CAST(SUBSTRING(id_transaksi, 4) AS UNSIGNED)), 240000) + 1 
    INTO next_num 
    FROM transaksi;
    
    SET new_ref = CONCAT('REF-', LPAD(next_num, 6, '0'));
    
    RETURN new_ref;
END //
DELIMITER ;

-- Index untuk optimasi query pembayaran
CREATE INDEX idx_transaksi_siswa ON transaksi(siswa_id);
CREATE INDEX idx_transaksi_tanggal ON transaksi(tanggal);
CREATE INDEX idx_transaksi_jenis ON transaksi(jenis_pembayaran_id);
CREATE INDEX idx_tagihan_siswa ON tagihan(siswa_id);
CREATE INDEX idx_tagihan_status ON tagihan(status_tagihan);

-- Query laporan keuangan bulanan
SELECT 
    DATE_FORMAT(tanggal, '%Y-%m') AS bulan,
    COUNT(*) AS total_transaksi,
    SUM(CASE WHEN STATUS = 'Berhasil' THEN jumlah ELSE 0 END) AS total_berhasil,
    SUM(CASE WHEN STATUS = 'Pending' THEN jumlah ELSE 0 END) AS total_pending,
    SUM(CASE WHEN STATUS = 'Gagal' THEN jumlah ELSE 0 END) AS total_gagal
FROM transaksi 
GROUP BY DATE_FORMAT(tanggal, '%Y-%m')
ORDER BY bulan DESC;

-- =====================================================
-- SISTEM LAPORAN KEUANGAN
-- =====================================================

-- Tabel laporan keuangan
CREATE TABLE laporan_keuangan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tanggal_laporan DATE NOT NULL,
    jenis_laporan VARCHAR(50) NOT NULL,
    deskripsi TEXT NOT NULL,
    total_pemasukan DECIMAL(15,0) DEFAULT 0,
    total_pengeluaran DECIMAL(15,0) DEFAULT 0,
    saldo DECIMAL(15,0) GENERATED ALWAYS AS (total_pemasukan - total_pengeluaran) STORED,
    periode_dari DATE,
    periode_sampai DATE,
    status_laporan ENUM('Draft', 'Pending', 'Selesai', 'Gagal') DEFAULT 'Draft',
    dibuat_oleh VARCHAR(100),
    file_export VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel detail laporan untuk breakdown per jenis pembayaran
CREATE TABLE detail_laporan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    laporan_id INT NOT NULL,
    jenis_pembayaran_id INT,
    kelas_id INT,
    jumlah_transaksi INT DEFAULT 0,
    total_nominal DECIMAL(15,0) DEFAULT 0,
    rata_rata DECIMAL(15,2) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (laporan_id) REFERENCES laporan_keuangan(id) ON DELETE CASCADE,
    FOREIGN KEY (jenis_pembayaran_id) REFERENCES jenis_pembayaran(id),
    FOREIGN KEY (kelas_id) REFERENCES kelas(id)
);

-- Insert data laporan sesuai gambar
INSERT INTO laporan_keuangan (tanggal_laporan, jenis_laporan, deskripsi, total_pemasukan, periode_dari, periode_sampai, status_laporan) VALUES
('2024-06-25', 'SPP Bulanan', 'Pembayaran SPP bulan Juni 2024', 45000000, '2024-06-01', '2024-06-30', 'Selesai'),
('2024-06-15', 'Uang Gedung', 'Penerimaan uang gedung periode Juni 2024', 120000000, '2024-06-01', '2024-06-30', 'Selesai'),
('2024-05-30', 'Praktikum', 'Laporan pembayaran praktikum bulan Mei 2024', 15000000, '2024-05-01', '2024-05-31', 'Pending'),
('2024-05-20', 'Seragam', 'Laporan pembayaran seragam periode Mei 2024', 8500000, '2024-05-01', '2024-05-31', 'Selesai'),
('2024-04-10', 'Uang Lab', 'Penerimaan uang laboratorium periode April 2024', 7000000, '2024-04-01', '2024-04-30', 'Gagal');

-- View untuk laporan keuangan (sesuai tabel di gambar)
CREATE VIEW v_laporan_keuangan AS
SELECT 
    DATE_FORMAT(tanggal_laporan, '%Y-%m-%d') AS 'Tanggal',
    jenis_laporan AS 'Jenis Laporan',
    deskripsi AS 'Deskripsi',
    CONCAT('Rp ', FORMAT(total_pemasukan, 0)) AS 'Jumlah',
    CASE 
        WHEN status_laporan = 'Selesai' THEN 'Selesai'
        WHEN status_laporan = 'Pending' THEN 'Pending'
        WHEN status_laporan = 'Gagal' THEN 'Gagal'
        ELSE 'Draft'
    END AS 'Status',
    id
FROM laporan_keuangan
ORDER BY tanggal_laporan DESC;

-- Stored procedure untuk generate laporan otomatis
DELIMITER //
CREATE PROCEDURE GenerateLaporanBulanan(
    IN p_tahun INT,
    IN p_bulan INT,
    IN p_jenis_laporan VARCHAR(50)
)
BEGIN
    DECLARE v_total_pemasukan DECIMAL(15,0);
    DECLARE v_periode_dari DATE;
    DECLARE v_periode_sampai DATE;
    DECLARE v_deskripsi TEXT;
    DECLARE v_laporan_id INT;
    
    -- Set periode
    SET v_periode_dari = DATE(CONCAT(p_tahun, '-', LPAD(p_bulan, 2, '0'), '-01'));
    SET v_periode_sampai = LAST_DAY(v_periode_dari);
    
    -- Hitung total berdasarkan jenis laporan
    IF p_jenis_laporan = 'SPP Bulanan' THEN
        SELECT COALESCE(SUM(t.jumlah), 0) INTO v_total_pemasukan
        FROM transaksi t
        JOIN jenis_pembayaran jp ON t.jenis_pembayaran_id = jp.id
        WHERE jp.kode = 'SPP'
        AND DATE(t.tanggal) BETWEEN v_periode_dari AND v_periode_sampai
        AND t.status = 'Berhasil';
        
        SET v_deskripsi = CONCAT('Pembayaran SPP bulan ', MONTHNAME(v_periode_dari), ' ', p_tahun);
        
    ELSEIF p_jenis_laporan = 'Semua Pembayaran' THEN
        SELECT COALESCE(SUM(jumlah), 0) INTO v_total_pemasukan
        FROM transaksi
        WHERE DATE(tanggal) BETWEEN v_periode_dari AND v_periode_sampai
        AND STATUS = 'Berhasil';
        
        SET v_deskripsi = CONCAT('Seluruh pembayaran periode ', MONTHNAME(v_periode_dari), ' ', p_tahun);
    END IF;
    
    -- Insert laporan
    INSERT INTO laporan_keuangan (
        tanggal_laporan, jenis_laporan, deskripsi, total_pemasukan,
        periode_dari, periode_sampai, status_laporan
    ) VALUES (
        CURDATE(), p_jenis_laporan, v_deskripsi, v_total_pemasukan,
        v_periode_dari, v_periode_sampai, 'Selesai'
    );
    
    SET v_laporan_id = LAST_INSERT_ID();
    
    -- Insert detail laporan per jenis pembayaran
    INSERT INTO detail_laporan (laporan_id, jenis_pembayaran_id, jumlah_transaksi, total_nominal, rata_rata)
    SELECT 
        v_laporan_id,
        jp.id,
        COUNT(t.id),
        COALESCE(SUM(t.jumlah), 0),
        COALESCE(AVG(t.jumlah), 0)
    FROM jenis_pembayaran jp
    LEFT JOIN transaksi t ON jp.id = t.jenis_pembayaran_id 
        AND DATE(t.tanggal) BETWEEN v_periode_dari AND v_periode_sampai
        AND t.status = 'Berhasil'
    GROUP BY jp.id;
    
    SELECT v_laporan_id AS laporan_id;
END //
DELIMITER ;

-- Query untuk cetak laporan (export data)
DELIMITER //
CREATE PROCEDURE CetakLaporan(IN p_laporan_id INT)
BEGIN
    -- Header laporan
    SELECT 
        'LAPORAN KEUANGAN SEKOLAH' AS header,
        jenis_laporan,
        deskripsi,
        DATE_FORMAT(periode_dari, '%d %M %Y') AS periode_dari,
        DATE_FORMAT(periode_sampai, '%d %M %Y') AS periode_sampai,
        DATE_FORMAT(tanggal_laporan, '%d %M %Y') AS tanggal_laporan,
        CONCAT('Rp ', FORMAT(total_pemasukan, 0)) AS total_pemasukan_format,
        status_laporan
    FROM laporan_keuangan
    WHERE id = p_laporan_id;
    
    -- Detail per jenis pembayaran
    SELECT 
        jp.nama AS jenis_pembayaran,
        dl.jumlah_transaksi,
        CONCAT('Rp ', FORMAT(dl.total_nominal, 0)) AS total_nominal,
        CONCAT('Rp ', FORMAT(dl.rata_rata, 0)) AS rata_rata
    FROM detail_laporan dl
    JOIN jenis_pembayaran jp ON dl.jenis_pembayaran_id = jp.id
    WHERE dl.laporan_id = p_laporan_id
    AND dl.total_nominal > 0
    ORDER BY dl.total_nominal DESC;
    
    -- Detail transaksi
    SELECT 
        t.id_transaksi,
        DATE_FORMAT(t.tanggal, '%d/%m/%Y %H:%i') AS tanggal,
        s.nama_lengkap AS siswa,
        k.nama_kelas AS kelas,
        jp.nama AS jenis_pembayaran,
        t.periode,
        CONCAT('Rp ', FORMAT(t.jumlah, 0)) AS jumlah,
        mp.nama AS metode,
        t.status
    FROM transaksi t
    JOIN laporan_keuangan lk ON DATE(t.tanggal) BETWEEN lk.periode_dari AND lk.periode_sampai
    LEFT JOIN siswa s ON t.siswa_id = s.id
    LEFT JOIN kelas k ON s.kelas_id = k.id
    LEFT JOIN jenis_pembayaran jp ON t.jenis_pembayaran_id = jp.id
    LEFT JOIN metode_pembayaran mp ON t.metode_pembayaran_id = mp.id
    WHERE lk.id = p_laporan_id
    AND t.status = 'Berhasil'
    ORDER BY t.tanggal DESC;
END //
DELIMITER ;

-- Query untuk export CSV (format untuk download)
SELECT 
    'Tanggal,Jenis Laporan,Deskripsi,Jumlah,Status' AS csv_header
UNION ALL
SELECT 
    CONCAT(
        DATE_FORMAT(tanggal_laporan, '%Y-%m-%d'), ',',
        REPLACE(jenis_laporan, ',', ' '), ',',
        REPLACE(deskripsi, ',', ' '), ',',
        total_pemasukan, ',',
        status_laporan
    ) AS csv_row
FROM laporan_keuangan
ORDER BY tanggal_laporan DESC;

-- Function untuk menghitung total pendapatan periode
DELIMITER //
CREATE FUNCTION HitungPendapatanPeriode(
    p_tanggal_dari DATE,
    p_tanggal_sampai DATE,
    p_jenis_pembayaran VARCHAR(50)
) RETURNS DECIMAL(15,0)
READS SQL DATA
DETERMINISTIC
BEGIN
    DECLARE total DECIMAL(15,0);
    
    IF p_jenis_pembayaran = 'SEMUA' THEN
        SELECT COALESCE(SUM(jumlah), 0) INTO total
        FROM transaksi
        WHERE DATE(tanggal) BETWEEN p_tanggal_dari AND p_tanggal_sampai
        AND STATUS = 'Berhasil';
    ELSE
        SELECT COALESCE(SUM(t.jumlah), 0) INTO total
        FROM transaksi t
        JOIN jenis_pembayaran jp ON t.jenis_pembayaran_id = jp.id
        WHERE DATE(t.tanggal) BETWEEN p_tanggal_dari AND p_tanggal_sampai
        AND jp.kode = p_jenis_pembayaran
        AND t.status = 'Berhasil';
    END IF;
    
    RETURN total;
END //
DELIMITER ;

-- Query dashboard laporan
SELECT 
    COUNT(*) AS total_laporan,
    SUM(CASE WHEN status_laporan = 'Selesai' THEN 1 ELSE 0 END) AS laporan_selesai,
    SUM(CASE WHEN status_laporan = 'Pending' THEN 1 ELSE 0 END) AS laporan_pending,
    SUM(CASE WHEN status_laporan = 'Gagal' THEN 1 ELSE 0 END) AS laporan_gagal,
    SUM(CASE WHEN status_laporan = 'Selesai' THEN total_pemasukan ELSE 0 END) AS total_pendapatan_tercatat
FROM laporan_keuangan;

-- Query laporan harian untuk monitoring
SELECT 
    DATE(tanggal) AS tanggal,
    COUNT(*) AS jumlah_transaksi,
    SUM(CASE WHEN STATUS = 'Berhasil' THEN jumlah ELSE 0 END) AS total_berhasil,
    SUM(CASE WHEN STATUS = 'Pending' THEN jumlah ELSE 0 END) AS total_pending,
    SUM(CASE WHEN STATUS = 'Gagal' THEN jumlah ELSE 0 END) AS total_gagal
FROM transaksi
WHERE DATE(tanggal) >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
GROUP BY DATE(tanggal)
ORDER BY tanggal DESC;

-- Index untuk optimasi laporan
CREATE INDEX idx_laporan_tanggal ON laporan_keuangan(tanggal_laporan);
CREATE INDEX idx_laporan_periode ON laporan_keuangan(periode_dari, periode_sampai);
CREATE INDEX idx_laporan_status ON laporan_keuangan(status_laporan);
CREATE INDEX idx_detail_laporan ON detail_laporan(laporan_id);

-- =====================================================
-- SISTEM AKUN KAS
-- =====================================================

-- Tabel untuk menyimpan data akun kas
CREATE TABLE akun_kas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_akun VARCHAR(100) NOT NULL,
    deskripsi TEXT,
    saldo DECIMAL(15,2) DEFAULT 0.00,
    STATUS ENUM('aktif', 'nonaktif') DEFAULT 'aktif',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel untuk menyimpan transaksi kas
CREATE TABLE transaksi_kas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    akun_kas_id INT NOT NULL,
    jenis_transaksi ENUM('masuk', 'keluar') NOT NULL,
    jumlah DECIMAL(15,2) NOT NULL,
    keterangan TEXT,
    tanggal_transaksi DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (akun_kas_id) REFERENCES akun_kas(id) ON DELETE CASCADE
);

-- Tabel untuk menyimpan kategori transaksi (opsional)
CREATE TABLE kategori_transaksi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_kategori VARCHAR(50) NOT NULL,
    deskripsi TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Menambahkan kolom kategori ke tabel transaksi_kas
ALTER TABLE transaksi_kas 
ADD COLUMN kategori_id INT,
ADD FOREIGN KEY (kategori_id) REFERENCES kategori_transaksi(id);

-- Insert data awal berdasarkan gambar
INSERT INTO akun_kas (nama_akun, deskripsi, saldo) VALUES
('Kas Utama', 'Kas utama untuk semua penerimaan dan pengeluaran', 120000000.00),
('Kas Proyek Renovasi', 'Dana khusus untuk proyek renovasi gedung sekolah', 75000000.00),
('Kas Ekstrakurikuler', 'Kas untuk kegiatan ekstrakurikuler dan acara siswa', 18500000.00),
('Kas Dana Sosial', 'Kas untuk program dana sosial dan bantuan siswa kurang mampu', 20000000.00);

-- Insert kategori transaksi contoh
INSERT INTO kategori_transaksi (nama_kategori, deskripsi) VALUES
('Operasional', 'Transaksi operasional harian'),
('Proyek', 'Transaksi terkait proyek khusus'),
('Ekstrakurikuler', 'Transaksi kegiatan ekstrakurikuler'),
('Sosial', 'Transaksi bantuan sosial'),
('Pemeliharaan', 'Transaksi pemeliharaan fasilitas');

-- View untuk menampilkan ringkasan akun kas
CREATE VIEW v_ringkasan_kas AS
SELECT 
    ak.id,
    ak.nama_akun,
    ak.deskripsi,
    ak.saldo,
    ak.status,
    COUNT(tk.id) AS total_transaksi,
    COALESCE(SUM(CASE WHEN tk.jenis_transaksi = 'masuk' THEN tk.jumlah END), 0) AS total_masuk,
    COALESCE(SUM(CASE WHEN tk.jenis_transaksi = 'keluar' THEN tk.jumlah END), 0) AS total_keluar
FROM akun_kas ak
LEFT JOIN transaksi_kas tk ON ak.id = tk.akun_kas_id
GROUP BY ak.id, ak.nama_akun, ak.deskripsi, ak.saldo, ak.status;

-- Stored procedure untuk menambah transaksi dan update saldo
DELIMITER //
CREATE PROCEDURE tambah_transaksi(
    IN p_akun_kas_id INT,
    IN p_jenis_transaksi ENUM('masuk', 'keluar'),
    IN p_jumlah DECIMAL(15,2),
    IN p_keterangan TEXT,
    IN p_tanggal_transaksi DATE,
    IN p_kategori_id INT
)
BEGIN
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        RESIGNAL;
    END;
    
    START TRANSACTION;
    
    -- Insert transaksi
    INSERT INTO transaksi_kas (akun_kas_id, jenis_transaksi, jumlah, keterangan, tanggal_transaksi, kategori_id)
    VALUES (p_akun_kas_id, p_jenis_transaksi, p_jumlah, p_keterangan, p_tanggal_transaksi, p_kategori_id);
    
    -- Update saldo akun kas
    IF p_jenis_transaksi = 'masuk' THEN
        UPDATE akun_kas SET saldo = saldo + p_jumlah WHERE id = p_akun_kas_id;
    ELSE
        UPDATE akun_kas SET saldo = saldo - p_jumlah WHERE id = p_akun_kas_id;
    END IF;
    
    COMMIT;
END //
DELIMITER ;

-- Index untuk performa yang lebih baik
CREATE INDEX idx_transaksi_akun_kas ON transaksi_kas(akun_kas_id);
CREATE INDEX idx_transaksi_tanggal ON transaksi_kas(tanggal_transaksi);
CREATE INDEX idx_transaksi_jenis ON transaksi_kas(jenis_transaksi);

-- Contoh query untuk menampilkan data seperti di aplikasi
SELECT 
    nama_akun AS 'Nama Akun',
    deskripsi AS 'Deskripsi',
    CONCAT('Rp ', FORMAT(saldo, 0)) AS 'Saldo'
FROM akun_kas 
WHERE STATUS = 'aktif'
ORDER BY saldo DESC;

-- =====================================================
-- SISTEM STAFF DAN GURU
-- =====================================================

CREATE TABLE staff_guru (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(255) NOT NULL,
    jabatan VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    status_aktif ENUM('Aktif', 'Nonaktif') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE staff_guru (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    jabatan VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    status_aktif ENUM('Aktif', 'Nonaktif') DEFAULT 'Aktif',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO staff_guru (nama, jabatan, email, status_aktif) VALUES
('Rina Maharani', 'Guru Matematika', 'rina.maharani@email.com', 'Aktif'),
('Dedi Kurniawan', 'Staff Administrasi', 'dedi.kurniawan@email.com', 'Aktif'),
('Sari Permata', 'Guru Bahasa Inggris', 'sari.permata@email.com', 'Nonaktif'),
('Agus Santoso', 'Staff IT', 'agus.santoso@email.com', 'Aktif');

-- Query untuk mengambil data
SELECT * FROM staff_guru;

-- Query untuk Update dan Delete
-- Update
UPDATE staff_guru
SET status_aktif = 'Nonaktif'
WHERE id = 3; -- Ubah ID sesuai dengan data yang ingin diperbarui

-- Delete
DELETE FROM staff_guru
WHERE id = 4; -- Ubah ID sesuai dengan data yang ingin dihapus


