<?php
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
$current_post_ID = get_the_ID();
?>

	<main>
		
		<div id="contents_outer">
			<ul id="path">
				<li>
					<a href="<?php echo HOME; ?>">
						<span itemprop="name">草津市・栗東市・守山市の不動産売却｜草津不動産売却テラス</span>
					</a>
				</li>
				<li>
					<a href="<?php echo HOME . 'blog/'; ?>">
						<span itemprop="name">ブログ一覧</span>
					</a>
				</li>
				<li>
					<span><?php the_title(); ?></span>
				</li>
			</ul>

			<div id="contents" class="clearfix">
				<div class="pageHead">
					<h1 class="pageHead__ttl ui-bd-main"><?php the_title(); ?></h1>
        </div>
				<div class="blogArticle">
          <div class="blogArticle__head">
            <p class="blogArticle__date"><?php the_time('Y-m-d'); ?></p>
						<?php
							$blog_cats = get_the_terms(get_the_ID(), 'blog-category');
							if( !empty( $blog_cats ) ) :
								$last_blog_cat = $blog_cats[0];
						?>
						<p class="headCategory__item ui-bg-sub">
                <a href="<?php echo get_term_link( $last_blog_cat->term_id, 'blog-category' ); ?>" class=""><?php echo $last_blog_cat->name; ?></a>
            </p>
						<?php endif; ?>
            
          </div>
          <div class="blogArticle__main"><?php the_content(); ?></div>
					
					<?php
						$blog_tags = get_the_terms(get_the_ID(), 'blog-tag');
						if( !empty( $blog_tags ) ) :
					?>
          <div class="bottomTag">
            <h2 class="bottomTag__contTtl ui-tx-sub">タグ一覧</h2>
            <div class="bottomTag__wrap">
							<div class="tagCont">
								<?php foreach ($blog_tags as $blog_tag) : ?>
									<span class="tagCont__item">
										<a href="<?php echo get_term_link( $blog_tag->term_id ); ?>" class="hoverDefault subcategory">#<?php echo $blog_tag->name; ?></a>
									</span>
								<?php endforeach; ?>
							</div>
            </div>
          </div>
					<?php endif; ?>

        </div>

				<div class="blogPager">
					<?php if( previous_post_link( "%link" ,'&lt;前へ') ) : ?><?php endif ; ?>
					<?php if( next_post_link( "%link" ,'次へ&gt;') ) : ?><?php endif ; ?>
    		</div>

				<p class="blogDetail__backListBtn">
					<a href="<?php echo HOME . 'blog/'; ?>">ブログ一覧ページへもどる</a>
				</p>

				<div class="blogDetail_conversion">
					<div class="cont-otherContact">
						<div class="contInner">
							<p class="otherContact__catch">
								まずはご相談ください！
							</p>
							<ul class="otherContact__list">
								<li class="otherContact__item--satei">
									<a href="<?php echo HOME . 'assessment/'; ?>" class="ui-bg-point hoverDefault" target="_blank" rel="nofollow">
										<i class="fas fa-calculator otherContact__icn--satei"></i>無料査定を依頼する
									</a>
								</li>
								<li class="otherContact__item--mail">
									<a href="<?php echo HOME . 'contact/'; ?>" class="ui-bg-sub hoverDefault" target="_blank" rel="nofollow">
										<i class="far fa-envelope otherContact__icn--mail"></i>まずは無料相談する
									</a>
								</li>
							</ul>
							<div class="otherContact__about">
								<p class="otherContact__tel"><i class="fas fa-phone-alt ui-tx-sub otherContact__icn--tel"></i>077-565-0021 </p>
								<div class="otherContact__company">
									<dl class="otherContact__info">
										<dt class="otherContact__name">営業時間</dt>
										<dd class="otherContact__text">09:00～18:00 </dd>
									</dl>
									<dl class="otherContact__info">
										<dt class="otherContact__name">定休日</dt>
										<dd class="otherContact__text">土曜・日曜・祝日 </dd>
									</dl>
								</div>
							</div>
						</div>
					</div>
				</div>

				<?php
					$current_terms = get_the_terms($current_post_ID, 'blog-category');
					if( !empty( $current_terms ) ) :
				?>
					<?php
						$related_args = [
							'post_type' => 'blog',
							'post_status' => 'publish',
							'posts_per_page' => 2,
							'orderby' => 'post_date',
							'order' => 'DESC',
							'post__not_in' => [$current_post_ID],
							'tax_query' => [
								[
									'taxonomy' => 'blog-category',
									'field'    => 'term_id',
									'terms'    => $current_terms[0]->term_id,
								],
							],
						];

						$related_query = new WP_Query( $related_args );
					?>
					<?php if( $related_query->have_posts() ) : ?>
					<div class="categoryArticle">
						<h2 class="categoryArticle__contTtl ui-tx-sub">関連記事</h2>
						<ul class="categoryArticle__list">
							<?php while ( $related_query->have_posts() ) : $related_query->the_post(); ?>
								<li class="categoryArticle__item--row1 hoverDefault js-boxLink" style="cursor: pointer;">
									<p class="categoryArticle__img">
										<a href="<?php echo the_permalink(); ?>" class="categoryArticle__link js-boxLink-link">
											<?php if( has_post_thumbnail() ): ?>
												<?php the_post_thumbnail("blog-thumbnail"); ?>
											<?php else: ?>
												<img src="<?php echo catch_that_image(); ?>" alt="<?php the_title(); ?>">
											<?php endif; ?>
										</a>
										<?php
											$blog_cats = get_the_terms(get_the_ID(), 'blog-category');
											if( !empty( $blog_cats ) ) :
												$last_blog_cat = $blog_cats[0];
										?>
										<span class="categoryName js-boxLink-tag ui-bg-sub">
											<a href="<?php echo get_term_link( $last_blog_cat->term_id ); ?>" class="hoverDefault"><?php echo $last_blog_cat->name; ?></a>
										</span>
										<?php endif; ?>
									</p>
									<div class="categoryArticle__wrap">
										<h3 class="categoryArticle__ttl"><?php the_title(); ?></h3>
										<p class="categoryArticle__text"><?php the_excerpt(); ?></p>
										<p class="categoryArticle__date"><?php the_time('Y-m-d'); ?></p>
									</div>
								</li>
							<?php endwhile; ?>
						</ul>
					</div>
					<?php wp_reset_postdata(); ?>
					<?php endif; ?>
				<?php endif; ?>

			</div>

		</div>

	</main>
<?php get_footer();?>
