<?php
$pdo = new PDO('mysql:host=localhost;dbname=legacylo_shino', 'legacylo_shino', 'P.r!UTIrK##mq[%+1M', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

$content = '<html><body><table cellspacing="0">';
foreach($pdo->query('SELECT * FROM changelog ORDER BY id DESC LIMIT 6') as $row){
	$content .= '
		<tr>
			<td style="width: 25%">'.date("d.m.y H:i", $row["time"]).'</td>
			<td style="width: 75%">'.$row["msg"].'</td>
		</tr>
	';
}
$content .= '</table></body></html>';
print $content;
?>