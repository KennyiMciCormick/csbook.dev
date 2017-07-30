$(document).on('click', '.verifyRe', function (event) {
    event.preventDefault();
    var t = $(this);
    var href = t.attr('href');
    swal({
        title: t.data('title'),
        text: t.data('description'),
        showCancelButton: true,
        closeOnConfirm: false,
        showLoaderOnConfirm: true,
        confirmButtonColor: t.data('color_button'),
        confirmButtonText: "Так",
        cancelButtonColor: "#b6c2c9",
        cancelButtonText: "Відмінити"
    }, function (isConfirm) {
        if (isConfirm) {
            $.ajax({
                type: "POST",
                url: href,
                success: function (response) {
                    if (response) {
                        swal('Видалено!');
                        table.updateTable('');
                    } else {
                        alert('ERROR');
                    }
                }
            });
        }
    });
});

$('#modal-edit').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var msg = button.closest('tr').find('.message').text();
    var id = button.data('id');
    console.log(msg);
    console.log(id);
    var modal = $(this);
    modal.find('#edit-msg').val(msg);
    modal.find('#edit-id').val(id);
});

$("#editForm").validate({
    validClass: "success-validate",
    errorClass: "error-validate",
    errorElement: "div",
    errorPlacement: function (error, element) {
        return false;
    },
    rules: {
        message: {
            required: true,
            minlength: 2
        }
    },
    submitHandler: function (form) {
//                form.submit();
        var em = $('#edit-msg');
        var ei = $('#edit-id');
        var msg = em.val();
        em.val('');
        var id = ei.val();
        ei.val('');
        $.ajax({
            type: "POST",
            url: '/admin/notes/edit/' + id,
            data: {msg: msg},
            success: function (response) {
                if (response) {
                    $('.notesTable .note-' + id + ' .message').html(response);
                } else {
                    alert('ERROR');
                }
                $('#modal-edit').modal('hide');
            }
        });
        return false;
    }
});
