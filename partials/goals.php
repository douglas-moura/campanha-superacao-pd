<?php
  $db = new Db($config);
  $points = $db -> select("SELECT g.* from `goals` as g where g.cod = '" . $_SESSION['user']['cpf'] . "'");
?>

<div class="">
	<h2>Metas e Desempenho</h2>
	<?php
		if (count($points) > 0 &&
		(
			(isset($points[0]['label_1']) && !empty($points[0]['label_1'])) ||
			(isset($points[0]['label_2']) && !empty($points[0]['label_2'])) ||
			(isset($points[0]['label_3']) && !empty($points[0]['label_3']))
		)
		) {
		
		$p = $points[0];
	?>
	<table class="table table-hover table-striped table-desempenho">
		<thead>
			<tr>
				<th class="col-time">Período</th>				
				<th class="col-goal">Meta</th>
				<?php if ($_SESSION['user']['public'] == 'vendedor') { ?>
				    <th class="col-reached">Venda</th>
				<?php } else { ?>
				    <th class="col-reached">LAIR</th>
				<?php } ?>
				<th class="col-reached">Realizado</th>		
			</tr>
		</thead>
		<tbody>
			<?php
				for ($i=1; $i <= 13; $i++):
				if ($p['label_' . $i]):
				
				$goal = $p['goal_' . $i];
				$reached = $p['reached_' . $i];	
				$venda = $p['venda_' . $i];			
				
			?>
			<tr class="row-<?php echo $i ?>">
			
				<td class="col-time">
					<?php echo str_replace("-", " / ", ucfirst($p['label_' . $i])) ?>
				</td>
				
				<td class="col-goal">
					<?php echo "R$ " . number_format($goal ? $goal : '-', 2, ',', '.'); ?>
				</td>
				
				<td class="col-goal">
					<?php echo "R$ " . number_format($venda ? $venda : '-', 2, ',', '.'); ?>
				</td>
				
				<td class="col-reached">
					<?php echo $reached ? $reached . "%" : '-'; ?>
				</td>
			
			</tr>
			<?php
				endif;
				endfor;
			?>
		</tbody>
	</table>
	<?php
		} else {
			echo "<p> Não divulgado </p>";
		}
	?>
</div>
