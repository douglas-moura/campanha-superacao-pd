<?php
  include_once __DIR__ . "/../partials/header-operacao.php";
?>
  <section class="wrapper">

  </section>

<?php

 $footerIncludes = '
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.28.14/js/jquery.tablesorter.min.js"></script>
    <script >
    $(function(){
      $("#sortable").tablesorter();
    });
    </script>
  ';

  include_once __DIR__ . "/../partials/footer.php";
  include_once __DIR__ . "/../partials/foot.php";
?>
