let submit = document.getElementsByClassName('send_input')[0];
let text = document.getElementsByClassName('text_input')[0];
let is_valid = 0;

text.addEventListener("keydown", (event) => {
  if (event.keyCode == 13)
  {
    Object.keys(user.commands).find((name) => {
      let input_user = text.value.split(' ');
      if (name == input_user[0])
      {
        input_user.splice(0, 1);
        let ret = undefined;
        ret = user.commands[name](input_user)
        if (typeof ret !== "undefined")
          console.log(ret);
        else
          console.log("operation effectuer avec success");
        is_valid = 1;
      }
    });
    text.value = "";
    if (!(is_valid))
      console.log("Cette commande n'est pas valide");
    is_valid = 0;
  }
});
