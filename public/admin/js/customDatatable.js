(function($) {
    'use strict';
    $('#user-table').DataTable({
        "order": [
            [0, "desc"]
        ]
    });

    $('#category-table').DataTable({
        "order": [
            [0, "desc"]
        ]
    });

    $('#table-courses').DataTable({
        "order": [
            [0, "desc"]
        ]
    });

    $('#batches-table').DataTable({
        "order": [
            [0, "desc"]
        ]
    });

    $('#booking-table').DataTable({
        "order": [
            [0, "desc"]
        ]
    });

    $('#private-chat-table').DataTable({
        "order": [
            [0, "desc"]
        ]
    });

    $('#course-batch-table').DataTable({
        "order": [
            [0, "desc"]
        ]
    });

    $('#main-booking-table').DataTable({
        "order": [
            [0, "desc"]
        ]
    });

    $('#verify-table').DataTable();

    $('#notification-table').DataTable({
        "order": [
            [0, "desc"]
        ]
    });

    $('#tutor-table').DataTable({
        "order": [
            [0, "desc"]
        ]
    });

    $('#video-table').DataTable({
        "order": [
            [0, "desc"]
        ]
    });

    $('#advanced-asc-table').DataTable({
        "order": [
            [0, "asc"]
        ],
        "lengthMenu": [
            [50, 100, 500, 1000, -1],
            [50, 100, 500, 1000, 'All']
        ]
    });

    $('#advanced-desc-table').DataTable({
        "order": [
            [0, "desc"]
        ],
        "lengthMenu": [
            [50, 100, 500, 1000, -1],
            [50, 100, 500, 1000, 'All']
        ]
    });

})(jQuery);