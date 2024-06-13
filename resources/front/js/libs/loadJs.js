function loadJs(url) {
  let script = document.createElement("script");
  script.src = url;
  script.setAttribute("async", "true");
  document.documentElement.firstChild.appendChild(script);
}
