let photo = document.getElementById("imgSubmit");
let addBtn = document.getElementById("btn");

let namefld = document.getElementById("prdName");
let brand = document.getElementById("prdBrand");
let category = document.getElementById("catg");
let desc = document.getElementById("textarea");
let checkBox = document.getElementById("prodOnSale");
let prodPrice = document.getElementById("prodPrice");
let hiddenField = document.getElementById("hiddenSaleField");
let hiddenDiv = document.getElementById("hiddenDiv");
let qtyField = document.getElementById("qtyField");

let errormsg = document.getElementById("error-msg");

let clearFields = () => {
  namefld.value = "";
  brand.value = "";
  category.value = "";
  desc.value = "";
  errormsg.value = "";
  prodPrice.value = "";
  hiddenField.value = "";
  qtyField.value = "";
};

checkBox.addEventListener("change", () => {
  if (checkBox.checked) {
    hiddenDiv.style.display = "block";
  } else {
    hiddenDiv.style.display = "none";
  }
});

window.addEventListener("pageshow", () => {
  clearFields();
});

addBtn.addEventListener("click", () => {
  if (
    namefld.value != "" &&
    brand.value !== "" &&
    category.value !== "" &&
    desc.value !== "" &&
    prodPrice.value !== "" &&
    qtyField.value !== ""
  ) {
    let http = new XMLHttpRequest();
    http.open("POST", "../controller/addProduct.php");
    http.send(new FormData(document.getElementById("imgSubmit")));
    http.addEventListener("load", () => {
      window.location.replace("../views/admin_products_panel.php");
    });
  } else {
    errormsg.innerText = "Please fill all fields";
  }
});
