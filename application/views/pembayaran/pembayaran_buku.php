<div class="card-body">
    <div class="card shadow mb-4 border-bottom-primary" id="tagihanbulanan" value="0">
        <!-- Card Header - Accordion -->
        <a href="#tagihanbulan" class="d-block bg-primary border border-primary card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
            <h6 class="m-0 font-weight-bold text-white">Tagihan Buku</h6>
        </a>
        <!-- Card Content - Collapse -->

        <div class="collapse show" id="tagihanbulan">

            <div class="table-responsive">
                <div class="card-body">
                    <table class="table table-striped" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>NISN</th>
                                <th>Tahun Ajaran</th>
                                <th>Jenis Pembayaran</th>
                                <th>Dibayar</th>
                                <th>Status Bayar</th>
                                <th>Bayar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;

                            foreach ($siswa_buku as $t) {
                            ?>
                                <tr>
                                    <td><?php echo $no++ ?></td>
                                    <td><?php echo $t->nisn ?></td>

                                    <td><?php echo $t->tahun_ajaran_id ?></td>
                                    <td><?php echo $t->jenis_pembayaran ?></td>
                                    <td><?php echo $t->deadline ?></td>
                                    <td><?php echo $t->is_active ?></td>
                                    <td style="<?= ($t->status_bayar == 'Lunas' ? 'color: green' : 'color: red') ?>"><?php echo $t->status_bayar ?></td> -->
                                    <td>
                                        <?php
                                        if ($t->status_bayar != 'Lunas') {
                                            echo anchor('pembayaran/spp_bulanan/' . '/' . $t->nisn, '<input type=submit class="btn btn-warning" value=\'bayar\'>');
                                        }
                                        echo anchor('pembayaran/cetak_spp_bulanan/' . '/' . $t->nisn, 'Cetak', array('title' => 'Cetak kartu SPP', 'class' => 'btn btn-info'));
                                        ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>