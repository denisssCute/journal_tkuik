//главные действующие лица, всевозможные инпуты,текстовые поля для переброски данных в другие формы
let title_disciplina = document.querySelector('#title_disciplina');
let group_number = document.querySelector('#group_number');
let disciplina = document.querySelector("[name='disciplina_name']");
let name_for_js = document.querySelectorAll('.name_for_js');
let toSQLinput = document.querySelector('#toSQLinput');
let tableInv = document.querySelectorAll('.a');
let searchBtn = document.querySelector('.search_btn');
let updateBtn = document.querySelector('#updateBtn');
let selectUpdateGroup = document.querySelector('#selectUpdateGroup');
let nameList = {};

//счётчиковые переменные, мб какая-то из них нигда не используется, но лучше не удалять :)
let index = 0;
let id;
let formPersStat;
let list;
function showPersonStats(el) { //функция, вызывается при нажатии на студента и показывает справа таблицу со статистикой по всем предметам
        tableInv.forEach(item =>{item.classList.add('invisible');item.classList.remove('table-right')})
    
        id = el+'_persStat'
        formPersStat = document.getElementById(id)
        formPersStat.classList.remove('invisible')
        formPersStat.classList.add('table-right')
}
function putH(el) { //главная функция по "поимке" нажатия на графу в таблице(для того чтобы подготовить данные к отправке на изменение)
    el.innerHTML = 'Н'
    this.ondblclick = e => {el.innerHTML = '';  }
    Update(el)
} 
function Update(el) { // функция, отвечающая за определение, преобразование и подготовку к отправке данных на изменение. Вызывается в onlyH(el), алгоритм понятен только мне, я его придумал и называется он "костыль Дениса :)" 
    list = document.querySelectorAll('.'+el.classList)
    list.forEach(x => {
            let sqlid = x.className.split('_')[1];
            let numberTema = x.className.split('_')[2];
            let valueH = x.innerHTML;

            for (let i in nameList) { //оптимизация будущего JSON путём удаления повторяющихся действий для одной и тойже клетки, а после этого добавление последнего изменения(сложнааа объяснить)
                let listik = nameList[i];
                if (listik[0] == sqlid && listik[1] == numberTema) {
                    delete nameList[i]
                }
            }

            nameList[index] = [sqlid,numberTema,valueH];
            index++;
            toSQLinput.value = nameList;
            toSQL();
        })
        console.log(toSQLinput.value)
}
function toSQL() { //функция превращающая список со всеми изменениями в json
    toSQLinput.innerHTML = JSON.stringify(nameList)
    toSQLinput.value = JSON.stringify(nameList)
}
function SaveValueDiscLS(el) { // косметическая функция
    localStorage.setItem(el.name, el.value);
}
function clsc() { //эта функция нигде не используется, но как память оставлю, когда-то она реализовывала обработку изменённых даннных для отправки на сервак(данный подход не подошёл)
    name_for_js.forEach(element => {
        element.childNodes.forEach(
            el => {
                nameList.push(el.nodeValue)
            }
        )
   });
   let textarea = document.querySelectorAll('textarea')
   nameList.forEach(namePers => {
    let count = 0;
    for (count = 0; count < 50; count++) {
        let valueText = textarea[count].value
        let classText = textarea[count].classList
        console.log("у "+namePers +' class равен '+classText+' и значение '+valueText)
    }
    
   })
}
document.addEventListener("DOMContentLoaded", function(){ //по факту косметическая функция, вызывающаяся при загрузке страницы 
    let disciplinaName = document.querySelector('#disciplinaName');
    disciplinaName.innerHTML = localStorage.getItem('disciplina_name')
});
function showGroupAdd(el) {
    localStorage.setItem(el.name, el.value);
    let studItem = document.querySelectorAll('.stud-item')
    studItem.forEach(item => {
        item.classList.add('invisible')
    })
    let listGroupToAdd = document.querySelectorAll('.G'+el.value)
    listGroupToAdd.forEach(element => {
        element.classList.remove('invisible')
    });
}
function logout() {
    localStorage.removeItem('disciplina_name');
    localStorage.removeItem('group_number');
    localStorage.removeItem('selectedIndex');
    localStorage.removeItem('showGroupNumber');
}

group_number.innerHTML = localStorage.getItem('group_number'); // косметическая функция

let menuItems = document.querySelectorAll("nav ul li");

// Добавить обработчик событий для каждого элемента меню
menuItems.forEach(function(menuItem) {
    menuItem.addEventListener("mouseenter", function() {
        // Отобразить подменю при наведении на элемент меню
        let subMenu = this.querySelector("ul");
        if (subMenu) {
            subMenu.style.display = "block";
        }
    });
    menuItem.addEventListener("mouseleave", function() {
        // Скрыть подменю при уходе курсора с элемента меню
        let subMenu = this.querySelector("ul");

        if (subMenu) {
            subMenu.style.display = "none";
        }
    });
});

function showSettings() {
    const ul = document.getElementById('ul_settings');
    if (ul.style.display === 'none') {
        ul.style.display = 'block'; // показываем элемент, если он скрыт
    } else {
        ul.style.display = 'none'; // скрываем элемент, если он виден
    }
}

function a() {
    let showForm = document.getElementById('show_form');
    let inputGroup = document.getElementById('inputGroup')
    showForm.addEventListener('submit', (e) => {

        let selectSearchGroup = document.getElementById('search_group');
        
        if (selectSearchGroup.value === 'Группа' || inputGroup.value == '') {
            e.preventDefault()
        }
    })
}

function openMg_Ac_Win() {
    const mg_ac_win = document.querySelector('#manage_account_win');
    mg_ac_win.style.display = "flex"
}

function closeMg_Ac_Win() {
    const mg_ac_win = document.querySelector('#manage_account_win');
    mg_ac_win.style.display = "none"
}


// document.getElementsByTagName('input').forEach((i) => {
//     i.autocomplete = 'off';
// })
