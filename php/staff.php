<?php
// Menghubungkan ke database
include '../php/koneksi.php';
// Mengambil data staff dan guru dari database
$query = "SELECT * FROM staff ORDER BY nama ASC";
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
                <h1 class="header-title">Data Staff & Guru</h1>
                <div class="user-info">
                    <span>Admin</span>
                    <div class="avatar">A</div>
                </div>
            </div>

            <!-- Search and Add Staff -->
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;" class="fade-in">
                <div class="search-container" style="flex-grow: 1; max-width: 400px;">
                    <input type="text" class="search-input" placeholder="Cari staff atau guru..." id="searchInput" />
                    <i class="fas fa-search search-icon"></i>
                </div>
                <a href="tambah-staff.html" class="btn btn-primary" style="padding: 0.75rem 1.5rem; margin-left: 1rem; white-space: nowrap;">
                    <i class="fas fa-user-plus"></i>
                    Tambah Staff
                </a>
            </div>

            <!-- Staff Table -->
            <div class="card fade-in">
                <div class="table-container">
                    <table class="table" id="staffTable" aria-label="Daftar staff dan guru">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Jabatan</th>
                                <th>Email</th>
                                <th>Status Aktif</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Rina Maharani</td>
                                <td>Guru Matematika</td>
                                <td>rina.maharani@email.com</td>
                                <td><span class="status-badge status-success">Aktif</span></td>
                                <td>
                                    <button class="btn btn-secondary" title="Lihat detail">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-primary" title="Edit data">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-danger" title="Hapus data">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>Dedi Kurniawan</td>
                                <td>Staff Administrasi</td>
                                <td>dedi.kurniawan@email.com</td>
                                <td><span class="status-badge status-success">Aktif</span></td>
                                <td>
                                    <button class="btn btn-secondary" title="Lihat detail">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-primary" title="Edit data">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-danger" title="Hapus data">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>Sari Permata</td>
                                <td>Guru Bahasa Inggris</td>
                                <td>sari.permata@email.com</td>
                                <td><span class="status-badge status-warning">Nonaktif</span></td>
                                <td>
                                    <button class="btn btn-secondary" title="Lihat detail">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-primary" title="Edit data">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-danger" title="Hapus data">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>Agus Santoso</td>
                                <td>Staff IT</td>
                                <td>agus.santoso@email.com</td>
                                <td><span class="status-badge status-success">Aktif</span></td>
                                <td>
                                    <button class="btn btn-secondary" title="Lihat detail">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-primary" title="Edit data">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-danger" title="Hapus data">
                                        <i class="fas fa-trash-alt"></i>
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

    // Search filter for staff table
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchInput');
        const staffTable = document.getElementById('staffTable').getElementsByTagName('tbody')[0];

        searchInput.addEventListener('input', function () {
            const filter = this.value.toLowerCase();
            const rows = staffTable.getElementsByTagName('tr');

            for (let i = 0; i < rows.length; i++) {
                const cells = rows[i].getElementsByTagName('td');
                let match = false;

                for (let j = 0; j < cells.length - 1; j++) { // Except last column (actions)
                    if (cells[j].textContent.toLowerCase().includes(filter)) {
                        match = true;
                        break;
                    }
                }

                rows[i].style.display = match ? '' : 'none';
            }
        });

        // Animation delay on fade-in elements
        document.querySelectorAll('.fade-in').forEach((element, index) => {
            element.style.animationDelay = `${index * 0.1}s`;
        });
    });
</script>
</body>
</html>

