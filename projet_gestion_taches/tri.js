"use strict"
//trierPar: trie les element dasn un tableau 
function trierPar(colonne){
    //recupere le tableau
   const tab = document.querySelector("table");

   //recupere toutes lignes
   const lignes = Array.from(tab.querySelectorAll("tr:not(:first-child)"));

   //trie les lignes selon la colonne
   lignes.sort(function(a,b){
        const celluleA = a.querySelectorAll("td")[colonne].innerText;
        const celluleB = b.querySelectorAll("td")[colonne].innerText;
        if( celluleA < celluleB) return  -1;
        if(celluleA > celluleB) return 1;

        return 0

});
lignes.forEach(ligne => tab.appendChild(ligne));
}