<?php

  $json = '{
  	"player1": {
  		"race": "humain",
  		"ship": {
  			"Honorable_Duty": {
  				"id": 1,
  				"height": 1,
  				"width": 4,
  				"armes": {
  					"Batteries_laser_de_flancs": {
  						"charge": 0,
  						"pc": [0, 10],
  						"pi": [11, 20],
  						"pl": [21, 30],
  						"description": "Tir un cône seulement sur les flancs"
  					}
  				},
  				"vitesse": 15,
  				"bouclier": 0,
  				"pos_x": 0,
  				"pos_y": 0,
  				"health": 5,
  				"health_max": 5,
  				"manoeuvre": 4,
  				"pp": 15
  			},
  			"Absolution": {
  				"id": 2,
  				"height": 1,
  				"width": 3,
  				"armes": {
  					"Batteries_laser_de_flancs": {
  						"charge": 0,
  						"pc": [0, 10],
  						"pi": [11, 20],
  						"pl": [21, 30],
  						"description": "Tir un cône seulement sur les flancs"
  					}
  				},
  				"vitesse": 18,
  				"bouclier": 0,
  				"pos_x": 0,
  				"pos_y": 0,
  				"health": 5,
  				"health_max": 5,
  				"manoeuvre": 3,
  				"pp": 10
  			}
  		}
  	},
  	"player2": {
  		"race": "Ork",
  		"ship": {
  			"Ravajeur": {
  				"id": 3,
  				"height": 4,
  				"width": 2,
  				"armes": {
  					"Flingoz" : {
  						"charge": 0,
  						"pc": [0, 10],
  						"pi": [11, 20],
  						"pl": [21, 30],
  						"description" : "Tir pas loins mais bon"
  					}
  				},
  				"vitesse": 19,
  				"bouclier": 0,
  				"pos_x": 0,
  				"pos_y": 0,
  				"health_max": 4,
          "health": 4,
  				"manoeuvre": 3,
  				"pp": 10
  			},
  			"Explozeur": {
  				"id": 4,
  				"height": 1,
  				"width": 5,
  				"armes" : {
  					"Bazoogrot": {
  						"charge": 0,
  						"pc": [0, 20],
  						"pi": [21, 30],
  						"pl": [31, 40],
  						"description": "Tir en avant des dechets"
  					}
  				},
          "vitesse": 19,
  				"bouclier": 0,
  				"pos_x": 0,
  				"pos_y": 0,
  				"health": 4,
          "health_max": 4,
  				"manoeuvre": 3,
  				"pp": 10
  			}
  		}
  	}
  }
';

  $content = json_decode($json, true);

  $error = file_put_contents('tmp/ship', serialize($content));

  var_dump($error);

?>
