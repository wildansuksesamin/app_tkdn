<div class="notice d-flex bg-light-info rounded border-info border border-dashed mb-15 p-6">
    <?php echo getSvgIcon('general/gen045', 'svg-icon svg-icon-2tx svg-icon-info me-4'); ?>
    <div class="d-flex flex-stack flex-grow-1">
        <div class="fw-semibold">
            <h4 class="text-danger fw-bold">Penting Dibaca!</h4>
            <div class="fs-6 text-gray-700">Kami hanya menerima file berjenis <span class="fw-bold" id="ketentuan_file"><?php echo (isset($allow_extension) ? $allow_extension : 'PDF dan JPG'); ?> saja</span>. Jika file Anda tidak sesuai dengan ketentuan, silahkan convert terlebih dahulu.</div>
        </div>
    </div>
</div>