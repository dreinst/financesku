<?php
// Menghubungkan ke database
include '../php/koneksi.php';
// Mengambil data akun kas dari database
$query = "SELECT * FROM akun_kas ORDER BY nama_akun ASC";
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
                <h1 class="header-title">Akun Kas</h1>
                <div class="user-info">
                    <span>Admin</span>
                    <div class="avatar">A</div>
                </div>
            </div>

            <!-- Search Bar -->
            <div class="search-container fade-in">
                <input type="text" placeholder="Cari akun kas..." class="search-input" id="searchInput" />
                <i class="fas fa-search search-icon" aria-hidden="true"></i>
            </div>

            <!-- Account Table -->
            <div class="card fade-in" style="margin-top: 1rem;">
                <div class="table-container">
                    <table class="table" id="accountTable">
                        <thead>
                            <tr>
                                <th>Nama Akun</th>
                                <th>Deskripsi</th>
                                <th>Saldo</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Kas Utama</td>
                                <td>Kas utama untuk semua penerimaan dan pengeluaran</td>
                                <td>Rp 120,000,000</td>
                                <td>
                                    <button class="btn btn-success" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-danger" title="Hapus" style="margin-left:0.3rem;">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>Kas Proyek Renovasi</td>
                                <td>Dana khusus untuk proyek renovasi gedung sekolah</td>
                                <td>Rp 75,000,000</td>
                                <td>
                                    <button class="btn btn-success" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-danger" title="Hapus" style="margin-left:0.3rem;">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>Kas Ekstrakurikuler</td>
                                <td>Kas untuk kegiatan ekstrakurikuler dan acara siswa</td>
                                <td>Rp 18,500,000</td>
                                <td>
                                    <button class="btn btn-success" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-danger" title="Hapus" style="margin-left:0.3rem;">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>Kas Dana Sosial</td>
                                <td>Kas untuk program dana sosial dan bantuan siswa kurang mampu</td>
                                <td>Rp 20,000,000</td>
                                <td>
                                    <button class="btn btn-success" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-danger" title="Hapus" style="margin-left:0.3rem;">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="dashboard-grid" style="margin-top: 2rem; justify-content: start;">
                <button class="btn btn-primary" style="padding: 1rem 2rem;">
                    <i class="fas fa-plus"></i>
                    Tambah Akun Baru
                </button>
                <button class="btn btn-secondary" style="padding: 1rem 2rem;">
                    <i class="fas fa-file-export"></i>
                    Export Data
                </button>
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
        const tableRows = document.querySelectorAll('#accountTable tbody tr');

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
