let addToCartBtn = document.getElementById("addToCartBtn");
let qtyField = document.getElementById("qtyField");

let numberOnlyRegex = /^[0-9]+$/;
const urlParams = new URLSearchParams(window.location.search);

addToCartBtn.addEventListener("click", () => {
  let value = qtyField.value;
  const prdid = urlParams.get("prdId");
  let http = new XMLHttpRequest();
  http.open("POST", "../controller/addToCart.php");
  let form = new FormData();
  if (numberOnlyRegex.test(parseInt(value))) {
    form.append("qty", value);
    form.append("prdid", prdid);
    http.send(form);
    http.addEventListener("load", () => {
      window.location.replace("../products.php");
    });
  } else {
    alert("Numbers only");
  }
});
