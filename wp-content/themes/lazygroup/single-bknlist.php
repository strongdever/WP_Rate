<?php
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
?>

	<?php
	if ( have_posts() ) :
		while ( have_posts() ) : the_post();

		$current_post_ID = get_the_ID();

		$current_cat = get_the_category() ? get_the_category()[0] : [];

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
					<a href="<?php echo HOME . 'bknlist/'; ?>">
						<span itemprop="name">売り物件一覧</span>
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
				
				<div class="bknDetailWrapper">
					<div class="bknDetail_top">
						<?php if( have_rows('thumb_gallery') ): ?>
						<div class="bknImageWrapper section_wrap">
              <div class="bknImage__main js-bknSlide-main">
								<?php while( have_rows('thumb_gallery') ) : the_row(); ?>
								<?php $description = get_sub_field('description') ? '【' . get_sub_field('subject') . '】' . get_sub_field('description') : '【' . get_sub_field('subject') . '】 -'; ?>
                <div class="bknImage__item">
                  <p class="bknImage__image">
                    <img src="<?php echo esc_attr( get_sub_field('image') ); ?>" alt="<?php echo '【' . get_sub_field('subject') . '】'; ?>" title="<?php echo '【' . get_sub_field('subject') . '】'; ?>" oncontextmenu="return false"/>
									</p>
                  <p class="bknImage__comment"><?php echo $description; ?></p>
                </div>
								<?php endwhile; ?>
              </div>
              <div class="bknImage__thumbnails js-bknSlide-thumb">
								<?php $thumbnail_number = 1; ?>
								<?php while( have_rows('thumb_gallery') ) : the_row(); ?>
                <div id="<?php echo 'n_' . $thumbnail_number; ?>" class="bknImage__thumbnailItem imgLiquidFill disp_list">
                  <img src="<?php echo esc_attr( get_sub_field('image') ); ?>" alt="<?php echo '【' . get_sub_field('subject') . '】'; ?>" title="<?php echo '【' . get_sub_field('subject') . '】'; ?>" width="64" height="48" data-comment="<?php echo $description; ?>" oncontextmenu="return false" />
									<span class="bknImage__thumbnailComment"><?php echo get_sub_field('subject'); ?></span>
                </div>
								<?php $thumbnail_number ++; ?>
								<?php endwhile; ?>
              </div>
              <script>
                $(function() {
                  var slider = '.js-bknSlide-main';
                  var thumbnailItem = '.js-bknSlide-thumb .bknImage__thumbnailItem';

                  $(thumbnailItem).each(function() {
                    var index = $(thumbnailItem).index(this);
                    $(this).attr('data-index', index);
                  });

                  $(slider).on('init', function(slick) {
                    var index = $('.slide-item.slick-slide.slick-current').attr('data-slick-index');
                    $(thumbnailItem + '[data-index="' + index + '"]').addClass('thumbnail-current');
                  });

                  $(slider).slick({
                    autoplay: true,
                    arrows: false,
                    fade: true,
                    infinite: false
                  });
                  $(thumbnailItem).on('click', function() {
                    var index = $(this).attr('data-index');
                    $(slider).slick('slickGoTo', index, false);
                  });

                  $(slider).on('beforeChange', function(event, slick, currentSlide, nextSlide) {
                    $(thumbnailItem).each(function() {
                      $(this).removeClass('thumbnail-current');
                    });
                    $(thumbnailItem + '[data-index="' + nextSlide + '"]').addClass('thumbnail-current');
                  });
                });
              </script>
            </div>
						<?php endif; ?>
						
						<div class="basicInfo section_wrap">

							<?php if( $current_cat->cat_name == "中古一戸建"  ) : ?>
								<div class="basicInfo__wrapper">
									<p class="basicInfo__type"><?php echo $current_cat->name; ?></p>
									<dl>
										<dt><?php echo $current_cat->term_id . '-' . $current_cat->cat_name; ?></dt>
										<dd>
											<span class="basicInfo__price"><?php echo number_format( get_field('property_price') ); ?>万円</span>
											<a href="javascript:void(0);" class="ui_button simulation__button">
												<i class="fas fa-calculator ui-tx-main"></i>支払いシミュレーション
											</a>
										</dd>
									</dl>
									<dl>
										<dt>所在地</dt>
										<dd>
											<?php echo get_field('property_location') ? get_field('property_location') : '-'; ?>
											<a href="javascript:void(0);" class="bknDetail__mapIcon">
												<img src="<?php echo T_DIRE_URI; ?>/assets/images/icon_map.jpg" alt="MAP" />
											</a>
										</dd>
									</dl>
									<dl>
										<dt>交通</dt>
										<?php 
											$stripped_text = strip_tags( get_field('property_traffic') );
											$first_line = '';
											if (preg_match('/^(.*)$/m', $stripped_text, $matches)) {
												$first_line = $matches[1];
											}
										?>
										<dd><?php echo $first_line ? $first_line : '-'; ?></dd>
									</dl>
									<script>
										$(function() {
											$('.simulation__button').on('click', function() {
												$('html,body').animate({
													scrollTop: $('#loanSimulation').offset().top - 60
												});
											});

											$('.bknDetail__mapIcon').on('click', function() {
												$('html,body').animate({
													scrollTop: $('#bknAddress-map').offset().top - 60
												});
											});
										});
									</script>
									<?php if( get_field('property_profit') ) : ?>
									<dl>
										<dt>利回り</dt>
										<dd><?php echo get_field('property_profit') ? get_field('property_profit	') : '-'; ?></dd>
									</dl>
									<?php endif; ?>
									<dl>
										<dt>間取り</dt>
										<dd><?php echo get_field('property_floorplan') ? get_field('property_floorplan') : '-'; ?></dd>
									</dl>
									<dl>
										<dt>建物面積(坪数)</dt>
										<dd><?php echo get_field('property_buildingarea') ? get_field('property_buildingarea') : '-'; ?></dd>
									</dl>
									<dl>
										<dt>向き</dt>
										<dd><?php echo get_field('property_direction') ? get_field('property_direction') : '-'; ?></dd>
									</dl>
									<dl>
										<dt>土地面積(坪数)</dt>
										<dd><?php echo get_field('property_landarea') ? get_field('property_landarea') : '-'; ?></dd>
									</dl>
									<dl>
										<dt>築年月(築年数)</dt>
										<dd><?php echo get_field('property_buildingdate') ? get_field('property_buildingdate') : '-'; ?></dd>
									</dl>
									<?php if( get_field('property_storey') ) : ?>
									<dl>
										<dt>階建て</dt>
										<dd><?php echo get_field('property_storey') ? get_field('property_storey') : '-'; ?></dd>
									</dl>
									<?php endif; ?>
								</div>


							
							<?php elseif( $current_cat->cat_name == "マンション
" ) : ?>
								<div class="basicInfo__wrapper">
									<p class="basicInfo__type"><?php echo $current_cat->name; ?></p>
									<dl>
										<dt><?php echo $current_cat->term_id . '-' . $current_cat->cat_name; ?></dt>
										<dd>
											<span class="basicInfo__price"><?php echo number_format( get_field('property_price') ); ?>万円</span>
											<a href="javascript:void(0);" class="ui_button simulation__button">
												<i class="fas fa-calculator ui-tx-main"></i>支払いシミュレーション
											</a>
										</dd>
									</dl>
									<dl>
										<dt>所在地</dt>
										<dd>
											<?php echo get_field('property_location') ? get_field('property_location') : '-'; ?>
											<a href="javascript:void(0);" class="bknDetail__mapIcon">
												<img src="<?php echo T_DIRE_URI; ?>/assets/images/icon_map.jpg" alt="MAP">
											</a>
										</dd>
									</dl>
									<dl>
										<dt>交通</dt>
										<?php 
											$stripped_text = strip_tags( get_field('property_traffic') );
											$first_line = '';
											if (preg_match('/^(.*)$/m', $stripped_text, $matches)) {
												$first_line = $matches[1];
											}
										?>
										<dd><?php echo $first_line ? $first_line : '-'; ?></dd>
									</dl>
									<script>
										$(function() {
											$('.simulation__button').on('click', function() {
												$('html,body').animate({
													scrollTop: $('#loanSimulation').offset().top - 60
												});
											});

											$('.bknDetail__mapIcon').on('click', function() {
												$('html,body').animate({
													scrollTop: $('#bknAddress-map').offset().top - 60
												});
											});
										});
									</script>
									<dl>
										<dt>専有面積</dt>
										<dd><?php echo get_field('property_exclusivearea') ? get_field('property_exclusivearea') : '-'; ?></dd>
									</dl>
									<dl>
										<dt>間取り</dt>
										<dd><?php echo get_field('property_floorplan') ? get_field('property_floorplan') : '-'; ?></dd>
									</dl>
									<dl>
										<dt>向き</dt>
										<dd><?php echo get_field('property_direction') ? get_field('property_direction') : '-'; ?></dd>
									</dl>
									<dl>
										<dt>所在階 / 階建て</dt>
										<dd><?php echo get_field('property_floor') ? get_field('property_floor') : '-'; ?></dd>
									</dl>
									<dl>
										<dt>築年月(築年数)</dt>
										<dd><?php echo get_field('property_buildingdate') ? get_field('property_buildingdate') : '-'; ?></dd>
									</dl>
								</div>


							<?php elseif( $current_cat->cat_name == "マンション
" ) : ?>
								<div class="basicInfo__wrapper">
									<p class="basicInfo__type"><?php echo $current_cat->name; ?></p>
									<dl>
										<dt><?php echo $current_cat->term_id . '-' . $current_cat->cat_name; ?></dt>
										<dd>
											<span class="basicInfo__price"><?php echo number_format( get_field('property_price') ); ?>万円</span>
											<a href="javascript:void(0);" class="ui_button simulation__button">
												<i class="fas fa-calculator ui-tx-main"></i>支払いシミュレーション
											</a>
										</dd>
									</dl>

									<dl>
										<dt>所在地</dt>
										<dd>
											<?php echo get_field('property_location') ? get_field('property_location') : '-'; ?>
											<a href="javascript:void(0);" class="bknDetail__mapIcon">
												<img src="<?php echo T_DIRE_URI; ?>/assets/images/icon_map.jpg" alt="MAP">
											</a>
										</dd>
									</dl>
									<dl>
										<dt>交通</dt>
										<?php 
											$stripped_text = strip_tags( get_field('property_traffic') );
											$first_line = '';
											if (preg_match('/^(.*)$/m', $stripped_text, $matches)) {
												$first_line = $matches[1];
											}
										?>
										<dd><?php echo $first_line ? $first_line : '-'; ?></dd>
									</dl>
									<dl>
										<dt>利回り</dt>
										<dd><?php echo get_field('property_profit') ? get_field('property_profit') : '-'; ?></dd>
									</dl>
									<dl>
										<dt>管理費</dt>
										<dd><?php echo get_field('property_managementfee') ? get_field('property_managementfee') : '-'; ?></dd>
									</dl>
									<script>
										$(function() {
											$('.simulation__button').on('click', function() {
												$('html,body').animate({
													scrollTop: $('#loanSimulation').offset().top - 60
												});
											});

											$('.bknDetail__mapIcon').on('click', function() {
												$('html,body').animate({
													scrollTop: $('#bknAddress-map').offset().top - 60
												});
											});
										});
									</script>
									<dl>
										<dt>間取り</dt>
										<dd><?php echo get_field('property_floorplan') ? get_field('property_floorplan') : '-'; ?></dd>
									</dl>
									<dl>
										<dt>建物面積(坪数)</dt>
										<dd><?php echo get_field('property_buildingarea') ? get_field('property_buildingarea') : '-'; ?></dd>
									</dl>
									<dl>
										<dt>向き</dt>
										<dd><?php echo get_field('property_direction') ? get_field('property_direction') : '-'; ?></dd>
									</dl>
									<dl>
										<dt>築年月(築年数)</dt>
										<dd><?php echo get_field('property_buildingdate') ? get_field('property_buildingdate') : '-'; ?></dd>
									</dl>
									<dl>
										<dt>階建て</dt>
										<dd><?php echo get_field('property_storey') ? get_field('property_storey') : '-'; ?></dd>
									</dl>
								</div>


							<?php elseif( $current_cat->cat_name == '売地' ) : ?>
								<div class="basicInfo__wrapper">
									<p class="basicInfo__type"><?php echo $current_cat->name; ?></p>
									<dl>
										<dt><?php echo $current_cat->term_id . '-' . $current_cat->cat_name; ?></dt>
										<dd>
											<span class="basicInfo__price"><?php echo number_format( get_field('property_price') ); ?>万円</span>
										</dd>
									</dl>

									<dl>
										<dt>所在地</dt>
										<dd>
											<?php echo get_field('property_location') ? get_field('property_location') : '-'; ?>
											<a href="javascript:void(0);" class="bknDetail__mapIcon">
												<img src="<?php echo T_DIRE_URI; ?>/assets/images/icon_map.jpg" alt="MAP">
											</a>
										</dd>
									</dl>
									<dl>
										<dt>交通</dt>
										<?php 
											$stripped_text = strip_tags( get_field('property_traffic') );
											$first_line = '';
											if (preg_match('/^(.*)$/m', $stripped_text, $matches)) {
												$first_line = $matches[1];
											}
										?>
										<dd><?php echo $first_line ? $first_line : '-'; ?></dd>
									</dl>
									<dl>
										<dt>利回り</dt>
										<dd><?php echo get_field('property_profit') ? get_field('property_profit') : '-'; ?></dd>
									</dl>
									<dl>
										<dt>土地面積(坪数)</dt>
										<dd><?php echo get_field('property_landarea') ? get_field('property_landarea') . '(' . get_field('property_tsubo') . ')' : '-'; ?></dd>
									</dl>
									<script>
										$(function() {
											$('.simulation__button').on('click', function() {
												$('html,body').animate({
													scrollTop: $('#loanSimulation').offset().top - 60
												});
											});

											$('.bknDetail__mapIcon').on('click', function() {
												$('html,body').animate({
													scrollTop: $('#bknAddress-map').offset().top - 60
												});
											});
										});
									</script>
									<?php  
										$property_structure_arr = explode('/', get_field('property_ratio'));
										$property_coverage = trim( $property_structure_arr[0] );
										$property_area = trim( $property_structure_arr[1] );
									?>
									<dl>
										<dt>建ぺい率</dt>
										<dd><?php echo $property_coverage ? $property_coverage : '-'; ?></dd>
									</dl>
									<dl>
										<dt>容積率</dt>
										<dd><?php echo $property_area ? $property_area : '-'; ?></dd>
									</dl>									
								</div>
							<?php endif; ?>
              <div class="basicInfo__contact">
                <p class="otherContact__catch">
                  まずはご相談ください！
                </p>
                <ul class="otherContact__list">
                  <li class="otherContact__item--satei">
                    <a href="<?php echo HOME . 'bkncontact/'; ?>" class="ui-bg-point hoverDefault" target="_blank">
                      <i class="far fa-envelope otherContact__icn--mail"></i>この物件にお問い合わせする
                    </a>
                  </li>
                </ul>
                <div class="otherContact__about">
                  <p class="otherContact__tel">
                    <i class="fas fa-phone-alt ui-tx-sub otherContact__icn--tel"></i>077-565-0021 </p>
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

					<div class="bknDetailWrapper__detailInfo section_wrap">
						<div class="bknDetailWrapper__detailInfo--title">
							<h2 class="bknCont__contTtl ui-tx-sub">物件概要</h2>
							<div>
								<span>物件番号：<?php echo get_field('property_number'); ?> / </span>
								<span>情報更新日：<?php echo get_field('property_updatedate') ? get_field('property_updatedate') : '-'; ?> / </span>
								<span>更新予定日：<?php echo get_field('property_scheduledate') ? get_field('property_scheduledate') : '-'; ?> / </span>
								<span>取引条件の有効期限：<?php echo get_field('property_deadlinedate') ? get_field('property_deadlinedate') : '-'; ?></span>
							</div>
						</div>
						<?php if( $current_cat->cat_name == "中古一戸建" ) : ?>
						<div class="bknDetailWrapper__detailInfo--data">
							<table>
								<tbody>
									<tr>
										<th><?php echo $current_cat->term_id . '-' . $current_cat->cat_name; ?></th>
										<td>
											<span class="basicInfo__price"><?php echo number_format( get_field('property_price') ); ?>万円</span>
											<a href="javascript:void(0);" class="ui_button simulation__button">
												<i class="fas fa-calculator ui-tx-main ui_icon-mail"></i>支払いシミュレーション
											</a>
										</td>
										<th>利回り</th>
										<td><?php echo get_field('property_profit') ? get_field('property_profit') : '-'; ?></td>
									</tr>
									<tr>
										<th>所在地</th>
										<td>
											<?php echo get_field('property_location') ? get_field('property_location') : '-'; ?>
											<a href="javascript:void(0);" class="bknDetail__mapIcon">
												<img src="<?php echo T_DIRE_URI; ?>/assets/images/icon_map.jpg" alt="MAP">
											</a>
										</td>
										<th>交通</th>
										<td><?php echo get_field('property_traffic') ? get_field('property_traffic') : '-'; ?></td>
									</tr>
									<tr>
										<th>間取り(詳細)</th>
										<td><?php echo get_field('property_floorplandetail') ? get_field('property_floorplandetail') : '-'; ?></td>
										<th>階建て</th>
										<td><?php echo get_field('property_storey') ? get_field('property_storey') : '-'; ?></td>
									</tr>
									<tr>
										<th>建物面積(坪数)</th>
										<td><?php echo get_field('property_buildingarea') ? get_field('property_buildingarea') : '-'; ?></td>
										<th>土地面積(坪数)</th>
										<td><?php echo get_field('property_landarea') ? get_field('property_landarea') : '-'; ?></td>
									</tr>
									<tr>
										<th>築年月(築年数)</th>
										<td><?php echo get_field('property_buildingdate') ? get_field('property_buildingdate') : '-'; ?></td>
										<th>建物構造</th>
										<td><?php echo get_field('property_structure') ? get_field('property_structure') : '-'; ?></td>
									</tr>
									<tr>
										<th>向き</th>
										<td><?php echo get_field('property_direction') ? get_field('property_direction') : '-'; ?></td>
										<th>地目 / 地勢</th>
										<td><?php echo get_field('property_terrain') ? get_field('property_terrain') : '-'; ?></td>
									</tr>
									<tr>
										<th>傾斜地部分面積 / 路地状敷地</th>
										<td><?php echo get_field('property_slopearea') ? get_field('property_slopearea') : '-'; ?> / <?php echo get_field('property_alley') ? get_field('property_alley') : '-'; ?></td>
										<th>接道状況</th>
										<td><?php echo get_field('property_situation') ? get_field('property_situation') : '-'; ?></td>
									</tr>
									<tr>
										<th>建ぺい率 / 容積率</th>
										<td><?php echo get_field('property_ratio') ? get_field('property_ratio') : '-'; ?></td>
										<th>用途地域</th>
										<td><?php echo get_field('property_usearea') ? get_field('property_usearea') : '-'; ?></td>
									</tr>
									<tr>
										<th>都市計画</th>
										<td><?php echo get_field('property_city') ? get_field('property_city') : '-'; ?></td>
										<th>駐車場 / 月額料金</th>
										<td><?php echo get_field('property_parking') ? get_field('property_parking') : '-'; ?></td>
									</tr>
									<tr>
										<th>土地の敷金 / 保証金</th>
										<td><?php echo get_field('property_deposit') ? get_field('property_deposit') : '-'; ?></td>
										<th>借地料 / 借地期間</th>
										<td><?php echo get_field('property_lease') ? get_field('property_lease') : '-'; ?></td>
									</tr>
									<tr>
										<th>私道負担面積 /<br>セットバック</th>
										<td><?php echo get_field('property_driveway') ? get_field('property_driveway') : '-'; ?></td>
										<th>現況 / 引渡時期</th>
										<td><?php echo get_field('property_currentstatus') ? get_field('property_currentstatus') : '-'; ?></td>
									</tr>
									<tr>
										<th>建築確認番号</th>
										<td><?php echo get_field('property_buildnumber') ? get_field('property_buildnumber') : '-'; ?></td>
										<th>法令上の制限</th>
										<td><?php echo get_field('property_legal') ? get_field('property_legal') : '-'; ?></td>
									</tr>
									<tr>
										<th>取引態様</th>
										<td><?php echo get_field('property_transaction') ? get_field('property_transaction') : '-'; ?></td>
										<th>販売区画数 / 総区画数</th>
										<td><?php echo get_field('property_salenumber') ? get_field('property_salenumber') : '-'; ?></td>
									</tr>
									<tr>
										<th>設備条件</th>
										<td colspan="3">
											<?php 
												$property_condition_str = get_field('property_equipment');
												$property_condition_arr = explode(',', $property_condition_str);
											?>
											<?php if( !empty( $property_condition_arr ) ) : ?>
											<ul class="bknDetailWrapper__facilities--name">
												<?php foreach ($property_condition_arr as $condition) : ?>
													<li><?php echo $condition; ?></li>
												<?php endforeach; ?>
											</ul>
											<?php endif; ?>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<?php elseif( $current_cat->cat_name == "中古マンション" ) : ?>
							<div class="bknDetailWrapper__detailInfo--data">
								<table>
									<tbody>
										<tr>
											<th><?php echo $current_cat->term_id . '-' . $current_cat->cat_name; ?></th>
											<td>
												<span class="basicInfo__price"><?php echo number_format( get_field('property_price') ); ?>万円</span>
												<a href="javascript:void(0);" cl        ass="ui_button simulation__button">
													<i class="fas fa-calculator ui-tx-main ui_icon-mail"></i>支払いシミュレーション
												</a>
											</td>
											<th>管理費</th>
											<td><?php echo get_field('property_managementfee') ? get_field('property_managementfee') : '-'; ?></td>
										</tr>

										<tr>
											<th>修繕積立金</th>
											<td><?php echo get_field('property_reserve_fund') ? get_field('property_reserve_fund') : '-'; ?></td>
											<th>修繕積立基金</th>
											<td><?php echo get_field('property_repaire_fund') ? get_field('property_repaire_fund') : '-'; ?></td>
										</tr>
										<tr>
											<th>所在地</th>
											<td>
												<?php echo get_field('property_location') ? get_field('property_location') : '-'; ?>
												<a href="javascript:void(0);" class="bknDetail__mapIcon">
													<img src="<?php echo T_DIRE_URI; ?>/assets/images/icon_map.jpg" alt="MAP">
												</a>
											</td>
											<th>交通</th>
											<td><?php echo get_field('property_traffic') ? get_field('property_traffic') : '-'; ?></td>
										</tr>
										<tr>
											<th>専有面積</th>
											<td><?php echo get_field('property_exclusivearea') ? get_field('property_exclusivearea') : '-'; ?></td>
											<th>間取り(詳細)</th>
											<td><?php echo get_field('property_floorplandetail') ? get_field('property_floorplandetail') : '-'; ?></td>
										</tr>
										<tr>
											<th>向き</th>
											<td><?php echo get_field('property_direction') ? get_field('property_direction') : '-'; ?></td>
											<th>所在階 / 階建て</th>
											<td><?php echo get_field('property_stage') ? get_field('property_stage') : '-'; ?> / <?php echo get_field('property_storey') ? get_field('property_storey	') : '-'; ?></td>
										</tr>
										<tr>
											<th>築年月(築年数)</th>
											<td><?php echo get_field('property_buildingdate') ? get_field('property_buildingdate') : '-'; ?></td>
											<th>販売戸数 / 棟総戸数</th>
											<td><?php echo get_field('property_soldnumber') ? get_field('property_soldnumber') : '-'; ?></td>
										</tr>
										<tr>
											<th>土地権利</th>
											<td><?php echo get_field('property_landrule') ? get_field('property_landrule') : '-'; ?></td>
											<th>権利金</th>
											<td><?php echo get_field('property_keymoney') ? get_field('property_keymoney') : '-'; ?></td>
										</tr>
										<tr>
											<th>管理組合有無</th>
											<td><?php echo get_field('property_managementportfolio') ? get_field('property_managementportfolio') : '-'; ?></td>
											<th>管理形態</th>
											<td><?php echo get_field('property_managementtype') ? get_field('property_managementtype') : '-'; ?></td>
										</tr>
										<tr>
											<th>管理方式</th>
											<td><?php echo get_field('property_managementstyle') ? get_field('property_managementstyle') : '-'; ?></td>
											<th>管理会社</th>
											<td><?php echo get_field('property_managementcomapany') ? get_field('property_managementcomapany') : '-'; ?></td>
										</tr>
										<tr>
											<th>現況</th>
											<td><?php echo get_field('property_situation') ? get_field('property_situation') : '-'; ?></td>
											<th>引渡時期</th>
											<td><?php echo get_field('property_period') ? get_field('property_period') : '-'; ?></td>
										</tr>
										<tr>
											<th>バルコニー面積</th>
											<td><?php echo get_field('property_balconyarea') ? get_field('property_balconyarea') : '-'; ?></td>
											<th>ルーフバルコニー面積</th>
											<td><?php echo get_field('property_roofbalconyarea') ? get_field('property_roofbalconyarea') : '-'; ?></td>
										</tr>
										<tr>
											<th>テラス面積</th>
											<td><?php echo get_field('property_terracearea') ? get_field('property_terracearea') : '-'; ?></td>
											<th>専用庭面積</th>
											<td><?php echo get_field('property_gardenarea') ? get_field('property_gardenarea') : '-'; ?></td>
										</tr>
										<tr>
											<th>用途地域</th>
											<td><?php echo get_field('property_usearea') ? get_field('property_usearea') : '-'; ?></td>
											<th>取引態様</th>
											<td><?php echo get_field('property_transaction') ? get_field('property_transaction') : '-'; ?></td>
										</tr>
										<tr>
											<th>駐車場 / 月額料金</th>
											<td><?php echo get_field('property_parking') ? get_field('property_parking') : '-'; ?></td>
											<th>土地の敷金 / 保証金</th>
											<td><?php echo get_field('property_deposit') ? get_field('property_deposit') : '-'; ?></td>
										</tr>
										<tr>
											<th>地勢</th>
											<td><?php echo get_field('property_area') ? get_field('property_area') : '-'; ?></td>
											<th>国土法届出要否</th>
											<td><?php echo get_field('property_landact') ? get_field('property_landact') : '-'; ?></td>
										</tr>
										<tr>
											<th>建物構造</th>
											<td><?php echo get_field('property_situation') ? get_field('property_situation') : '-'; ?></td>
											<th>建築確認番号</th>
											<td><?php echo get_field('property_buildnumber') ? get_field('property_buildnumber') : '-'; ?></td>
										</tr>
										<tr>
											<th>設備条件</th>
											<td colspan="3">
												<?php 
													$property_condition_str = get_field('property_equipment');
													$property_condition_arr = explode(',', $property_condition_str);
												?>
												<?php if( !empty( $property_condition_arr ) ) : ?>
												<ul class="bknDetailWrapper__facilities--name">
													<?php foreach ($property_condition_arr as $condition) : ?>
														<li><?php echo $condition; ?></li>
													<?php endforeach; ?>
												</ul>
												<?php endif; ?>
											</td>
										</tr>
										<?php if( get_field('property_other_equipment') ) : ?>
										<tr>
											<th>設備(その他)</th>
											<td colspan="3"><?php echo get_field('property_other_equipment') ? get_field('property_other_equipment') : '-'; ?></td>
										</tr>
										<?php endif; ?>
										<?php if( get_field('property_other_condition') ) : ?>
										<tr>
											<th>条件(その他)</th>
											<td colspan="3"><?php echo get_field('property_other_condition') ? get_field('property_other_condition') : '-'; ?></td>
										</tr>
										<?php endif; ?>
									</tbody>
								</table>
							</div>
						<?php elseif( $current_cat->cat_name == "中古マンション" ) : ?>
							<div class="bknDetailWrapper__detailInfo--data">
								<table>
									<tbody>
										<tr>
											<th><?php echo $current_cat->term_id . '-' . $current_cat->cat_name; ?></th>
											<td>
												<span class="basicInfo__price"><?php echo number_format( get_field('property_price') ); ?>万円</span>
												<a href="javascript:void(0);" class="ui_button simulation__button">
													<i class="fas fa-calculator ui-tx-main ui_icon-mail"></i>支払いシミュレーション
												</a>
											</td>
											<th>利回り</th>
											<td><?php echo get_field('property_profit') ? get_field('property_profit') : '-'; ?></td>
										</tr>
										<tr>
											<th>管理費</th>
											<td><?php echo get_field('property_managementfee') ? get_field('property_managementfee') : '-'; ?></td>
											<th>所在地</th>
											<td>
												<?php echo get_field('property_location') ? get_field('property_location') : '-'; ?>
												<a href="javascript:void(0);" class="bknDetail__mapIcon">
													<img src="<?php echo T_DIRE_URI; ?>/assets/images/icon_map.jpg" alt="MAP">
												</a>
											</td>
										</tr>
										<tr>
											<th>交通</th>
											<td><?php echo get_field('property_traffic') ? get_field('property_traffic') : '-'; ?></td>
											<th>間取り(詳細)</th>
											<td><?php echo get_field('property_floorplandetail') ? get_field('property_floorplandetail') : '-'; ?></td>
										</tr>
										<tr>
											<th>建物面積(坪数)</th>
											<td><?php echo get_field('property_buildingarea') ? get_field('property_buildingarea') : '-'; ?></td>
											<th>向き</th>
											<td><?php echo get_field('property_direction') ? get_field('property_direction') : '-'; ?></td>
										</tr>
										<tr>
											<th>築年月(築年数)</th>
											<td><?php echo get_field('property_buildingdate') ? get_field('property_buildingdate') : '-'; ?></td>
											<th>建物構造</th>
											<td><?php echo get_field('property_structure') ? get_field('property_structure') : '-'; ?></td>
										</tr>
										<tr>
											<th>階建て</th>
											<td><?php echo get_field('property_storey') ? get_field('property_storey') : '-'; ?></td>
											<th>現況 / 引渡時期</th>
											<td><?php echo get_field('property_currentstatus') ? get_field('property_currentstatus') : '-'; ?></td>
										</tr>
										<tr>
											<th>駐車場 / 月額料金</th>
											<td><?php echo get_field('property_parking') ? get_field('property_parking') : '-'; ?></td>
											<th>土地権利</th>
											<td><?php echo get_field('property_landrule') ? get_field('property_landrule') : '-'; ?></td>
										</tr>
										<tr>
											<th>土地面積</th>
											<td><?php echo get_field('property_landarea') ? get_field('property_landarea') : '-'; ?></td>
											<th>地目 / 地勢</th>
											<td><?php echo get_field('property_terrain') ? get_field('property_terrain') : '-'; ?></td>
										</tr>
										<tr>
											<th>接道状況</th>
											<td><?php echo get_field('property_contactstatus') ? get_field('property_contactstatus') : '-'; ?></td>
											<th>建ぺい率 / 容積率</th>
											<td><?php echo get_field('property_ratio') ? get_field('property_ratio') : '-'; ?></td>
										</tr>
										<tr>
											<th>用途地域</th>
											<td><?php echo get_field('property_usearea') ? get_field('property_usearea') : '-'; ?></td>
											<th>都市計画</th>
											<td><?php echo get_field('property_city') ? get_field('property_city') : '-'; ?></td>
										</tr>
										<tr>
											<th>管理組合有無</th>
											<td><?php echo get_field('property_managementportfolio') ? get_field('property_managementportfolio') : '-'; ?></td>
											<th>管理形態</th>
											<td><?php echo get_field('property_managementtype') ? get_field('property_managementtype') : '-'; ?></td>
										</tr>
										<tr>
											<th>管理方式</th>
											<td><?php echo get_field('property_managementstyle') ? get_field('property_managementstyle') : '-'; ?></td>
											<th>管理会社</th>
											<td><?php echo get_field('property_managementcomapany') ? get_field('property_managementcomapany') : '-'; ?></td>
										</tr>
										<tr>
											<th>国土法届出要否</th>
											<td><?php echo get_field('property_landact') ? get_field('property_landact') : '-'; ?></td>
											<th>法令上の制限</th>
											<td><?php echo get_field('property_law') ? get_field('property_law') : '-'; ?></td>
										</tr>
										<tr>
											<th>取引態様</th>
											<td><?php echo get_field('property_transaction') ? get_field('property_transaction') : '-'; ?></td>
											<th>販売戸数 / 棟総戸数</th>
											<td><?php echo get_field('property_soldnumber') ? get_field('property_soldnumber') : '-'; ?></td>
										</tr>
										<tr>
											<th>設備条件</th>
											<td colspan="3">
												<?php 
													$property_condition_str = get_field('property_equipment');
													$property_condition_arr = explode(',', $property_condition_str);
												?>
												<?php if( !empty( $property_condition_arr ) ) : ?>
												<ul class="bknDetailWrapper__facilities--name">
													<?php foreach ($property_condition_arr as $condition) : ?>
														<li><?php echo $condition; ?></li>
													<?php endforeach; ?>
												</ul>
												<?php endif; ?>
											</td>
										</tr>
									</tbody>
								</table>
							</div>						
						<?php elseif( $current_cat->cat_name == "売地" ) : ?>
							<div class="bknDetailWrapper__detailInfo--data">
								<table>
									<tbody>
										<tr>
											<th><?php echo $current_cat->term_id . '-' . $current_cat->cat_name; ?></th>
											<td>
												<span class="basicInfo__price"><?php echo number_format( get_field('property_price') ); ?>万円</span>
											</td>
											<th>坪単価</th>
											<td><?php echo get_field('property_unitprice') ? get_field('property_unitprice') : '-'; ?></td>
										</tr>
										<tr>
											<th>所在地</th>
											<td>
												<?php echo get_field('property_location') ? get_field('property_location') : '-'; ?>
												<a href="javascript:void(0);" class="bknDetail__mapIcon">
													<img src="<?php echo T_DIRE_URI; ?>/assets/images/icon_map.jpg" alt="MAP">
												</a>
											</td>
											<th>交通</th>
											<td><?php echo get_field('property_traffic') ? get_field('property_traffic') : '-'; ?></td>
										</tr>
										<tr>
										<th>土地面積(坪数)</th>
											<td><?php echo get_field('property_landarea') ? get_field('property_landarea') . '(' . get_field('property_tsubo') . ')' : '-'; ?></td>
											<th>私道負担面積 /セットバック</th>
											<td><?php echo get_field('property_driveway') ? get_field('property_driveway') : '-'; ?></td>
										</tr>
										<tr>
											<th>現況</th>
											<td><?php echo get_field('property_currentstatus') ? get_field('property_currentstatus') : '-'; ?></td>
											<th>土地権利</th>
											<td><?php echo get_field('property_landrule') ? get_field('property_landrule') : '-'; ?></td>
										</tr>
										<tr>
											<th>建築条件</th>
											<td><?php echo get_field('property_buildingstatus') ? get_field('property_buildingstatus') : '-'; ?></td>
											<th>地目 / 地勢</th>
											<td><?php echo get_field('property_terrain') ? get_field('property_terrain') : '-'; ?></td>
										</tr>
										<tr>
											<th>接道状況</th>
											<td><?php echo get_field('property_situation') ? get_field('property_situation') : '-'; ?></td>
											<th>建ぺい率 / 容積率</th>
											<td><?php echo get_field('property_ratio') ? get_field('property_ratio') : '-'; ?></td>
										</tr>
										<tr>
											<th>用途地域 / 最適用途</th>
											<td><?php echo get_field('property_usage') ? get_field('property_usage') : '-'; ?></td>
											<th>都市計画</th>
											<td><?php echo get_field('property_city') ? get_field('property_city') : '-'; ?></td>
										</tr>
										<tr>
											<th>傾斜地部分面積</th>
											<td><?php echo get_field('property_slopearea') ? get_field('property_slopearea') : '-'; ?></td>
											<th>路地状敷地</th>
											<td><?php echo get_field('property_alley') ? get_field('property_alley') : '-'; ?></td>	
										</tr>
										<tr>
											<th>取引態様</th>
											<td><?php echo get_field('property_transaction') ? get_field('property_transaction') : '-'; ?></td>
											<th>国土法届出要否</th>
											<td><?php echo get_field('property_landact') ? get_field('property_landact') : '-'; ?></td>
										</tr>
										<tr>
											<th>引渡時期</th>
											<td><?php echo get_field('property_delivery') ? get_field('property_delivery') : '-'; ?></td>
											<th>引渡条件</th>
											<td><?php echo get_field('property_deliverycondition') ? get_field('property_deliverycondition') : '-'; ?></td>
										</tr>
										<tr>
											<th>法令上の制限</th>
											<td><?php echo get_field('property_legal') ? get_field('property_legal') : '-'; ?></td>
											<th>販売区画数 / 総区画数</th>
											<td><?php echo get_field('property_salepart') ? get_field('property_salepart') . '/' . get_field('property_totalparcel') : '-'; ?></td>
										</tr>										
										<tr>
											<th>設備条件</th>
											<td colspan="3">
												<?php 
													$property_condition_str = get_field('property_equipment');
													$property_condition_arr = explode(',', $property_condition_str);
												?>
												<?php if( !empty( $property_condition_arr ) ) : ?>
												<ul class="bknDetailWrapper__facilities--name">
													<?php foreach ($property_condition_arr as $condition) : ?>
														<li><?php echo $condition; ?></li>
													<?php endforeach; ?>
												</ul>
												<?php endif; ?>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						<?php endif; ?>
					</div>
					<script type="text/javascript" src="<?php echo T_DIRE_URI; ?>/assets/js/bkn/lozad.min.js"></script>

					<?php if( get_field('google_map') ) : ?>
					<div id="bknAddress-map" class="section_wrap">
						<h2 class="bknCont__contTtl ui-tx-sub">地図</h2>
						<div class="bkn-sectionInner">
							<div>
								<iframe width="1080" height="370" style="border:none;" src="<?php echo esc_url( get_field('google_map') ); ?>"></iframe>
							</div>
							<p class="bknCont__note">※地図上に表示される物件の位置は付近住所に所在することを表すものであり、実際の物件所在地とは異なる場合がございます。</p>
						</div>
					</div>
					<style type="text/css">
						/* Googleマップ */
						.bknCont__note {
							margin-top: 5px;
							color: #e10000;
						}
					</style>
					<?php endif; ?>

					<div class="bknDetail_conversion conversion_topBottomMargin">
						<div class="cont-otherContact">
							<div class="contInner">
								<p class="otherContact__catch">
									まずはご相談ください！
								</p>
								<ul class="otherContact__list">
									<li class="otherContact__item--satei">
										<a href="<?php echo HOME . 'bkncontact/'; ?>" class="ui-bg-point hoverDefault" target="_blank">
											<i class="far fa-envelope otherContact__icn--mail"></i>この物件にお問い合わせする
										</a>
									</li>
									<li class="otherContact__item--phone">
										<p class="otherContact__tel--bkn ui-bg-sub">
											<i class="fas fa-phone-alt otherContact__icn--tel"></i>077-565-0021 </p>
									</li>
								</ul>
								<div class="otherContact__about">
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
						<style>
							.otherContact__tel--bkn {
								height: 60px;
								line-height: 56px;
								font-size: 20px;
								font-weight: bold;
								background: none;
								border: 2px solid #ddd;
								box-sizing: border-box;
								text-align: center;
								display: block;
								border-radius: 3px;
							}
							
							.otherContact__tel--bkn i {
								margin-right: 15px;
							}
						</style>
					</div>

					<div class="section_wrap">
						<h2 class="bknCont__contTtl ui-tx-sub">取り扱い店舗(株式会社トラストレイト)</h2>
						<div class="bknDetailWrapper__company">
							<p class="bkn-company__image">
								<img src="<?php echo esc_attr( get_field('store_image') ); ?>" alt="<?php echo get_field('store_company'); ?>"></p>
							<div class="bkn-company__detail">
								<dl class="bkn-company__information">
									<dt class="company__information--item ui-tx-main">所在地</dt>
									<dd class="company__information--value address"><?php echo get_field('store_address') ? get_field('store_address') : '-'; ?></dd>
								</dl>
								<dl class="bkn-company__information">
									<dt class="company__information--item ui-tx-main">電話番号</dt>
									<dd class="company__information--value tel"><?php echo get_field('store_phone') ? get_field('store_phone') : '-'; ?></dd>
								</dl>
								<dl class="bkn-company__information">
									<dt class="company__information--item ui-tx-main">営業時間</dt>
									<dd class="company__information--value eigyoTime"><?php echo get_field('store_operatetime') ? get_field('store_operatetime') : '-'; ?></dd>
								</dl>
								<dl class="bkn-company__information">
									<dt class="company__information--item ui-tx-main">定休日</dt>
									<dd class="company__information--value holiday"><?php echo get_field('store_holiday') ? get_field('store_holiday') : '-'; ?></dd>
								</dl>
							</div>
						</div>
					</div>

					<div id="loanSimulation" class="bkn-section bkncalculate section_wrap">
            <h2 class="bknCont__contTtl ui-tx-sub">支払いシミュレーション<span>この物件を購入した場合の、月々の支払い価格の一例です。借り入れを保証するものではございません。</span></h2>
            <div id="simulation" class="bkn-sectionInner">
              <div class="calculation">
                <div class="clearfix">
                  <dl>
                    <dt>返済期間</dt>
                    <dd>
                      <input id="period" class="loan" type="text" />
                      <ul>
                        <li id="periodPlus" class="simulation__bt_mark"><i class="fas fa-plus-square"></i></li>
                        <li id="periodMinus" class="simulation__bt_mark"><i class="far fa-minus-square"></i></li>
                      </ul>
                    </dd>
                  </dl>
                  <dl>
                    <dt>金利</dt>
                    <dd>
                      <input id="rate" class="loan" type="text" />
                      <ul>
                        <li id="ratePlus" class="simulation__bt_mark"><i class="fas fa-plus-square"></i></li>
                        <li id="rateMinus" class="simulation__bt_mark"><i class="far fa-minus-square"></i></li>
                      </ul>
                    </dd>
                  </dl>
                  <dl>
                    <dt>ボーナス時の増額（1回分）</dt>
                    <dd>
                      <input id="bonus" class="loan" type="text" />
                      <ul>
                        <li id="bonusPlus" class="simulation__bt_mark"><i class="fas fa-plus-square"></i></li>
                        <li id="bonusMinus" class="simulation__bt_mark"><i class="far fa-minus-square"></i></li>
                      </ul>
                    </dd>
                  </dl>
                  <dl>
                    <dt>借入金額</dt>
                    <dd>
                      <input id="borrow" class="loan" type="text" />
                      <ul>
                        <li id="borrowPlus" class="simulation__bt_mark"><i class="fas fa-plus-square"></i></li>
                        <li id="borrowMinus" class="simulation__bt_mark"><i class="far fa-minus-square"></i></li>
                      </ul>
                    </dd>
                  </dl>
                  <dl class="calc_last">
                    <dt>頭金</dt>
                    <dd>
                      <input id="initial" class="loan" type="text" />
                      <ul>
                        <li id="initialPlus" class="simulation__bt_mark"><i class="fas fa-plus-square"></i></li>
                        <li id="initialMinus" class="simulation__bt_mark"><i class="far fa-minus-square"></i></li>
                      </ul>
                    </dd>
                  </dl>
                </div>
                <div class="loantext">
                  <p>※元利均等方式金利5.00％まで※返済年数5～50年まで入力できます</p>
                  <p>※ボーナスは年2回で計算しています。1000万円まで入力できます</p>
                </div>
                <input type="hidden" name="loanPeriod" value="" />
                <input type="hidden" name="loanRate" value="" />
                <input type="hidden" name="loanInitial" value="" />

                <dl id="answer" class="ui-bg-main">
                  <dt>毎月の返済額</dt>
                  <dd><input id="monthPay" type="text" disabled="disabled" /></dd>
                </dl>
              </div>
              <!--calculation-->
            </div>
            <!--simulation-->
          </div>

					<div class="bknDetail_conversion conversion_topMargin">
            <div class="cont-otherContact">
              <div class="contInner">
                <p class="otherContact__catch">
                  まずはご相談ください！
                </p>
                <ul class="otherContact__list">
                  <li class="otherContact__item--satei">
                    <a href="<?php echo HOME . 'bkncontact/'; ?>" class="ui-bg-point hoverDefault" target="_blank">
                      <i class="far fa-envelope otherContact__icn--mail"></i>この物件にお問い合わせする
                    </a>
                  </li>
                  <li class="otherContact__item--phone">
                    <p class="otherContact__tel--bkn ui-bg-sub">
                      <i class="fas fa-phone-alt otherContact__icn--tel"></i>077-565-0021 </p>
                  </li>
                </ul>
                <div class="otherContact__about">
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
            <style>
              .otherContact__tel--bkn {
                height: 60px;
                line-height: 56px;
                font-size: 20px;
                font-weight: bold;
                background: none;
                border: 2px solid #ddd;
                box-sizing: border-box;
                text-align: center;
                display: block;
                border-radius: 3px;
              }
              
              .otherContact__tel--bkn i {
                margin-right: 15px;
              }
            </style>
          </div>

				</div>

			</div>

		</div>

	</main>

	<script>
		$(function() {
			$(window).on('load', function(e) {
				var bknData = {
					property_title: "<?php the_title(); ?>",
					thumb_src: "<?php echo wp_get_attachment_image_url( get_post_thumbnail_id( get_the_ID() ), 'bknlist-thumbnail' ) ? wp_get_attachment_image_url( get_post_thumbnail_id( get_the_ID() ), 'bknlist-thumbnail' ) : catch_that_image(); ?>",
					property_price: "<?php echo number_format( get_field('property_price') ); ?>万円",
					property_floorplan: "<?php echo get_field('property_floorplan') ? get_field('property_floorplan') : '-'; ?>",
					property_buildingarea: "<?php echo get_field('property_buildingarea') ? get_field('property_buildingarea') : '-'; ?>",
					property_landarea: "<?php echo get_field('property_landarea') ? get_field('property_landarea') : '-'; ?>"
				};
				var bknObj = JSON.stringify(bknData)
				localStorage.setItem('bknData', bknObj);
			});	
		});
	</script>

	<?php
		endwhile;
	endif;
	?>

<?php get_footer();?>
