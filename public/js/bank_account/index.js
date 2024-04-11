$(document).ready(function () {
    $('#deleteBankAccountModal').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget);
        const bankAccountId = button.data('bank-account-id');
        $('#deleteBankAccount').attr('data-bank-account-id', bankAccountId);
    });

    $('#deleteBankAccount').on('click', function () {
        const bankAccountId = $(this).data('bank-account-id');
        $(`#formDeleteBankAccount${bankAccountId}`).submit();
        $('#deleteBankAccountModal').modal('hide');
    });
});
