<div class="card-body">
    <div class="card shadow mb-4 border-bottom-success" id="infosiswa" value="0">
        <!-- Card Header - Accordion -->
        <a href="#informasisiswa" class="d-block bg-success border border-success card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
            <h6 class="m-0 font-weight-bold text-white">Informasi siswa</h6>
        </a>
        <!-- Card Content - Collapse -->
        <div class="collapse show" id="informasisantri">
            <div class="card-body">
                <table class="table table-striped">
                    <tbody>
                        <?php foreach ($siswa as $u) { ?>
                            <tr>
                                <td>Nis </td>
                                <td>: <?php echo $u->nis ?></td>
                            </tr>
                            <tr>
                                <td>Nama siswa</td>
                                <td>: <span id="nm-siswa"><?php echo $u->nama_siswa ?></span></td>
                            </tr>
                            <!-- <tr>
                                <td>Jenis Kelmain</td>
                                <td>: <?php echo $u->jenis_kelamin ?></td>
                            </tr>
                            <tr>
                                <td>Angkatan</td>
                                <td>: <?php echo $u->angkatan ?></td>
                            </tr>
                            <tr>
                                <td>Kamar</td>
                                <td>: <?php echo $u->kamar ?></td>
                            </tr>
                            <tr>
                                <td>Alamat</td>
                                <td>: <?php echo $u->alamat ?></td>
                            </tr>
                            <tr>
                                <td>NO HP</td>
                                <td>: <?php echo $u->no_hp ?></td>
                            </tr> -->
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>