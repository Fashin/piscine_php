(function() {
  /**
   * Var content all pictures on the articles right & left
   * @type {DOM}
   */
  var onglets = document.getElementsByClassName('img-article');

  var map_control = new MapControl();

  /**
   * Function to control the red border when mouse enter/leave on {onglet}
   * @return {void}
   */
  let red_border_control = (el) => {
    for (let i = 0; i < onglets.length; i++)
      if (onglets[i].classList.contains('selected'))
        onglets[i].classList.remove('selected');
    el.srcElement.classList.add('selected');
  }

  /**
   * Function to forward function, list advanced 1...7
   * @param  {DOM} el DOM element
   * @return {void}
   */
  let forward_map = (el) => {
    let value = parseInt(el.srcElement.getAttribute('actual'));
    let img = document.getElementsByClassName('img-main')[0];
    value++;
    if (value == 8)
      value = 1;
    img.setAttribute('src', 'ressources/forward/' + value + '.png')
    el.srcElement.setAttribute('actual', value);
  }

  let talk_control = (el) => {
    map_control.init_div(parseInt(document.getElementsByClassName('arrow')[0].getAttribute('actual')));
  }

  /**
   * Binding de touts les events on the differents articles
   * @param  {DOM} let onglet (contains all onglet by articles)
   * @return {void}     Only a binding of differents functions
   */
  for (let i = 0; i < onglets.length; i++)
  {
    onglets[i].addEventListener('mouseover', red_border_control);
    if (onglets[i].classList.contains('arrow'))
      onglets[i].addEventListener('click', forward_map);
    else if (onglets[i].classList.contains('talk'))
      onglets[i].addEventListener('click', talk_control);
  }

})();
