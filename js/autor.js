const API = 'http://localhost:8000';
const token = '37d0d8c6c1c3842d0abc428dbc7a2fadd88c12e5';
const apiHeaders = new Headers();
apiHeaders.append('Content-Type', 'application/json');
apiHeaders.append('X-TOKEN', token);

const $btnActualizar = document.getElementById('loadAuthors');
const $tableBody = document.getElementById('table-body');

//Save
const $btnSave = document.getElementById('authorSave');
let $url = document.getElementById('url');
let $persona = document.getElementById('persona');
const $btnUpdate = document.getElementById('authorUpdate');
const $btnDelete = document.getElementById('authorDelete');
let $eliminar = document.getElementById('eliminar')
let $actualizar = document.getElementById('act');

$btnActualizar.addEventListener('click', async function(){
    const authors = await getAuthors();
    let authorRowHtml = '';
    for (let index = 0; index < authors['data'].length; index++) {
        authorRowHtml += `<tr>
        <td><div>${Object(authors.data[index]['url_web'])}</div></td>
        <td><div>${Object(authors.data[index]['id'])}</div></td>
        <td>
            <div class="actions">
                <button><i class="far fa-edit"></i></button>
                <button><i class="far fa-trash-alt"></i></button>
            </div>
        </td>
        </tr>`;
    }
    $tableBody.innerHTML = authorRowHtml;
});

$btnSave.addEventListener('click', async function(){
    let author = {
        'url_web' : $url.value,
        'id_persona' : $persona.value
    };
    const authorCreated = await setAuthor(author);
    if(authorCreated) {
        $tableBody.insertRow(-1).innerHTML = authorItemTemplate(author);
    }
});

$btnUpdate.addEventListener('click', async function(){
    let author = {
        'url_web' : $url.value,
        'id_persona' : $persona.value
    }
    const authorCreated = await updateAuthor($actualizar.value,author);
});

$btnDelete.addEventListener('click', async function(){
    const authorCreated = await deleteAuthor($eliminar.value);
})

async function getAuthors(id){
    const apiURL = id ? `${API}/authors/${id}` : `${API}/authors`;
    const init = {
        method: 'GET',
        headers: apiHeaders
    }
    try {
        const response = await fetch(apiURL,init);
        const data = await response.json();
        return data;
    }catch (err) {
        console.log('Error al obtener los autores',err);
    }
    
}

async function setAuthor(author){
    const apiURL = `${API}/authors`;
    const init = {
        method: 'POST',
        headers: apiHeaders,
        body: JSON.stringify(author)
    }
    try {
        const response = await fetch(apiURL,init);
        const data = await response.json();
        return data;
    }catch(err) {
        console.log('Error al enviar autor', err);
    }
}

async function updateAuthor(id,author){
    const apiURL = `${API}/authors/${id}`;
    const init = {
        method: 'PUT',
        headers: apiHeaders,
        body: JSON.stringify(author)
    }
    try {
        const response = await fetch(apiURL,init);
        const data = await response.json();
        return data;
    }catch(err) {
        console.log('Error al enviar nuevo autor', err);
    }
}

async function deleteAuthor(id){
    const apiURL =`${API}/authors/${id}`;
    const init = {
        method: 'DELETE',
        headers: apiHeaders
    }
    try {
        const response = await fetch(apiURL,init);
        const data = await response.json();
        return data;
    }catch (err) {
        console.log('Error al borrar el autor',err);
    }
}

function authorItemTemplate(author){
    return(`
    <tr>
    <td><div>${author.url_web}</div></td>
    <td><div>${author.id_persona}</div></td>
    <td>
        <div class="actions">
            <button><i class="far fa-edit"></i></button>
            <button><i class="far fa-trash-alt"></i></button>
        </div>
    </td>
    </tr>`
    );
}