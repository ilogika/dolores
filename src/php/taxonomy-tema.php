<?php
// TODO: use get_term_meta($term->term_id, 'image') as OpenGraph image
get_header();
$term = get_queried_object();

$video = get_term_meta($term->term_id, 'video', true);
$more = get_term_meta($term->term_id, 'more', true);

$vparams = "rel=0&amp;controls=0&amp;showinfo=0";
?>

<main class="tema">
  <div class="wrap">
    <?php if ($video) { ?>
    <div class="tema-video">
      <iframe
        allowfullscreen
        frameborder="0"
        height="480"
        src="https://youtube.com/embed/<?php echo $video . "?" . $vparams; ?>"
        width="640"
        >
      </iframe>
    </div>
    <?php } ?>

    <div class="tema-info">
      <h2 class="tema-name">
        <?php
        if ($term->parent != 0) {
          echo "#";
        }
        single_cat_title();
        ?>
      </h2>
      <p><?php echo category_description(); ?></p>
      <?php if ($more) { ?>
        <a class="tema-link-more" href="<?php echo $more; ?>">
          Ver diagnóstico
        </a>
      <?php } ?>
    </div>
  </div>
</main>

<?php
if ($term->parent == 0) {
  ?>
  <section class="tema-form bg-pattern-orange">
    <div class="wrap tema-form">
      <div class="tema-form-explanation">
        <h2 class="tema-form-title">
          Se a<br />cidade<br />fosse<br />nossa?
        </h2>
        <p class="tema-form-description">
          Você tem alguma ideia para o tema
          <strong><?php single_cat_title(); ?></strong>?
        </p>
        <p class="tema-form-description">
          Compartilhe usando o formulário!
        </p>
      </div>

      <form class="tema-form-form">
        <p class="tema-form-item">
          <label class="tema-form-label" for="tema-form-title">
            Título
          </label>
          <input
              type="text"
              class="tema-form-input"
              id="tema-form-title"
              maxlength="100"
              placeholder="Título (max. 100 caracteres)"
              />
        </p>
        <p class="tema-form-item">
          <label class="tema-form-label" for="tema-form-content">
            Escreva sua ideia
          </label>
          <textarea
              class="tema-form-textarea"
              id="tema-form-content"
              maxlength="600"
              placeholder="Ideia (max. 600 caracteres)"
              ></textarea>
        </p>
        <p class="tema-form-item">
          <label class="tema-form-label" for="tema-form-tags">
            Tags
          </label>
          <input
              type="text"
              class="tema-form-input"
              id="tema-form-tags"
              placeholder="Escolha algumas palavras-chave"
              />
        </p>
        <p class="tema-form-item" style="margin-top: 5px; text-align: right;">
          <button class="tema-form-button" onclick="alert('Em construção.')">
            Enviar
          </button>
        </p>
      </form>
    </div>
  </section>
  <?php
}
?>

<?php
include(__DIR__ . '/grid-ideias.php');
?>

<?php
get_footer();
?>
