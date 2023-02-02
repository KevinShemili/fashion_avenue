let addBtn = document.getElementById("addBtn");
let content = document.getElementById("container");

let searchField = document.getElementById("searchField");
let clearBtn = document.getElementById("clearBtn");

addBtn.addEventListener("click", () => {
  window.location.href = "../views/add_new_product.php";
});

window.onload = () => {
  getProducts((products) => {
    prepareContent(products);
  });
};

let getProducts = (callback) => {
  let httpRequest = new XMLHttpRequest();
  httpRequest.open("GET", `../controller/getAllProducts.php`);
  httpRequest.send();
  httpRequest.addEventListener("load", () => {
    let productsJson = httpRequest.responseText;
    let products = JSON.parse(productsJson);
    callback(products);
  });
};

let prepareContent = (products) => {
  content.innerHTML = "";
  if (products) {
    for (let product of products) {
      if (product["onSale"] == 1) {
        newPrice =
          parseFloat(product["price"]) -
          (parseFloat(product["salePercentage"]) *
            parseFloat(product["price"])) /
            100;
        content.innerHTML += `
        <div class="card">
          <img id="img" src="../${product["imageLocation"]}" alt="${product["productName"]}">
          <div id="card-body">
              <h4 style="margin-top: 20px;" class="card-title">${product["productName"]}</h4>
              <h5 class="card-title">${product["productDesc"]}</h5>
              <h5 class="card-text">${product["brand"]}</h5>
              <h5 class="card-text" style="color: crimson;">${newPrice} $</h5>
              <button id="edit-fields" type="button" prd-id="${product["productId"]}">Edit</button>
          </div>
        </div>
        `;
      } else {
        content.innerHTML += `
        <div class="card">
          <img id="img" src="../${product["imageLocation"]}" alt="${product["productName"]}">
          <div id="card-body">
              <h4 style="margin-top: 20px;" class="card-title">${product["productName"]}</h4>
              <h5 class="card-title">${product["productDesc"]}</h5>
              <h5 class="card-text">${product["brand"]}</h5>
              <h5 class="card-text">${product["price"]} $</h5>
              <button id="edit-fields" type="button" prd-id="${product["productId"]}">Edit</button>
          </div>
        </div>
        `;
      }
    }
  } else {
    content.innerHTML += `<h3 style="color: crimson;">Empty Catalog</h3>`;
  }
};

content.addEventListener("click", (event) => {
  if (event.target.nodeName == "BUTTON") {
    const prd_id = event.target.getAttribute("prd-id");
    window.location.href = "../views/expand_product.php?prdid=" + prd_id;
  }
});

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
          content.innerHTML += `
        <div class="card">
          <img id="img" src="../${product["imageLocation"]}" alt="${product["productName"]}">
          <div id="card-body">
              <h4 class="card-title">${product["productName"]}</h4>
              <h5 class="card-title">${product["productDesc"]}</h5>
              <h5 class="card-text">${product["brand"]}</h5>
              <h5 class="card-text">${product["price"]} $</h5>
              <button id="edit-fields" type="button" prd-id="${product["productId"]}">Edit</button>
          </div>
        </div>
        `;
        }
      }
    });
  }
});

clearBtn.addEventListener("click", () => {
  searchField.value = "";
  getProducts((products) => {
    prepareContent(products);
  });
});
