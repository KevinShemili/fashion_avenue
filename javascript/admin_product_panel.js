let addBtn = document.getElementById("addBtn");
let content = document.getElementById("container");

addBtn.addEventListener("click", () => {
  window.location.href = "../views/add_new_product.php";
});

window.onload = () => {
  getProducts();
};

let getProducts = () => {
  let httpRequest = new XMLHttpRequest();
  httpRequest.open("GET", `../controller/getAllProducts.php`);
  httpRequest.send();
  httpRequest.addEventListener("load", () => {
    let productsJson = httpRequest.responseText;
    let products = JSON.parse(productsJson);
    if (products) {
      for (let product of products) {
        content.innerHTML += `
        <div class="card">
          <img id="img" src="../${product["imageLocation"]}" alt="${product["productName"]}">
          <div id="card-body">
              <h4 class="card-title">${product["productName"]}</h4>
              <h5 class="card-title">${product["productDesc"]}</h5>
              <h5 class="card-text">${product["brand"]}</h5>
              <h5 class="card-text">${product["price"]} $</h5>
              <button id="edit-fields" type="button" prd-id="${product["productId"]}">Edit Fields</button>
              <button id="change-qty" type="button" prd-id="${product["productId"]}">Change Quantity</button>
              <button id="delete-btn" type="button" prd-id="${product["productId"]}">Delete</button>
          </div>
        </div>
        `;
      }
    } else {
      content.innerHTML += `<h3 style="color: crimson;">Empty Catalog</h3>`;
    }
  });
};

content.addEventListener("click", (event) => {
  if (event.target.nodeName == "BUTTON") {
    const prd_id = event.target.getAttribute("prd-id");
    let httpRequest = new XMLHttpRequest();
    httpRequest.open("POST", `../views/expand_product.php`);
    httpRequest.send("prd_id=" + prd_id);
  }
});
