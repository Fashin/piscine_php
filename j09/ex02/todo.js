(function() {

  let submit = document.getElementsByClassName('submit')[0];
  let todo = document.getElementById('ft_list');

  let create_element = (title, todo, all_todo) => {
    let new_todo = document.createElement("div");
    let text_todo = document.createTextNode(title);

    new_todo.addEventListener('click', (event) => {
      if (confirm("Voulez vous supprimer cette element ?"))
      {
        todo.removeChild(event.target);
        if (document.cookie.length > 0)
        {
          let cookie = document.cookie.split('=')[1].split(',');
          let new_value = [];
          for (let i = 0; i < cookie.length; i++)
            if (cookie[i] != event.target.innerHTML)
              new_value.push(cookie[i]);
          document.cookie = "todo=" + new_value.join();
        }
      }
    });
    new_todo.appendChild(text_todo);
    todo.insertBefore(new_todo, all_todo[0]);
  }

  if (document.cookie.length > 0)
  {
    let todos = document.cookie.split('=')[1].split(',');
    for (let i = 0; i < todos.length; i++)
      create_element(todos[i], todo, todo.childNodes);
  }

  submit.addEventListener('click', () => {
    let title = prompt("S'il vous plait renseignez le titre :");

    if (title && title.length > 0 && title.trim())
    {
      create_element(title, todo, todo.childNodes);
      let new_cookie;
      if (document.cookie.length == 0)
        new_cookie = title + ";";
      else
      {
        new_cookie = document.cookie.split('=')[1].split("|").filter((elem) => {
          return (elem.trim());
        })
        new_cookie.push(title);
        new_cookie.join();
      }
      document.cookie = "todo=" + new_cookie;
    }
  });

})();
