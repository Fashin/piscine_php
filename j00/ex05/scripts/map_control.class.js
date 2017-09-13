class MapControl {

  /**
   * Only create an array to contain the class and the text to get by json
   * @return {void}
   */
  constructor(){
    this.div_class = {
      0 : {
        0 : ['women-1', 'pnj'],
        1 : ['men-1', 'pnj'],
        2 : ['women-2', 'pnj'],
        3 : ['women-3', 'pnj'],
        4 : ['women-4', 'pnj'],
        5 : ['women-5', 'pnj'],
        6 : ['group-1', 'pnj']
      },
      4 : {
        0 : ['doors-1', 'quest', 'coffee']
      }
    };
    this.dialogue = [first_picture_text];
  }

  /**
   * Usual function to get the actual picture on main
   * Create to get the json from this.dialogue
   * @return {int} number of the actual picture
   */
  get_actual_picture() {
    let picture = document.getElementsByClassName('img-main')[0];
    let num = picture.getAttribute('src').split('/')[1].split('.')[0];
    if (num == "cluster")
      num = 0;
    return (this.dialogue[num]);
  }

  /**
   * Get on the json from click on hitbox of a interract talk picture, get the class name
   * and get the correspondant json, get the question and the possibles answer, bind an
   * event listener and the answer who re-active this function recursivly.
   * @param  {DOM} el      Parent element who call the interractive pictures
   * @param  {Number} [num=0->7] Number to search on the json
   * @return {void}
   */
  put_text_interract(el, num = 0) {
    pop_up.cleans();
    el = (typeof el.srcElement !== "undefined") ? el.srcElement : el[0];
    let name = el.getAttribute('class').split(' ')[1];
    let json = undefined;
    let text = undefined;
    json = (typeof map_control.get_actual_picture()[name] !== "undefined") ? first_picture_text[name][num] : undefined;
    if (typeof json !== "undefined")
    {
      if (typeof json["adding_quest"] !== "undefined")
        user.adding_new_quest(json["adding_quest"]["id"]);
      else
      {
        text = json['q'];
        let answer = json['a'];
        for (let key in answer)
          pop_up.add_element('a', answer[key][0], {"href" : "#", "class": "reponse", "goto": answer[key][1], "parent" : name}, (new_el) => {
            new_el.addEventListener('click', () => {
              pop_up.cleans();
              let el = document.getElementsByClassName(new_el.getAttribute('parent'))
              map_control.put_text_interract(el, new_el.getAttribute('goto'));
            });
          });
      }
    }
    else
      text = "Je n'ai rien à te raconter fuis ! J'ai du travail moi";
    pop_up.show(text);
  }

  starting_quest(){
    let object_name = map_control.div_class[this.getAttribute('object')][this.getAttribute('uid')];

    let img_main = document.getElementsByClassName('img-main')[0];
    img_main.setAttribute('src', 'ressources/quest_map/' + object_name[2] + '/0.png');
    img_main.setAttribute('quest', object_name[2]);
    document.getElementsByClassName('arrow')[0].setAttribute('actual', '0');
  }

  /**
   * Create a div element for insert on the div interract on main picture
   * @param  {String} class_name class_name get from the div_class declare on constructor
   * @return {DOM}            Div with class 'invisible' & <class_name> get on parameter
   */
  create_element(object_name)
  {
    pop_up.cleans();
    let div = document.createElement('div');
    div.className = 'invisible ' + object_name[0];
    if (object_name[1] == 'pnj')
    {
      div.setAttribute('talk', '0');
      div.addEventListener('click', this.put_text_interract);
    }
    else if (object_name[1] == 'quest')
    {
      div.setAttribute('object', '4');
      div.setAttribute('uid', '0');
      div.addEventListener('click', this.starting_quest);
    }
    return (div);
  }
  /**
   * Usual function to clean the div who create the hit box
   * @return {[type]} [description]
   */
  cleans_div_interract() {
    let div = document.getElementsByClassName('interract-block')[0];
    for (let i = 0; i < div.children.length; i++)
      div.children[i].remove();
  }

  /**
   * Function to put the hit-box on talk interract
   * @param  {int} img_actual The actual picture display on main
   * @return {void}            Only create the div who contain the hit box
   */
  init_div (img_actual){
    let block_interract = document.getElementsByClassName('interract-block')[0];
    this.cleans_div_interract();
    if (typeof this.div_class[img_actual] !== "undefined")
      for (let i = 0; i < Object.keys(this.div_class[img_actual]).length; i++)
        block_interract.appendChild(this.create_element(this.div_class[img_actual][i]));
  }
}
