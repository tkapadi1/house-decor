const cartTotal = document.querySelector(".cart-total");

cartvalue = 0;

class Storage {
  static getCart() {
    return localStorage.getItem("cart")
      ? JSON.parse(localStorage.getItem("cart"))
      : [];
  }
  static getCartValue() {
      let value = JSON.parse(localStorage.getItem("cart_value"));
      return value;
  }
}


class UI{
    setupAPP() {
        cartvalue = Storage.getCartValue();
        return cartvalue;
      }
}

document.addEventListener("DOMContentLoaded", () => {
    const ui = new UI();
    cartTotal.innerHTML = ui.setupAPP();
  });