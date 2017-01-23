// MORRIS BAR CHART
// =================================================================
// Require MorrisJS Chart
// -----------------------------------------------------------------
// http://morrisjs.github.io/morris.js/
// =================================================================

$.get(
    "/adminpanel/GetStat",
    {

    },
    function (data) {

        Morris.Bar({
            element: 'demo-morris-bar',
            data: data
            ,
            xkey: 'insert_date',
            ykeys: ['xml_count', 'files_count','p_count'],
            labels: ['Всего загруженно', 'Всего файлов','Неопределено'],
            gridEnabled: false,
            gridLineColor: 'transparent',
            barColors: ['#177bbb', '#afd2f0','#dedede'],
            resize:true,
            hideHover: 'auto'
        });/**
         * Created by User on 29.06.2016.
         */


    }, "json"
); //$.get  END

