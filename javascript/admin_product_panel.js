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
        <div class="card" style="display:flex; width: 18rem;">
        <img class="card-img-top" src="../${product["imageLocation"]}" alt="${product["productName"]}">
        <div class="card-body">
            <h4 class="card-title">${product["productName"]}</h4>
            <h5 class="card-title">${product["productDesc"]}</h5>
            <p class="card-text">${product["brand"]}</p>
            <button class="btn btn-primary" prd-id="${product["productId"]}">Show Details</button>
        </div>
    </div>
          `;
      }
    } else {
      content.innerHTML += `<h3 style="color: crimson;">Empty Catalog</h3>`;
    }
  });
};
