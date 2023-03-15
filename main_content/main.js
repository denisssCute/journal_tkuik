let allTextarea = document.querySelectorAll("textarea");
let allMainTableTh = document.querySelectorAll(".thMainTable");
let completeInput = document.querySelector('#completionInput'); //инупт с JSON, в котором находятся все темы

let jsonFromServer = document.querySelectorAll('.invisibleTextarea');
let json = jsonFromServer[0].defaultValue
json = JSON.parse(json)

allTextarea.forEach(el => {
    el.addEventListener("input", function() {
        let newValue = el.value.replace(/[^Н]/g, "");
        el.value = newValue;
    })
    el.addEventListener('keydown', e => {
        e.preventDefault();
    })
})

allMainTableTh.forEach(el => {
    el.addEventListener('click', e => {
        let modals = document.querySelectorAll('.modal');
        modals.forEach(el => {el.style.display = 'none';})

        let id = e.target.id
        id = id.replace('tema', '')
        const modal = document.querySelector('#modal'+id);
        const { top, left } = e.target.getBoundingClientRect();
        modal.style.top = `${top + window.scrollY + 40}px`;
        modal.style.left = `${left + window.scrollX - 20}px`;
        modal.style.display = 'block';

        const leftConent = document.querySelector('.left-content');
        leftConent.style.overflow = 'hidden';

        let closeBtn = modal.children[0].children[1] //ловим нажатие по кнопке закрытия модального окна
        closeBtn.addEventListener('click', e => {
            modal.style.display = 'none';
            leftConent.style.overflow = 'auto';
        })

        const completeBtn = modal.children[2]
        let compId = modal.children[2].id
        compIdForCage = Number(compId.replace('completeBtn','')) + 2
        completeBtn.addEventListener('click', e => { //ловим нажатие по кнопке завершения урока
            const date = document.querySelector('#input'+id).value;
            if (date != '') {
                let allTr = document.querySelectorAll('.trMainTable')
                allTr.forEach(elem => {
                    if (elem.childNodes[compIdForCage].tagName === 'TH') {
                        const th = elem.childNodes[compIdForCage].childNodes[0]
                        th.onclick = null
                    } else if (elem.childNodes[compIdForCage].tagName === 'TD') {
                        const txtarea = elem.childNodes[compIdForCage].childNodes[0]
                        txtarea.onclick = null
                        txtarea.readOnly = true
                        txtarea.style.background = `rgb(234, 234, 234)`
                    }
                    modal.style.display = 'none';
                    leftConent.style.overflow = 'auto';
                })
                prepareJSONtoSend(id,date)
                completeInput.value = JSON.stringify(json)
            }else {
                console.log('ВВЕДИТЕ ДАТУ')
            }
        })
    })
})

function prepareJSONtoSend(id,date) {
    const keyTema = 'tema_'+ id;
    json[keyTema]["complete"] = 1
    json[keyTema]["date"] = date
}

let today = new Date().toISOString().substr(0, 10); //ставим по умолчанию сегодняшнее число у инпута
const inputs = document.querySelectorAll(".inputComplete")
inputs.forEach(i => {
    i.value = today;
})

function putJsonInCompleteInput() {
}




