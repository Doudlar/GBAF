// Affichage du champ commentaire au click sur nouveau commentaire
  function ajout_com() {
     document.getElementById("ajout_com").style.display="block";
     console.log("toto");
}

document.getElementById("lien_commentaire").addEventListener("click", ajout_com);