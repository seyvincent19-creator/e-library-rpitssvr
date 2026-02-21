$(document).ready(function () {
    $('#example').DataTable({
        responsive: true,
        paging: true,
        searching: true,
        info: true,

         // ✅ FIX "Show entries"
        language: {
            lengthMenu: 'Show _MENU_ entries per page'
        },
        
        buttons: ['copy','excel', 'pdf', 'print'],

        /*
         DOM LAYOUT EXPLANATION
         <"dt-export"B>        → Export buttons (top)
         <"dt-top"fp>          → Search (f) + Pagination (p) on TOP
         r t                   → processing + table
         <"dt-info"i>          → info bottom
        */
        // dom:
        //     '<"row mb-3"<"col-md-12 text-start"B>>' +
        //     '<"row mb-3"<"col-md-6"l><"col-md-6 text-end"f>>' +
        //     // 'i'+'rtp',
        //     'rtip',

        dom:
            // Export buttons (top)
            '<"row mb-3"<"col-12"B>>' +

            // Show entries (left) + Search (right)
            '<"row mb-2 align-items-center"' +
                '<"col-md-6"l>' +
                '<"col-md-6 text-end"f>' +
            '>' +

            // Table
            'rt' +

            // Info (left) + Pagination (right)
            '<"row mt-2 align-items-center"' +
                '<"col-md-6"i>' +
                '<"col-md-6 d-flex justify-content-end"p>' +
            '>'
           
    });
});


