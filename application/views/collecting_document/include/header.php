<div class="card card-flush h-lg-100 mb-10">
    <!--begin::Body-->
    <div class="card-body p-lg-17">
        <!--begin::Layout-->
        <div id="data_zona_collecting_dokumen">
            <div class="d-flex flex-column flex-lg-row">
                <!--begin::Content-->
                <div class="flex-lg-row-fluid me-0">
                    <div class="fw-bold fs-3"><?php echo $konten['opening_meeting']->nama_badan_usaha . ' ' . $konten['opening_meeting']->nama_perusahaan; ?></div>
                    <div class="row mt-3">
                        <div class="col-sm-3">
                            <div class="fs-7 text-gray-400">Nomor Order</div>
                            <div class="fw-semibold text-gray-800 fs-5"><?php echo $konten['opening_meeting']->nomor_order_payment; ?></div>
                        </div>
                        <div class="col-sm-3">
                            <div class="fs-7 text-gray-400">Nomor OC</div>
                            <div class="fw-semibold text-gray-800 fs-5"><?php echo $konten['opening_meeting']->nomor_oc; ?></div>
                        </div>
                        <div class="col-sm-3">
                            <div class="fs-7 text-gray-400">Tipe Pengajuan</div>
                            <div class="fw-semibold text-gray-800 fs-5">
                                <?php
                                if ($konten['opening_meeting']->tipe_pengajuan == 'PEMERINTAH') {
                                    echo 'Berbayar Pemerintah';
                                } else {
                                    echo 'Berbayar Pelaku Usaha';
                                }
                                ?>
                            </div>
                        </div>
                        <?php
                        if ($konten['opening_meeting']->id_status >= 7 and $konten['opening_meeting']->id_status < 15) {
                        ?>
                            <div class="col-sm-3">
                                <div class="fs-7 text-gray-400">Waktu Collecting Dokumen</div>
                                <div class="fw-semibold text-gray-800 fs-5">
                                    <?php
                                    $tgl_mulai_verifikasi_dokumen = $konten['opening_meeting']->tgl_mulai_verifikasi_dokumen; // contoh nilai variabel tgl_mulai_verifikasi_dokumen

                                    $datetime1 = new DateTime($tgl_mulai_verifikasi_dokumen);
                                    $datetime2 = new DateTime('now');

                                    $interval = $datetime1->diff($datetime2);
                                    $hari_berjalan = $interval->format('%a');

                                    $sisa_hari = $konten['opening_meeting']->masa_collecting_dokumen - $hari_berjalan;
                                    echo $sisa_hari . ' hari lagi';
                                    ?>
                                </div>
                            </div>
                        <?php } else if ($konten['opening_meeting']->id_status == 17) {
                        ?>

                            <div class="col-sm-3">
                                <div class="fs-7 text-gray-400">Tipe Permohonan</div>
                                <div class="fw-semibold text-gray-800 fs-5">
                                    <?php
                                    echo $konten['opening_meeting']->nama_tipe_permohonan;
                                    ?>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <!--end::Content-->

            </div>
            <!--end::Layout-->
        </div>
    </div>
    <!--end::Body-->
</div>