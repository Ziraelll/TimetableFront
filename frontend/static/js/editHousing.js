function tableToJson() {
  let result = [];
  let table = document
    .getElementById("housing")
    .getElementsByTagName("tbody")[0];
  let trs = table.getElementsByTagName("tr");
  for (let i = 0; i < trs.length; i++) {
    let tds = trs[i].getElementsByTagName("td");
    let obj = {};
    obj.id = i + 1;
    obj.shortHousing = tds[0].getElementsByTagName("input")[0].value;
    obj.longHousing = tds[1].getElementsByTagName("input")[0].value;
    obj.address = tds[2].getElementsByTagName("input")[0].value;
    result.push(obj);
  }
  return JSON.stringify(result);
}

function postTable() {
  let xhr = new XMLHttpRequest();

  let json = tableToJson();

  xhr.open("POST", "edit_housing.php");
  xhr.setRequestHeader("Content-type", "application/json; charset=utf-8");

  xhr.send(json);

  xhr.onload = function () {
    if (xhr.status !== 200) {
      alert(`Ошибка ${xhr.status}: ${xhr.statusText}`);
    }
  };
}
