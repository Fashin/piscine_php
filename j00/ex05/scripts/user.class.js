class Users extends Quest{

  constructor() {
    super();
    this.actual_quest = [];
    this.commands = {
      "quest" : [this.get_quest, '1', '[liste toutes les quêtes actuels]'],
      "help" : [this.man, '1', '[pour voire toutes les commandes que vous pouvez tapez]'],
      "inventaire" : [this.get_object, '1', '[pour voire les objets de votre inventaire]'],
      "add_quest" : [this.add_new_quest, '0'],
      "add_object" : [this.add_new_object, '0']
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

  add_new_quest (id) {
    for (let i = 0; i < id.length; i++)
      user.actual_quest.push(id[i]);
    console.log("Quête accepter");
  }

  add_new_object (name) {
    for (let i = 0; i < name.length; i++)
      user.object.push(name[i]);
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
    {
      console.log(user.actual_quest);
      //console.log(user.translate_quest());
      return ("nthin");
    }
    else
      return ("Vous n'avez pas encore choisit de quête");
  }

  end_quest (uid) {
    for (let i = 0; i < user.actual_quest.length; i++)
    {
      if (user.actual_quest[i] == uid)
      {
        user.actual_quest.splice(i, 1);
        console.log("Bravo vous avez terminé la quête !");
        break ;
      }
    }
  }

  update_quest() {
    let div = document.getElementsByClassName('invisible')[0];
    let object = div.getAttribute('object');
    if (typeof object !== "undefined")
      user.object.push(object);
  }
}
