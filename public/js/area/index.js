$(document).ready(function () {
    $('#deleteAreaModal').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget);
        const areaId = button.data('area-id');
        $('#deleteArea').attr('data-area-id', areaId);
    });

    $('#deleteArea').on('click', function () {
        const areaId = $(this).data('area-id');
        $(`#formDeleteArea${areaId}`).submit();
        $('#deleteAreaModal').modal('hide');
    });
});
