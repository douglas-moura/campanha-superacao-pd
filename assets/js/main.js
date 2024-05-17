/*
const urlAtual = window.location.href;
if(urlAtual === 'http://localhost/maxx/default/maxx-premios-v2/') {
    var bodySite = document.getElementsByTagName('body');
    bodySite[0].style.height = '100vh';
}
*/

// Acordeão da tabela de pontos
function abrirAcordeao(id) {
    var linhaSuperior = id.length == 11 ? id.slice(0, -7) : id.slice(0, -8);
    var acordeao = document.querySelector("input#" + id);
    var num = id.substring(10)
    var seta = document.querySelector("svg.seta_" + num);
    var panel = acordeao.nextElementSibling;
    var pai = acordeao.parentNode;    
    if (panel.style.display === "block") {
        panel.style.display = "none";
        if (linhaSuperior == 'acco') {
            pai.style.background = "white";
            seta.style.transform = "rotate(0deg)";  
        }
    } else {
        panel.style.display = "block";
        if (linhaSuperior == 'acco') {
            pai.style.background = "#f3f3f3";
            seta.style.transform = "rotate(90deg)";            
            var linhasTotal = document.querySelectorAll("#linha");
            for (var i = 0; i < linhasTotal.length; i++) {
                var acordeaoClose = document.querySelector("input#accordion-" + i);
                var panelClose = acordeaoClose.nextElementSibling;
                var paiClose = acordeaoClose.parentNode;
                var setaClose = document.querySelector("svg.seta_" + i);

                if (acordeaoClose != acordeao) {
                    panelClose.style.display = "none";
                    paiClose.style.background = "white";
                    setaClose.style.transform = "rotate(0deg)"; 
                }
            }
        }
    }
}