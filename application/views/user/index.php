<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-8">
            <h1 class="mb-3"><?= $title; ?></h1>
            <div class="card">
                <div class="card-horizontal">
                    <div>
                        <img style="width: 18rem;" src="<?= base_url('assets/img/profile/') . $user['profile_img']; ?>" alt="Card image cap">
                    </div>
                    <div class="card-body">
                        <h4 class="card-title"><?= $user['name']; ?></h4>
                        <p class="card-text"><?= $user['email']; ?></p>
                    </div>
                </div>
                <div class="card-footer">
                    <small class="text-muted"><?= (($user['role_id'] == 1) ? 'Admin' : 'Member'); ?></small>
                    <small class="text-muted float-right">since <?= date('d F y', $user['date_created']); ?></small>
                </div>
            </div>
        </div>
    </div>


</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->