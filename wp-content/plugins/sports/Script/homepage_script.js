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