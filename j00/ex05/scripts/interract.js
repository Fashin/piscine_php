(function() {
  /**
   * Var content all pictures on the articles right & left
   * @type {DOM}
   */
  var onglets = document.getElementsByClassName('img-article');

  /**
   * Array to create the binding with parameters:
   * Key : class needed for binding
   * array[0] : type of event listener
   * array[1] : function needed for calling
   * @type {Object}
   */
  var interract_function = {
    "arrow" : ["click", forward_map],
    "talk" : ["click", talk_control],
    "use" : ["click", talk_control]
  };

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
   * Binding de touts les events on the differents articles
   * @param  {DOM} let onglet (contains all onglet by articles)
   * @return {void}     Only a binding of differents functions
   */
  for (let i = 0; i < onglets.length; i++)
  {
    let actual_class = onglets[i].classList[1];
    Object.keys(interract_function).find((name) => {
      if (name == actual_class)
        onglets[i].addEventListener(interract_function[name][0], interract_function[name][1]);
    });
    onglets[i].addEventListener('mouseover', red_border_control);
  }

})();
