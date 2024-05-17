<?php
  $db = new Db($config);
  $points = $db -> select("SELECT g.* from `vb_goals` as g where g.cod = '" . $_SESSION['user']['cpf'] . "'");
?>

<div class="wrap-rules">
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
				<th class="col-time">Vendas</th>			
				<th class="col-goal">Meta</th>	
				<th class="col-goal">Realizado</th>	
			</tr>
		</thead>
		<tbody>
			<?php
				for ($i=1; $i <= 13; $i++):
				if ($p['label_' . $i]):
				
				$goal = $p['goal_' . $i];
				$venda = $p['venda_' . $i];
				$reached = $p['reached_' . $i];				
				
			?>
			<tr class="row-<?php echo $i ?>">
			
				<td class="col-time">
					<?php echo $p['label_' . $i] ?>
				</td>				
				
				<td class="col-reached">
					<?php echo $venda ? $venda : '-'; ?>
				</td>
				
				<td class="col-goal">
					<?php echo $goal ? $goal : '-'; ?>
				</td>
				
				<td class="col-reached">
					<?php echo $reached ? $reached : '-'; ?>
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
