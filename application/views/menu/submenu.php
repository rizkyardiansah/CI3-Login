<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg">
            <h1 class="mb-3"><?= $title; ?></h1>

            <a href="" class="btn btn-primary mb-3 addSubmenu" data-toggle="modal" data-target="#submenuModal">Add New Submenu</a>

            <?= form_error('name', '<div class="alert alert-danger">', '</div>'); ?>
            <?= form_error('menu_id', '<div class="alert alert-danger">', '</div>'); ?>
            <?= form_error('icon', '<div class="alert alert-danger">', '</div>'); ?>
            <?= form_error('url', '<div class="alert alert-danger">', '</div>'); ?>

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
                        <th>Name</th>
                        <th>Menu</th>
                        <th>Icon</th>
                        <th>URL</th>
                        <th>Active</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php $i = 1;
                    foreach ($submenu as $sm) : ?>
                        <tr>
                            <th><?= $i++; ?></th>
                            <td><?= $sm['name'] ?></td>
                            <td><?= $sm['menuName'] ?></td>
                            <td><i class="<?= $sm['icon'] ?>"></i></td>
                            <td><a href="<?= base_url($sm['url']); ?>"><?= base_url($sm['url']); ?></a></td>
                            <td><?= ($sm['is_active'] == 1) ? 'Yes' : 'No'; ?></td>
                            <td>
                                <a class="badge badge-success editSubmenu" data-toggle="modal" data-target="#submenuModal" data-id="<?= $sm['id']; ?>">Edit</a>
                                <a href="<?= base_url('menu/deleteSubmenu/') . $sm['id']; ?>" class="badge badge-danger">Delete</a>
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
<div class="modal fade" id="submenuModal" tabindex="-1" role="dialog" aria-labelledby="submenuLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="submenuLabel">Add New Submenu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="" method="POST">
                <input type="hidden" id="id" name="id">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter submenu name..." value="<?= set_value('name'); ?>">
                    </div>

                    <div class="form-group">
                        <select class="form-control" id="menu_id" name="menu_id">
                            <option hidden value="0">Select menu</option>
                            <?php foreach ($menu as $m) : ?>
                                <option value="<?= $m['id']; ?>"><?= $m['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <input type="text" class="form-control" id="icon" name="icon" placeholder="Enter submenu icon class..." value="<?= set_value('icon'); ?>">
                    </div>

                    <div class="form-group">
                        <input type="text" class="form-control" id="url" name="url" placeholder="Enter submenu url..." value="<?= set_value('url'); ?>">
                    </div>

                    <div class="form-group pl-1">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="is_active" name="is_active">
                            <label class="form-check-label" for="is_active">
                                Active
                            </label>
                        </div>
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