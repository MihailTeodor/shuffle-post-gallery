<?php defined( 'ABSPATH' ) or die; ?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<div class="spg-main-container">
	<div class="spg-container spg-container-controls">
		<div class="row">
			<div class="col-4@sm col-3@md">
				<div class="filters-group">
					<label for="filters-search-input" class="filter-label">Search</label>
					<input class="textfield filter__search js-shuffle-search" type="search" id="filters-search-input" />
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-12@sm filters-group-wrap">
				<?php if ( ! empty( $categories ) ) : ?>
					<div class="filters-group">
						<p class="filter-label">Filter</p>
						<div class="btn-group filter-options">
							<?php foreach( $categories as $category_slug => $category_name ) : ?>
								<button class="btn btn--primary" data-group="<?php esc_attr_e( $category_slug ); ?>"><?php esc_html_e( $category_name ); ?></button>
							<?php endforeach; ?>
						</div>
					</div>
				<?php endif; ?>
				<fieldset class="filters-group">
					<legend class="filter-label">Sort</legend>
					<div class="btn-group sort-options">
						<label class="btn active">
							<input type="radio" name="sort-value" value="dom" /> Default
						</label>
						<label class="btn">
							<input type="radio" name="sort-value" value="title" /> Title
						</label>
						<label class="btn">
							<input type="radio" name="sort-value" value="date-created" /> Date Created
						</label>
					</div>
				</fieldset>
			</div>
		</div>
	</div>
	<div class="spg-container">
		<div class="shuffle-grid-container">
			<?php foreach( $posts as $post ) : ?>
				<figure class="picture-item column <?php esc_attr_e( $post->spg_data['span'] ); ?>" data-groups='["<?php echo implode( '","', $post->category_slugs ); ?>"]' data-date-created="<?php esc_attr_e( $post->post_date ); ?>" data-title="<?php esc_attr_e( $post->post_title ); ?>">
					<div class="aspect <?php esc_attr_e( $post->spg_data['aspect'] ); ?>">
						<div class="aspect__inner"><img src="<?php esc_attr_e( $post->spg_data['img_src'] ); ?>" obj.alt="obj.alt"/></div>
						<div class="picture-item__details">
							<figcaption class="picture-item__title"><a href="<?php the_permalink( $post ); ?>" target="_blank" rel="noopener"><?php esc_attr_e( $post->post_title ); ?></a></figcaption>
						</div>
					</div>
				</figure>
			<?php endforeach; ?>
			<div class="column my-sizer-element"></div>
		</div>
	</div>
</div>