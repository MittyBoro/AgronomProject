const formatPrice = function (price) {
  if (price) {
    price = Math.round(price);
    return new Intl.NumberFormat("ru-RU").format(price);
  } else return "";
};
const sklonenie = function (number, txt, cases = [2, 0, 1, 1, 1, 2]) {
  return txt[
    number % 100 > 4 && number % 100 < 20
      ? 2
      : cases[number % 10 < 5 ? number % 10 : 5]
  ];
};

const setScrollbarWidth = function (
  propertyName = "--scrollbar-width",
  className = null
) {
  // Creating invisible container
  const outer = document.createElement("div");
  if (className) outer.classList.add(className);
  outer.style.visibility = "hidden";
  outer.style.overflow = "scroll"; // forcing scrollbar to appear
  outer.style.msOverflowStyle = "scrollbar"; // needed for WinJS apps
  document.body.appendChild(outer);

  // Creating inner element and placing it in the container
  const inner = document.createElement("div");
  outer.appendChild(inner);

  // Calculating difference between container's full width and the child width
  const scrollbarWidth = outer.offsetWidth - inner.offsetWidth;

  // Removing temporary elements from the DOM
  outer.parentNode.removeChild(outer);

  document.documentElement.style.setProperty(
    propertyName,
    scrollbarWidth + "px"
  );

  return scrollbarWidth;
};

const isElementInViewport = function (el) {
  let rect = el.getBoundingClientRect();
  return (
    rect.top >= 0 &&
    rect.left >= 0 &&
    rect.bottom <=
      (window.innerHeight || document.documentElement.clientHeight) &&
    rect.right <= (window.innerWidth || document.documentElement.clientWidth)
  );
};

const siblings = function (el) {
  if (el.parentNode === null) return [];

  return Array.prototype.filter.call(el.parentNode.children, function (child) {
    return child !== el;
  });
};

export {
  formatPrice,
  sklonenie,
  setScrollbarWidth,
  isElementInViewport,
  siblings,
};
