<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/fonts/bootstrap-icons/bootstrap-icons.css" />
    <link rel="stylesheet" href="css/theme.min.css" />

    <title>IFJS</title>
</head>

<body>

    <div class="container my-6">
        <div class="row align-items-center justify-content-center">
            <div class="col-md-8">
                <div class="progress mb-3">
                    <div if-style="text:width={if-click}" class="progress-bar" style="width: 65.08997%;" role="progressbar"></div>
                </div>
                <div class="cond">
                    <div class="row">
                        <div if-class="tex:col-md-8" class="col">
                            <input if-type="time:datetime-local|text" class="form-control" placeholder="First name">
                        </div>
                        <div class="col">
                            <input if-type="pass:password|text" class="form-control" placeholder="Password..." type="text">
                        </div>
                        <button if-click="time|pass" class="btn btn-white rounded-pill">
                            {<i class="bi bi-clock"></i>|<i class="bi bi-eye-slash"></i>}
                        </button>
                        <button if-click="(0-100,20)" class="btn btn-white rounded-pill">
                            {klop|polk}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function IFJS() {
            const cond_div = document.querySelectorAll('.cond');
            Array.prototype.forEach.call(cond_div, function(foreach_this_cond_div) {
                // console.log(foreach_this_cond_div);
                let on_click_buttons = foreach_this_cond_div.querySelectorAll('[if-click]');

                Array.prototype.forEach.call(on_click_buttons, function(foreach_this_button) {
                    // console.log(foreach_this_button);

                    let if_content_def = foreach_this_button.innerHTML.trim().split('{');
                    if (if_content_def) {
                        if_content_def = if_content_def[1]
                            .split('}')[0]
                            .split('|');

                    }
                    let if_content = if_content_def.filter(function(el) {
                        return el != '';
                    });
                    // Setting default text content
                    foreach_this_button.innerHTML = if_content[0];

                    let content_counts = 1;
                    let click_counts = 0;

                    foreach_this_button.addEventListener('click', function(for_each_click) {
                        // console.log(this);
                        let cond_attribute = this.getAttribute('if-click').split('|');

                        // console.log(on_click_buttons);

                        // console.log(cond_attribute);

                        if (click_counts === cond_attribute.length) {
                            // console.log('click_exceeds');
                            click_counts = 0;
                        }
                        // console.log(this.innerHTML.trim().split('{')[1].split('}')[0].split('|'));
                        if (if_content) {

                            if (if_content.length > 1) {

                                this.innerHTML = if_content[content_counts];

                                content_counts++;

                                if (content_counts === if_content.length) {
                                    // console.log('click_exceeds');
                                    content_counts = 0;
                                }
                            }
                        }
                        // after click searching for if-type elements
                        const if_types = foreach_this_cond_div.querySelectorAll('[if-type]');

                        Array.prototype.forEach.call(if_types, function(for_each_if_types) {
                            // console.log(for_each_if_types);

                            //Selecting only first index of the condition
                            let _ifcond_ = String(for_each_if_types.getAttribute('if-type')).split(':');

                            let _iftoggles_ = _ifcond_[1].split('|');

                            // console.log(_iftoggles_);

                            if (cond_attribute[click_counts] === _ifcond_[0]) {
                                // console.log('if satisfied...');

                                for_each_if_types.setAttribute('type', _iftoggles_[0]);

                            } else if (click_counts <= _iftoggles_.length - 1) {

                                for_each_if_types.setAttribute('type', _iftoggles_[click_counts]);

                            } else {

                                for_each_if_types.setAttribute('type', _iftoggles_[_iftoggles_.length - 1]);
                                // console.log(for_each_if_types, _iftoggles_.length);
                            }

                        });
                        click_counts++;
                    });
                });
            });
        };
        new IFJS();

        function handle_if_events(if_type, element, value) {
            switch (if_type) {
                case 'type':
                case 'TYPE':
                case 'Type':
                    element.setAttribute('type', value);
                    break;

                case 'class':
                    element.classList.add(value);

                case 'class-remove':
                    element.classList.remove(value);

                case 'attr':
                case 'attribute':
                    element.setAttribute('attr', value);

                case 'style':
                case 'Style':
                    element.getAttribute('style').split(';').push(value).join(';');
                default:
                    break;
            }
        }
    </script>
</body>

</html>