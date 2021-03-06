class PopUp {

  constructor()  {
    this.pop_up = document.getElementsByClassName('pop_up')[0];
    this.close = this.pop_up.children[0];
    this.close.addEventListener('click', this.close_pop_up);
  }

  show(text) {
    if (typeof text === "undefined")
      this.close_pop_up();
    else
    {
      this.pop_up.children[1].innerHTML = text;
      this.pop_up.classList.remove("hide");
      this.pop_up.classList.add("show");
    }
  }

  cleans() {
    for (let i = 2; i < this.pop_up.children.length; i++)
      this.pop_up.children[i].remove();
  }

  close_pop_up() {
    pop_up.pop_up.classList.remove("show");
    pop_up.pop_up.classList.add("hide");
    pop_up.cleans();
  }

  add_element(type, content, attribute = undefined, binding = undefined) {
    let new_el = document.createElement(type);
    new_el.innerHTML = content;
    if (typeof attribute !== "undefined")
      for (let key in attribute)
        new_el.setAttribute(key, attribute[key]);
    if (typeof binding !== "undefined")
      binding(new_el);
    this.pop_up.appendChild(new_el);
  }

}
