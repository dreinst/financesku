<?php
// Menghubungkan ke database
include '../php/koneksi.php';
// Mengambil data transaksi dari database
$query = "SELECT * FROM transaksi ORDER BY tanggal DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Transaksi - Sistem Keuangan Sekolah</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../css/styles.css" />
</head>
<body>
    <button class="sidebar-toggle" onclick="toggleSidebar()">
        <i class="fas fa-bars"></i>
    </button>

    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <div class="logo">FinanceSku</div>
                <div class="school-name">Sistem Keuangan Sekolah</div>
            </div>
            <nav class="nav-menu">
                <a href="../html/dashboard.html" class="nav-item">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
                <a href="../html/siswa.html" class="nav-item">
                    <i class="fas fa-user-graduate"></i>
                    <span>Data Siswa</span>
                </a>
                <a href="../html/pembayaran.html" class="nav-item">
                    <i class="fas fa-credit-card"></i>
                    <span>Pembayaran</span>
                </a>
                <a href="../html/transaksi.html" class="nav-item">
                    <i class="fas fa-exchange-alt"></i>
                    <span>Transaksi</span>
                </a>
                <a href="../html/laporan.html" class="nav-item">
                    <i class="fas fa-chart-bar"></i>
                    <span>Laporan</span>
                </a>
                <a href="../html/akun-kas.html" class="nav-item">
                    <i class="fas fa-wallet"></i>
                    <span>Akun Kas</span>
                </a>
                <a href="../html/staff.html" class="nav-item">
                    <i class="fas fa-users"></i>
                    <span>Staff/Guru</span>
                </a>
                <a href="../php/login.php" class="nav-item">
                    <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="header">
                <h1 class="header-title">Daftar Transaksi</h1>
                <div class="user-info">
                    <span>Admin</span>
                    <div class="avatar">A</div>
                </div>
            </div>

            <!-- Transaction Table -->
            <div class="card fade-in">
                <h3 style="margin-bottom: 1rem;">Transaksi Terbaru</h3>
                <div class="table-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID Transaksi</th>
                                <th>Tanggal</th>
                                <th>Siswa</th>
                                <th>Jenis Pembayaran</th>
                                <th>Jumlah</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>TX-240001</td>
                                <td>2024-04-10 10:30</td>
                                <td>Ahmad Rizki</td>
                                <td>SPP Bulan Maret</td>
                                <td>Rp 350,000</td>
                                <td><span class="status-badge status-success">✓ Berhasil</span></td>
                                <td>
                                    <button class="btn btn-secondary" style="padding: 0.3rem 0.8rem; font-size: 0.8rem;">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>TX-240002</td>
                                <td>2024-04-10 09:15</td>
                                <td>Siti Nurhaliza</td>
                                <td>Uang Gedung</td>
                                <td>Rp 2,500,000</td>
                                <td><span class="status-badge status-success">✓ Berhasil</span></td>
                                <td>
                                    <button class="btn btn-secondary" style="padding: 0.3rem 0.8rem; font-size: 0.8rem;">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>TX-240003</td>
                                <td>2024-04-10 08:45</td>
                                <td>Budi Santoso</td>
                                <td>Seragam</td>
                                <td>Rp 150,000</td>
                                <td><span class="status-badge status-warning">⏳ Pending</span></td>
                                <td>
                                    <button class="btn btn-warning" style="padding: 0.3rem 0.8rem; font-size: 0.8rem;">
                                        <i class="fas fa-clock"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>TX-240004</td>
                                <td>2024-04-10 08:30</td>
                                <td>Rina Maharani</td>
                                <td>SPP Bulan Februari</td>
                                <td>Rp 350,000</td>
                                <td><span class="status-badge status-success">✓ Berhasil</span></td>
                                <td>
                                    <button class="btn btn-secondary" style="padding: 0.3rem 0.8rem; font-size: 0.8rem;">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>TX-240005</td>
                                <td>2024-04-10 07:45</td>
                                <td>Dedi Kurniawan</td>
                                <td>Praktikum</td>
                                <td>Rp 100,000</td>
                                <td><span class="status-badge status-danger">✗ Gagal</span></td>
                                <td>
                                    <button class="btn btn-danger" style="padding: 0.3rem 0.8rem; font-size: 0.8rem;">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('active');
        }

        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.fade-in').forEach((element, index) => {
                element.style.animationDelay = `${index * 0.1}s`;
            });
        });
    </script>
</body>
</html>

