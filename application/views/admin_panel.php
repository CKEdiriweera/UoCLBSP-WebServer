<?php
/**
 * Created by PhpStorm.
 * User: udithj
 * Date: 8/14/2018
 * Time: 5:29 PM
 */
?>

<html>

<head>

    <script src="<?php echo base_url() ?>assets/sweetalert2/dist/sweetalert2.all.min.js"></script>

    <style>
        #adminSearch{
            background-image: url('<?php echo base_url(); ?>assets/drawable/searchicon.png');
            background-position: 2px 8px;
            background-size: 35px;
            background-repeat: no-repeat;
            width: 30%;
            font-size: 16px;
            padding: 12px 30px 12px 40px;
            border: 2px solid #ddd;
            margin-bottom: 12px;
        }

    </style>
    
    <script>
        $(document).ready(function () {
            updateData();
        });


        function updateData() {
            $("#adminTable tbody tr").remove();
            $.ajax({
                url: '<?php echo base_url('Admin/get_admins_data'); ?>',
                method: 'GET',
                // data: ,
                dataType: 'json',
                success: function (response) {
                    // console.log(response);
                    var tab = '<tbody id="myTable">';
                    // var editButton = "<a class='btn btn-primary'>Edit</a>";
                    // var deleteButton =  "<a class='btn btn-danger'>Delete</a>";
                    //var action = `<td>${editButton}&nbsp&nbsp&nbsp&nbsp${deleteButton}</td>`;

                    response.forEach(function (entry) {

                        var deleteButton = `<td><a class="btn btn-danger" onclick="deleteAdmin(${entry.id})">Delete</a></td>`;

                        let userEmail = '<?php echo $_SESSION['email'] ?>';

                        // if (userEmail===entry.email){
                        //     var editButton = `<a class="btn btn-primary" onclick="">Edit</a>`;
                        //
                        //     var action = `<td>${editButton}</td><td>${deleteButton}</td>`;
                        // }
                        // else {
                        //     var action = `<td></td><td>${deleteButton}</td>`;
                        // }
                        tab += `<tr><td>${entry.name}</td><td>${entry.email}</td><td>${entry.telephone}</td>${deleteButton}</tr>`;

                    });
                    tab += '</tbody></table>';
                    document.getElementById('adminTable').innerHTML += tab;

                },

                error: function (response) {
                    // console.log(response);
                    swal({
                        type: 'error',
                        text: 'something went wrong!'
                    });
                }

                });
        }

        function deleteAdmin(id) {
            swal({
                title: `are you sure you want to delete?`,
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: true
            }).then((result) => {
                if (result.value){
                    $.ajax({
                        url: '<?php echo base_url('Admin/delete_admin'); ?>/'+id,
                        method: 'POST',
                        //data: id,
                        // dataType: 'json',
                        success: function (response) {
                            console.log(response);
                            swal(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            );
                            updateData();
                        },
                        error: function (response) {
                            console.log(response);
                            swal({
                                type: 'error',
                                text: 'something went wrong!'
                            });
                        }
                    });
                }
            })
        }

        function editAdmin(id) {
            $.ajax({
                url: '<?php echo base_url('Admin/get_admin_data_by_id'); ?>/'+id,
                method: 'POST',
                //data: id,
                // dataType: 'json',
                success: function (response) {
                    // console.log(response);



                    swal(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                    );
                    updateData();
                },
                error: function (response) {
                    // console.log(response);
                    swal({
                        type: 'error',
                        text: 'something went wrong!'
                    });
                }
            });
        }


        $(document).ready(function(){
            $("#adminSearch").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#myTable tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });


        function searchTable() {
            var input, searchBy, filter, table, tr, td, i;

            if (document.getElementById('r1').checked){
                searchBy = 'name';
            }
            else if (document.getElementById('r2').checked){
                searchBy = 'email';
            }
            else {
                searchBy = 'contact'
            }

            input = document.getElementById("adminSearch");
            filter = input.value.toUpperCase();
            table = document.getElementById("adminTable");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0];
                console.log(td);
                // if (td) {
                //     if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                //         tr[i].style.display = "";
                //     } else {
                //         tr[i].style.display = "none";
                //     }
                // }
            }
        }


    </script>

    <style>
        .row.vdivide [class*='col-']:not(:last-child):after {
            background: #afd9ee;
            width: 3px;
            content: "";
            display:block;
            position: absolute;
            top:0;
            bottom: 0;
            right: 0;
            height: 100%;
        }
    </style>

</head>

<body>

<div class="container">
    <div class="row vdivide">
        <div class="col-sm-6" style=" height: 100%">
            <div class="container">
                <input id="adminSearch" placeholder="Search" onkeyup="searchTable()">
            </div>
            <div class="container" style="padding-top: 400px">
                <button class="btn btn-primary btn-lg" style="font-size: 44px">Add Admin</button>
            </div>
        </div>

        <hr>
        <div id="right_div" class="col-sm-6" style=" height: 100%">
            <h2 style="padding-bottom: 20px">Admin Table</h2>
            <table id="adminTable" class="table table-bordered" style="width: 100%; table-layout: auto">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Contact No</th>
                    <th>Action</th>
                </tr>
                </thead>

      </div>

    </div>
</div>

</body>

</html>
