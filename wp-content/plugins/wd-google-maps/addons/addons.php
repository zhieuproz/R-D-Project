<?php
function gmwd_addons_display() {
  $addons = array(
    'marker-clusters'   => array(
      'name'        => __('GMWD Marker Clustering', 'gmwd'),
      'url'         => 'https://web-dorado.com/products/wordpress-google-maps-plugin/add-ons/marker-clustering.html',
      'description' => __('GMWD Marker Clustering is designed for grouping close markers for more user-friendly display over the map.', 'gmwd'),
      'icon'        => '',
      'image'       => GMWD_URL . '/addons/images/marker_clusters.png',
    ),  
  
  );
  ?>
  <div class="wrap">
    <div id="settings">
      <div id="settings-content" >
        <h2 id="add_on_title"><?php _e('Google Maps WD Add-ons', 'gmwd'); ?></h2>
        <?php
        if ($addons) {
          foreach ($addons as $name => $addon) {
            ?>
            <div class="add-on">
              <h2><?php echo $addon['name']; ?></h2>
              <figure class="figure">
                <div  class="figure-img">
                  <a href="<?php echo $addon['url']; ?>" target="_blank">
                    <?php
                    if ($addon['image']) {
                      ?>
                      <img src="<?php echo $addon['image']; ?>" />
                      <?php
                    }
                    ?>
                  </a>
                </div>
                <figcaption class="addon-descr figcaption">
                  <?php
                  if ($addon['icon']) {
                    ?>
                    <img src="<?php echo $addon['icon']; ?>" />
                    <?php
                  }
                  ?>
                  <?php echo $addon['description']; ?>
                </figcaption>
              </figure>
              <?php
              if ($addon['url'] !== '#') {
                ?>
              <a href="<?php echo $addon['url']; ?>" target="_blank" class="addon"><span><?php _e('GET THIS ADD ON', 'gmwd'); ?></span></a>
                <?php
              }
              else {
                ?>
              <div class="ecwd_coming_soon">
                <img src="<?php echo WD_gmwd_URL . '/addons/images/coming_soon.png'; ?>" />
              </div>
                <?php
              }
              ?>
            </div>
            <?php
          }
        }
        ?>
      </div>
    </div>
  </div>
  <?php
}