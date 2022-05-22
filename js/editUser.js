function tableToJson() {
  let result = [];
  let table = document.getElementById("users").getElementsByTagName("tbody")[0];
  let trs = table.getElementsByTagName("tr");
  for (let i = 0; i < trs.length; i++) {
    let tds = trs[i].getElementsByTagName("td");
    let obj = {};
    obj.id = i + 1;
    obj.lname = tds[0].getElementsByTagName("input")[0].value;
    obj.fname = tds[1].getElementsByTagName("input")[0].value;
    obj.surname = tds[2].getElementsByTagName("input")[0].value;
    obj.idPosition = tds[3].getElementsByTagName("select")[0].value;
    obj.banned = tds[4].getElementsByTagName("input")[0].value;
    result.push(obj);
  }
  return JSON.stringify(result);
}

function postTable() {
  let xhr = new XMLHttpRequest();

  let json = tableToJson();

  xhr.open("POST", "edit_user.php");
  xhr.setRequestHeader("Content-type", "application/json; charset=utf-8");

  xhr.send(json);

  xhr.onload = function () {
    if (xhr.status !== 200) {
      alert(`Ошибка ${xhr.status}: ${xhr.statusText}`);
    }
  };
}
