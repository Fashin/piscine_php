class Users extends Quest{

  constructor() {
    super();
    this.actual_quest = [];
    this.commands = {
      "quest" : [this.get_quest, '1', '[liste toutes les quêtes actuels]'],
      "add_quest" : [this.adding_new_quest, '0'],
      "help" : [this.man, '1', '[pour voire toutes les commandes que vous pouvez tapez]'],
      "inventaire" : [this.get_object, '1', '[pour voire les objets de votre inventaire]']
    };
    this.object = [];
  }

  man() {
    let ret = undefined;

    ret = "====================\n";
    for (let key in user.commands)
      if (user.commands[key][1] > 0)
        ret += '-> ' +  key + ' ' + user.commands[key][2] + '\n';
    ret += "====================\n";
    return (ret);
  }

  adding_new_quest (id) {
    user.actual_quest.push(id);
  }

  get_object() {
    let ret = undefined;

    if (user.object.length == 0)
      ret = "==================\nVous n'avez rien dans vos poches\n==================\n";
    else
    {
      ret = "==================\n";
      for (let i = 0; i < user.object.length; i++)
        ret += "-> " + user.object[i] + '\n';
      ret += "==================\n";
    }
    return (ret);
  }

  have_object(object_name) {
    for (let i = 0; i < user.object.length; i++)
      if (object_name == user.object[i])
        return (1);
    return (0);
  }

  get_quest() {
    if (user.actual_quest.length > 0)
      return (user.translate_quest(user.actual_quest));
    else
      return ("Vous n'avez pas encore choisit de quête");
  }

  update_quest() {
    let div = document.getElementsByClassName('invisible')[0];
    let object = div.getAttribute('object');
    if (typeof object !== "undefined")
      user.object.push(object);
  }
}
