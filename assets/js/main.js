(function () {
  "use strict";

  document.addEventListener("DOMContentLoaded", function () {
    var autoForms = document.querySelectorAll("[data-auto-submit]");
    autoForms.forEach(function (form) {
      form.querySelectorAll("select").forEach(function (select) {
        select.addEventListener("change", function () {
          form.submit();
        });
      });
    });
  });
})();
