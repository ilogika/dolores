<?php
require_once(DOLORES_PATH . '/dlib/assets.php');

$logo_src = DoloresAssets::get_image_uri('cam/logo-hero.png');

get_header();

if (!$paged || $paged == 1) {
  ?>
  <section class="site-presentation explanation">
    <div clsas="wrap explanation-wrap">
      <!-- TODO -->
    </div>
  </section>

  <section class="site-hero">
    <div class="hero-logo-container">
      <a href="<?php echo site_url(); ?>" title="Página inicial">
        <img class="hero-logo-image" src="<?php echo $logo_src; ?>" />
      </a>
    </div>
    <button class="hero-button toggle-explanation">
      <span>Entenda</span>
    </button>

    <div class="home-calendar">
      <div class="wrap">
        <h2 class="home-next-event">
          Próximo <span>evento</span>
        </h2><h3 class="home-event-title">
          Cine-debate com Samir de Oliveira sobre jornalismo socialista revolucionário
        </h3><div class="home-event-mobile-table"><ul class="home-event-info">
          <li class="home-event-info-li home-event-info-50">
            <i class="fa fa-fw fa-lg fa-calendar"></i>23/02
          </li><li class="home-event-info-li home-event-info-50">
            <i class="fa fa-fw fa-lg fa-clock-o"></i>14h
          </li><li class="home-event-info-li">
            <a class="home-event-location" href="#">
              <div class="home-event-icon-container">
                <i class="fa fa-fw fa-lg fa-map-marker"></i>
              </div>
              <div class="home-event-location-text">
                Sede do PSOL
                <br />
                <small>(ver no mapa)</small>
              </div>
            </a>
          </li>
        </ul><div class="home-calendar-button-container">
          <a class="home-calendar-button" href="#" title="Agenda completa">
            Agenda completa
          </a>
        </div></div>
      </div>
    </div>
  </section>

  <?php
  if (DoloresStreaming::get_active()) {
    $title = esc_html(DoloresStreaming::get_title());
    $youtube_id = DoloresStreaming::get_youtube_id();
    $params = "rel=0&amp;showinfo=0&amp;autoplay=1";
    $url = "//youtube.com/embed/${youtube_id}?${params}";
    ?>
    <section class="site-streaming">
      <div class="page wrap">
        <h2 class="streaming-title"><?php echo $title; ?></h2>
        <iframe
          class="streaming-box"
          src="<?php echo $url; ?>"
          frameborder="0"
          allowfullscreen>
        </iframe>
      </div>
    </section>
    <?php
  }
  ?>

  <section class="home-temas">
    <div class="wrap home-temas-wrap">
      <div class="home-temas-element">
        <h2 class="home-temas-title">Entre no debate</h2>

        <ul class="home-temas-grid">
          <?php
          $taxonomy = 'tema';
          add_filter('get_terms_orderby', 'dolores_random_orderby');
          $terms = get_terms($taxonomy, array(
            'hide_empty' => false,
            'number' => 4,
            'parent' => 0
          ));
          remove_filter('get_terms_orderby', 'dolores_random_orderby');
          foreach ($terms as $term) {
            $image = get_term_meta($term->term_id, 'image', true);
            if ($image) {
              $style = ' style="background-image: url(\'' . $image . '\');"';
            } else {
              $style = '';
            }
            $href = get_term_link($term, $taxonomy);
            ?>
            <li<?php echo $style; ?>>
              <a href="<?php echo $href; ?>" class="temas-item">
                <span class="temas-text-container">
                  <span class="tema"><?php echo $term->name; ?></span>
                </span>
              </a>
            </li>
            <?php
          }
          ?>
        </ul>

        <div class="home-temas-button-container">
          <a class="home-temas-button" href="/temas/">
            Veja todos os temas
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- TODO -->

  <section class="home-banners">
    <div class="wrap">
      <a class="home-banner home-voluntario" href="#"
          title="Seja um voluntário">
        <span>Seja um voluntário</span>
      </a>
      <a class="home-banner home-contribuicoes" href="#"
          title="Contribuições para o debate">
        <span>Contribuições para o debate</span>
      </a>
    </div>
  </section>

  <hr class="home-sep" />

  <?php dolores_grid(); ?>

  <?php
}
?>

<?php get_footer(); ?>
