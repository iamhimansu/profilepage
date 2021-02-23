function ifJS() {
    let cond_div = document.querySelectorAll('.cond');
    Array.prototype.forEach.call(cond_div, function (foreach_this_cond_div) {
        // console.log(foreach_this_cond_div);
        let on_click_buttons = foreach_this_cond_div.querySelectorAll('[on-click]');

        Array.prototype.forEach.call(on_click_buttons, function (foreach_this_button) {
            // console.log(foreach_this_button);
            foreach_this_button.dataset.clicked = 0;

            foreach_this_button.addEventListener('click', function (_for_each_click) {
                // console.log(this);
                let cond_attribute = this.getAttribute('on-click').split('|');
                // console.log(cond_attribute);
                foreach_this_button.dataset.clicked++;

                let click_counts = Number(foreach_this_button.dataset.clicked) || 0;
                // console.log(click_counts);

                if (click_counts === cond_attribute.length) {
                    // console.log('click_exceeds');
                    foreach_this_button.dataset.clicked = 0;
                }

                // after click searching for if-type elements
                let if_types = foreach_this_cond_div.querySelectorAll('[if-type]');

                Array.prototype.forEach.call(if_types, function (for_each_if_types) {
                    // console.log(for_each_if_types);

                    //Selecting only first index of the condition
                    let _ifcond_ = String(for_each_if_types.getAttribute('if-type')).split(':');

                    let _iftoggles_ = _ifcond_[1].split('|');

                    // console.log(_iftoggles_);

                    if (cond_attribute[click_counts - 1] === _ifcond_[0]) {
                        // console.log('if satisfied...');

                        for_each_if_types.setAttribute('type', _iftoggles_[0]);
                    } else if (click_counts <= _iftoggles_.length - 1) {
                        for_each_if_types.setAttribute('type', _iftoggles_[click_counts]);
                    } else {
                        for_each_if_types.setAttribute('type', _iftoggles_[_iftoggles_.length - 1]);
                        // console.log(for_each_if_types, _iftoggles_.length);
                    }

                });

            });
        });
    });
};
new ifJS();