<?php $javascript->link('/api_generator/js/request_manager.js', false); ?>
<h1><?php __('Admin Class Index'); ?></h1>
<table class="listing" cellspacing="0" cellpadding="0">
	<thead>
		<tr>
			<th><?php __('Classname'); ?> </th>
			<th><?php __('Coverage'); ?>
			<th><?php __('Actions'); ?> </th>
		</tr>
	</thead>
	<?php foreach ($apiClasses as $apiClass): ?>
		<tr>
			<td><?php echo $apiClass['ApiClass']['name']; ?></td>
			<td><?php 
				if (!empty($apiClass['ApiClass']['coverage_cache'])): 
					echo $number->toPercentage($apiClass['ApiClass']['coverage_cache'] * 100);
				else:
					echo '<span class="coverage-indicator" id="' . $apiClass['ApiClass']['id'] . '">Loading..</span>';
				endif;
			?></td>
			<td>
				<?php 
				echo $html->link(__('View Coverage', true), array('action' => 'docs_coverage', $apiClass['ApiClass']['slug'])); 
				?>
			</td>
		</tr>
	<?php endforeach ?>
</table>
<?php echo $this->element('paging'); ?>

<script type="text/javascript">
if (window.basePath === undefined) {
	window.basePath = '<?php $this->webroot; ?>';
}
ApiGenerator.classIndex = {
	coverageUrl : window.basePath + 'admin/api_generator/calculate_coverage/',

	init : function () {
		var self = this;

		$$('table.listing .coverage-indicator').each(function (item, i) {
			var requestOpts = {
				url : self.coverageUrl + item.get('id'),
				onSuccess : self.updateCoverage,
				method : 'get'
			};
			RequestManager.prefetch(requestOpts);
		});
	},

	updateCoverage : function (responseText, responseXml) {
		var object = JSON.decode(responseText);
		var value = Math.round(object.coverage * 100) / 100;
		$(object.id).set('text', value + '%');
		value = Math.round(value);
		if (value >= 75) {
			$(object.id).setStyle('color', 'green');
		} else if (value < 75 && value > 50) {
			$(object.id).setStyle('color', 'GoldenRod');
		} else {
			$(object.id).setStyle('color', 'DarkRed');
		}
	}
};
</script>