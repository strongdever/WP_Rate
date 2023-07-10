<?php
   if ( ! defined( 'ABSPATH' ) ) exit;
   get_header();
   
   $paged = get_query_var('paged') ? get_query_var('paged') : 1;
   
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
            <span itemprop="name">売り物件一覧</span>
         </li>
      </ul>
      <!-- contentsStart -->
      <?php
        $args = [
            'post_type' => 'bknlist',
            'post_status' => 'publish',
            'paged' => $paged,
            'posts_per_page' => 20,
            'orderby' => 'post_date',
            'order' => 'DESC'
        ];
        $custom_query = new WP_Query( $args );
        ?>
      <div id="contents" class="clearfix">
         <div class="pageHead">
            <h1 class="pageHead__ttl ui-bd-main">売り物件一覧</h1>
         </div>
         <div class="bknWrapper">
            <?php custom_pagination($custom_query->max_num_pages, $paged, $custom_query->found_posts); ?>

            <?php 
                if( $custom_query->have_posts() ) :
                    while ( $custom_query->have_posts() ) : $custom_query->the_post();
                        $current_cat = get_the_category() ? get_the_category()[0] : [];
            ?>
            <div class="bknDataWrapper">
               <div class="bknInformation">
                  <!--画像-->
                  <p class="bknInformation__image">
                     <a href="<?php the_permalink(); ?>" target="_blank">
                        <?php if( has_post_thumbnail() ): ?>
                            <?php the_post_thumbnail("bknlist-thumbnail"); ?>
                        <?php else: ?>
                            <img src="<?php echo catch_that_image(); ?>" alt="<?php the_title(); ?>">
                        <?php endif; ?>
                     </a>
                  </p>
                  <!--物件概要-->
                  <div class="bknInformation__wrapper">
                     <div class="bknInformation__importantInfo">
                        <p class="bknName">
                           <a href="<?php the_permalink(); ?>" target="_blank"><?php the_title(); ?></a>
                        </p>
                     </div>
                     <div class="bknInformation__part1">
                        <dl class="bknInformation__list bknInformation__address">
                           <dt class="bknInformation__term">住所</dt>
                           <dd class="bknInformation__desc"><?php echo get_field( 'property_location' ) ? get_field( 'property_location' ) : '-'; ?></dd>
                        </dl>
                        <dl class="bknInformation__list">
                           <dt class="bknInformation__term">交通</dt>
                           <dd class="bknInformation__desc"><?php echo get_field( 'property_traffic' ) ? get_field( 'property_traffic' ) : '-'; ?>
                           </dd>
                        </dl>
                        <div>
                           <dl class="bknInformation__list bknInformation__shortItem">
                            <?php
                                $building_date_arr = explode('(', get_field('property_updatedate'));
                                $building_date = trim($building_date_arr[0]);
                                ?>
                              <dt class="bknInformation__term">築年</dt>
                              <dd class="bknInformation__desc"><?php echo $building_date ? $building_date : '-'; ?></dd>
                              <?php 
                                $building_structure_arr = explode('/', get_field('property_structure'));
                                $building_floor = trim($building_structure_arr[0]);
                                $building_struct = trim($building_structure_arr[1]);
                                ?>
                              <dt class="bknInformation__term">階数</dt>
                              <dd class="bknInformation__desc"><?php echo $building_floor ? $building_floor : '-'; ?></dd>
                              <dt class="bknInformation__term">構造</dt>
                              <dd class="bknInformation__desc"><?php echo $building_struct ? $building_struct : '-'; ?></dd>
                           </dl>
                        </div>
                     </div>
                     <div class="bknInformation__part2">
                        <table>
                        <?php if( $current_cat->cat_name == "中古一戸建" ) : ?>
										
                            <tbody>
                                <tr>
                                    <th>価格</th>
									<th>利回り</th>
                                    <th>間取り</th>
                                    <th>建物面積</th>
                                    <th>土地面積</th>
                                </tr>
                                <tr>
                                    <td class="bknInformation__price"><span class="basicInfo__price"><?php echo number_format( get_field('property_price') ); ?>万円</span> </td>
                                    <td><?php echo get_field('property_profit') ? get_field('property_profit') : '-'; ?></td>
                                    <td><?php echo get_field('property_floorplan') ? get_field('property_floorplan') : '-'; ?></td>
                                    <td><?php echo get_field('property_buildingarea') ? get_field('property_buildingarea') : '-'; ?></td>
                                    <td><?php echo get_field('property_landarea') ? get_field('property_landarea') : '-'; ?></td>
                                </tr>
                            </tbody>


                            <?php elseif( $current_cat->cat_name == "中古マンション" ) : ?>
                                <tbody>
                                <tr>
                                    <th>価格</th>
									<th>所在地</th>
                                    <th>間取り</th>
                                    <th>専有面積</th>
                                </tr>
                                <tr>
                                    <td class="bknInformation__price"><span class="basicInfo__price"><?php echo number_format( get_field('property_price') ); ?>万円</span> </td>
                                    <td><?php echo get_field('property_location') ? get_field('property_location') : '-'; ?></td>
                                    <td><?php echo get_field('property_floorplan') ? get_field('property_floorplan') : '-'; ?></td>
                                    <td><?php echo get_field('property_exclusivearea') ? get_field('property_exclusivearea') : '-'; ?></td>
                                </tr>
                            </tbody>


                            <?php elseif( $current_cat->cat_name == "マンション" ) : ?>
                                <tbody>
                                <tr>
                                    <th style="width: 17vw;">価格</th>
									<th style="width: 10vw">利回り</th>
                                    <th>面積</th>													
                                </tr>
                                <tr>
                                    <td class="bknInformation__price"><span class="basicInfo__price"><?php echo number_format( get_field('property_price') ); ?>万円</span> </td>
                                    <td><?php echo get_field('property_floorplan') ? get_field('property_floorplan') : '-'; ?></td>
                                    <td><?php echo get_field('property_buildingarea') ? get_field('property_buildingarea') : '-'; ?></td>
                                </tr>
                            </tbody>


                            <?php elseif( $current_cat->cat_name == "売地" ) : ?>
                                <tbody>
                                <tr>
                                    <th>価格</th>
									<th>利回り</th>
                                    <th>土地面積</th>
                                    <th>坪数</th>
                                    <th>販売区画</th>
                                    <th>総区画</th>
                                </tr>
                                <tr>
                                    <td class="bknInformation__price"><span class="basicInfo__price"><?php echo number_format( get_field('property_price') ); ?>万円</span> </td>
                                    <td><?php echo get_field('property_floorplan') ? get_field('property_floorplan') : '-'; ?></td>
                                    <td><?php echo get_field('property_landarea') ? get_field('property_landarea') : '-'; ?></td>
                                    <td><?php echo get_field('property_tsubo') ? get_field('property_tsubo') : '-'; ?></td>
                                    <td><?php echo get_field('property_salepart') ? get_field('property_salepart') : '-'; ?></td>
                                    <td><?php echo get_field('property_totalparcel') ? get_field('property_totalparcel') : '-'; ?></td>
                                </tr>
                            </tbody>
                        <?php endif; ?>
                        </table>
                     </div>
                     <div class="bknDataWrapper__moreBt">
                        <a href="<?php the_permalink(); ?>" class="ui-bg-main" target="_blank">詳細を見る</a>
                     </div>
                  </div>
               </div>
            </div>
            <?php endwhile; ?>
            <?php wp_reset_postdata(); ?>
			<?php endif; ?>
         </div>
         <?php custom_pagination($custom_query->max_num_pages, $paged, $custom_query->found_posts); ?>
         <div class="bknLIst__conversion conversion_topMargin">
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
      </div>
      <!-- contentsEnd -->
   </div>
</main>
<?php get_footer(); ?>