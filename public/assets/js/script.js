let FIELDS = document.querySelector('form').querySelectorAll('[input]');

function checkValidation(e){
    let parent = e.target.parentNode.parentNode.querySelectorAll('div')
    
    parent.forEach(itm => {
        itm.querySelector('input').checked = false;
    })
    e.target.checked = true;
    
}
function Clear(e) {
    e.preventDefault();
    FIELDS.reset();
}

function ShowComments(e){
    let commentNode = e.target.parentNode.nextElementSibling
    let thead = e.target.parentNode.parentNode.previousElementSibling.querySelector('tr').children.length
    let tbody = e.target.parentNode.parentNode

    let value = e.target.querySelector('p').innerText;

    let tr = document.createElement('tr')
    tr.classList.add('commentRow')
    tr.classList.add('bg-slate-900')

    tr.innerHTML = `<td colspan="${thead}" class="py-2 px-4"><p>${value}</p></td>`
    if(commentNode){
        if(commentNode.classList.contains('commentRow')){
            tbody.removeChild(commentNode)
        }else{
            tbody.insertBefore(tr,commentNode)
        }
    }else{
        tbody.insertBefore(tr,commentNode)
    }
}

function FilterData(e,filterBy="all") {
    var input, filter, table, tbody, tr, td, i, txtValue, cell;
    input = e.target.value.toLowerCase();
    
    tbody = document.querySelector("tbody");
    tr = tbody.querySelectorAll("tr");
    

    if(filterBy == "date"){
        for (i = 0; i < tr.length; i++) {
            td = tr[i].querySelector(".date-val");
            if (td) {
                txtValue = td.innerText.includes(input);
                if (txtValue) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }else{
        for (i = 0; i < tr.length; i++) {
            tr[i].style.display = "none";
            td = tr[i].getElementsByTagName("td");
            
            for (j = 0; j < td.length; j++) {
                cell = td[j]

                if (cell) {
                    if (cell.innerText.toLowerCase().indexOf(input) > -1) {

                        tr[i].style.display = "";
                        break;
                    }else {
                        tr[i].style.display = "none";
                    }
                } 
            }
        }
    }
}