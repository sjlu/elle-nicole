<div id="photos" class="content">
	<? foreach ($content['images'] as $image): ?>
		<img src="<?= base_url($image) ?>" />
	<? endforeach; ?>
</div>