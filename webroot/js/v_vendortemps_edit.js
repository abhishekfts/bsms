var branch_office = [0];
var today = new Date();
var year3 =
    today.getMonth() > 3 ? today.getFullYear() : today.getFullYear() - 1;
var year2 = year3 - 1;
var year1 = year2 - 1;
var year0 = year1 - 1;

$(function () {
    $("#productionyear3").text(year2 + "-" + year3);
    $("#productionyear2").text(year1 + "-" + year2);
    $("#productionyear1").text(year0 + "-" + year1);
    $(".placeholder3").attr("placeholder", year2 + " - " + year3);
    $(".placeholder2").attr("placeholder", year1 + " - " + year2);
    $(".placeholder1").attr("placeholder", year0 + " - " + year1);
    $(".year3").val(year2 + " - " + year3);
    $(".year2").val(year1 + " - " + year2);
    $(".year1").val(year0 + " - " + year1);
    bsCustomFileInput.init();
});

$(document).on("change", "#copypermanant", function () {
    if ($(this).is(":checked")) {
        $("#register_office_address1").val(
            $("#id_permanent_address_address1").val()
        );
        $("#register_office_address2").val(
            $("#id_permanent_address_address2").val()
        );
        $("#register_office_pincode").val(
            $("#id_permanent_address_pincode").val()
        );
        $("#register_office_city").val($("#id_permanent_address_city").val());
        $("#register_office_country").val(
            $("#id_permanent_address_country").val()
        );
        $("#register_office_state").val($("#id_permanent_address_state").val());
        $("#register_office_telephone").val(
            $("#id_permanent_address_telephone").val()
        );
        $("#register_office_faxno").val($("#id_permanent_address_faxno").val());
    } else {
        $("#register_office_address1").val("");
        $("#register_office_address2").val("");
        $("#register_office_pincode").val("");
        $("#register_office_city").val("");
        $("#register_office_country").val("");
        $("#register_office_state").val("");
        $("#register_office_telno").val("");
        $("#register_office_faxno").val("");
    }
});

$(document).on("click", ".fully_manufactured_radio", function () {
    if ($(this).val() === "no") {
        $(".sub-contractors-info").show();
    } else {
        $(".sub-contractors-info").hide();
        $("#other_manufacturer").val("");
    }
});

$(document).on("click", ".add", function () {
    var clas = $(this).data("class");
    var sub = $(this).data("sub");
    var havesub = $(this).data("havesub");
    var lastid;
    $("." + clas).each(function (i, obj) {
        lastid =
            $(this).data("sub") == "1"
                ? $(this).data("sub_id")
                : $(this).data("id");
    });

    var str = $("#" + clas + "_" + lastid).html();
    nextid = lastid + 1;

    str = str.replaceAll(clas + "_" + lastid + "_", clas + "_" + nextid + "_"); // Change id
    str = str.replaceAll(" hide", ""); // Show Delete
    str = str.replaceAll(
        "[" + clas + "]" + "[" + lastid + "]",
        "[" + clas + "]" + "[" + nextid + "]"
    ); // Change name
    str = str.replaceAll(
        'data-id="' + lastid + '"',
        'data-id="' + nextid + '"'
    ); // Change data-id

    if (sub == 1) {
        str = str.replaceAll(
            'data-sub_id="' + lastid + '"',
            'data-sub_id="' + nextid + '"'
        );
    } else {
        str = str.replaceAll(
            'data-id="' + lastid + '"',
            'data-id="' + nextid + '"'
        );
    }
    $("." + clas + "_card_body").append(
        '<div class="row ' +
            clas +
            " " +
            clas +
            "_" +
            nextid +
            '" data-id="' +
            nextid +
            '" id="' +
            clas +
            "_" +
            nextid +
            '">' +
            str +
            '</div><hr class="' +
            clas +
            "_" +
            nextid +
            '" style="border: revert;">'
    );

    if (havesub == 1) {
        var subclass = $(this).data("subclass");
        $("." + clas + "_" + nextid + "_" + subclass).each(function (i, obj) {
            if (i > 0) {
                $(obj).remove();
                $(
                    "." + clas + "_" + nextid + "_" + subclass + "_" + i
                ).remove();
            }
        });
    }
});

// maximum length validation funcation
function validateMaxLength(inputElement) {
    var inputValue = inputElement.val();
    var maxLength = parseInt(inputElement.attr("maxlength"));
    if (inputValue.length > maxLength) {
        inputValue = inputValue.slice(0, maxLength);
        inputElement.val(inputValue);
    }
}

$(document).on("input", ".maxlength_validation", function () {
    validateMaxLength($(this));
});

$(document).on("keypress", ".alphaonly", function (event) {
    var regex = new RegExp("^[A-Za-z ]+$");
    var key = String.fromCharCode(
        !event.charCode ? event.which : event.charCode
    );
    if (!regex.test(key)) {
        event.preventDefault();
        return false;
    }
});

$(".UpperCase").on("keyup", function () {
    var upperCaseText = $(this).val().toUpperCase();
    $(this).val(upperCaseText);
});

$("#id_bank_country").on("change", function () {
    var swiftBicField = $("#id_swift_bic").closest(".col-3");
    if ($(this).val() === "India") {
        swiftBicField.hide().val("");
        id_swift_bic;
    } else {
        swiftBicField.show();
    }
});

$(document).ready(function () {
    var isFirstInput = true;

    $(document).on("keypress", ".alphaafternumberonly", function (event) {
        var key = String.fromCharCode(
            !event.charCode ? event.which : event.charCode
        );

        if (isFirstInput) {
            if (/^[0-9]+$/.test(key)) {
                event.preventDefault();
                return false;
            }
            isFirstInput = false;
        } else {
            if (!/^[A-Za-z0-9 ]+$/.test(key)) {
                event.preventDefault();
                return false;
            }
        }
    });
});

function capitalizeFirstLetter(str) {
    return str.charAt(0).toUpperCase() + str.slice(1);
}

$(document).on("input", ".capitalize", function () {
    var inputValue = $(this).val();
    if (inputValue.length > 0) {
        $(this).val(capitalizeFirstLetter(inputValue));
    }
});

datePickerId.max = new Date().toISOString().split("T")[0];

$(document).on("click", ".showme", function () {
    var trigger = $(this).data("trigger");
    if ($(this).val() == trigger) {
        $("#" + $(this).data("show")).show();
    } else {
        $("#" + $(this).data("show")).hide();
    }
});

$(document).on("click", ".delete", function () {
    var nextid = $(this).data("id");
    var clas = $(this).data("class");
    var getarray = [];
    var lastid;
    $("." + clas).each(function (i, obj) {
        lastid = $(obj).data("id");
        getarray.push(lastid);
    });
    if (getarray.length != 1) {
        $("." + clas + "_" + nextid).remove();
    }
});


function getRemote(
    remote_url,
    method = "GET",
    type = "json",
    convertapi = true
) {
    var resp = $.ajax({
        type: method,
        dataType: type,
        url: remote_url,
        async: false,
    }).responseText;
    if (convertapi) {
        return JSON.parse(resp);
    }
    return resp;
}

$(document).on("change", ".my-country", function () {
    var country_code = $(this).val();
    var resp = getRemote(
        baseurl + "api/api/country-by-state/" + country_code
    );
    var opt = "<option selected=''>Please Select</option>";
    resp = resp["message"];
    $.each(resp["States"], function (i, v) {
        opt += `<option value="` + v.region_code + `">` + v.name + `</option>`;
    });
    //  $("#id_permanent_address_state").html(opt);
    $("#" + $(this).data("state")).html(opt);
});
