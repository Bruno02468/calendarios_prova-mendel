// para a página de criar calendários

if (window.localStorage) {
    if (localStorage["sala"]) document.getElementById("sala").value = localStorage["sala"];
    if (localStorage["numero"]) document.getElementById("chamada").value = localStorage["numero"];
    if (localStorage["moodle"]) document.getElementById("moodle").value = localStorage["moodle"];
    if (localStorage["primeironome"]) document.getElementById("nome").value = localStorage["primeironome"];
}

var err = document.getElementById("err");
var dia1 = document.getElementById("dia1");
var dia2 = document.getElementById("dia2");
var dia3 = document.getElementById("dia3");
var dia4 = document.getElementById("dia4");
var emptyOption = "<option value=\"none\">- - - - - - - - - - - - - - - - -</option>";


function getMateriaByNome(nome) {
    for (var i = 0; i < materias.length; i++) {
        if (materias[i].nome == nome) return i;
    }
}

function makeOption(materia) {
    return "<option value=\"" + materia.nome + "\">" + materia.nome + "</option>";
}

function makeOptionsWithLeft() {
    var res = "";
    for (var i = 0; i < materias.length; i++) {
        var materia = materias[i];
        if (materia.selected) continue;
        res += makeOption(materia);
    }
    return res + emptyOption;
}

var selectors = [];
for (var dia = 1; dia <= 4; dia++) {
    var diadiv = document.getElementById("dia" + dia);
    for (var selnum = 1; selnum <= 3; selnum++) {
        var selector = document.createElement("select");
        selector.setAttribute("id", "dia-" + dia + "-" + selnum);
        selector.setAttribute("name", "dia-" + dia + "-" + selnum);
        selector.setAttribute("onchange", "updateSelectors();");
        selector.innerHTML = makeOptionsWithLeft();
        selector.value = "none";
        diadiv.appendChild(selector);
        selectors.push(selector);
        diadiv.appendChild(document.createElement("br"));
    }
}

if (window.localStorage) {
    if (localStorage["calendario_salvo_unfail"]) {
        var unfailed = localStorage["calendario_salvo_unfail"].split(",");
        if (unfailed.length == selectors.length) {
            for (var i = 0; i < selectors.length; i++) {
                var selector = selectors[i];
                var val = unfailed[i];
                if ((getMateriaByNome(val) !== undefined) || (val == "none")) {
                    selector.value = val;
                }
            }
        }
    }
}

var dias = [[], [], [], []];
function updateSelectors() {
    for (var i = 0; i < materias.length; i++) {
        materias[i].selected = false;
    }
    dias = [[], [], [], []];
    for (var j = 0; j < selectors.length; j++) {
        var selector = selectors[j];
        if (selector.value == "none") continue;
        var matid = getMateriaByNome(selector.value);
        materias[matid].selected = true;
        var dia = selector.id[4];
        dias[dia-1].push(materias[matid]);
    }
    for (var k = 0; k < selectors.length; k++) {
        var selector = selectors[k];
        var prevVal = selector.value;
        if (prevVal !== "none") {
            selector.innerHTML = makeOption(materias[getMateriaByNome(selector.value)])
                + makeOptionsWithLeft();
        } else {
            selector.innerHTML = makeOptionsWithLeft();
        }
        selector.value = prevVal;
    }
    var vals = [];
    for (var i = 0; i < selectors.length; i++) {
        vals.push(selectors[i].value);
    }
    var strvals = vals.join(",");
    if (window.localStorage) {
        localStorage["calendario_salvo_unfail"] = strvals;
    }
}

function error(mensagem) {
    err.innerHTML = mensagem;
}

function checar() {
    updateSelectors();
    for (var i = 0; i < materias.length; i++) {
        if (!materias[i].selected) {
            error("Cadê a prova de " + materias[i].nome + "?");
            return false;
        }
    }
    for (var i = 0; i < dias.length; i++) {
        var dia = dias[i];
        if (dia.length == 0) {
            error("Nenhuma prova no " + (i+1) + "º dia?");
            return false;
        }
        if (dia.length == 1) {
            error("Só uma prova no " + (i+1) + "º dia?");
            return false;
        }
        var humanas = 0;
        var exatas = 0;
        var curtas = 0;
        for (var j = 0; j < dia.length; j++) {
            if (dia[j].curta) {
                curtas++;
            } else {
                switch (dia[j].natureza) {
                    case "i": humanas++; break;
                    case "h": humanas++; break;
                    case "b": exatas++; break;
                    case "e": exatas++; break;
                }
            }
        }

        if (humanas > 1) {
            error("Muitas humanas no " + (i+1) + "º dia...");
            return false;
        }
        if (exatas > 1) {
            error("Muitas exatas no " + (i+1) + "º dia...");
            return false;
        }
        if (curtas > 2) {
            error("Três provas curtas " + (i+1) + "º dia? Sério?");
            return false;
        }
        if (curtas == 2 && exatas + humanas == 0) {
            error("Só provas curtas " + (i+1) + "º dia? Sério?");
            return false;
        }
        if (exatas == 0) {
            error("Sem exatas no " + (i+1) + "º dia?");
            return false;
        }
        if (humanas == 0 && !ingles) {
            error("Sem humanas no " + (i+1) + "º dia?");
            return false;
        }
    }
    error("");
    if (window.localStorage) {
        localStorage["moodle"] = document.getElementById("moodle").value;
        localStorage["primeironome"] = document.getElementById("nome").value;
        localStorage["sala"] = document.getElementById("sala").value;
        localStorage["numero"] = document.getElementById("chamada").value;
    }
    return true;
}