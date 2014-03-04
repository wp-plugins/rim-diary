<div class="wrap">
	<div id="icon-themes" class="icon32"></div>

	<div id="rim-diary-admin">
		<h1>The Rim Diary</h1>

		<div class="winnings">
		<?php foreach( $winnings as $tag => $count ) : ?>
			<span class="statistic"><?php printf( '%dx %s', $count, $prizes[ $tag ] ) ?></span>
		<?php endforeach ?>
		</div>

		<h2>Roll Up The Rim...</h2>
		<form method="post">
			<?php foreach( RimDiary::getPrizes() as $tag => $prize ) : ?>
				<div class="prize">
					<img class="prize-image" src="<?php echo plugins_url() . "/rim-diary/resources/images/prize-{$tag}.png" ?>"/>
					<button class="button button-primary" type="submit" name="rim-rolled" value="<?php echo $tag ?>"><?php echo $prize ?></button>
				</div>
			<?php endforeach ?>
			<p><button class="button button-secondary delete" type="submit" name="rim-rolled" value="<?php echo 'reset-rims' ?>">Reset Rims</button></p>
			<?php wp_nonce_field( 'log-rim-diary', 'log-rim-diary-nonce' ) ?>
		</form>
	</div>
</div>