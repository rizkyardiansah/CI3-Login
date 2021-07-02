<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-6">
            <h1 class="mb-3"><?= $title; ?></h1>

            <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addMenuModal">Add New Menu</a>
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
                        <th scope="col">#</th>
                        <th scope="col">Menu</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1;
                    foreach ($menu as $m) : ?>
                        <tr>
                            <th scope="row"><?= $i++; ?></th>
                            <td><?= $m['name']; ?></td>
                            <td>
                                <a href="" class="badge badge-success">Edit</a>
                                <a href="<?= base_url('menu/deletemenu/') . $m['id']; ?>" class="badge badge-danger">Delete</a>
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

<!-- Modal -->
<!-- Button trigger modal -->

<!-- Modal -->
<div class="modal fade" id="addMenuModal" tabindex="-1" role="dialog" aria-labelledby="addMenuLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addMenuLabel">Add New Menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('menu/addMenu'); ?>" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="name" name="name" aria-describedby="emailHelp" placeholder="Enter menu name...">
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