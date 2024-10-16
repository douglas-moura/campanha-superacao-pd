auth = sessionStorage.getItem("sessao_iniciada")

let senha = undefined
let token = undefined

fetch('../api/acesso-cliente/index.json')
    .then((response) => response.json())
    .then((data) => {
        senha = data.senhaCliente
        token = data.authToken

        if(auth == token) {
            let pelicula = document.querySelector("div#pelicula-cliente")
            pelicula.style.display = "none"
        } else {
            let cod_acesso = prompt("Código de Acesso:")
            if(cod_acesso == senha) {
                alert("Acesso liberado");
                sessionStorage.setItem("sessao_iniciada", token)

                let pelicula = document.querySelector("div#pelicula-cliente")
                pelicula.style.display = "none"
            } else {
                alert("Código Incorreto")
                window.location.reload(true);
            }
        }
    })

function abrirDrop(id) {
    let linha_sup = document.querySelector("tr#linha-" + id)
    let linha_geral_sup = document.getElementsByClassName("linha-superior")
    let linha_inf = document.querySelector("tr#linha-drop-A-" + id)
    let linha_inf_B = document.querySelector("tr#linha-drop-B-" + id)
    let linha_geral_infsA = document.getElementsByClassName("drop-down-dados")
    let linha_geral_infsB = document.getElementsByClassName("drop-down-infos")
    let seta = document.querySelector("svg#seta-" + id)
    let seta_geral = document.getElementsByClassName("seta")

    // abre o drop-down
    if(linha_inf.style.display != "table-row") {
        linha_sup.style.backgroundColor = "var(--cor-1-filtro) !important"
        linha_sup.style.fontWeight = 800
        linha_sup.style.borderTop = ".2rem solid var(--cor-1) !important"
        linha_inf.style.display = "table-row"
        linha_inf_B.style.display = "table-row"
        seta.style.transform = "rotate(90deg)"
        
        // fecha o drop-down que ja esta aberto
        for(let i = 0; i < linha_geral_sup.length; i++) {
            if(linha_geral_sup[i].getAttribute("id").substr(5) != linha_inf.id.substr(12)) {
                linha_geral_sup[i].style.backgroundColor = "var(--cinza-2) !important"
                linha_geral_sup[i].style.fontWeight = "normal"
                linha_geral_sup[i].style.borderTop = ".1rem  solid var(--cinza-3) !important"
                linha_geral_infsA[i].style.display = "none"
                linha_geral_infsB[i].style.display = "none"
                seta_geral[i].style.transform = "rotate(0)"
            }
        }
    // fecha o drop-down
    } else {
        linha_sup.style.backgroundColor = "var(--cinza-2)"
        linha_sup.style.fontWeight = "normal"
        linha_sup.style.borderTop = ".1rem  solid var(--cinza-3) !important"
        linha_inf.style.display = "none"
        linha_inf_B.style.display = "none"
        seta.style.transform = "rotate(0)"
    }
}

function mostrarImgProd(id) {
    let img_pedido = document.querySelector("img.img-pedido-" + id)

    if(img_pedido.style.display != "block") {
        img_pedido.style.display = "block"
    } else {
        img_pedido.style.display = "none"
    }
}

function sairCliente() {
    sessionStorage.removeItem("sessao_iniciada")
    window.location.replace("/")
}