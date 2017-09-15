class Quest {

  constructor ()
  {

    this.quest = {
      "id" : ["0A", "coffee"]
    };

    this.list_quest = {
      "0" : first_picture_quest
    }
  }

  translate_quest(id)
  {
    let quest = undefined;

    if (typeof id[0] !== "undefined")
    {
      id = id[0].toString();
      if (typeof (quest = this.list_quest[id[0]]) !== "undefined")
        return (this.toString(quest[id[1]]));
      else
        return ("Cette quête n'existe pas :/");
    }
    else
      return ("Vous n'avez pas encore de quête");
  }

  pre_requis (uid, map) {
    for (let key in this.list_quest[map]) {
      if (this.list_quest[map][key]['uid'] == uid) {
        return (this.list_quest[map][key]['pre_requis']);
      }
    }
    return (undefined);
  }

  have_quest(uid)
  {
    for (let i = 0; i < this.actual_quest.length; i++)
      if (this.actual_quest[i] == uid)
        return (1);
    return (0);
  }

  toString(quest)
  {
    let ret = undefined;
    if (typeof quest['title'] !== "undefined")
      ret = "==================\n" + quest['title'] + '\n\n';
    if (typeof quest['contexte'] !== "undefined" && typeof ret !== "undefined")
      ret += quest['contexte'] + '\n==================\n';
    return (ret);
  }

}
