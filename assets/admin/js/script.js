// $('div.alert').not('.alert-important').delay(3000).fadeOut(350);

// $(".delete").on("submit", function () {
//     // alert("hatem");
//     // return  Lobibox.confirm({
//     //     msg: "Are you sure you want to delete this user?",
//     // });
//     return confirm('هل انت متاكد من الحذف ؟');
//     // return confirm("Are you sure?");
// });

$('.select2').select2({
    // dir: "rtl"
});
var currentDate = new Date();
$(".datepicker").datepicker({
    // dateFormat: 'yy-mm-dd'
    dateFormat: 'yy-mm-dd',
    changeMonth: true,
    // setDate: currentDate,
    // regional: "ar" ,
    // yearRange: “c-70:c+10”,
    // isRTL: true,
    changeYear: true,

});
$(".birthDate").datepicker({
    // dateFormat: 'yy-mm-dd'
    dateFormat: 'yy-mm-dd',
    changeMonth: true,
    // setDate: currentDate,
    // regional: "ar" ,
    // yearRange: “c-70:c+10”,
    // isRTL: true,
    changeYear: true,
    yearRange: '-100:+0'

})
// .datepicker("setDate", new Date())

$(".datepickerToday").datepicker({
    // dateFormat: 'yy-mm-dd'
    dateFormat: 'yy-mm-dd',
    changeMonth: true,
    // setDate: currentDate,
    // regional: "ar" ,
    // yearRange: “c-70:c+10”,
    // isRTL: true,
    changeYear: true,

})
.datepicker("setDate", new Date())
;

function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}


$(".numberonly2").keypress(function (e) {
    //if the letter is not digit then display error and don't type anything
    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        //display error message
        // console.log( $(this).next().next());
        // $(this).next().text("برجاء ادخال ارقام فقط").show().fadeOut(2000);
        return false;
    }
});
$(".floatonly2").keypress(function (event) {
    //if the letter is not digit then display error and don't type anything
    if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
        //display error message
        // console.log( $(this).next().next());
        // $(this).next().text("{{trans('main.number_only')}}").show().fadeOut(2000);
        return false;
    }
});

if ($("#filter-from, #filter-to").length > 0) {
    var dateToday = new Date();
    var dates = $("#filter-from, #filter-to").datepicker({
        // defaultDate: "+1w",
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        changeYear: true,
        numberOfMonths: 2,
        // isRTL: true,
        // minDate: dateToday,
        onSelect: function (selectedDate) {
            var option = this.id == "filter-from" ? "minDate" : "maxDate",
                instance = $(this).data("datepicker"),
                date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings);
            dates.not(this).datepicker("option", option, date);
        }
    });
}

$(document).ready(function () {

    $('.footable').footable({
        paginate: false
        // "stopPropagation": true
        // "columns": [{
        //     "sortable": true
        // }]
    });


});


// $('button[type="submit"]').on("click", function (e) {
$('.disableOnSubmit').on("click", function (e) {
    e.preventDefault();
// alert();
//     alert("hatem");
    $(this).prop('disabled', true);
    // $(this).attr("type", "button");
    // return false;
    $(this).closest("form").submit();
    // alert("hatem");
    // return confirm("Are you sure?");
});