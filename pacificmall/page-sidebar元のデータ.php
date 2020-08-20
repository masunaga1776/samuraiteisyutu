

<?php
/*
Template Name: サイドバーあり
*/
get_header(); ?>



              <div class="page-inner two-column">
                <div class="page-main" id="pg-company">
                  <div class="content">
                    <div class="content-main">
                      <article class="article-body">
                        <div class="article-inner">
                          
                          
                          
                          <?php
                          if(have_posts()):
                          while(have_posts() ): the_post();
                          the_content();
                          endwhile;
                          endif;
                          ?>
                          
                          
                          
                          <p>ちびっこたちは、いつも以上に練習を楽しみました！</p>
                          <p>2018年8月大手町モールにて「街のちびっこダンス大会」を開催しました。近年はダンス教室に通うお子様も多く、お子様同士や親御様同士の交流の場となればと思い企画いたしました。ご来場のみなさまは、お楽しみいただけましたでしょうか？ 心配していた雨に見舞われることもなく、大会の目玉、東京の真ん中で開催された大花火大会が大盛況となりました。</p>
                          <p>この場をお借りしてお礼申し上げます。</p>
                          <ul class="wp-block-gallery columns-2 is-cropped">
                            <li class="blocks-gallery-item">
                              <figure>
                                <img src="#" alt="" />
                              </figure>
                            </li>
                            <li class="blocks-gallery-item">
                              <figure>
                                <img src="#" alt="" />
                              </figure>
                            </li>
                          </ul>
                        </div>
                      </article>
                    </div>
                    <div class="content-side">
                      <div class="side-box">
                       
                       <?php dynamic_sidebar('primary-widget-area'); ?>
                       
                      </div>
                    </div>
                  </div>
                </div>
              </div>
          <?php get_footer(); ?>
          
          