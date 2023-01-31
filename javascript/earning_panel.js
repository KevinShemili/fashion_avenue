let resultParagraph = document.getElementById("resultParagraph");
let tableBody = document.getElementById("tableBody");

window.onload = () => {
  getBudget((sales) => {
    prepareContent(sales);
    prepareParagraph(sales);
  });
};

let getBudget = (callback) => {
  let httpRequest = new XMLHttpRequest();
  httpRequest.open("GET", `../controller/getBudget.php`);
  httpRequest.send();
  httpRequest.addEventListener("load", () => {
    let usersJson = httpRequest.responseText;
    let sales = JSON.parse(usersJson);
    callback(sales);
  });
};

let prepareContent = (sales) => {
  let hashmap = new Map();
  for (sale of sales) {
    if (hashmap.has(sale["date"])) {
      let storedValue = hashmap.get(sale["date"]);
      let newValue = parseFloat(storedValue) + parseFloat(sale["revenue"]);
      hashmap.set(sale["date"], newValue);
    } else {
      hashmap.set(sale["date"], sale["revenue"]);
    }
  }

  tableBody.innerHTML = "";
  for (let [key, value] of hashmap) {
    tableBody.innerHTML += `
        <tr>
          <td>${key}</td>
          <td>${parseFloat(value).toFixed(2)}$</td>
        </tr>`;
  }
};

let prepareParagraph = (sales) => {
  let total = 0;
  for (sale of sales) {
    total += parseFloat(sale["revenue"]);
  }

  resultParagraph.innerHTML = `
    <ul style="text-align: center;">
    From <b>${sales.length}</b> total sales: 
    <li>A revenue of <b>${total.toFixed(2)}</b>$ was generated.</li>
    </ul>
    `;
};
