@extends('master')

@section('title', 'Daftar Form1 Asesi')

@section('konten')
<div class="container mt-4 mb-5">
    <!-- Header Section -->
    <div class="page-header mb-4">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="d-flex align-items-center mb-3">
                    <div class="header-icon bg-gradient-primary">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <div class="ms-3">
                        <h2 class="mb-1 fw-bold">Daftar Permohonan Sertifikasi</h2>
                        <p class="text-muted mb-0">Form Asesmen FR.APL.01 - Data Asesi</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-md-end">
                <div class="stats-card">
                    <div class="stats-number">{{ count($asesi) }}</div>
                    <div class="stats-label">Total Permohonan</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Search Section -->
    <div class="filter-section mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6 col-lg-4">
                        <div class="search-box">
                            <i class="fas fa-search search-icon"></i>
                            <input type="text" id="searchInput" class="form-control ps-5" 
                                   placeholder="Cari nama, NIK, atau email...">
                        </div>
                    </div>
                    <div class="col-md-3 col-lg-2">
                        <button class="btn btn-outline-primary w-100" onclick="resetFilters()">
                            <i class="fas fa-redo me-2"></i>Reset
                        </button>
                    </div>
                    <div class="col-md-3 col-lg-2 ms-auto">
                        <button class="btn btn-success w-100" onclick="exportData()">
                            <i class="fas fa-file-excel me-2"></i>Export
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-gradient-primary text-white border-0">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-list me-2"></i>Data Asesi
                </h5>
                <span class="badge bg-white text-primary" id="rowCount">{{ count($asesi) }} Data</span>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 modern-table" id="asesiTable">
                    <thead class="table-light">
                        <tr>
                            <th width="100" class="text-center">
                                <i class="fas fa-hashtag me-1"></i>ID
                            </th>
                            <th>
                                <i class="fas fa-user me-1"></i>Nama Lengkap
                            </th>
                            <th width="150">
                                <i class="fas fa-id-card me-1"></i>NIK
                            </th>
                            <th width="200">
                                <i class="fas fa-envelope me-1"></i>Email
                            </th>
                            <th width="140">
                                <i class="fas fa-phone me-1"></i>Telepon
                            </th>
                            <th width="180" class="text-center">
                                <i class="fas fa-clock me-1"></i>Update Terakhir
                            </th>
                            <th width="150" class="text-center">
                                <i class="fas fa-cog me-1"></i>Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($asesi as $index => $a)
                            <tr class="data-row">
                                <td class="text-center">
                                    <span class="badge bg-light text-dark fw-semibold">{{ $a->id_asesi }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle">
                                            {{ strtoupper(substr($a->nama_lengkap, 0, 2)) }}
                                        </div>
                                        <div class="ms-3">
                                            <div class="fw-semibold text-dark">{{ $a->nama_lengkap }}</div>
                                            <small class="text-muted">Asesi #{{ $a->id_asesi }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <code class="text-primary">{{ $a->nik }}</code>
                                </td>
                                <td>
                                    <a href="mailto:{{ $a->email }}" class="text-decoration-none text-muted">
                                        <i class="fas fa-envelope me-1"></i>{{ $a->email }}
                                    </a>
                                </td>
                                <td>
                                    <a href="tel:{{ $a->telepon }}" class="text-decoration-none text-muted">
                                        <i class="fas fa-phone-alt me-1"></i>{{ $a->telepon }}
                                    </a>
                                </td>
                                <td class="text-center">
                                    <div class="date-wrapper">
                                        <i class="fas fa-calendar-alt text-muted me-2"></i>
                                        <span class="text-muted small">
                                            {{ \Carbon\Carbon::parse($a->updated_at)->format('d M Y') }}
                                        </span>
                                        <br>
                                        <small class="text-muted">
                                            {{ \Carbon\Carbon::parse($a->updated_at)->format('H:i') }}
                                        </small>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.permohonan.show', $a->id_asesi) }}" 
                                           class="btn btn-sm btn-primary btn-action"
                                           data-bs-toggle="tooltip" 
                                           title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-sm btn-info btn-action"
                                                onclick="showQuickView({{ $index }})"
                                                data-bs-toggle="tooltip" 
                                                title="Quick View">
                                            <i class="fas fa-info-circle"></i>
                                        </button>
                                        <button type="button" 
                                                class="btn btn-sm btn-success btn-action"
                                                onclick="contactAsesi('{{ $a->email }}', '{{ $a->telepon }}')"
                                                data-bs-toggle="tooltip" 
                                                title="Kontak">
                                            <i class="fas fa-paper-plane"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr id="emptyState">
                                <td colspan="7" class="text-center py-5">
                                    <div class="empty-state">
                                        <i class="fas fa-inbox"></i>
                                        <h5>Belum Ada Data</h5>
                                        <p class="text-muted">Belum ada permohonan FR.APL.01 yang terdaftar</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Pagination Info -->
        @if(count($asesi) > 0)
        <div class="card-footer bg-light border-0">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted small">
                    <i class="fas fa-info-circle me-1"></i>
                    Menampilkan <strong id="showingCount">{{ count($asesi) }}</strong> dari <strong>{{ count($asesi) }}</strong> data
                </div>
                <div>
                    <button class="btn btn-sm btn-outline-secondary" onclick="window.print()">
                        <i class="fas fa-print me-1"></i>Cetak
                    </button>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Quick View Modal -->
<div class="modal fade" id="quickViewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-gradient-primary text-white border-0">
                <h5 class="modal-title">
                    <i class="fas fa-user-circle me-2"></i>Quick View - Data Asesi
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4" id="quickViewContent">
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Tutup
                </button>
                <a href="#" id="viewDetailBtn" class="btn btn-primary">
                    <i class="fas fa-arrow-right me-2"></i>Lihat Detail Lengkap
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Contact Modal -->
<div class="modal fade" id="contactModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-gradient-success text-white border-0">
                <h5 class="modal-title">
                    <i class="fas fa-paper-plane me-2"></i>Kontak Asesi
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="contact-options">
                    <a href="#" id="emailLink" class="contact-option">
                        <div class="contact-icon bg-primary">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div>
                            <div class="fw-semibold">Kirim Email</div>
                            <small class="text-muted" id="emailText">email@example.com</small>
                        </div>
                    </a>
                    <a href="#" id="phoneLink" class="contact-option">
                        <div class="contact-icon bg-success">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div>
                            <div class="fw-semibold">Telepon</div>
                            <small class="text-muted" id="phoneText">0812-xxxx-xxxx</small>
                        </div>
                    </a>
                    <a href="#" id="whatsappLink" class="contact-option">
                        <div class="contact-icon bg-success">
                            <i class="fab fa-whatsapp"></i>
                        </div>
                        <div>
                            <div class="fw-semibold">WhatsApp</div>
                            <small class="text-muted">Chat via WhatsApp</small>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Asesi data for quick view
const asesiData = @json($asesi);

// Search functionality
document.getElementById('searchInput').addEventListener('keyup', function() {
    const searchTerm = this.value.toLowerCase();
    const rows = document.querySelectorAll('.data-row');
    let visibleCount = 0;
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        if (text.includes(searchTerm)) {
            row.style.display = '';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    });
    
    document.getElementById('showingCount').textContent = visibleCount;
    document.getElementById('rowCount').textContent = visibleCount + ' Data';
});

// Reset filters
function resetFilters() {
    document.getElementById('searchInput').value = '';
    const rows = document.querySelectorAll('.data-row');
    rows.forEach(row => row.style.display = '');
    document.getElementById('showingCount').textContent = rows.length;
    document.getElementById('rowCount').textContent = rows.length + ' Data';
}

// Quick View
function showQuickView(index) {
    const asesi = asesiData[index];
    const content = `
        <div class="row g-4">
            <div class="col-12 text-center mb-3">
                <div class="avatar-circle-lg mx-auto">
                    ${asesi.nama_lengkap.substring(0, 2).toUpperCase()}
                </div>
                <h4 class="mt-3 mb-1">${asesi.nama_lengkap}</h4>
                <p class="text-muted">ID Asesi: #${asesi.id_asesi}</p>
            </div>
            <div class="col-md-6">
                <div class="info-box">
                    <i class="fas fa-id-card text-primary"></i>
                    <div>
                        <small class="text-muted d-block">NIK</small>
                        <strong>${asesi.nik}</strong>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="info-box">
                    <i class="fas fa-envelope text-primary"></i>
                    <div>
                        <small class="text-muted d-block">Email</small>
                        <strong>${asesi.email}</strong>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="info-box">
                    <i class="fas fa-phone text-primary"></i>
                    <div>
                        <small class="text-muted d-block">Telepon</small>
                        <strong>${asesi.telepon}</strong>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="info-box">
                    <i class="fas fa-clock text-primary"></i>
                    <div>
                        <small class="text-muted d-block">Update Terakhir</small>
                        <strong>${new Date(asesi.updated_at).toLocaleDateString('id-ID')}</strong>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    document.getElementById('quickViewContent').innerHTML = content;
    document.getElementById('viewDetailBtn').href = `/admin/permohonan/${asesi.id_asesi}`;
    
    const modal = new bootstrap.Modal(document.getElementById('quickViewModal'));
    modal.show();
}

// Contact Asesi
function contactAsesi(email, phone) {
    document.getElementById('emailText').textContent = email;
    document.getElementById('phoneText').textContent = phone;
    document.getElementById('emailLink').href = `mailto:${email}`;
    document.getElementById('phoneLink').href = `tel:${phone}`;
    
    // Format phone for WhatsApp (remove leading 0 and add 62)
    const waPhone = phone.replace(/^0/, '62').replace(/\D/g, '');
    document.getElementById('whatsappLink').href = `https://wa.me/${waPhone}`;
    
    const modal = new bootstrap.Modal(document.getElementById('contactModal'));
    modal.show();
}

// Export data
function exportData() {
    alert('Fitur export akan segera tersedia!');
}

// Initialize tooltips
document.addEventListener('DOMContentLoaded', function() {
    const tooltips = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    tooltips.forEach(tooltip => new bootstrap.Tooltip(tooltip));
});
</script>

<style>
/* Page Header */
.page-header {
    margin-bottom: 2rem;
}

.header-icon {
    width: 60px;
    height: 60px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
    box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
}

.bg-gradient-primary {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
}

.bg-gradient-success {
    background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);
}

/* Stats Card */
.stats-card {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
    color: white;
    padding: 20px;
    border-radius: 12px;
    text-align: center;
    box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
}

.stats-number {
    font-size: 2.5rem;
    font-weight: 700;
    line-height: 1;
}

.stats-label {
    font-size: 0.9rem;
    opacity: 0.9;
    margin-top: 8px;
}

/* Search Box */
.search-box {
    position: relative;
}

.search-icon {
    position: absolute;
    left: 16px;
    top: 50%;
    transform: translateY(-50%);
    color: #6c757d;
}

.search-box .form-control {
    border-radius: 10px;
    border: 2px solid #e9ecef;
    padding: 10px 16px 10px 45px;
    transition: all 0.3s ease;
}

.search-box .form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.25rem rgba(0, 123, 255, 0.15);
}

/* Filter Section */
.filter-section .card {
    border-radius: 12px;
    overflow: hidden;
}

/* Modern Table */
.modern-table {
    border: none;
}

.modern-table thead {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}

.modern-table thead th {
    border: none;
    color: #495057;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.85rem;
    letter-spacing: 0.5px;
    padding: 16px;
}

.modern-table tbody tr {
    transition: all 0.3s ease;
    border-bottom: 1px solid #f1f3f5;
}

.modern-table tbody tr:hover {
    background-color: #f8f9fa;
    transform: scale(1.005);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.modern-table tbody td {
    padding: 16px;
    vertical-align: middle;
    border: none;
}

/* Avatar Circle */
.avatar-circle {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 0.9rem;
    flex-shrink: 0;
}

.avatar-circle-lg {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 1.8rem;
}

/* Action Buttons */
.btn-action {
    border-radius: 8px;
    padding: 6px 12px;
    transition: all 0.3s ease;
}

.btn-action:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

/* Empty State */
.empty-state {
    padding: 40px 20px;
}

.empty-state i {
    font-size: 4rem;
    color: #dee2e6;
    margin-bottom: 20px;
}

.empty-state h5 {
    color: #6c757d;
    font-weight: 600;
}

/* Date Wrapper */
.date-wrapper {
    font-size: 0.9rem;
}

/* Code styling */
code {
    background: #f8f9fa;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 0.9em;
}

/* Card Enhancements */
.card {
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.3s ease;
}

.card:hover {
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1) !important;
}

.card-header {
    padding: 16px 24px;
}

/* Modal Info Box */
.info-box {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 16px;
    background: #f8f9fa;
    border-radius: 12px;
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
}

.info-box:hover {
    border-color: #007bff;
    background: #f0f7ff;
}

.info-box i {
    font-size: 1.5rem;
}

/* Contact Options */
.contact-options {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.contact-option {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 16px;
    background: #f8f9fa;
    border-radius: 12px;
    text-decoration: none;
    color: inherit;
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.contact-option:hover {
    background: #fff;
    border-color: #007bff;
    transform: translateX(8px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.contact-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.3rem;
    flex-shrink: 0;
}

/* Responsive */
@media (max-width: 768px) {
    .header-icon {
        width: 50px;
        height: 50px;
        font-size: 1.2rem;
    }

    .stats-card {
        margin-top: 16px;
    }

    .stats-number {
        font-size: 2rem;
    }

    .modern-table thead th {
        font-size: 0.75rem;
        padding: 12px 8px;
    }

    .modern-table tbody td {
        padding: 12px 8px;
        font-size: 0.85rem;
    }

    .avatar-circle {
        width: 35px;
        height: 35px;
        font-size: 0.8rem;
    }

    .btn-group {
        flex-direction: column;
    }

    .btn-action {
        width: 100%;
        margin-bottom: 4px;
    }
}

/* Print Styles */
@media print {
    .filter-section,
    .btn-group,
    .card-footer,
    .header-icon {
        display: none !important;
    }

    .card {
        box-shadow: none;
        border: 1px solid #dee2e6;
    }

    .modern-table tbody tr:hover {
        background-color: transparent;
        transform: none;
    }
}

/* Animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.card, .data-row {
    animation: fadeInUp 0.5s ease;
}

/* Badge Enhancements */
.badge {
    font-weight: 500;
    letter-spacing: 0.3px;
    padding: 6px 12px;
}
</style>
@endsection