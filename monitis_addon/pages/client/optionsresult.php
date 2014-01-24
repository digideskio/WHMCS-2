<?php
$optionId = (int)$_GET['id'];

$query = '
SELECT tblhostingconfigoptions.configid as productid, tblhostingconfigoptions.optionid as option_id, 
	mod_monitis_options.type as monitor_type, mod_monitis_options.settings,
	tblhosting.id as serviceid, tblhosting.userid, tblhosting.orderid, tblhosting.domain, tblhosting.dedicatedip, tblhosting.domainstatus,
	tblhosting.server as serverid, tblorders.ordernum, tblorders.status,
	tblclients.firstname as firstName, tblclients.lastname as lastName, tblclients.email,
	CONCAT(tblclients.firstname, " ", tblclients.lastname) as username,
	CONCAT("option") as producttype
FROM tblhostingconfigoptions
	RIGHT JOIN mod_monitis_options
		ON mod_monitis_options.option_id = tblhostingconfigoptions.optionid
	LEFT JOIN tblhosting
		ON tblhosting.id = tblhostingconfigoptions.relid
	LEFT JOIN tblorders
		ON tblorders.id = tblhosting.orderid
	LEFT JOIN tblclients
		ON tblclients.id = tblhosting.userid
WHERE tblhostingconfigoptions.optionid = '.$optionId.' AND tblhosting.domainstatus = "Active"
';

$result = mysql_query( $query );
$monitors = array();
while( $row = mysql_fetch_assoc( $result ) ){
	$row['settings'] = html_entity_decode( $row['settings'] );
	$row['web_site'] = MonitisSeviceHelper::url_IP( $row, $row['monitor_type'] );
	$res = MonitisHookClass::createCreateConfigOptionMonitor( $row );
	$row['response'] = $res['data'][0]['response'];
	array_push( $monitors, $row );
}
?>
<style type="text/css">
.monitis-options-result .datatable{
	width: 100%;
	border-spacing: 1px;
}
.monitis-options-result .datatable td {
	padding: 5px;
}
.monitis-options-result .datatable .status{
	font-weight:bold;
}
.monitis-options-result .datatable .status.ok{
	color: #468847;
}
.monitis-options-result .datatable .status.error{
	color: #CC0000;
}
.monitis-options-result .datatable .status.warning{
	color: #C09853;
}
.monitis-options-result .datatable .status.info{
	color: #888888;
}
.monitis-options-result .back{
	text-align: right;
	margin-bottom: 20px;
}
</style>

<div class="monitis-options-result">
	<div class="back monitis_link_result">
		<a href="<?php echo MONITIS_APP_URL ?>&monitis_page=tabclient&sub=options">&#8592; Back to options list</a>
	</div>
	<table class="datatable">
		<thead>
			<tr>
				<th>Order ID</th>
				<th>Order #</th>
				<th>Client</th>
				<th>Monitor type</th>
				<th>Domain</th>
				<th>Dedicated IP</th>
				<th>Status</th>
			</tr>
		</thead>
		<tbody>
			<?
			if( is_array( $monitors ) && count($monitors) ):
			$addonUrl = MonitisHelper::adminAddonUrl();
			foreach( $monitors as $monitor ):
			?>
			<tr>
				<!-- td><?=$monitor["orderid"]?></td -->
				<td><a href="<?=MonitisHelper::adminOrderUrl($monitor["orderid"])?>" target="_blank"><?=$monitor["orderid"]?></a></td>
				<td><?=$monitor["ordernum"]?></td>
				<td><?=$monitor["username"]?></td>
				<td><?=$monitor["monitor_type"]?></td>
				<td><?=$monitor["domain"]?></td>
				<td><?=$monitor["dedicatedip"]?></td>
				<td class="status <?=$monitor["response"]["status"]?>">
				<?if($monitor['response']['status'] == 'error') {?>
					<a href="<?=$addonUrl?>&monitis_page=tabreport" class="status <?=$monitor["response"]["status"]?>" target="_blank"><?=$monitor["response"]["msg"]?></a>
				<?} else {?>
					<?=$monitor["response"]["msg"]?>
				<?}?>
				</td>
			</tr>
			<? endforeach ?>
			<? else: ?>
			<tr>
				<td colspan="7">No active products available.</td>
			</tr>
			<? endif ?>
		</tbody>
	</table>
</div>