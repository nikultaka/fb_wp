var $ = jQuery;


function live_match_list() {
    $.ajax({
        type: "POST",
        url: ajaxurl,
        datatype: "json",
        data: {
          action: "live_match_list_Controller::live_match_list",
        },
        success: function (responce) {
          var data = JSON.parse(responce);
          if (data.status == 1) {
            $("#livematchlist").append(data.live_match_string);
          }
        },
      });
}

function upcoming_match_list() {
  $.ajax({
      type: "POST",
      url: ajaxurl,
      datatype: "json",
      data: {
        action: "live_match_list_Controller::upcoming_match_list",
      },
      success: function (responce) {
        var data = JSON.parse(responce);
        if (data.status == 1) {
          $("#upcomingmatchlist").append(data.upcoming_match_string);
        }
      },
    });
}

function live_leaderboard_list() {
  $.ajax({
      type: "POST",
      url: ajaxurl,
      datatype: "json",
      data: {
        action: "live_match_list_Controller::live_leaderboard_list",
      },
      success: function (responce) {
        var data = JSON.parse(responce);
        if (data.status == 1) {
          $("#liveleaderboardlist").append(data.live_leaderboard_string);
        }
      },
    });
}

function load_leaderboard_Pointtable(id) {

  $.ajax({
      type: "POST",
      url: ajaxurl,
      datatype: "json",
      data: {
        id: id,
        action: "live_match_list_Controller::load_leaderboard_Pointtable",
      },
      success: function (responce) {
        var data = JSON.parse(responce);
        if (data.status == 1) {
          $("#liveleaderboardpoints").empty();
          $("#liveleaderboardpoints").append(data.live_leaderboard_points_string);
        }
      },
    });
}