
/**
 * Global variable to control the interract map, create a pop_up and new user
 * @type {MapControl}
 */
var user = new Users();

var map_control = new MapControl();

var pop_up = new PopUp();

/**
 * Function to init the div of interraction with npc talk
 * @param  {DOM} el useless params, only add by addEventListener
 * @return {void}
 */
let talk_control = (el) => {
  map_control.init_div(document.getElementsByClassName('arrow')[0].getAttribute('actual'));
};

/**
 * Function to forward function, list advanced 1...7
 * @param  {DOM} el DOM element
 * @return {void}
 */
let forward_map = () => {
  let arrow = document.getElementsByClassName('arrow')[0];
  let value = arrow.getAttribute('actual').toString();
  let img = document.getElementsByClassName('img-main')[0];

  if (typeof img.getAttribute('quest') !== typeof null)
  {
    let new_picture = parseInt(value[1]) + 1;
    let quest_name = img.getAttribute('quest');
    value = value[0] + new_picture;
    if (new_picture < 3)
      img.setAttribute('src', 'ressources/quest_map/' + quest_name + '/' + new_picture + '.png');
    else if (new_picture == 3)
    {
      img.setAttribute('src', 'ressources/cluster.jpg');
      img.removeAttribute('quest');
      value = 0;
    }
  }
  else
  {
    value = parseInt(value);
    value++;
    if (value < 8)
      img.setAttribute('src', 'ressources/forward/' + value + '.png')
    else if (value == 8)
    {
      img.setAttribute('src', 'ressources/cluster.jpg');
      value = 0;
    }
  }
  map_control.cleans_div_interract();
  arrow.setAttribute('actual', value);
}
