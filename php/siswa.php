<?php
// Menghubungkan ke database
include '../php/koneksi.php';
// Mengambil data siswa dari database
$query = "SELECT * FROM siswa ORDER BY nisn ASC";
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
                <h1 class="header-title">Data Siswa</h1>
                <div class="user-info">
                    <span>Admin</span>
                    <div class="avatar">A</div>
                </div>
            </div>

            <!-- Kartu Statistik -->
            <div class="dashboard-grid">
                <div class="card stat-card fade-in">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <div class="stat-value">1,247</div>
                    <div class="stat-label">Total Siswa Aktif</div>
                </div>
                <div class="card stat-card fade-in">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #43e97b, #38f9d7);">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <div class="stat-value">25</div>
                    <div class="stat-label">Siswa Baru Bulan Ini</div>
                </div>
                <div class="card stat-card fade-in">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #f093fb, #f5576c);">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div class="stat-value">3</div>
                    <div class="stat-label">Siswa Menunggak</div>
                </div>
                <div class="card stat-card fade-in">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #4facfe, #00f2fe);">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div class="stat-value">150</div>
                    <div class="stat-label">Lulusan Tahun Ini</div>
                </div>
            </div>

            <!-- Penambahan Form Siswa -->
            <div class="form-container fade-in">
                <h3 style="margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
                    <i class="fas fa-user-plus"></i>
                    Tambah Siswa Baru
                </h3>
                <form id="studentForm">
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">NISN</label>
                            <input type="text" class="form-input" id="nisn" placeholder="Nomor Induk Siswa Nasional" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">NIS</label>
                            <input type="text" class="form-input" id="nis" placeholder="Nomor Induk Siswa" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-input" id="namaLengkap" placeholder="Nama lengkap siswa" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Kelas</label>
                            <select class="form-input" id="kelas" required>
                                <option value="">Pilih Kelas</option>
                                <option value="X IPA 1">X IPA 1</option>
                                <option value="X IPA 2">X IPA 2</option>
                                <option value="X IPS 1">X IPS 1</option>
                                <option value="X IPS 2">X IPS 2</option>
                                <option value="XI IPA 1">XI IPA 1</option>
                                <option value="XI IPA 2">XI IPA 2</option>
                                <option value="XI IPS 1">XI IPS 1</option>
                                <option value="XI IPS 2">XI IPS 2</option>
                                <option value="XII IPA 1">XII IPA 1</option>
                                <option value="XII IPA 2">XII IPA 2</option>
                                <option value="XII IPS 1">XII IPS 1</option>
                                <option value="XII IPS 2">XII IPS 2</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Jenis Kelamin</label>
                            <select class="form-input" id="jenisKelamin" required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="date" class="form-input" id="tanggalLahir" required>
                        </div>
                    </div>
                    
                    <div class="form-grid" style="margin-top: 1rem;">
                        <div class="form-group">
                            <label class="form-label">Alamat</label>
                            <textarea class="form-input" id="alamat" rows="3" placeholder="Alamat lengkap siswa"></textarea>
                        </div>
                        <div class="form-group">
                            <label class="form-label">No. Telepon</label>
                            <input type="tel" class="form-input" id="noTelepon" placeholder="Nomor telepon siswa/orang tua">
                        </div>
                    </div>
                    
                    <div class="form-grid" style="margin-top: 1rem;">
                        <div class="form-group">
                            <label class="form-label">Nama Ayah</label>
                            <input type="text" class="form-input" id="namaAyah" placeholder="Nama ayah kandung">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Nama Ibu</label>
                            <input type="text" class="form-input" id="namaIbu" placeholder="Nama ibu kandung">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Pekerjaan Orang Tua</label>
                            <input type="text" class="form-input" id="pekerjaanOrtu" placeholder="Pekerjaan orang tua">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Status Siswa</label>
                            <select class="form-input" id="statusSiswa" required>
                                <option value="Aktif">Aktif</option>
                                <option value="Tidak Aktif">Tidak Aktif</option>
                                <option value="Lulus">Lulus</option>
                                <option value="Pindah">Pindah</option>
                            </select>
                        </div>
                    </div>
                    
                    <div style="margin-top: 2rem; text-align: right;">
                        <button type="button" class="btn btn-secondary" onclick="resetForm()">
                            <i class="fas fa-undo"></i>
                            Reset
                        </button>
                        <button type="submit" class="btn btn-primary" style="margin-left: 1rem;">
                            <i class="fas fa-save"></i>
                            Simpan Data
                        </button>
                    </div>
                </form>
            </div>

            <!-- List Siswa -->
            <div class="card fade-in">
                <div class="table-header">
                    <h3 style="margin: 0;">Daftar Siswa</h3>
                    <div style="display: flex; gap: 1rem; align-items: center;">
                        <div class="search-container" style="margin: 0; width: 300px;">
                            <input type="text" class="search-input" id="searchStudent" placeholder="Cari siswa...">
                            <i class="fas fa-search search-icon"></i>
                        </div>
                        <button class="btn btn-success" onclick="exportData()">
                            <i class="fas fa-download"></i>
                            Export
                        </button>
                    </div>
                </div>
                <div class="table-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>NISN</th>
                                <th>NIS</th>
                                <th>Nama</th>
                                <th>Kelas</th>
                                <th>L/P</th>
                                <th>Status</th>
                                <th>Tunggakan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="studentTableBody">
                            <tr>
                                <td>0012345678</td>
                                <td>2024001</td>
                                <td>Ahmad Rizki Pratama</td>
                                <td>XII IPA 1</td>
                                <td>L</td>
                                <td><span class="status-badge status-success">Aktif</span></td>
                                <td>Rp 0</td>
                                <td>
                                    <button class="btn btn-secondary" style="padding: 0.3rem 0.8rem; font-size: 0.8rem;" onclick="viewStudent('2024001')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-primary" style="padding: 0.3rem 0.8rem; font-size: 0.8rem; margin-left: 0.5rem;" onclick="editStudent('2024001')">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-danger" style="padding: 0.3rem 0.8rem; font-size: 0.8rem; margin-left: 0.5rem;" onclick="deleteStudent('2024001')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>0012345679</td>
                                <td>2024002</td>
                                <td>Siti Nurhaliza</td>
                                <td>XI IPS 1</td>
                                <td>P</td>
                                <td><span class="status-badge status-success">Aktif</span></td>
                                <td>Rp 350,000</td>
                                <td>
                                    <button class="btn btn-secondary" style="padding: 0.3rem 0.8rem; font-size: 0.8rem;" onclick="viewStudent('2024002')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-primary" style="padding: 0.3rem 0.8rem; font-size: 0.8rem; margin-left: 0.5rem;" onclick="editStudent('2024002')">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-danger" style="padding: 0.3rem 0.8rem; font-size: 0.8rem; margin-left: 0.5rem;" onclick="deleteStudent('2024002')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>0012345680</td>
                                <td>2024003</td>
                                <td>Budi Santoso</td>
                                <td>X IPA 2</td>
                                <td>L</td>
                                <td><span class="status-badge status-success">Aktif</span></td>
                                <td>Rp 150,000</td>
                                <td>
                                    <button class="btn btn-secondary" style="padding: 0.3rem 0.8rem; font-size: 0.8rem;" onclick="viewStudent('2024003')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-primary" style="padding: 0.3rem 0.8rem; font-size: 0.8rem; margin-left: 0.5rem;" onclick="editStudent('2024003')">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-danger" style="padding: 0.3rem 0.8rem; font-size: 0.8rem; margin-left: 0.5rem;" onclick="deleteStudent('2024003')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>0012345681</td>
                                <td>2024004</td>
                                <td>Rina Maharani</td>
                                <td>XII IPS 2</td>
                                <td>P</td>
                                <td><span class="status-badge status-warning">Tidak Aktif</span></td>
                                <td>Rp 700,000</td>
                                <td>
                                    <button class="btn btn-secondary" style="padding: 0.3rem 0.8rem; font-size: 0.8rem;" onclick="viewStudent('2024004')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-primary" style="padding: 0.3rem 0.8rem; font-size: 0.8rem; margin-left: 0.5rem;" onclick="editStudent('2024004')">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-danger" style="padding: 0.3rem 0.8rem; font-size: 0.8rem; margin-left: 0.5rem;" onclick="deleteStudent('2024004')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>0012345682</td>
                                <td>2024005</td>
                                <td>Dedi Kurniawan</td>
                                <td>XI IPA 1</td>
                                <td>L</td>
                                <td><span class="status-badge status-success">Aktif</span></td>
                                <td>Rp 0</td>
                                <td>
                                    <button class="btn btn-secondary" style="padding: 0.3rem 0.8rem; font-size: 0.8rem;" onclick="viewStudent('2024005')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-primary" style="padding: 0.3rem 0.8rem; font-size: 0.8rem; margin-left: 0.5rem;" onclick="editStudent('2024005')">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-danger" style="padding: 0.3rem 0.8rem; font-size: 0.8rem; margin-left: 0.5rem;" onclick="deleteStudent('2024005')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Siswa -->
    <div id="studentDetailModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2 style="margin-bottom: 1.5rem;">Detail Siswa</h2>
            <div id="studentDetailContent">
                <!-- Pemunculan Content -->
            </div>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('active');
        }

        function resetForm() {
            document.getElementById('studentForm').reset();
            showNotification('Form telah direset', 'warning');
        }

        function viewStudent(nis) {
            // Mock data siswa - bisa connect server
            const mockData = {
                '2024001': {
                    nisn: '0012345678',
                    nis: '2024001',
                    nama: 'Ahmad Rizki Pratama',
                    kelas: 'XII IPA 1',
                    jenisKelamin: 'Laki-laki',
                    tanggalLahir: '2006-03-15',
                    alamat: 'Jl. Merdeka No. 123, Malang',
                    noTelepon: '08123456789',
                    namaAyah: 'Ahmad Surya',
                    namaIbu: 'Siti Aminah',
                    pekerjaanOrtu: 'Wiraswasta',
                    status: 'Aktif',
                    tunggakan: 'Rp 0'
                }
            };

            const student = mockData[nis] || mockData['2024001'];
            
            const content = `
                <div class="form-grid">
                    <div><strong>NISN:</strong> ${student.nisn}</div>
                    <div><strong>NIS:</strong> ${student.nis}</div>
                    <div><strong>Nama:</strong> ${student.nama}</div>
                    <div><strong>Kelas:</strong> ${student.kelas}</div>
                    <div><strong>Jenis Kelamin:</strong> ${student.jenisKelamin}</div>
                    <div><strong>Tanggal Lahir:</strong> ${student.tanggalLahir}</div>
                    <div><strong>Alamat:</strong> ${student.alamat}</div>
                    <div><strong>No. Telepon:</strong> ${student.noTelepon}</div>
                    <div><strong>Nama Ayah:</strong> ${student.namaAyah}</div>
                    <div><strong>Nama Ibu:</strong> ${student.namaIbu}</div>
                    <div><strong>Pekerjaan Orang Tua:</strong> ${student.pekerjaanOrtu}</div>
                    <div><strong>Status:</strong> <span class="status-badge status-success">${student.status}</span></div>
                </div>
                <div style="margin-top: 1.5rem;">
                    <strong>Tunggakan:</strong> ${student.tunggakan}
                </div>
            `;
            
            document.getElementById('studentDetailContent').innerHTML = content;
            document.getElementById('studentDetailModal').style.display = 'block';
        }

        function editStudent(nis) {
            showNotification('Fitur edit akan segera tersedia', 'warning');
        }

        function deleteStudent(nis) {
            if (confirm('Apakah Anda yakin ingin menghapus data siswa ini?')) {
                showNotification('Data siswa berhasil dihapus', 'success');
                // In real app, you would make an API call here
            }
        }

        function closeModal() {
            document.getElementById('studentDetailModal').style.display = 'none';
        }

        function exportData() {
            showNotification('Data sedang diekspor...', 'success');
            // In real app, this would trigger file 
        }

        function showNotification(message, type) {
            const notification = document.createElement('div');
            notification.className = `notification ${type} show`;
            notification.textContent = message;
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.remove();
            }, 3000);
        }

        // Penyerahan Form
        document.getElementById('studentForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Perolehan form data
            const formData = new FormData(this);
            const data = Object.fromEntries(formData);
            
            // Pengiriman ke server
            console.log('Student data:', data);
            
            showNotification('Data siswa berhasil disimpan!', 'success');
            this.reset();
        });

        // Mencari Fungsi
        document.getElementById('searchStudent').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const tableRows = document.querySelectorAll('#studentTableBody tr');
            
            tableRows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('studentDetailModal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }

        // Inisiasi Animasi
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.fade-in').forEach((element, index) => {
                element.style.animationDelay = `${index * 0.1}s`;
            });
        });
    </script>
</body>
</html>