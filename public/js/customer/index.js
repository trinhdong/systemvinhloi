$(document).ready(function () {
    $('#deleteCustomerModal').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget);
        const customerId = button.data('customer-id');
        $('#deleteCustomer').attr('data-customer-id', customerId);
    });

    $('#deleteCustomer').on('click', function () {
        const customerId = $(this).data('customer-id');
        $(`#formDeleteCustomer${customerId}`).submit();
        $('#deleteCustomerModal').modal('hide');
    });
});
