/**
 * @author Herbert Ullrich
 * Scripts that apply throughout the entire website in order to enhance user friendliness by using several simple
 * class names introduced below
 */

$(".noscript").hide();
/**
 * @see class table-fixed-header
 * Snippet that fixes the header of the table below the navbar on scrolling.
 */
$('.table-fixed-header').each(function () {
    var $thead = $(this).find('thead');
    var $scrollingThead = $thead.clone();
    var $div = $("<div>", {'class': 'fixed-header-copy'});
    var $table = $("<table>").attr("class", $(this).attr("class"));
    var $ths = $thead.find('th');
    var $scrollingThs = $scrollingThead.find('th');
    var navbarHeight = $(".fixed-top").outerHeight();

    $table.append($scrollingThead);
    $div.append($table);
    $div.css('top', navbarHeight).appendTo($(this).parent());

    function updateThSizes() {
        for (var i = 0; i < $ths.length; i++) {
            $($scrollingThs[i]).outerWidth($($ths[i]).outerWidth());
        }
    }

    $(window).on('load', updateThSizes);
    $(window).resize(updateThSizes);
    $(window).scroll(function () {
        if ($thead.offset().top - navbarHeight < $(window).scrollTop() && $thead.outerWidth() <= $(window).outerWidth()) {
            $div.css('display', 'block');
        } else {
            $div.css('display', 'none');
        }
    });
});

/**
 * @see class table-fixed-footer
 * Snippet that fixes the footer of the table to the bottom of the display.
 */
$('.table-fixed-footer').each(function () {
    var $tfoot = $(this).find('tfoot');
    var $scrollingTfoot = $tfoot.clone();
    var $div = $("<div>", {'class': 'fixed-footer-copy'});
    var $table = $("<table>", {'class': 'table table-striped'});
    var $tds = $tfoot.find('td');
    var $scrollingTds = $scrollingTfoot.find('td');

    $table.append($scrollingTfoot);
    $div.append($table);
    $div.css('bottom', 0).appendTo($(this).parent());

    function updateTdSizes() {
        for (var i = 0; i < $tds.length; i++) {
            $($scrollingTds[i]).outerWidth($($tds[i]).outerWidth());
        }
    }

    $(window).on('load', updateTdSizes);
    $(window).resize(updateTdSizes);
    $(window).scroll(function () {
        if ($tfoot.offset().top > $(window).scrollTop() + $(window).innerHeight() && $tfoot.outerWidth() <= $(window).outerWidth()) {
            $div.css('display', 'block');
        } else {
            $div.css('display', 'none');
        }
    });
});
var lastChosenCell = null;
var $openModal = null;

function swapCell(cell, html) {
    var $cell = $(html).click(function () {
        openCellForm(this);
    });
    tooltipNote($cell);
    $(cell).replaceWith($cell);
    return $cell;
}

$(".fulfillment-form").on('beforeSubmit', function (e) {
    var form = $(this);
    console.log(form.serialize());
    $.ajax({
        url: form.attr("action"),
        type: form.attr("method"),
        data: form.serialize(),
        success: function (data) {
            if (data.status) {
                $cell = swapCell(lastChosenCell, data.cell);
                $openModal.modal('hide');
                if (data.hasOwnProperty('potentialCell')) {
                    console.log(data.potentialCell);
                    swapCell($cell.parent().find('td:last-child'), data.potentialCell);
                }
            } else {
                alert("Nepodařilo se vyplnit návyk.\n" + data.errors);
            }
        },
        error: function () {
            alert("Něco se nepodařilo.");
        }
    });
}).on('submit', function (e) {
    e.preventDefault();
});
$(".fulfillment-cell").click(function () {
    openCellForm(this);
});
$('.modal').on('shown.bs.modal', function (e) {
    $(this).find('.autofocus-wrapper input,.autofocus-wrapper select').focus();
});

function openCellForm(reference) {
    var $cell = $(reference);
    var data = $cell.data();
    var prefix = "#fulfillment_" + data.habit_id + "_";
    var $modal = $(prefix + "modal");
    var Ymd = data.day.split('-', 3);
    $modal.find('h5 small').text(Ymd[2] + '.' + Ymd[1] + '.' + Ymd[0]);
    for (var i in data) {
        if (i == 'excused') {
            $(prefix + i).prop('checked', data[i]);
            continue;
        }
        $(prefix + i).val(data[i]);
    }
    $openModal = $modal.modal("show");
    $(prefix + 'value').click();
    lastChosenCell = reference;
}
function tooltipNote(reference) {
    var $ref = $(reference);
    var note = $ref.data('note');
    $ref.tooltip({container: 'body', title: note, placement: 'bottom'});
}
$(window).on('load', function () {
    $('[data-note]').each(function () {
        tooltipNote(this);
    });
});

$(".pagination").each(function () {
    $(this).find('li').addClass('page-item');
    $(this).find('a,span').addClass('page-link');
});