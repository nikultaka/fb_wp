var $ = jQuery;
$(document).ready(function () {
  $("#leagueModal").on("hidden.bs.modal", function (event) {
    $("#leagueformdata")[0].reset();
    $("#hlid").val("");
  });
  $("#hlid").val("");
  $(".date-time-picker").datetimepicker();
  $(".xdsoft_datetimepicker").css("z-index", "9999999999999999999");

  loadleaguetable();
  $("#leagueformdata").validate({
    rules: {
      sports: "required",
      name: "required",
      status: "required",
    },
    messages: {
      sports: "Select Sport First",
      name: "Name is Required",
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
      { mData: "status" },
      { mData: "action" },
    ],
    order: [[0, "asc"]],
    columnDefs: [
      {
        targets: [3],
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
        $("#status").val(result.status);
        loadleaguetable();
      }
    },
  });
}

/*************************** 
end of league
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
            $("#iscomplete").prop("checked", false);
            loadroundtable();
            $("#roundformdata")[0].reset();

            localStorage.removeItem("matchData");
            localStorage.setItem("matchData", JSON.stringify(data.matchData));

            localStorage.removeItem("joinData");
            localStorage.setItem("joinData", JSON.stringify(data.joinData));

            localStorage.removeItem("userData");
            localStorage.setItem("userData", JSON.stringify(data.userData));
          }
        },
      });
    },
  });

  if ($("#iscomplete").is(":checked")) {
    auto_join_team();
  }
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
        hdnleagueid: hdnleagueid,
      },
    },
    aoColumns: [
      // { mData: "id" },
      { mData: "rname" },
      { mData: "scoremultiplier" },
      { mData: "scoretype" },
      { mData: "rstatus" },
      { mData: "iscomplete" },
      { mData: "action" },
    ],
    order: [[0, "asc"]],
    columnDefs: [
      {
        targets: [5],
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
  $("#iscomplete").attr("checked", false); // Unchecks it

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
        $("#hrid").val(result.id);
        $("#rname").val(result.rname);
        $("#scoremultiplier").val(result.scoremultiplier);
        $("#scoretype").val(result.scoretype);
        $("#rstatus").val(result.rstatus);
        if (result.iscomplete == "YES") {
          $("#iscomplete").prop("checked", true);
        } else {
          $("#iscomplete").prop("checked", false);
        }
        loadroundtable();
      }
    },
  });
}

/*************************** 
end of round
start of match
 **************************/

function leaguematch(id) {
  $("#hmhdnleagueid").val(id);

  $("#hmid").val("");

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
      enddate: "Cut Off Time is Required",
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
        hmhdnleagueid: hmhdnleagueid,
      },
    },
    initComplete: function (settings, msg) {
      console.log(msg);
      var roundString = '<option value="">----Round----</option>';
      if (msg.round.length > 0) {
        for (var n = 0; n < msg.round.length; n++) {
          roundString +=
            '<option value="' +
            msg.round[n].id +
            '">' +
            msg.round[n].rname +
            "</option>";
        }
      }
      $("#round").html(roundString);
    },
    aoColumns: [
      // { mData: "id" },
      { mData: "round" },
      { mData: "team1" },
      { mData: "team2" },
      { mData: "enddate" },
      { mData: "mstatus" },
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
        $("#round").val(result.round);
        $("#team1").val(result.team1);
        $("#team2").val(result.team2);
        $("#enddate").val(result.enddate);
        $("#status").val(result.status);
        //loadmatchtable();
      }
    },
  });
}

/*************************** 
end of match
start of score
 **************************/
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
      console.log(responce);
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

$("#save_Btnmatchscore").click(function () {
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
            $("#matchscoremodal").modal("hide");
          }
        },
      });
    },
  });
});

// function deletematchscore_record(id) {
//   Swal.fire({
//     title: "Are you sure?",
//     text: "You are sure to delete this record !",
//     icon: "warning",
//     showCancelButton: true,
//     confirmButtonColor: "#3085d6",
//     cancelButtonColor: "#d33",
//     confirmButtonText: "Yes, delete it!",
//   }).then((result) => {
//     if (result.isConfirmed) {
//       $.ajax({
//         url: ajaxurl,
//         type: "POST",
//         data: {
//           id: id,
//           action: "league_controller::deletematchscore_record",
//         },
//         success: function (responce) {
//           var data = JSON.parse(responce);
//           if (data.status == 1) {
//             Swal.fire("Deleted!", "Your record has been deleted.", "success");
//             loadmatchscoretable();
//           }
//         },
//       });
//     }
//   });
// }

/*************************** 
end of score
start of leaderboard
 **************************/

function leagueleaderboard(id) {
  $("#lbhdnleagueid").val(id);
  $("#leaderboardModal").modal("show");
  loadleaderboardtable();
}

function loadleaderboardtable() {
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
        lbhdnleagueid: lbhdnleagueid,
      },
    },
    aoColumns: [
      { mData: "leaguename" },
      { mData: "username" },
      { mData: "score" },
    ],
    order: [[0, "asc"]],
  });
}
/*************************** 
end of leaderboard
start of Additional Points
 **************************/

function loadadditionalpoints(id) {
  // $("#additionalpointsmodal").modal("show");
  $("#hdnapid").val(id);

  $.ajax({
    url: ajaxurl,
    type: "POST",
    data: {
      id: id,
      action: "league_controller::loadadditionalpoints_Datatable",
    },
    success: function (responce) {
      var data = JSON.parse(responce);
      if (data.status == 1) {
        var result = data.recoed;
        $("#additionalpointsmodal").modal("show");
        $("#apformdata")[0].reset();
        $("#hapid").val(result.id);
        $("#jokerscoremultiplier").val(result.jokerscoremultiplier);
        $("#jokerscoretype").val(result.jokerscoretype);
        $("#predictorscoremultiplier").val(result.predictorscoremultiplier);
        $("#predictorscoretype").val(result.predictorscoretype);
      }
    },
  });
}

$("#save_Btnap").click(function () {
  $("#apformdata").validate({
    submitHandler: function () {
      $.ajax({
        url: ajaxurl,
        type: "POST",
        data: $("#apformdata").serialize(),

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

/*************************** 
end of Additional Points
 **************************/

/*************************** 
start of sport List
 **************************/

function get_all_sport_list() {
  $.ajax({
    type: "POST",
    url: ajaxurl,
    datatype: "json",
    data: {
      action: "sport_list_Controller::get_sport_list",
    },
    success: function (responce) {
      var data = JSON.parse(responce);
      if (data.status == 1) {
        $("#sportlistdata").append(data.sport_string);
      }
    },
  });
}

/*************************** 
end of sport List
start of League List
 **************************/

function league_list(id) {
  $.ajax({
    type: "POST",
    url: ajaxurl,
    datatype: "json",
    data: {
      id: id,
      action: "league_list_Controller::get_league_list",
    },
    success: function (responce) {
      var data = JSON.parse(responce);
      if (data.status == 1) {
        $("#leaguelistdata").append(data.league_string);
      }
    },
  });
}

/*************************** 
end of sport List
start of Round List
 **************************/

function round_list(id) {
  $.ajax({
    type: "POST",
    url: ajaxurl,
    datatype: "json",
    data: {
      id: id,
      action: "round_list_Controller::get_round_list",
    },
    success: function (responce) {
      var data = JSON.parse(responce);
      if (data.status == 1) {
        $("#roundlistdata").append(data.round_string);
      }
    },
  });
}

/*************************** 
end of Get Round List
start of Match List
 **************************/
function match_list(id) {
  $.ajax({
    type: "POST",
    url: ajaxurl,
    datatype: "json",
    data: {
      id: id,
      action: "match_list_Controller::get_match_list",
    },
    success: function (responce) {
      var data = JSON.parse(responce);
      if (data.status == 1) {
        localStorage.removeItem("allTeamData");
        localStorage.setItem("allTeamData", JSON.stringify(data.teamData));

        localStorage.removeItem("roundSelectData");
        localStorage.setItem("roundSelectData",JSON.stringify(data.roundSelectData));

        localStorage.removeItem("validateData");
        localStorage.setItem("validateData", JSON.stringify(data.validateData));

        $("#matchlistdata").append(data.match_string);
      }
    },
  });
}

/*************************** 
end of Match List
start of Score Predict
 **************************/

function load_score_predicter_model(matchid, teamid) {
  var matchDate = $("#match-" + matchid).attr("data-date");
  var dt = new Date();
  var currenttime =
    dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds();
  var currentDate = $.datepicker.formatDate("yy-mm-dd", new Date());
  var current = currentDate + " " + currenttime;
  if (matchDate > current) {
    $("#hdnsprmatchid").val(matchid);
    $("#hdnsprteamid").val(teamid);
    $.ajax({
      url: ajaxurl,
      type: "POST",
      data: {
        matchid: matchid,
        teamid: teamid,
        action: "match_list_Controller::score_predictor_load_data",
      },
      success: function (responce) {
        console.log(responce);

        var data = JSON.parse(responce);
        if (data.status == 1) {
          var result = data.recoed;

          $("#scorepredictormodal").modal("show");
          $("#scorepredictorformdata")[0].reset();
          $("#hspfid").val(result.id);
          console.log(result.id);
          $("#scorepredictor").val(result.scorepredictor);
        }
      },
    });
  } else {
    Swal.fire({
      title: "You Can Not Predict Score For This Team",
      text: "Date Is Over To Predict Score For This Team",
      icon: "error",
      showCancelButton: false,
      confirmButtonColor: "#d33",
      cancelButtonColor: "#d33",
      confirmButtonText: "Ok",
    });
  }
}

$("#save_Btnscorepredictor").click(function () {
  $("#scorepredictorformdata").validate({
    rules: {
      scorepredictor: "required",
    },
    messages: {
      scorepredictor: "Enter Score !",
    },
    submitHandler: function () {
      $.ajax({
        url: ajaxurl,
        type: "POST",
        data: $("#scorepredictorformdata").serialize(),
        success: function (responce) {
          var data = JSON.parse(responce);
          if (data.status == 1) {
            Swal.fire({
              icon: "success",
              title: data.msg,
              showConfirmButton: false,
              timer: 1500,
            });
            $("#scorepredictormodal").modal("hide");
          }
        },
      });
    },
  });
});

/*************************** 
end of  Score Predict
start of Join Team
 **************************/

function join_team(tid, id, leagueid, roundid) {
  var roundSelectDataArray = JSON.parse(
    localStorage.getItem("roundSelectData")
  );
  var leagueidstr = leagueid.toString();
  var roundidstr = roundid.toString();

  var sprSelectData = [];
  var uniqcheck = roundSelectDataArray.filter((round) => {
    return round.roundselect === "scorePredictorround";
  });
  uniqcheck.forEach((round) => {
    var sprround = round.roundid;
    sprSelectData.push(sprround);
  });

  var jrSelectData = [];
  var uniqcheck = roundSelectDataArray.filter((round) => {
    return round.roundselect === "jokeround";
  });
  uniqcheck.forEach((round) => {
    var jrround = round.leagueid;
    jrSelectData.push(jrround);
  });

  var roundSelectData = [];
  roundSelectDataArray.forEach((round) => {
    var roundselect = round.roundselect.trim().toLowerCase();
    roundSelectData.push(roundselect);
  });

  // console.log(jrSelectData);
  // console.log(leagueidstr);
  // console.log(sprSelectData);
  // console.log(roundSelectData);

  var validateDataArray = JSON.parse(localStorage.getItem("validateData"));
  var uniqidselect = [];
  validateDataArray.forEach((uniq) => {
    var idselect = uniq.id;
    uniqidselect.push(idselect);
  });
  // console.log(uniqidselect);
  // console.log(roundidstr);

  var allTeamDataArray = JSON.parse(localStorage.getItem("allTeamData"));
  var allteamname = [];
  var leagueidteam = allTeamDataArray.filter((team) => {
    return team.leagueid === leagueidstr;
  });
  leagueidteam.forEach((team) => {
    var allteamnamelg = team.teamname.trim().toLowerCase();
    allteamname.push(allteamnamelg);
  });

  var teamname = "";
  if (tid == 1) {
    teamname = $(".team_" + tid + "_" + id).attr("data-teamname1");
  } else if (tid == 0) {
    teamname = $(".team_" + tid + "_" + id).attr("data-teamname2");
  }
  var teamnamestr = teamname.toString();
  if (allteamname.includes(teamnamestr.trim().toLowerCase())) {
    Swal.fire({
      title: "You Can Not Select This Team",
      text: "You Already Selected This Team In Another Round",
      icon: "error",
      showCancelButton: false,
      confirmButtonColor: "#d33",
      cancelButtonColor: "#d33",
      confirmButtonText: "Ok",
    });
  } else {
    var matchDate = $("#match-" + id).attr("data-date");

    var dt = new Date();
    var currenttime =
      dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds();
    var currentDate = $.datepicker.formatDate("yy-mm-dd", new Date());
    var current = currentDate + " " + currenttime;

    if (matchDate > current) {
      // $(".team_" + tid + "_" + id).html("PREVIOUSLY SELECTED");
      Swal.fire({
        title: "<h3>Are You Sure Want To Select This Team !</h3>",
        text: "If you already selected team, Then this team will override it",
        icon: "info",
        showCancelButton: true,
        width: "450px",
        confirmButtonColor: "#24890d",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, select it!",
      }).then((result) => {
        if (result.isConfirmed) {
          if (uniqidselect.includes(roundidstr)) {
            if (
              roundSelectData.includes("jokeround".trim().toLowerCase()) &&
              jrSelectData.includes(leagueidstr)
            ) {
              if (
                roundSelectData.includes(
                  "scorePredictorround".trim().toLowerCase()
                ) &&
                sprSelectData.includes(roundidstr)
              ) {
                $roundselect = "nothanks";
                $.ajax({
                  type: "POST",
                  url: ajaxurl,
                  datatype: "json",
                  data: {
                    tid: tid,
                    id: id,
                    roundselect: "nothanks",
                    action: "match_list_Controller::add_team_join",
                  },
                  success: function (responce) {
                    var data = JSON.parse(responce);
                    if (data.status == 1) {
                      Swal.fire("You Selected Team Successfully.");
                      $("#joinbutton").append("You selected This Match");
                      $(".match-" + id).html("SELECT");
                      $(".team_" + tid + "_" + id).html("SELECTED");
                      location.reload();
                      if (allteamname.includes(teamnamestr.trim().toLowerCase())) { $(".team_" + tid + "_" + id).html("PREVIOUSLY SELECTED");}
                    }
                  },
                });
                return false;
              } else {
                var inputOptions = new Promise((resolve) => {
                  resolve({
                    scorePredictorround:
                      '<h5><strong style="color:#2e2d2d">Score Predictor Round</strong></h5>',
                  });
                });
              }
            } else if (
              roundSelectData.includes(
                "scorePredictorround".trim().toLowerCase()
              ) &&
              sprSelectData.includes(roundidstr)
            ) {
              var inputOptions = new Promise((resolve) => {
                resolve({
                  jokeround:
                    '<h5><strong  style="color:#2e2d2d">Joker Round</strong></h5>',
                });
              });
            } else {
              var inputOptions = new Promise((resolve) => {
                resolve({
                  jokeround:
                    '<h5><strong  style="color:#2e2d2d">Joker Round</strong></h5>',
                  scorePredictorround:
                    '<h5><strong style="color:#2e2d2d">Score Predictor Round</strong></h5>',
                });
              });
            }

            const { value: round } = Swal.fire({
              title: '<h2 style="color:#0a4a03">Want To Select Round ?<h2>',
              input: "radio",
              icon: "question",
              width: "450px",
              confirmButtonColor: "#0a4a03",
              iconColor: "#54595F",
              confirmButtonText: "select it!",
              allowOutsideClick: false,
              allowEscapeKey: false,
              inputOptions: inputOptions,
              inputValidator: (value) => {
                if (!value) {
                  return "You need to choose something!";
                }
              },
            }).then((round) => {
              $roundselect = round.value;
              $.ajax({
                type: "POST",
                url: ajaxurl,
                datatype: "json",
                data: {
                  tid: tid,
                  id: id,
                  roundselect: round.value,
                  action: "match_list_Controller::add_team_join",
                },
                success: function (responce) {
                  var data = JSON.parse(responce);
                  if (data.status == 1) {
                    Swal.fire("You Selected Team Successfully.");
                    $("#joinbutton").append("You selected This Match");
                    $(".match-" + id).html("SELECT");
                    $(".team_" + tid + "_" + id).html("SELECTED");
                    location.reload();
                    if (allteamname.includes(teamnamestr.trim().toLowerCase())) { $(".team_" + tid + "_" + id).html("PREVIOUSLY SELECTED");}


                  }
                },
              });
            });
          } else {
            $roundselect = "nothanks";
            $.ajax({
              type: "POST",
              url: ajaxurl,
              datatype: "json",
              data: {
                tid: tid,
                id: id,
                roundselect: "nothanks",
                action: "match_list_Controller::add_team_join",
              },
              success: function (responce) {
                var data = JSON.parse(responce);
                if (data.status == 1) {
                  Swal.fire("You Selected Team Successfully.");
                  $("#joinbutton").append("You selected This Match");
                  $(".match-" + id).html("SELECT");
                  $(".team_" + tid + "_" + id).html("SELECTED");
                  location.reload();
                  if (allteamname.includes(teamnamestr.trim().toLowerCase())) { $(".team_" + tid + "_" + id).html("PREVIOUSLY SELECTED");}

                }
              },
            });
          }
        }
      });
    } else {
      Swal.fire({
        title: "You Can Not select This Team !",
        text: "Date Is Over To select Or Change Team.",
        icon: "error",
        showCancelButton: false,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ok",
      });
    }
  }
  return false;
}

/*************************** 
end of Join Team
start of auto join team
 **************************/

function auto_join_team() {

 /** user **/
 var userDataArray = JSON.parse(localStorage.getItem("userData"));
 var matchDataArray = JSON.parse(localStorage.getItem("matchData"));

 var roundselectid = [];
 matchDataArray.forEach((team) => {
   var roundselectm = team.round.trim().toLowerCase();
   roundselectid.push(roundselectm);
 });

 console.log(roundselectid)
 var userdata = [];
 userDataArray.forEach((user) => {
   var userselect = user.id.trim().toLowerCase();
   userdata.push(userselect);
 });

 var joinDataArray = JSON.parse(localStorage.getItem("joinData"));
 var joinrounduser = [];
 var joinround = joinDataArray.filter((team) => {
  return team.roundid === roundselectid[0] ;
});
joinround.forEach((round) => {
   var rounduserselect = round.userid.trim().toLowerCase();
   joinrounduser.push(rounduserselect);
 });
 console.log(joinrounduser)
 var uid = $(userdata).not(joinrounduser).get();
  /** /user **/

  /** round **/

  var matchrounds = [];
  matchDataArray.forEach((team) => {
    var roundselectm = team.round.trim().toLowerCase();
    matchrounds.push(roundselectm);
  });
  var Newmatchrounds = matchrounds.filter(function (elem, index, self) {
    return index === self.indexOf(elem);
  });

  var joinrounds = [];
  joinDataArray.forEach((round) => {
    var roundselect = round.roundid.trim().toLowerCase();
    joinrounds.push(roundselect);
  });

  var difference = $(Newmatchrounds).not(joinrounds).get();
  /** /round **/

  /** teamname **/
  uid.forEach((user) => {
  difference.forEach((round) => {

    var matchteamname = [];
    var matchidjoin = matchDataArray.filter((team) => {
      return team.round === round;
    });
    matchidjoin.forEach((team) => {
      var allmatchjoin1 = team.team1.trim().toLowerCase();
      matchteamname.push(allmatchjoin1);
    });
    var matchteamname2 = [];
    var matchidjoin = matchDataArray.filter((team) => {
      return team.round === round;
    });
    matchidjoin.forEach((team) => {
      var allmatchjoin2 = team.team2.trim().toLowerCase();
      matchteamname2.push(allmatchjoin2);
    });
    var allteamname = matchteamname.concat(matchteamname2);

    var jointeamname = [];
    joinDataArray.forEach((round) => {
      var teamselect = round.teamname.trim().toLowerCase();
      jointeamname.push(teamselect);
    });

    var differenceteam = $(allteamname).not(jointeamname).get();
    var teamname = differenceteam[0];
    /**************/ console.log(teamname);
    /** /teamname **/

    /** match id **/
    var matchjoin = [];
    var matchidjoin = matchDataArray.filter((team) => {
      return team.team1.trim().toLowerCase() === teamname;
    });
    matchidjoin.forEach((team) => {
      var allmatchjoin = team.id.trim().toLowerCase();
      matchjoin.push(allmatchjoin);
    });
    /**************/ console.log(matchjoin);
    /** /match id **/

      $roundselect = "nothanks";
      $id = matchjoin[0];
      $tid = "1";
      $uid = user;
      console.log($uid)
      $.ajax({
        type: "POST",
        url: ajaxurl,
        datatype: "json",
        data: {
          tid: "1",
          id: matchjoin[0],
          uid: user,
          roundselect: "nothanks",
          action: "match_list_Controller::add_team_join",
        },
        success: function (responce) {
          var data = JSON.parse(responce);
          if (data.status == 1) {          
          }
        },
      });
      return false;

  });
});
}

/*************************** 
end of auto join team
start of My Score
 **************************/

function my_score_list() {
  $("#myscoredata-table").dataTable({
    paging: true,
    pageLength: 10,
    bProcessing: true,
    serverSide: true,
    bDestroy: true,
    ajax: {
      type: "POST",
      url: ajaxurl,
      datatype: "json",
      data: {
        action: "my_score_Controller::get_my_score",
      },
    },
    initComplete: function (settings, json) {
      $("#totalScore").text(json.score);
    },
    aoColumns: [
      // { mData: "id" },
      { mData: "sport" },
      { mData: "league" },
      { mData: "round" },
      { mData: "team" },
      { mData: "yourscore" },
      { mData: "action" },
    ],
    order: [[0, "asc"]],
    columnDefs: [
      {
        targets: [5],
        orderable: false,
      },
    ],
  });
}

/*************************** 
end of My Score
start of Leaderboard List
 **************************/

// function leader_board_list() {
//   $("#leaderboardlistdata-table").dataTable({
//     paging: true,
//     pageLength: 10,
//     bProcessing: true,
//     serverSide: true,
//     bDestroy: true,
//     ajax: {
//       type: "POST",
//       url: ajaxurl,
//       datatype: "json",
//       data: {
//         action: "leader_board_Controller::get_leader_board",
//       },
//     },
//     aoColumns: [
//       // { mData: "id" },
//       { mData: "league" },
//       { mData: "action" },
//     ],
//     order: [[0, "asc"]],
//     columnDefs: [
//       {
//         targets: [1],
//         orderable: false,
//       },
//     ],
//   });
// }

/*************************** 
end of Leaderboard List
start of Load Leaderboard List
 **************************/

function load_leader_board_list(id) {
  $("#loadleaderboardlistdata-table").dataTable({
    paging: true,
    pageLength: 10,
    bProcessing: true,
    serverSide: true,
    bDestroy: true,
    ajax: {
      type: "POST",
      url: ajaxurl,
      datatype: "json",
      data: {
        id,
        id,
        action: "leader_board_Controller::load_leader_board",
      },
    },
    aoColumns: [
      // { mData: "id" },
      { mData: "leaguename" },
      { mData: "username" },
      { mData: "userspoints" },
      { mData: "action" },
    ],
    order: [[0, "asc"]],
    columnDefs: [
      {
        targets: [3],
        orderable: false,
      },
    ],
  });
}

/*************************** 
end of Load Leaderboard List
start of Match Score Details
 **************************/

function load_match_score_details_list(id, uid) {
  $("#matchscoredetailsmodal").modal("show");

  $("#loadmatchscoredetails-table").dataTable({
    paging: true,
    pageLength: 10,
    bProcessing: true,
    serverSide: true,
    bDestroy: true,
    ajax: {
      type: "POST",
      url: ajaxurl,
      datatype: "json",
      data: {
        id: id,
        uid: uid,
        action: "leader_board_Controller::load_match_score_details",
      },
    },
    aoColumns: [
      // { mData: "id" },
      { mData: "teamname" },
      { mData: "teamscore" },
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
end of Load Match Score Details
start of Send Mail Users For Enddate
 **************************/

// function send_mail_users_for_enddate() {
//     $.ajax({
//       type: "POST",
//       url: ajaxurl,
//       datatype: "json",
//       data: {
//         action: "match_list_Controller::send_mail_users_enddate",
//       },
//       success: function (responce) {
//         var data = JSON.parse(responce);
//         if (data.status == 1) {
         
//         }
//       },
//     });
// }

/*************************** 
end of Send Mail Users For Enddate
 **************************/

