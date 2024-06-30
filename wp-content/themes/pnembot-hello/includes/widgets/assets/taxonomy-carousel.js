/// <reference types="jquery" />
console.log("console.log(this);");
jQuery(($) => {
  console.log(elementor, taxonomy_carousel_ajax);
  elementor.hook.addAction("panel/open_editor/widget", (panel, model, view) => {
    console.log(panel, model, view);
    // get the post-type
    $('[data-setting="post-type"]').change(function () {
      console.log(this);
      $('[data-setting="taxonomy"]').empty();
      const post_type = $(this).val() || [];

      const data = {
        action: "taxonomy_carousel_ajax",
        postTypeNonce: taxonomy_carousel_ajax.postTypeNonce,
        post_type,
      };
      

      $.post(taxonomy_carousel_ajax.ajaxurl, data, (response) => {
        const taxonomies = JSON.parse(response);
        $.each(taxonomies, function () {
          if (this.name === "post_format") return;
          $('[data-setting="taxonomy"]').append(
            `<option value="${this.name}">${this.label}</option>`
          );
        });
        $('[data-setting="taxonomy"]')[0].selectedIndex = -1;
      });
    });
  });
});
