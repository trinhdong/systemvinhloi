$(document).ready(function () {
    $(document).on('click', '#rejectOrder', function () {
        if ($(this).closest('#rejectOrderModal').find('#rejectNote').val() == '') {
            $(this).closest('#rejectOrderModal').find('#rejectNote').addClass('is-invalid')
            return false;
        }
        $('#update-status-order-reject').append($(this).closest('#rejectOrderModal').find('#rejectNote').clone().removeAttr('id'))
        $('#update-status-order-reject').submit()
        $(this).prop('disabled',true);
        $(this).closest('#rejectOrderModal').modal('hide');
    })

    $(document).on('click', '#approveOrder', function () {
        if ($(this).closest('#approveOrderModal').find('#approveNote').val() == '') {
            $(this).closest('#approveOrderModal').find('#approveNote').addClass('is-invalid')
            return false;
        }
        $('#update-status-order').append($(this).closest('#approveOrderModal').find('#approveNote').clone().removeAttr('id'))
        $('#update-status-order').submit()
        $(this).prop('disabled',true);
        $(this).closest('#approveOrderModal').modal('hide');
    })

    $(document).on('focus', '#approveNote, #rejectNote', function () {
        $(this).removeClass('is-invalid');
    })
})
