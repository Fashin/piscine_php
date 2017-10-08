window.onload = () => {
  let xhr = new XMLHttpRequest();
  xhr.open('GET', 'http://localhost:8080/tmp/board', true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = () => {
    if (xhr.readyState == 4 && xhr.status == 200)
    {
      let map = JSON.parse(xhr.response);
      let u_params = {
        'height' : window.screen.availHeight,
        'width' : window.screen.availWidth,
        'map_size' : {
          'height' : map.length,
          'width' : map[0].length,
        },
      };
      display_board(map, u_params);
    }
  };
  xhr.send(null);
}
