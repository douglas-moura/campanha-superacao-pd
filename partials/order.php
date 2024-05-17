<?php
	define('COOKIENAME', 'mxo');

	function hasOrder() {
		$order = getOrder();
		if (isset($order[0]) && $order[0]->c) {
			return true;
		}
		return false;
	}

	function getOrder() {
		if (!isset($_COOKIE[COOKIENAME])) {
			return [];
		} else {
			try {
				return json_decode($_COOKIE[COOKIENAME]);
			} catch (\Exception $e) {
				return [];
			}
		}
	}

	function setOrder($order) {
		setcookie(COOKIENAME, json_encode($order), time() + (86400 * 7), "/");
	}

	function deleteItem($cod, $order) {
		$_order = array_filter($order, function ($item) {
			return $item->c === $cod;
		});

		setOrder($_order);
	}

	function checkItem($item, $cod) {
		return $item->c === $cod;
	}

	function getCodes($order) {
		$cods = [];
		$length = count($order);
		for ($i = 0; $i < $length; $i++) {
			$cods[] = $order[$i]->c;
		}
		return $cods;
	}

	function getQuery($order) {
		$codes = implode(',', getCodes($order));
		$query = "SELECT * FROM catalog where active = 1 and visible = 1 and cod in ($codes)";
		return $query;
	}

	function populateOrder($order, $products) {
		$codes = getCodes($order);
		$orderCount = count($order);
		$productOrder = [];
		if (!$products) {
			return $productOrder;
		}

		foreach ($products as $product) {
			for ($i = 0; $i < $orderCount; $i++) {
				if ($product['cod'] == $order[$i]->c) {
					$productOrder[$i] = $product;
					$productOrder[$i]['voltage'] = $order[$i]->v;
				}
			}
		}
		return $productOrder;
	}

	function sumProducts($total, $product) {
		return $total + intval($product['points']);
	}

	function getTotal($products) {
		return array_reduce($products, "sumProducts", 0);
	}

	function deleteOrder() {
		if (isset($_COOKIE[COOKIENAME])) {
			setcookie(COOKIENAME, FALSE, -1, '/');
			unset($_COOKIE[COOKIENAME]);
		}
	}
