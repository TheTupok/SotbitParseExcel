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
      $(document).ready(function () {
        $("#parseForm").submit((event) => {
          event.preventDefault();
          if (document.getElementById('price_from').value > document.getElementById('price_before').value &&
                  document.getElementById('price_before').value !== '') {
            const priceFrom = document.getElementById('price_from').value;
            document.getElementById('price_from').value = document.getElementById('price_before').value;
            document.getElementById('price_before').value = priceFrom;
          }
          if (document.getElementById('article_from').value > document.getElementById('article_before').value &&
                  document.getElementById('article_before').value !== '') {
            const articleFrom = document.getElementById('article_from').value;
            document.getElementById('article_from').value = document.getElementById('article_before').value;
            document.getElementById('article_before').value = articleFrom;
          }
          const filterData = {
            'article_from': document.getElementById('article_from').value,
            'article_before': document.getElementById('article_before').value,
            'price_from': document.getElementById('price_from').value,
            'price_before': document.getElementById('price_before').value,
            'name': document.getElementById('name').value,
            'countRow': document.getElementById('countRow').value,
          }
          $.ajax({
            type: 'POST',
            url: 'handlerParseExcel.php',
            data: filterData,
            success: function (result) {
              const html = $.parseHTML(result);
              $("#resultParse").html(html);
            }
          });
          return false;
        });
      });
    </script>
  </head>
  <body>
    <form id="parseForm">
      <label class="label-filter">
        <span>Article</span>
        <input class="input-from" type="text" placeholder="From" id="article_from"><input class="input-before"
                                                                                          type="text"
                                                                                          placeholder="Before"
                                                                                          id="article_before">
      </label>
      <label class="label-filter">
        <span>Price</span>
        <input class="input-from" type="number" placeholder="From" id="price_from"><input class="input-before"
                                                                                          type="text"
                                                                                          placeholder="Before"
                                                                                          id="price_before">
      </label>
      <label class="label-filter">
        <span>Name</span>
        <input style="width:250px" type="text" placeholder="Name" id="name">
      </label>
      <label class="label-filter">
        <span>Count row</span>
        <input style="width:250px" type="number" placeholder="Count row" id="countRow">
      </label>
      <button type="submit" class="btn-parse">Parse Excel</button>
    </form>
    <div id="resultParse">

    </div>
  </body>
</html>