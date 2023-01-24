let photo = document.getElementById("imgSubmit");
let addBtn = document.getElementById("btn");

let namefld = document.getElementById("prdName");
let brand = document.getElementById("prdBrand");
let category = document.getElementById("catg");
let desc = document.getElementById("textarea");

let errormsg = document.getElementById("error-msg");

let clearFields = () => {
  namefld.value = "";
  brand.value = "";
  category.value = "";
  desc.value = "";
  errormsg.value = "";
};

window.addEventListener("pageshow", () => {
  clearFields();
});

addBtn.addEventListener("click", () => {
  if (
    namefld.value != "" &&
    brand.value !== "" &&
    category.value !== "" &&
    desc.value !== ""
  ) {
    let http = new XMLHttpRequest();
    http.open("POST", "../controller/addProduct.php");
    http.send(new FormData(document.getElementById("imgSubmit")));
    http.addEventListener("load", () => {
      errormsg.innerText = http.responseText;
      window.location.href = "../views/admin_products_panel.php";
    });
  } else {
    errormsg.innerText = "Please fill all fields";
  }
});
