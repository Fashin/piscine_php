window.onload = () => {
  let xhr = new XMLHttpRequest();
  xhr.open('GET', '/mnt/c/Users/cbeauvoi/Documents/cours/piscine_php/j08/tmp/board', true);
  xhr.setRequestHeader('Content-Type', 'application/json');
  xhr.send();
  xhr.onreadystatechange = () => {
    if (this.readyState == 4 && this.status == 200) {
        var myArr = JSON.parse(this.responseText);
        console.log(myArr);
    }
    else
      console.log("Error from loading");
  };
}
