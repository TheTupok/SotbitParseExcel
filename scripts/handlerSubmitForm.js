import {ExceptionFilterService} from '../services/exceptionFilter.service.js';

class HandlerSubmitForm {
    dataExcel = [];
    headerTable = '';

    onloadApp() {
        $.ajax({
            type: 'POST',
            url: 'core/parseExcel.php',
            success: (result) => {
                this.dataExcel = JSON.parse(result);
                document.getElementById('btn-parse').style.display = '';
                this.headerTable = this.dataExcel.shift().join('');
                this.sendFilterAndReturnData('');
            }
        });
    }

    sendFilterAndReturnData(filter) {
        $.ajax({
            type: 'POST',
            url: 'core/handlerFilterData.php',
            data: {
                'filter': filter,
                'data': this.dataExcel
            },
            success: (result) => {
                const dataParse = $.parseHTML(this.headerTable + result);
                $("#resultParse").html(dataParse);
            }
        });
    }

    recordFilter() {
        const errorMessageDiv = $("#error_alert");
        const resExcService = ExceptionFilterService.checkAndCorrectFilter();
        if (resExcService.error) {
            errorMessageDiv.html(resExcService.error);
            return;
        }

        errorMessageDiv.html('');

        const filterData = {
            'article': {
                'start': document.getElementById('article_from').value,
                'end': document.getElementById('article_before').value
            },
            'price': {
                'start': document.getElementById('price_from').value,
                'end': document.getElementById('price_before').value
            },
            'name': document.getElementById('name').value,
            'countRow': document.getElementById('countRow').value,
            'articleType': resExcService.articleType
        };
        this.sendFilterAndReturnData(filterData);
    }
}

const handlerForm = new HandlerSubmitForm();
window.onload = () => handlerForm.onloadApp();
$(document).ready(() => {
    $("#filterForm").submit((event) => {
        event.preventDefault();
        handlerForm.recordFilter();
        return false;
    });
});