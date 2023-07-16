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
    tr.classList.add('bg-slate-700')

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