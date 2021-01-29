//init datepicker
let endDate = document.getElementById('endDate')
/*const picker = datepicker('#endDate',{
    formatter:(endDate, date, instance)=>{
        const value = date.toLocaleDateString()
        endDate.value=value
    }
})*/const picker = datepicker('#endDate')

let deleteBtn = document.querySelectorAll('deleteBtn')
let table = document.getElementById('tasksTable');
let error = document.getElementById('error')
let tBody = document.getElementById('tasksTable');
let searchByName = document.getElementById('searchByName')
let searchByTaskName = document.getElementById('searchByTaskName')
let form = document.forms.taskForm;
let data;
let inputEmail = document.getElementById('email');

const mask = '____@_____.com'
/*inputEmail.value=mask;
inputEmail.addEventListener('click',(e)=>{
    let dotPos = inputEmail.value.indexOf('@');

})*/
Inputmask({ regex:"^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$"}).mask(inputEmail);
form.addEventListener('submit', (e)=>{
    e.preventDefault()
    error.innerHTML='';
    let formData = new FormData(form);
    let request = new XMLHttpRequest();
    request.open("POST", '../Controllers/TaskController.php');
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200){

            console.log(request.response)
            let data = JSON.parse(request.response);
            if(data.status=='failed'){
                console.log(request.response)
                error.innerHTML=data.error
            }
            else{
            table.innerHTML+=`
                    <tr data-id=${data.id}>
                        <th scope="row">${data.name}</th>
                        <td>${data.task_name}</td>
                        <td>${data.creation_date}</td>
                        <td>${data.end_date}</td>
                        <td>${data.task_desc}</td>
                        <td><button type="button" class="btn btn-dark" id="deleteBtn" onclick="deleteTask(${data.id});">Delete</button></td>
                    </tr>
                `
            }
        }
    }
    request.send(formData);
    //sortByEndDate()
})

function deleteTask(id){
    console.log('work delete')
    let el=document.querySelector('tr[data-id="'+id+'"]')
    let formData = new FormData();
    formData.append('id', id)
    let request = new XMLHttpRequest();
    request.open("GET", '../Controllers/TaskController.php?id='+id);
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200){
            el.remove()
        }
    }
    request.send();
}

function loadTasks(){
    console.log('work load')
    let request = new XMLHttpRequest();
        request.open("GET", '../Controllers/TaskController.php');
        request.onreadystatechange = function () {
            if (request.readyState == 4 && request.status == 200){
                console.log(request.response)
                let data = JSON.parse(request.response);
                data.forEach(element => {
                    if(request.response!=''){
                    table.innerHTML+=`
                        <tr data-id=${element.id}>
                            <th scope="row">${element.name}</th>
                            <td>${element.task_name}</td>
                            <td>${element.creation_date}</td>
                            <td class="endDate">${element.end_date}</td>
                            <td>${element.task_desc}</td>
                            <td><button type="button" class="btn btn-dark" id="deleteBtn" onclick="deleteTask(${element.id});">Delete</button></td>
                        </tr>
                    `
            }   
                });
            }
        }
        request.send();
}

let ascending =false;
function sortByDate(cellNumber){

    let tasks = document.getElementsByTagName('tr');
    let sortedRows = Array.from(tasks)
    .slice(0)
    .sort((rowA, rowB) =>{ 
        let transformDayA = rowA.cells[cellNumber].innerText.split('.')
        let transformDayB = rowB.cells[cellNumber].innerText.split('.')
        let dateA = new Date(transformDayA[2], transformDayA[1], transformDayA[0]), dateB=new Date(transformDayB[2], transformDayB[1], transformDayB[0])
        //return dateA-dateB
        if(!ascending)
            return dateA-dateB
        else 
            return dateB-dateA
    } 
    )
    tBody.append(...sortedRows);
    ascending=!ascending
    console.log(ascending + " ASC")
}

function search(cellNumber, searchField){
    searchField.addEventListener('keydown', (e)=>{
        if(e.keyCode==13){
            let tasks = document.getElementsByTagName('tr');
            //let neededRows=Array.from(tasks).slice(1).filter(item=>item.cells[0].innerText.toLowerCase()==search.value.toLowerCase());
            let neededRows=Array.from(tasks).slice(1).filter((item)=>{
                let name=item.cells[cellNumber].innerText.split(' ')
                for (let i = 0; i < name.length; i++) {
                    if(name[i].toLowerCase()==searchField.value.toLowerCase()){
                        console.log(item)
                        return item
                    }    
                }
            })
            tBody.innerHTML=''
            tBody.append(...neededRows);
        
            if(searchField.value=='')
                loadTasks()
        }
    })
}
search(0, searchByName)
search(1, searchByTaskName)
loadTasks();
