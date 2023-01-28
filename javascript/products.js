let content = document.getElementById("container");

let searchField = document.getElementById("searchField");
let clearBtn = document.getElementById("clearBtn");

let selectCatg = document.getElementById("catg");

let getProducts = (callback) => {
  let httpRequest = new XMLHttpRequest();
  httpRequest.open("GET", `controller/getAllProducts.php`);
  httpRequest.send();
  httpRequest.addEventListener("load", () => {
    let productsJson = httpRequest.responseText;
    let products = JSON.parse(productsJson);
    callback(products);
  });
};

searchField.addEventListener("keyup", ({ key }) => {
  if (key === "Enter") {
    let value = searchField.value;
    content.innerHTML = "";
    getProducts((products) => {
      for (let product of products) {
        if (
          product["productName"].match(value) ||
          product["productDesc"].match(value) ||
          product["brand"].match(value)
        ) {
          if (product["onSale"] == 1) {
            let newPrice =
              product["price"] -
              (product["salePercentage"] * product["price"]) / 100;
            content.innerHTML += `
        <div style="display:flex; flex-direction: column; align-items:center; justify-content:center; text-align: center;" prdId="${product["productId"]}" class="project_box">
          <div class="dark_white_bg"><a href="views/expandProductClient.php?prdId=${product["productId"]}"><img style="min-width: 200px; max-width: 200px; min-height: 200px; max-height: 200px;" src="${product["imageLocation"]}" alt="#" /></a></div>
            <h3><a href="views/expandProductClient.php?prdId=${product["productId"]}">${product["productName"]}</a></h3>
            <h4><s>${product["price"]}$</s></h4>
            <h4 style="color: crimson;">${newPrice}$</h4>
         </div>
        `;
          } else {
            content.innerHTML += `
        <div style="display:flex; flex-direction: column; align-items:center; justify-content:center; text-align: center;" prdId="${product["productId"]}" class="project_box">
            <div class="dark_white_bg"><a href="views/expandProductClient.php?prdId=${product["productId"]}"><img style="min-width: 200px; max-width: 200px; min-height: 200px; max-height: 200px;" src="${product["imageLocation"]}" alt="#" /></a></div>
            <h3><a href="views/expandProductClient.php?prdId=${product["productId"]}">${product["productName"]}</a></h3>
            <h4>${product["price"]}$</h4>
         </div>
        `;
          }
        }
      }
    });
  }
});

selectCatg.addEventListener("change", () => {
  let catgValue = selectCatg.options[selectCatg.selectedIndex].value;
  content.innerHTML = "";
  getProducts((products) => {
    for (let product of products) {
      if (product["category"].match(catgValue)) {
        if (product["onSale"] == 1) {
          let newPrice =
            product["price"] -
            (product["salePercentage"] * product["price"]) / 100;
          content.innerHTML += `
        <div style="display:flex; flex-direction: column; align-items:center; justify-content:center; text-align: center;" prdId="${product["productId"]}" class="project_box">
          <div class="dark_white_bg"><a href="views/expandProductClient.php?prdId=${product["productId"]}"><img style="min-width: 200px; max-width: 200px; min-height: 200px; max-height: 200px;" src="${product["imageLocation"]}" alt="#" /></a></div>
            <h3><a href="views/expandProductClient.php?prdId=${product["productId"]}">${product["productName"]}</a></h3>
            <h4><s>${product["price"]}$</s></h4>
            <h4 style="color: crimson;">${newPrice}$</h4>
         </div>
        `;
        } else {
          content.innerHTML += `
        <div style="display:flex; flex-direction: column; align-items:center; justify-content:center; text-align: center;" prdId="${product["productId"]}" class="project_box">
            <div class="dark_white_bg"><a href="views/expandProductClient.php?prdId=${product["productId"]}"><img style="min-width: 200px; max-width: 200px; min-height: 200px; max-height: 200px;" src="${product["imageLocation"]}" alt="#" /></a></div>
            <h3><a href="views/expandProductClient.php?prdId=${product["productId"]}">${product["productName"]}</a></h3>
            <h4>${product["price"]}$</h4>
         </div>
        `;
        }
      }
    }
  });
});

clearBtn.addEventListener("click", () => {
  window.location.href = `products.php`;
});
