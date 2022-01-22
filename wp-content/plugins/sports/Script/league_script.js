var $ = jQuery;
$(document).ready(function () {

  
  $("#leagueModal").on("hidden.bs.modal", function (event) {
    $("#leagueformdata")[0].reset();
    $("#hlid").val("");
  });
  $("#hlid").val("");
  $('.date-time-picker').datetimepicker();
  $(".xdsoft_datetimepicker").css("z-index", "9999999999999999999");

  loadleaguetable();
  $("#leagueformdata").validate({
    rules: {
      sports: "required",
      name: "required",
      round: "required",
      status: "required",
    },
    messages: {
      sports: "Select Sport First",
      name: "Name is Required",
      round: "Select Yes or No",
      status: "Status is Required",
    },
    submitHandler: function () {
      $.ajax({
        url: ajaxurl,
        type: "POST",
        data: $("#leagueformdata").serialize(),

        success: function (responce) {
          var data = JSON.parse(responce);
          if (data.status == 1) {
            Swal.fire({
              icon: "success",
              title: data.msg,
              showConfirmButton: false,
              timer: 1500,
            });
            $("#sports").val("");
            $("#name").val("");
            $("#round").val("");
            $("#status").val("");
            $("#hlid").val("");
            loadleaguetable();
            $("#leagueModal").modal("hide");
          }
        },
      });
    },
  });
});

function loadleaguetable() {
  $("#leaguedata-table").dataTable({
    paging: true,
    pageLength: 10,
    bProcessing: true,
    serverSide: true,
    bDestroy: true,
    ajax: {
      url: ajaxurl,
      type: "POST",
      data: {
        action: "league_controller::loadleague_Datatable",
      },
    },
    aoColumns: [
      // { mData: "id" },
      { mData: "sports" },
      { mData: "name" },
      { mData: "round" },
      { mData: "status" },
      { mData: "action" },
    ],
    order: [[0, "asc"]],
    columnDefs: [
      {
        targets: [4],
        orderable: false,
      },
    ],
  });
}

function leaguerecord_delete(id) {
  Swal.fire({
    title: "Are you sure?",
    text: "You are sure to delete this record !",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, delete it!",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: ajaxurl,
        type: "POST",
        data: {
          id: id,
          action: "league_controller::deleteleague_record",
        },
        success: function (responce) {
          var data = JSON.parse(responce);
          if (data.status == 1) {
            Swal.fire("Deleted!", "Your record has been deleted.", "success");
            loadleaguetable();
          }
        },
      });
    }
  });
}

function leaguerecord_edit(id) {
  $.ajax({
    url: ajaxurl,
    type: "POST",
    data: {
      id: id,
      action: "league_controller::editleague_record",
    },
    success: function (responce) {
      var data = JSON.parse(responce);
      $("#submit").html("Update");
      $("#submit").css("background", "blue");
      // console.log(data);
      if (data.status == 1) {
        var result = data.recoed;
        $("#leagueModal").modal("show");
        $("#hlid").val(result.id);
        $("#sports").val(result.sports);
        $("#name").val(result.name);
        $("#round" + result.round)[0].checked = true;
        $("#status").val(result.status);
        loadleaguetable();
      }
    },
  });
}


/*************************** 
end of Get League
start of League List
 **************************/


function get_all_league_list() {

  $.ajax({
      type: "POST",
      url: ajaxurl,
      data:{
          'action' : "Aleague_list_controller::get_league_list"
      },
      success: function (responce) {
          var data = JSON.parse(responce);
          if (data.status == 1) {
              $("#league_list_div").append(data.event_string);
          }   
      }
  });
}


/*************************** 
end of Get League List
start of round
 **************************/

function leagueround(id) {
  $("#hdnleagueid").val(id);
  $("#roundModal").modal("show");
  $("#roundformdata")[0].reset();
  $("#hrid").val("");
  loadroundtable();
}

$("#save_Btnround").click(function () {
  console.log($("#roundformdata").serialize());

  $("#roundformdata").validate({
    rules: {
      rname: "required",
      scoremultiplier: "required",
      scoretype: "required",
      rstatus: "required",
    },
    messages: {
      rname: "Name is Required",
      scoremultiplier: "Score Multiplier is Required",
      scoretype: "Score Type is Required",
      rstatus: "Status is Required",
    },
    submitHandler: function () {
      $.ajax({
        url: ajaxurl,
        type: "POST",
        data: $("#roundformdata").serialize(),

        success: function (responce) {
          var data = JSON.parse(responce);
          if (data.status == 1) {
            Swal.fire({
              icon: "success",
              title: data.msg,
              showConfirmButton: false,
              timer: 1500,
            });
            $("#rname").val("");
            $("#scoremultiplier").val("");
            $("#hrid").val("");
            $("#scoretype").val("");
            $("#rstatus").val("");
            loadroundtable();
            $("#roundformdata")[0].reset();
            // $("#roundModal").modal("hide");
          }
        },
      });
    },
  });
});

function loadroundtable() {
  var hdnleagueid = $("#hdnleagueid").val();
  $("#rounddata-table").dataTable({
    paging: true,
    pageLength: 10,
    bProcessing: true,
    serverSide: true,
    bDestroy: true,
    ajax: {
      url: ajaxurl,
      type: "POST",
      data: {
        action: "league_controller::loadround_Datatable",
        hdnleagueid: hdnleagueid
      },
    },
    aoColumns: [
      // { mData: "id" },
      { mData: "rname" },
      { mData: "scoremultiplier" },
      { mData: "scoretype" },
      { mData: "rstatus" },
      { mData: "action" },
    ],
    order: [[0, "asc"]],
    columnDefs: [
      {
        targets: [4],
        orderable: false,
      },
    ],
  });
}

function deleteround_record(id) {
  Swal.fire({
    title: "Are you sure?",
    text: "You are sure to delete this record !",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, delete it!",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: ajaxurl,
        type: "POST",
        data: {
          id: id,
          action: "league_controller::deleteround_record",
        },
        success: function (responce) {
          var data = JSON.parse(responce);
          if (data.status == 1) {
            Swal.fire("Deleted!", "Your record has been deleted.", "success");
            loadroundtable();
          }
        },
      });
    }
  });
}

function editround_record(id) {
  $.ajax({
    url: ajaxurl,
    type: "POST",
    data: {
      id: id,
      action: "league_controller::editround_record",
    },
    success: function (responce) {
      var data = JSON.parse(responce);
      $("#submit").html("Update");

      if (data.status == 1) {
        var result = data.recoed;
        console.log(result.id);
        $("#hrid").val(result.id);
        $("#rname").val(result.rname);
        $("#scoremultiplier").val(result.scoremultiplier);
        $("#scoretype").val(result.scoretype);
        $("#rstatus").val(result.rstatus);
        loadroundtable();
      }
    },
  });
}


/*************************** 
end of round
start of match
 **************************/

function leaguematch(id,roundEmpty) {
$("#hmhdnleagueid").val(id);
$("#hmid").val("");

if(roundEmpty == 0){
  $("#roundNameDivId").hide();
}else{
  $("#roundNameDivId").show();
}

$("#matchmodal").modal("show");

$("#matchformdata")[0].reset();
// $('.date-time-picker').datetimepicker();
loadmatchtable();
} 

$("#save_Btnmatch").click(function () {
    console.log($("#matchformdata").serialize());
  
    $("#matchformdata").validate({
      rules: {
        round: "required",
        team1: "required",
        team2: "required",
        enddate: "required",
        mstatus: "required",
      },
      messages: {
        round: "Round Name is Required",
        team1: "Team 1 is Required",
        team2: "Team 2 is Required",
        enddate: "Date is Required",
        mstatus: "Status is Required",
      },
      submitHandler: function () {
        $.ajax({
          url: ajaxurl,
          type: "POST",
          data: $("#matchformdata").serialize(),
  
          success: function (responce) {
            var data = JSON.parse(responce);
            if (data.status == 1) {
              Swal.fire({
                icon: "success",
                title: data.msg,
                showConfirmButton: false,
                timer: 1500,
              });
              $("#round").val("");
              $("#team1").val("");
              $("#team2").val("");
              $("#enddate").val("");
              $("#mstatus").val("");
              $("#hmid").val("");    
              loadmatchtable();
              $("#matchformdata")[0].reset();
              // $("#matchModal").modal("hide");
            }
          },
        });
      },
    });
  });
  
  function loadmatchtable() {
    var hmhdnleagueid = $("#hmhdnleagueid").val();
    $("#matchdata-table").dataTable({
      paging: true,
      pageLength: 10,
      bProcessing: true,
      serverSide: true,
      bDestroy: true,
      ajax: {
        url: ajaxurl,
        type: "POST",
        data: {
          action: "league_controller::loadmatch_Datatable",
          hmhdnleagueid: hmhdnleagueid
        }
      },
      // initComplete: function(settings,msg) {
      //   console.log(msg);
      //     var roundString = '<option value="">----Round----</option>';
      //     if(msg.round.length > 0) {
      //         for(var n=0; n<msg.round.length; n++) {
      //             roundString+='<option value="'+msg.round[n].id+'">'+msg.round[n].rname+'</option>';
      //         }
      //     }
      //     $("#round").html(roundString);
      // },
      aoColumns: [
        // { mData: "id" },
        { mData: "round" },
        { mData: "team1" },
        { mData: "team2" },
        { mData: "enddate" },
        { mData: "mstatus"},
        { mData: "action" },
      ],
      order: [[0, "asc"]],
      columnDefs: [
        {
          targets: [4],
          orderable: false,
        },
      ],
    });
  }



  function deletematch_record(id) {
    Swal.fire({
      title: "Are you sure?",
      text: "You are sure to delete this record !",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, delete it!",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: ajaxurl,
          type: "POST",
          data: {
            id: id,
            action: "league_controller::deletematch_record",
          },
          success: function (responce) {
            var data = JSON.parse(responce);
            if (data.status == 1) {
              Swal.fire("Deleted!", "Your record has been deleted.", "success");
              loadmatchtable();
            }
          },
        });
      }
    });
  }

  
  function editmatch_record(id) {
    $.ajax({
      url: ajaxurl,
      type: "POST",
      data: {
        id: id,
        action: "league_controller::editmatch_record",
      },
      success: function (responce) {
        var data = JSON.parse(responce);
        $("#submit").html("Update");
        $("#submit").css("backgmatch", "blue");
        if (data.status == 1) {
          var result = data.recoed;
          console.log(result);
          $("#hmid").val(result.id);
          $('#round').val(result.round);
          console.log(result.roundname)
          $("#team1").val(result.team1);
          $("#team2").val(result.team2);
          $("#enddate").val(result.enddate);
          $("#status").val(result.status);
          loadmatchtable();
        }
      },
    });
  }
  


/*************************** 
end of match
start of score
 **************************/

  
  $("#save_Btnmatchscore").click(function () {
      console.log($("#matchscoreformdata").serialize());
    
      $("#matchscoreformdata").validate({
        rules: {
          team1score: "required",
          team2score: "required",
        },
        messages: {
          team1score: "Team 1 Score is Required",
          team2score: "Team 2 Score is Required",
        },
        submitHandler: function () {
          $.ajax({
            url: ajaxurl,
            type: "POST",
            data: $("#matchscoreformdata").serialize(),
    
            success: function (responce) {
              var data = JSON.parse(responce);
              if (data.status == 1) {
                Swal.fire({
                  icon: "success",
                  title: data.msg,
                  showConfirmButton: false,
                  timer: 1500,
                });
              }
            },
          });
        },
      });
    });
    
    function loadmatchscoretable(matchid) {
      $("#hdnmatchid").val(matchid);
      $.ajax({
        url: ajaxurl,
        type: "POST",
        data: {
          matchid: matchid,
          action: "league_controller::loadmatchscore_Datatable",
        },
        success: function (responce) {
          var data = JSON.parse(responce);
          if (data.status == 1) {
            var result = data.recoed;
            $("#matchscoremodal").modal("show");      
            $("#matchscoreformdata")[0].reset();
            $("#matchmodal").modal("hide");  
            $("#hmsid").val(result.id);
            $("#team1score").val(result.team1score);
            $("#team2score").val(result.team2score);
            $("#teamname1").html(result.teamname1);
            $("#teamname2").html(result.teamname2);
          }
        },
      });
    }
  
  
  
    function deletematchscore_record(id) {
      Swal.fire({
        title: "Are you sure?",
        text: "You are sure to delete this record !",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: ajaxurl,
            type: "POST",
            data: {
              id: id,
              action: "league_controller::deletematchscore_record",
            },
            success: function (responce) {
              var data = JSON.parse(responce);
              if (data.status == 1) {
                Swal.fire("Deleted!", "Your record has been deleted.", "success");
                loadmatchscoretable();
              }
            },
          });
        }
      });
    }


/*************************** 
end of score
start of leaderboard
 **************************/

function leagueleaderboard(id) {
  $("#lbhdnleagueid").val(id);
  $("#leaderboardModal").modal("show");
  loadleaderboardtable();
}

function loadleaderboardtable(){
  console.log("hello");
  var lbhdnleagueid = $("#lbhdnleagueid").val();
  $("#leaderboarddata-table").dataTable({
    paging: true,
    pageLength: 10,
    bProcessing: true,
    serverSide: true,
    bDestroy: true,
    ajax: {
      url: ajaxurl,
      type: "POST",
      data: {
        action: "league_controller::loadleaderboard_Datatable",
        lbhdnleagueid: lbhdnleagueid
      },
    },
    aoColumns: [
      // { mData: "id" },
      { mData: "id" },
      { mData: "score" },
    ],
    order: [[0, "asc"]],
    columnDefs: [
      {
        targets: [1],
        orderable: false,
      },
    ],
  });
}
/*************************** 
end of leaderboard
 **************************/


 