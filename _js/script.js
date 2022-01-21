// function sendAJAXRequest(parameters="", type_="GET") {
//     // $.ajax({
//     //     type: type_,
//     //     url: "api.php?" + parameters,
//     //     async: true,
//     //     dataType: "json",
//     //     success
//     // });
// }
String.prototype.replaceAll = function(search, replacement) {
    var target = this;
    return target.split(search).join(replacement);
};

function getDateTimeNow() {
    var date = new Date();
    var year = date.getFullYear();
    var month = date.getMonth() + 1;
    var day = date.getDate();
    var hour = date.getHours();
    var minute = date.getMinutes();
    var second = parseInt("00");

    month = month < 10 ? ("0" + (month)) : month;
    day = day < 10 ? ("0" + (day)) : day;
    hour = hour < 10 ? ("0" + (hour)) : hour;
    minute = minute < 10 ? ("0" + (minute)) : minute;
    second = second < 10 ? ("0" + (second)) : second;

    var date_time = year + "-" + month + "-" + day + " " + hour + ":" + minute + ":" + second;
    return date_time;
}

function getDateTime(date, is_string) {
    date = new Date(date);
    var year = date.getFullYear();
    var month = date.getMonth() + 1;
    var day = date.getDate();
    var hour = date.getHours();
    var minute = date.getMinutes();
    var second = parseInt("00");

    month = month < 10 ? ("0" + (month)) : month;
    day = day < 10 ? ("0" + (day)) : day;
    hour = hour < 10 ? ("0" + (hour)) : hour;
    minute = minute < 10 ? ("0" + (minute)) : minute;
    second = second < 10 ? ("0" + (second)) : second;

    var date_time = year + "-" + month + "-" + day + " " + hour + ":" + minute + ":" + second;
    if(!is_string) {
        date_time = date_time.replaceAll("-", "");
        date_time = date_time.replaceAll(" ", "");
        date_time = date_time.replaceAll(":", "");
        date_time = parseFloat(date_time);
        // console.log(date_time);
    }
    return date_time;
}

$(window).bind('beforeunload',function(){
    $("#page-loader").addClass("active");
});

$(document).ready(function() {
    $("#page-loader").removeClass("active");
    // $("a[href]").on("click", function() {
    //     $("#page-loader").show();
    // });

    alertify.defaults.transition = "zoom";
    alertify.defaults.theme.ok = "ui positive button";
    alertify.defaults.theme.cancel = "ui black button";

    $.fn.api.settings.api = {
        'fetch' : "_php/api.php?fetch={fetch}&query={/query}",
        'fetch_educ_course' : "../../_php/api.php?fetch={fetch}&query={/query}",
        'fetch_stud_course' : "../../_php/api.php?fetch={fetch}&query={/query}"
    };

    $.is_course_valid = true;
    $.is_user_id_valid = true;

    $("#modal-bulletin").modal();
    $('.ui.rating').rating({
        interactive: false,
        maxRating: 10
    });

    setInterval(function() {
        $.date_today = new Date();
    }, 100);

    $('table').tablesort();

    $('#slider-time-limit').slider({
        min: 3,
        max: 30,
        start: 3,
        step: 6,
        onMove: function(move) {
            $(this).find("input").each(function() {
                $(this).val(move);
            });
        }
    });

    $(".ui.calendar").calendar();

    
    

    setTimeout(function() {
        $("#calendar-dissemination-date").calendar({
            minDate: new Date($.date_today.getFullYear(), $.date_today.getMonth(), $.date_today.getDate(), $.date_today.getHours(), $.date_today.getMinutes()),
            endCalendar: $("#calendar-deadline-date"),
            today: true,
            onChange: function(date) {
                if(date != null) {
                    $(this).prev().val(getDateTime(date, true));
                    var year = $(this).calendar("get date").getFullYear();
                    var month = $(this).calendar("get date").getMonth();
                    var day = $(this).calendar("get date").getDate();
                    var hour = $(this).calendar("get date").getHours();
                    var minute = $(this).calendar("get date").getMinutes();
                    var minDate = new Date(year, month, day, hour + 3, minute);
                    var maxDate = new Date(year, month + 3, day, hour + 3, minute);
                    $("#calendar-deadline-date").calendar("set minDate", minDate);
                    $("#calendar-deadline-date").calendar("set maxDate", maxDate);
                } else {
                    $(this).prev().val("");
                }
            }
        });
    
        $("#calendar-deadline-date").calendar({
            // minDate: new Date($.date_today.getFullYear(), $.date_today.getMonth(), $.date_today.getDate(), $.date_today.getHours() + 3, $.date_today.getMinutes()),
            // maxDate: new Date($.date_today.getFullYear(), $.date_today.getMonth() + 3, $.date_today.getDate()),
            startCalendar: $("#calendar-dissemination-date"),
            today: true,
            onChange: function(date) {
                // console.log($(this).calendar("get startDate"));
                if(date != null) {
                    $(this).prev().val(getDateTime(date, true));
                } else {
                    $(this).prev().val("");
                }
            }
        });
        // $("#calendar-dissemination-date").calendar("set minDate", new Date($.date_today.getFullYear(), $.date_today.getMonth(), $.date_today.getDate(), $.date_today.getHours(), $.date_today.getMinutes()));
        // $("#calendar-deadline-date").calendar("set minDate", new Date($.date_today.getFullYear(), $.date_today.getMonth(), $.date_today.getDate(), $.date_today.getHours() + 3, $.date_today.getMinutes()));
        // $("#calendar-deadline-date").calendar("set maxDate", new Date($.date_today.getFullYear(), $.date_today.getMonth() + 3, $.date_today.getDate()));
    }, 100);

    setInterval(function() {
        if($("#calendar-dissemination-date").calendar("get date") == null || getDateTime($("#calendar-dissemination-date").calendar("get date"), false) < getDateTime($.date_today, false)) {
            $("#calendar-dissemination-date").calendar("set date", new Date($.date_today.getFullYear(), $.date_today.getMonth(), $.date_today.getDate(), $.date_today.getHours(), $.date_today.getMinutes()));
        } else {
        }

        if($("#calendar-deadline-date").calendar("get date") == null) {
            $("#calendar-deadline-date").calendar("set date", $("#calendar-deadline-date").calendar("get minDate"))
        }
    }, 100);
    $("#checkbox-set-up-t").on("change", function() {
        if(!$(this).prop("checked")) {
            $(this).closest(".field").next().addClass("disabled");
            // $("#slider-time-limit").find("input", function() {
            //     $(this).attr("disabled", "disabled");
            // });
        } else {
            $(this).closest(".field").next().removeClass("disabled");
            // $("#slider-time-limit").find("input", function() {
            //     $(this).removeAttr("disabled");
            // });
        }
    });

    $(".ui.dropdown").dropdown({
        label: {
            variation: "black"
        }
    });

    
    $('.ui.dropdown').has("#dropdown-prerequisites").dropdown({
        fullTextSearch: true,
        apiSettings: {
            action: "fetch_educ_course",
            on: "focusin",
            debug: false,
            urlData: {
                fetch: "courses",
                query: function() {
                    return $('.ui.dropdown').has("#edit-dropdown-prerequisites").find("#edit-dropdown-prerequisites").attr("data-course-code");
                }
            },
            cache: false
        },
        filterRemoteData: true,
        saveRemoteData: false,
        label: {
            variation: "black"
        }
    });

    $('.ui.dropdown').has("#edit-dropdown-prerequisites").dropdown({
        fullTextSearch: true,
        apiSettings: {
            action: "fetch_educ_course",
            on: "focusin",
            debug: false,
            urlData: {
                fetch: "courses",
                query: function() {
                    return $('.ui.dropdown').has("#edit-dropdown-prerequisites").find("#edit-dropdown-prerequisites").attr("data-course-code");
                }
            },
            cache: false
        },
        filterRemoteData: true,
        saveRemoteData: false,
        label: {
            variation: "black"
        }
    });

    $('.ui.dropdown').has("#class-sections").dropdown({
        fullTextSearch: true,
        apiSettings: {
            on: "focusin",
            debug: false,
            url: "../../_php/api.php?fetch=getClasses&query=" + $("#class-sections").attr("data-course-id"),
            cache: false,
            onComplete: function(response) {
                // console.log(response);
            }
        },
        filterRemoteData: true,
        saveRemoteData: false,
        label: {
            variation: "black"
        }
    });

    $('.ui.dropdown').has("#dropdown-course-category").dropdown({
        fullTextSearch: true,
        allowAdditions: true,
        clearable: true,
        apiSettings: {
            on: "focusin",
            debug: false,
            url: "../../_php/api.php?fetch=getCourseCategories",
            cache: false
        },
        filterRemoteData: true,
        saveRemoteData: false,
        label: {
            variation: "black"
        }
        // onChange: function() {
        //     $("#input-course-suffix").api("query");
        // }
    });

    $('.ui.dropdown').has("#task-creation-category").dropdown({
        fullTextSearch: true,
        allowAdditions: true,
        clearable: true,
        apiSettings: {
            on: "focusin",
            debug: false,
            url: "../../_php/api.php?fetch=getTaskCategories",
            cache: false,
            onComplete: function(response) {
                // console.log(response);
            }
        },
        filterRemoteData: true,
        saveRemoteData: false,
        label: {
            variation: "black"
        }
        // onChange: function() {
        //     $("#input-course-suffix").api("query");
        // }
    });

    $('.ui.dropdown').has("#task-creation-handled-courses").dropdown({
        fullTextSearch: true,
        clearable: true,
        apiSettings: {
            action: "fetch_educ_course",
            debug: false,
            urlData: {
                fetch: "getHandledCourses"
            },
            cache: false
        },
        filterRemoteData: true,
        saveRemoteData: false,
        label: {
            variation: "black"
        }
    });
    
    $('.ui.dropdown').has("#dropdown-filter-course-category").dropdown({
        fullTextSearch: true,
        clearable: true,
        apiSettings: {
            on: "focusin",
            debug: false,
            url: "../../_php/api.php?fetch=getCourseCategories",
            cache: false
        },
        filterRemoteData: true,
        saveRemoteData: false,
        onChange: function() {
            watchCourseCategory();
        },
        onRemove: function() {
            watchCourseCategory();
        },
        label: {
            variation: "black"
        }
    });

    $('.ui.dropdown').has("#dropdown-program").dropdown({
        fullTextSearch: true,
        apiSettings: {
            action: "fetch",
            debug: false,
            urlData: {
                fetch: "programs"
            }
        },
        filterRemoteData: true,
        saveRemoteData: false,
        label: {
            variation: "black"
        }
    });

    

    $('.ui.dropdown').has("#class-dropdown-program").dropdown({
        fullTextSearch: true,
        apiSettings: {
            action: "fetch_educ_course",
            debug: false,
            urlData: {
                fetch: "class_programs",
            }
        },
        filterRemoteData: true,
        saveRemoteData: false,
        label: {
            variation: "black"
        }
    });

    $('.ui.dropdown').has("#dropdown-year-level").dropdown({
        fullTextSearch: true,
        apiSettings: {
            action: "fetch",
            debug: false,
            urlData: {
                fetch: "year_levels"
            }
        },
        filterRemoteData: true,
        saveRemoteData: false,
        label: {
            variation: "black"
        }
    });

    $('.ui.dropdown').has("#class-dropdown-year-level").dropdown({
        fullTextSearch: true,
        apiSettings: {
            action: "fetch_educ_course",
            debug: false,
            urlData: {
                fetch: "class_year_levels",
            }
        },
        filterRemoteData: true,
        saveRemoteData: false,
        label: {
            variation: "black"
        }
    });

    $('.ui.dropdown').has("#dropdown-department").dropdown({
        fullTextSearch: true,
        apiSettings: {
            action: "fetch",
            debug: false,
            urlData: {
                fetch: "departments"
            }
        },
        filterRemoteData: true,
        saveRemoteData: false,
        label: {
            variation: "black"
        },
        onChange: function() {
            var field = $("#input-user-id").closest(".field");
            var value = $("#dropdown-department").val();
            var input_val = $("#user-id").val().trim();
            var hidden_input = $("#hidden-user-id");
            field.removeClass("disabled");
            field.find(".ui.label").text(value + "-");
            hidden_input.val(value + "-" + input_val);
            // field.removeClass("disabled");
        }
    });

    $(".ui.modal").modal({
        blurring: true,
        transition: "scale"
    });

    $("#modal-add-class.ui.modal").modal({
        transition: "fade up"
    });

    $("#modal-remove-class.ui.modal").modal({
        transition: "fade up",
        onHidden: function() {
            $(".ui.dropdown").has("#class-sections").dropdown("clear");
        }
    });

    $("#link-modal-TAC").on("click", function() {
        $("#modal-TAC").modal("toggle");
    });

    $("#button-add-class").on("click", function() {
        $("#modal-add-class").modal("toggle");
    });

    $("#button-remove-class").on("click", function() {
        $("#modal-remove-class").modal("toggle");
    });

    $("#button-submit-add-class").api({
        action: "fetch_educ_course",
        debug: false,
        urlData: {
            fetch: "addClass",
            query: () => {
                $("#form-add-class").form("validate form");
                var is_valid = $("#form-add-class").form("is valid");
                if(!is_valid) {
                    notify("Class has not been created", ("Make sure to fill up the form."), 4, "red", "graduation cap");
                    event.preventDefault();
                } else {
                    var program = $(".ui.dropdown").has("#class-dropdown-program").dropdown("get value");
                    var year_level = $(".ui.dropdown").has("#class-dropdown-year-level").dropdown("get value");
                    var block_section = $("#class-block-section").val();
                    var query = program + "&year_level=" + year_level + "&block_section=" + block_section + "&course_code=" + $("#button-submit-add-class").attr("data-course-id");
                    return query;
                }
            }
        },
        onComplete: function(response) {
            console.log(response);
            var is_valid = $("#form-add-class").form("is valid");
            if(is_valid) {
                if(response.success) {
                    notify("Class has been created", (response["results"][0] + " has been added to your list of Classes for the Course " + $("#button-submit-add-class").attr("data-course-id") + "."), 4, "green", "graduation cap");
                    $("#segment-handled-course-class").api("query");
                } else {
                    notify("Class has not been created", (response["results"][0] + " is already added to your list of Classes for the Course " + $("#button-submit-add-class").attr("data-course-id") + "."), 4, "red", "graduation cap");
                }
            }
        }
    });

    $("#button-submit-remove-class").api({
        action: "fetch_educ_course",
        debug: false,
        urlData: {
            fetch: "removeClass",
            query: () => {
                $("#form-remove-class").form("validate form");
                var is_valid = $("#form-remove-class").form("is valid");
                if(!is_valid) {
                    notify("Classes have not been removed", ("Make sure to select atleast one Class"), 4, "red", "graduation cap");
                    event.preventDefault();
                } else {
                    var sections = $(".ui.dropdown").has("#class-sections").dropdown("get value");
                    var query = sections + "&course_code=" + $("#button-submit-remove-class").attr("data-course-id");
                    return query;
                }
            }
        },
        onComplete: function(response) {
            var is_valid = $("#form-remove-class").form("is valid");
            if(is_valid) {
                if(response.success) {
                    notify("Classes have been removed", ("Classes have been removed from this Handled Course"), 4, "green", "graduation cap");
                    $("#segment-handled-course-class").api("query");
                } else {
                    notify("Classes have not been removed", ("Classes have not been removed from this Handled Course"), 4, "red", "graduation cap");
                }
                $(".ui.dropdown").has("#class-sections").dropdown("clear");
            }
        }
    });
    
    $("#form-add-course").form();
    $("#modal-add-course").sidebar({
        transition: "slide along"
    });

    $("#form-edit-course").form({
        inline: true,
        on     : 'submit',
        prompt : {
            empty: '{name} must not be empty',
            integer: "{name} must be a number"
        },
        fields : {
            "course_edit[course_category]": "empty",
            "course_edit[course_suffix]": "empty",
            "course_edit[course_title]": "empty",
            "course_edit[course_description]": "empty",
            "course_type[]": "empty",
            "course_edit[course_units]": "integer"
        }
    }).api({
        debug: false,
        url: "../../_php/api.php?fetch=getCourseInfo&query=" + $("#button-edit-course").attr("data-course-id"),
        cache: false,
        onComplete: function(response) {
            if(response.success) {
                if(response["results"]["Course Prerequisites"] == "") {
                    response["results"]["Course Prerequisites"] = "[]";
                }
                setEditCourseForm(response["results"]);
            }
        }
    });

    $("#form-add-class").form({
        inline: true,
        on: "blur",
        prompt : {
            empty: '{name} must not be empty',
            integer: "{name} must be a number"
        },
        fields : {
            "class[program_id]": "empty",
            "class[year_level_id]": "empty",
            "class[block_section]": "integer"
        }

    });

    $("#form-remove-class").form({
        inline: true,
        on: "blur",
        prompt : {
            empty: '{name} must not be empty',
            integer: "{name} must be a number"
        },
        fields : {
            "class_sections[]": "empty"
        }

    });

    $("#modal-edit-course").sidebar({
        transition: "slide along"
    });

    $("#button-add-course").on("click", function() {
        $("#modal-add-course").sidebar("toggle");
    });

    $("#button-edit-course").on("click", function() {
        $("#modal-edit-course").sidebar("toggle");
        $("#header-edit-course-title").text("Modify " + $("#button-edit-course").attr("data-course-id") + " Course");

        $("#form-edit-course").api({
            debug: false,
            url: "../../_php/api.php?fetch=getCourseInfo&query=" + $("#button-edit-course").attr("data-course-id"),
            cache: false,
            onComplete: function(response) {
                if(response.success) {
                    if(response["results"]["Course Prerequisites"] == "") {
                        response["results"]["Course Prerequisites"] = "[]";
                    }
                    setEditCourseForm(response["results"]);
                }
            }
        });
        $("#form-edit-course").api("query");
    });

    function setEditCourseForm(values) {

        $(".ui.dropdown").has("#edit-dropdown-prerequisites").dropdown("show");
        $(".ui.dropdown").has("#edit-dropdown-prerequisites").dropdown("hide");
        $("#form-edit-course").form("set values", {
            "course_edit[course_category]": values["Course Category"],
            "course_edit[course_suffix]": values["Course Suffix"],
            "course_edit[course_title]": values["Course Title"],
            "course_edit[course_description]": values["Course Description"],
            "course_type[]": $.parseJSON(values["Course Type"]),
            "course_edit[course_units]": values["Course Units"],
            "course_prerequisites[]": $.parseJSON(values["Course Prerequisites"])
        });
        $("#button-submit-edit-course").attr("value", values["Course Code"]);
        
        $("#form-edit-course").api("destroy");
    }

    // funct
    $("#segment-handled-course-class").api({
        on: "now",
        debug: false,
        url: "../../_php/api.php?fetch=getHandledCourseClasses&query=" + $("#segment-handled-course-class").attr("data-course-id"),
        cache: false,
        onComplete: function(response) {
            // console.log(response);
            $("#segment-handled-course-class").html(response["results"][0]);
        }
    });


    $("*[data-title]").each(function() {
        $(this).popup({
            on: "hover",
            variation: "inverted mini",
            position: "top center"
        });
    });

    // $("input").popup({
    //     on: "focus",
    //     variation: "inverted mini",
    //     position: "top center"
    // });

    // $("input").on("focusin", function() {
    //     $(this).popup("show");
    // });
    
    // $("input").on("focusout", function() {
    //     $(this).popup("hide");
    // });

    $(".item-menu-item").popup({
        on: "hover",
        variation: "wide basic mini",
        hoverable: true
    });

    $('.ui.accordion').accordion({
        exclusive: false
    });

    // $("a").on("click", function() {
    //     $("#page-loader").addClass("active");
    // });

    // $.fn.api.settings.successTest = function(response) {
    //     console.log(response);
    //     if(response && response.success) {
    //         return response.success;
    //     }
    //     return false;
    // };

    $('.message .close').on('click', function() {
        $(this).closest('.message').transition('fade');
    });

    // $(body).bind("DOMSubtreeModified", function() {

    // });

    $(".textarea-auto-height").on("input", function(event) {
        $(this).css("height", "");
        $(this).css("height", ($(this)[0].scrollHeight + 2) + "px");
    });

    $(".textarea-with-counter").on("input", function(event) {
        var counter = $(".textarea-with-counter ~ .textarea-counter");
        var counter_val = $(this)[0].textLength;
        var counter_max = parseInt($(this).attr("maxlength"));
        var style = (counter_val >= counter_max) ? "style='color: var(--red);'" : null;
        var html = "<span " + style + ">" + counter_val + "</span> / " + counter_max + " Characters";
        counter.html(html);
        if(counter_val == 0) {
            counter.html("");
        }
    });

    $('.ui.search').search({
        type: 'category',
        source: {
            "results": {
              "category1": {
                "name": "Category 1",
                "results": [
                  {
                    "title": "Result Title",
                    "url": "/optional/url/on/click",
                    "image": "optional-image.jpg",
                    "price": "Optional Price",
                    "description": "Optional Description"
                  },
                  {
                    "title": "Result Title",
                    "url": "/optional/url/on/click",
                    "image": "optional-image.jpg",
                    "price": "Optional Price",
                    "description": "Optional Description"
                  }
                ]
              },
              "category2": {
                "name": "Category 2",
                "results": [
                  {
                    "title": "Result Title",
                    "url": "/optional/url/on/click",
                    "image": "optional-image.jpg",
                    "price": "Optional Price",
                    "description": "Optional Description"
                  }
                ]
              }
            },
            // optional action below results
            "action": {
              "url": '/path/to/results',
              "text": "View all 202 results"
            }
          }
    });

    $("#form-sign-up-educator").form({
        inline : true,
        on     : 'submit',
        prompt : {
            empty: '{name} must not be empty',
            match: "{name} must match the Password you entered",
            checked: "You must allow STMS to use these Information",
            number: "{name} must be a Number"
        },
        fields : {
            "user[given_name]": "empty",
            "user[family_name]": "empty",
            "user[barangay]": "empty",
            "user[city]": "empty",
            "user[province]": "empty",
            "user[birth_month]": "empty",
            "user[birth_day]": "empty",
            "user[birth_year]": "empty",
            "user[gender]": "empty",
            "user[department]": "empty",
            "user[dummy_username]": ["empty", "exactLength[4]", "number"],
            "user[password]": "empty",
            "user[password_confirmation]": "match[user[password]]",
            "user[has_accepted_TAC]": "checked"
        },
        onSuccess: function() {
            if(!$.is_user_id_valid) {
                event.preventDefault();
                notify("Unique ID already exists", "The ID that you typed is already registered", 4, "red", "key");
            }
        }
    });


    $("#form-add-course").form({
        inline: true,
        on     : 'submit',
        prompt : {
            empty: '{name} must not be empty',
            integer: "{name} must be a number"
        },
        fields : {
            "course[course_category]": "empty",
            "course[course_suffix]": "empty",
            "course[course_title]": "empty",
            "course[course_description]": "empty",
            "course_type[]": "empty",
            "course[course_units]": "integer"
        },
        onSuccess: function() {
            if(!$.is_course_valid) {
                notify("Course already exists", "The course code that you type is already registered.", 4, "red", "book");
                event.preventDefault();
            }
        }
    });

    $("#form-sign-up-student").form({
        inline : true,
        on     : 'submit',
        prompt : {
            empty: '{name} must not be empty',
            match: "{name} must match the Password you entered",
            checked: "You must accept STMS's Terms and Conditions"
        },
        fields : {
            "user[given_name]": "empty",
            "user[family_name]": "empty",
            "user[barangay]": "empty",
            "user[city]": "empty",
            "user[province]": "empty",
            "user[birth_month]": "empty",
            "user[birth_day]": "empty",
            "user[birth_year]": "empty",
            "user[gender]": "empty",
            "user[student_number]": ["empty", "exactLength[8]"],
            "user[program_id]": "empty",
            "user[year_level]": "empty",
            "user[block_section]": "empty",
            "user[password]": "empty",
            "user[password_confirmation]": "match[user[password]]",
            "user[has_accepted_TAC]": "checked"
        },
        onSuccess: function() {
            if(!$.is_user_id_valid) {
                event.preventDefault();
                notify("Unique ID already exists", "The ID that you typed is already registered", 4, "red", "key");
            }
        }
    });


    $.is_password_valid = true;
    $("#form-sign-in-student").form({
        inline : true,
        on     : 'submit',
        prompt : {
            empty: '{name} must not be empty',
            match: "{name} must match the Password you entered",
            checked: "You must accept STMS's Terms and Conditions"
        },
        fields : {
            "user[student_number]": ["empty", "exactLength[8]"],
            "user[password]": "empty"
        },
        onSuccess: function() {
            if(!$.is_user_id_valid) {
                event.preventDefault();
                notify("Unique ID does not exist", "The ID that you typed is invalid.", 4, "red", "key");
            } else {
                $("#password").api("query");
                if(!$.is_password_valid) {
                    event.preventDefault();
                    notify("Invalid Password", "The password that you typed is incorrect.", 4, "red", "key");
                }
            }
        }
    })

    $("#user-id").on("input", function() {
        var field = $("#input-user-id").closest(".field");
        var value = $("#dropdown-department").val();
        var input_val = $("#user-id").val().trim();
        var hidden_input = $("#hidden-user-id");
        // field.removeClass("disabled");
        // field.find(".ui.label").text(value + "-");
        hidden_input.val(value + "-" + input_val);
    });
    
    $("#password").api({
        action: "fetch",
        debug: false,
        urlData: {
            fetch: "checkPassword " + $("#button-submit").val(),
            query:  function() {
                return $("#user-id").val() + "&pass=" + $("#password").val();
            }
        },
        onComplete: function(response) {
            // if(response != undefined) {
                if(!response.success) {
                    $.is_password_valid = false;
                } else {
                    $.is_password_valid = true;
                }
            // }
        }
    });

    $("#form-sign-in-educator").form({
        inline : true,
        on     : 'submit',
        prompt : {
            empty: '{name} must not be empty',
            match: "{name} must match the Password you entered",
            checked: "You must accept STMS's Terms and Conditions"
        },
        fields : {
            "user[username]": "empty",
            "user[password]": "empty"
        },
        onSuccess: function() {
            if(!$.is_user_id_valid) {
                event.preventDefault();
                notify("Unique ID does not exist", "The ID that you typed is invalid.", 4, "red", "key");
            } else {
                $("#password").api("query");
                if(!$.is_password_valid) {
                    event.preventDefault();
                    notify("Invalid Password", "The password that you typed is incorrect.", 4, "red", "key");
                }
            }
        }
    });


    function removeCheck(field, icon) {
        // console.log($(icon).removeClass("check green"));
        // console.log($(field));
        $(icon).removeClass("check green circle");
        // if(message != "") {
        //     alertify.message(message).delay(4);
        // }
        // $(field).attr("data-variation", "inverted mini");
        // $(field).attr("data-title", message);
        if($(field).val().trim() == "") {
            $(field).removeAttr("data-variation");
            $(field).removeAttr("data-content");
        }
    }

    function addCheck(field, icon) {
        // console.log($(icon));
        // console.log($(field));
        if($(field).val().trim() != "") {
            $(icon).addClass("check green circle");
            $(field).removeAttr("data-variation");
            $(field).removeAttr("data-title");
        }
    }


    $("#password").on("keyup", function() {
        $("#password-confirmation").attr("pattern", $(this).val());
    });

    $("#input-user-id[data-sign-in]").api({
        action: "fetch",
        debug: false,
        urlData: {
            fetch: "checkUserID " + $("#button-submit").val(),
            query:  function() {
                return $("#user-id").val();
            }
        },
        on: "focusout",
        onSuccess:  function() {
        },
        onFailure: function() {
        },
        onComplete: function(response) {
            if(response.success) {
                addCheck("#user-id", "#icon-user-id");
                $.is_user_id_valid = true;
            } else {
                removeCheck("#user-id", "#icon-user-id");
                notify("Unique ID does not exist", "The ID that you typed is invalid.", 4, "red", "key");
                $.is_user_id_valid = false;
            }
        }
    });

    $("#input-course-suffix").api({
        action: "fetch_educ_course",
        debug: false,
        urlData: {
            fetch: "checkCourseCode",
            query:  function() {
                return $("#dropdown-course-category").val() + " " + $("#course-course-suffix").val();
            }
        },
        on: "focusout",
        onSuccess: function() {
            if($("#form-add-course").form("is valid", "course[course_category]") && $("#form-add-course").form("is valid", "course[course_suffix]")) {
                removeCheck("#course-course-suffix", "#icon-course-suffix");
                notify("Course already exists", "The course code that you type is already registered.", 4, "red", "book");
                $.is_course_valid = false;
                $("#course-course-suffix").popup("show");
                setTimeout(function() {
                    $("#course-course-suffix").popup("hide");
                }, 2000);
            }
        },
        onFailure: function() {
            if($("#form-add-course").form("is valid", "course[course_category]") && $("#form-add-course").form("is valid", "course[course_suffix]")) {
                addCheck("#course-course-suffix", "#icon-course-suffix");
                $.is_course_valid = true;
            } else {
                removeCheck("#course-course-suffix", "#icon-course-suffix");
            }
        }
    });
    
    $("#input-user-id[data-sign-up]").api({
        action: "fetch",
        debug: false,
        urlData: {
            fetch: "checkUserID " + $("#button-submit").val(),
            query:  function() {
                if($("#button-submit").val() == "student") {
                    return $("#user-id").val();
                } else if($("#button-submit").val() == "educator") {
                    return $("#hidden-user-id").val();
                }
            }
        },
        on: "focusout",
        onSuccess: function() {
        },
        onFailure:  function() {
        },
        onComplete: function(response) {
            if(response.success) {
                removeCheck("#user-id", "#icon-user-id");
                notify("Unique ID already exists", "The ID that you typed is already registered", 4, "red", "key");
                $.is_user_id_valid = false;
            } else {
                addCheck("#user-id", "#icon-user-id");
                $.is_user_id_valid = true;
            }
        }
    });

    $(".card-add-to-button").each(function() {$(this).api({
        // loadingDuration : 1000,
        action: "fetch_educ_course",
        debug: false,
        urlData: {
            fetch: "addToHandledCourses",
            query: () => {
                var query = $(this).attr("data-course-id");
                if(query == undefined) {
                    query = $(this).attr("data-course-id");
                }
                return query;
            }
        },
        on: "click",
        onComplete: (response, element, xhr) => {
            if(response.success) {
                var course = $(this).attr("data-course-id");
                notify("Course has been added", (course + " has been added to your Handled Courses."), 4, "green", "bookmark");
                $(this).addClass("disabled");
                $(this).next("button").removeClass("disabled");
                $(this).css("display", "none");
                $(this).addClass("disabled");
                $(this).closest(".card-link").attr("data-course-type", "handled");
                var remove_btn = (".card-remove-from-button[data-course-id='" + $(this).attr("data-course-id") + "']");
                $(remove_btn).css("display", "");
                $(remove_btn).removeClass("disabled");
                watchCourseCategory();
                watchCourseType();
                
                $("#segment-handled-course-class").api("query");
                $("#button-add-class").show();
                // $("#button-remove-class").show();
            }
        }
    })});

    function notify(header_message, message, delay, color, icon) {
        alertify.message("\
            <div class='ui inverted inverted segment notification-popup'>\
                <h6 class='ui inverted " + color + " header'>\
                    <i class='" + icon + " icon'></i>\
                    <div class='content'>\
                        " + header_message + "\
                        <div class='sub header'>" + message + "</div>\
                    </div>\
                </h6>\
            </div>\
        ").delay(delay);
    }

    $.force = "no";
    $(".card-remove-from-button").each(function() {$(this).api({
        // loadingDuration : 1000,
        action: "fetch_educ_course",
        debug: false,
        urlData: {
            fetch: "removeFromHandledCourses",
            query: () => {
                var query = $(this).attr("data-course-id") + "&btn_id=" + $(this).attr("id") + "&force=" + $.force;
                if(query == undefined) {
                    query = $(this).attr("data-course-id") + "&btn_id=" + $(this).attr("id") + "&force=" + $.force;
                }
                return query;
            }
        },
        on: "click",
        onComplete: (response, element, xhr) => {
            if(response.success) {
                var course = $(this).attr("data-course-id");
                alertify.message("\
                    <div class='ui inverted inverted segment notification-popup'>\
                        <h6 class='ui inverted red header'>\
                            <i class='bookmark outline icon'></i>\
                            <div class='content'>\
                                Course has been removed\
                                <div class='sub header'>" + course + " has been removed from your Handled Courses.</div>\
                            </div>\
                        </h6>\
                    </div>\
                ").delay(4);
                $(this).addClass("disabled");
                $(this).next("button").removeClass("disabled");
                $(this).css("display", "none");
                $(this).addClass("disabled");
                $(this).closest(".card-link").attr("data-course-type", "not_handled");
                var add_btn = (".card-add-to-button[data-course-id='" + $(this).attr("data-course-id") + "']");
                $(add_btn).css("display", "");
                $(add_btn).removeClass("disabled");
                watchCourseCategory();
                watchCourseType();

                $("#segment-handled-course-class").api("query");
                $("#button-add-class").hide();
                // $("#button-remove-class").hide();
            } else {
                $(response["results"][0]).appendTo("body");
            }
        }
    })});

    // $(".card-remove-from-button").each(function() {$(this).api({
    //     // loadingDuration : 1000,
    //     action: "fetch_educ_course",
    //     debug: false,
    //     urlData: {
    //         fetch: "removeFromHandledCourses",
    //         query: () => {
    //             var query = $(this).attr("data-course-id") + "&btn_id=" + $(this).attr("id") + "&force=" + $.force;
    //             if(query == undefined) {
    //                 query = $(this).attr("data-course-id") + "&btn_id=" + $(this).attr("id") + "&force=" + $.force;
    //             }
    //             return query;
    //         }
    //     },
    //     on: "click",
    //     onFailure: function() {
            
    //     },
    //     onComplete: (response, element, xhr) => {
    //         if(response.success) {
    //             var course = $(this).attr("data-course-id");
    //             alertify.message("\
    //                 <div class='ui inverted inverted segment notification-popup'>\
    //                     <h6 class='ui inverted red header'>\
    //                         <i class='bookmark outline icon'></i>\
    //                         <div class='content'>\
    //                             Course has been removed\
    //                             <div class='sub header'>" + course + " has been removed from your Handled Courses.</div>\
    //                         </div>\
    //                     </h6>\
    //                 </div>\
    //             ").delay(4);
    //             $(this).addClass("disabled");
    //             $(this).next("button").removeClass("disabled");
    //             $(this).css("display", "none");
    //             $(this).addClass("disabled");
    //             $(this).closest(".card-link").attr("data-course-type", "not_handled");
    //             var add_btn = (".card-add-to-button[data-course-id='" + $(this).attr("data-course-id") + "']");
    //             $(add_btn).css("display", "");
    //             $(add_btn).removeClass("disabled");
    //             watchCourseCategory();
    //             watchCourseType();

    //             $("#segment-handled-course-class").api("query");
    //             $("#button-add-class").hide();
    //             $("#button-remove-class").hide();
    //         } else {
    //             $(response["results"][0]).appendTo("body");
    //         }
    //     }
    // })});

    // $("#button-sign-up").on("click", function() {
    //     $(".ui.form#form-sign-up-student").form("validate form");
    // });

    function fadeUpCards(elem) {
        // if(elem.attr("data-course-visibility") == "visible") {
        //     elem.transition({
        //         animation: "fade up",
        //         duration: 200,
        //         interval: 100
        //     });
        // }
    }

    function checkResults() {
        var cards = $("#cards-link");
        var has_no_result = true;
        cards.children().each(function(i,card) {
            if($(card).css("display") != "none") {
                $(cards).show();
                $("#header-no-result-course").hide();
                has_no_result = false;
            }
            
        });
        if(has_no_result) {
            $(cards).hide();
            $("#header-no-result-course").show();
        }
    }

    $("#sorting-z-a").on("change", function(evt) {
        var cards = $("#cards-link");
        if(this.checked && cards.attr("data-cards-sorting") == "a-z") {
            cards.attr("data-cards-sorting", "z-a");
            fadeUpCards(cards.children());
            cards.children().each(function(i,card){cards.prepend(card)});
            fadeUpCards(cards.children());
        }
    });

    $("#sorting-a-z").on("change", function(evt) {
        var cards = $("#cards-link");
        if(this.checked && cards.attr("data-cards-sorting") == "z-a") {
            cards.attr("data-cards-sorting", "a-z");
            fadeUpCards(cards.children());
            cards.children().each(function(i,card){cards.prepend(card)});
            fadeUpCards(cards.children());
        }
    });

    $('.ui.dropdown').has("#dropdown-filter-course-type").dropdown({
        onChange: function() {
            watchCourseType();
        },
        label: {
            variation: "black"
        }
    });

    $('.ui.dropdown').has("#dropdown-type").dropdown({
        label: {
            variation: "black"
        }
    });

    function watchCourseType() {
        var dropdown = $('.ui.dropdown').has("#dropdown-filter-course-type");
        var dropdown_values = $(dropdown).dropdown("get value");
        var cards = $("#cards-link");
        if(dropdown_values.length == 0) {
            cards.children().each(function(i,card) {
                $(card).attr("data-course-type-visibility", "visible");
                if($(card).attr("data-course-type-visibility") == "visible" && $(card).attr("data-course-category-visibility") == "visible") {
                    $(card).show();
                } else {
                    $(card).hide();
                }
            });
            checkResults();
        } else {
            cards.children().each(function(i,card) {
                if(!dropdown_values.includes($(card).attr("data-course-type"))) {
                    $(card).attr("data-course-type-visibility", "hidden");
                    if($(card).attr("data-course-type-visibility") == "hidden" || $(card).attr("data-course-category-visibility") == "hidden") {
                        $(card).hide();
                    } else {
                        $(card).show();
                    }
                } else {
                    $(card).attr("data-course-type-visibility", "visible");
                    if($(card).attr("data-course-type-visibility") == "visible" && $(card).attr("data-course-category-visibility") == "visible") {
                        $(card).show();
                    } else {
                        $(card).hide();
                    }
                }
            });
            checkResults();
        }

    }

    function watchCourseCategory() {
        var dropdown = $('.ui.dropdown').has("#dropdown-filter-course-category");
        var dropdown_values = $(dropdown).dropdown("get value");
        var cards = $("#cards-link");
        if(dropdown_values.length == 0) {
            cards.children().each(function(i,card) {
                $(card).attr("data-course-category-visibility", "visible");
                if($(card).attr("data-course-type-visibility") == "visible" && $(card).attr("data-course-category-visibility") == "visible") {
                    $(card).show();
                } else {
                    $(card).hide();
                }
            });
            checkResults();
        } else {
            cards.children().each(function(i,card) {
                if(!dropdown_values.includes($(card).attr("data-course-category"))) {
                    $(card).attr("data-course-category-visibility", "hidden");
                    if($(card).attr("data-course-type-visibility") == "hidden" || $(card).attr("data-course-category-visibility") == "hidden") {
                        $(card).hide();
                    } else {
                        $(card).show();
                    }
                } else {
                    $(card).attr("data-course-category-visibility", "visible");
                    if($(card).attr("data-course-type-visibility") == "visible" && $(card).attr("data-course-category-visibility") == "visible") {
                        $(card).show();
                    } else {
                        $(card).hide();
                    }
                }
            });
            checkResults();
        }
    }

    function revalidateTaskNumberings() {
        $.item_count = 0;
        $.total_points = 0;
        $("#segment-task-items-collection .segment-task-item:not(.segment-task-item-basis)").each(function(index, elem) {
            $(this).attr("data-task-item-number", "" + (index + 1));
            $.item_count += 1;
            $.choice_count = 0;

            $(this).find(".input-task-item-point").each(function() {
                $(this).attr("name", "task_item_" + $.item_count + "[point]");
                $.total_points += $(this).val();
                $(this).on("input", function() {
                    countPoints();
                });
            });

            $(this).find(".textarea-task-question").each(function() {
                $(this).attr("name", "task_item_" + $.item_count + "[question]");
            });

            $(this).find(".hidden-task-item-correct-choice").each(function() {
                $(this).attr("name", "task_item_" + $.item_count + "[correct_choice]");
            });

            $(this).find(".content-question-number > span").each(function() {
                $(this).text($.item_count);
            });

            $(this).find(".column-task-choice:not(.column-task-choice-basis)").each(function(index, elem) {
                $.choice_count += 1;
                $(this).attr("data-task-choice-number", "" + (index + 1));

                $(this).find(".textarea-task-choice").each(function() {
                    $(this).attr("name", "task_item_" + $.item_count + "[choice_" + $.choice_count + "]");
                });
            });
            $(this).attr("data-task-item-choice-count", $.choice_count);
        });

        $("#segment-task-items-collection").attr("data-task-item-count", $.item_count);
        $("#label-total-items > .detail").text($.item_count);
        $("#hidden-task-item-count").val($.item_count);
        $("#hidden-task-total-points").val($.total_points);
        countPoints();
    }


    // $(".button-task-add-choice").each(function() {
    //     $(this).on("click", function() {
    //         var add_choice = $(this).closest(".column-add-choice");
    //         var choice = $(".column-task-choice-basis");
    //         var item = $(this).closest(".segment-task-item");
    //         $(add_choice).before($(choice).prop("outerHTML"));
    //         var new_choice = $(this).closest(".column-add-choice").prev();
    //         $(new_choice).removeClass("column-task-choice-basis");
    //         $(new_choice).show("fadeup");
    //         revalidateTaskNumberings();
    //         setUpRemoveChoiceButton(new_choice);

    //         $(new_choice).find(".textarea-auto-height").each(function() {
    //             $(this).on("input", function() {
    //                 $(this).css("height", "");
    //                 $(this).css("height", ($(this)[0].scrollHeight + 2) + "px");
    //             });
    //         });

    //         $(new_choice).find("*[data-title]").each(function() {
    //             $(this).popup({
    //                 on: "hover",
    //                 variation: "inverted mini",
    //                 position: "top center"
    //             });
    //         });
    //     });
    // });

    $(".button-task-add-item").each(function() {
        $(this).on("click", function() {
            var item = $(".segment-task-item-basis");
            var item_collection = $("#segment-task-items-collection");
            $(this).before($(item).prop("outerHTML"));
            var new_item = $(this).prev();
            $(new_item).removeClass("segment-task-item-basis");
            $(new_item).show("fadeup");
            revalidateTaskNumberings();
            setUpAddChoice(new_item);

            $(new_item).find(".button-task-item-remove").each(function() {
                $(this).on("click", function() {
                    // var item_ = $(this).closest(".segment-task-item");
                    $(new_item).remove();
                    revalidateTaskNumberings();
                });
            });

            $(new_item).find(".textarea-auto-height").each(function() {
                $(this).on("input", function() {
                    $(this).css("height", "");
                    $(this).css("height", ($(this)[0].scrollHeight + 2) + "px");
                });
            });
    
            $(new_item).find("*[data-title]").each(function() {
                $(this).popup({
                    on: "hover",
                    variation: "inverted mini",
                    position: "top center"
                });
            });
        });
    });

    function setUpAddChoice(item) {
        $(item).find(".button-task-add-choice").each(function() {
            $(this).on("click", function() {
                var add_choice = $(this).closest(".column-add-choice");
                var choice = $(".column-task-choice-basis");
                var item = $(this).closest(".segment-task-item");
                $(add_choice).before($(choice).prop("outerHTML"));
                var new_choice = $(this).closest(".column-add-choice").prev();
                $(new_choice).removeClass("column-task-choice-basis");
                $(new_choice).show("fadeup");
                revalidateTaskNumberings();
                setUpRemoveChoiceButton(new_choice);
                setUpMarkChoiceButton(new_choice);
    
                $(new_choice).find(".textarea-auto-height").each(function() {
                    $(this).on("input", function() {
                        $(this).css("height", "");
                        $(this).css("height", ($(this)[0].scrollHeight + 2) + "px");
                    });
                });
    
                $(new_choice).find("*[data-title]").each(function() {
                    $(this).popup({
                        on: "hover",
                        variation: "inverted mini",
                        position: "top center"
                    });
                });
            });
        });
    }

    function removeTaskItemChoice(choice) {
        $(choice).closest(".column-task-choice").remove();
        revalidateTaskNumberings();
    }
    
    function markTaskItemChoice(choice) {
        var item = $(choice).closest(".segment-task-item");
        var real_choice = $(choice).closest(".column-task-choice");
        var input_correct_ans = $(item).find(".hidden-task-item-correct-choice");
        revalidateCheckMarks(item);
        $(real_choice).find("textarea").each(function() {
            $(this).addClass("textarea-selected");
            var name = "choice_" + $(real_choice).attr("data-task-choice-number");

            $(input_correct_ans).each(function() {
                $(this).val(name);
            });
            // name = name.replace("]", "_correct]");
            // $(this).attr("name", name);
        });
        $(choice).addClass("active");
    }

    function revalidateCheckMarks(item) {
        $(item).find(".button-task-mark-button").each(function() {
            $(this).removeClass("active");
        });
        $(item).find("textarea").each(function() {
            $(this).removeClass("textarea-selected");
            // $.name = $(this).attr("name");
            // $.name = $.name.replace("_correct]", "]");
            // $(this).attr("name", $.name);
        });
    }

    function countPoints() {
        var points = 0;
        $("#segment-task-items-collection .segment-task-item:not(.segment-task-item-basis)").find(".input-task-item-point").each(function() {
            var value = parseInt($(this).val());
            if(isNaN(value) || value <= 0) {
                value = 0;
            }
            points += value;
        });
        $("#label-total-points > .detail").text(points);
        $("#hidden-task-total-points").val(points);
    }

    function setUpRemoveChoiceButton(choice) {
        // console.log($(choice).find(".button-task-remove-button"));
        $(choice).find(".button-task-remove-button").each(function() {
            $(this).on("click", function() {
                removeTaskItemChoice($(this));
            });
        });
    }

    function setUpMarkChoiceButton(choice) {
        // console.log($(choice).find(".button-task-remove-button"));
        $(choice).find(".button-task-mark-button").each(function() {
            $(this).on("click", function() {
                markTaskItemChoice($(this));
            });
        });
    }



    $(".button-task-remove-button").each(function() {
        setUpRemoveChoiceButton($(this));
    });

    $(".button-task-mark-button").each(function() {
        setUpMarkChoiceButton($(this));
    });

    $("#form-create-task").form({
        inline : true,
        on     : 'submit',
        prompt : {
            empty: '{name} must not be empty'
        },
        fields : {
            "task[handled_course]": "empty"
        },
        // form-create-task
        onSuccess: function() {
            var item_count = parseInt($("#segment-task-items-collection").attr("data-task-item-count"));
            var task_item = $("#segment-task-items-collection .segment-task-item:not(.segment-task-item-basis)");
            if(item_count <= 0 || isNaN(item_count)) {
                notify("No Items in this Task", "Add some items first to your Task.", 4, "red", "tasks");
                event.preventDefault();
            } else {
                var valid = true;
                $(task_item).each(function() {
                    if(!valid) {
                        return false;
                    }
                    var choice_count = parseInt($(this).attr("data-task-item-choice-count"));
                    if(choice_count <= 0 || isNaN(choice_count)) {
                        valid = false;
                        notify("No Choice for some Items", "Some of your items does not have a choice.", 4, "red", "tasks");
                        event.preventDefault();
                    } else if(choice_count == 1) {
                        valid = false;
                        notify("Two Choices are needed", "Some of your items have only one choice.", 4, "red", "tasks");
                        event.preventDefault();
                    } else {
                        $(this).find(".input-task-item-point").each(function() {
                            if(!valid) {
                                return false;
                            }
                            var item_point = parseInt($(this).val());
                            if(item_point <= 0 || isNaN(item_point)) {
                                valid = false;
                                notify("Points are needed for Items", "You must specify a point for each item.", 4, "red", "tasks");
                                event.preventDefault();
                            } else {
                                $(task_item).find(".textarea-task-question").each(function() {
                                    if(!valid) {
                                        return false;
                                    }
                                    var value = $(this).val().trim();
                                    if(!value) {
                                        valid = false;
                                        notify("Questions must not be Empty", "Fill out your questions properly.", 4, "red", "tasks");
                                        event.preventDefault();
                                    } else {
                                        $(task_item).find(".column-task-choice:not(.column-task-choice-basis) .textarea-task-choice").each(function() {
                                            if(!valid) {
                                                return false;
                                            }
                                            var value = $(this).val().trim();
                                            if(!value) {
                                                valid = false;
                                                notify("Choices must not be Empty", "Fill out your choices properly.", 4, "red", "tasks");
                                                event.preventDefault();
                                            } else {
                                                $(task_item).find(".hidden-task-item-correct-choice").each(function() {
                                                    if(!valid) {
                                                        return false;
                                                    }
                                                    var value = $(this).val().trim();
                                                    if(!value) {
                                                        valid = false;
                                                        notify("No Choice is marked as the Correct Answer", "Your items must have a correct answer.", 4, "red", "tasks");
                                                        event.preventDefault();
                                                    } else {
                                                        // var date = $("#input-dissemination-date").val();
                                                        // ("#input-dissemination-date").val(getDateTime(date));
                                                    }
                                                });
                                            }
                                        });
                                    }
                                });
                            }
                        });
                    }
                });
            }
        }
    });

    $(".button-join-class").each(function() {
        $(this).api({
        url: $("#main-script").attr("data-api-path"),
        debug: false,
        urlData: {
            fetch: "joinClass",
            query: () => {
                var handled_course_id = $(this).attr("data-handled-course-id");
                var class_id = $(this).attr("data-class-id");
                var receiver_id = $(this).attr("data-receiver-id");
                var query = handled_course_id + "&class_id=" + class_id + "&receiver_id=" + receiver_id;
                return query;
            }
        },
        onComplete: function(response) {
            console.log(response);
            if(!response.results.accepted && $(this).hasClass("button-join-class")) {
                $(this).find(".button-join-class-text").text("Pending");
                $(this).addClass("disabled yellow");
                $(this).removeClass("inverted green");
                $(this).removeClass("button-join-class");
                $(this).find(".icon").removeClass("right arrow");
                $(this).find(".icon").addClass("right check");
                $(this).attr("data-title", "You must wait for the Educator's Confirmation");
            }
        }     
    })});

    $("#modal-bulletin").modal({
        onVisible: function() {
            // if(!$("#modal-bulletin").modal("is active")) {
                $("#modal-bulletin-segment-display").api("query");
            // }
        }
    });

    $("#modal-bulletin").on("click", function() {
        if($("#modal-bulletin").modal("is active")) {
            event.preventDefault();
        }
    });

    $("#button-bulletin").on("click", function() {
        $("#modal-bulletin").modal("toggle");
    });

    $("#button-bulletin").api({
        url: $("#main-script").attr("data-api-path"),
        on: "focus",
        debug: false,
        urlData: {
            fetch: "getJoinNotificationCount",
            query: () => {
                return "";
            }
        },
        onComplete: function(response) {
            // if(!$("#modal-bulletin").modal("is active")) {
            if(response != undefined) {
                // console.log(response);
                if(response.success) {
                    $(this).find(".icon").addClass("green");
                    $(this).find(".label").css("display", "");
                    $(this).find(".label").text(response.results);
                } else {
                    $(this).find(".icon").removeClass("green");
                    $(this).find(".label").css("display", "none");
                    $(this).find(".label").text(response.results);
                }
            }
            // }
        }
    });

    setInterval(function() {
        if($("#button-bulletin").length) {
            $("#button-bulletin").api("query");
        }
    }, 200);

    $("#modal-bulletin-segment-display").api({
        url: $("#main-script").attr("data-api-path"),
        on: "blur",
        debug: false,
        urlData: {
            fetch: "getJoinNotifications",
            query: () => {
                // var handled_course_id = $(this).attr("data-handled-course-id");
                // var class_id = $(this).attr("data-class-id");
                // var receiver_id = $(this).attr("data-receiver-id");
                // var query = handled_course_id + "&class_id=" + class_id + "&receiver_id=" + receiver_id;
                return "";
            }
        },
        onComplete: function(response) {
            // console.log(response);
            // if(!$("#modal-bulletin").modal("is active")) {
            if(response != undefined) {
                if(response.success) {
                    $(this).removeClass("center aligned");
                    $(this).html(response.results);
                    initNotifButtons();
                } else {
                    $(this).addClass("center aligned");
                    $(this).html(response.results);
                }
            }
            // }
        } 
    });

    function initNotifButtons() {
        $(".button-join-confirm").each(function() {
            $(this).api({
                cache: false,
                debug: true,
                url: $("#main-script").attr("data-api-path-gen") + "?fetch=acceptStudent&" + "query=" + $(this).attr("data-nofication-entry-id") + "&stud=" + $(this).attr("data-student-number")+ "&class=" + $(this).attr("data-class-id"),
                onComplete: function(response) {
                    console.log(response);
                    if(response.success) {
                        notify("Student Verified", "A Student has been added to one of your Classes.", 4, "green", "graduation cap");
                        $("#modal-bulletin-segment-display").api("query");
                    }
                }
            });
        });

        $(".button-join-decline").each(function() {
            $(this).api({
                cache: false,
                debug: true,
                url: $("#main-script").attr("data-api-path-gen") + "?fetch=declineStudent&" + "query=" + $(this).attr("data-nofication-entry-id"),
                onComplete: function(response) {
                    console.log(response);
                    if(response.success) {
                        notify("Student Denied", "You have declined a Student's request to join one in one of your Classes.", 4, "red", "graduation cap");
                        $("#modal-bulletin-segment-display").api("query");
                    }
                }
            });
        });
    }

    $(".button-task-answer-choice-button").each(function() {
        $(this).on("click", function() {
            $(this).closest(".grid-task-answer-choices").find(".button-task-answer-choice-button").each(function() {
                $(this).removeClass("green active textarea-selected");
                $(this).addClass("basic");
            });
            $(this).removeClass("basic");
            $(this).addClass("green active textarea-selected");
            var choice_name = $(this).attr("data-choice-name");
            $(this).closest(".segment-task-answer-item").find(".hidden-task-answer-item-correct-choice").each(function() {
                $(this).val(choice_name);
            });
        });
    });

});