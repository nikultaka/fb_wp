
var $ = jQuery;
$(document).ready(function () {
    $('#registerteamModal').on('hidden.bs.modal', function(event) {
        $('#teamformdata')[0].reset();
        $('#tid').val('');
     });
     $('#tid').val('');
     
    loadteamdatatable();
        $("form").validate({
            rules: {
                sportid : "required",
                teamname : "required",
                tstatus : "required",
            },
            messages: {
                sportid : "Sports Name is required",
                teamname : "Team Name is Required",
                tstatus : "Status is Required",
            },
            submitHandler: function() {
                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: $('#teamformdata').serialize(),

                    success: function (responce) {
                        var data = JSON.parse(responce);
                        if (data.status == 1) {
                                Swal.fire({
                                    icon: 'success',
                                    title: data.msg,
                                    showConfirmButton: false,
                                    timer: 1500
                                })
                            $('#sportid').val('');
                            $('#teamname').val('');
                            $('#tstatus').val('');
                            $('#tid').val('');
                            loadteamdatatable();
                            $('#registerteamModal').modal('hide');

                        }
                    }
                });
            }
        });
    });

    function loadteamdatatable(){
        $('#teamdata-table').dataTable({
            "paging": true,
            "pageLength": 10,
            "bProcessing": true,
            "serverSide": true,
            "bDestroy": true,
            "ajax": {
                url: ajaxurl,
                type: "POST",
                data : {
                    action : "team_controller::loaddata_team_Datatable"
                },
            },
            "aoColumns": [
                // { mData: 'id' },
                { mData: 'sportid' },
                { mData: 'teamname' },
                { mData: 'tstatus' },
                { mData: 'action' },
            ],
            "order": [[0, "asc"]],
            "columnDefs": [{
                "targets": [3],
                "orderable": false
            }]
        });
    }

    function teamrecord_delete(id){
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
                                action : "team_controller::delete_team_record"
                            },
                            success: function (responce) {
                                var data = JSON.parse(responce);
                                if (data.status == 1) {
                                        Swal.fire(
                                            'Deleted!',
                                            'Team has been deleted.',
                                            'success'
                                        )
                                    loadteamdatatable();
                                }
                            }
                        });
                 }
            })
    }

    function teamrecord_edit(id){
        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data:{
                id : id ,
                action : "team_controller::edit_team_record"
            },
            success: function (responce) {
                var data = JSON.parse(responce);
                $('#submit').html('Update');
                $('#submit').css('background','blue');
                // console.log(data);
                if (data.status == 1) {
                    var result = data.recoed;
                    $('#registerteamModal').modal('show');
                    $('#tid').val(result.id);
                    $('#sportid').val(result.sportid);
                    $('#teamname').val(result.teamname);
                    $('#tstatus').val(result.tstatus);
                    loadteamdatatable();
                }
            }
        });
    }
    