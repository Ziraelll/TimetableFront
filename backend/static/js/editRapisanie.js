function tableToJson(tableId) {
  let table = document
    .getElementById("" + tableId)
    .getElementsByTagName("tbody")[0];
  let trs = table.getElementsByTagName("tr");
  let tds = trs[0].getElementsByTagName("td");
  let obj = {};
  obj.id = tableId;
  console.log(tds[0]);
  obj.numberPair = tds[0].getElementsByTagName("input")[0].value;
  obj.dateStart = tds[1].getElementsByTagName("input")[0].value;
  obj.dateEnd = tds[2].getElementsByTagName("input")[0].value;
  obj.idSubject = tds[3].getElementsByTagName("select")[0].value;
  obj.idHousing = tds[4].getElementsByTagName("select")[0].value;
  obj.idClassroom = tds[5].getElementsByTagName("select")[0].value;

  tds = trs[1].getElementsByTagName("td");
  obj.idGroup = tds[0].getElementsByTagName("select")[0].value;
  obj.idUser = tds[1].getElementsByTagName("select")[0].value;
  obj.secondTeacher = tds[2].getElementsByTagName("select")[0].value;
  obj.idTypeWeek = tds[3].getElementsByTagName("select")[0].value;
  obj.idDay = tds[4].getElementsByTagName("select")[0].value;
  return JSON.stringify(obj);
}

function deletePair(pairId) {
  let json = tableToJson(pairId);
  let xhr = new XMLHttpRequest();
  xhr.open("DELETE", "edit_raspisanie.php");
  xhr.setRequestHeader("Content-type", "application/json; charset=utf-8");
  xhr.send(json);

  xhr.onload = function () {
    if (xhr.status !== 200) {
      alert(`Ошибка ${xhr.status}: ${xhr.statusText}`);
      alert(
        "Тут умер здравый смысл \n" +
          "Я все в рот ебал \n И когда Думченко захочет в следующий раз \n " +
          "сЫкономить на студентах, пусть идёт нахуй"
      );
      console.log("Тут умер здравый смысл");
      console.log(
        "И когда Думченко захочет в следующий раз " +
          "сЫкономить на студентах, пусть идёт нахер"
      );
    }
  };
}

function changePair(pairId) {
  let json = tableToJson(pairId);

  let xhr = new XMLHttpRequest();

  xhr.open("POST", "edit_raspisanie.php");
  xhr.setRequestHeader("Content-type", "application/json; charset=utf-8");

  xhr.send(json);

  xhr.onload = function () {
    if (xhr.status !== 200) {
      alert(`Ошибка ${xhr.status}: ${xhr.statusText}`);
      console.log("Тут умер здравый смысл");
    }
  };
}
