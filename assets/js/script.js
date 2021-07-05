//upload file
$('.custom-file-input').on('change', function () {
    let filename = $(this).val().split('\\').pop();
    $(this).next('.custom-file-label').addClass("selected").html(filename);
});

//modal
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