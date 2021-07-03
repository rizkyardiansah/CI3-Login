<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-8">
            <h1 class="mb-3"><?= $title; ?></h1>

            <?= form_open_multipart('user/edit') ?>
            <div class="form-group row">
                <label for="email" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="email" name="email" value="<?= $user['email']; ?>" readonly>
                </div>
            </div>

            <div class="form-group row">
                <label for="name" class="col-sm-2 col-form-label">Name</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="name" name="name" value="<?= $user['name']; ?>">
                    <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-2">
                    <label for="picture">Picture</label>
                </div>
                <div class="col-sm-3">
                    <img class="img-thumbnail" src="<?= base_url('assets/img/profile/') . $user['profile_img']; ?>">
                </div>
                <div class="col-sm-7">
                    <div class="input-group mb-3">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="profile_img" name="profile_img">
                            <label class="custom-file-label" for="profile_img">Choose file</label>
                        </div>
                    </div>
                </div>
            </div>

            <button class="btn btn-primary float-right" type="submit">Save</button>
            </form>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->