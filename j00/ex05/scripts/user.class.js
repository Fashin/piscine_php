class Users extends Quest{

  constructor() {
    super();
    this.actual_quest = [];
    this.commands = {
      "quest" : this.get_quest,
      "add_quest" : this.adding_new_quest,
      "help" : this.man
    };
  }

  adding_new_quest (id) {
    user.actual_quest.push(id);
  }

  get_quest() {
    if (user.actual_quest.length > 0)
      return (user.translate_quest(user.actual_quest));
    else
      return ("Vous n'avez pas encore choisit de quête");
  }
}
