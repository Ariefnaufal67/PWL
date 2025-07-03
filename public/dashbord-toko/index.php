<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-shopping-cart"></i>
                        History Transaksi Pembelian <strong><?= $username ?></strong>
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-primary btn-sm" onclick="refreshData()">
                            <i class="fas fa-sync-alt"></i> Refresh
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Statistics Cards -->
                    <div class="row mb-4">
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3 id="totalTransaksi"><?= count($buy) ?></h3>
                                    <p>Total Transaksi</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-shopping-bag"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3 id="totalPendapatan">
                                        <?php 
                                        $totalPendapatan = 0;
                                        if (!empty($buy)) {
                                            foreach ($buy as $item) {
                                                $totalPendapatan += $item['total_harga'];
                                            }
                                        }
                                        echo number_to_currency($totalPendapatan, 'IDR');
                                        ?>
                                    </h3>
                                    <p>Total Pendapatan</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-dollar-sign"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3 id="totalItem">
                                        <?php 
                                        $totalItem = 0;
                                        if (!empty($buy) && !empty($product)) {
                                            foreach ($buy as $item) {
                                                if (isset($product[$item['id']])) {
                                                    foreach ($product[$item['id']] as $prod) {
                                                        $totalItem += $prod['jumlah'];
                                                    }
                                                }
                                            }
                                        }
                                        echo $totalItem;
                                        ?>
                                    </h3>
                                    <p>Total Item Terjual</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-boxes"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h3 id="transaksiPending">
                                        <?php 
                                        $pending = 0;
                                        if (!empty($buy)) {
                                            foreach ($buy as $item) {
                                                if ($item['status'] == "0") $pending++;
                                            }
                                        }
                                        echo $pending;
                                        ?>
                                    </h3>
                                    <p>Transaksi Pending</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-clock"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Search and Filter -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="searchInput">Cari Transaksi:</label>
                                <input type="text" class="form-control" id="searchInput" 
                                       placeholder="Cari berdasarkan ID, total, atau alamat..." 
                                       onkeyup="filterTable()">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="statusFilter">Filter Status:</label>
                                <select class="form-control" id="statusFilter" onchange="filterTable()">
                                    <option value="">Semua Status</option>
                                    <option value="1">Sudah Selesai</option>
                                    <option value="0">Belum Selesai</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="sortBy">Urutkan:</label>
                                <select class="form-control" id="sortBy" onchange="sortTable()">
                                    <option value="newest">Terbaru</option>
                                    <option value="oldest">Terlama</option>
                                    <option value="highest">Total Tertinggi</option>
                                    <option value="lowest">Total Terendah</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="transactionTable">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">ID Pembelian</th>
                                    <th scope="col">Waktu Pembelian</th>
                                    <th scope="col">Total Bayar</th>
                                    <th scope="col">Jumlah Item</th>
                                    <th scope="col">Alamat</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="transactionBody">
                                <?php
                                if (!empty($buy)) :
                                    foreach ($buy as $index => $item) :
                                        // Hitung jumlah item untuk transaksi ini
                                        $jumlahItem = 0;
                                        if (!empty($product) && isset($product[$item['id']])) {
                                            foreach ($product[$item['id']] as $prod) {
                                                $jumlahItem += $prod['jumlah'];
                                            }
                                        }
                                ?>
                                <tr data-status="<?= $item['status'] ?>" data-total="<?= $item['total_harga'] ?>" data-date="<?= $item['created_at'] ?>">
                                    <th scope="row"><?php echo $index + 1 ?></th>
                                    <td>
                                        <span class="badge badge-primary"><?php echo $item['id'] ?></span>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            <?php echo date('d M Y, H:i', strtotime($item['created_at'])) ?>
                                        </small>
                                    </td>
                                    <td>
                                        <strong class="text-success">
                                            <?php echo number_to_currency($item['total_harga'], 'IDR') ?>
                                        </strong>
                                    </td>
                                    <td>
                                        <span class="badge badge-info badge-pill" style="font-size: 0.9em;">
                                            <?= $jumlahItem ?> items
                                        </span>
                                    </td>
                                    <td>
                                        <small><?php echo $item['alamat'] ?></small>
                                    </td>
                                    <td>
                                        <?php if ($item['status'] == "1") : ?>
                                            <span class="badge badge-success">
                                                <i class="fas fa-check-circle"></i> Sudah Selesai
                                            </span>
                                        <?php else : ?>
                                            <span class="badge badge-warning">
                                                <i class="fas fa-clock"></i> Belum Selesai
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-success btn-sm" 
                                                data-bs-toggle="modal" data-bs-target="#detailModal-<?= $item['id'] ?>">
                                            <i class="fas fa-eye"></i> Detail
                                        </button>
                                    </td>
                                </tr>

                                <!-- Detail Modal Begin -->
                                <div class="modal fade" id="detailModal-<?= $item['id'] ?>" tabindex="-1">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header bg-primary text-white">
                                                <h5 class="modal-title">
                                                    <i class="fas fa-receipt"></i> Detail Transaksi #<?= $item['id'] ?>
                                                </h5>
                                                <button type="button" class="btn-close btn-close-white" 
                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- Transaction Info -->
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <strong>Waktu Pembelian:</strong><br>
                                                        <small class="text-muted"><?= date('d M Y, H:i:s', strtotime($item['created_at'])) ?></small>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <strong>Status:</strong><br>
                                                        <?php if ($item['status'] == "1") : ?>
                                                            <span class="badge badge-success">Sudah Selesai</span>
                                                        <?php else : ?>
                                                            <span class="badge badge-warning">Belum Selesai</span>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                
                                                <div class="row mb-3">
                                                    <div class="col-12">
                                                        <strong>Alamat Pengiriman:</strong><br>
                                                        <small class="text-muted"><?= $item['alamat'] ?></small>
                                                    </div>
                                                </div>

                                                <hr>
                                                
                                                <!-- Products List -->
                                                <h6><i class="fas fa-shopping-bag"></i> Daftar Produk:</h6>
                                                <div class="table-responsive">
                                                    <table class="table table-sm">
                                                        <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Produk</th>
                                                                <th>Harga</th>
                                                                <th>Jumlah</th>
                                                                <th>Subtotal</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php 
                                                            $totalSubtotal = 0;
                                                            if (!empty($product) && isset($product[$item['id']])) {
                                                                foreach ($product[$item['id']] as $index2 => $item2) :
                                                                    $subtotal = $item2['subtotal_harga'] - 1000000; // Sesuai dengan kode asli
                                                                    $totalSubtotal += $subtotal;
                                                            ?>
                                                            <tr>
                                                                <td><?= $index2 + 1 ?></td>
                                                                <td>
                                                                    <div class="d-flex align-items-center">
                                                                        <?php if ($item2['foto'] != '' && file_exists("img/" . $item2['foto'])) : ?>
                                                                            <img src="<?= base_url() . "img/" . $item2['foto'] ?>" 
                                                                                 width="50" height="50" class="rounded me-2">
                                                                        <?php endif; ?>
                                                                        <div>
                                                                            <strong><?= $item2['nama'] ?></strong>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td><?= number_to_currency($item2['harga'], 'IDR') ?></td>
                                                                <td>
                                                                    <span class="badge badge-secondary"><?= $item2['jumlah'] ?> pcs</span>
                                                                </td>
                                                                <td>
                                                                    <strong><?= number_to_currency($subtotal, 'IDR') ?></strong>
                                                                </td>
                                                            </tr>
                                                            <?php 
                                                                endforeach; 
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <hr>

                                                <!-- Summary -->
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <strong>Total Item:</strong> 
                                                        <span class="badge badge-info"><?= $jumlahItem ?> items</span>
                                                    </div>
                                                    <div class="col-md-6 text-right">
                                                        <strong>Subtotal Produk:</strong> <?= number_to_currency($totalSubtotal, 'IDR') ?><br>
                                                        <strong>Ongkir:</strong> <?= number_to_currency($item['ongkir'], 'IDR') ?><br>
                                                        <h5><strong>Total Bayar:</strong> <?= number_to_currency($item['total_harga'], 'IDR') ?></h5>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                <button type="button" class="btn btn-primary" onclick="printTransaction(<?= $item['id'] ?>)">
                                                    <i class="fas fa-print"></i> Cetak
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Detail Modal End -->
                                <?php
                                    endforeach;
                                endif;
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div>
                            <small class="text-muted">
                                Menampilkan <span id="showingCount"><?= count($buy) ?></span> dari <span id="totalCount"><?= count($buy) ?></span> transaksi
                            </small>
                        </div>
                        <nav aria-label="Page navigation">
                            <ul class="pagination pagination-sm mb-0" id="pagination">
                                <!-- Pagination will be generated by JavaScript -->
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// JavaScript untuk fitur filtering dan sorting
function filterTable() {
    const searchInput = document.getElementById('searchInput').value.toLowerCase();
    const statusFilter = document.getElementById('statusFilter').value;
    const table = document.getElementById('transactionTable');
    const tbody = table.getElementsByTagName('tbody')[0];
    const rows = tbody.getElementsByTagName('tr');
    let visibleCount = 0;

    for (let i = 0; i < rows.length; i++) {
        const row = rows[i];
        const cells = row.getElementsByTagName('td');
        
        if (cells.length > 0) {
            const id = cells[0].textContent.toLowerCase();
            const total = cells[2].textContent.toLowerCase();
            const alamat = cells[4].textContent.toLowerCase();
            const status = row.getAttribute('data-status');
            
            let showRow = true;
            
            // Filter by search
            if (searchInput && !id.includes(searchInput) && !total.includes(searchInput) && !alamat.includes(searchInput)) {
                showRow = false;
            }
            
            // Filter by status
            if (statusFilter && status !== statusFilter) {
                showRow = false;
            }
            
            row.style.display = showRow ? '' : 'none';
            if (showRow) visibleCount++;
        }
    }
    
    document.getElementById('showingCount').textContent = visibleCount;
}

function sortTable() {
    const sortBy = document.getElementById('sortBy').value;
    const table = document.getElementById('transactionTable');
    const tbody = table.getElementsByTagName('tbody')[0];
    const rows = Array.from(tbody.getElementsByTagName('tr'));
    
    rows.sort((a, b) => {
        switch(sortBy) {
            case 'newest':
                return new Date(b.getAttribute('data-date')) - new Date(a.getAttribute('data-date'));
            case 'oldest':
                return new Date(a.getAttribute('data-date')) - new Date(b.getAttribute('data-date'));
            case 'highest':
                return parseInt(b.getAttribute('data-total')) - parseInt(a.getAttribute('data-total'));
            case 'lowest':
                return parseInt(a.getAttribute('data-total')) - parseInt(b.getAttribute('data-total'));
            default:
                return 0;
        }
    });
    
    // Re-append sorted rows
    rows.forEach((row, index) => {
        tbody.appendChild(row);
        // Update row numbers
        const numberCell = row.querySelector('th');
        if (numberCell) numberCell.textContent = index + 1;
    });
}

function refreshData() {
    // Simulate data refresh
    location.reload();
}

function printTransaction(id) {
    // Implement print functionality
    const modal = document.getElementById('detailModal-' + id);
    const printWindow = window.open('', '', 'height=600,width=800');
    const modalContent = modal.querySelector('.modal-content').innerHTML;
    
    printWindow.document.write(`
        <html>
            <head>
                <title>Detail Transaksi #${id}</title>
                <style>
                    body { font-family: Arial, sans-serif; }
                    .modal-header { background: #007bff; color: white; padding: 10px; }
                    .modal-body { padding: 20px; }
                    .table { width: 100%; border-collapse: collapse; }
                    .table th, .table td { border: 1px solid #ddd; padding: 8px; }
                    .badge { padding: 3px 8px; border-radius: 3px; }
                    .badge-success { background: #28a745; color: white; }
                    .badge-warning { background: #ffc107; color: #212529; }
                    .badge-info { background: #17a2b8; color: white; }
                    .badge-secondary { background: #6c757d; color: white; }
                </style>
            </head>
            <body>
                ${modalContent}
                <script>window.print(); window.close();</script>
            </body>
        </html>
    `);
    printWindow.document.close();
}

// Initialize table on page load
document.addEventListener('DOMContentLoaded', function() {
    // Set initial sort
    sortTable();
});
</script>

<style>
/* Custom CSS untuk styling tambahan */
.small-box {
    border-radius: 10px;
    position: relative;
    overflow: hidden;
}

.small-box .inner {
    padding: 10px;
}

.small-box .icon {
    position: absolute;
    top: auto;
    bottom: 10px;
    right: 10px;
    z-index: 0;
    font-size: 70px;
    color: rgba(0,0,0,0.15);
}

.table-responsive {
    border-radius: 10px;
    overflow: hidden;
}

.table thead th {
    border-bottom: 2px solid #dee2e6;
    vertical-align: middle;
    font-weight: 600;
}

.table tbody tr:hover {
    background-color: rgba(0,123,255,0.05);
}

.badge {
    font-size: 0.8em;
}

.modal-content {
    border-radius: 10px;
}

.modal-header {
    border-radius: 10px 10px 0 0;
}

.card {
    border-radius: 15px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.btn {
    border-radius: 5px;
}

.form-control {
    border-radius: 5px;
}
</style>

<?= $this->endSection() ?>