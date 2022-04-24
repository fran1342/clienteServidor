//Variables para peticones a mi API
const API = 'http://localhost:8000';
const token = '37d0d8c6c1c3842d0abc428dbc7a2fadd88c12e5';
const apiHeaders = new Headers();
apiHeaders.append('Content-Type', 'application/json');
apiHeaders.append('X-TOKEN', token);

const $btnActualizar = document.getElementById('loadBooks');
const $tableBody = document.getElementById('table-body');

//Save
const $btnSave = document.getElementById('bookSave');
const $btnUpdate = document.getElementById('bookUpdate');
const $btnDelete = document.getElementById('bookDelete');
let $titulo = document.getElementById('titulo');
let $desc = document.getElementById('desc');
let $isbn = document.getElementById('isbn');
let $ao = document.getElementById('año');
let $tipo = document.getElementById('tipo');
let $editorial = document.getElementById('edit');
let $eliminar = document.getElementById('eliminar')
let $actualizar = document.getElementById('act');

$btnActualizar.addEventListener('click', async function(){
    const books = await getBooks();
    let bookRowHtml = '';
    books.data.forEach(book => {
        bookRowHtml += bookItemTemplate(book);
    });
    /*for (let index = 0; index < books['data'].length; index++) {
        bookRowHtml += `<tr>
        <td><div>${Object(books.data[index]['titulo'])}</div></td>
        <td><div class="text">${Object(books.data[index]['descripcion'])}</div></td>
        <td><div class="text">${Object(books.data[index]['isbn'])}</div></td>
        <td><div class="text">${Object(books.data[index]['id'])}</div></td>
        <td>
            <div class="actions">
                <button><i class="far fa-edit"></i></button>
                <button><i class="far fa-trash-alt"></i></button>
            </div>
        </td>
        </tr>`;
    }*/
    $tableBody.innerHTML = bookRowHtml;
    //console.log(typeof(books));
});

$btnSave.addEventListener('click', async function(){
    let book = {
        'titulo' : $titulo.value,
        'descripcion' : $desc.value,
        'isbn' : $isbn.value,
        'año_publicacion' : $ao.value,
        'tipo' : $tipo.value,
        'id_editorial' : $editorial.value
    };
    const bookCreated = await setBook(book);
    if(bookCreated) {
        $tableBody.insertRow(-1).innerHTML = bookItemTemplate(book);
    }
});

$btnUpdate.addEventListener('click', async function(){
    let book = {
        'titulo' : $titulo.value,
        'descripcion' : $desc.value,
        'isbn' : $isbn.value,
        'año_publicacion' : $ao.value,
        'tipo' : $tipo.value,
        'id_editorial' : $editorial.value
    };
    const bookCreated = await updateBook($actualizar.value,book);
});

$btnDelete.addEventListener('click', async function(){
    const bookCreated = await deleteBook($eliminar.value);
})

async function getBooks(id){
    /*if(id){
        const apiURL = `${API}/books/${id}`
    }else{
        const apiURL = `${API}/books`
    }*/
    const apiURL = id ? `${API}/books/${id}` : `${API}/books`;
    const init = {
        method: 'GET',
        headers: apiHeaders
    }
    try {
        const response = await fetch(apiURL,init);
        const data = await response.json();
        return data;
    }catch (err) {
        console.log('Error al obtener libros',err);
    }
    
}

async function setBook(book){
    const apiURL = `${API}/books`;
    const init = {
        method: 'POST',
        headers: apiHeaders,
        body: JSON.stringify(book)
    }
    try {
        const response = await fetch(apiURL,init);
        const data = await response.json();
        return data;
    }catch(err) {
        console.log('Error al enviar libro', err);
    }
}

async function updateBook(id,book){
    const apiURL = `${API}/books/${id}`;
    const init = {
        method: 'PUT',
        headers: apiHeaders,
        body: JSON.stringify(book)
    }
    try {
        const response = await fetch(apiURL,init);
        const data = await response.json();
        return data;
    }catch(err) {
        console.log('Error al enviar nuevo libro', err);
    }
}

async function deleteBook(id){
    const apiURL =`${API}/books/${id}`;
    const init = {
        method: 'DELETE',
        headers: apiHeaders
    }
    try {
        const response = await fetch(apiURL,init);
        const data = await response.json();
        return data;
    }catch (err) {
        console.log('Error al borrar el libro',err);
    }
}

function bookItemTemplate(book){
    return(`
    <tr>
    <td><div>${book.titulo}</div></td>
    <td><div class="text">${book.descripcion}</div></td>
    <td><div class="text">${book.isbn}</div></td>
    <td>
        <div class="actions">
            <button><i class="far fa-edit"></i></button>
            <button><i class="far fa-trash-alt"></i></button>
        </div>
    </td>
    </tr>`
    );
}