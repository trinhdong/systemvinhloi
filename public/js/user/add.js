$(document).ready(function () {
    $('.toggle-password').click(function () {
        // Tìm icon bên trong nút
        let icon = $(this).find('i');
        // Kiểm tra và thay đổi class của icon
        if (icon.hasClass('bi-eye-slash')) {
            icon.removeClass('bi-eye-slash').addClass('bi-eye'); // Chuyển sang trạng thái hiển thị mật khẩu
            $(this).parent().find('input').attr('type', 'text');
        } else {
            icon.removeClass('bi-eye').addClass('bi-eye-slash'); // Chuyển sang trạng thái ẩn mật khẩu
            $(this).parent().find('input').attr('type', 'password');
        }
    });
});
$(document).on('submit', 'form', function () {
    let isValid = true;
    if ($('input[name="name"]').val() == '') {
        $('input[name="name"]').addClass('is-invalid')
        isValid = false;
    }
    if ($('input[name="email"]').val() == '') {
        $('input[name="email"]').addClass('is-invalid')
        isValid = false;
    }
    if ($('.has-validation input[name="password"]').val() == '') {
        $('input[name="password"]').addClass('is-invalid')
        isValid = false;
    }
    if ($('select[name="role"]').val() == null) {
        $('select[name="role"]').addClass('is-invalid')
        isValid = false;
    }
    if (!isValid) {
        return false;
    }
    $(this).find('button[type="submit"]').prop('disabled',true);
    $(this).submit();
})
$(document).on('focus', 'input[name="name"], input[name="email"], input[name="password"], select[name="role"]', function () {
    $(this).removeClass('is-invalid');
})
$(document).on('change', 'select[name="role"]', function () {
    if ($(this).val() == 2) {
        $('#addCustomer').removeClass('d-none')
    } else {
        $('#addCustomer').addClass('d-none')
    }
})
