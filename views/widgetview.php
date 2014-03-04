<?php echo $before_widget ?>

<?php echo "{$before_title}The Rim Diary{$after_title}" ?>

<div class="rim-container">

	<a class="call-to-action" target="_blank" title="Roll Up The Rim To Win" href="http://www.rolluptherimtowin.com"><img class="tim-hortons-cup" src="<?php echo plugins_url() . '/rim-diary/resources/images/roll-up-the-rim-cup.jpg' ?>" alt=""/></a>

	<div>
	<?php foreach( $winnings as $tag => $count ) : ?>
		<span class="statistic"><?php printf( '%dx %s', $count, $prizes[ $tag ] ) ?></span>
	<?php endforeach ?>
	</div>

</div>


<?php echo $after_widget ?>