$(function () {
    "use strict";

    $(document).ready(function () {
        $('#quantityDatatable').DataTable({
            "language": {
                "sProcessing":   "Đang xử lý...",
                "sLengthMenu":   "Hiển thị _MENU_ dòng",
                "sZeroRecords":  "Không tìm thấy dữ liệu",
                "sInfo":         "Hiển thị từ _START_ đến _END_ của _TOTAL_ dòng",
                "sInfoEmpty":    "Hiển thị từ 0 đến 0 của 0 dòng",
                "sInfoFiltered": "(được lọc từ _MAX_ dòng)",
                "sInfoPostFix":  "",
                "sSearch":       "Tìm:",
                "sUrl":          "",
                "oPaginate": {
                    "sFirst":    "Đầu",
                    "sPrevious": "Trước",
                    "sNext":     "Tiếp",
                    "sLast":     "Cuối"
                }
            }
        });

        const urlParams = new URLSearchParams(window.location.search);
        const year = urlParams.get('year') || '';
        const yearPayment = urlParams.get('year_payment') || '';
        const month = urlParams.get('month') || '';
        const day = urlParams.get('day') || '';

        $('#quantityDatatable_filter').addClass('d-flex justify-content-end')
        $('#quantityDatatable_filter').prepend("<form id=\"form-search\" class='d-flex justify-content-end'></form>");
        var days = getDaysOfMonth(parseInt(year),parseInt(month));
        var selectDays = $('<select name="day" onchange="$(\'#form-search\').submit()"'  + (year === '' || month === '' ? ' disabled' : '') +  ' class="form-select form-select-sm me-2" style="width: 80px;">');
        selectDays.append($('<option>').attr('value', '').text('ngày'));
        $.each(days, function(index, d) {
            selectDays.append($('<option>').attr('value', d).attr('selected', d === parseInt(day)).text(d));
        });
        $('#quantityDatatable_filter #form-search').prepend(selectDays);

        var months = [1,2,3,4,5,6,7,8,9,10,11,12];
        var selectMonth = $('<select name="month" onchange="$(\'#form-search\').submit()" class="form-select form-select-sm me-2" style="width: 80px;">');
        selectMonth.append($('<option>').attr('value', '').text('tháng'));
        $.each(months, function(index, m) {
            selectMonth.append($('<option>').attr('value', m).attr('selected', m === parseInt(month)).text(m));
        });
        $('#quantityDatatable_filter #form-search').prepend(selectMonth);

        var years = getYears();
        var selectYear = $('<select name="year" onchange="$(\'#form-search\').submit()" class="form-select form-select-sm me-2" style="width: 80px;">');
        $.each(years, function(index, y) {
            selectYear.append($('<option>').attr('value', y).attr('selected', y === parseInt(year)).text(y));
        });
        $('#quantityDatatable_filter #form-search').prepend(selectYear)

        var selectYearPayment = $('<select name="year_payment" onchange="$(\'#form-search-payment\').submit()" class="form-select form-select-sm me-2" style="width: 80px;">');
        $.each(years, function(index, y) {
            selectYearPayment.append($('<option>').attr('value', y).attr('selected', y === parseInt(yearPayment)).text(y));
        });
        $('#search-payment').prepend(selectYearPayment)
    });

    function getYears() {
        var currentYear = new Date().getFullYear();
        var years = [];
        for (var i = currentYear; i >= currentYear - 20; i--) {
            years.push(i);
        }
        return years;
    }
    function getDaysOfMonth(year, month) {
        var daysInMonth = new Date(year, month, 0).getDate();
        var days = [];
        for (var i = 1; i <= daysInMonth; i++) {
            days.push(i);
        }
        return days;
    }
});
