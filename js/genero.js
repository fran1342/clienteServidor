const API = 'http://localhost:8000';
const token = '37d0d8c6c1c3842d0abc428dbc7a2fadd88c12e5';
const apiHeaders = new Headers();
apiHeaders.append('Content-Type', 'application/json');
apiHeaders.append('X-TOKEN', token);

const $btnActualizar = document.getElementById('loadGenders');
const $tableBody = document.getElementById('table-body');

//Save
const $btnSave = document.getElementById('genderSave');
const $btnUpdate = document.getElementById('genderUpdate');
const $btnDelete = document.getElementById('genderDelete');
let $name = document.getElementById('nombre');
let $desc = document.getElementById('desc');
let $eliminar = document.getElementById('eliminar')
let $actualizar = document.getElementById('act');

$btnActualizar.addEventListener('click', async function(){
    const genders = await getGenders();
    let genderRowHtml = '';
    for (let index = 0; index < genders['data'].length; index++) {
        genderRowHtml += `<tr>
        <td><div>${Object(genders.data[index]['nombre'])}</div></td>
        <td><div>${Object(genders.data[index]['descripcion'])}</div></td>
        <td><div>${Object(genders.data[index]['id'])}</div></td>
        <td>
            <div class="actions">
                <button><i class="far fa-edit"></i></button>
                <button><i class="far fa-trash-alt"></i></button>
            </div>
        </td>
        </tr>`;
    }
    $tableBody.innerHTML = genderRowHtml;
});

$btnSave.addEventListener('click', async function(){
    let gender = {
        'nombre' : $name.value,
        'descripcion' : $desc.value
    };
    const genderCreated = await setGender(gender);
    if(genderCreated) {
        $tableBody.insertRow(-1).innerHTML = genderItemTemplate(gender);
    }
});

$btnUpdate.addEventListener('click', async function(){
    let gender = {
        'nombre' : $name.value,
        'descripcion' : $desc.value
    };
    const genderCreated = await updateGender($actualizar.value,gender);
});

$btnDelete.addEventListener('click', async function(){
    const genderCreated = await deleteGender($eliminar.value)
})

async function getGenders(id){
    const apiURL = id ? `${API}/genders/${id}` : `${API}/genders`;
    const init = {
        method: 'GET',
        headers: apiHeaders
    }
    try {
        const response = await fetch(apiURL,init);
        const data = await response.json();
        return data;
    }catch (err) {
        console.log('Error al obtener los generos',err);
    }
    
}

async function setGender(gender){
    const apiURL = `${API}/genders`;
    const init = {
        method: 'POST',
        headers: apiHeaders,
        body: JSON.stringify(gender)
    }
    try {
        const response = await fetch(apiURL,init);
        const data = await response.json();
        return data;
    }catch(err) {
        console.log('Error al enviar genero', err);
    }
}

async function updateGender(id,gender){
    const apiURL = `${API}/genders/${id}`;
    const init = {
        method: 'PUT',
        headers: apiHeaders,
        body: JSON.stringify(gender)
    }
    try {
        const response = await fetch(apiURL,init);
        const data = await response.json();
        return data;
    }catch(err) {
        console.log('Error al enviar nuevo genero', err);
    }
}

async function deleteGender(id){
    const apiURL =`${API}/genders/${id}`;
    const init = {
        method: 'DELETE',
        headers: apiHeaders
    }
    try {
        const response = await fetch(apiURL,init);
        const data = await response.json();
        return data;
    }catch (err) {
        console.log('Error al borrar el genero',err);
    }
}

function genderItemTemplate(gender){
    return(`
    <tr>
    <td><div>${gender.nombre}</div></td>
    <td><div>${gender.descripcion}</div></td>
    <td>
        <div class="actions">
            <button><i class="far fa-edit"></i></button>
            <button><i class="far fa-trash-alt"></i></button>
        </div>
    </td>
    </tr>`
    );
}