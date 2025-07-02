<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<!-- Flash Messages -->
<?php if (session()->getFlashData('success')) : ?>
<div class="alert alert-info alert-dismissible fade show" role="alert">
    <?= esc(session()->getFlashData('success')) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>

<?php if (session()->getFlashData('failed')) : ?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <?= esc(session()->getFlashData('failed')) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>

<!-- Discount Info Display (if exists in session) -->
<?php if (session()->get('discount')): ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="bi bi-gift"></i> 
    Diskon Hari Ini: Rp <?= number_format(session()->get('discount'), 0, ',', '.') ?>
    <small>(<?= session()->get('discount_date') ?>)</small>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>

<!-- Main Content -->
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="card-title">Data Diskon</h5>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDiskonModal">
                <i class="bi bi-plus"></i> Tambah Data
            </button>
        </div>
        
        <!-- Success/Error Messages -->
        <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>
        
        <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>

        <!-- Entries per page selector -->
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="dataTables_length">
                    <label>
                        <select class="form-select form-select-sm" style="width: auto; display: inline-block;">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                        entries per page
                    </label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="dataTables_filter text-end">
                    <label>
                        Search: <input type="search" class="form-control form-control-sm" style="width: auto; display: inline-block;" placeholder="">
                    </label>
                </div>
            </div>
        </div>

        <!-- Discount Table -->
        <div class="table-responsive">
            <table class="table table-striped table-hover datatable">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Tanggal</th>
                        <th>Nominal (Rp)</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($diskons)): ?>
                        <?php $no = 1; foreach ($diskons as $diskon): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= date('Y-m-d', strtotime($diskon['tanggal'])) ?></td>
                            <td><?= number_format($diskon['nominal'], 0, ',', '.') ?></td>
                            <td>
                                <button type="button" class="btn btn-sm btn-success" 
                                        onclick="editDiskon(<?= $diskon['id'] ?>, '<?= $diskon['tanggal'] ?>', <?= $diskon['nominal'] ?>)">
                                    Ubah
                                </button>
                                <a href="<?= base_url('/diskon/delete/' . $diskon['id']) ?>" 
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('Yakin ingin menghapus diskon ini?')">
                                    Hapus
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center">Tidak ada data diskon</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination info -->
        <div class="row mt-3">
            <div class="col-md-6">
                <div class="dataTables_info">
                    Showing 1 to <?= count($diskons ?? []) ?> of <?= count($diskons ?? []) ?> entries
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Diskon Modal -->
<div class="modal fade" id="addDiskonModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url('/diskon/store') ?>" method="post">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Diskon Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                    </div>
                    <div class="mb-3">
                        <label for="nominal" class="form-label">Nominal Diskon</label>
                        <input type="number" class="form-control" id="nominal" name="nominal" 
                               placeholder="Masukkan nominal diskon" required min="1">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Diskon Modal -->
<div class="modal fade" id="editDiskonModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="" method="post" id="editForm">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h5 class="modal-title">Edit Diskon</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_tanggal" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="edit_tanggal" name="tanggal" readonly>
                        <small class="text-muted">Tanggal tidak dapat diubah</small>
                    </div>
                    <div class="mb-3">
                        <label for="edit_nominal" class="form-label">Nominal Diskon</label>
                        <input type="number" class="form-control" id="edit_nominal" name="nominal" 
                               placeholder="Masukkan nominal diskon" required min="1">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    function editDiskon(id, tanggal, nominal) {
        document.getElementById('edit_tanggal').value = tanggal;
        document.getElementById('edit_nominal').value = nominal;
        document.getElementById('editForm').action = '<?= base_url('/diskon/update/') ?>' + id;
        
        var editModal = new bootstrap.Modal(document.getElementById('editDiskonModal'));
        editModal.show();
    }

    // Auto-dismiss alerts after 5 seconds
    setTimeout(function() {
        var alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            var bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);

    // Initialize DataTable if needed
    $(document).ready(function() {
        if (typeof $.fn.DataTable !== 'undefined') {
            $('.datatable').DataTable({
                "pageLength": 10,
                "lengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
                "language": {
                    "search": "Search:",
                    "lengthMenu": "_MENU_ entries per page",
                    "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                    "paginate": {
                        "first": "First",
                        "last": "Last",
                        "next": "Next",
                        "previous": "Previous"
                    }
                }
            });
        }
    });
</script>
<?= $this->endSection() ?>