let resultParagraph = document.getElementById("resultParagraph");
let tableBody = document.getElementById("tableBody");

let getUsers = () => {
  let httpRequest = new XMLHttpRequest();
  httpRequest.open("GET", `../controller/getUsers.php`);
  httpRequest.send();
  httpRequest.addEventListener("load", () => {
    let usersJson = httpRequest.responseText;
    let users = JSON.parse(usersJson);
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
    prepareParagraph(users);
  });
};

let prepareParagraph = (users) => {
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
};

window.onload = () => {
  getUsers();
};
