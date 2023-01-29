let container = document.getElementById("content");
let totalPriceText = document.getElementById("totalPriceText");
let checkoutBtn = document.getElementById("checkoutBtn");

const urlParams = new URLSearchParams(window.location.search);

let arrayPrdIds = [];

window.onload = () => {
  getCardItems((items) => {
    prepareContainer(items);
  });
};

let getCardItems = (callback) => {
  const cartId = urlParams.get("cartId");
  let http = new XMLHttpRequest();
  http.open("GET", "../controller/getCartItems.php?cartId=" + cartId);
  http.send();
  http.addEventListener("load", () => {
    let productsJson = http.responseText;
    let products = JSON.parse(productsJson);
    if (products) callback(products);
    else container.innerHTML = "";
  });
};

let prepareContainer = (items) => {
  container.innerHTML = "";
  if (items.length > 0) {
    let totalPriceToPay = 0;
    for (let item of items) {
      let itemPrdId = item["prdId"];

      let http = new XMLHttpRequest();
      http.open("GET", "../controller/getProduct.php?itemPrdId=" + itemPrdId);
      http.send();
      http.addEventListener("load", () => {
        let productsJson = http.responseText;
        let products = JSON.parse(productsJson);
        let obj = {
          id: itemPrdId,
          bought: item["quantity"],
          oldQty: products["quantity"],
        };
        arrayPrdIds.push(obj);
        if (products["onSale"] == 1) {
          newPrice =
            products["price"] -
            (products["salePercentage"] * products["price"]) / 100;
          totalPriceToPay += parseFloat(newPrice) * parseInt(item["quantity"]);
          container.innerHTML += `<div class="row border-top border-bottom">
                                <div class="row main align-items-center">
                                    <div class="col-2"><img class="img-fluid" src="../${products["imageLocation"]}"></div>
                                    <div class="col">
                                        <div class="row text-muted">${products["productName"]}</div>
                                        <div class="row">${products["brand"]}</div>
                                    </div>
                                    <div class="col">
                                        <a href="#" class="border">${item["quantity"]}</a>
                                    </div>
                                    <div class="col" style="color:crimson;">${newPrice}$<span cartItemId=${item["cartItemsId"]} id="deleteProd" class="close">&#10005;</span></div>
                                </div>
                        </div>`;
        } else {
          totalPriceToPay +=
            parseFloat(products["price"]) * parseInt(item["quantity"]);
          container.innerHTML += `<div class="row border-top border-bottom">
                                <div class="row main align-items-center">
                                    <div class="col-2"><img class="img-fluid" src="../${products["imageLocation"]}"></div>
                                    <div class="col">
                                        <div class="row text-muted">${products["productName"]}</div>
                                        <div class="row">${products["brand"]}</div>
                                    </div>
                                    <div class="col">
                                        <a href="#" class="border">${item["quantity"]}</a>
                                    </div>
                                    <div class="col">${products["price"]}$<span cartItemId=${item["cartItemsId"]} id="deleteProd" class="close">&#10005;</span></div>
                                </div>
                        </div>`;
        }
        totalPriceText.innerText = parseFloat(totalPriceToPay).toFixed(2) + "$";
      });
    }
  } else {
    totalPriceText.innerText = "0$";
  }
};

container.addEventListener("click", (event) => {
  event.stopPropagation();
  event.preventDefault();
  if (event.target.nodeName == "SPAN") {
    const cartItemId = event.target.getAttribute("cartItemId");

    let http = new XMLHttpRequest();
    http.open("POST", "../controller/deleteCartItem.php");
    let form = new FormData();
    form.append("cartItemId", cartItemId);
    http.send(form);
    http.addEventListener("load", () => {
      getCardItems((items) => {
        prepareContainer(items);
      });
    });
  }
});

checkoutBtn.addEventListener("click", () => {
  if (totalPriceText.innerText != "0$") {
    let http = new XMLHttpRequest();
    http.open("POST", "../controller/deleteAllCartItems.php");
    http.send();
    http.addEventListener("load", () => {
      container.innerHTML = "Success. Items will be delivered soon.";
      totalPriceText.innerText = "0$";

      for (let obj of arrayPrdIds) {
        let ihttp = new XMLHttpRequest();
        ihttp.open("POST", "../controller/updateProductQty.php");
        let form = new FormData();
        form.append("id", obj.id);
        form.append("oldQty", obj.oldQty);
        form.append("boughtQty", obj.bought);
        ihttp.send(form);
      }
    });

    let http2 = new XMLHttpRequest();

    http2.open("POST", "../controller/addToBudget.php");
    let form = new FormData();
    form.append("revenue", totalPriceText.innerText);
    http2.send(form);
    http2.addEventListener("load", () => {
      let response = http2.responseText;
    });
  } else {
    container.innerHTML = "No items.";
  }
});
