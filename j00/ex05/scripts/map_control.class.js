class MapControl {

  /**
   * Only create an array to contain the class and the text to get by json
   * @return {void}
   */
  constructor(){
    this.div_class = {
      0 : ['women-1', 'men-1', 'men-2', 'women-2', 'women-3', 'women-4', 'women-5', 'group-1']
    };
  }

  /**
   * Get on the json from click on hitbox of a interract talk picture, get the class name
   * and get the correspond json, get the question and the possibles answer, bind an
   * event listener and the answer who re-active this function recursivly.
   * @param  {DOM} el      Parent element who call the interractive pictures
   * @param  {Number} [num=0] Number to search on the json
   * @return {void}
   */
  put_text_interract(el, num = 0) {
    pop_up.cleans();
    el = (typeof el.srcElement !== "undefined") ? el.srcElement : el[0];

    let name = el.getAttribute('class').split(' ')[1];
    let json = undefined;
    let text = undefined;
    json = (typeof first_picture_text[name] !== "undefined") ? first_picture_text[name][num] : undefined;
    if (typeof json !== "undefined")
    {
      text = json['q'];
      let answer = json['a'];
      for (let key in answer)
        pop_up.add_element('a', answer[key][0], {"href" : "#", "class": "reponse", "goto": answer[key][1], "parent" : name}, (new_el) => {
          new_el.addEventListener('click', () => {
            pop_up.cleans();
            let el = document.getElementsByClassName(new_el.getAttribute('parent'))
            new MapControl().put_text_interract(el, new_el.getAttribute('goto'));
          });
        });
    }
    else
      text = "Je n'ai rien à te raconter fuit ! J'ai du travail moi";
    pop_up.show(text);
  }

  /**
   * Create a div element for insert on the div interract on main picture
   * @param  {String} class_name class_name get from the div_class declare on constructor
   * @return {DOM}            Div with class 'invisible' & <class_name> get on parameter
   */
  create_element(class_name)
  {
    pop_up.cleans(1);
    let div = document.createElement('div');
    div.className = 'invisible ' + class_name;
    div.setAttribute('talk', '0');
    div.addEventListener('click', this.put_text_interract);
    return (div);
  }

  /**
   * Function to put the hit-box on talk interract
   * @param  {int} img_actual The actual picture display on main
   * @return {void}            Only create the div who contain the hit box
   */
  init_div (img_actual){
    let block_interract = document.getElementsByClassName('interract-block')[0];
    for (let i = 0; i < this.div_class[img_actual].length; i++)
      block_interract.appendChild(this.create_element(this.div_class[img_actual][i]));
  }
}
