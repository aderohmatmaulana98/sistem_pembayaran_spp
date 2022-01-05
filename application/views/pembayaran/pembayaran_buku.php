<div class="card-body">
    <div class="card shadow mb-4 border-bottom-primary" id="tagihanbulanan" value="0">

        <a href="#tagihanbulan" class="d-block bg-primary border border-primary card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
            <h6 class="m-0 font-weight-bold text-white">Tagihan Buku</h6>
        </a>


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
                                <th>Deadline</th>
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
                                    <td><?php echo $t->besar_tagihan ?></td>
                                    <td><?php echo $t->deadline ?></td>

                                    <td style="<?= ($t->status_bayar == 'Lunas' ? 'color: green' : 'color: red') ?>"><?php echo $t->status_bayar ?></td>
                                    <td>
                                        <a href="#" class='btn btn-dange' style='font-size:15px;color:#00cc00' data-toggle="modal" data-target="#updatetagbuku<?= $t->id_tag_buku ?>">Bayar</a>
                                    </td>
                                </tr>
                                <div class="modal fade" id="updatetagbuku<?= $t->id_tag_buku ?>" tabindex="-1" role="dialog" aria-labelledby="addNewDonaturLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="addNewDonaturLabel">Pembayaran Buku </h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="p-5">
                                                <form class="user" method="post" action="<?= base_url('pembayaran/pem_buku'); ?>" enctype="multipart/form-data">
                                                    <div class="form-group">
                                                        <label for="id">Id</label><br>
                                                        <input type="hidden" name="nisn" value="<?php echo $t->nisn ?>">
                                                        <input type="text" class="form-control form-control-user" id="status_bayar" name="status_bayar" placeholder="Masukan status_bayar" value="<?= set_value('status_bayar'); ?>" hidden>
                                                        <input name="tanggal_bayar" class="form-control" type="text" value="<?php echo $tgl_bayar; ?>" hidden>
                                                        <input type="text" class="form-control form-control-user" id="id_tag_buku" name="id_tag_buku" value="<?php echo $t->id_tag_buku ?>" readonly="">

                                                    </div>
                                                    <div class="form-group">
                                                        <label>Paket</label>
                                                        <select id="paket" name="paket" class="form-control">
                                                            <option>Pilih Jenis Paket</option>
                                                            <?php
                                                            foreach ($this->db->query('SELECT * from Paket')->result() as $sis) { /*$this->m_transaksi->tampil_datatahun()->result() */
                                                            ?>

                                                                <option value="<?php echo $sis->nama_paket ?>"> <?php echo $sis->nama_paket ?> </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Jenis Pembayaran</label>
                                                        <select id="jenis_pembayaran" name="jenis_pembayaran" class="form-control" oninput="CekInput()">
                                                            <option>Pilih Jenis Pembayaran</option>
                                                            <?php
                                                            foreach ($this->db->query('SELECT * from jenis_pembayaran')->result() as $sis) { /*$this->m_transaksi->tampil_datatahun()->result() */
                                                            ?>

                                                                <option value="<?php echo $sis->jenis_pembayaran ?>"> <?php echo $sis->jenis_pembayaran ?> | Rp.<?php echo number_format($sis->besar_tagihan) ?> </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group" id="cek2">
                                                        <span id="format2"></span>
                                                        <label>Total Tagihan</label>
                                                        <input type="text" class="form-control form-control-user" id="saldo" name="besar_tagihan" placeholder="Masukan besar_tagihan" value="<?= set_value('besar_tagihan'); ?>" onkeyup="document.getElementById('format2').innerHTML = formatCurrency(this.value);" readonly>
                                                        <?= form_error('besar_tagihan', '<small class="text-danger pl-3">', '</small>'); ?>
                                                    </div>
                                                    <div class="form-group col-14 ">
                                                        <label>Metode Pembayaran</label>
                                                        <select id="metode-pembayaran" class="form-control" name="metode_pembayaran" required>
                                                            <option value="">Pilih Metode Pembayaran</option>
                                                            <option value="Online">Online</option>
                                                            <?php if ($_SESSION["role_id"] == "1") { ?>
                                                                <option value="Manual">Bayar Ditempat</option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        <button type="submit" name="update" class="btn btn-primary">Bayar</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function CekInput() {
        a = $("select#jenis_pembayaran option").filter(":selected").val();
        console.log(a);
        if (a == 'Semester 1') {
            $("input#saldo").val('<?= $semester1 ?>');
        } else if (a == 'Semester 2') {
            $("input#saldo").val('<?= $semester2 ?>');
        } else if (a == 'Semester 3') {
            $("input#saldo").val('<?= $semester3 ?>');
        } else if (a == 'Semester 4') {
            $("input#saldo").val('<?= $semester4 ?>');
        } else if (a == 'Semester 5') {
            $("input#saldo").val('<?= $semester5 ?>');
        } else if (a == 'Semester 6') {
            $("input#saldo").val('<?= $semester6 ?>');
        }
    }
</script>