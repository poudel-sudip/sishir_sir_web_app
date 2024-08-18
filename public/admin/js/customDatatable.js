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

    $('.advanced-asc-table').DataTable({
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

    $('.advanced-desc-table').DataTable({
        "order": [
            [0, "desc"]
        ],
        "lengthMenu": [
            [50, 100, 500, 1000, -1],
            [50, 100, 500, 1000, 'All']
        ]
    });

    $('.all-asc-table').DataTable({
        "order": [
            [0, "asc"]
        ],
        "lengthMenu": [
            [-1],
            ['All']
        ]
    });

    $('.all-desc-table').DataTable({
        "order": [
            [0, "desc"]
        ],
        "lengthMenu": [
            [-1],
            ['All']
        ]
    });

    $('.all-entries-table').DataTable({
        searching: true, // Enable search feature
        ordering: true,  // Enable ordering feature
        paging: false,   // Disable pagination
        info: false,     // Disable showing information
        lengthChange: false, // Disable showing entries length
        bFilter: true,   // Enable search input field
        bInfo: false,    // Disable "Showing X to Y of Z entries" information
        bPaginate: false, // Disable pagination
        "order": [
            [0, "desc"]
        ],
    });

    $('.all-entries-asc-table').DataTable({
        searching: true, // Enable search feature
        ordering: true,  // Enable ordering feature
        paging: false,   // Disable pagination
        info: false,     // Disable showing information
        lengthChange: false, // Disable showing entries length
        bFilter: true,   // Enable search input field
        bInfo: false,    // Disable "Showing X to Y of Z entries" information
        bPaginate: false, // Disable pagination
        "order": [
            [0, "asc"]
        ],
    });

})(jQuery);