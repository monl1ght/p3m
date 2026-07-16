/**
* Public Website Script - P3M Polibang
*/

(function() {
  "use strict";

  const body = document.querySelector("body");
  const header = document.querySelector("#header");
  const mobileNavToggleBtn = document.querySelector(".mobile-nav-toggle");
  const scrollTop = document.querySelector(".scroll-top");

  function toggleScrolled() {
    if (!body || !header) return;

    window.scrollY > 60
      ? body.classList.add("scrolled")
      : body.classList.remove("scrolled");
  }

  document.addEventListener("scroll", toggleScrolled);
  window.addEventListener("load", toggleScrolled);

  function mobileNavToggle() {
    if (!body || !mobileNavToggleBtn) return;

    body.classList.toggle("mobile-nav-active");

    const icon = mobileNavToggleBtn.querySelector("i");
    if (icon) {
      icon.classList.toggle("bi-list");
      icon.classList.toggle("bi-x");
    }
  }

  if (mobileNavToggleBtn) {
    mobileNavToggleBtn.addEventListener("click", mobileNavToggle);
  }

  document.querySelectorAll("#navmenu a").forEach(function(navmenuLink) {
    navmenuLink.addEventListener("click", function() {
      const isDropdownToggle = navmenuLink.querySelector(".toggle-dropdown");

      if (body && body.classList.contains("mobile-nav-active") && !isDropdownToggle) {
        mobileNavToggle();
      }
    });
  });

  document.querySelectorAll(".navmenu .toggle-dropdown").forEach(function(dropdownToggle) {
    dropdownToggle.addEventListener("click", function(e) {
      if (window.innerWidth >= 1200) return;

      e.preventDefault();
      e.stopImmediatePropagation();

      const parentLink = this.parentNode;
      const dropdownMenu = parentLink ? parentLink.nextElementSibling : null;

      if (parentLink) {
        parentLink.classList.toggle("active");
      }

      if (dropdownMenu) {
        dropdownMenu.classList.toggle("dropdown-active");
      }
    });
  });

  document.addEventListener("click", function(e) {
    if (!body || !body.classList.contains("mobile-nav-active")) return;

    const nav = document.querySelector("#navmenu");
    const clickedInsideNav = nav && nav.contains(e.target);
    const clickedToggle = mobileNavToggleBtn && mobileNavToggleBtn.contains(e.target);

    if (!clickedInsideNav && !clickedToggle) {
      mobileNavToggle();
    }
  });

  const preloader = document.querySelector("#preloader");
  if (preloader) {
    window.addEventListener("load", function() {
      preloader.remove();
    });
  }

  function toggleScrollTop() {
    if (!scrollTop) return;

    window.scrollY > 100
      ? scrollTop.classList.add("active")
      : scrollTop.classList.remove("active");
  }

  if (scrollTop) {
    scrollTop.addEventListener("click", function(e) {
      e.preventDefault();
      window.scrollTo({
        top: 0,
        behavior: "smooth"
      });
    });

    window.addEventListener("load", toggleScrollTop);
    document.addEventListener("scroll", toggleScrollTop);
  }

  function aosInit() {
    if (typeof AOS === "undefined") return;

    AOS.init({
      duration: 650,
      easing: "ease-in-out",
      once: true,
      mirror: false
    });
  }

  window.addEventListener("load", aosInit);

  if (typeof GLightbox !== "undefined") {
    GLightbox({
      selector: ".glightbox"
    });
  }

  function initSwiper() {
    if (typeof Swiper === "undefined") return;

    document.querySelectorAll(".init-swiper").forEach(function(swiperElement) {
      const configElement = swiperElement.querySelector(".swiper-config");
      if (!configElement) return;

      let config = {};

      try {
        config = JSON.parse(configElement.innerHTML.trim());
      } catch (error) {
        console.error("Swiper config tidak valid:", error);
        return;
      }

      new Swiper(swiperElement, config);
    });
  }

  window.addEventListener("load", initSwiper);

  document.querySelectorAll(".faq-item h3, .faq-item .faq-toggle").forEach(function(faqItem) {
    faqItem.addEventListener("click", function() {
      if (faqItem.parentNode) {
        faqItem.parentNode.classList.toggle("faq-active");
      }
    });
  });

  document.querySelectorAll(".skills-animation").forEach(function(item) {
    if (typeof Waypoint === "undefined") return;

    new Waypoint({
      element: item,
      offset: "80%",
      handler: function() {
        item.querySelectorAll(".progress .progress-bar").forEach(function(el) {
          el.style.width = el.getAttribute("aria-valuenow") + "%";
        });
      }
    });
  });

  document.querySelectorAll(".isotope-layout").forEach(function(isotopeItem) {
    if (typeof imagesLoaded === "undefined" || typeof Isotope === "undefined") return;

    const layout = isotopeItem.getAttribute("data-layout") || "masonry";
    const filter = isotopeItem.getAttribute("data-default-filter") || "*";
    const sort = isotopeItem.getAttribute("data-sort") || "original-order";
    const container = isotopeItem.querySelector(".isotope-container");

    if (!container) return;

    let initIsotope;

    imagesLoaded(container, function() {
      initIsotope = new Isotope(container, {
        itemSelector: ".isotope-item",
        layoutMode: layout,
        filter: filter,
        sortBy: sort
      });
    });

    isotopeItem.querySelectorAll(".isotope-filters li").forEach(function(filterButton) {
      filterButton.addEventListener("click", function() {
        const active = isotopeItem.querySelector(".isotope-filters .filter-active");

        if (active) {
          active.classList.remove("filter-active");
        }

        this.classList.add("filter-active");

        if (initIsotope) {
          initIsotope.arrange({
            filter: this.getAttribute("data-filter")
          });
        }

        aosInit();
      });
    });
  });

  window.addEventListener("load", function() {
    if (!window.location.hash) return;

    const section = document.querySelector(window.location.hash);
    if (!section) return;

    setTimeout(function() {
      const scrollMarginTop = getComputedStyle(section).scrollMarginTop;
      window.scrollTo({
        top: section.offsetTop - parseInt(scrollMarginTop || 0),
        behavior: "smooth"
      });
    }, 100);
  });

  const navmenuLinks = document.querySelectorAll(".navmenu a");

  function navmenuScrollspy() {
    navmenuLinks.forEach(function(navmenuLink) {
      if (!navmenuLink.hash) return;

      const section = document.querySelector(navmenuLink.hash);
      if (!section) return;

      const position = window.scrollY + 200;

      if (position >= section.offsetTop && position <= section.offsetTop + section.offsetHeight) {
        document.querySelectorAll(".navmenu a.active").forEach(function(link) {
          link.classList.remove("active");
        });

        navmenuLink.classList.add("active");
      } else {
        navmenuLink.classList.remove("active");
      }
    });
  }

  window.addEventListener("load", navmenuScrollspy);
  document.addEventListener("scroll", navmenuScrollspy);
})();
