<div class="<?php echo $style; ?>  wow bounce" data-wow-duration="1's" style="visibility: visible; animation-name: bounce;">
  <div class="pricing-table">
    <div class="plan featured" style="background: <?php echo $price_bg; ?>; border: 2px solid <?php echo $top_bg; ?>; transform: scale(1.0<?php echo $zoom; ?>);">
      <div class="header" style="background-color: <?php echo $top_bg ?>">
        <h4 class="plan-title" style="color: <?php echo $title_clr; ?>; font-size: <?php echo $titlesize; ?>px;">
          <?php echo $price_title; ?>
        </h4>
        <div class="plan-cost"><span class="plan-price" style="color: <?php echo $amount_clr; ?>;font-size: <?php echo $amountsize; ?>px;"><?php echo $price_currency; ?><?php echo $price_amount; ?></span><span class="plan-type" style="color: <?php echo $amount_clr; ?>;font-size: <?php echo $planesize; ?>px;"><?php echo $price_plan; ?></span></div>
        <span class="price-title5-span" style="border-color: <?php echo $top_bg ?> transparent transparent transparent;"></span>
      </div>
      <div class="price-content">
        <?php echo $content; ?>
      </div>
      <div class="plan-select">
        <a href="<?php echo esc_url($btn_url['url']); ?>" target="<?php echo $btn_url['target']; ?>" title="<?php echo esc_html($btn_url['title']); ?>" style="font-size: <?php echo $btnsize; ?>px; background: <?php echo $top_bg; ?>;"><?php echo $btn_text; ?></a>
      </div>
    </div>
  </div>
</div>