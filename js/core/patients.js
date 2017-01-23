/**
 * Created by User on 25.04.2016.
 */

function ToWork(patient_id)
{
    $("#f_patient_id").val(patient_id);
    $('#ModalToWork').modal('show');
}


$(document).ready(function() {

    $('.hasDatepicker2').datetimepicker({
        format:'Y-m-d',
        lang:'ru',
        timepicker:false,
        closeOnDateSelect:true,
    });

    $("#search-button").click(function () {

        console.info('earch');

       var ff = $('#search_form_1').serializeArray();

        $.get(
            "/ajax/search_new",
            ff,
            function (data) {
                $('#patients_table').bootstrapTable('load', data);
            }, "json"
        ); //$.get  END*/
    });

});

function LoadSearchXML()
{
    console.info("load");
    var ff = $('#search_form_1').serializeArray();
    $('#ModalLoadXML').modal('show');


}