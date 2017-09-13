class Quest {

  constructor () {

    this.quest = {
      "id" : ["0A"]
    };

    this.list_quest = {
      "0" : first_picture_quest
    }
  }

  translate_quest(id) {
    let quest = undefined;

    id = id[0].toString();
    if (typeof (quest = this.list_quest[id[0]]) !== "undefined")
      return (this.toString(quest[id[1]]));
    else
      return ("Cette quête n'existe pas :/");
  }

  man() {
    let ret = undefined;

    ret = "Vous pouvez utiliser les commandes suivantes : \n";
    ret += "- quest [liste toutes les quêtes actuels]\n";
    ret += "- help [pour voire toutes les commandes que vous pouvez tapez]\n";
    return (ret);
  }

  toString(quest) {
    let ret = undefined;
    if (typeof quest['title'] !== "undefined")
      ret = "==================\n" + quest['title'] + '\n\n';
    if (typeof quest['contexte'] !== "undefined" && typeof ret !== "undefined")
      ret += quest['contexte'] + '\n==================\n';
    return (ret);
  }

}
