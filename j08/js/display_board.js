let display_board = (map, u_params) => {
  let canvas = document.getElementById('canvas');
  let ctx = canvas.getContext('2d');
  let rect_width = Math.round(u_params.width / u_params.map_size.width);
  let rect_height = Math.round(u_params.height / u_params.map_size.height);
  let numCol = map[0].length;
  let numRow = map.length;
  ctx.canvas.width = u_params.width;
  ctx.canvas.height = u_params.height;
  console.log(map);
  for (let i = 0; i < numRow; i++)
  {
    for (let j = 0; j < numCol; j++)
    {
      if (map[i][j] == '.')
        ctx.fillStyle = "green";
      else
        ctx.fillStyle = "brown";
      ctx.fillRect(i * rect_width, j * rect_height, rect_width, rect_height);
    }
  }
}
