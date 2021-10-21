<?php
	require 'Parser.php';
	require_once 'config.php';

	$link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_BASE); 
	mysqli_set_charset($link, "utf8") or die("Не установлена кодировка соединения");

	$html = Parser::getPage([
	 "url" => "https://mirinstrumenta.ua/category/pnevmogaykoverti.html"
	]);

	$data = date('Y-m-d');
	$domain_name = 'https://mirinstrumenta.ua';
	$page_url = 'https://mirinstrumenta.ua/category/pnevmogaykoverti.html';

	if(!empty($html["data"])){
		$content = $html["data"]["content"];

		$dom = new domDocument; 
		// $dom->preserveWhiteSpace = false;

		$res = @$dom->loadHTML($content); 

		$xpath = new DOMXPath ($dom);

		foreach ($xpath->query (".//div[@class='price']") as $review){
		    $pieces = explode(" ", $review->firstChild->nodeValue);

		    if (!empty($pieces[1])) {
		    	$price = $pieces[1];
		    }else{
		    	$price = 0;
		    }

		    $discount = 0;
		    foreach ($xpath->query (".//div[@class='discount']", $review) as $item){
		    	if ($item->textContent) {
		    		$discount_item = explode(" ", $item->textContent);
		    		$discount = $discount_item[2];
		    	}
		    }

		    foreach ($xpath->query (".//br", $review) as $discount_item2){
		    	$stock =  $discount_item2->nextSibling->nodeValue;
		    }

		    $sql = "INSERT INTO site_info (id,date,domain_name,page_url,price,stock_percent,stock_price) VALUES(null,'$data','$domain_name','$page_url','$price','$discount','$stock')";
			mysqli_query($link,$sql);
		}
	}

	$sql2 = "SELECT * FROM site_info";

	$query2 = mysqli_query($link, $sql2);
	while ($res2[] = mysqli_fetch_assoc($query2)) {
		$parsinfo = $res2;
	}
?>

<table>
	<thead>
		<tr>
			<td>ID</td>
			<td>Дата</td>
			<td>Домен</td>
			<td>Страница</td>
			<td>Цена</td>
			<td>Процент скидки</td>
			<td>Акционная цена</td>
		</tr>
	</thead>
	<tbody>
		<?php if (!empty($parsinfo)) {
			foreach ($parsinfo as $info) { ?>
				<tr>
					<td><?php echo $info['id']; ?></td>
					<td><?php echo $info['date']; ?></td>
					<td><?php echo $info['domain_name']; ?></td>
					<td><?php echo $info['page_url']; ?></td>
					<td><?php echo $info['price']; ?></td>
					<td><?php echo $info['stock_percent']; ?></td>
					<td><?php echo $info['stock_price']; ?></td>
				</tr>
			<?php }
		} ?>
	</tbody>
</table>