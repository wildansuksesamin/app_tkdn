<div class="container mt-5">
    <h2 class="mb-4">Upload Invoice dan Faktur Pajak</h2>

    <?php if (isset($success)): ?>
        <div class="alert alert-<?php echo $success ? 'success' : 'danger'; ?>">
            <?php echo $success ? 'Upload berhasil.' : 'Upload gagal: ' . $results['error']; ?>
        </div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="invoice" class="form-label">Upload File Invoice (PDF/JPG/PNG)</label>
            <input type="file" name="invoice" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="faktur" class="form-label">Upload File Faktur Pajak (PDF/JPG/PNG)</label>
            <input type="file" name="faktur" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Upload</button>
    </form>

    <hr class="my-5">

    <h4>Riwayat Upload</h4>
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>No</th>
                <th>File Invoice</th>
                <th>File Faktur Pajak</th>
                <th>Waktu Upload</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($upload_list)): ?>
                <?php $no = 1; foreach ($upload_list as $row): ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><a href="<?= base_url('uploads/' . $row->file_invoice); ?>" target="_blank">Lihat Invoice</a></td>
                        <td><a href="<?= base_url('uploads/' . $row->file_faktur); ?>" target="_blank">Lihat Faktur</a></td>
                        <td><?= date('d M Y H:i', strtotime($row->created_at)); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="4" class="text-center">Belum ada data</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
