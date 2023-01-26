let checkBox = document.getElementById("prodOnSale");
let changePhoto = document.getElementById("changephotobtn");
let photoForm = document.getElementById("imgSubmit");
let img = document.getElementById("img");

const urlParams = new URLSearchParams(window.location.search);

checkBox.addEventListener("change", () => {
  if (checkBox.checked) {
    hiddenDiv.style.display = "block";
  } else {
    hiddenDiv.style.display = "none";
  }
});

changePhoto.addEventListener("click", () => {
  const prdid = urlParams.get("prdid");
  let http = new XMLHttpRequest();
  http.open("POST", "../controller/changePhoto.php");
  let form = new FormData();
  form.append("photoForm", img.files[0], img.files[0].name);
  form.append("prdid", prdid);
  http.onreadystatechange = function () {
    if (http.readyState == 4 && http.status == 200) {
      window.location.href = "../views/expand_product.php?prdid=" + prdid;
    }
  };
  http.send(form);
});
