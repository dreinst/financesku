<?php
// Menghubungkan ke database
include '../php/koneksi.php';
// Mengambil data pembayaran dari database
$query = "SELECT * FROM pembayaran ORDER BY tanggal DESC";
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
                <h1 class="header-title">Pembayaran</h1>
                <div class="user-info">
                    <span>Admin</span>
                    <div class="avatar">A</div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="dashboard-grid">
                <div class="card stat-card fade-in">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #43e97b, #38f9d7);">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <div class="stat-value">Rp 45.7M</div>
                    <div class="stat-label">Pembayaran Bulan Ini</div>
                </div>
                <div class="card stat-card fade-in">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #4facfe, #00f2fe);">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-value">1,124</div>
                    <div class="stat-label">Pembayaran Berhasil</div>
                </div>
                <div class="card stat-card fade-in">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #ffecd2, #fcb69f);">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-value">23</div>
                    <div class="stat-label">Pembayaran Pending</div>
                </div>
                <div class="card stat-card fade-in">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #f093fb, #f5576c);">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div class="stat-value">Rp 8.2M</div>
                    <div class="stat-label">Total Tunggakan</div>
                </div>
            </div>

            <!-- Quick Payment Form -->
            <div class="form-container fade-in">
                <h3 style="margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
                    <i class="fas fa-credit-card"></i>
                    Proses Pembayaran Baru
                </h3>
                <form id="paymentForm">
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Cari Siswa</label>
                            <div style="position: relative;">
                                <input type="text" class="form-input" id="studentSearch" placeholder="Ketik NIS atau nama siswa..." autocomplete="off">
                                <div id="studentSuggestions" class="suggestions-dropdown" style="display: none;"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Jenis Pembayaran</label>
                            <select class="form-input" id="paymentType" required onchange="updatePaymentAmount()">
                                <option value="">Pilih Jenis Pembayaran</option>
                                <option value="spp" data-amount="350000">SPP Bulanan - Rp 350,000</option>
                                <option value="uang_gedung" data-amount="2500000">Uang Gedung - Rp 2,500,000</option>
                                <option value="seragam" data-amount="150000">Seragam - Rp 150,000</option>
                                <option value="praktikum" data-amount="100000">Praktikum - Rp 100,000</option>
                                <option value="ujian" data-amount="200000">Ujian - Rp 200,000</option>
                                <option value="ekstrakurikuler" data-amount="75000">Ekstrakurikuler - Rp 75,000</option>
                                <option value="buku" data-amount="300000">Buku - Rp 300,000</option>
                                <option value="lainnya" data-amount="0">Lainnya</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Periode/Bulan (untuk SPP)</label>
                            <select class="form-input" id="paymentPeriod">
                                <option value="">Pilih Periode</option>
                                <option value="2024-01">Januari 2024</option>
                                <option value="2024-02">Februari 2024</option>
                                <option value="2024-03">Maret 2024</option>
                                <option value="2024-04">April 2024</option>
                                <option value="2024-05">Mei 2024</option>
                                <option value="2024-06">Juni 2024</option>
                                <option value="2024-07">Juli 2024</option>
                                <option value="2024-08">Agustus 2024</option>
                                <option value="2024-09">September 2024</option>
                                <option value="2024-10">Oktober 2024</option>
                                <option value="2024-11">November 2024</option>
                                <option value="2024-12">Desember 2024</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Jumlah Pembayaran</label>
                            <input type="text" class="form-input" id="paymentAmount" placeholder="Rp 0" readonly>
                        </div>
                    </div>
                    
                    <div class="form-grid" style="margin-top: 1rem;">
                        <div class="form-group">
                            <label class="form-label">Metode Pembayaran</label>
                            <select class="form-input" id="paymentMethod" required>
                                <option value="">Pilih Metode</option>
                                <option value="tunai">Tunai</option>
                                <option value="transfer">Transfer Bank</option>
                                <option value="kartu_debit">Kartu Debit</option>
                                <option value="qris">QRIS</option>
                                <option value="e_wallet">E-Wallet</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Nomor Referensi/Bukti</label>
                            <input type="text" class="form-input" id="referenceNumber" placeholder="Nomor struk/referensi (opsional)">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Keterangan</label>
                            <textarea class="form-input" id="paymentNotes" rows="3" placeholder="Keterangan tambahan (opsional)"></textarea>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Tanggal Pembayaran</label>
                            <input type="date" class="form-input" id="paymentDate" required>
                        </div>
                    </div>
                    
                    <div id="selectedStudentInfo" class="card" style="margin-top: 1rem; display: none; background: rgba(67, 233, 123, 0.1); border-left: 4px solid #43e97b;">
                        <h4 style="margin-bottom: 0.5rem; color: #43e97b;">Informasi Siswa</h4>
                        <div id="studentInfoContent"></div>
                    </div>
                    
                    <div style="margin-top: 2rem; text-align: right;">
                        <button type="button" class="btn btn-secondary" onclick="resetPaymentForm()">
                            <i class="fas fa-undo"></i>
                            Reset
                        </button>
                        <button type="submit" class="btn btn-primary" style="margin-left: 1rem;">
                            <i class="fas fa-credit-card"></i>
                            Proses Pembayaran
                        </button>
                    </div>
                </form>
            </div>

            <!-- Riwayat  -->
            <div class="card fade-in">
                <div class="table-header">
                    <h3 style="margin: 0;">Riwayat Pembayaran</h3>
                    <div style="display: flex; gap: 1rem; align-items: center;">
                        <div class="search-container" style="margin: 0; width: 300px;">
                            <input type="text" class="search-input" id="searchPayment" placeholder="Cari pembayaran...">
                            <i class="fas fa-search search-icon"></i>
                        </div>
                        <select class="form-input" id="filterStatus" style="width: 150px;" onchange="filterPayments()">
                            <option value="">Semua Status</option>
                            <option value="berhasil">Berhasil</option>
                            <option value="pending">Pending</option>
                            <option value="gagal">Gagal</option>
                        </select>
                        <button class="btn btn-success" onclick="exportPayments()">
                            <i class="fas fa-download"></i>
                            Export
                        </button>
                    </div>
                </div>
                <div class="table-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID Transaksi</th>
                                <th>Tanggal</th>
                                <th>Siswa</th>
                                <th>Jenis Pembayaran</th>
                                <th>Jumlah</th>
                                <th>Metode</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="paymentTableBody">
                            <tr>
                                <td>TRX-240001</td>
                                <td>17/06/2025 10:30</td>
                                <td>Ahmad Rizki</td>
                                <td>SPP Maret 2024</td>
                                <td>Rp 350,000</td>
                                <td>Tunai</td>
                                <td><span class="status-badge status-success">✓ Berhasil</span></td>
                                <td>
                                    <button class="btn btn-secondary" style="padding: 0.3rem 0.8rem; font-size: 0.8rem;" onclick="printReceipt('TRX-240001')">
                                        <i class="fas fa-print"></i>
                                    </button>
                                    <button class="btn btn-primary" style="padding: 0.3rem 0.8rem; font-size: 0.8rem; margin-left: 0.5rem;" onclick="viewPaymentDetail('TRX-240001')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>TRX-240002</td>
                                <td>17/06/2025 09:15</td>
                                <td>Siti Nurhaliza</td>
                                <td>Uang Gedung</td>
                                <td>Rp 2,500,000</td>
                                <td>Transfer</td>
                                <td><span class="status-badge status-success">✓ Berhasil</span></td>
                                <td>
                                    <button class="btn btn-secondary" style="padding: 0.3rem 0.8rem; font-size: 0.8rem;" onclick="printReceipt('TRX-240002')">
                                        <i class="fas fa-print"></i>
                                    </button>
                                    <button class="btn btn-primary" style="padding: 0.3rem 0.8rem; font-size: 0.8rem; margin-left: 0.5rem;" onclick="viewPaymentDetail('TRX-240002')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>TRX-240003</td>
                                <td>17/06/2025 08:45</td>
                                <td>Budi Santoso</td>
                                <td>Seragam</td>
                                <td>Rp 150,000</td>
                                <td>QRIS</td>
                                <td><span class="status-badge status-warning">⏳ Pending</span></td>
                                <td>
                                    <button class="btn btn-warning" style="padding: 0.3rem 0.8rem; font-size: 0.8rem;" onclick="confirmPayment('TRX-240003')">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button class="btn btn-primary" style="padding: 0.3rem 0.8rem; font-size: 0.8rem; margin-left: 0.5rem;" onclick="viewPaymentDetail('TRX-240003')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>TRX-240004</td>
                                <td>17/06/2025 08:30</td>
                                <td>Rina Maharani</td>
                                <td>SPP Februari 2024</td>
                                <td>Rp 350,000</td>
                                <td>Tunai</td>
                                <td><span class="status-badge status-success">✓ Berhasil</span></td>
                                <td>
                                    <button class="btn btn-secondary" style="padding: 0.3rem 0.8rem; font-size: 0.8rem;" onclick="printReceipt('TRX-240004')">
                                        <i class="fas fa-print"></i>
                                    </button>
                                    <button class="btn btn-primary" style="padding: 0.3rem 0.8rem; font-size: 0.8rem; margin-left: 0.5rem;" onclick="viewPaymentDetail('TRX-240004')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>TRX-240005</td>
                                <td>17/06/2025 07:45</td>
                                <td>Dedi Kurniawan</td>
                                <td>Praktikum</td>
                                <td>Rp 100,000</td>
                                <td>E-Wallet</td>
                                <td><span class="status-badge status-danger">✗ Gagal</span></td>
                                <td>
                                    <button class="btn btn-danger" style="padding: 0.3rem 0.8rem; font-size: 0.8rem;" onclick="retryPayment('TRX-240005')">
                                        <i class="fas fa-redo"></i>
                                    </button>
                                    <button class="btn btn-primary" style="padding: 0.3rem 0.8rem; font-size: 0.8rem; margin-left: 0.5rem;" onclick="viewPaymentDetail('TRX-240005')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Outstanding Payments -->
            <div class="card fade-in" style="margin-top: 2rem;">
                <h3 style="margin-bottom: 1.5rem; color: #f5576c;">
                    <i class="fas fa-exclamation-triangle"></i>
                    Tunggakan Pembayaran
                </h3>
                <div class="table-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Siswa</th>
                                <th>Kelas</th>
                                <th>Jenis Pembayaran</th>
                                <th>Periode</th>
                                <th>Jumlah</th>
                                <th>Terlambat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Siti Nurhaliza</td>
                                <td>XI IPS 1</td>
                                <td>SPP</td>
                                <td>Februari 2024</td>
                                <td>Rp 350,000</td>
                                <td>15 hari</td>
                                <td>
                                    <button class="btn btn-primary" style="padding: 0.3rem 0.8rem; font-size: 0.8rem;" onclick="processOutstandingPayment('2024002', 'spp', '2024-02')">
                                        <i class="fas fa-credit-card"></i>
                                        Bayar
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>Budi Santoso</td>
                                <td>X IPA 2</td>
                                <td>Praktikum</td>
                                <td>-</td>
                                <td>Rp 100,000</td>
                                <td>8 hari</td>
                                <td>
                                    <button class="btn btn-primary" style="padding: 0.3rem 0.8rem; font-size: 0.8rem;" onclick="processOutstandingPayment('2024003', 'praktikum', '')">
                                        <i class="fas fa-credit-card"></i>
                                        Bayar
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>Rina Maharani</td>
                                <td>XII IPS 2</td>
                                <td>SPP</td>
                                <td>Januari 2024</td>
                                <td>Rp 350,000</td>
                                <td>45 hari</td>
                                <td>
                                    <button class="btn btn-primary" style="padding: 0.3rem 0.8rem; font-size: 0.8rem;" onclick="processOutstandingPayment('2024004', 'spp', '2024-01')">
                                        <i class="fas fa-credit-card"></i>
                                        Bayar
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Detail Modal -->
    <div id="paymentDetailModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2 style="margin-bottom: 1.5rem;">Detail Pembayaran</h2>
            <div id="paymentDetailContent">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>

    <script>
        // Mock student data for search suggestions
        const students = [
            { nis: '2024001', name: 'Ahmad Rizki Pratama', class: 'XII IPA 1' },
            { nis: '2024002', name: 'Siti Nurhaliza', class: 'XI IPS 1' },
            { nis: '2024003', name: 'Budi Santoso', class: 'X IPA 2' },
            { nis: '2024004', name: 'Rina Maharani', class: 'XII IPS 2' },
            { nis: '2024005', name: 'Dedi Kurniawan', class: 'XI IPA 1' }
        ];

        let selectedStudent = null;

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('active');
        }

        function updatePaymentAmount() {
            const paymentType = document.getElementById('paymentType');
            const paymentAmount = document.getElementById('paymentAmount');
            const selectedOption = paymentType.options[paymentType.selectedIndex];
            
            if (selectedOption && selectedOption.dataset.amount) {
                const amount = parseInt(selectedOption.dataset.amount);
                paymentAmount.value = formatCurrency(amount);
            } else {
                paymentAmount.value = '';
            }
        }

        function formatCurrency(amount) {
            return 'Rp ' + amount.toLocaleString('id-ID');
        }

        function resetPaymentForm() {
            document.getElementById('paymentForm').reset();
            selectedStudent = null;
            document.getElementById('selectedStudentInfo').style.display = 'none';
            document.getElementById('studentSuggestions').style.display = 'none';
            showNotification('Form pembayaran telah direset', 'warning');
        }

        function searchStudents(query) {
            return students.filter(student => 
                student.nis.toLowerCase().includes(query.toLowerCase()) ||
                student.name.toLowerCase().includes(query.toLowerCase())
            );
        }

        function selectStudent(student) {
            selectedStudent = student;
            document.getElementById('studentSearch').value = `${student.nis} - ${student.name}`;
            document.getElementById('studentSuggestions').style.display = 'none';
            
            // Show student info
            const studentInfo = document.getElementById('selectedStudentInfo');
            const studentInfoContent = document.getElementById('studentInfoContent');
            
            studentInfoContent.innerHTML = `
                <p><strong>NIS:</strong> ${student.nis}</p>
                <p><strong>Nama:</strong> ${student.name}</p>
                <p><strong>Kelas:</strong> ${student.class}</p>
            `;
            
            studentInfo.style.display = 'block';
        }

        function processOutstandingPayment(nis, type, period) {
            const student = students.find(s => s.nis === nis);
            if (student) {
                selectStudent(student);
                document.getElementById('paymentType').value = type;
                if (period) {
                    document.getElementById('paymentPeriod').value = period;
                }
                updatePaymentAmount();
                
                // Scroll to form
                document.querySelector('.form-container').scrollIntoView({ behavior: 'smooth' });
                showNotification('Data tunggakan telah dimuat ke form pembayaran', 'success');
            }
        }

        function printReceipt(transactionId) {
            showNotification('Mencetak kwitansi pembayaran...', 'success');
            // In real app, this would generate and print receipt
        }

        function viewPaymentDetail(transactionId) {
            // Mock payment detail
            const mockDetail = {
                id: transactionId,
                date: '17/06/2025 10:30',
                student: 'Ahmad Rizki Pratama',
                type: 'SPP Maret 2024',
                amount: 'Rp 350,000',
                method: 'Tunai',
                status: 'Berhasil',
                reference: 'REF-001',
                notes: 'Pembayaran langsung di kantor'
            };

            const content = `
                <div class="form-grid">
                    <div><strong>ID Transaksi:</strong> ${mockDetail.id}</div>
                    <div><strong>Tanggal:</strong> ${mockDetail.date}</div>
                    <div><strong>Siswa:</strong> ${mockDetail.student}</div>
                    <div><strong>Jenis Pembayaran:</strong> ${mockDetail.type}</div>
                    <div><strong>Jumlah:</strong> ${mockDetail.amount}</div>
                    <div><strong>Metode:</strong> ${mockDetail.method}</div>
                    <div><strong>Status:</strong> <span class="status-badge status-success">${mockDetail.status}</span></div>
                    <div><strong>Referensi:</strong> ${mockDetail.reference}</div>
                </div>
                <div style="margin-top: 1rem;">
                    <strong>Keterangan:</strong> ${mockDetail.notes}
                </div>
                <div style="margin-top: 1.5rem; text-align: right;">
                    <button class="btn btn-secondary" onclick="printReceipt('${mockDetail.id}')">
                        <i class="fas fa-print"></i>
                        Cetak Kwitansi
                    </button>
                </div>
            `;

            document.getElementById('paymentDetailContent').innerHTML = content;
            document.getElementById('paymentDetailModal').style.display = 'block';
        }

        function confirmPayment(transactionId) {
            if (confirm('Konfirmasi pembayaran ini sebagai berhasil?')) {
                showNotification('Pembayaran berhasil dikonfirmasi', 'success');
                // Update table row status
                const rows = document.querySelectorAll('#paymentTableBody tr');
                rows.forEach(row => {
                    if (row.cells[0].textContent === transactionId) {
                        row.cells[6].innerHTML = '<span class="status-badge status-success">✓ Berhasil</span>';
                    }
                });
            }
        }

        function retryPayment(transactionId) {
            showNotification('Mencoba ulang pembayaran...', 'warning');
            // In real app, this would retry the payment process
        }

        function filterPayments() {
            const filterStatus = document.getElementById('filterStatus').value;
            const tableRows = document.querySelectorAll('#paymentTableBody tr');
            
            tableRows.forEach(row => {
                const statusCell = row.cells[6].textContent.toLowerCase();
                if (!filterStatus || statusCell.includes(filterStatus)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        function exportPayments() {
            showNotification('Data pembayaran sedang diekspor...', 'success');
            // In real app, this would trigger file download
        }

        function closeModal() {
            document.getElementById('paymentDetailModal').style.display = 'none';
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

        // Initialize current date
        document.getElementById('paymentDate').valueAsDate = new Date();

        // Student search functionality
        document.getElementById('studentSearch').addEventListener('input', function(e) {
            const query = e.target.value;
            const suggestions = document.getElementById('studentSuggestions');
            
            if (query.length < 2) {
                suggestions.style.display = 'none';
                return;
            }
            
            const results = searchStudents(query);
            
            if (results.length > 0) {
                suggestions.innerHTML = results.map(student => 
                    `<div class="suggestion-item" onclick="selectStudent({nis: '${student.nis}', name: '${student.name}', class: '${student.class}'})">${student.nis} - ${student.name} (${student.class})</div>`
                ).join('');
                suggestions.style.display = 'block';
            } else {
                suggestions.style.display = 'none';
            }
        });

        // Payment form submission
        document.getElementById('paymentForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (!selectedStudent) {
                showNotification('Silakan pilih siswa terlebih dahulu', 'warning');
                return;
            }
            
            // Get form data
            const formData = new FormData(this);
            const data = Object.fromEntries(formData);
            data.student = selectedStudent;
            
            // In real app, you would send this to server
            console.log('Payment data:', data);
            
            showNotification('Pembayaran berhasil diproses!', 'success');
            
            // Reset form
            resetPaymentForm();
        });

        // Search payments
        document.getElementById('searchPayment').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const tableRows = document.querySelectorAll('#paymentTableBody tr');
            
            tableRows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('paymentDetailModal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }

        // Hide suggestions when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('#studentSearch') && !e.target.closest('#studentSuggestions')) {
                document.getElementById('studentSuggestions').style.display = 'none';
            }
        });

        // Initialize animations
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.fade-in').forEach((element, index) => {
                element.style.animationDelay = `${index * 0.1}s`;
            });
        });
    </script>

    <style>
        .suggestions-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            max-height: 200px;
            overflow-y: auto;
            z-index: 1000;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .suggestion-item {
            padding: 0.8rem 1rem;
            cursor: pointer;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .suggestion-item:hover {
            background: rgba(102, 126, 234, 0.05);
        }

        .suggestion-item:last-child {
            border-bottom: none;
        }
    </style>
</body>
</html>