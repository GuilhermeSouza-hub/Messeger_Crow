const fch = '<>/\\"' + "`#&| '"

function checkElement(el, mtd, elId, cpe=false) {
    if (mtd == "chr") {
        var charsInp = Array.from(new Set(el.value)).join("").concat(fch)
        var charsExp = Array.from(new Set(charsInp)).join("")
        var errorMes = document.createElement("div")

        charsInp = Array.from(charsInp)
        charsInp.sort()

        charsExp = Array.from(charsExp)
        charsExp.sort()

        errorMes.className = "error_mes"
        errorMes.id = elId

        if (document.querySelector("#" + elId)) {
            document.getElementById(elId).remove()
        }

        if ((charsInp.length != charsExp.length) && (elId != "psw")) {
            if (cpe) {
                errorMes.innerHTML = "Nossos corvos se recusam a levar estes caracteres."
                el.parentElement.parentElement.after(errorMes)
            }
            return false
        }
        else if ((el.value.length < 8) && elId == "psw") {
            if (cpe) {
                errorMes.innerHTML = "Nossos corvos não gostam de voar atoa. Coloque ao menos 8 caracteres."
                el.parentElement.parentElement.after(errorMes)
            }
            return false
        }
        else if (el.value == "") {
            if (cpe) {
                errorMes.innerHTML = "Nossos corvos não gostam de voar atoa. Adicione algum caracter."
                el.parentElement.parentElement.after(errorMes)
            }
            return false
        }
        else {
            return true
        }
    }
    else {
        if (el.method != "post") {
            if (cpe) {
                document.getElementById("error_pup").style.display = "flex"
            }
            return false
        }
        return true
    }
}

function trySubmit() {
    if (checkAll()) {
        document.getElementById("form").submit()
    }
}

function checkAll() {
    const usr = document.getElementById("usuario")
    const psw = document.getElementById("senha")
    const frm = document.getElementById("form")

    const verify1 = checkElement(usr, "chr", "usr")
    const verify2 = checkElement(psw, "chr", "psw")
    const verify3 = checkElement(frm, "frm", "frm")

    const verifys = [verify1, verify2, verify3]
    const infos = [[usr, "chr", "usr"], [psw, "chr", "psw"], [frm, "frm", "frm"]]

    for (var i = 0; i <= 2; i++) {
        if (!verifys[i]) {
            var info = infos[i]
            checkElement(info[0], info[1], info[2], true)
            break
        }
    }

    if (verify1 && verify2 && verify3) {
        return true
    }
    return false
}

function closeErrorPup() {
    document.getElementById("error_pup").style.display = "none"
}


