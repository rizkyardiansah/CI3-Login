//upload file
$('.custom-file-input').on('change', function () {
    let filename = $(this).val().split('\\').pop();
    $(this).next('.custom-file-label').addClass("selected").html(filename);
});

//Role modal
$(function () {
    $('.addRole').on('click', function () {
        $('#roleLabel').html('Add New Role');
        $('.modal-footer button[type=submit]').html('Add!');
        $('.modal-content form').attr('action', 'http://localhost/ci3-login/admin/addRole');
    });

    $('.editRole').on('click', function () {
        $('#roleLabel').html('Edit Role');
        $('.modal-footer button[type=submit]').html('Save!');
        $('.modal-content form').attr('action', 'http://localhost/ci3-login/admin/editRole');
        const id = $(this).data('id');

        $.ajax({
            url: 'http://localhost/ci3-login/admin/getRoleById',
            data: { id: id },
            method: 'post',
            dataType: 'json',
            success: function (data) {
                console.log(data);
                $('#name').val(data.role);
                $('#id').val(data.id);
            }
        });


    });

    $('.modal-footer button[type=button]').on('click', function () {
        $('#name').val("");
        $('#id').val("");
    });

    $('.modal-header button').on('click', function () {
        $('#name').val("");
        $('#id').val("");
    });
});


//Menu modal
$(function () {
    $('.addMenu').on('click', function () {
        $('#menuLabel').html('Add New Menu');
        $('.modal-footer button[type=submit]').html('Add!');
        $('.modal-content form').attr('action', 'http://localhost/ci3-login/menu/addMenu');
    });

    $('.editMenu').on('click', function () {
        $('#menuLabel').html('Edit Menu');
        $('.modal-footer button[type=submit]').html('Save!');
        $('.modal-content form').attr('action', 'http://localhost/ci3-login/menu/editMenu');
        const id = $(this).data('id');

        $.ajax({
            url: 'http://localhost/ci3-login/menu/getMenuById',
            data: { id: id },
            method: 'post',
            dataType: 'json',
            success: function (data) {
                console.log(data);
                $('#name').val(data.name);
                $('#id').val(data.id);
            }
        });


    });

    $('.modal-footer button[type=button]').on('click', function () {
        $('#name').val("");
        $('#id').val("");
    });

    $('.modal-header button').on('click', function () {
        $('#name').val("");
        $('#id').val("");
    });
});

//Subenu modal
$(function () {
    $('.addSubmenu').on('click', function () {
        $('#submenuLabel').html('Add New Submenu');
        $('.modal-footer button[type=submit]').html('Add!');
        $('.modal-content form').attr('action', 'http://localhost/ci3-login/menu/addSubmenu');
    });

    $('.editSubmenu').on('click', function () {
        $('#submenuLabel').html('Edit Submenu');
        $('.modal-footer button[type=submit]').html('Save!');
        $('.modal-content form').attr('action', 'http://localhost/ci3-login/menu/editSubmenu');
        const id = $(this).data('id');

        $.ajax({
            url: 'http://localhost/ci3-login/menu/getSubmenuById',
            data: { id: id },
            method: 'post',
            dataType: 'json',
            success: function (data) {
                console.log(data);
                $('#id').val(data.id);
                $('#name').val(data.name);
                $('#icon').val(data.icon);
                $('#url').val(data.url);
                $('#menu_id').val(data.menu_id);

                if (data.is_active == true) {
                    $('#is_active').prop('checked', true);
                } else {
                    $('#is_active').prop('checked', false);
                }
            }
        });


    });

    $('.modal-footer button[type=button]').on('click', function () {
        $('#id').val();
        $('#name').val();
        $('#icon').val();
        $('#url').val();
        $('#menu_id').val(0);
        $('#is_active').prop('checked', false);
    });

    $('.modal-header button').on('click', function () {
        $('#id').val();
        $('#name').val();
        $('#icon').val();
        $('#url').val();
        $('#menu_id').val(0);
        $('#is_active').prop('checked', false);
    });
});