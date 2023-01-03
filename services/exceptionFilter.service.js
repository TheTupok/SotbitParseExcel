export class ExceptionFilterService {
    static checkAndCorrectFilter() {
        const articleMistake = 'Article search example: 1000 - 10000, E4100 - E4200 <br/>' +
            'Wrong: E4100 - 200000, E4100 - E42000';

        const priceStart = document.getElementById('price_from').value;
        const priceEnd = document.getElementById('price_before').value;
        if (Number(priceStart) > Number(priceEnd) && priceEnd !== '') {
            document.getElementById('price_from').value = priceEnd;
            document.getElementById('price_before').value = priceStart;
        }

        const articleStart = document.getElementById('article_from').value;
        const articleEnd = document.getElementById('article_before').value;
        if (this.containsOnlyNumbers(articleStart) && this.containsOnlyNumbers(articleEnd)) {
            if (Number(articleStart) > Number(articleEnd) && articleEnd !== '') {
                document.getElementById('article_from').value = articleEnd;
                document.getElementById('article_before').value = articleStart;
            }
            return {articleType: 'number'};
        } else if (!this.containsOnlyNumbers(articleStart) && !this.containsOnlyNumbers(articleEnd) &&
            articleStart.length === articleEnd.length) {
            return {articleType: 'mixed'};
        } else {
            document.getElementById('article_from').value = '';
            document.getElementById('article_before').value = '';
            return {error: articleMistake};
        }
    }

    static containsOnlyNumbers(str) {
        return /^\d+$/.test(str);
    }
}