
var $ = jQuery;
$(document).ready(function () {
    $('#registerModal').on('hidden.bs.modal', function(event) {
        $('#formdata')[0].reset();
        $('#hid').val('');
     });
     $('#hid').val('');
     
    loaddatatable();
        $("form").validate({
            rules: {
                name : "required",
                status : "required",
            },
            messages: {
                name : "Name is Required",
                status : "Status is Required",
            },
            submitHandler: function() {
                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: $('#formdata').serialize(),

                    success: function (responce) {
                        var data = JSON.parse(responce);
                        if (data.status == 1) {
                                Swal.fire({
                                    icon: 'success',
                                    title: data.msg,
                                    showConfirmButton: false,
                                    timer: 1500
                                })
                            $('#name').val('');
                            $('#status').val('');
                            $('#hid').val('');
                            loaddatatable();
                            $('#registerModal').modal('hide');

                        }
                    }
                });
            }
        });
    });

    function loaddatatable(){
        $('#sportsdata-table').dataTable({
            "paging": true,
            "pageLength": 10,
            "bProcessing": true,
            "serverSide": true,
            "bDestroy": true,
            "ajax": {
                url: ajaxurl,
                type: "POST",
                data : {
                    action : "sports_controller::loaddata_Datatable"
                },
            },
            "aoColumns": [
                // { mData: 'id' },
                { mData: 'name' },
                { mData: 'status' },
                { mData: 'action' },
            ],
            "order": [[0, "asc"]],
            "columnDefs": [{
                "targets": [1],
                "orderable": false
            }]
        });
    }

    function record_delete(id){
            Swal.fire({
                title: 'Are you sure?',
                text: "You are sure to delete this record !",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                        $.ajax({
                            url: ajaxurl,
                            type: 'POST',
                            data:{
                                id : id ,
                                action : "sports_controller::delete_record"
                            },
                            success: function (responce) {
                                var data = JSON.parse(responce);
                                if (data.status == 1) {
                                        Swal.fire(
                                            'Deleted!',
                                            'Sports has been deleted.',
                                            'success'
                                        )
                                    loaddatatable();
                                }
                            }
                        });
                 }
            })
    }

    function record_edit(id){
        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data:{
                id : id ,
                action : "sports_controller::edit_record"
            },
            success: function (responce) {
                var data = JSON.parse(responce);
                $('#submit').html('Update');
                $('#submit').css('background','blue');
                // console.log(data);
                if (data.status == 1) {
                    var result = data.recoed;
                    $('#registerModal').modal('show');
                    $('#hid').val(result.id);
                    $('#name').val(result.name);
                    $('#status').val(result.status);
                    loaddatatable();
                }
            }
        });
    }
    