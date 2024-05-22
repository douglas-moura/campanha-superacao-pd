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
    let linha_sup = document.querySelector("tr.linha-" + id)
    let linha = document.querySelector("tr#linha-drop-" + id)
    let seta = document.querySelector("svg#seta-" + id)
    let linha_geral_sup = document.getElementsByClassName("linha-superior")
    let linha_geral = document.getElementsByClassName("drop-down")
    let seta_geral = document.getElementsByClassName("seta")

    console.log(linha_sup)

    if(linha.style.display != "table-row") {
        linha_sup.style.fontWeight = 800
        linha.style.display = "table-row"
        seta.style.transform = "rotate(90deg)"

        for(let i = 0; i < linha_geral.length; i++) {
            if(linha_geral[i].getAttribute("id") != linha.id) {
                linha_geral_sup[i].style.backgroundColor = "var(--cinza-2)"
                linha_geral_sup[i].style.fontWeight = "normal"
                linha_geral[i].style.display = "none"
                seta_geral[i].style.transform = "rotate(0)"
            }
        }
    } else {
        linha_sup.style.backgroundColor = "var(--cinza-2)"
        linha_sup.style.fontWeight = "normal"
        linha.style.display = "none"
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