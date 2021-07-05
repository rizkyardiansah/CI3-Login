<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-6">
            <h1 class="mb-3"><?= $title; ?></h1>

            <?php if ($this->session->flashdata('flash')) : ?>
                <div class="alert alert-<?= $this->session->flashdata('flash')['type']; ?> alert-dismissable fade show" role="alert">
                    <strong><?= $this->session->flashdata('flash')['text']; ?></strong>
                    <button type="button" class="close" data-dismiss="alert"></button>
                </div>

                <?php unset($_SESSION['flash']); ?>
            <?php endif; ?>

            <h3><?= $specific_role['role'] ?></h3>

            <form action="" method="POST">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Access</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $i = 1;
                        foreach ($menu as $m) : ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= $m['name']; ?></td>
                                <td>
                                    <div class="form-check">
                                        <?php foreach ($access as $a) : ?>
                                            <?php if ($a['menu_id'] == $m['id'] && $a['role_id'] == $specific_role['id']) : ?>
                                                <input class="form-check-input" type="checkbox" value="<?= $specific_role['id']; ?>" name="<?= $m['name']; ?>" checked>
                                                <?php break; ?>
                                            <?php else : ?>
                                                <input class="form-check-input" type="checkbox" value="<?= $specific_role['id']; ?>" name="<?= $m['name']; ?>">
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <button type="submit" name="submit" value="on" class="btn btn-primary float-right mt-2 mr-3">Save Changes</button>
            </form>
            <a href="<?= base_url('admin/role'); ?>" class="btn btn-secondary float-right mt-2 mr-2">Cancel</a>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->