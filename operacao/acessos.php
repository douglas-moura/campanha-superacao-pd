<?php
    include_once __DIR__ . "/../partials/header-operacao.php";
    $query = 'select * FROM `events` order by id desc';
    $rows = $db -> select($query);
    $count = count($rows[0]);
    if ($count > 0) {
        $fields = array_keys($rows[0]);
?>

        <section class="wrapper" style="width:100%;overflow-x:auto;">
            <table class="table" id="sortable">
                <thead>
                    <tr>
                        <?php foreach ($fields as $field) {
                            echo "<th scope='col'> $field </th>";
                        } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        for ($i=0; $i < $count; $i++) {
                            echo "<tr>";
                            foreach ($rows[$i] as $key => $value) {
                                echo "<td>$value</td>";
                            }
                            echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>
        </section>
<?php
    } else {
        echo 'Não foi possível listas os participantes';
    }

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
