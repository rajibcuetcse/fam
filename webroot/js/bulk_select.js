$(window).load(function () {

        $("input[id^='content_']").change(function (e) {

            var selected_users_element = $("input[name='selected_content']");
            var selected_users = selected_users_element.val();
            var clickedValue = $(this).prop('id');
            var array = selected_users.split(',');

            if ($(this).is(':checked')) {
                if ($.inArray(clickedValue, array) == -1) {
                    var value = selected_users_element.val();
                    if (value != '') {
                        selected_users_element.val(value + ',' + clickedValue);
                    } else {
                        selected_users_element.val(clickedValue);
                    }
                }
            } else {
                array = $.grep(array, function (value) {
                    return value != clickedValue;
                });
                selected_users_element.val(array.join(','));
            }
        });

        $("input[id^='ContentSelect']").change(function (e) {
            if ($(this).is(':checked')) {
                $("input[id^='content_']").each(function (index) {
                    $(this).prop("checked",true).trigger("change");
                });
            } else {
                $("input[id^='content_']").each(function (index) {
                    $(this).prop("checked",false).trigger("change");
                });
            }
        });

    });