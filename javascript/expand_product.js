let checkBox = document.getElementById("prodOnSale");
let changePhoto = document.getElementById("changephotobtn");
let photoForm = document.getElementById("imgSubmit");
let img = document.getElementById("img");

let btnAdd = document.getElementById("btnAdd");
let btnRemove = document.getElementById("btnRemove");
let btnUpdate = document.getElementById("btnUpdate");
let btnDelete = document.getElementById("btnDelete");

let qtyErrorMsg = document.getElementById("qtyErrorMsg");

let quantityUpdateField = document.getElementById("quantityUpdateField");
let quantityNr = document.getElementById("totalQuantityNumber");

let productName = document.getElementById("prdName");
let productBrand = document.getElementById("prdBrand");
let productPrice = document.getElementById("prodPrice");
let productDesc = document.getElementById("textarea");
let salePercentage = document.getElementById("hiddenSaleField");
let productCategory = document.getElementById("catg");

const urlParams = new URLSearchParams(window.location.search);
let numberOnlyRegex = /^[0-9]+$/;

checkBox.addEventListener("change", () => {
  if (checkBox.checked) {
    hiddenDiv.style.display = "block";
  } else {
    hiddenDiv.style.display = "none";
  }
});

btnUpdate.addEventListener("click", () => {
  const prdid = urlParams.get("prdid");
  let http = new XMLHttpRequest();
  http.open("POST", "../controller/updateProduct.php");
  let form = new FormData();
  if (img.files[0] != null) {
    form.append("photoForm", img.files[0], img.files[0].name);
  }
  form.append("prdid", prdid);
  if (productName.value != null) {
    form.append("productName", productName.value);
  }
  if (productBrand.value != null) {
    form.append("productBrand", productBrand.value);
  }
  if (productPrice.value != null) {
    form.append("productPrice", productPrice.value);
  }
  if (productDesc.value != null) {
    form.append("productDesc", productDesc.value);
  }
  if (checkBox.checked) {
    form.append("onSale", 1);
    if (salePercentage.value != null) {
      form.append("salePercentage", salePercentage.value);
    }
  } else {
    form.append("onSale", 0);
  }
  if (productCategory.options[productCategory.selectedIndex].value != null) {
    form.append(
      "category",
      productCategory.options[productCategory.selectedIndex].value
    );
  }
  form.append("qty", parseInt(quantityNr.innerText));
  http.send(form);
  http.addEventListener("load", () => {
    window.location.href = "../views/admin_products_panel.php";
  });
});

btnDelete.addEventListener("click", () => {
  const prdid = urlParams.get("prdid");
  let http = new XMLHttpRequest();
  http.open("POST", "../controller/deleteProduct.php");
  let data = new FormData();
  data.append("prdid", prdid);
  http.send(data);
  http.addEventListener("load", () => {
    window.location.href = "../views/admin_products_panel.php";
  });
});

window.onload = () => {
  let imagePreview = document.getElementById("imagePreview");
  changePhoto.addEventListener("click", (ev) => {
    ev.preventDefault();
    ev.stopPropagation();
    let file = img.files[0];
    let reader = new FileReader();
    reader.readAsDataURL(file);
    reader.addEventListener("load", function () {
      imagePreview.src = reader.result;
    });
  });
};

btnRemove.addEventListener("click", () => {
  let value = parseInt(quantityNr.innerText);
  let fieldValue = parseInt(quantityUpdateField.value);
  if (numberOnlyRegex.test(fieldValue)) {
    if (value - fieldValue < 0) {
      qtyErrorMsg.innerText = `Error negative balance`;
    } else {
      value -= fieldValue;
      quantityNr.innerText = `${value}`;
    }
  } else {
    qtyErrorMsg.innerText = `Numbers only`;
  }
});

btnAdd.addEventListener("click", () => {
  let value = parseInt(quantityNr.innerText);
  let fieldValue = parseInt(quantityUpdateField.value);
  if (numberOnlyRegex.test(fieldValue)) {
    value += fieldValue;
    quantityNr.innerText = `${value}`;
  } else {
    qtyErrorMsg.innerText = `Numbers only`;
  }
});
