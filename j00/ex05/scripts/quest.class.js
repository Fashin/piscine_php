class Quest {

  constructor () {

    this.quest = {
      "id" : ["0A", "coffee"]
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

  have_quest(uid) {
    console.log(this.actual_quest);
    console.log(uid);
    for (let i = 0; i < this.actual_quest.length; i++)
      if (this.actual_quest[i] == uid)
        return (1);
    return (0);
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
