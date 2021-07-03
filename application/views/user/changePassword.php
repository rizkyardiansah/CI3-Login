<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->

    <div class="row">
        <div class="col-lg-5">
            <h1 class="mb-3"><?= $title; ?></h1>

            <form action="" method="POST">
                <div class="form-group row">
                    <div class="col-sm">
                        <input type="password" class="form-control" id="currentpassword" name="currentpassword" placeholder="Current Password">
                        <?= form_error('currentpassword', '<small class="text-danger pl-3">', '</small>'); ?>

                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm">
                        <input type="password" class="form-control" id="newpassword1" name="newpassword1" placeholder="New Password">
                        <?= form_error('newpassword1', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm">
                        <input type="password" class="form-control" id="newpassword2" name="newpassword2" placeholder="Repeat New Password">
                        <?= form_error('newpassword2', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary float-right ml-3">Change</button>
                <button type="submit" class="btn btn-secondary float-right">Cancel</button>
            </form>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->