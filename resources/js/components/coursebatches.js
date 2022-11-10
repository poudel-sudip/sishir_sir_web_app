$(document).ready(function () {
    $(document).on('change', '#course_name', function() {
        var course_id = $(this).val();
        var op = " ";
        $('#batch_name').html(" ");
        $.ajax({
            type: 'get',
            url: '/admin/courses/' + course_id + '/batchnames/',
            success: function success(data) {
                for (var i = 0; i < data.length; i++) {
                    op += '<option value="' + data[i].id + '">' + data[i].name + '</option>';
                }
                $('#batch_name').append(op);
            },
            error: function error() {
                console.log('failure');
            }
        });
    });
});
