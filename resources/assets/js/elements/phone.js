import { parsePhoneNumberFromString } from "libphonenumber-js";

function formatPhone(value) {
  let phone = parsePhoneNumberFromString(value, "RU");
  if (!phone) return value;
  return phone.formatInternational();
}

function isValid(value) {
  let phone = parsePhoneNumberFromString(value, "RU");
  if (!phone) return false;
  return phone.isValid();
}

document.querySelectorAll("input.format-phone").forEach((el) => {
  el.addEventListener("input", () => {
    el.value = formatPhone(el.value);

    if (!isValid(el.value)) el.setCustomValidity("Введите действующий телефон");
    else el.setCustomValidity("");
  });

  window.onload = () => {
    el.value = formatPhone(el.value);
  };
});
