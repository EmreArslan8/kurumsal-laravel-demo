(function () {
  var body = document.body;
  var header = document.querySelector("[data-site-header]");
  var navToggle = document.querySelector("[data-nav-toggle]");
  var nav = document.querySelector("[data-primary-nav]");
  var languageButtons = document.querySelectorAll("[data-language]");
  var forms = document.querySelectorAll("[data-contact-form]");
  var yearTargets = document.querySelectorAll("[data-year]");
  var toastTimer;

  function setHeaderState() {
    if (!header) {
      return;
    }

    header.classList.toggle("is-scrolled", window.scrollY > 8);
  }

  function closeNav() {
    if (!navToggle) {
      return;
    }

    body.classList.remove("nav-open");
    navToggle.setAttribute("aria-expanded", "false");
  }

  function toggleNav() {
    var isOpen = body.classList.toggle("nav-open");
    navToggle.setAttribute("aria-expanded", String(isOpen));
  }

  function showToast(message) {
    var toast = document.querySelector("[data-toast]");

    if (!toast) {
      toast = document.createElement("div");
      toast.className = "toast";
      toast.setAttribute("data-toast", "");
      toast.setAttribute("role", "status");
      toast.setAttribute("aria-live", "polite");
      document.body.appendChild(toast);
    }

    toast.textContent = message;
    toast.classList.add("is-visible");
    window.clearTimeout(toastTimer);
    toastTimer = window.setTimeout(function () {
      toast.classList.remove("is-visible");
    }, 2600);
  }

  function setLanguage(language) {
    languageButtons.forEach(function (button) {
      var isActive = button.getAttribute("data-language") === language;
      button.classList.toggle("is-active", isActive);
      button.setAttribute("aria-pressed", String(isActive));
    });

    document.documentElement.setAttribute("data-selected-language", language);

    if (language === "en") {
      showToast("English visual state selected. Text can be wired to CMS translations.");
      return;
    }

    showToast("Turkce gorsel durum secildi. Metinler CMS cevirilerine baglanabilir.");
  }

  function markInvalid(field, isInvalid) {
    field.classList.toggle("is-invalid", isInvalid);
    field.setAttribute("aria-invalid", String(isInvalid));
  }

  function validateForm(form) {
    var fields = form.querySelectorAll("input[required], select[required], textarea[required]");
    var firstInvalid = null;

    fields.forEach(function (field) {
      var valid = field.type === "checkbox" ? field.checked : field.value.trim().length > 0;

      if (field.type === "email" && field.value.trim().length > 0) {
        valid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(field.value.trim());
      }

      markInvalid(field, !valid);

      if (!valid && !firstInvalid) {
        firstInvalid = field;
      }
    });

    return firstInvalid;
  }

  function bindForm(form) {
    var status = form.querySelector("[data-form-status]");

    form.addEventListener("submit", function (event) {
      event.preventDefault();

      var firstInvalid = validateForm(form);

      if (firstInvalid) {
        if (status) {
          status.textContent = "Lutfen zorunlu alanlari kontrol edin.";
        }
        firstInvalid.focus();
        return;
      }

      if (status) {
        status.textContent = "Tesekkurler. Demo form basariyla calisti.";
      }

      form.reset();
      form.querySelectorAll(".is-invalid").forEach(function (field) {
        markInvalid(field, false);
      });
    });

    form.addEventListener("input", function (event) {
      if (event.target.matches("input, select, textarea")) {
        markInvalid(event.target, false);
      }
    });
  }

  yearTargets.forEach(function (target) {
    target.textContent = String(new Date().getFullYear());
  });

  setHeaderState();
  window.addEventListener("scroll", setHeaderState, { passive: true });

  if (navToggle && nav) {
    navToggle.addEventListener("click", toggleNav);
    nav.addEventListener("click", function (event) {
      if (event.target.matches("a")) {
        closeNav();
      }
    });
  }

  languageButtons.forEach(function (button) {
    button.addEventListener("click", function () {
      setLanguage(button.getAttribute("data-language"));
    });
  });

  forms.forEach(bindForm);
})();
