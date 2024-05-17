<?php

$selectCategory = isset($_GET['category']) ? $_GET['category'] : '';
$categoryComplement = $selectCategory !== '' ? "&category=" . $_GET['category'] : '';
$categoryQuery = $selectCategory !== '' ? " AND category = '" . $_GET['category'] . "'" : '';
$queryTotal = "SELECT count(id) as total FROM catalog where active = 1 AND visible = 1 $categoryQuery";
$count = $db->select($queryTotal);

$categories = [
    "Acessórios",
    "Ar condicionado e aquecedores",
    "Áudio",
    "Automotivo",
    "Beleza",
    "Cama, Mesa e Banho",
    "Câmeras e Filmadoras",
    "Casa e Construção",
    "Celulares e Smartphones",
    "Eletrodomésticos",
    "Eletroportáteis",
    "Esporte e Lazer",
    "Ferramentas",
    "Games",
    "Infantil",
    "Informática e Acessórios",
    "Linha Industrial",
    "Moda",
    "Papelaria",
    "Relógios",
    "Saúde",
    "Telefonia",
    "Tv e Home Theater",
    "Utilidades Domésticas"
];

$orders = [
    "nome" => "Nome do produto A - Z",
    "nome-desc" => "Nome do produto Z - A",
    "pontos" => "Pontos menor para o maior",
    "pontos-desc" => "Pontos maior para o menor"
];

$perPage = 30;
$total = $perPage - 1;

if ($count[0] && $count[0]['total']) {
    $total = $count[0]['total'];
}

$totalPages = round($total / $perPage);

if (isset($_GET['order'])) {
    switch ($_GET['order']) {
        case 'pontos':
            $order = 'points';
            break;

        case 'pontos-desc':
            $order = 'points desc';
            break;

        case 'nome':
            $order = 'title';
            break;

        case 'nome-desc':
            $order = 'title desc';
            break;

        default:
            $order = 'points desc';
            break;
    }
} else {
    $order = 'points desc';
}

$page = 1;

if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $page = intval($_GET['page']);
}

if ($page > $totalPages || $page < 1) {
    $page = 1;
}

$startOn = ($page - 1) * $perPage;

$query = "SELECT * FROM catalog WHERE active = 1 AND visible = 1 $categoryQuery order by $order LIMIT $startOn, $perPage";
$products = $db->select($query);
$totalProducts = count($products);
?>

<ul class="filtro_prod" role="tablist">
    <li role="presentation" class="dropdown drop-1">
        <a href="#" class="dropdown-toggle" id="drop4" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> Ordenar <span class="caret"></span> </a>
        <ul class="dropdown-menu" id="menu1" aria-labelledby="drop4">
            <?php
            foreach ($orders as $slug => $label) {
                echo "<li><a href='./?order=$slug'>$label</a></li>";
            }
            ?>
        </ul>
    </li>
    <li role="presentation" class="dropdown drop-2">
        <a href="#" class="" id="drop4" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> Filtrar <span class="caret"></span> </a>
        <ul class="dropdown-menu" id="menu1" aria-labelledby="drop4">
            <?php
            if ($selectCategory && in_array($selectCategory, $categories)) {
                echo "<li class='feature'><a href='./'><strong>Limpar</strong></a></li>";
            }

            foreach ($categories as $index => $category) {
                if ($category === $selectCategory) {
                    echo "<li><a href='./'><strong>$category (X)</strong></a></li>";
                } else {
                    echo "<li><a href='./?category=$category'>$category</a></li>";
                }
            }
            ?>
        </ul>
    </li>
</ul>

<div class="catalog">

    <?php for ($i = 0; $i < $totalProducts; $i++) { ?>

        <div class="product">
            <a data-toggle="modal" data-target=".modal-<?php echo $products[$i]['cod'] ?>">
                <picture>
                    <img src="../img/p/<?php echo $products[$i]['cod'] ?>.jpg" alt="" />
                </picture>
                <h6><?php echo $products[$i]['category'] ?></h6>
                <h4><?php echo $products[$i]['title'] ?></h4>
                <div>
                    <p>Pontos:<br><strong><?php echo number_format($products[$i]['points'], 0, ',', '.') ?></strong></p>
                    <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg></span>
                </div>
            </a>
        </div>

        <div class="modal fade modal-<?php echo $products[$i]['cod'] ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="gridSystemModalLabel"><?php echo  $products[$i]['title'] ?></h4>
                    </div>
                    <div class="product-detail">
                        <picture>
                            <img src="../img/p/<?php echo $products[$i]['cod'] ?>.jpg" width="500" alt="" />
                        </picture>
                        <div class="product-detail-description">
                            <!--<h4><?php echo  $products[$i]['title'] ?></h4>-->
                            <p class=""><?php echo  $products[$i]['description'] ?></p><br>
                            <p class="points">Pontos:<br><strong><?php echo number_format($products[$i]['points'], 0, ',', '.') ?></strong></p>
                        </div><!--pedir-->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                        <?php if ($products[$i]['voltage'] === '110-220') { ?>
                            <button class="btn btn_sec btn-buy js-add-cart" data-cod="<?php echo $products[$i]['cod'] ?>" data-voltage="110V" id="buy-220V-<?php echo $products[$i]['cod'] ?>">
                                <span>Pedir este 110V</span>
                                <em><i class="ico-check">✓</i> Solicitado</em>
                            </button>
                            <button class="btn btn_sec btn-buy js-add-cart" data-cod="<?php echo $products[$i]['cod'] ?>" data-voltage="220V" id="buy-110V-<?php echo $products[$i]['cod'] ?>">
                                <span>Pedir este 220V</span>
                                <em><i class="ico-check">✓</i> Solicitado</em>
                            </button>
                        <?php } else { ?>
                            <button class="btn btn_sec btn-buy js-add-cart" data-cod="<?php echo $products[$i]['cod'] ?>" data-voltage="" id="buy-<?php echo $products[$i]['cod'] ?>">
                                <span>Pedir este prêmio</span>
                                <em><i class="ico-check">✓</i> Solicitado</em>
                            </button>
                        <?php }; ?>
                        <button class="btn btn_prim btn-action-go" href="" id="go-<?php echo $products[$i]['cod'] ?>"><a href="<?php echo '//' . $config['baseUrl'] . '/pedido'; ?>">Ir para o pedido</a></button>
                    </div>
                </div>
            </div>
        </div>

    <?php } ?>

</div>

<ul class="pagination pagination-products">

    <?php
    $disableStart = $page === 1 ? ' disabled' : '';
    $disableEnd = $page === $totalPages ? ' disabled' : '';
    if (isset($_GET['order'])) {
        $orderComplement = "&order=" . $_GET['order'];
    } else {
        $orderComplement = "&order=pontos-desc";
    }

    echo "<li class='$disableStart'><a href='./?page=" . ($page - 1) . "$orderComplement'>&laquo;</a></li>";

    for ($i = 1; $i <= $totalPages; $i++) {
        $active = $page === $i ? ' active' : '';
        echo "<li class='$active'><a href='./?page=$i$orderComplement$categoryComplement'>$i</a></li>";
    }

    echo "<li class='$disableEnd'><a href='./?page=" . ($page + 1) . "$orderComplement'>&raquo;</a></li>";
    ?>

</ul>


<?php $footerIncludes = '
    <script src="//' . $config['assets'] . 'js/jquery.cookie.js?version=' . $config['version'] . '"></script>
    <script src="//' . $config['assets'] . 'js/catalog.js?version=' . $config['version'] . '"></script>
    ';
?>