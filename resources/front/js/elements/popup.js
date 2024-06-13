document.addEventListener("DOMContentLoaded", function () {
  // popup окна

  window.openPopup = function (popupClass, popupData = null) {
    let popup = document.querySelector(popupClass);
    if (!popup) return;

    document
      .querySelectorAll(".popup-boxes > .active")
      .forEach((el) => el.classList.remove("active"));
    popup.classList.add("active");

    document.documentElement.classList.add("noscroll");

    setScrollbarWidth();

    const event = new CustomEvent("popupOpened", {
      detail: {
        popupClass: popupClass,
        popupData: popupData,
        popup: popup,
      },
    });
    document.dispatchEvent(event);

    window.popupClass = popupClass;

    history.pushState({ popup: popupClass }, "");
  };

  window.closePopups = function () {
    document
      .querySelectorAll(".popup-boxes > .active")
      .forEach((el) => el.classList.remove("active"));

    document.documentElement.classList.remove("noscroll");

    window.popupClass = null;

    const event = new CustomEvent("popupClosed", {});
    document.dispatchEvent(event);
  };

  document.querySelectorAll("[data-popup]").forEach((el) => {
    el.addEventListener("click", (e) => {
      e.preventDefault();
      openPopup(el.dataset.popup, el.dataset.popupData);
    });
  });
  document.querySelectorAll(".close-popup").forEach((el) => {
    el.addEventListener("click", (e) => {
      e.preventDefault();
      closePopups();
    });
  });
  document.querySelectorAll(".popup").forEach((el) => {
    el.addEventListener("click", (e) => {
      if (e.target.classList.contains("popup")) closePopups();
    });
  });

  document.onkeydown = function (evt) {
    evt = evt || window.event;
    var isEscape = false;
    if ("key" in evt) {
      isEscape = evt.key === "Escape" || evt.key === "Esc";
    } else {
      isEscape = evt.keyCode === 27;
    }
    if (isEscape) {
      closePopups();
    }
  };

  window.addEventListener("popstate", () => {
    closePopups();
    history.pushState({ popup: false }, "");
  });

  document.onkeydown = function (evt) {
    evt = evt || window.event;
    var isEscape = false;
    if ("key" in evt) {
      isEscape = evt.key === "Escape" || evt.key === "Esc";
    } else {
      isEscape = evt.keyCode === 27;
    }
    if (isEscape) {
      closePopups();
    }
  };
});
