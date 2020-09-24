<div class="content">
        <div class="header">
      

            <h1 class="page-title">������� ������</h1>
                    

        </div>
        <div class="main-content">
		
		
   
        <div class="panel panel-default">
         <center>
<?PHP
/* 
Script MINE-INCOME
Autor: EvgeSH
URL: MyShopScript.ru
ICQ: 326-728
Email: EvgeSH@ProtonMail.com
*/
# ������
if(isset($_GET["last_31"])){
	
	$dlim = time() - 60*60*24*30;
	$db->Query("SELECT * FROM ".$pref."db_payment WHERE date_add > $dlim ORDER BY id DESC");
	
	$days_money = array();
	$days_insert = array();
	
	if($db->NumRows() > 0){
		
		while($data = $db->FetchArray()){
		$index = date("d.m.Y", $data["date_add"]);
		
			$days_money[$index] = (isset($days_money[$index])) ? $days_money[$index] + $data["sum"] : $data["sum"];
			$days_insert[$index] = (isset($days_insert[$index])) ? $days_insert[$index] + 1 : 1;
			
		}
	
	# �����
	if(count($days_money) > 0){
		
		$array_for_chart = array();
		$array_for_chart2 = array();
		$array_for_chart3 = array();
		
			foreach($days_money as $date => $sum){
			
				$array_for_chart[] = "['".$date."', ".round($sum)."]";
				$array_for_chart2[] = "['".$date."', ".$days_insert[$date]."]";
				$array_for_chart3[] = "['".$date."', ".round($sum / $days_insert[$date], 2)."]";
			
			}
			
			$retd = implode(", ", array_reverse($array_for_chart));
			$retd2 = implode(", ", array_reverse($array_for_chart2));
			$retd3 = implode(", ", array_reverse($array_for_chart3));
			
		?>

	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['����', '�����'],
          <?=$retd; ?>
        ]);

        var options = {
          title: '������� ������ (�����)',
          hAxis: {title: 'Last 30 Days',  titleTextStyle: {color: 'green'}}
        };

        var chart = new google.visualization.SteppedAreaChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
	<div id="chart_div" style="width: 100%; height: 500px;"></div>
	
	<script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart2);
      function drawChart2() {
        var data2 = google.visualization.arrayToDataTable([
          ['����', '���-��'],
          <?=$retd2; ?>
        ]);

        var options2 = {
          title: '������� ������ (���-��)',
          hAxis: {title: 'Last 30 Days',  titleTextStyle: {color: 'green'}}
        };

        var chart2 = new google.visualization.SteppedAreaChart(document.getElementById('chart_div2'));
        chart2.draw(data2, options2);
      }
    </script>
	<div id="chart_div2" style="width: 100%; height: 500px;"></div>
	<script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart3);
      function drawChart3() {
        var data3 = google.visualization.arrayToDataTable([
          ['����', '�����'],
          <?=$retd3; ?>
        ]);

        var options3 = {
          title: 'AVG (����� / ���-��)',
          hAxis: {title: 'Last 30 Days',  titleTextStyle: {color: 'green'}}
        };

        var chart3 = new google.visualization.SteppedAreaChart(document.getElementById('chart_div3'));
        chart3.draw(data3, options3);
      }
    </script>
	<div id="chart_div3" style="width: 100%; height: 500px;"></div>
	
	
		<?PHP
		
	}
	
	}else echo "<center><b>������� ���</b></center><BR />";
	
	
	
?></div><div class="clr"></div>	<?PHP
return;
}


# ����� ���������� �� ����
if(isset($_GET["list_day"])){

	$db->Query("SELECT * FROM ".$pref."db_payment ORDER BY id DESC");
	
	$days_money = array();
	$days_insert = array();
	
	if($db->NumRows() > 0){
		
		while($data = $db->FetchArray()){
		$index = date("d.m.Y", $data["date_add"]);
		
			$days_money[$index] = (isset($days_money[$index])) ? $days_money[$index] + $data["sum"] : $data["sum"];
			$days_insert[$index] = (isset($days_insert[$index])) ? $days_insert[$index] + 1 : 1;
			
		}
	
	# �����
	if(count($days_money) > 0){
	
		?>
		<table cellpadding='3' cellspacing='0' border='0' bordercolor='#336633' align='center' width="99%">
		  <tr bgcolor="#efefef">
			<td align="center" class="m-tb">����</td>
			<td align="center" class="m-tb">������</td>
			<td align="center" class="m-tb">�� �����</td>
			<td align="center" class="m-tb">AVG</td>
		  </tr>
		<?PHP
		
		$array_for_chart = array();
		
			foreach($days_money as $date => $sum){
			
				?>
				<tr class="htt">
					<td align="center"><b><?=$date; ?></b></td>
					<td align="center"><?=$days_insert[$date]; ?> ��.</td>
					<td align="center"><?=$sum; ?> <?=$config->VAL;?></td>
					<td align="center"><?=round($sum/$days_insert[$date],2); ?> <?=$config->VAL;?></td>
				</tr>
				<?PHP
				
			}
			
		?>
		</table>
		<?PHP
		
	}
	
	}else echo "<center><b>������� ���</b></center><BR />";
	
	
	
?></div><div class="clr"></div>	<?PHP
return;
}

# �������� ������� Payeer
if(isset($_GET["balance"])){

$payeer = new rfs_payeer($config->AccountNumber, $config->apiId, $config->apiKey);
	if ($payeer->isAuth())
	{
		
		$arBalance = $payeer->getBalance();
		echo "<pre>".print_r($arBalance, true)."</pre>";	
	
	}
	
?></div><div class='clr'></div><?PHP

return;			
}	



$num_p = (isset($_GET["page"]) AND intval($_GET["page"]) < 1000 AND intval($_GET["page"]) >= 1) ? (intval($_GET["page"]) -1) : 0;
$lim = $num_p * 100;

$db->Query("SELECT * FROM ".$pref."db_payment ORDER BY id DESC LIMIT {$lim}, 100");

function colorSum($sum){

	if($sum >= 100) return "red";
	return "#000000";
}

if($db->NumRows() > 0){

?>
<table cellpadding='3' cellspacing='0' border='0' bordercolor='#336633' align='center' width="99%">
  <tr bgcolor="#efefef">
    <td align="center" width="50" class="m-tb">User</td>
	<td align="center" width="50" class="m-tb">Serebro</td>
	<td align="center" width="50" class="m-tb">Money</td>
	<td align="center" width="50" class="m-tb">Purse</td>
	<td align="center" width="50" class="m-tb">Date</td>
  </tr>


<?PHP

	while($data = $db->FetchArray()){
	
	?>
	<tr class="htt">
	<td align="center"><a href="index.php?menu=users&edit=<?=$data["user_id"]; ?>" class="stn"><?=$data["user"]; ?></a></td>
    <td align="center"><?=$data["serebro"]; ?></td>
    
	
	
    <td align="center"><font color="<?=colorSum($data["sum"]); ?>"><?=sprintf("%.2f",$data["sum"]); ?> <?=$data["valuta"]; ?></font></td>
	<td align="center"><?=$data["purse"]; ?></td>
	<td align="center"><?=date("d.m H:i:s",$data["date_add"]); ?></td>
  	</tr>
	<?PHP
	
	}

?>

</table>
<BR />
<?PHP


}else echo "<center><b>�� ������ �������� ��� �������</b></center><BR />";

	
$db->Query("SELECT COUNT(*) FROM ".$pref."db_payment");
$all_pages = $db->FetchRow();

	if($all_pages > 100){
	
	$sort_b = (isset($_GET["sort"])) ? intval($_GET["sort"]) : 0;
	
	$nav = new navigator;
	$page = (isset($_GET["page"]) AND intval($_GET["page"]) < 1000 AND intval($_GET["page"]) >= 1) ? (intval($_GET["page"])) : 1;
	
	echo "<BR /><center>".$nav->Navigation(10, $page, ceil($all_pages / 100), "index.php?menu=payments&page="), "</center>";
	
	}
?>



        </div>
    </div>
    
   


  <footer>
                <hr>

              <p class="pull-right">Admin <a href="https://profitscripts.tech" target="_blank">Panel</a> by <a href="https://profitscripts.tech/" target="_blank">Profit Scripts</a></p>
                <p>� 2018 <a href="https://profitscripts.tech/" target="_blank">Profit Scripts</a></p>
            </footer>
  
  