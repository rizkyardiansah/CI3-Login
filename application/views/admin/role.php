<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-6">
            <h1 class="mb-3"><?= $title; ?></h1>

            <a href="" class="btn btn-primary mb-3 addRole" data-toggle="modal" data-target="#roleModal">Add New Role</a>

            <?= form_error('name', '<div class="alert alert-danger">', '</div>'); ?>

            <?php if ($this->session->flashdata('flash')) : ?>
                <div class="alert alert-<?= $this->session->flashdata('flash')['type']; ?> alert-dismissable fade show" role="alert">
                    <strong><?= $this->session->flashdata('flash')['text']; ?></strong>
                    <button type="button" class="close" data-dismiss="alert"></button>
                </div>

                <?php unset($_SESSION['flash']); ?>
            <?php endif; ?>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1;
                    foreach ($role as $r) : ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= $r['role']; ?></td>
                            <td>
                                <a href="<?= base_url('admin/roleAccess/') . $r['id']; ?>" class="badge badge-warning">access</a>
                                <a class="badge badge-success editRole" data-toggle="modal" data-target="#roleModal" data-id="<?= $r['id']; ?>">edit</a>
                                <a href="<?= base_url('admin/deleteRole/') . $r['id'] ?>" class="badge badge-danger" onclick="confirm('Are you sure')">delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- Modal Add New Role-->
<div class="modal fade" id="roleModal" tabindex="-1" role="dialog" aria-labelledby="roleLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="roleLabel">Add New Role</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="POST">
            <input type="hidden" name="id" id="id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Role Name</label>
                        <input type="text" class="form-control" id="name" name="name" aria-describedby="emailHelp" placeholder="Enter Role name...">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="submit" class="btn btn-primary">Add!</button>
                </div>
            </form>
        </div>
    </div>
</div>