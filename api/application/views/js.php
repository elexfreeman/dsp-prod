<script>

    /*Обработчик фамилии/имени/отчества */
    function PatientFormatter(value, row, index) {
        var a = value.split(':');
        return [
            '<a href="/patient/show/'+a[1]+'"><span class="text-semibold">'+a[0]+'</span></a>'
        ].join('');
    }

    /*Обработчик фамилии/имени/отчества */
    function LPUFormatter(value, row, index) {
        var a = value.split(':');
        <?php
        if($auth->login=='admin')
            echo "var admin=true;";
        else
        echo "var admin=false;";
    ?>
        if(admin==true)
        {
            return [
                a[0]+' <a href="/patient/edit/'+a[1]+'" class="btn btn-info" type="button" id="search-button">Изменить</a>'
            ].join('');
        }
        else
        {
            return [
                a[0]
            ].join('');
        }

    }

    function detailFormatter(index, row) {
        var html = [];
        $.each(row, function (key, value) {
            html.push('<p><b>' + key + ':</b> ' + value + '</p>');
        });
        return html.join('');
    }

    /*форматирование кнопки в работе*/
    function FDateFormatter(value, row, index) {
        var a = value.split('&');

        if(a[0].length<3)
        {
            return [
                '<button onclick="ToWork('+a[1]+')" class="btn btn-info" type="button" >В работе</button>'
            ].join('');

        }
        else
        {
            return [
                a[0]
            ].join('');
        }

    }


    $(document).ready(function() {

        /*выставляем таблицу пациентов*/


        $('#patients_table').bootstrapTable({
            url: '/ajax/search_new',
            columns: [
                {
                    field: 'ProtocolDate',
                    title: 'Дата выдачи'
                    ,sortable: true
                },
                {
                    field: 'LastName',
                    title: 'Фамилия'
                    ,sortable: true,
                    formatter:PatientFormatter
                },
                {
                    field: 'FirstName',
                    title: 'Имя',
                    searchable:true
                    ,sortable: true,
                    formatter:PatientFormatter
                },

                {
                    field: 'SecondName',
                    title: 'Отчество'
                    ,sortable: true,
                    formatter:PatientFormatter
                },
                {
                    field: 'BirthDate',
                    title: 'Дата рождения'
                    ,sortable: true
                },
                {
                    field: 'RegAddress',
                    title: 'Адрес регистрации'
                },
                {
                    field: 'SNILS',
                    title: 'СНИЛС'
                },
                {
                    field: 'LPUCODE',
                    title: 'ЛПУ'
                    ,sortable: true,
                    formatter:LPUFormatter
                },
                {
                    field: 'f_date',
                    title: '-'
                    ,sortable: true,
                    formatter:FDateFormatter
                },



            ]
        });
    });
</script>