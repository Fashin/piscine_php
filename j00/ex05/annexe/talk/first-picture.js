var first_picture_text = {
    "women-1" : {
        "0" : {
          "q" : "Bonjour, comment allez vous ?",
          "a" : {
            "0" : ["Bien et vous ?", '1'],
            "1" : ["Test", 'A'],
          },
        },
        "1" : {
          "q" : "Très bien merci !",
          "a" : {
            "0" : ["deuxieme reponse", '0']
          },
        },
        "A" : {
          "q" : "Ok commençons la quête !",
          "a" : {
            "0" : ["Que dois-je faire ?", 'B']
          }
        },
        "B" : {
          "q" : "Commence donc par aller me chercher un café !",
          "a" : {
            "0" : ["Ok let's go !", "C"],
            "1" : ["Va si la flemme", "D"]
          }
        },
        "C" : {
          "adding_quest" : {
            "id" : "0A"
          }
        },
        "D" : {
          "q" : "C'est la vie, et dépéche toi !",
          "a" : {
            "0" : ["Ok c'est partie...", "C"],
            "1" : ["Nan c'est mort", "99"]
          }
        }
    },
    "men-1" : {
      "0" : {
        "q" : "Hey salut ! Que puis-je pour toi ?",
        "a" : {
          "0" : ["Salut, désolé de te déranger, mais réussir cette piscine me tiens beaucoup à coeur,<br> et j'aimerais savoir comment arrêter de joueur aux jeux vidéos pour m'investir pleinement...", "1"],
          "1" : ["Quelles sont les clés de la réussite d'une piscine ?", "2"],
          "2" : ["Est-ce que tu sais qui à inversé les couleurs sur mon écran ?? Et comment on fait pour l'enlever ?", "3"]
          }
      },
      "1" : {
        "q" : "Les réponses ce trouvent dans ton coeur, et ce n'est que là que tu pourras puiser la force dont tu as besoin pour couper court à ton addiction",
        "a" : {
          "0" : ["Ok super merci !", "0"]
        }
      },
      "2" : {
        "q" : "RTFM",
        "a" : {
          "0" : ["Franchement tu n'es pas sympa !", "99"]
        }
      },
      "3" : {
        "q" : "...",
        "a" : {
          "0" : ["Pourquoi tu ne veux pas me le dire ?", "99"]
        }
      }
    }
}
