function Links() {
  function e() {
    $(".blocks > .block").remove(), $(".blocks").append(p);
  }
  function o(e = "text", o, t) {
    return '<input type="' + e + '" value="' + o + '" ' + t + " />";
  }
  function t() {
    b.reIndex(), b.update();
    var e = $(m).serializeControls(),
      o = "";
    for (var t in e)
      if (e.hasOwnProperty(t)) {
        var i = e[t];
        void 0 === i.link_title ||
        void 0 === i.link_address ||
        void 0 === i.domain_icon ||
        i.disabled
          ? delete e[t]
          : (1 == !i.thumbnail_off
              ? (domain_favicon =
                  '<div class="col-auto mr-2"><div class="avatar avatar-xs ${key}_domain_icon"><img class="avatar-img rounded-circle" src="' +
                  i.domain_icon +
                  '"></div></div>')
              : (domain_favicon = ""),
            i.priority && "true" === i.priority.enabled
              ? (priority_effect =
                  "animate__animated animate__" +
                  i.priority.effect +
                  " animate__infinite animate__slow")
              : (priority_effect = ""),
            (o +=
              '<div class="card m-3 rounded ' +
              priority_effect +
              '"><div class="p-2"><div class="row align-items-center no-gutters"><a class="stretched-link" target="_blank" href="' +
              i.link_address +
              '"></a>' +
              domain_favicon +
              '<div class="col text-truncate"><h6 class="text-uppercase text-muted mb-1">' +
              a(i.link_address).authority +
              '</h6><span class="h4 mb-0">' +
              i.link_title +
              '</span></div><div class="col-auto ml-n1"><i class="bi bi-chevron-right text-muted mb-0"></i></div></div></div></div>'));
      }
    $(".live_preview").html(o);
  }
  function i(e, o) {
    if (!e.hasAttr("dif")) {
      var i,
        a = 0;
      (o = o
        .replace(/^(?:https?:\/\/)?(?:www\.)?/i, "")
        .split("/")[0]
        .toLowerCase()),
        e.html(
          '<div class="spinner-grow"><span class="sr-only">Loading...</span></div>'
        );
      const n = axios.CancelToken.source();
      return axios
        .get("https://api.faviconkit.com/" + o + "/144", {
          cancelToken: n.token,
        })
        .then(function (n) {
          if (200 === n.status) {
            if (0 === a)
              return (
                (i = "https://api.faviconkit.com/" + o + "/144"),
                e.html(
                  '<img class="avatar-img rounded-circle" src ="' +
                    i +
                    '" title="Verified"/><input type="hidden" name="' +
                    $(e).attr("ref-icon") +
                    '[domain_icon]" value="' +
                    i +
                    '" />'
                ),
                e.attr("dif", "f"),
                $(e)
                  .closest(".avatar")
                  .removeClass("avatar-offline")
                  .addClass("avatar-online"),
                t(),
                null == i || "" == i ? void (a = 1) : void 0
              );
            if (
              1 === a &&
              ((i = n.data.icons[0].src),
              e.html(
                '<img class="avatar-img rounded-circle" src ="' +
                  i +
                  '" title="Verified"/><input type="hidden" name="' +
                  $(e).attr("ref-icon") +
                  '[domain_icon]" value="' +
                  i +
                  '" />'
              ),
              e.attr("dif", "f"),
              $(e)
                .closest(".avatar")
                .removeClass("avatar-offline")
                .addClass("avatar-online"),
              t(),
              null == i || "" == i)
            )
              return void (a = 2);
            if (2 === a)
              return (
                (i = "http://www.google.com/s2/favicons?domain=" + o),
                e.html(
                  '<img class="avatar-img rounded-circle" src ="' +
                    i +
                    '" title="Verified"/><input type="hidden" name="' +
                    $(e).attr("ref-icon") +
                    '[domain_icon]" value="' +
                    i +
                    '" />'
                ),
                e.attr("dif", "f"),
                $(e)
                  .closest(".avatar")
                  .removeClass("avatar-offline")
                  .addClass("avatar-online"),
                t(),
                null == i || "" == i ? void (a = 3) : void 0
              );
            if (3 === a)
              return (
                (i = "http://" + o + "/favicon.ico"),
                e.html(
                  '<img class="avatar-img rounded-circle" src ="' +
                    i +
                    '" title="Verified"/><input type="hidden" name="' +
                    $(e).attr("ref-icon") +
                    '[domain_icon]" value="' +
                    i +
                    '" />'
                ),
                e.attr("dif", "f"),
                $(e)
                  .closest(".avatar")
                  .removeClass("avatar-offline")
                  .addClass("avatar-online"),
                t(),
                null == i || "" == i ? void (a = 4) : void 0
              );
          }
        })
        .catch(function (n) {
          var l = n.toString();
          l.indexOf("Error") > -1 || l.indexOf("404") > -1 || l.indexOf("400"),
            (a = 4),
            4 === a &&
              ((i =
                "https://via.placeholder.com/200/D62D20/FFFFFF?text=" +
                o.substring(0, 1)),
              e.html(
                '<img class="avatar-img rounded-circle" src ="' +
                  i +
                  '"  title="Could not verify link"/><input type="hidden" name="' +
                  $(e).attr("ref-icon") +
                  '[domain_icon]" value="' +
                  i +
                  '" />'
              ),
              $(e).closest(".avatar").addClass("avatar-offline"),
              e.attr("dinf"),
              t(),
              (a = 0));
        });
    }
  }
  function a(e) {
    for (
      var o = a.options,
        t = o.parser[o.strictMode ? "strict" : "loose"].exec(e),
        i = {},
        n = 14;
      n--;

    )
      i[o.key[n]] = t[n] || "";
    return (
      (i[o.q.name] = {}),
      i[o.key[12]].replace(o.q.parser, function (e, t, a) {
        t && (i[o.q.name][t] = a);
      }),
      i
    );
  }
  function n() {
    let e,
      o = $(".link_page_name").val();
    e = axios.CancelToken.source();
    var t = document.querySelector(".send-request");
    const i = new FormData(t);
    return (
      i.append("page_name", o),
      axios
        .post("controllers/Handlers/page.publish.Handler.php", i, {
          cancelToken: e.token,
        })
        .then(function (o) {
          Snackbar.show({
            pos: "top-center",
            text: "Page updated",
          }),
            $(".page-visit-link").html(o.data),
            e.cancel("Operation canceled due to new request.");
        })
        .catch(function (e) {})
    );
  }
  function l(e) {
    e.insertBefore(e.prev());
  }
  function s(e) {
    e.insertAfter(e.next());
  }
  function r(e) {
    if (e) {
      var o, t;
      if ((t = e.match(/youtube\.com.*(\?v=|\/embed\/)(.{11})/)))
        (o = t.pop()), (o = `//www.youtube.com/embed/${o}`);
      else if ((t = e.match(/youtu.be\/(.{11})/)))
        (o = t.pop()), (o = `//www.youtube.com/embed/${o}`);
      else if ((t = e.match(/vimeo\.com.*[\\\/](\d+)/)))
        (o = t.pop()), (o = `//player.vimeo.com/video/${o}`);
      else if ((t = e.match(/google\.com\/maps\/.*(\@[\d\.]+,-?[\d\.]+)/))) {
        o = t.pop();
        var i = e.match(/google\.com\/maps\/.*([\d\.])/);
        o = `//maps.google.com/maps?q=${t}&z=${i.pop()}&output=embed`;
      } else
        (t = e.match(/(open\.spotify\.com)/)) &&
          (o = `//open.spotify.com/embed/playlist/${c().getSpotifyID(e)}`);
      if (o) return o;
    }
    return !1;
  }
  function c() {
    function e(e, o) {
      return e.match(o) ? RegExp.$1 : null;
    }
    var o = /^(?:https?:\/\/)?(?:i\.|www\.|img\.)?(?:youtu\.be\/|youtube\.com\/|ytimg\.com\/)(?:embed\/|v\/|vi\/|vi_webp\/|watch\?v=|watch\?.+&v=)((\w|-){11})(?:\S+)?$/,
      t = /https?:\/\/(?:vimeo\.com\/|player\.vimeo\.com\/)(?:video\/|(?:channels\/staffpicks\/|channels\/)|)((\w|-){7,9})/,
      i = /https?:\/\/(?:embed\.|open\.)(?:spotify\.com\/)(?:track\/|\?uri=spotify:track:)((\w|-){22})/,
      a = /https?:\/\/(?:w\.|www\.|)(?:soundcloud\.com\/)(?:(?:player\/\?url=https\%3A\/\/api.soundcloud.com\/tracks\/)|)(((\w|-)[^A-z]{7})|([A-Za-z0-9]+(?:[-_][A-Za-z0-9]+)*(?!\/sets(?:\/|$))(?:\/[A-Za-z0-9]+(?:[-_][A-Za-z0-9]+)*){1,2}))/;
    return {
      getYoutubeID: function (t) {
        return e(t, o);
      },
      getYoutubeUrl: function (e) {
        return "https://www.youtube.com/watch?v=" + e;
      },
      getVimeoID: function (o) {
        return e(o, t);
      },
      getVimeoUrl: function (e) {
        return "http://vimeo.com/" + e;
      },
      getSpotifyID: function (o) {
        return e(o, i);
      },
      getSpotifyUrl: function (e) {
        return "http://open.spotify.com/track/" + e;
      },
      getSoundcloudID: function (o) {
        return e(o, a);
      },
      getSoundcloudUrl: function (e) {},
    };
  }
  var d =
    "<option value='Pacific/Midway'>(UTC-11:00) Midway Island </option><option value='Pacific/Samoa'>(UTC-11:00) Samoa </option><option value='Pacific/Honolulu'>(UTC-10:00) Hawaii </option><option value='US/Alaska'>(UTC-09:00) Alaska </option><option value='America/Los_Angeles'>(UTC-08:00) Pacific Time (US &amp; Canada) </option><option value='America/Tijuana'>(UTC-08:00) Tijuana </option><option value='US/Arizona'>(UTC-07:00) Arizona </option><option value='America/Chihuahua'>(UTC-07:00) Chihuahua </option><option value='America/Chihuahua'>(UTC-07:00) La Paz </option><option value='America/Mazatlan'>(UTC-07:00) Mazatlan </option><option value='US/Mountain'>(UTC-07:00) Mountain Time (US &amp; Canada) </option><option value='America/Managua'>(UTC-06:00) Central America </option><option value='US/Central'>(UTC-06:00) Central Time (US &amp; Canada) </option><option value='America/Mexico_City'>(UTC-06:00) Guadalajara </option><option value='America/Mexico_City'>(UTC-06:00) Mexico City </option><option value='America/Monterrey'>(UTC-06:00) Monterrey </option><option value='Canada/Saskatchewan'>(UTC-06:00) Saskatchewan </option><option value='America/Bogota'>(UTC-05:00) Bogota </option><option value='US/Eastern'>(UTC-05:00) Eastern Time (US &amp; Canada) </option><option value='US/East-Indiana'>(UTC-05:00) Indiana (East) </option><option value='America/Lima'>(UTC-05:00) Lima </option><option value='America/Bogota'>(UTC-05:00) Quito </option><option value='Canada/Atlantic'>(UTC-04:00) Atlantic Time (Canada) </option><option value='America/Caracas'>(UTC-04:30) Caracas </option><option value='America/La_Paz'>(UTC-04:00) La Paz </option><option value='America/Santiago'>(UTC-04:00) Santiago </option><option value='Canada/Newfoundland'>(UTC-03:30) Newfoundland </option><option value='America/Sao_Paulo'>(UTC-03:00) Brasilia </option><option value='America/Argentina/Buenos_Aires'>(UTC-03:00) Buenos Aires </option><option value='America/Argentina/Buenos_Aires'>(UTC-03:00) Georgetown </option><option value='America/Godthab'>(UTC-03:00) Greenland </option><option value='America/Noronha'>(UTC-02:00) Mid-Atlantic </option><option value='Atlantic/Azores'>(UTC-01:00) Azores </option><option value='Atlantic/Cape_Verde'>(UTC-01:00) Cape Verde Is. </option><option value='Africa/Casablanca'>(UTC+00:00) Casablanca </option><option value='Europe/London'>(UTC+00:00) Edinburgh </option><option value='Etc/Greenwich'>(UTC+00:00) Greenwich Mean Time : Dublin </option><option value='Europe/Lisbon'>(UTC+00:00) Lisbon </option><option value='Europe/London'>(UTC+00:00) London </option><option value='Africa/Monrovia'>(UTC+00:00) Monrovia </option><option value='UTC'>(UTC+00:00) UTC </option><option value='Europe/Amsterdam'>(UTC+01:00) Amsterdam </option><option value='Europe/Belgrade'>(UTC+01:00) Belgrade </option><option value='Europe/Berlin'>(UTC+01:00) Berlin </option><option value='Europe/Berlin'>(UTC+01:00) Bern </option><option value='Europe/Bratislava'>(UTC+01:00) Bratislava </option><option value='Europe/Brussels'>(UTC+01:00) Brussels </option><option value='Europe/Budapest'>(UTC+01:00) Budapest </option><option value='Europe/Copenhagen'>(UTC+01:00) Copenhagen </option><option value='Europe/Ljubljana'>(UTC+01:00) Ljubljana </option><option value='Europe/Madrid'>(UTC+01:00) Madrid </option><option value='Europe/Paris'>(UTC+01:00) Paris </option><option value='Europe/Prague'>(UTC+01:00) Prague </option><option value='Europe/Rome'>(UTC+01:00) Rome </option><option value='Europe/Sarajevo'>(UTC+01:00) Sarajevo </option><option value='Europe/Skopje'>(UTC+01:00) Skopje </option><option value='Europe/Stockholm'>(UTC+01:00) Stockholm </option><option value='Europe/Vienna'>(UTC+01:00) Vienna </option><option value='Europe/Warsaw'>(UTC+01:00) Warsaw </option><option value='Africa/Lagos'>(UTC+01:00) West Central Africa </option><option value='Europe/Zagreb'>(UTC+01:00) Zagreb </option><option value='Europe/Athens'>(UTC+02:00) Athens </option><option value='Europe/Bucharest'>(UTC+02:00) Bucharest </option><option value='Africa/Cairo'>(UTC+02:00) Cairo </option><option value='Africa/Harare'>(UTC+02:00) Harare </option><option value='Europe/Helsinki'>(UTC+02:00) Helsinki </option><option value='Europe/Istanbul'>(UTC+02:00) Istanbul </option><option value='Asia/Jerusalem'>(UTC+02:00) Jerusalem </option><option value='Europe/Helsinki'>(UTC+02:00) Kyiv </option><option value='Africa/Johannesburg'>(UTC+02:00) Pretoria </option><option value='Europe/Riga'>(UTC+02:00) Riga </option><option value='Europe/Sofia'>(UTC+02:00) Sofia </option><option value='Europe/Tallinn'>(UTC+02:00) Tallinn </option><option value='Europe/Vilnius'>(UTC+02:00) Vilnius </option><option value='Asia/Baghdad'>(UTC+03:00) Baghdad </option><option value='Asia/Kuwait'>(UTC+03:00) Kuwait </option><option value='Europe/Minsk'>(UTC+03:00) Minsk </option><option value='Africa/Nairobi'>(UTC+03:00) Nairobi </option><option value='Asia/Riyadh'>(UTC+03:00) Riyadh </option><option value='Europe/Volgograd'>(UTC+03:00) Volgograd </option><option value='Asia/Tehran'>(UTC+03:30) Tehran </option><option value='Asia/Muscat'>(UTC+04:00) Abu Dhabi </option><option value='Asia/Baku'>(UTC+04:00) Baku </option><option value='Europe/Moscow'>(UTC+04:00) Moscow </option><option value='Asia/Muscat'>(UTC+04:00) Muscat </option><option value='Europe/Moscow'>(UTC+04:00) St. Petersburg </option><option value='Asia/Tbilisi'>(UTC+04:00) Tbilisi </option><option value='Asia/Yerevan'>(UTC+04:00) Yerevan </option><option value='Asia/Kabul'>(UTC+04:30) Kabul </option><option value='Asia/Karachi'>(UTC+05:00) Islamabad </option><option value='Asia/Karachi'>(UTC+05:00) Karachi </option><option value='Asia/Tashkent'>(UTC+05:00) Tashkent </option><option value='Asia/Calcutta'>(UTC+05:30) Chennai </option><option value='Asia/Kolkata'>(UTC+05:30) Kolkata </option><option value='Asia/Calcutta'>(UTC+05:30) Mumbai </option><option value='Asia/Calcutta'>(UTC+05:30) New Delhi </option><option value='Asia/Calcutta'>(UTC+05:30) Sri Jayawardenepura </option><option value='Asia/Katmandu'>(UTC+05:45) Kathmandu </option><option value='Asia/Almaty'>(UTC+06:00) Almaty </option><option value='Asia/Dhaka'>(UTC+06:00) Astana </option><option value='Asia/Dhaka'>(UTC+06:00) Dhaka </option><option value='Asia/Yekaterinburg'>(UTC+06:00) Ekaterinburg </option><option value='Asia/Rangoon'>(UTC+06:30) Rangoon </option><option value='Asia/Bangkok'>(UTC+07:00) Bangkok </option><option value='Asia/Bangkok'>(UTC+07:00) Hanoi </option><option value='Asia/Jakarta'>(UTC+07:00) Jakarta </option><option value='Asia/Novosibirsk'>(UTC+07:00) Novosibirsk </option><option value='Asia/Hong_Kong'>(UTC+08:00) Beijing </option><option value='Asia/Chongqing'>(UTC+08:00) Chongqing </option><option value='Asia/Hong_Kong'>(UTC+08:00) Hong Kong </option><option value='Asia/Krasnoyarsk'>(UTC+08:00) Krasnoyarsk </option><option value='Asia/Kuala_Lumpur'>(UTC+08:00) Kuala Lumpur </option><option value='Australia/Perth'>(UTC+08:00) Perth </option><option value='Asia/Singapore'>(UTC+08:00) Singapore </option><option value='Asia/Taipei'>(UTC+08:00) Taipei </option><option value='Asia/Ulan_Bator'>(UTC+08:00) Ulaan Bataar </option><option value='Asia/Urumqi'>(UTC+08:00) Urumqi </option><option value='Asia/Irkutsk'>(UTC+09:00) Irkutsk </option><option value='Asia/Tokyo'>(UTC+09:00) Osaka </option><option value='Asia/Tokyo'>(UTC+09:00) Sapporo </option><option value='Asia/Seoul'>(UTC+09:00) Seoul </option><option value='Asia/Tokyo'>(UTC+09:00) Tokyo </option><option value='Australia/Adelaide'>(UTC+09:30) Adelaide </option><option value='Australia/Darwin'>(UTC+09:30) Darwin </option><option value='Australia/Brisbane'>(UTC+10:00) Brisbane </option><option value='Australia/Canberra'>(UTC+10:00) Canberra </option><option value='Pacific/Guam'>(UTC+10:00) Guam </option><option value='Australia/Hobart'>(UTC+10:00) Hobart </option><option value='Australia/Melbourne'>(UTC+10:00) Melbourne </option><option value='Pacific/Port_Moresby'>(UTC+10:00) Port Moresby </option><option value='Australia/Sydney'>(UTC+10:00) Sydney </option><option value='Asia/Yakutsk'>(UTC+10:00) Yakutsk </option><option value='Asia/Vladivostok'>(UTC+11:00) Vladivostok </option><option value='Pacific/Auckland'>(UTC+12:00) Auckland </option><option value='Pacific/Fiji'>(UTC+12:00) Fiji </option><option value='Pacific/Kwajalein'>(UTC+12:00) International Date Line West </option><option value='Asia/Kamchatka'>(UTC+12:00) Kamchatka </option><option value='Asia/Magadan'>(UTC+12:00) Magadan </option><option value='Pacific/Fiji'>(UTC+12:00) Marshall Is. </option><option value='Asia/Magadan'>(UTC+12:00) New Caledonia </option><option value='Asia/Magadan'>(UTC+12:00) Solomon Is. </option><option value='Pacific/Auckland'>(UTC+12:00) Wellington </option><option value='Pacific/Tongatapu'>(UTC+13:00) Nuku'alofa </option";
  let p = [];
  $(document).bind("DOMNodeInserted", function () {
    $('[data-toggle="tooltip"]').tooltip(),
      (previous_configuration = $(".blocks").html()),
      localStorage.setItem("DOMELEMENTS", previous_configuration);
    let e = document.querySelectorAll("[toggle-relative]");
    e.forEach(function (e) {
      e.addEventListener("click", function () {
        let o = e.getAttribute("toggle-relative"),
          t = document.querySelector('[relative-id="' + o + '"]'),
          i = t.getAttribute("relative-func");
        if (e.checked) {
          if (null === t && null === i)
            return void console.warn("relative-id [" + o + '"] not found');
          if (i) {
            i.split("(")[0], i.split("(")[1].split(")")[0];
          }
          t.style.display = null;
        } else {
          if (null === t && null === relative_func)
            return void console.warn("relative-id #" + o + " not found");
          t.style.display = "none";
        }
      });
    });
  }),
    localStorage.getItem("DOMELEMENTS") &&
      "undefined" !== localStorage.getItem("DOMELEMENTS") &&
      (confirm("Want to recover from where you left?")
        ? $(".blocks").html(localStorage.getItem("DOMELEMENTS"))
        : localStorage.removeItem("DOMELEMENTS"));
  var u = {
    valueNames: [
      { attr: "value", name: "block_title" },
      { attr: "value", name: "link_box" },
    ],
  };
  let b = new List("send-request", u);
  (p = $(".blocks > .block")),
    $("#send-request").on(
      "change",
      "input[type=text], input[type=url]",
      function (e) {
        (p = $(".blocks > .block")),
          e.target.setAttribute("value", e.target.value),
          b.reIndex(),
          b.update();
      }
    ),
    $("#filter-links").on("keypress", function () {
      let e = $(this).val();
      b.fuzzySearch(e);
    }),
    $("#sort-asc").on("click", function () {
      $(this).val();
      b.sort("block_title", {
        order: "asc",
        alphabet: "ABCDEFGHIJKLMNOPQRSTUVXYZÅÄÖabcdefghijklmnopqrstuvxyzåäö",
      }),
        t();
    }),
    $("#sort-desc").on("click", function () {
      $(this).val();
      b.sort("block_title", {
        order: "desc",
        alphabet: "ABCDEFGHIJKLMNOPQRSTUVXYZÅÄÖabcdefghijklmnopqrstuvxyzåäö",
      }),
        t();
    }),
    $("#reset-sorting").on("click", function () {
      e(), t();
    }),
    $(window).scroll(function () {
      let e = $(".right_panel").parent().width(),
        o = Math.ceil($("#topbar").outerHeight(!0));
      $(window).scrollTop() > o &&
        ($(".right_panel").width(e), $(".right_panel").addClass("stick-top")),
        $(window).scrollTop() < o + 1 &&
          ($(".right_panel").width(e),
          $(".right_panel").removeClass("stick-top"));
    }),
    window.addEventListener("keypress", function (e) {
      e.ctrlKey &&
        ((17 !== e.which && 17 !== e.key) ||
          ($("#profile-tab").hasClass("active")
            ? $("#layouts-tab").click()
            : $("#profile-tab").click()));
    });
  var m = document.querySelector(".send-request"),
    f = $(m).serializeControls();
  let v,
    h = 0,
    k = 0,
    g = 0;
  $(".blocks").on("click", "#show_username", function () {
    $(this).closest(".block").find(".s_m_u_enabled").length > 0
      ? $(this).closest(".block").find(".s_m_u_enabled").remove()
      : $(this)
          .closest(".block")
          .find(".block-inputs")
          .append(
            o(
              "text",
              "true",
              'name="chat[features][show_my_username]" class="d-none s_m_u_enabled"'
            )
          );
  }),
    $(".blocks").on("click", "#force_login", function () {
      $(this).closest(".block").find(".f_login_enabled").length > 0
        ? $(this).closest(".block").find(".f_login_enabled").remove()
        : $(this)
            .closest(".block")
            .find(".block-inputs")
            .append(
              o(
                "text",
                "true",
                'name="chat[features][force_login]" class="d-none f_login_enabled"'
              )
            );
    }),
    $(".blocks").on("click", "#auto_reply", function () {
      $(this).closest(".block").find(".a_r_enabled").length > 0
        ? $(this).closest(".block").find(".a_r_enabled").remove()
        : $(this)
            .closest(".block")
            .find(".block-inputs")
            .append(
              o(
                "text",
                "true",
                'name="chat[features][auto_reply][auto_reply]" class="d-none a_r_enabled"'
              )
            );
    }),
    $(".blocks").on("click", "#filter_abuse", function () {
      $(this).closest(".block").find(".f_abuse_enabled").length > 0
        ? $(this).closest(".block").find(".f_abuse_enabled").remove()
        : $(this)
            .closest(".block")
            .find(".block-inputs")
            .append(
              o(
                "text",
                "true",
                'name="chat[features][filter_abuse][filter_abuse]" class="d-none f_abuse_enabled"'
              )
            );
    }),
    $(".blocks").on("click", ".anim_type", function (e) {
      $(".blocks").find(".p_enabled").length > 0
        ? ($(".blocks").find(".p_enabled").remove(),
          document.querySelectorAll(".priority_link").forEach(function (e) {
            e.innerText = "Priority";
          }),
          $(this)
            .closest(".block")
            .find(".block-inputs")
            .append(
              o(
                "text",
                "true",
                'name="' +
                  $(this).closest(".block").attr("id") +
                  '[priority][enabled]" class="d-none p_enabled"'
              ),
              o(
                "text",
                $(this).attr("ref-effect"),
                'name="' +
                  $(this).closest(".block").attr("id") +
                  '[priority][effect]" class="d-none p_enabled"'
              )
            ),
          document
            .querySelectorAll(".priority_link_container")
            .forEach(function (e) {
              e.classList.remove("text-succes", "bg-success-soft");
            }))
        : $(this)
            .closest(".block")
            .find(".block-inputs")
            .append(
              o(
                "text",
                "true",
                'name="' +
                  $(this).closest(".block").attr("id") +
                  '[priority][enabled]" class="d-none p_enabled"'
              ),
              o(
                "text",
                $(this).attr("ref-effect"),
                'name="' +
                  $(this).closest(".block").attr("id") +
                  '[priority][effect]" class="d-none p_enabled"'
              )
            );
      var i = document.querySelectorAll(".anim_type");
      i.forEach(function (o) {
        e.target !== o && o.classList.remove("active");
      }),
        e.target.classList.add("active"),
        $(this)
          .closest(".block-inputs")
          .find(".priority_link")
          .html(e.target.lastChild.textContent),
        $(this)
          .closest(".block")
          .find(".priority_link")[0]
          .setAttribute("ref-animation-effect", $(this).attr("ref-effect")),
        $(this)
          .closest(".block")
          .find(".block-inputs")
          .append(
            o(
              "text",
              "true",
              'name="' +
                $(this).closest(".block").attr("id") +
                '[priority][enabled]" class="d-none p_enabled"'
            ),
            o(
              "text",
              $(this).attr("ref-effect"),
              'name="' +
                $(this).closest(".block").attr("id") +
                '[priority][effect]" class="d-none p_enabled"'
            )
          ),
        (v = 1),
        $(this)
          .closest(".block-inputs")
          .find(".priority_link_container")
          .addClass("text-succes bg-success-soft"),
        "none" === $(this).attr("ref-effect") &&
          ($(".blocks").find(".p_enabled").remove(),
          document.querySelectorAll(".priority_link").forEach(function (e) {
            (e.innerText = "Priority"),
              e
                .closest(".priority_link_container")
                .classList.remove("text-succes", "bg-success-soft");
          })),
        t(),
        n();
    }),
    $(".blocks").on("change", ".toggle_thumbnail", function (e) {
      e.target.checked
        ? $(this).closest(".block").find(".thumbnail_off").remove()
        : $(this)
            .closest(".block")
            .find(".block-inputs")
            .append(
              o(
                "text",
                "true",
                'name="' +
                  $(this).closest(".block").attr("id") +
                  '[thumbnail_off]" class="d-none thumbnail_off"'
              )
            ),
        $(this).closest(".block").find(".avatar-img").toggleClass("desaturate"),
        t(),
        n();
    }),
    $(".blocks").on("click", ".close_forward_page", function () {
      $(this).closest(".forward_page_box").remove();
    }),
    $(".blocks").on("click", ".confirm_forward_page", function () {
      $(this)
        .closest(".block")
        .find(".block-inputs")
        .append(
          o(
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
          o(
            "text",
            $(this)
              .closest(".block")
              .find(".forward_page_input_timezone")
              .val(),
            'name="' +
              $(this).closest(".block").attr("id") +
              '[forward][timezone]" class="d-none forward_date"'
          )
        ),
        (f = $(m).serializeControls());
      var e = f["" + $(this).closest(".block").attr("id")].forward.date;
      (forward_date_time =
        e.split(",")[0].trim() + " to " + e.split(",")[1].trim()),
        $(this).closest(".block").find(".forward_information").remove(),
        $(this)
          .closest(".block")
          .find(".block-inputs")
          .before(w(forward_date_time)),
        t(),
        n();
    }),
    $(".blocks").on("click", ".clear_forward", function () {
      $(this).closest(".block").find(".forward_date").remove(),
        $(this).parent().remove(),
        t(),
        n();
    }),
    $(".blocks").on("click", ".close_schedule", function () {
      $(this).closest(".schedule_box").remove();
    }),
    $(".blocks").on("click", ".confirm_schedule", function () {
      if (
        "" == $(this).closest(".block").find(".scheduled_input_date").val() ||
        "" == $(this).closest(".block").find(".scheduled_input_timezone").val()
      )
        return !1;
      $(this)
        .closest(".block")
        .find(".block-inputs")
        .append(
          o(
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
          o(
            "text",
            $(this).closest(".block").find(".scheduled_input_timezone").val(),
            'name="' +
              $(this).closest(".block").attr("id") +
              '[scheduled][timezone]" class="d-none schedule_date"'
          )
        ),
        (f = $(m).serializeControls());
      var e = f["" + $(this).closest(".block").attr("id")].scheduled.date;
      (scheduled_date_time =
        e.split(",")[0].trim() + " to " + e.split(",")[1].trim()),
        $(this).closest(".block").find(".scheduled_information").remove(),
        $(this)
          .closest(".block")
          .find(".block-inputs")
          .before(y(scheduled_date_time)),
        t(),
        n();
    }),
    $(".blocks").on("click", ".clear_schedule", function () {
      $(this).closest(".block").find(".schedule_date").remove(),
        $(this).parent().remove(),
        t(),
        n();
    }),
    $(".blocks").on("click", ".forward_link", function () {
      $(".blocks").find(".forward_page_box").length > 0 &&
        $(".blocks").find(".forward_page_box").remove(),
        $(".blocks").find(".forward_information").remove(),
        $(".blocks").find(".forward_date").remove(),
        $(this).closest(".block").find(".block-inputs").before(U),
        flatpickr(".forward_page_input_date", {
          altFormat: "F j, Y",
          enableTime: !0,
          defaultHour: new Date().getHours(),
          defaultMinute: new Date().getMinutes(),
          minDate: "today",
          dateFormat: "d-m-Y h:i K",
          mode: "range",
        }),
        $(".forward_page_input_timezone").select2({
          placeholder: "Select your timezone",
        }),
        t(),
        n();
    }),
    $(".blocks").on("click", ".schedule_link", function () {
      $(this).closest(".block").find(".schedule_box").length > 0 ||
        ($(this).closest(".block").find(".block-inputs").before(T),
        $(".scheduled_input_timezone").select2({
          placeholder: "Select your timezone",
        }),
        document
          .querySelectorAll(".scheduled_input_date")
          .forEach(function (e) {
            flatpickr(e, {
              altFormat: "F j, Y",
              enableTime: !0,
              defaultHour: new Date().getHours(),
              defaultMinute: new Date().getMinutes(),
              minDate: "today",
              dateFormat: "d-m-Y h:i K",
              mode: "range",
            });
          }));
    }),
    $(".blocks").on("click", ".disableBlock", function () {
      $(this).closest(".block").find(".b_disabled").length > 0
        ? ($(this).closest(".block").find(".b_disabled").remove(),
          $(this).html("Disable"),
          $(this)
            .closest(".block")
            .find(".card")
            .toggleClass("bg-info-soft border-info desaturate"))
        : ($(this)
            .closest(".block")
            .find(".card")
            .toggleClass("bg-info-soft border-info desaturate"),
          $(this)
            .closest(".block")
            .find(".block-inputs")
            .append(
              o(
                "text",
                "true",
                'name="' +
                  $(this).closest(".block").attr("id") +
                  '[disabled]" class="d-none b_disabled"'
              )
            ),
          $(this).html("Disabled")),
        t(),
        n();
    }),
    $(".blocks").sortable({
      axis: "y",
      cursor: "move",
      revert: !0,
      placeholder: "ui-state-highlight",
      cursorAt: { left: 5, right: 5, top: 5, bottom: 5 },
      update: function (e, o) {
        t(), n();
      },
      sort: function (e, o) {},
      start: function (e, o) {
        o.item[0].classList.add("scale-n9");
      },
      stop: function (e, o) {
        o.item[0].classList.remove("scale-n9");
      },
    }),
    $(".blocks").disableSelection(),
    $(".toggle_dark").on("click", function () {
      $("html").toggleClass("dark-theme");
      const e = $("#theme");
      e.toggleClass("dark"),
        e.hasClass("dark")
          ? (e.attr(
              "href",
              "http://localhost/ProfilePage/css/theme-dark.min.css"
            ),
            $(this).html('<i class="bi bi-lightbulb sz-24 my-2"></i>'))
          : (e.attr("href", "http://localhost/ProfilePage/css/theme.min.css"),
            $(this).html('<i class="bi bi-lightbulb-off sz-24 my-2"></i>'));
    }),
    (blockNum = 0),
    ($.fn.hasAttr = function (e) {
      return void 0 !== this.attr(e);
    }),
    (a.options = {
      strictMode: !1,
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
      q: { name: "queryKey", parser: /(?:^|&)([^&=]*)=?([^&]*)/g },
      parser: {
        strict: /^(?:([^:\/?#]+):)?(?:\/\/((?:(([^:@]*)(?::([^:@]*))?)?@)?([^:\/?#]*)(?::(\d*))?))?((((?:[^?#\/]*\/)*)([^?#]*))(?:\?([^#]*))?(?:#(.*))?)/,
        loose: /^(?:(?![^:@]+:[^:@\/]*@)([^:\/?#.]+):)?(?:\/\/)?((?:(([^:@]*)(?::([^:@]*))?)?@)?([^:\/?#]*)(?::(\d*))?)(((\/(?:[^?#](?![^?#\/]*\.[^?#\/.]+(?:[?#]|$)))*\/?)?([^?#\/]*))(?:\?([^#]*))?(?:#(.*))?)/,
      },
    });
  var _ = function () {
      return '<div class="dialog-overlay rounded-xl card-body bg-danger-soft text-danger d-flex align-items-center flex-column justify-content-center"><div class="warning"><h3>Are you sure you want to delete?</h3></div><div class="btn-group"><button type="button" class="btn btn-danger btn-sm rounded-pill confirm-delete mr-3">Delete</button> <button type="button" class="btn btn-primary btn-sm rounded-pill cancel-delete">Cancel</button></div></div>';
    },
    y = function (e) {
      return (
        '<div class="scheduled_information"><div class="card-header p-2 h-auto"><h4 class="card-header-title">Scheduled from ' +
        e +
        '</h4><button type="button" class="btn btn-sm btn-white rounded clear_schedule">Clear schedule</button></div></div>'
      );
    },
    w = function (e) {
      return (
        '<div class="forward_information"><div class="card-header p-2 h-auto"><h4 class="card-header-title">Forward set from ' +
        e +
        '</h4><button type="button" class="btn btn-sm btn-white rounded clear_forward">Clear forward</button></div></div>'
      );
    },
    C = function (e, o) {
      return (
        '<div class="accordion border rounded p-0 mt-3"><div class="row align-items-center justify-content-between no-gutters"><div class="col"><button class="btn btn-block text-left mb-0" type="button" data-toggle="collapse" data-target="#' +
        e +
        '_preview" aria-expanded="true" aria-controls="collapseOne"><span class="preview_enabled">Preview</span></button></div><div class="col-auto"><button class="align-self-end btn mb-0 btn-white btn-sm rounded-pill mr-2 toggle_link_preview" type="button"><span class="link_preview_enabled">Turn off</span></button></div></div><div id="' +
        e +
        '_preview" class="collapse show"><div class="embed-responsive embed-responsive-21by9 rounded-bottom"><iframe class="embed-responsive-item" src="' +
        o +
        '" allowfullscreen></iframe></div></div></div>'
      );
    },
    T = function () {
      return (
        '<div class="schedule_box"><div class="card-header h-auto p-2 px-3"><h4 class="card-header-title">Schedule link</h4><div class="btn-group btn-group-sm"><button type="button" class="btn bg-white-soft border confirm_schedule">Save</button> <button type="button" class="btn bg-white-soft border close_schedule">Close</button></div></div><div class="p-3"><div class="row"><div class="col-md-6 mb-3"><div class="input-group input-group-merge"><div class="input-group-prepend"><span class="input-group-text p-0 px-2"><i class="bi bi-clock-history"></i></span></div><input type="text" class="form-control form-control-sm form-control-prepended scheduled_input_date" placeholder="Start date to End date" data-toggle="flatpickr"></div></div><div class="col-md-6"><select class="scheduled_input_timezone">' +
        d +
        '</select></div></div></div><hr class="m-0"></div>'
      );
    },
    U = function () {
      return (
        '<div class="forward_page_box"><div class="card-header h-auto p-2 px-3"><h4 class="card-header-title">Forward link</h4><div class="btn-group btn-group-sm"><button type="button" class="btn bg-white-soft border confirm_forward_page">Save</button> <button type="button" class="btn bg-white-soft border close_forward_page">Close</button></div></div><div class="p-3"><div class="row"><div class="col-md-6 mb-3"><div class="input-group input-group-merge"><div class="input-group-prepend"><span class="input-group-text p-0 px-2"><i class="bi bi-clock-history"></i></span></div><input type="text" class="form-control form-control-sm form-control-prepended forward_page_input_date" placeholder="Date 1 to Date 2" data-toggle="flatpickr"></div></div><div class="col-md-6"><select class="forward_page_input_timezone">' +
        d +
        '</select></div> </div></div> <hr class = "m-0"> </div>'
      );
    },
    x = function () {
      return '<div class="block mb-2" id="anonymus_chat"><div class="card mb-0 rounded"><div class="card-header"><h4 class="card-header-title">Anonymus chat</h4><button class="btn btn-sm btn-white-soft removeBlock" type="button"><i class="bi bi-x-circle sz-18"></i></button></div><div class="card-body py-1 block-inputs"><div class="mb-3"><ul class="list-group list-group-flush"><li class="list-group-item d-flex align-items-center justify-content-between px-0"><small>Show my username <i class="bi bi-info-circle ml-2" data-toggle="tooltip" title="Turning this on will show your username, turning this off will show randomly generated name to every user."></i></small><div class="custom-control custom-switch"><input type="checkbox" class="custom-control-input" id="show_username"> <label class="custom-control-label" for="show_username"></label></div></li><li class="list-group-item d-flex align-items-center justify-content-between px-0"><small>Disallow direct messaging <i class="bi bi-info-circle ml-2" data-toggle="tooltip" title="Enable this to get messages only from registered users."></i></small><div class="custom-control custom-switch"><input type="checkbox" class="custom-control-input" id="force_login"> <label class="custom-control-label" for="force_login"></label></div></li><li class="list-group-item"><div class="d-flex align-items-center justify-content-between px-0"><small>Set delay timer *in seconds <i class="bi bi-info-circle ml-2" data-toggle="tooltip" title="Users will have to wait before sending a new message. Default timer is 5 seconds."></i></small><div class="custom-control custom-switch"><input type="checkbox" class="custom-control-input toggle-input" toggle-relative="delaytimer" id="delay_timer"> <label class="custom-control-label" for="delay_timer"></label></div></div><input name="chat[features][delay_timer]" class="form-control mt-2" relative-id="delaytimer" value="10" placeholder="Set seconds..." style="display:none"></li></ul></div></div></div></div>';
    },
    A = function () {
      return '<div class="block" id="feedback_collector"><div class="card mb-3"><div class="card-header"><h4 class="card-header-title">Feedback</h4><button class="btn btn-sm btn-white-soft removeBlock" type="button"><i class="bi bi-x-circle sz-18"></i></button></div><div class="block-inputs form-group mb-0"><div class="card-body"><ul class="list-group list-group-flush"><li class="list-group-item form-group-item mt-n4 py-3 px-0 mb-0"><input class="form-control mb-2" id="feedbacker" type="text" placeholder="Enter placeholder" value="Your name" name="feedback_collector[name]"> <input class="form-control mb-2" placeholder="Enter placeholder" value="Your email" type="email" name="feedback_collector[email]"> <textarea class="form-control mb-2 feedback_message" id="feedback_message" rows="5" placeholder="Enter your placeholder for user" name="feedback_collector[feebacker_message]" resize="none"></textarea></li></ul></div></div></div></div>';
    },
    S = function () {
      return '<div class="block" id="information_collector"><div class="card"><div class="card-header"><h4 class="card-header-title">Forms</h4><button class="btn btn-sm btn-white-soft removeBlock" type="button"><i class="bi bi-x-circle sz-18"></i></button></div><div class="block-inputs form-group mb-0"><div class="card-body"><ul class="list-group list-group-flush mt-n4"><li class="list-group-item form-group-item py-3 px-0 mb-0"><div class="row"><div class="col-md-3"><input type="text" class="form-control form-control-flush" placeholder="Give a label" name="information_collector[fields][name][label]"></div><div class="col"><div class="input-group input-group-merge"><input type="text" class="form-control form-control-appended" placeholder="Placeholder" value="Name" name="information_collector[fields][name][placeholder]"><div class="input-group-append"><div class="input-group-text py-0"><button class="btn btn-sm bg-danger-soft text-danger rounded-pill removeInput" type="button">Remove</button></div></div></div></div></div></li><li class="list-group-item form-group-item py-3 px-0"><div class="row"><div class="col-md-3"><input type="text" class="form-control form-control-flush w-auto" placeholder="Give a label" name="information_collector[fields][email][label]"></div><div class="col"><div class="input-group input-group-merge"><input type="text" class="form-control form-control-appended form-control-" placeholder="Placeholder" value="Email" name="information_collector[fields][email][placeholder]"><div class="input-group-append"><div class="input-group-text py-0"><button class="btn btn-sm bg-danger-soft text-danger rounded-pill removeInput" type="button">Remove</button></div></div></div></div></div></li><li class="list-group-item form-group-item py-3 px-0"><div class="row"><div class="col-md-3"><input type="text" class="form-control form-control-flush w-auto" placeholder="Give a label" name="information_collector[fields][phone][label]"></div><div class="col"><div class="input-group input-group-merge"><input type="text" class="form-control form-control-appended form-control-" placeholder="Placeholder" value="Phone number" name="information_collector[fields][phone][placeholder]"><div class="input-group-append"><div class="input-group-text py-0"><button class="btn btn-sm bg-danger-soft text-danger rounded-pill removeInput" type="button">Remove</button></div></div></div></div></div></li><li class="list-group-item form-group-item px-0"><div class="row"><div class="col-md-3"><input type="text" class="form-control form-control-flush w-auto" placeholder="Give a label" name="information_collector[fields][dob][label]"></div><div class="col"><div class="input-group input-group-merge"><input type="text" class="form-control form-control-appended form-control-" placeholder="Placeholder" value="Date of birth" name="information_collector[fields][dob][placeholder]"><div class="input-group-append"><div class="input-group-text py-0"><button class="btn btn-sm bg-danger-soft text-danger rounded-pill removeInput" type="button">Remove</button></div></div></div></div></div></li></ul><div class="toolbar"><div class="btn-group btn-group-sm"><div class="dropdown rounded-pill mr-2 bg-primary-soft priority_link_container"><button type="button" class="btn btn-sm text-primary dropdown-toggle" data-toggle="dropdown" ref-animation-effect="headShake"><i class="bi bi-asterisk sz-sm"></i> <span class="priority_link">Priority</span></button><div class="dropdown-menu position-absolute" style="z-index:999"><h6 class="dropdown-header animation_list">Choose animations</h6><a class="dropdown-item anim_type" ref-effect="none" href="javascript:void(0)"><i class="bi bi-bezier2"></i> None</a> <a class="dropdown-item anim_type" ref-effect="headShake" href="javascript:void(0)"><i class="bi bi-bezier2"></i> Default</a> <a class="dropdown-item anim_type" ref-effect="bounce" href="javascript:void(0)"><i class="bi bi-bezier2"></i> Bounce</a> <a class="dropdown-item anim_type" ref-effect="flash" href="javascript:void(0)"><i class="bi bi-bezier2"></i> Flash</a> <a class="dropdown-item anim_type" ref-effect="pulse" href="javascript:void(0)"><i class="bi bi-bezier2"></i> Pulse</a> <a class="dropdown-item anim_type" ref-effect="rubberBand" href="javascript:void(0)"><i class="bi bi-bezier2"></i> Rubberband</a> <a class="dropdown-item anim_type" ref-effect="shakeX" href="javascript:void(0)"><i class="bi bi-bezier2"></i> Shake X</a> <a class="dropdown-item anim_type" ref-effect="shakeY" href="javascript:void(0)"><i class="bi bi-bezier2"></i> Shake Y</a> <a class="dropdown-item anim_type" ref-effect="jello" href="javascript:void(0)"><i class="bi bi-bezier2"></i> Jello</a> <a class="dropdown-item anim_type" ref-effect="tada" href="javascript:void(0)"><i class="bi bi-bezier2"></i> Tada</a></div></div><button class="btn btn-sm btn-white rounded-pill disableBlock" type="button"><i class="bi bi-slash-circle sz-sm"></i> Disable</button></div></div></div></div></div></div>';
    },
    z = function (e) {
      return (
        '<div class="block mb-2" id="link_' +
        e +
        '"><div class="reorder-links"><div class="card mb-0 rounded-xl"><div class="card-body p-3 block-inputs"><div class="row"><div class="col-auto align-self-center p-0 h-100 d-none d-sm-block"><i class="bi bi-grip-vertical"></i></div>  <div class="col-auto align-self-center px-2 d-block d-sm-none" style="height:94px"><div class="btn-group-vertical h-100"><button type="button" class="btn btn-white p-0 move-up"><i class="bi bi-chevron-up"></i></button><button type="button" class="btn btn-white p-0 move-down"><i class="bi bi-chevron-down"></i></button></div></div><div class="col-auto pl-0"><div class="d-flex flex-column justify-content-center align-items-center"><div class="avatar avatar-md"><div class="avatar-title font-size-lg bg-primary-soft rounded-circle text-primary rounded-pill mr-2 domain-icon" ref-icon="link_' +
        e +
        '"><i class="bi bi-link sz-24"></i></div><input type="file" class="d-none custom_domain_icon" name="link_' +
        e +
        '[custom_icon]"></div></div><div class="custom-control custom-switch align-self-end mt-3"><input type="checkbox" class="custom-control-input toggle_thumbnail" id="thumbnail_toggle_' +
        e +
        '" title="Remove thumbnail" checked> <label class="custom-control-label" for="thumbnail_toggle_' +
        e +
        '"></label></div></div><div class="col ml-n3"><!-- Input --><div class="input-group input-group-merge"><input type="text" class="form-control form-control-flush form-control-auto block_title" value="" placeholder="Title" id="link_title_' +
        e +
        '" name="link_' +
        e +
        '[link_title]"><div class="input-group-prepend"><div class="input-group-text bg-transparent p-0 px-1 border-0"><i class="bi bi-type sz-18"></i></div></div></div><div class="input-group input-group-merge mt-2"><input type="url" class="form-control form-control-flush form-control-auto link_box block_domain" value="" placeholder="Page url" id="link_address_' +
        e +
        '" name="link_' +
        e +
        '[link_address]"><div class="input-group-prepend"><div class="input-group-text bg-transparent p-0 px-1 border-0"><i class="bi bi-link-45deg sz-18"></i></div></div></div><div class="medium-screen-setting-menu d-none d-md-block mt-2"><div class="d-flex"><div class="dropdown rounded-pill mr-2 bg-primary-soft priority_link_container"><button type="button" class="btn btn-sm text-primary dropdown-toggle" data-toggle="dropdown" ref-animation-effect="headShake"><i class="bi bi-asterisk sz-sm"></i> <span class="priority_link">Priority</span></button><div class="dropdown-menu position-absolute" style="z-index:999"><h6 class="dropdown-header animation_list">Choose animations</h6><a class="dropdown-item anim_type" ref-effect="none" href="javascript:void(0)"><i class="bi bi-bezier2"></i> None</a> <a class="dropdown-item anim_type" ref-effect="headShake" href="javascript:void(0)"><i class="bi bi-bezier2"></i> Default</a> <a class="dropdown-item anim_type" ref-effect="bounce" href="javascript:void(0)"><i class="bi bi-bezier2"></i> Bounce</a> <a class="dropdown-item anim_type" ref-effect="flash" href="javascript:void(0)"><i class="bi bi-bezier2"></i> Flash</a> <a class="dropdown-item anim_type" ref-effect="pulse" href="javascript:void(0)"><i class="bi bi-bezier2"></i> Pulse</a> <a class="dropdown-item anim_type" ref-effect="rubberBand" href="javascript:void(0)"><i class="bi bi-bezier2"></i> Rubberband</a> <a class="dropdown-item anim_type" ref-effect="shakeX" href="javascript:void(0)"><i class="bi bi-bezier2"></i> Shake X</a> <a class="dropdown-item anim_type" ref-effect="shakeY" href="javascript:void(0)"><i class="bi bi-bezier2"></i> Shake Y</a> <a class="dropdown-item anim_type" ref-effect="jello" href="javascript:void(0)"><i class="bi bi-bezier2"></i> Jello</a> <a class="dropdown-item anim_type" ref-effect="tada" href="javascript:void(0)"><i class="bi bi-bezier2"></i> Tada</a></div></div><button type="button" class="btn btn-sm bg-primary-soft text-primary rounded-pill mr-2 schedule_link">Schedule</button> <button type="button" class="btn btn-sm bg-primary-soft text-primary rounded-pill mr-2 forward_link">Leap</button> <button type="button" class="btn btn-sm btn-white rounded-pill disableBlock">Disable</button></div></div><div class="small-screen-setting-menu mt-2 d-flex d-block d-md-none"><div class="dropdown rounded-pill mr-2 bg-primary-soft priority_link_container"><button type="button" class="btn btn-sm text-primary dropdown-toggle" data-toggle="dropdown" ref-animation-effect="headShake"><span class="priority_link">Priority</span></button><div class="dropdown-menu position-absolute" style="z-index:999"><h6 class="dropdown-header animation_list">Choose animations</h6><a class="dropdown-item anim_type" ref-effect="none" href="javascript:void(0)"><i class="bi bi-bezier2"></i> None</a> <a class="dropdown-item anim_type" ref-effect="headShake" href="javascript:void(0)"><i class="bi bi-bezier2"></i> Default</a> <a class="dropdown-item anim_type" ref-effect="bounce" href="javascript:void(0)"><i class="bi bi-bezier2"></i> Bounce</a> <a class="dropdown-item anim_type" ref-effect="flash" href="javascript:void(0)"><i class="bi bi-bezier2"></i> Flash</a> <a class="dropdown-item anim_type" ref-effect="pulse" href="javascript:void(0)"><i class="bi bi-bezier2"></i> Pulse</a> <a class="dropdown-item anim_type" ref-effect="rubberBand" href="javascript:void(0)"><i class="bi bi-bezier2"></i> Rubberband</a> <a class="dropdown-item anim_type" ref-effect="shakeX" href="javascript:void(0)"><i class="bi bi-bezier2"></i> Shake X</a> <a class="dropdown-item anim_type" ref-effect="shakeY" href="javascript:void(0)"><i class="bi bi-bezier2"></i> Shake Y</a> <a class="dropdown-item anim_type" ref-effect="jello" href="javascript:void(0)"><i class="bi bi-bezier2"></i> Jello</a> <a class="dropdown-item anim_type" ref-effect="tada" href="javascript:void(0)"><i class="bi bi-bezier2"></i> Tada</a></div></div><div class="dropdown"><a class="btn btn-white dropdown-toggle btn-sm rounded-pill" href="javascript:void(0)" data-toggle="dropdown">Settings</a><div class="dropdown-menu"><h6 class="dropdown-header">Select options</h6><a class="dropdown-item schedule_link" href="javascript:void(0)"><i class="mr-2 bi bi-calendar3-range"></i> Schedule link</a> <a class="dropdown-item forward_link" href="javascript:void(0)"><i class="mr-2 bi bi-arrow-return-right"></i> Leap</a> <a class="dropdown-item" href="javascript:void(0)"><i class="mr-2 bi bi-slash-circle"></i> <span class="disableBlock">Disable</span></a></div></div></div></div><div class="col-auto align-self-start"><div class="text-muted"><button class="btn btn-sm btn-white-soft outline-none removeBlock" type="button"><i class="bi bi-x-circle sz-18"></i></button></div></div></div><div class="link-media-preview"></div></div></div></div></div>'
      );
    };
  $("body").on("click", ".chat_anonymously", function () {
    g >= 1
      ? ((g = 0),
        $("#anonymus_chat").remove(),
        $(".layout-anonymus")[0].classList.remove("form-added"))
      : ((g = 1),
        $(".blocks").prepend(x),
        $(".count_links").html($(".block").length),
        $(".layout-anonymus")[0].classList.add("form-added"),
        Snackbar.show({
          pos: "top-center",
          text: "Anonymus chat installed 😊",
        }));
  }),
    $("body").on("click", ".feedback_collector", function () {
      k >= 1
        ? ((k = 0),
          $("#feedback_collector").remove(),
          $(".layout-feedback")[0].classList.remove("form-added"))
        : ((k = 1),
          $(".blocks").prepend(A),
          $(".count_links").html($(".block").length),
          $(".layout-feedback")[0].classList.add("form-added"),
          Snackbar.show({
            pos: "top-center",
            text: "You can use only one feedback in a page 😊",
          }));
    }),
    $("body").on("click", ".information_collector", function () {
      h >= 1
        ? ((h = 0),
          $("#information_collector").remove(),
          $(".layout-form")[0].classList.remove("form-added"))
        : ((h = 1),
          $(".blocks").prepend(S),
          $(".count_links").html($(".block").length),
          $(".layout-form")[0].classList.add("form-added"),
          Snackbar.show({
            pos: "top-center",
            text: "You can use only one form in a page 😊",
          }));
    }),
    $(".link_container").on("click", ".add_new_link", function () {
      blockNum++,
        $(".blocks").prepend(z(blockNum)),
        $(".count_links").html($(".block").length);
    }),
    $(".link_container").on("click", ".removeInput", function () {
      1 == $(this).closest(".block").find(".input-group").length
        ? $(this).closest(".block").find(".block-inputs").before(_)
        : $(this).closest(".form-group-item").remove(),
        t(),
        n();
    }),
    $(".link_container").on("click", ".removeBlock", function () {
      $(".count_links").html($(".block").length),
        $(this).closest(".block").find(".block-inputs").before(_),
        t();
    }),
    $(".blocks").on("click", ".confirm-delete", function () {
      "information_collector" === $(this).closest(".block").attr("id") &&
        ((h = 0), $(".layout-form")[0].classList.remove("form-added")),
        "feedback_collector" === $(this).closest(".block").attr("id") &&
          ((k = 0), $(".layout-feedback")[0].classList.remove("form-added")),
        $(this).closest(".block").remove(),
        $(".block").length < 1 && $(".add_new_link").click(),
        t(),
        $(".count_links").html($(".block").length);
    }),
    $(".blocks").on("click", ".cancel-delete", function () {
      $(this).closest(".dialog-overlay").remove();
    }),
    $(".blocks").on("click", ".domain-icon", function () {
      $(this).closest(".block").find(".custom_domain_icon").click();
    });
  var E = new FileReader(),
    j = ["image/jpeg", "image/png", "image/jpg"];
  $(".blocks").on("change", ".custom_domain_icon", function (e) {
    var o = this.files[0],
      t = o.type;
    if (t != j[0] && t != j[1] && t != j[2])
      return (
        alert("Sorry, only JPG, JPEG, & PNG files are allowed to upload."), !1
      );
    (E.onload = function (o) {
      $(".blocks")
        .find(e.target)
        .closest(".block")
        .find(".domain-icon")
        .html(
          `<img class="avatar-img rounded-circle" src ="${o.target.result}" />`
        ),
        $(".live_preview")
          .find(
            `.${$(".blocks")
              .find(e.target)
              .closest(".block")
              .find(".domain-icon")
              .attr("ref-icon")}_domain_icon`
          )
          .html(
            `<img class="avatar-img rounded-circle" src ="${o.target.result}" />`
          );
    }),
      E.readAsDataURL(o);
  }),
    $(".blocks").on("keypress focus blur change", ".block", function (e) {
      if (e.target.classList.contains("link_box") && "" == !e.target.value) {
        i(
          $(this).find(".domain-icon"),
          a($(this).find(".link_box").val()).authority
        );
        var o = r(e.target.value);
        if (o) {
          $(this)
            .closest(".block")
            .find(".link-media-preview")
            .html(
              '\n          <div class="d-flex justify-content-center p-5">\n            <div class="spinner-border text-primary" role="status">\n              <span class="sr-only">Loading...</span>\n            </div>\n          </div>'
            );
          var t = $(this).closest(".block").attr("id");
          setTimeout(function () {
            $(this).closest(".block").find(".link-media-preview").html(C(t, o));
          }, 1e3);
        } else $(this).closest(".block").find(".link-media-preview").html("");
      }
    }),
    $(".blocks").on("click", ".toggle_link_preview", function () {
      console.log($(this).closest(".block").find(".link_preview_off").length),
        $(this).closest(".block").find(".link_preview_off").length > 0
          ? ($(this).closest(".block").find(".link_preview_off").remove(),
            $(this).removeClass("bg-danger-soft text-danger"),
            $(this)
              .closest(".block")
              .find(".link_preview_enabled")
              .html(
                '\n          <i class="bi bi-eye p-0 m-0"></i>\n          <span class="link_preview_enabled">Turned on</span>\n          '
              ))
          : ($(this).addClass("bg-danger-soft text-danger"),
            $(this)
              .closest(".block")
              .find(".link_preview_enabled")
              .html(
                '\n          <i class="bi bi-eye-slash p-0 m-0"></i>\n          <span class="link_preview_enabled">Turned off</span>\n          '
              ),
            $(this)
              .closest(".block-inputs")
              .append(
                o(
                  "text",
                  "off",
                  `name="${$(this)
                    .closest(".block")
                    .attr("id")}[link_preview]" class="d-none link_preview_off"`
                )
              ));
    }),
    $(".publish_page").on("click", function () {
      n();
    }),
    $(".blocks").on("click", ".move-up", function (e) {
      l($(this).closest(".block")),
        $("html, body").animate(
          { scrollTop: $($(this).closest(".block")).offset().top - 150 },
          300
        );
    }),
    $(".blocks").on("click", ".move-down", function (e) {
      s($(this).closest(".block")),
        $("html, body").animate(
          { scrollTop: $($(this).closest(".block")).offset().top - 150 },
          300
        );
    });
}
