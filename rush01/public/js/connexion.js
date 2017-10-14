(function(){

  $('.submit').on('click', (event) => {
    let login = $('.login').val();
    let psswd = $('.password').val();

    if (login.length == 0 || psswd.length == 0)
      return (false);
    $.ajax({
      method: "POST",
      url: "../../controller/connexion.php",
      data: {login: login, psswd: psswd},
    }).done((msg) => {
      console.log(msg);
    });
  })

})();
