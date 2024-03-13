$(document).ready(function () {
    $('#deleteUserModal').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget);
        const userId = button.data('user-id');
        $('#deleteUser').attr('data-user-id', userId);
    });

    $('#deleteUser').on('click', function () {
        const userId = $(this).data('user-id');
        $(`#formDeleteUser${userId}`).submit();
        $('#deleteUserModal').modal('hide');
    });
});
