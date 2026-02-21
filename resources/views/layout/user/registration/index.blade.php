<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Information</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">

    <style>
        body{
            background: hsl(230, 100%, 96%);
        }
        /* កំណត់ទំហំ popup */
        .swal2-popup {
            /* background-color: rgb(2, 1, 53); */
            background: #fff;
            color: rgb(2, 1, 53);
            border-radius: 10px;
            font-size: 18px;
            flex-direction: row-reverse !important;
        }



        /* កំណត់ button តូច */
        .swal2-confirm,
        .swal2-cancel {
            font-size: 12px ;
            padding: 10px 20px ;
            margin: 0 20px;
            border-radius: 6px;
        }
        .swal2-confirm:hover{
            background-color: rgb(77, 77, 185);
        }

        .swal2-cancel:hover{
            background-color: rgb(187, 7, 7);
        }
    </style>
</head>
<body>









    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- <script>
    Swal.fire({
        // title: "Information",
        text: "Are you a student from RPITSSVR?",
        width: 450,   // កំណត់ width តូច
        showCancelButton: true,
        confirmButtonText: "Yes",
        cancelButtonText: "No",
        confirmButtonColor: "blue",
        cancelButtonColor: "red",
        focusConfirm: false,
        focusCancel: false,
        allowEnterKey: false

    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: "Welcome Student!",
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "dashboard.html";
                }
            });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            Swal.fire({
                text: "Are you a lecturer from RPITSSVR?",
                width: 450,   // កំណត់ width តូច
                showCancelButton: true,
                confirmButtonText: "Yes",
                cancelButtonText: "No",
                confirmButtonColor: "blue",
                cancelButtonColor: "red",
                focusConfirm: false,
                focusCancel: false,
                allowEnterKey: false
            });

        }else if(result.isConfirmed){
             Swal.fire({
                title: "Welcome Lecturer!",
                }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "dashboard.html";
                }
            });
        }
    });
</script> -->


    <script>
        async function checkUserRole() {
            const student = await Swal.fire({
                text: "Are you a student from RPITSSVR?",
                width: 450,
                showCancelButton: true,
                confirmButtonText: "Yes",
                cancelButtonText: "No",
                confirmButtonColor: "blue",
                cancelButtonColor: "red",
                focusConfirm: false,
                focusCancel: false,
                stopKeydownPropagation: false   // prevents Enter key from auto trigger if needed
            });

            if (student.isConfirmed) {
                // await Swal.fire({ title: "Welcome Student!" });
                window.location.href = "{{ url('registration/student') }}";
                return;
            }

            const lecturer = await Swal.fire({
                text: "Are you a lecturer from RPITSSVR?",
                width: 450,
                showCancelButton: true,
                confirmButtonText: "Yes",
                cancelButtonText: "No",
                confirmButtonColor: "blue",
                cancelButtonColor: "red",
                focusConfirm: false,
                focusCancel: false,
                stopKeydownPropagation: false
            });

            if (lecturer.isConfirmed) {
                window.location.href = "{{ url('registration/lecturer') }}";
                return;
            }

            // Neither student nor lecturer — offer plain member registration
            const member = await Swal.fire({
                text: "Would you like to register as a regular member?",
                width: 450,
                showCancelButton: true,
                confirmButtonText: "Yes",
                cancelButtonText: "No",
                confirmButtonColor: "blue",
                cancelButtonColor: "red",
                focusConfirm: false,
                focusCancel: false,
                stopKeydownPropagation: false
            });

            if (member.isConfirmed) {
                window.location.href = "{{ route('registration.user') }}";
            } else {
                window.location.href = "{{ url('/') }}";
            }
        }

        checkUserRole();
    </script>




</body>
</html>
