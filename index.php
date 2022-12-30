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
      function ParseExcel() {
        const filterData = {
          'article': document.getElementById('article').value,
          'name': document.getElementById('name').value,
          'price': document.getElementById('price').value,
          'countRow': document.getElementById('countRow').value,
        }
        $.ajax({
          type: 'POST',
          url: 'handlerParseExcel.php',
          data: filterData,
          success: function (result) {
            $('#resultParse').text(result);
          }
        })
      }
    </script>
  </head>
  <body>
    <form action="" onsubmit="ParseExcel(); return false">
      <div class="form__group field">
        <input type="text" class="form__field" placeholder="Article" id="article"/>
        <label class="form__label">Article</label>
      </div>
      <div class="form__group field">
        <input type="text" class="form__field" placeholder="Name" id="name"/>
        <label class="form__label">Name</label>
      </div>
      <div class="form__group field">
        <input type="number" class="form__field" placeholder="Price" id="price"/>
        <label class="form__label">Price</label>
      </div>
      <div class="form__group field">
        <input type="number" class="form__field" placeholder="Count row" id="countRow"/>
        <label class="form__label">Count row</label>
      </div>
      <button type="submit" class="btn-parse">Parse Excel</button>
    </form>

    <div id="resultParse">

    </div>
  </body>
</html>