function Links() {
  var timezones =
    "<option value='Pacific/Midway'>(UTC-11:00) Midway Island </option><option value='Pacific/Samoa'>(UTC-11:00) Samoa </option><option value='Pacific/Honolulu'>(UTC-10:00) Hawaii </option><option value='US/Alaska'>(UTC-09:00) Alaska </option><option value='America/Los_Angeles'>(UTC-08:00) Pacific Time (US &amp; Canada) </option><option value='America/Tijuana'>(UTC-08:00) Tijuana </option><option value='US/Arizona'>(UTC-07:00) Arizona </option><option value='America/Chihuahua'>(UTC-07:00) Chihuahua </option><option value='America/Chihuahua'>(UTC-07:00) La Paz </option><option value='America/Mazatlan'>(UTC-07:00) Mazatlan </option><option value='US/Mountain'>(UTC-07:00) Mountain Time (US &amp; Canada) </option><option value='America/Managua'>(UTC-06:00) Central America </option><option value='US/Central'>(UTC-06:00) Central Time (US &amp; Canada) </option><option value='America/Mexico_City'>(UTC-06:00) Guadalajara </option><option value='America/Mexico_City'>(UTC-06:00) Mexico City </option><option value='America/Monterrey'>(UTC-06:00) Monterrey </option><option value='Canada/Saskatchewan'>(UTC-06:00) Saskatchewan </option><option value='America/Bogota'>(UTC-05:00) Bogota </option><option value='US/Eastern'>(UTC-05:00) Eastern Time (US &amp; Canada) </option><option value='US/East-Indiana'>(UTC-05:00) Indiana (East) </option><option value='America/Lima'>(UTC-05:00) Lima </option><option value='America/Bogota'>(UTC-05:00) Quito </option><option value='Canada/Atlantic'>(UTC-04:00) Atlantic Time (Canada) </option><option value='America/Caracas'>(UTC-04:30) Caracas </option><option value='America/La_Paz'>(UTC-04:00) La Paz </option><option value='America/Santiago'>(UTC-04:00) Santiago </option><option value='Canada/Newfoundland'>(UTC-03:30) Newfoundland </option><option value='America/Sao_Paulo'>(UTC-03:00) Brasilia </option><option value='America/Argentina/Buenos_Aires'>(UTC-03:00) Buenos Aires </option><option value='America/Argentina/Buenos_Aires'>(UTC-03:00) Georgetown </option><option value='America/Godthab'>(UTC-03:00) Greenland </option><option value='America/Noronha'>(UTC-02:00) Mid-Atlantic </option><option value='Atlantic/Azores'>(UTC-01:00) Azores </option><option value='Atlantic/Cape_Verde'>(UTC-01:00) Cape Verde Is. </option><option value='Africa/Casablanca'>(UTC+00:00) Casablanca </option><option value='Europe/London'>(UTC+00:00) Edinburgh </option><option value='Etc/Greenwich'>(UTC+00:00) Greenwich Mean Time : Dublin </option><option value='Europe/Lisbon'>(UTC+00:00) Lisbon </option><option value='Europe/London'>(UTC+00:00) London </option><option value='Africa/Monrovia'>(UTC+00:00) Monrovia </option><option value='UTC'>(UTC+00:00) UTC </option><option value='Europe/Amsterdam'>(UTC+01:00) Amsterdam </option><option value='Europe/Belgrade'>(UTC+01:00) Belgrade </option><option value='Europe/Berlin'>(UTC+01:00) Berlin </option><option value='Europe/Berlin'>(UTC+01:00) Bern </option><option value='Europe/Bratislava'>(UTC+01:00) Bratislava </option><option value='Europe/Brussels'>(UTC+01:00) Brussels </option><option value='Europe/Budapest'>(UTC+01:00) Budapest </option><option value='Europe/Copenhagen'>(UTC+01:00) Copenhagen </option><option value='Europe/Ljubljana'>(UTC+01:00) Ljubljana </option><option value='Europe/Madrid'>(UTC+01:00) Madrid </option><option value='Europe/Paris'>(UTC+01:00) Paris </option><option value='Europe/Prague'>(UTC+01:00) Prague </option><option value='Europe/Rome'>(UTC+01:00) Rome </option><option value='Europe/Sarajevo'>(UTC+01:00) Sarajevo </option><option value='Europe/Skopje'>(UTC+01:00) Skopje </option><option value='Europe/Stockholm'>(UTC+01:00) Stockholm </option><option value='Europe/Vienna'>(UTC+01:00) Vienna </option><option value='Europe/Warsaw'>(UTC+01:00) Warsaw </option><option value='Africa/Lagos'>(UTC+01:00) West Central Africa </option><option value='Europe/Zagreb'>(UTC+01:00) Zagreb </option><option value='Europe/Athens'>(UTC+02:00) Athens </option><option value='Europe/Bucharest'>(UTC+02:00) Bucharest </option><option value='Africa/Cairo'>(UTC+02:00) Cairo </option><option value='Africa/Harare'>(UTC+02:00) Harare </option><option value='Europe/Helsinki'>(UTC+02:00) Helsinki </option><option value='Europe/Istanbul'>(UTC+02:00) Istanbul </option><option value='Asia/Jerusalem'>(UTC+02:00) Jerusalem </option><option value='Europe/Helsinki'>(UTC+02:00) Kyiv </option><option value='Africa/Johannesburg'>(UTC+02:00) Pretoria </option><option value='Europe/Riga'>(UTC+02:00) Riga </option><option value='Europe/Sofia'>(UTC+02:00) Sofia </option><option value='Europe/Tallinn'>(UTC+02:00) Tallinn </option><option value='Europe/Vilnius'>(UTC+02:00) Vilnius </option><option value='Asia/Baghdad'>(UTC+03:00) Baghdad </option><option value='Asia/Kuwait'>(UTC+03:00) Kuwait </option><option value='Europe/Minsk'>(UTC+03:00) Minsk </option><option value='Africa/Nairobi'>(UTC+03:00) Nairobi </option><option value='Asia/Riyadh'>(UTC+03:00) Riyadh </option><option value='Europe/Volgograd'>(UTC+03:00) Volgograd </option><option value='Asia/Tehran'>(UTC+03:30) Tehran </option><option value='Asia/Muscat'>(UTC+04:00) Abu Dhabi </option><option value='Asia/Baku'>(UTC+04:00) Baku </option><option value='Europe/Moscow'>(UTC+04:00) Moscow </option><option value='Asia/Muscat'>(UTC+04:00) Muscat </option><option value='Europe/Moscow'>(UTC+04:00) St. Petersburg </option><option value='Asia/Tbilisi'>(UTC+04:00) Tbilisi </option><option value='Asia/Yerevan'>(UTC+04:00) Yerevan </option><option value='Asia/Kabul'>(UTC+04:30) Kabul </option><option value='Asia/Karachi'>(UTC+05:00) Islamabad </option><option value='Asia/Karachi'>(UTC+05:00) Karachi </option><option value='Asia/Tashkent'>(UTC+05:00) Tashkent </option><option value='Asia/Calcutta'>(UTC+05:30) Chennai </option><option value='Asia/Kolkata'>(UTC+05:30) Kolkata </option><option value='Asia/Calcutta'>(UTC+05:30) Mumbai </option><option value='Asia/Calcutta'>(UTC+05:30) New Delhi </option><option value='Asia/Calcutta'>(UTC+05:30) Sri Jayawardenepura </option><option value='Asia/Katmandu'>(UTC+05:45) Kathmandu </option><option value='Asia/Almaty'>(UTC+06:00) Almaty </option><option value='Asia/Dhaka'>(UTC+06:00) Astana </option><option value='Asia/Dhaka'>(UTC+06:00) Dhaka </option><option value='Asia/Yekaterinburg'>(UTC+06:00) Ekaterinburg </option><option value='Asia/Rangoon'>(UTC+06:30) Rangoon </option><option value='Asia/Bangkok'>(UTC+07:00) Bangkok </option><option value='Asia/Bangkok'>(UTC+07:00) Hanoi </option><option value='Asia/Jakarta'>(UTC+07:00) Jakarta </option><option value='Asia/Novosibirsk'>(UTC+07:00) Novosibirsk </option><option value='Asia/Hong_Kong'>(UTC+08:00) Beijing </option><option value='Asia/Chongqing'>(UTC+08:00) Chongqing </option><option value='Asia/Hong_Kong'>(UTC+08:00) Hong Kong </option><option value='Asia/Krasnoyarsk'>(UTC+08:00) Krasnoyarsk </option><option value='Asia/Kuala_Lumpur'>(UTC+08:00) Kuala Lumpur </option><option value='Australia/Perth'>(UTC+08:00) Perth </option><option value='Asia/Singapore'>(UTC+08:00) Singapore </option><option value='Asia/Taipei'>(UTC+08:00) Taipei </option><option value='Asia/Ulan_Bator'>(UTC+08:00) Ulaan Bataar </option><option value='Asia/Urumqi'>(UTC+08:00) Urumqi </option><option value='Asia/Irkutsk'>(UTC+09:00) Irkutsk </option><option value='Asia/Tokyo'>(UTC+09:00) Osaka </option><option value='Asia/Tokyo'>(UTC+09:00) Sapporo </option><option value='Asia/Seoul'>(UTC+09:00) Seoul </option><option value='Asia/Tokyo'>(UTC+09:00) Tokyo </option><option value='Australia/Adelaide'>(UTC+09:30) Adelaide </option><option value='Australia/Darwin'>(UTC+09:30) Darwin </option><option value='Australia/Brisbane'>(UTC+10:00) Brisbane </option><option value='Australia/Canberra'>(UTC+10:00) Canberra </option><option value='Pacific/Guam'>(UTC+10:00) Guam </option><option value='Australia/Hobart'>(UTC+10:00) Hobart </option><option value='Australia/Melbourne'>(UTC+10:00) Melbourne </option><option value='Pacific/Port_Moresby'>(UTC+10:00) Port Moresby </option><option value='Australia/Sydney'>(UTC+10:00) Sydney </option><option value='Asia/Yakutsk'>(UTC+10:00) Yakutsk </option><option value='Asia/Vladivostok'>(UTC+11:00) Vladivostok </option><option value='Pacific/Auckland'>(UTC+12:00) Auckland </option><option value='Pacific/Fiji'>(UTC+12:00) Fiji </option><option value='Pacific/Kwajalein'>(UTC+12:00) International Date Line West </option><option value='Asia/Kamchatka'>(UTC+12:00) Kamchatka </option><option value='Asia/Magadan'>(UTC+12:00) Magadan </option><option value='Pacific/Fiji'>(UTC+12:00) Marshall Is. </option><option value='Asia/Magadan'>(UTC+12:00) New Caledonia </option><option value='Asia/Magadan'>(UTC+12:00) Solomon Is. </option><option value='Pacific/Auckland'>(UTC+12:00) Wellington </option><option value='Pacific/Tongatapu'>(UTC+13:00) Nuku'alofa </option";
  let defaultSorting = [];

  $(document).bind("DOMNodeInserted", function () {
    $('[data-toggle="tooltip"]').tooltip();

    previous_configuration = $(".blocks").html();
    localStorage.setItem("DOMELEMENTS", previous_configuration);
    //show it when the checkbox is clicked
    // $('[relative-id]').css('display:none');
    // let toggle_all_relatives = document.querySelectorAll("[relative-id]");
    // toggle_all_relatives.forEach(relatives => {
    //   relatives.style["display"] = "none";
    // });

    let toggle_related = document.querySelectorAll("[toggle-relative]");
    toggle_related.forEach(function (this_toggle) {
      this_toggle.addEventListener("click", function () {
        let toggle_relative_id = this_toggle.getAttribute("toggle-relative");
        let relative_id = document.querySelector(
          '[relative-id="' + toggle_relative_id + '"]'
        );
        let relative_func_callback = relative_id.getAttribute(`relative-func`);
        // console.log(relative_func_callback_params);
        if (this_toggle.checked) {
          if (relative_id === null && relative_func_callback === null) {
            console.warn("relative-id [" + toggle_relative_id + '"] not found');
            return;
          }
          if (relative_func_callback) {
            let relative_func_name = relative_func_callback.split("(")[0];
            let relative_func_callback_params = relative_func_callback
              .split("(")[1]
              .split(")")[0];

            // eval(relative_func_callback);
          }
          relative_id.style["display"] = null;
        } else {
          if (relative_id === null && relative_func === null) {
            console.warn("relative-id #" + toggle_relative_id + " not found");
            return;
          }
          relative_id.style["display"] = "none";
        }
      });
    });
  });

  if (
    localStorage.getItem("DOMELEMENTS") &&
    localStorage.getItem("DOMELEMENTS") !== "undefined"
  ) {
    if (confirm("Want to recover from where you left?")) {
      $(".blocks").html(localStorage.getItem("DOMELEMENTS"));
    } else {
      localStorage.removeItem("DOMELEMENTS");
    }
  }
  var options = {
    valueNames: [
      {
        attr: "value",
        name: "block_title",
      },
      {
        attr: "value",
        name: "link_box",
      },
    ],
  };

  // Init list
  let linksList = new List("send-request", options);

  defaultSorting = $(".blocks > .block");

  $("#send-request").on(
    "change",
    "input[type=text], input[type=url]",
    function (e) {
      defaultSorting = $(".blocks > .block");
      // console.log('DOM Changed');
      e.target.setAttribute("value", e.target.value);
      linksList.reIndex();
      linksList.update();
    }
  );
  $("#filter-links").on("keyup", function () {
    let searchString = $(this).val();
    linksList.fuzzySearch(searchString);
  });
  $("#sort-asc").on("click", function () {
    let sortAlpha = $(this).val();
    linksList.sort("block_title", {
      order: "asc",
      alphabet: "ABCDEFGHIJKLMNOPQRSTUVXYZÅÄÖabcdefghijklmnopqrstuvxyzåäö",
    });
    updateData();
  });
  $("#sort-desc").on("click", function () {
    let sortAlpha = $(this).val();
    linksList.sort("block_title", {
      order: "desc",
      alphabet: "ABCDEFGHIJKLMNOPQRSTUVXYZÅÄÖabcdefghijklmnopqrstuvxyzåäö",
    });
    updateData();
  });
  $("#reset-sorting").on("click", function () {
    // linksList.search();
    sorting_default();
    updateData();
  });

  function sorting_default() {
    // console.log(defaultSorting);
    $(".blocks > .block").remove();
    $(".blocks").append(defaultSorting);
  }
  $(window).scroll(function () {
    // console.log($('.block').attr('id'));
    let parentwidth = $(".right_panel").parent().width();

    //Get dynamic scrolltop
    let topnavbarWidth = Math.ceil($("#topbar").outerHeight(true));
    // console.log(topnavbarWidth);

    if ($(window).scrollTop() > topnavbarWidth) {
      $(".right_panel").width(parentwidth);
      $(".right_panel").addClass("stick-top");
    }
    if ($(window).scrollTop() < topnavbarWidth + 1) {
      $(".right_panel").width(parentwidth);
      $(".right_panel").removeClass("stick-top");
    }
  });
  (function () {
    window.addEventListener("keypress", function (event) {
      if (event.ctrlKey) {
        if (event.which === 17 || event.key === 17) {
          if ($("#profile-tab").hasClass("active")) {
            $("#layouts-tab").click();
          } else {
            $("#profile-tab").click();
          }
        }
      }
      // console.log('ctrl pressed');
      // console.log(event.which);
    });
    /**
     * All the code that needs to be unexposed in the console here.
     */
  })(); // Send parameters inside the function if you need to
  var form = document.querySelector(".send-request");
  var form_objects = $(form).serializeControls();
  let priority_enabled,
    index = 0,
    information_collector_used = 0,
    feedback_collector_used = 0,
    anonymus_chat_used = 0;

  $(".blocks").on("click", "#show_username", function () {
    if ($(this).closest(".block").find(".s_m_u_enabled").length > 0) {
      $(this).closest(".block").find(".s_m_u_enabled").remove();
    } else {
      // $()
      $(this)
        .closest(".block")
        .find(".block-inputs")
        .append(
          create_object(
            "text",
            "true",
            'name="chat[features][show_my_username]" class="d-none s_m_u_enabled"'
          )
        );
    }
  });
  $(".blocks").on("click", "#force_login", function () {
    if ($(this).closest(".block").find(".f_login_enabled").length > 0) {
      $(this).closest(".block").find(".f_login_enabled").remove();
    } else {
      // $()
      $(this)
        .closest(".block")
        .find(".block-inputs")
        .append(
          create_object(
            "text",
            "true",
            'name="chat[features][force_login]" class="d-none f_login_enabled"'
          )
        );
    }
  });
  $(".blocks").on("click", "#auto_reply", function () {
    if ($(this).closest(".block").find(".a_r_enabled").length > 0) {
      $(this).closest(".block").find(".a_r_enabled").remove();
    } else {
      // $()
      $(this)
        .closest(".block")
        .find(".block-inputs")
        .append(
          create_object(
            "text",
            "true",
            'name="chat[features][auto_reply][auto_reply]" class="d-none a_r_enabled"'
          )
        );
    }
  });
  $(".blocks").on("click", "#filter_abuse", function () {
    if ($(this).closest(".block").find(".f_abuse_enabled").length > 0) {
      $(this).closest(".block").find(".f_abuse_enabled").remove();
    } else {
      // $()
      $(this)
        .closest(".block")
        .find(".block-inputs")
        .append(
          create_object(
            "text",
            "true",
            'name="chat[features][filter_abuse][filter_abuse]" class="d-none f_abuse_enabled"'
          )
        );
    }
  });
  $(".blocks").on("click", ".anim_type", function (e) {
    //Counting priotity objects
    if ($(".blocks").find(".p_enabled").length > 0) {
      $(".blocks").find(".p_enabled").remove();
      document.querySelectorAll(".priority_link").forEach(function (ele) {
        ele.innerText = "Priority";
      });

      $(this)
        .closest(".block")
        .find(".block-inputs")
        .append(
          create_object(
            "text",
            "true",
            'name="' +
              $(this).closest(".block").attr("id") +
              '[priority][enabled]" class="d-none p_enabled"'
          ),
          create_object(
            "text",
            $(this).attr("ref-effect"),
            'name="' +
              $(this).closest(".block").attr("id") +
              '[priority][effect]" class="d-none p_enabled"'
          )
        );

      document
        .querySelectorAll(".priority_link_container")
        .forEach(function (ele) {
          ele.classList.remove("text-succes", "bg-success-soft");
        });
    } else {
      $(this)
        .closest(".block")
        .find(".block-inputs")
        .append(
          create_object(
            "text",
            "true",
            'name="' +
              $(this).closest(".block").attr("id") +
              '[priority][enabled]" class="d-none p_enabled"'
          ),
          create_object(
            "text",
            $(this).attr("ref-effect"),
            'name="' +
              $(this).closest(".block").attr("id") +
              '[priority][effect]" class="d-none p_enabled"'
          )
        );
    }

    //Managing .active class
    var animation_lists = document.querySelectorAll(".anim_type");
    animation_lists.forEach(function (animation_type) {
      if (e.target !== animation_type) {
        animation_type.classList.remove("active");
      }
    });
    e.target.classList.add("active");

    //Setting / Updating name of the selected option
    // $(this).parent().parent().find('.priority_link')[0].innerText = e.target.lastChild.textContent;
    // console.log(e);
    $(this)
      .closest(".block-inputs")
      .find(".priority_link")
      .html(e.target.lastChild.textContent);
    // console.log($('.blocks').find('.p_enabled').length);

    //Updating effect property
    $(this)
      .closest(".block")
      .find(".priority_link")[0]
      .setAttribute("ref-animation-effect", $(this).attr("ref-effect"));

    $(this)
      .closest(".block")
      .find(".block-inputs")
      .append(
        create_object(
          "text",
          "true",
          'name="' +
            $(this).closest(".block").attr("id") +
            '[priority][enabled]" class="d-none p_enabled"'
        ),
        create_object(
          "text",
          $(this).attr("ref-effect"),
          'name="' +
            $(this).closest(".block").attr("id") +
            '[priority][effect]" class="d-none p_enabled"'
        )
      );

    //Updating priority enabled as 1;
    priority_enabled = 1;
    $(this)
      .closest(".block-inputs")
      .find(".priority_link_container")
      .addClass("text-succes bg-success-soft");

    if ($(this).attr("ref-effect") === "none") {
      $(".blocks").find(".p_enabled").remove();
      document.querySelectorAll(".priority_link").forEach(function (ele) {
        ele.innerText = "Priority";
        ele
          .closest(".priority_link_container")
          .classList.remove("text-succes", "bg-success-soft");
      });
    }
    updateData();
    publishPage();
  });

  //Defined variables

  $(".blocks").on("change", ".toggle_thumbnail", function (e) {
    // Check if thumbnail is on/off
    if (e.target.checked) {
      // If thumbnail is on then remove thumbnail object
      $(this).closest(".block").find(".thumbnail_off").remove();
    } else {
      //if thumbnail is off then add thumbnail object with key and value
      $(this)
        .closest(".block")
        .find(".block-inputs")
        .append(
          create_object(
            "text",
            "true",
            'name="' +
              $(this).closest(".block").attr("id") +
              '[thumbnail_off]" class="d-none thumbnail_off"'
          )
        );
    }
    // apply desaturation after turning off thumbnail
    $(this).closest(".block").find(".avatar-img").toggleClass("desaturate");
    // update data (key : pair values)
    updateData();
    // send request to the server
    publishPage();
  });

  $(".blocks").on("click", ".close_forward_page", function () {
    $(this).closest(".forward_page_box").remove();
  });

  $(".blocks").on("click", ".confirm_forward_page", function () {
    $(this)
      .closest(".block")
      .find(".block-inputs")
      .append(
        //Creating date, time, timezone object
        create_object(
          "text",
          $(this)
            .closest(".block")
            .find(".forward_page_input_date")
            .val()
            .split("to"),
          'name="' +
            $(this).closest(".block").attr("id") +
            '[forward][date]" class="d-none forward_date"'
        ),
        create_object(
          "text",
          $(this).closest(".block").find(".forward_page_input_timezone").val(),
          'name="' +
            $(this).closest(".block").attr("id") +
            '[forward][timezone]" class="d-none forward_date"'
        )
      );

    //Updating form controls values
    form_objects = $(form).serializeControls();

    //Displaying realtime forward information
    var forward_date =
      form_objects["" + $(this).closest(".block").attr("id") + ""]["forward"][
        "date"
      ];

    //Formatting forward date
    forward_date_time =
      "" +
      forward_date.split(",")[0].trim() +
      " to " +
      forward_date.split(",")[1].trim() +
      "";

    //Removing previous/old information if available
    $(this).closest(".block").find(".forward_information").remove();

    //Displaying updated information
    $(this)
      .closest(".block")
      .find(".block-inputs")
      .before(forwardLinkInformation(forward_date_time));

    updateData();
    publishPage();
  });

  $(".blocks").on("click", ".clear_forward", function () {
    $(this).closest(".block").find(".forward_date").remove();
    $(this).parent().remove();
    updateData();
    publishPage();
  });

  $(".blocks").on("click", ".close_schedule", function () {
    $(this).closest(".schedule_box").remove();
  });

  $(".blocks").on("click", ".confirm_schedule", function () {
    if (
      $(this).closest(".block").find(".scheduled_input_date").val() == "" ||
      $(this).closest(".block").find(".scheduled_input_timezone").val() == ""
    ) {
      return false;
    }

    $(this)
      .closest(".block")
      .find(".block-inputs")
      .append(
        //Creating date, time, timezone object
        create_object(
          "text",
          $(this)
            .closest(".block")
            .find(".scheduled_input_date")
            .val()
            .split("to"),
          'name="' +
            $(this).closest(".block").attr("id") +
            '[scheduled][date]" class="d-none schedule_date"'
        ),
        create_object(
          "text",
          $(this).closest(".block").find(".scheduled_input_timezone").val(),
          'name="' +
            $(this).closest(".block").attr("id") +
            '[scheduled][timezone]" class="d-none schedule_date"'
        )
      );

    //Updating form controls values
    form_objects = $(form).serializeControls();

    //Displaying realtime scheduled information
    var scheduled_date =
      form_objects["" + $(this).closest(".block").attr("id") + ""]["scheduled"][
        "date"
      ];

    //Formatting scheduled date

    scheduled_date_time =
      "" +
      scheduled_date.split(",")[0].trim() +
      " to " +
      scheduled_date.split(",")[1].trim() +
      "";

    //Removing previous/old information if available
    $(this).closest(".block").find(".scheduled_information").remove();

    //Displaying updated information
    $(this)
      .closest(".block")
      .find(".block-inputs")
      .before(scheduledInformation(scheduled_date_time));

    //Updating data
    updateData();
    publishPage();
  });

  $(".blocks").on("click", ".clear_schedule", function () {
    $(this).closest(".block").find(".schedule_date").remove();
    $(this).parent().remove();
    updateData();
    publishPage();
  });

  $(".blocks").on("click", ".forward_link", function () {
    //Remove all other forward links
    if ($(".blocks").find(".forward_page_box").length > 0) {
      $(".blocks").find(".forward_page_box").remove();
    }
    $(".blocks").find(".forward_information").remove();
    $(".blocks").find(".forward_date").remove();
    //Set current link as forward
    $(this)
      .closest(".block")
      .find(".block-inputs")
      .before(forward_link_template);
    flatpickr(".forward_page_input_date", {
      altFormat: "F j, Y",
      enableTime: true,
      defaultHour: new Date().getHours(),
      defaultMinute: new Date().getMinutes(),
      minDate: "today",
      dateFormat: "d-m-Y h:i K",
      mode: "range",
    });
    $(".forward_page_input_timezone").select2({
      placeholder: "Select your timezone",
    });

    updateData();
    publishPage();
  });
  $(".blocks").on("click", ".schedule_link", function () {
    //Removing previous/old information if available
    if ($(this).closest(".block").find(".schedule_box").length > 0) {
      return;
    } else {
      //Displaying new information
      $(this).closest(".block").find(".block-inputs").before(schedule_template);

      $(".scheduled_input_timezone").select2({
        placeholder: "Select your timezone",
      });

      document
        .querySelectorAll(".scheduled_input_date")
        .forEach(function (ele) {
          // creates multiple instances of flatpickr
          flatpickr(ele, {
            altFormat: "F j, Y",
            enableTime: true,
            defaultHour: new Date().getHours(),
            defaultMinute: new Date().getMinutes(),
            minDate: "today",
            dateFormat: "d-m-Y h:i K",
            mode: "range",
          });
        });
    }
  });

  $(".blocks").on("click", ".disableBlock", function () {
    if ($(this).closest(".block").find(".b_disabled").length > 0) {
      $(this).closest(".block").find(".b_disabled").remove();
      $(this).html("Disable");
      $(this)
        .closest(".block")
        .find(".card")
        .toggleClass("bg-info-soft border-info desaturate");
    } else {
      $(this)
        .closest(".block")
        .find(".card")
        .toggleClass("bg-info-soft border-info desaturate");
      $(this)
        .closest(".block")
        .find(".block-inputs")
        .append(
          create_object(
            "text",
            "true",
            'name="' +
              $(this).closest(".block").attr("id") +
              '[disabled]" class="d-none b_disabled"'
          )
        );
      $(this).html("Disabled");
    }
    // $(this).toggleClass('text-success bg-success-soft');
    updateData();
    publishPage();
  });
  $(".blocks").sortable({
    axis: "y",
    cursor: "move",
    revert: true,
    placeholder: "ui-state-highlight",
    cursorAt: {
      left: 5,
      right: 5,
      top: 5,
      bottom: 5,
    },
    update: function (event, ui) {
      // console.log(event);
      updateData();
      publishPage();
    }, //end update
    sort: function (event, ui) {
      // This event is triggered during sorting.
      // ui.item[0].classList.add("scale-n9");
    },
    start: function (event, ui) {
      // This event is triggered when sorting starts.
      ui.item[0].classList.add("scale-n9");
    },
    stop: function (event, ui) {
      ui.item[0].classList.remove("scale-n9");
    },
  });
  $(".blocks").disableSelection();

  function create_object(type = "text", data, attrs) {
    return '<input type="' + type + '" value="' + data + '" ' + attrs + " />";
  }

  function updateData() {
    linksList.reIndex();
    linksList.update();

    var obj = $(form).serializeControls();
    // localStorage.setItem('Config', JSON.stringify(obj));
    var t_preview = "";
    for (var key in obj) {
      if (obj.hasOwnProperty(key)) {
        var val = obj[key];

        if (
          val.link_title === undefined ||
          val.link_address === undefined ||
          val.domain_icon === undefined ||
          val.disabled
        ) {
          delete obj[key];
        } else {
          /*val.link_title ? title = val.link_title : title = "Title";
            val.link_address ? url = val.link_address : url = "www.address.com";*/
          if (!val.thumbnail_off == true) {
            domain_favicon =
              '<div class="col-auto mr-2"><div class="avatar avatar-xs ${key}_domain_icon"><img class="avatar-img rounded-circle" src="' +
              val.domain_icon +
              '"></div></div>';
          } else {
            domain_favicon = "";
          }
          if (val.priority && val.priority.enabled === "true") {
            priority_effect =
              "animate__animated animate__" +
              val.priority.effect +
              " animate__infinite animate__slow";
          } else {
            priority_effect = "";
          }
          t_preview +=
            '<div class="card m-3 rounded ' +
            priority_effect +
            '"><div class="p-2"><div class="row align-items-center no-gutters"><a class="stretched-link" target="_blank" href="' +
            val.link_address +
            '"></a>' +
            domain_favicon +
            '<div class="col text-truncate"><h6 class="text-uppercase text-muted mb-1">' +
            parseUri(val.link_address).authority +
            '</h6><span class="h4 mb-0">' +
            val.link_title +
            '</span></div><div class="col-auto ml-n1"><i class="bi bi-chevron-right text-muted mb-0"></i></div></div></div></div>';
        }
      }
    }
    $(".live_preview").html(t_preview);
    // console.log(obj);
  }
  $(".toggle_dark").on("click", function () {
    $("html").toggleClass("dark-theme");
    const theme = $("#theme");
    theme.toggleClass("dark");
    if (theme.hasClass("dark")) {
      theme.attr("href", "http://localhost/ProfilePage/css/theme-dark.min.css");
      $(this).html('<i class="bi bi-lightbulb sz-24 my-2"></i>');
    } else {
      theme.attr("href", "http://localhost/ProfilePage/css/theme.min.css");
      $(this).html('<i class="bi bi-lightbulb-off sz-24 my-2"></i>');
    }
  });

  blockNum = 0;
  $.fn.hasAttr = function (name) {
    return this.attr(name) !== undefined;
  };

  function addFavicon(toElem, ofDomain) {
    if (toElem.hasAttr("dif")) {
      return;
    } else {
      var favicon;
      var errorFavicon = 0;
      var addIcon;
      ofDomain = ofDomain
        .replace(/^(?:https?:\/\/)?(?:www\.)?/i, "")
        .split("/")[0]
        .toLowerCase();
      // console.log(parseUri(ofDomain));

      //Appending preloader for fetching domain favicon
      addIcon = toElem.html(
        '<div class="spinner-grow"><span class="sr-only">Loading...</span></div>'
      );

      //Returning promise to check if link is valid
      const cancelTokenSource = axios.CancelToken.source();
      return axios
        .get("https://api.faviconkit.com/" + ofDomain + "/144", {
          cancelToken: cancelTokenSource.token,
        })
        .then(function (response) {
          //Check if status code is 200, OK
          if (response.status === 200) {
            //If status code is 200 then add icon
            if (errorFavicon === 0) {
              favicon = "https://api.faviconkit.com/" + ofDomain + "/144";
              addIcon = toElem.html(
                '<img class="avatar-img rounded-circle" src ="' +
                  favicon +
                  '" title="Verified"/><input type="hidden" name="' +
                  $(toElem).attr("ref-icon") +
                  '[domain_icon]" value="' +
                  favicon +
                  '" />'
              );
              // console.log($(toElem).attr('ref-icon'));
              toElem.attr("dif", "f");
              $(toElem)
                .closest(".avatar")
                .removeClass("avatar-offline")
                .addClass("avatar-online");
              updateData();
              if (favicon == null || favicon == "") {
                errorFavicon = 1;
                return;
              }
              return;
            }
            if (errorFavicon === 1) {
              favicon = response.data.icons[0].src;
              addIcon = toElem.html(
                '<img class="avatar-img rounded-circle" src ="' +
                  favicon +
                  '" title="Verified"/><input type="hidden" name="' +
                  $(toElem).attr("ref-icon") +
                  '[domain_icon]" value="' +
                  favicon +
                  '" />'
              );
              // console.log($(toElem).attr('ref-icon'));
              toElem.attr("dif", "f");
              $(toElem)
                .closest(".avatar")
                .removeClass("avatar-offline")
                .addClass("avatar-online");
              updateData();
              if (favicon == null || favicon == "") {
                errorFavicon = 2;
                return;
              }
            }
            if (errorFavicon === 2) {
              favicon =
                "http://www.google.com/s2/favicons?domain=" + ofDomain + "";
              addIcon = toElem.html(
                '<img class="avatar-img rounded-circle" src ="' +
                  favicon +
                  '" title="Verified"/><input type="hidden" name="' +
                  $(toElem).attr("ref-icon") +
                  '[domain_icon]" value="' +
                  favicon +
                  '" />'
              );
              // console.log($(toElem).attr('ref-icon'));
              toElem.attr("dif", "f");
              $(toElem)
                .closest(".avatar")
                .removeClass("avatar-offline")
                .addClass("avatar-online");
              updateData();
              if (favicon == null || favicon == "") {
                errorFavicon = 3;
                return;
              }
              return;
            }
            if (errorFavicon === 3) {
              favicon = "http://" + ofDomain + "/favicon.ico";
              addIcon = toElem.html(
                '<img class="avatar-img rounded-circle" src ="' +
                  favicon +
                  '" title="Verified"/><input type="hidden" name="' +
                  $(toElem).attr("ref-icon") +
                  '[domain_icon]" value="' +
                  favicon +
                  '" />'
              );
              // console.log($(toElem).attr('ref-icon'));
              toElem.attr("dif", "f");
              $(toElem)
                .closest(".avatar")
                .removeClass("avatar-offline")
                .addClass("avatar-online");
              updateData();
              if (favicon == null || favicon == "") {
                errorFavicon = 4;
                return;
              }
              return;
            }
          }
          // console.log(response);
        })
        .catch(function (error) {
          //Converting error message to string
          var errormsg = error.toString();

          //Check if any [Error, 404] message exists
          if (
            errormsg.indexOf("Error") > -1 ||
            errormsg.indexOf("404") > -1 ||
            errormsg.indexOf("400") > -1
          );

          //If found any Error message Set errorFavicon = 4
          errorFavicon = 4;

          // Conditional to load favicon
          if (errorFavicon === 4) {
            favicon =
              "https://via.placeholder.com/200/D62D20/FFFFFF?text=" +
              ofDomain.substring(0, 1) +
              "";
            addIcon = toElem.html(
              '<img class="avatar-img rounded-circle" src ="' +
                favicon +
                '"  title="Could not verify link"/><input type="hidden" name="' +
                $(toElem).attr("ref-icon") +
                '[domain_icon]" value="' +
                favicon +
                '" />'
            );
            $(toElem).closest(".avatar").addClass("avatar-offline");
            toElem.attr("dinf");
            updateData();
            // console.log('Favicon not found');
            errorFavicon = 0;
          }
        });
      if (cancelTokenSource) {
        // Cancel request
        cancelTokenSource.cancel("Oopration cancelled due to new req.");
      }
    }
    return addIcon;
  }

  // parseUri 1.2.2
  // (c) Steven Levithan <stevenlevithan.com>
  // MIT License

  function parseUri(str) {
    var o = parseUri.options,
      m = o.parser[o.strictMode ? "strict" : "loose"].exec(str),
      uri = {},
      i = 14;

    while (i--) uri[o.key[i]] = m[i] || "";

    uri[o.q.name] = {};
    uri[o.key[12]].replace(o.q.parser, function ($0, $1, $2) {
      if ($1) uri[o.q.name][$1] = $2;
    });

    return uri;
  }
  parseUri.options = {
    strictMode: false,
    key: [
      "source",
      "protocol",
      "authority",
      "userInfo",
      "user",
      "password",
      "host",
      "port",
      "relative",
      "path",
      "directory",
      "file",
      "query",
      "anchor",
    ],
    q: {
      name: "queryKey",
      parser: /(?:^|&)([^&=]*)=?([^&]*)/g,
    },
    parser: {
      strict: /^(?:([^:\/?#]+):)?(?:\/\/((?:(([^:@]*)(?::([^:@]*))?)?@)?([^:\/?#]*)(?::(\d*))?))?((((?:[^?#\/]*\/)*)([^?#]*))(?:\?([^#]*))?(?:#(.*))?)/,
      loose: /^(?:(?![^:@]+:[^:@\/]*@)([^:\/?#.]+):)?(?:\/\/)?((?:(([^:@]*)(?::([^:@]*))?)?@)?([^:\/?#]*)(?::(\d*))?)(((\/(?:[^?#](?![^?#\/]*\.[^?#\/.]+(?:[?#]|$)))*\/?)?([^?#\/]*))(?:\?([^#]*))?(?:#(.*))?)/,
    },
  };
  var confirmDialog = function () {
    return '<div class="dialog-overlay rounded-xl card-body bg-danger-soft text-danger d-flex align-items-center flex-column justify-content-center"><div class="warning"><h3>Are you sure you want to delete?</h3></div><div class="btn-group"><button type="button" class="btn btn-danger btn-sm rounded-pill confirm-delete mr-3">Delete</button> <button type="button" class="btn btn-primary btn-sm rounded-pill cancel-delete">Cancel</button></div></div>';
  };
  var scheduledInformation = function (scheduled_date_time) {
    return (
      '<div class="scheduled_information"><div class="card-header p-2 h-auto"><h4 class="card-header-title">Scheduled from ' +
      scheduled_date_time +
      '</h4><button type="button" class="btn btn-sm btn-white rounded clear_schedule">Clear schedule</button></div></div>'
    );
  };
  var forwardLinkInformation = function (forward_date_time) {
    return (
      '<div class="forward_information"><div class="card-header p-2 h-auto"><h4 class="card-header-title">Forward set from ' +
      forward_date_time +
      '</h4><button type="button" class="btn btn-sm btn-white rounded clear_forward">Clear forward</button></div></div>'
    );
  };
  var link_media_preview_template = function (reference_block, v_id) {
    return (
      '<div class="accordion border rounded p-0 mt-3"><div class="row align-items-center justify-content-between no-gutters"><div class="col"><button class="btn btn-block text-left mb-0" type="button" data-toggle="collapse" data-target="#' +
      reference_block +
      '_preview" aria-expanded="true" aria-controls="collapseOne"><span class="preview_enabled">Preview</span></button></div><div class="col-auto"><button class="align-self-end btn mb-0 btn-white btn-sm rounded-pill mr-2 toggle_link_preview" type="button"><span class="link_preview_enabled">Turn off</span></button></div></div><div id="' +
      reference_block +
      '_preview" class="collapse show"><div class="embed-responsive embed-responsive-21by9 rounded-bottom"><iframe class="embed-responsive-item" src="' +
      v_id +
      '" allowfullscreen></iframe></div></div></div>'
    );
  };
  var schedule_template = function () {
    return (
      '<div class="schedule_box"><div class="card-header h-auto p-2 px-3"><h4 class="card-header-title">Schedule link</h4><div class="btn-group btn-group-sm"><button type="button" class="btn bg-white-soft border confirm_schedule">Save</button> <button type="button" class="btn bg-white-soft border close_schedule">Close</button></div></div><div class="p-3"><div class="row"><div class="col-md-6 mb-3"><div class="input-group input-group-merge"><div class="input-group-prepend"><span class="input-group-text p-0 px-2"><i class="bi bi-clock-history"></i></span></div><input type="text" class="form-control form-control-sm form-control-prepended scheduled_input_date" placeholder="Start date to End date" data-toggle="flatpickr"></div></div><div class="col-md-6"><select class="scheduled_input_timezone">' +
      timezones +
      '</select></div></div></div><hr class="m-0"></div>'
    );
  };
  var forward_link_template = function () {
    return `<div class="forward_page_box"><div class="card-header h-auto p-2 px-3"><h4 class="card-header-title">Forward link</h4><div class="btn-group btn-group-sm"><button type="button" class="btn bg-white-soft border confirm_forward_page">Save</button> <button type="button" class="btn bg-white-soft border close_forward_page">Close</button></div></div><div class="p-3"><div class="row"><div class="col-md-6 mb-3"><div class="input-group input-group-merge"><div class="input-group-prepend"><span class="input-group-text p-0 px-2"><i class="bi bi-clock-history"></i></span></div><input type="text" class="form-control form-control-sm form-control-prepended forward_page_input_date" placeholder="Date 1 to Date 2" data-toggle="flatpickr"></div></div><div class="col-md-6"><select class="forward_page_input_timezone">
      <?php foreach ($timezones as $zones => $zone) {
        print "<option value='$zone'>$zones </option>";
      } ?> </select></div> </div></div> <hr class = "m-0"> </div>`;
  };
  var anonymus_chat_template = function () {
    return '<div class="block mb-2" id="anonymus_chat"><div class="card mb-0 rounded"><div class="card-header"><h4 class="card-header-title">Anonymus chat</h4><button class="btn btn-sm btn-white-soft removeBlock" type="button"><i class="bi bi-x-circle sz-18"></i></button></div><div class="card-body py-1 block-inputs"><div class="mb-3"><ul class="list-group list-group-flush"><li class="list-group-item d-flex align-items-center justify-content-between px-0"><small>Show my username <i class="bi bi-info-circle ml-2" data-toggle="tooltip" title="Turning this on will show your username, turning this off will show randomly generated name to every user."></i></small><div class="custom-control custom-switch"><input type="checkbox" class="custom-control-input" id="show_username"> <label class="custom-control-label" for="show_username"></label></div></li><li class="list-group-item d-flex align-items-center justify-content-between px-0"><small>Disallow direct messaging <i class="bi bi-info-circle ml-2" data-toggle="tooltip" title="Enable this to get messages only from registered users."></i></small><div class="custom-control custom-switch"><input type="checkbox" class="custom-control-input" id="force_login"> <label class="custom-control-label" for="force_login"></label></div></li><li class="list-group-item"><div class="d-flex align-items-center justify-content-between px-0"><small>Set delay timer *in seconds <i class="bi bi-info-circle ml-2" data-toggle="tooltip" title="Uers will have to wait before sending a new message."></i></small><div class="custom-control custom-switch"><input type="checkbox" class="custom-control-input toggle-input" toggle-relative="delaytimer" id="delay_timer"> <label class="custom-control-label" for="delay_timer"></label></div></div><input name="chat[features][delay_timer]" class="form-control mt-2" relative-id="delaytimer" value="10" placeholder="Set seconds..." style="display:none"></li><li class="list-group-item"><div class="d-flex align-items-center justify-content-between px-0"><small>Send auto reply <i class="bi bi-info-circle ml-2" data-toggle="tooltip" title="You can set a custom reply to users."></i></small><div class="custom-control custom-switch"><input type="checkbox" class="custom-control-input toggle-input" toggle-relative="autoreply" id="auto_reply"> <label class="custom-control-label" for="auto_reply"></label></div></div><textarea name="chat[features][auto_reply][reply]" class="form-control mt-2" relative-id="autoreply" cols="30" rows="2" style="display:none">Hi, {user} thankyou for texting me.</textarea></li><li class="list-group-item"><div class="d-flex align-items-center justify-content-between px-0"><small>Filter abusive messages <i>*beta</i> <i class="bi bi-info-circle ml-2" data-toggle="tooltip" title="Abusive messages will be filtered and removed, no filter is 100% accurate"></i></small><div class="custom-control custom-switch"><input type="checkbox" class="custom-control-input toggle-input" id="filter_abuse" toggle-relative="abusefilter"> <label class="custom-control-label" for="filter_abuse"></label></div></div><input class="form-control mt-2" relative-id="abusefilter" name="chat[features][filter_abuse][words]" size="50" type="text" placeholder="Enter words to filter like: abc, def" style="display:none"></li></ul></div></div></div></div>';
  };
  var feedback_collector_template = function () {
    return '<div class="block" id="feedback_collector"><div class="card mb-3"><div class="card-header"><h4 class="card-header-title">Feedback</h4><button class="btn btn-sm btn-white-soft removeBlock" type="button"><i class="bi bi-x-circle sz-18"></i></button></div><div class="block-inputs form-group mb-0"><div class="card-body"><ul class="list-group list-group-flush"><li class="list-group-item form-group-item mt-n4 py-3 px-0 mb-0"><input class="form-control mb-2" id="feedbacker" type="text" placeholder="Enter placeholder" value="Your name" name="feedback_collector[name]"> <input class="form-control mb-2" placeholder="Enter placeholder" value="Your email" type="email" name="feedback_collector[email]"> <textarea class="form-control mb-2 feedback_message" id="feedback_message" rows="5" placeholder="Enter your placeholder for user" name="feedback_collector[feebacker_message]" resize="none"></textarea></li></ul></div></div></div></div>';
  };
  var information_collector_template = function () {
    return '<div class="block" id="information_collector"><div class="card"><div class="card-header"><h4 class="card-header-title">Forms</h4><button class="btn btn-sm btn-white-soft removeBlock" type="button"><i class="bi bi-x-circle sz-18"></i></button></div><div class="block-inputs form-group mb-0"><div class="card-body"><ul class="list-group list-group-flush mt-n4"><li class="list-group-item form-group-item py-3 px-0 mb-0"><div class="row"><div class="col-md-3"><input type="text" class="form-control form-control-flush" placeholder="Give a label" name="information_collector[fields][name][label]"></div><div class="col"><div class="input-group input-group-merge"><input type="text" class="form-control form-control-appended" placeholder="Placeholder" value="Name" name="information_collector[fields][name][placeholder]"><div class="input-group-append"><div class="input-group-text py-0"><button class="btn btn-sm bg-danger-soft text-danger rounded-pill removeInput" type="button">Remove</button></div></div></div></div></div></li><li class="list-group-item form-group-item py-3 px-0"><div class="row"><div class="col-md-3"><input type="text" class="form-control form-control-flush w-auto" placeholder="Give a label" name="information_collector[fields][email][label]"></div><div class="col"><div class="input-group input-group-merge"><input type="text" class="form-control form-control-appended form-control-" placeholder="Placeholder" value="Email" name="information_collector[fields][email][placeholder]"><div class="input-group-append"><div class="input-group-text py-0"><button class="btn btn-sm bg-danger-soft text-danger rounded-pill removeInput" type="button">Remove</button></div></div></div></div></div></li><li class="list-group-item form-group-item py-3 px-0"><div class="row"><div class="col-md-3"><input type="text" class="form-control form-control-flush w-auto" placeholder="Give a label" name="information_collector[fields][phone][label]"></div><div class="col"><div class="input-group input-group-merge"><input type="text" class="form-control form-control-appended form-control-" placeholder="Placeholder" value="Phone number" name="information_collector[fields][phone][placeholder]"><div class="input-group-append"><div class="input-group-text py-0"><button class="btn btn-sm bg-danger-soft text-danger rounded-pill removeInput" type="button">Remove</button></div></div></div></div></div></li><li class="list-group-item form-group-item px-0"><div class="row"><div class="col-md-3"><input type="text" class="form-control form-control-flush w-auto" placeholder="Give a label" name="information_collector[fields][dob][label]"></div><div class="col"><div class="input-group input-group-merge"><input type="text" class="form-control form-control-appended form-control-" placeholder="Placeholder" value="Date of birth" name="information_collector[fields][dob][placeholder]"><div class="input-group-append"><div class="input-group-text py-0"><button class="btn btn-sm bg-danger-soft text-danger rounded-pill removeInput" type="button">Remove</button></div></div></div></div></div></li></ul><div class="toolbar"><div class="btn-group btn-group-sm"><div class="dropdown rounded-pill mr-2 bg-primary-soft priority_link_container"><button type="button" class="btn btn-sm text-primary dropdown-toggle" data-toggle="dropdown" ref-animation-effect="headShake"><i class="bi bi-asterisk sz-sm"></i> <span class="priority_link">Priority</span></button><div class="dropdown-menu position-absolute" style="z-index:999"><h6 class="dropdown-header animation_list">Choose animations</h6><a class="dropdown-item anim_type" ref-effect="none" href="javascript:void(0)"><i class="bi bi-bezier2"></i> None</a> <a class="dropdown-item anim_type" ref-effect="headShake" href="javascript:void(0)"><i class="bi bi-bezier2"></i> Default</a> <a class="dropdown-item anim_type" ref-effect="bounce" href="javascript:void(0)"><i class="bi bi-bezier2"></i> Bounce</a> <a class="dropdown-item anim_type" ref-effect="flash" href="javascript:void(0)"><i class="bi bi-bezier2"></i> Flash</a> <a class="dropdown-item anim_type" ref-effect="pulse" href="javascript:void(0)"><i class="bi bi-bezier2"></i> Pulse</a> <a class="dropdown-item anim_type" ref-effect="rubberBand" href="javascript:void(0)"><i class="bi bi-bezier2"></i> Rubberband</a> <a class="dropdown-item anim_type" ref-effect="shakeX" href="javascript:void(0)"><i class="bi bi-bezier2"></i> Shake X</a> <a class="dropdown-item anim_type" ref-effect="shakeY" href="javascript:void(0)"><i class="bi bi-bezier2"></i> Shake Y</a> <a class="dropdown-item anim_type" ref-effect="jello" href="javascript:void(0)"><i class="bi bi-bezier2"></i> Jello</a> <a class="dropdown-item anim_type" ref-effect="tada" href="javascript:void(0)"><i class="bi bi-bezier2"></i> Tada</a></div></div><button class="btn btn-sm btn-white rounded-pill disableBlock" type="button"><i class="bi bi-slash-circle sz-sm"></i> Disable</button></div></div></div></div></div></div>';
  };
  var link_template = function (blockNum) {
    return (
      '<div class="block mb-2" id="link_' +
      blockNum +
      '"><div class="reorder-links"><div class="card mb-0 rounded-xl"><div class="card-body p-3 block-inputs"><div class="row"><div class="col-auto align-self-center p-0 h-100 d-none d-sm-block"><i class="bi bi-grip-vertical"></i></div>  <div class="col-auto align-self-center px-2 d-block d-sm-none" style="height:94px"><div class="btn-group-vertical h-100"><button type="button" class="btn btn-white p-0 move-up"><i class="bi bi-chevron-up"></i></button><button type="button" class="btn btn-white p-0 move-down"><i class="bi bi-chevron-down"></i></button></div></div><div class="col-auto pl-0"><div class="d-flex flex-column justify-content-center align-items-center"><div class="avatar avatar-md"><div class="avatar-title font-size-lg bg-primary-soft rounded-circle text-primary rounded-pill mr-2 domain-icon" ref-icon="link_' +
      blockNum +
      '"><i class="bi bi-link sz-24"></i></div><input type="file" class="d-none custom_domain_icon" name="link_' +
      blockNum +
      '[custom_icon]"></div></div><div class="custom-control custom-switch align-self-end mt-3"><input type="checkbox" class="custom-control-input toggle_thumbnail" id="thumbnail_toggle_' +
      blockNum +
      '" title="Remove thumbnail" checked> <label class="custom-control-label" for="thumbnail_toggle_' +
      blockNum +
      '"></label></div></div><div class="col ml-n3"><!-- Input --><div class="input-group input-group-merge"><input type="text" class="form-control form-control-flush form-control-auto block_title" value="" placeholder="Title" id="link_title_' +
      blockNum +
      '" name="link_' +
      blockNum +
      '[link_title]"><div class="input-group-prepend"><div class="input-group-text bg-transparent p-0 px-1 border-0"><i class="bi bi-type sz-18"></i></div></div></div><div class="input-group input-group-merge mt-2"><input type="url" class="form-control form-control-flush form-control-auto link_box block_domain" value="" placeholder="Page url" id="link_address_' +
      blockNum +
      '" name="link_' +
      blockNum +
      '[link_address]"><div class="input-group-prepend"><div class="input-group-text bg-transparent p-0 px-1 border-0"><i class="bi bi-link-45deg sz-18"></i></div></div></div><div class="medium-screen-setting-menu d-none d-md-block mt-2"><div class="d-flex"><div class="dropdown rounded-pill mr-2 bg-primary-soft priority_link_container"><button type="button" class="btn btn-sm text-primary dropdown-toggle" data-toggle="dropdown" ref-animation-effect="headShake"><i class="bi bi-asterisk sz-sm"></i> <span class="priority_link">Priority</span></button><div class="dropdown-menu position-absolute" style="z-index:999"><h6 class="dropdown-header animation_list">Choose animations</h6><a class="dropdown-item anim_type" ref-effect="none" href="javascript:void(0)"><i class="bi bi-bezier2"></i> None</a> <a class="dropdown-item anim_type" ref-effect="headShake" href="javascript:void(0)"><i class="bi bi-bezier2"></i> Default</a> <a class="dropdown-item anim_type" ref-effect="bounce" href="javascript:void(0)"><i class="bi bi-bezier2"></i> Bounce</a> <a class="dropdown-item anim_type" ref-effect="flash" href="javascript:void(0)"><i class="bi bi-bezier2"></i> Flash</a> <a class="dropdown-item anim_type" ref-effect="pulse" href="javascript:void(0)"><i class="bi bi-bezier2"></i> Pulse</a> <a class="dropdown-item anim_type" ref-effect="rubberBand" href="javascript:void(0)"><i class="bi bi-bezier2"></i> Rubberband</a> <a class="dropdown-item anim_type" ref-effect="shakeX" href="javascript:void(0)"><i class="bi bi-bezier2"></i> Shake X</a> <a class="dropdown-item anim_type" ref-effect="shakeY" href="javascript:void(0)"><i class="bi bi-bezier2"></i> Shake Y</a> <a class="dropdown-item anim_type" ref-effect="jello" href="javascript:void(0)"><i class="bi bi-bezier2"></i> Jello</a> <a class="dropdown-item anim_type" ref-effect="tada" href="javascript:void(0)"><i class="bi bi-bezier2"></i> Tada</a></div></div><button type="button" class="btn btn-sm bg-primary-soft text-primary rounded-pill mr-2 schedule_link">Schedule</button> <button type="button" class="btn btn-sm bg-primary-soft text-primary rounded-pill mr-2 forward_link">Leap</button> <button type="button" class="btn btn-sm btn-white rounded-pill disableBlock">Disable</button></div></div><div class="small-screen-setting-menu mt-2 d-flex d-block d-md-none"><div class="dropdown rounded-pill mr-2 bg-primary-soft priority_link_container"><button type="button" class="btn btn-sm text-primary dropdown-toggle" data-toggle="dropdown" ref-animation-effect="headShake"><span class="priority_link">Priority</span></button><div class="dropdown-menu position-absolute" style="z-index:999"><h6 class="dropdown-header animation_list">Choose animations</h6><a class="dropdown-item anim_type" ref-effect="none" href="javascript:void(0)"><i class="bi bi-bezier2"></i> None</a> <a class="dropdown-item anim_type" ref-effect="headShake" href="javascript:void(0)"><i class="bi bi-bezier2"></i> Default</a> <a class="dropdown-item anim_type" ref-effect="bounce" href="javascript:void(0)"><i class="bi bi-bezier2"></i> Bounce</a> <a class="dropdown-item anim_type" ref-effect="flash" href="javascript:void(0)"><i class="bi bi-bezier2"></i> Flash</a> <a class="dropdown-item anim_type" ref-effect="pulse" href="javascript:void(0)"><i class="bi bi-bezier2"></i> Pulse</a> <a class="dropdown-item anim_type" ref-effect="rubberBand" href="javascript:void(0)"><i class="bi bi-bezier2"></i> Rubberband</a> <a class="dropdown-item anim_type" ref-effect="shakeX" href="javascript:void(0)"><i class="bi bi-bezier2"></i> Shake X</a> <a class="dropdown-item anim_type" ref-effect="shakeY" href="javascript:void(0)"><i class="bi bi-bezier2"></i> Shake Y</a> <a class="dropdown-item anim_type" ref-effect="jello" href="javascript:void(0)"><i class="bi bi-bezier2"></i> Jello</a> <a class="dropdown-item anim_type" ref-effect="tada" href="javascript:void(0)"><i class="bi bi-bezier2"></i> Tada</a></div></div><div class="dropdown"><a class="btn btn-white dropdown-toggle btn-sm rounded-pill" href="javascript:void(0)" data-toggle="dropdown">Settings</a><div class="dropdown-menu"><h6 class="dropdown-header">Select options</h6><a class="dropdown-item schedule_link" href="javascript:void(0)"><i class="mr-2 bi bi-calendar3-range"></i> Schedule link</a> <a class="dropdown-item forward_link" href="javascript:void(0)"><i class="mr-2 bi bi-arrow-return-right"></i> Leap</a> <a class="dropdown-item" href="javascript:void(0)"><i class="mr-2 bi bi-slash-circle"></i> <span class="disableBlock">Disable</span></a></div></div></div></div><div class="col-auto align-self-start"><div class="text-muted"><button class="btn btn-sm btn-white-soft outline-none removeBlock" type="button"><i class="bi bi-x-circle sz-18"></i></button></div></div></div><div class="link-media-preview"></div></div></div></div></div>'
    );
  };

  function publishPage() {
    let cancelToken;
    let pageName = $(".link_page_name").val();

    //Save the cancel token for the current request
    cancelToken = axios.CancelToken.source();

    //Check if there are any previous pending requests

    //Grabbing form for submission
    var form = document.querySelector(".send-request");

    const formData = new FormData(form);
    formData.append("page_name", pageName);

    return axios
      .post("controllers/Handlers/page.publish.Handler.php", formData, {
        cancelToken: cancelToken.token, //Register a cancel token
      })
      .then(function (response) {
        $(".page-visit-link").html(response.data);
        // if (typeof cancelToken != typeof undefined) {
        cancelToken.cancel("Operation canceled due to new request.");
        // }
      })
      .catch(function (response) {});
  }
  //Anonymus chats
  $("body").on("click", ".chat_anonymously", function () {
    if (anonymus_chat_used >= 1) {
      anonymus_chat_used = 0;
      $("#anonymus_chat").remove();
      $(".layout-anonymus")[0].classList.remove("form-added");
    } else {
      // Updating Form status
      anonymus_chat_used = 1;

      $(".blocks").prepend(anonymus_chat_template);
      $(".count_links").html($(".block").length);
      $(".layout-anonymus")[0].classList.add("form-added");
      Snackbar.show({
        pos: "top-center",
        text: "Anonymus chat installed 😊",
      });
    }
  });
  //Feedback
  $("body").on("click", ".feedback_collector", function () {
    if (feedback_collector_used >= 1) {
      feedback_collector_used = 0;
      $("#feedback_collector").remove();
      $(".layout-feedback")[0].classList.remove("form-added");
    } else {
      // Updating Form status
      feedback_collector_used = 1;

      $(".blocks").prepend(feedback_collector_template);
      $(".count_links").html($(".block").length);
      $(".layout-feedback")[0].classList.add("form-added");
      Snackbar.show({
        pos: "top-center",
        text: "You can use only one feedback in a page 😊",
      });
    }
  });

  // Form

  $("body").on("click", ".information_collector", function () {
    //Checking if Form is used previously
    if (information_collector_used >= 1) {
      information_collector_used = 0;
      $("#information_collector").remove();
      $(".layout-form")[0].classList.remove("form-added");
    } else {
      // Updating Form status
      information_collector_used = 1;

      $(".blocks").prepend(information_collector_template);
      $(".count_links").html($(".block").length);
      $(".layout-form")[0].classList.add("form-added");
      Snackbar.show({
        pos: "top-center",
        text: "You can use only one form in a page 😊",
      });
    }
  });
  $(".link_container").on("click", ".add_new_link", function () {
    blockNum++;
    $(".blocks").prepend(link_template(blockNum));
    $(".count_links").html($(".block").length);
  });
  $(".link_container").on("click", ".removeInput", function () {
    if ($(this).closest(".block").find(".input-group").length == 1) {
      $(this).closest(".block").find(".block-inputs").before(confirmDialog);
    } else {
      $(this).closest(".form-group-item").remove();
    }
    updateData();
    publishPage();
  });
  $(".link_container").on("click", ".removeBlock", function () {
    // $(this).closest('.block').remove();

    $(".count_links").html($(".block").length);
    $(this).closest(".block").find(".block-inputs").before(confirmDialog);
    updateData();
  });
  $(".blocks").on("click", ".confirm-delete", function () {
    //Update Form used as 0
    if ($(this).closest(".block").attr("id") === "information_collector") {
      information_collector_used = 0;
      $(".layout-form")[0].classList.remove("form-added");
    }
    if ($(this).closest(".block").attr("id") === "feedback_collector") {
      feedback_collector_used = 0;
      $(".layout-feedback")[0].classList.remove("form-added");
    }

    $(this).closest(".block").remove();
    if ($(".block").length < 1) {
      $(".add_new_link").click();
    }
    updateData();

    $(".count_links").html($(".block").length);
  });
  $(".blocks").on("click", ".cancel-delete", function () {
    $(this).closest(".dialog-overlay").remove();
  });
  $(".blocks").on("click", ".domain-icon", function () {
    $(this).closest(".block").find(".custom_domain_icon").click();
    // $('#staticBackdrop').modal('show')
  });

  // Initialize reader in gloval scope
  var reader = new FileReader();

  // Set valid file types
  var match = ["image/jpeg", "image/png", "image/jpg"];

  /**File attachments handler for question */
  $(`.blocks`).on("change", ".custom_domain_icon", function (custom_icon) {
    var file = this.files[0];
    var fileType = file.type;
    if (
      !(fileType == match[0] || fileType == match[1] || fileType == match[2])
    ) {
      alert("Sorry, only JPG, JPEG, & PNG files are allowed to upload.");
      return false;
    } else {
      reader.onload = function (e) {
        $(".blocks")
          .find(custom_icon.target)
          .closest(".block")
          .find(".domain-icon")
          .html(
            `<img class="avatar-img rounded-circle" src ="${e.target.result}" />`
          );
        $(".live_preview")
          .find(
            `.${$(".blocks")
              .find(custom_icon.target)
              .closest(".block")
              .find(".domain-icon")
              .attr("ref-icon")}_domain_icon`
          )
          .html(
            `<img class="avatar-img rounded-circle" src ="${e.target.result}" />`
          );
        // $('.live_preview').find('.link_1_domain_icon').html(`<img class="avatar-img rounded-circle" src ="${e.target.result}" />`);
        // $('.blocks').find(custom_icon.target).closest('.block').find(".question-attachment-data").val(e.target.result);
        // console.log($('.blocks').find(custom_icon.target).closest('.block'));
      };
      reader.readAsDataURL(file);
    }
  });

  $(".blocks").on("keyup", ".block", function (element) {
    //Fetch favicon of the address
    if (element.target.classList.contains("link_box")) {
      if (!element.target.value == "") {
        addFavicon(
          $(this).find(".domain-icon"),
          parseUri($(this).find(".link_box").val()).authority
        );
        // quality options: low, medium, high, max | default is max.
        var v_id = create_preview(element.target.value);
        if (v_id) {
          $(this).closest(".block").find(".link-media-preview").html(`
          <div class="d-flex justify-content-center p-5">
            <div class="spinner-border text-primary" role="status">
              <span class="sr-only">Loading...</span>
            </div>
          </div>`);
          var set_preview_for = $(this).closest(".block").attr("id");
          setTimeout(function () {
            $(this)
              .closest(".block")
              .find(".link-media-preview")
              .html(link_media_preview_template(set_preview_for, v_id));
          }, 1000);
        } else {
          $(this).closest(".block").find(".link-media-preview").html(``);
        }
        // updateData();
      }
    }
    // publishPage();
  });
  //Bind turn off event
  $(".blocks").on("click", ".toggle_link_preview", function () {
    console.log($(this).closest(".block").find(".link_preview_off").length);
    if ($(this).closest(".block").find(".link_preview_off").length > 0) {
      $(this).closest(".block").find(".link_preview_off").remove(),
        $(this).removeClass("bg-danger-soft text-danger"),
        $(this).closest(".block").find(".link_preview_enabled").html(`
          <i class="bi bi-eye p-0 m-0"></i>
          <span class="link_preview_enabled">Turned on</span>
          `);
    } else {
      $(this).addClass("bg-danger-soft text-danger"),
        $(this).closest(".block").find(".link_preview_enabled").html(`
          <i class="bi bi-eye-slash p-0 m-0"></i>
          <span class="link_preview_enabled">Turned off</span>
          `);
      $(this)
        .closest(".block-inputs")
        .append(
          create_object(
            "text",
            "off",
            `name="${$(this)
              .closest(".block")
              .attr("id")}[link_preview]" class="d-none link_preview_off"`
          )
        );
    }
  });

  function move_up(elem) {
    elem.insertBefore(elem.prev());
    // publishPage();
  }

  function move_down(elem) {
    elem.insertAfter(elem.next());
    // publishPage();
  }
  $(".publish_page").on("click", function () {
    publishPage();
  });
  //Moving block up

  $(".blocks").on("click", ".move-up", function (e) {
    move_up($(this).closest(".block"));
    // Animating slide up
    $("html, body").animate(
      {
        scrollTop: $($(this).closest(".block")).offset().top - 150,
      },
      300
    );
  });

  //Moving Block Down

  $(".blocks").on("click", ".move-down", function (e) {
    move_down($(this).closest(".block"));
    // Animating slide down
    $("html, body").animate(
      {
        scrollTop: $($(this).closest(".block")).offset().top - 150,
      },
      300
    );
  });

  function create_preview(url) {
    if (url) {
      //Intializing variables

      var output, result;

      //Check for youtube videos
      if ((result = url.match(/youtube\.com.*(\?v=|\/embed\/)(.{11})/))) {
        output = result.pop();
        output = `//www.youtube.com/embed/${output}`;
      } else if ((result = url.match(/youtu.be\/(.{11})/))) {
        output = result.pop();
        output = `//www.youtube.com/embed/${output}`;

        //Check for vimeo videos
      } else if ((result = url.match(/vimeo\.com.*[\\\/](\d+)/))) {
        output = result.pop();
        output = `//player.vimeo.com/video/${output}`;

        //Check for Google maps
      } else if (
        (result = url.match(/google\.com\/maps\/.*(\@[\d\.]+,-?[\d\.]+)/))
      ) {
        output = result.pop();
        var g_map_z = url.match(/google\.com\/maps\/.*([\d\.])/);
        output = `//maps.google.com/maps?q=${result}&z=${g_map_z.pop()}&output=embed`;

        //Check for Spotify Music
      } else if ((result = url.match(/(open\.spotify\.com)/))) {
        output = `//open.spotify.com/embed/playlist/${MediaFormat().getSpotifyID(
          url
        )}`;
      }
      if (output) {
        return output;
      }
    }
    return false;
  }
  /**
   * MediaFormat
   * format and return only needed pieces of media from their public sources
   * Author: Trevor Clarke
   */
  function MediaFormat() {
    // http://www.youtube.com/embed/m5yCOSHeYn4
    var ytRegEx = /^(?:https?:\/\/)?(?:i\.|www\.|img\.)?(?:youtu\.be\/|youtube\.com\/|ytimg\.com\/)(?:embed\/|v\/|vi\/|vi_webp\/|watch\?v=|watch\?.+&v=)((\w|-){11})(?:\S+)?$/;
    // http://vimeo.com/3116167, https://player.vimeo.com/video/50489180, http://vimeo.com/channels/3116167, http://vimeo.com/channels/staffpicks/113544877
    var vmRegEx = /https?:\/\/(?:vimeo\.com\/|player\.vimeo\.com\/)(?:video\/|(?:channels\/staffpicks\/|channels\/)|)((\w|-){7,9})/;
    // http://open.spotify.com/track/06TYfe9lyGQA6lfqo5szIi, https://embed.spotify.com/?uri=spotify:track:78z8O6X1dESVSwUPAAPdme
    var spRegEx = /https?:\/\/(?:embed\.|open\.)(?:spotify\.com\/)(?:track\/|\?uri=spotify:track:)((\w|-){22})/;
    // https://soundcloud.com/aviciiofficial/avicii-you-make-me-diplo-remix, https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/29395900&amp;color=ff5500&amp;auto_play=false&amp;hide_related=false&amp;show_comments=true&amp;show_user=true&amp;show_reposts=false
    var scRegEx = /https?:\/\/(?:w\.|www\.|)(?:soundcloud\.com\/)(?:(?:player\/\?url=https\%3A\/\/api.soundcloud.com\/tracks\/)|)(((\w|-)[^A-z]{7})|([A-Za-z0-9]+(?:[-_][A-Za-z0-9]+)*(?!\/sets(?:\/|$))(?:\/[A-Za-z0-9]+(?:[-_][A-Za-z0-9]+)*){1,2}))/;

    function getIDfromRegEx(src, regExpy) {
      return src.match(regExpy) ? RegExp.$1 : null;
    }

    return {
      // returns only the ID
      getYoutubeID: function (src) {
        return getIDfromRegEx(src, ytRegEx);
      },
      // returns main link
      getYoutubeUrl: function (ID) {
        return "https://www.youtube.com/watch?v=" + ID;
      },
      // returns only the ID
      getVimeoID: function (src) {
        return getIDfromRegEx(src, vmRegEx);
      },
      // returns main link
      getVimeoUrl: function (ID) {
        return "http://vimeo.com/" + ID;
      },
      // returns only the ID
      getSpotifyID: function (src) {
        return getIDfromRegEx(src, spRegEx);
      },
      // returns main link
      getSpotifyUrl: function (ID) {
        return "http://open.spotify.com/track/" + ID;
      },
      // returns only the ID
      getSoundcloudID: function (src) {
        return getIDfromRegEx(src, scRegEx);
      },
      // returns main link
      // NOTE: this one really sucks since soundcloud doesnt have good API without js library
      getSoundcloudUrl: function (ID) {},
    };
  }
}
