<?php
   if ( ! defined( 'ABSPATH' ) ) exit;
   get_header();
   
   $paged = get_query_var('paged') ? get_query_var('paged') : 1;
   
   $cat_slug = get_query_var('blog-category') ? get_query_var('blog-category') : "";
   $tag_slug = get_query_var('blog-tag') ? get_query_var('blog-tag') : "";

   ?>
<main>
   <div id="contents_outer">
      <ul id="path" itemscope itemtype="https://schema.org/BreadcrumbList">
         <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
            <a itemprop="item" href="<?php echo HOME; ?>">
            <span itemprop="name">草津市・栗東市・守山市の不動産売却｜草津不動産売却テラス</span>
            </a>
         </li>
         <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
            <span itemprop="name">ブログ一覧</span>
         </li>
      </ul>
      <!-- contentsStart -->
	  <?php
			$args = [
				'post_type' => 'blog',
				'post_status' => 'publish',
				'paged' => $paged,
				'posts_per_page' => 20,
				'orderby' => 'post_date',
				'order' => 'DESC'
			];

			$tax_query = [];

			if( $cat_slug ) {
				$tax_query[] = [
					'taxonomy' => 'blog-category',
					'field' => 'slug',
					'terms' => $cat_slug
				];
			}

			if( $tag_slug ) {
				$tax_query[] = [
					'taxonomy' => 'blog-tag',
					'field' => 'slug',
					'terms' => $tag_slug
				];
			}

			if ( !empty($tax_query) ) {
				$args['tax_query'] = $tax_query;
			}

			$custom_query = new WP_Query( $args );
		?>

      <div id="contents" class="clearfix">
         <div class="pageHead">
            <h1 class="pageHead__ttl ui-bd-main">
               ブログ一覧 
            </h1>
         </div>
         <div class="l-page">
            <div class="newBlog">
			<?php custom_pagination($custom_query->max_num_pages, $paged, $custom_query->found_posts); ?>
               <div class="newBlog__head">
                  <h2 class="newBlog__contTtl ui-tx-sub">新着記事</h2>
                  <div class="categorySelect">
                     <span class="categorySelect__name">カテゴリ：</span>
					 <?php  
						$nav_cats_args = [
							'taxonomy' => 'blog-category',
							'hide_empty' => false,
						];

						$nav_cats = get_terms( $nav_cats_args );
					?>
                     <select name="categoryId" id="categoryId" class="categorySelect__item">
                        <option value="0" label="選択してください">選択してください</option>
						<?php foreach($nav_cats as $nav_cat) : ?>
                        <option value="<?php echo $nav_cat->slug; ?>" label="<?php echo $nav_cat->name; ?>"><?php echo $nav_cat->name; ?></option>
						<?php endforeach; ?>
                     </select>
                     <span class="categorySelect__name">タグ：</span>
					 <?php  
						$nav_tags_args = [
							'taxonomy' => 'blog-tag',
							'hide_empty' => false,
						];

						$nav_tags = get_terms( $nav_tags_args );
					 ?>
                     <select name="tagId" id="tagId" class="categorySelect__item">
                        <option value="0" label="選択してください">選択してください</option>
						<?php foreach($nav_tags as $nav_tag) : ?>
                        <option value="<?php echo $nav_tag->slug; ?>" label="<?php echo $nav_tag->name; ?>"><?php echo $nav_tag->name; ?></option>
						<?php endforeach; ?>
                     </select>
                  </div>
               </div>
               <?php if( $custom_query->have_posts() ) : ?>
               <div class="newBlog__wrap">
                  <ul class="newBlog__list">
					<?php while( $custom_query->have_posts() ) : $custom_query->the_post(); ?>
					<li class="newBlog__item js-boxLink hoverDefault ui-bd-main">
						<p class="newBlog__img">
							<a href="<?php echo the_permalink(); ?>" class="newBlog__link js-boxLink-link">
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
							<span class="categoryName ui-bg-sub">
								<a href="<?php echo get_term_link( $last_blog_cat->term_id ); ?>" class="js-boxLink-tag hoverDefault"><?php echo $last_blog_cat->name; ?></a>
							</span>
							<?php endif; ?>
						</p>
						<div class="newBlog__detail">
							<h2 class="newBlog__name"><?php the_title(); ?></h2>
							<div class="newBlog__comment"><?php the_excerpt(); ?></div>
							<?php
								$blog_tags = get_the_terms(get_the_ID(), 'blog-tag');
								if( !empty( $blog_tags ) ) :
							?>
							<div class="tagCont">
								<?php $tag_count = 0; ?>
								<?php foreach ($blog_tags as $blog_tag) : ?>
								<span class="tagCont__item js-boxLink-tag">
									<a href="<?php echo get_term_link( $blog_tag->term_id ); ?>" class="hoverDefault">#<?php echo $blog_tag->name; ?></a>
								</span>
								<?php $tag_count ++; ?>
								<?php if( $tag_count >= 3 ) break; ?>
								<?php endforeach; ?>
							</div>
							<?php endif; ?>
							<p class="newBlog__date">
								<?php the_time('Y-m-d'); ?>
							</p>
						</div>
					</li>
					 <?php endwhile; ?>
					 <?php wp_reset_postdata(); ?>
                  </ul>
               </div>
			   <?php else : ?>
			   <div class="newBlog__wrap">
				   <h3 class="otherContact__catch">検索結果はありません。</h3>
			   </div>
			   <?php endif; ?>
            </div>
            <?php custom_pagination($custom_query->max_num_pages, $paged, $custom_query->found_posts); ?>
            <div class="blog_conversion conversion_topMargin">
               <div class="cont-otherContact">
                  <div class="contInner">
                     <p class="otherContact__catch">
                        まずはご相談ください！
                     </p>
                     <ul class="otherContact__list">
                        <li class="otherContact__item--satei">
                           <a href="<?php echo HOME . 'assessment'; ?>" class="ui-bg-point hoverDefault" target="_blank" rel="nofollow">
                           <i class="fas fa-calculator otherContact__icn--satei"></i>無料査定を依頼する
                           </a>
                        </li>
                        <li class="otherContact__item--mail">
                           <a href="<?php echo HOME . 'contact'; ?>" class="ui-bg-sub hoverDefault" target="_blank" rel="nofollow">
                           <i class="far fa-envelope otherContact__icn--mail"></i>まずは無料相談する
                           </a>
                        </li>
                     </ul>
                     <div class="otherContact__about">
                        <p class="otherContact__tel">
                           <i class="fas fa-phone-alt ui-tx-sub otherContact__icn--tel"></i>077-565-0021 
                        </p>
                        <div class="otherContact__company">
                           <dl class="otherContact__info">
                              <dt class="otherContact__name">営業時間</dt>
                              <dd class="otherContact__text">
                                 09:00～18:00 
                              </dd>
                           </dl>
                           <dl class="otherContact__info">
                              <dt class="otherContact__name">定休日</dt>
                              <dd class="otherContact__text">
                                 土曜・日曜・祝日 
                              </dd>
                           </dl>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <?php
					$popular_args = [
						'post_type' => 'blog',
						'post_status' => 'publish',
						'posts_per_page' => 4,
						'meta_key' => 'wpb_post_views_count',
						'orderby' => 'meta_value_num',
						'order' => 'DESC',
					];

					$popular_query = new WP_Query( $popular_args );
				?>
            <?php if( $popular_query->have_posts() ) : ?>
            <div class="categoryArticle">
               <h2 class="categoryArticle__contTtl ui-tx-sub">人気の記事</h2>
               <ul class="categoryArticle__list">
               <?php while($popular_query->have_posts()) : $popular_query->the_post(); ?>
                  <li class="categoryArticle__item js-boxLink hoverDefault ui-bd-main">
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
                        <span class="categoryName ui-bg-sub">
                           <a href="<?php echo get_term_link( $last_blog_cat->term_id ); ?>" class="js-boxLink-tag hoverDefault"><?php echo $last_blog_cat->name; ?></a>
                        </span>
                        <?php endif; ?>
                     </p>
                     <div class="categoryArticle__wrap">
                        <h3 class="categoryArticle__ttl">任意売却　－不利な状況になる前に未来を見据えて－</h3>
                        <p class="categoryArticle__text">不利な状況になる前に未来を見据えて任意売却をローン返済でお悩&#8230;</p>
                        <p class="categoryArticle__date">2023-06-05</p>
                     </div>
                  </li>
                  <?php endwhile; ?>
                  <?php wp_reset_postdata(); ?>
               </ul>
               <?php endif; ?>
            </div>
            <?php if(!empty($nav_tags)) : ?>
            <div class="bottomTag">
               <h2 class="bottomTag__contTtl ui-tx-sub">タグ一覧</h2>
               <div class="bottomTag__wrap">
                  <div class="tagCont">
                     <?php foreach( $nav_tags as $nav_tag) : ?>
                     <span class="tagCont__item">
                     <a href="<?php echo get_term_link($nav_tag->term_id); ?>">#<?php echo $nav_tag->name; ?></a>
                     </span>
                     <?php endforeach; ?>
                  </div>
               </div>
            </div>
            <?php endif; ?>
            <p class="category__bt">
               <a href="http://localhost/trustrate/blog-categorytag" class="ui-bg-point hoverDefault">
               カテゴリ・タグ一覧
               </a>
            </p>
         </div>
         <script>
            $('#categoryId').on('change', function() {
            	var categoryId = $('#categoryId').val();
            	var url = '<?php echo HOME; ?>';
            	if (categoryId !== '0') {
            		url += 'blog/' + 'blog-category/	' + categoryId;
            		window.location.href = url;
            	}
            });
            
            $('#tagId').on('change', function() {
            	var tagId = $('#tagId').val();
            	var url = '<?php echo HOME; ?>';
            	if (tagId !== '0') {
            		url += 'blog/' + 'blog-tag/' + tagId;
            		window.location.href = url;
            	}
            });
         </script>
      </div>
      <!-- contentsEnd -->
   </div>
</main>
<?php get_footer(); ?>