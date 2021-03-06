<div class="main-content container-fluid">
    <div class="page-title">
        <h3>My Profile</h3>
    </div>
    <section class="section">
        <div class="row mb-2">
            <div class="col-lg-8">
                <?= $this->session->flashdata('message');  ?>
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-lg-6 text-start">
                                <h5>Profile</h5>
                            </div>
                            <div class="col-lg-6 text-end">
                                <a href="<?= base_url('user/edit_profil') ?>" class="btn btn-primary">Edit Profile</a>
                            </div>
                        </div>
                        <hr>
                    </div>
                    <div class="card-body">
                        <div>
                            <h4>NISN</h4>
                            <p><?= $user['nisn'] ?></p>
                        </div>
                        <div>
                            <h4>Nama Lengkap</h4>
                            <p><?= $user['nama'] ?></p>
                        </div>
                        <div>
                            <h4>Email</h4>
                            <p><?= $user['email'] ?></p>
                        </div>
                        <div>
                            <h4>No HP</h4>
                            <p><?= $user['no_hp'] ?></p>
                        </div>
                        <div>
                            <h4>Tempat Lahir</h4>
                            <p><?= $user['tempat_lahir'] ?></p>
                        </div>
                        <div>
                            <h4>Tanggal Lahir</h4>
                            <p><?= $user['tgl_lahir'] ?></p>
                        </div>
                        <div>
                            <h4>Alamat</h4>
                            <p><?= $user['alamat'] ?></p>
                        </div>
                        <div>
                            <h4>Foto</h4>
                            <img src="<?= base_url('assets/assets/images/profile/') . $user['image'] ?>" width="100" height="100">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
</div>