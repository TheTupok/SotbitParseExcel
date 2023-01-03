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
    <script type="module" src="scripts/handlerSubmitForm.js"></script>
    <script type="module" src="services/exceptionFilter.service.js"></script>
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
    <div id="error_alert"></div>
    <div>
      <table border="1" id="resultParse"></table>
    </div>
  </body>
</html>