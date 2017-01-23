
/*форматирование даты*/
dspApp.filter('dateFormat', function() {
    return function(input_date) {
        var d = moment(input_date);
        return d.format("DD.MM.YYYY");
    };
});

/*форматирование цены*/
dspApp.filter('priceFormat', function() {
    return function(input_price) {
        var price       = Number.prototype.toFixed.call(parseFloat(input_price) || 0, 0),
        //заменяем точку на запятую
            price_sep   = price.replace(/(\D)/g, ","),
        //добавляем пробел как разделитель в целых
            price_sep   = price_sep.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1 ");

        return price_sep;
    };
});