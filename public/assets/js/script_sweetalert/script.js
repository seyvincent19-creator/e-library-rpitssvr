// {{ Using Sweetalert2  }}

// {{ Button Show Detail }}
$(document).on('click', '.btn-show', function(e){
    e.preventDefault();
    let id = $(this).data('id'); // ទាញ ID ពី button

    $.ajax({
        url: '/admin/degree/' + id,
        type: 'GET',
        success: function(degree){


            function formatText(str) {
                return str
                    .toLowerCase()
                    .replace(/(^|\s|-|\()\w/g, function(char) {
                        return char.toUpperCase();
                });
            }

            Swal.fire({
                title: '<h4 class="fw-bold">Degree Details</h4>',
                html:
                   `
                        <div class="container text-start">
                            <p><strong class="me-2">Major :</strong> ${degree.majors_formatted}</p>
                            <p><strong class="me-2">Duration Year :</strong>${formatText(degree.duration_years)}</p>
                            <p><strong class="me-2">Study Time:</strong> ${formatText(degree.study_time)}</p>
                            <p><strong class="me-2">Degree Level :</strong> ${formatText(degree.degree_level)}</p>
                            <p><strong class="me-2">Generation :</strong> ${degree.generation_text}</p>
                        </div>
                    `,

                    // បើ Error Null ប្រើមួយនេះ
                    // <p><strong>Duration:</strong> ${degree.duration_years?.toUpperCase() ?? ''}</p>
                width: 500,
                background: 'var(--bg-dashboard)',
                color: 'var(--title-color)',
                customClass: {
                    popup: 'rounded-4 shadow'
                }
            });
        },
        error: function(xhr){
            console.log(xhr.responseText); // debug
            Swal.fire("Error!", "Cannot fetch degree details", "error");
        }
    });
});


// {{ Button Notification Delete }}
$('.btn-delete').click(function(e){
    e.preventDefault();
    var form = $(this).parents("form");

    Swal.fire({
        title: "Are you sure ?",
        text: "You won't be able to revert this!",
        // icon: "warning",
        // background: "#212529",
        // color: "#fff",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
        }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
});




