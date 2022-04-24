<?php
// ? autentificaón vía Access Tokens

require_once 'auth.php';
require_once 'errorResponse.php';
require_once 'basedatos.php';
require_once 'dataResponse.php';
require_once 'book.php';
require_once 'gender.php';
require_once 'author.php';

header('Content-Type:application/json');

function response($error,$response){

    if ($error) {
        $res = errorFormat($error);
    } else {
        $res = dataFormat($response);
    }
    
    http_response_code($res['statusCode']);
    echo json_encode($res);
    die;
}

function dataFormat($dataResponse){
    return [
        "statusCode" => $dataResponse->getCode(),
        "data" => $dataResponse->getData()
    ];
}

function errorFormat($error){
    array(
        "statusCode" => $error->getCode(),
        "error" => $error->getError(),
        "message" => $error->getMessage()
    );
}

if (!array_key_exists('HTTP_X_TOKEN',$_SERVER)){
    response(new ErrorResponse(400,'Not found','Faltan parametros'),null);
}

$auth = new Auth($_SERVER['HTTP_X_TOKEN']);

if ($auth->errorAuth() !== 0) {
    response(new ErrorResponse(500,'Servidor',$auth->errorAuth()),null);
}

if( $auth->responseAuth() !== 'true' ) {
    response(new ErrorResponse(403,'Auth','token invalido'),null);
}


$allowedResourceType = [
    'books',
    'authors',
    'genders'
];

$resourceType = $_GET['resource_type'];


if (!in_array( $resourceType, $allowedResourceType)) {
    response(new ErrorResponse(400,'Not found','El recurso solicitado no existe'),null);
    die;
}

$books = [];

$authors = [];

$genders = [];

$resourceType = $_GET['resource_type'];
$resourceId = array_key_exists('resource_id', $_GET) ? $_GET['resource_id'] : '';

if(!in_array($resourceType, $allowedResourceType)){
    response(new ErrorResponse(400,'Not found','El recurso solicitado no existe'),null);
}

$db=new DataBase();

switch ( strtoupper($_SERVER['REQUEST_METHOD'])) {
    case 'GET':
        if($resourceType == 'books'){
            if (empty($resourceId)) {
                response(null,new DataResponse(200,$db->getBooks()));
            }else{
                response(null,new DataResponse(200,$db->getBook($resourceId))); 
            }
        }
        elseif ($resourceType == 'genders') {
            if (empty($resourceId)) {
                response(null,new DataResponse(200,$db->getGenders()));
            }else{
                response(null,new DataResponse(200,$db->getGender($resourceId))); 
            }
        }
        elseif ($resourceType == 'authors') {
            if (empty($resourceId)) {
                response(null,new DataResponse(200,$db->getAuthors()));
            }else{
                response(null,new DataResponse(200,$db->getAuthor($resourceId))); 
            }
        }
    break;
    case 'POST':
        if ($resourceType == 'books') {
            $json = file_get_contents('php://input');
            $book = new Book(json_decode($json,true));
            response(null,new DataResponse(201,$db->createBook($book)));
        }elseif ($resourceType == 'genders') {
            $json = file_get_contents('php://input');
            $gender = new Gender(json_decode($json,true));
            response(null,new DataResponse(201,$db->createGender($gender)));
        }
        elseif ($resourceType == 'authors') {
            $json = file_get_contents('php://input');
            $author = new Author(json_decode($json,true));
            response(null,new DataResponse(201,$db->createAuthor($author)));
        }
    break;
    case 'PUT':
        if($resourceType == 'books'){
            if(!empty($resourceId)){
                $json=file_get_contents('php://input');
                $book=new Book(json_decode($json,true));
                response(null,new DataResponse(200,$db->updateBook($resourceId,$book)));
            }
            response(null,new DataResponse(200,$db->getBooks()));
        }
        elseif ($resourceType == 'genders') {
            if(!empty($resourceId)){
                $json=file_get_contents('php://input');
                $gender=new Gender(json_decode($json,true));
                response(null,new DataResponse(200,$db->updateGender($resourceId,$gender)));
            }
            response(null,new DataResponse(200,$db->getGenders()));
        }
        elseif ($resourceType == 'authors') {
            if(!empty($resourceId)){
                $json=file_get_contents('php://input');
                $author=new Author(json_decode($json,true));
                response(null,new DataResponse(200,$db->updateAuthor($resourceId,$author)));
            }
            response(null,new DataResponse(200,$db->getAuthors()));
        }
    break;
    case 'DELETE':
        if($resourceType == 'books'){
            if(!empty($resourceId)){
                response(null,new DataResponse(201,$db->deleteBook($resourceId)));
            }
            response(null,new DataResponse(200,$db->getBooks()));
        }
        elseif ($resourceType == 'genders') {
            if(!empty($resourceId)){
                response(null,new DataResponse(201,$db->deleteGender($resourceId)));
            }
            response(null,new DataResponse(200,$db->getGenders()));
        }
        elseif ($resourceType == 'authors') {
            if(!empty($resourceId)){
                response(null,new DataResponse(201,$db->deleteAuthor($resourceId)));
            }
            response(null,new DataResponse(200,$db->getAuthors()));
        }
    break;
}

// server
// php -S localhost:8000 server.php
// cliente 
// curl "http://localhost:8000?resource_type=books"
// curl "http://localhost:8000?resource_type=books&resource_id=1"
//  http://localhost:8000/books/1