/**
 * Global variable to control the interract map, create a pop_up and new user
 * @type {MapControl}
 */
var map_control = new MapControl();

var user = new Users();

var pop_up = new PopUp();

/**
 * Function to init the div of interraction with npc talk
 * @param  {DOM} el useless params, only add by addEventListener
 * @return {void}
 */
let talk_control = (el) => {
  map_control.init_div(parseInt(document.getElementsByClassName('arrow')[0].getAttribute('actual')));
};

/**
 * Function to forward function, list advanced 1...7
 * @param  {DOM} el DOM element
 * @return {void}
 */
let forward_map = () => {
  let arrow = document.getElementsByClassName('arrow')[0];
  let value = parseInt(arrow.getAttribute('actual'));
  let img = document.getElementsByClassName('img-main')[0];

  value++;
  if (typeof img.getAttribute('quest') !== typeof null)
  {
    let quest_name = img.getAttribute('quest');
    if (value < 3)
      img.setAttribute('src', 'ressources/quest_map/' + quest_name + '/' + value + '.png');
    else if (value == 3)
      console.log("you are at the end of quest");
  }
  else
  {
    if (value < 8)
      img.setAttribute('src', 'ressources/forward/' + value + '.png')
    else if (value == 8)
    {
      img.setAttribute('src', 'ressources/cluster.jpg');
      value = 0;
    }
    map_control.cleans_div_interract();
  }
  console.log(arrow);
  arrow.setAttribute('actual', value);
}
