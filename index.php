<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>Sotbit | ParseExcel</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript">
      let dataExcel = [];
      let headerTable = '';
      window.onload = function () {
        $.ajax({
          type: 'POST',
          url: 'core/parseExcel.php',
          success: function (result) {
            dataExcel = JSON.parse(result);
            document.getElementById('btn-parse').style.display = '';
            headerTable = dataExcel.shift().join('');
            $.ajax({
              type: 'POST',
              url: 'core/handlerFilterData.php',
              data: {
                'filter': [],
                'data': dataExcel
              },
              success: function (result) {
                const dataParse = $.parseHTML(headerTable + result);
                $("#resultParse").html(dataParse);
              }
            });
          }
        });
      }
    </script>
    <script type="text/javascript">
      $(document).ready(function () {
        $("#filterForm").submit((event) => {
          event.preventDefault();
          if (Number(document.getElementById('price_from').value) > Number(document.getElementById('price_before').value) &&
                  document.getElementById('price_before').value !== '') {
            const priceFrom = document.getElementById('price_from').value;
            document.getElementById('price_from').value = document.getElementById('price_before').value;
            document.getElementById('price_before').value = priceFrom;
          }
          if (Number(document.getElementById('article_from').value) > Number(document.getElementById('article_before').value) &&
                  document.getElementById('article_before').value !== '') {
            const articleFrom = document.getElementById('article_from').value;
            document.getElementById('article_from').value = document.getElementById('article_before').value;
            document.getElementById('article_before').value = articleFrom;
          }
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
          }
          $.ajax({
            type: 'POST',
            url: 'core/handlerFilterData.php',
            data: {
              'filter': filterData,
              'data': dataExcel
            },
            success: function (result) {
              const html = $.parseHTML(headerTable + result);
              $("#resultParse").html(html);
            }
          });
          return false;
        });
      });
    </script>
  </head>
  <body>
    <form id="filterForm">
      <label class="label-filter">
        <span>Article</span>
        <input class="input-from" type="text" placeholder="From" id="article_from"><input
                class="input-before"
                type="text"
                placeholder="Before"
                id="article_before">
      </label>
      <label class="label-filter">
        <span>Price</span>
        <input class="input-from" type="number" placeholder="From" id="price_from" step="0.01"><input
                class="input-before"
                type="number"
                placeholder="Before"
                id="price_before"
                step="0.01">
      </label>
      <label class="label-filter">
        <span>Name</span>
        <input style="width:250px" type="text" placeholder="Name" id="name">
      </label>
      <label class="label-filter">
        <span>Count row</span>
        <input style="width:250px" type="number" placeholder="Count row" id="countRow">
      </label>
      <button type="submit" id="btn-parse" style="display:none">Parse Excel</button>
    </form>
    <div>
      <table border="1" id="resultParse">

      </table>
    </div>
  </body>
</html>