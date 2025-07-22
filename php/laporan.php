<?php
// Menghubungkan ke database
include '../php/koneksi.php';
// Mengambil data laporan dari database
$query = "SELECT * FROM laporan ORDER BY tanggal DESC";
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
                <a href="../php/siswa.php"nav-item">
                    <i class="fas fa-user-graduate"></i>
                    <span>Data Siswa</span>
                </a>
                <a href="../php/pembayaran.php"nav-item">
                    <i class="fas fa-credit-card"></i>
                    <span>Pembayaran</span>
                </a>
                <a href="../php/laporan.php"nav-item">
                    <i class="fas fa-exchange-alt"></i>
                    <span>Transaksi</span>
                </a>
                <a href="../php/laporan.php"nav-item">
                    <i class="fas fa-chart-bar"></i>
                    <span>Laporan</span>
                </a>
                <a href="../php/akun-kas.php" class="nav-item">
                    <i class="fas fa-wallet"></i>
                    <span>Akun Kas</span>
                </a>
                <a href="../php/staff.php class="nav-item">
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
                <h1 class="header-title">Laporan Keuangan</h1>
                <div class="user-info">
                    <span>Admin</span>
                    <div class="avatar">A</div>
                </div>
            </div>

            <!-- Search Bar -->
            <div class="search-container fade-in">
                <input type="text" placeholder="Cari laporan..." class="search-input" id="searchInput" />
                <i class="fas fa-search search-icon" aria-hidden="true"></i>
            </div>

            <!-- Report Table -->
            <div class="card fade-in" style="margin-top: 1rem;">
                <div class="table-container">
                    <table class="table" id="reportTable">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Jenis Laporan</th>
                                <th>Deskripsi</th>
                                <th>Jumlah</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>2024-06-25</td>
                                <td>SPP Bulanan</td>
                                <td>Pembayaran SPP bulan Juni 2024</td>
                                <td>Rp 45,000,000</td>
                                <td><span class="status-badge status-success">✓ Selesai</span></td>
                                <td>
                                    <button class="btn btn-primary" title="Unduh PDF">
                                        <i class="fas fa-file-pdf"></i>
                                    </button>
                                    <button class="btn btn-secondary" title="Lihat Detail" style="margin-left:0.3rem;">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>2024-06-15</td>
                                <td>Uang Gedung</td>
                                <td>Penerimaan uang gedung periode Juni 2024</td>
                                <td>Rp 120,000,000</td>
                                <td><span class="status-badge status-success">✓ Selesai</span></td>
                                <td>
                                    <button class="btn btn-primary" title="Unduh PDF">
                                        <i class="fas fa-file-pdf"></i>
                                    </button>
                                    <button class="btn btn-secondary" title="Lihat Detail" style="margin-left:0.3rem;">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>2024-05-30</td>
                                <td>Praktikum</td>
                                <td>Laporan pembayaran praktikum bulan Mei 2024</td>
                                <td>Rp 15,000,000</td>
                                <td><span class="status-badge status-warning">⏳ Pending</span></td>
                                <td>
                                    <button class="btn btn-primary" title="Unduh PDF" disabled style="opacity:0.6; cursor:not-allowed;">
                                        <i class="fas fa-file-pdf"></i>
                                    </button>
                                    <button class="btn btn-secondary" title="Lihat Detail" style="margin-left:0.3rem;">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>2024-05-20</td>
                                <td>Seragam</td>
                                <td>Laporan pembayaran seragam periode Mei 2024</td>
                                <td>Rp 8,500,000</td>
                                <td><span class="status-badge status-success">✓ Selesai</span></td>
                                <td>
                                    <button class="btn btn-primary" title="Unduh PDF">
                                        <i class="fas fa-file-pdf"></i>
                                    </button>
                                    <button class="btn btn-secondary" title="Lihat Detail" style="margin-left:0.3rem;">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>2024-04-10</td>
                                <td>Uang Lab</td>
                                <td>Penerimaan uang laboratorium periode April 2024</td>
                                <td>Rp 7,000,000</td>
                                <td><span class="status-badge status-danger">✗ Gagal</span></td>
                                <td>
                                    <button class="btn btn-primary" title="Unduh PDF" disabled style="opacity:0.6; cursor:not-allowed;">
                                        <i class="fas fa-file-pdf"></i>
                                    </button>
                                    <button class="btn btn-secondary" title="Lihat Detail" style="margin-left:0.3rem;">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Buttons Card -->
            <div class="card fade-in" style="margin-top: 2rem; padding: 1.5rem;">
                <div class="dashboard-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); gap: 1.5rem; justify-content: center;">
                    <button class="btn btn-primary" style="padding: 1.5rem; display: flex; align-items: center; justify-content: center; gap: 0.5rem;">
                        <i class="fas fa-print"></i>
                        Cetak Laporan
                    </button>
                    <button class="btn btn-success" style="padding: 1.5rem; display: flex; align-items: center; justify-content: center; gap: 0.5rem;">
                        <i class="fas fa-file-csv"></i>
                        Export CSV
                    </button>
                </div>
            </div>

        </div>
    </div>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        sidebar.classList.toggle('active');
    }

    // Search filter fungsi
    document.addEventListener('DOMContentLoaded', () => {
        const searchInput = document.getElementById('searchInput');
        const tableRows = document.querySelectorAll('#reportTable tbody tr');

        searchInput.addEventListener('input', () => {
            const query = searchInput.value.toLowerCase();

            tableRows.forEach(row => {
                const rowText = row.textContent.toLowerCase();
                if (rowText.includes(query)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        // Animasi delay fade-in
        document.querySelectorAll('.fade-in').forEach((element, index) => {
            element.style.animationDelay = `${index * 0.1}s`;
        });
    });
</script>
</body>
</html>
