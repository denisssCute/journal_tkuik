let countDisc = 0;
let jsonstr = {}


window.onload = function () {
    document.getElementById("jsoninput").value = "";
};

function addDisc() {
    const input = document.getElementById('inputDisc');
    let ulDisc = document.getElementById('ulDisc');
    if (input.value.trim().length != 0) {
        let li = document.createElement('li');
        li.appendChild(document.createTextNode(input.value.trim()));
        ulDisc.appendChild(li);
        ulDisc.appendChild(li);

        let jsoninput = document.getElementById('jsoninput')
        jsonstr[countDisc] = input.value.trim()
        jsoninput.value = JSON.stringify(jsonstr)
        countDisc++
        input.value = "";
    }
}

function addGroup() {
    const input = document.getElementById('inputGroup');
    let ulDisc = document.getElementById('ulGroup');
    if (input.value.trim().length != 0) {
        let li = document.createElement('li');
        li.appendChild(document.createTextNode(input.value.trim()));
        ulDisc.appendChild(li);
        ulDisc.appendChild(li);

        let jsoninput = document.getElementById('jsoninput')
        jsonstr[countDisc] = input.value.trim()
        jsoninput.value = JSON.stringify(jsonstr)
        countDisc++
        input.value = "";

    }

}

document.getElementById('to_main').addEventListener('click', (e) => {
    let name = document.getElementById('nameInput')
    name.value = name.value.trim()
    let login = document.getElementById('login')
    login.value = login.value.trim()
    let password = document.getElementById('password')
    password.value = password.value.trim()

    if (name.value.trim() === "") {
        // alert('Введите имя')
        e.preventDefault();
    }
    if (login.value.trim() === "") {
        // alert('Введите логин')
        e.preventDefault();
    }
    if (password.value.trim() === "") {
        // alert('Введите пароль')
        e.preventDefault();
    }
})

document.getElementById('create_pasport').addEventListener('click', e => {
    let hours = document.getElementById('inputHours')
    hours.value = hours.value.trim()
})


function addStudent() {
    const input = document.getElementById('inputGroup');
    let ulDisc = document.getElementById('ulGroup');
    if (input.value.trim().length != 0) {
        let li = document.createElement('li');
        li.appendChild(document.createTextNode(input.value.trim()));
        ulDisc.appendChild(li);
        ulDisc.appendChild(li);

        let jsoninput = document.getElementById('jsoninput')
        jsonstr[countDisc] = input.value.trim()
        jsoninput.value = JSON.stringify(jsonstr)
        countDisc++
        input.value = "";

    }

}
