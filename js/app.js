function processing_started(element, holding_class, starting_text) {
    element.attr("disabled", "true"),
        element.addClass(holding_class),
        element.removeAttr("id"),
        element.html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>' + starting_text);
}

function processing_done(element, holding_id, holding_class, default_text) {
    element.removeAttr("disabled"),
        element.attr("id", holding_id),
        element.removeClass(holding_class),
        element.html(default_text);
}
var tz = '';

try {
    // moment js + moment timezone
    tz = moment.tz.guess();
    setCookie('tz', tz, 7);
} catch (e) {
    console.log("Could not detect timezone.");
}
/*axios({
        url: 'timezone',
        method: 'post',
        data: 'timezone=' + tz
    })
    .then(function (response) {}).catch();
*/