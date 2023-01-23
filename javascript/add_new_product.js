var photo = document.getElementById("photo");

var data = new FormData();
//from inputs
data.append(photo.name, photo.files[0]);
data.append("name", name);
data.append("price", price);
data.append("quantity", quantity);
data.append("description", description);

var xmlhttp = new XMLHttpRequest();
xmlhttp.open("POST", "ajaxpost.php");
xmlhttp.send(data);
