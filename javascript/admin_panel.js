let resultParagraph = document.getElementById("resultParagraph");
let tableBody = document.getElementById("tableBody");

let searchField = document.getElementById("searchField");
let clearBtn = document.getElementById("clearBtn");

let nextBtn = document.getElementById("next-btn");
let backBtn = document.getElementById("back-btn");

let paginationDiv = document.getElementById("paginationDiv");

let firstA = document.getElementById("firstA");
let secondA = document.getElementById("secondA");
let thirdA = document.getElementById("thirdA");

const urlParams = new URLSearchParams(window.location.search);

window.onload = () => {
  getPaginatedUsers();
  prepareParagraph();
};

let getAllUsers = (callback) => {
  let httpRequest = new XMLHttpRequest();
  httpRequest.open("GET", `../controller/getUsers.php?action=getAllUsers`);
  httpRequest.send();
  httpRequest.addEventListener("load", () => {
    let usersJson = httpRequest.responseText;
    let users = JSON.parse(usersJson);
    callback(users);
  });
};

let getPaginatedUsers = () => {
  let httpRequest = new XMLHttpRequest();
  let pag = urlParams.get("pag");
  httpRequest.open("GET", `../controller/getUsers.php?pag=${pag}`);
  httpRequest.send();
  httpRequest.addEventListener("load", () => {
    let usersJson = httpRequest.responseText;
    let users = JSON.parse(usersJson);
    if (users.length < 5) {
      nextBtn.disabled = true;
    }
    prepareContent(users);
  });
};

let prepareContent = (users) => {
  tableBody.innerHTML = "";
  for (let user of users) {
    let flag;
    if (user["credit_card"] == 0 || user["credit_card"] == undefined) {
      flag = "../images/close.png";
    } else {
      flag = "../images/check.png";
    }
    tableBody.innerHTML += `
        <tr>
          <th scope="row">${user["name"]}</th>
          <td>${user["surname"]}</td>
          <td>${user["email"]}</td>
          <td>
            <img style="width: 20px; height: 20px;" src=${flag}>
          </td>
        </tr>`;
  }
};

let prepareParagraph = () => {
  getAllUsers((users) => {
    let positives = 0,
      negatives = 0;

    for (let user of users) {
      if (user["credit_card"] == 0 || user["credit_card"] == undefined) {
        negatives++;
      } else {
        positives++;
      }
    }

    resultParagraph.innerHTML = `
    <ul style="text-align: center;">
    Out of <b>${users.length}</b> accounts: 
    <li><b>${positives}</b> users have registered their credit cards.</li>
    <li><b>${negatives}</b> users have not registered their credit cards.</li>
    </ul>
    `;
  });
};

searchField.addEventListener("keyup", ({ key }) => {
  if (key === "Enter") {
    let value = searchField.value;
    tableBody.innerHTML = "";
    if (value == "") {
      getPaginatedUsers();
      paginationDiv.style.display = `block`;
    } else {
      paginationDiv.style.display = `none`;
      getAllUsers((users) => {
        for (let user of users) {
          if (
            user["name"].match(value) ||
            user["surname"].match(value) ||
            user["email"].match(value)
          ) {
            let flag;
            if (user["credit_card"] == 0 || user["credit_card"] == undefined) {
              flag = "../images/close.png";
            } else {
              flag = "../images/check.png";
            }
            tableBody.innerHTML += `
        <tr>
          <th scope="row">${user["name"]}</th>
          <td>${user["surname"]}</td>
          <td>${user["email"]}</td>
          <td>
            <img style="width: 20px; height: 20px;" src=${flag}>
          </td>
        </tr>`;
          }
        }
      });
    }
  }
});

clearBtn.addEventListener("click", () => {
  searchField.value = "";
  paginationDiv.style.display = `block`;
  getPaginatedUsers();
});

nextBtn.addEventListener("click", () => {
  if (urlParams.get("pag")) {
    const pag = parseInt(urlParams.get("pag"));
    let newPag = pag + 1;
    window.location.href = "../views/admin_panel.php?pag=" + newPag;
  } else {
    window.location.href = "../views/admin_panel.php?pag=" + 2;
  }
});

backBtn.addEventListener("click", () => {
  if (urlParams.get("pag")) {
    const pag = parseInt(urlParams.get("pag"));
    let newPag = pag - 1;
    if (newPag <= 0) {
      backBtn.disabled = true;
    } else {
      window.location.href = "../views/admin_panel.php?pag=" + newPag;
    }
  } else {
    backBtn.disabled = true;
  }
});
