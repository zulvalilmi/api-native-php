<?php

require_once "koneksi.php";

if(function_exists($_GET['function'])){
    $_GET['function']();
}

// Get Data Users
// URL DESIGN Get Data Users:
// localhost/api-native/api.php?function=getUsers
function getUsers(){

    // Permintaan ke server
    global $koneksi;
    $query = mysqli_query($koneksi, "SELECT * FROM users");
    while($data = mysqli_fetch_object($query)){
        $users[] = $data;
    }

    // Menghasilkan response server
    $respon = array(
        'status'    => 1,
        'message'   => 'Success get users',
        'users'     => $users
    );

    // Menampilkan data dalam bentuk JSON
    header('Content-Type: application/json');
    print json_encode($respon);

}

// Insert Data User
// URL DESIGN Insert Data User:
// localhost/api-native/api.php?function=addUser
function addUsers(){
    
    global $koneksi;

    $parameter = array(
        'nama' => '', 
        'alamat' => ''
    );

    $cekData = count(array_intersect_key($_POST, $parameter));

    if($cekData == count($parameter)){

        $nama   = $_POST['nama'];
        $alamat = $_POST['alamat'];
        
        $result = mysqli_query($koneksi, "INSERT INTO users VALUES('', '$nama', '$alamat')");

        if($result){
            return message(1, "Insert data $nama success");
        }else{
            return message(0, "Insert data failed");
        }

    }else{
        return message(0, "Parameter Salah");
    }

}

function message($status, $msg){

    $respon = array(
            'status'    => $status,
            'message'   => $msg
    );

    // Menampilkan data dalam bentuk JSON
    header('Content-Type: application/json');
    print json_encode($respon);
}


//update data user
//URL DESAIGN update data user
//localhost/api-native/api.php?function=updateUser&id={id}

function updateUsers(){

    global $koneksi;

    if(!empty($_GET['id'])){
        $id =$_GET['id'];
    }

    $parameter = array(
        'nama'      => "",
        'alamat'    => ""
    );
 //fungsi array_intersect_key() berfungsi untuk membandingkan kunci dari dua atau lebih array, dan mengembalikann kecocokan
    $cekData = count(array_intersect_key($_POST, $parameter));

    if($cekData == count ($parameter)){
        $nama       = $_POST['nama'];
        $alamat     = $_POST['alamat'];

        $result= mysqli_query($koneksi, "UPDATE users SET nama='$nama', alamat ='$alamat' WHERE id='$id' ");

        if($result){
            return message(1, "Update data $nama succes");
        }else{
            return message(0, "update data failded");
        }
    
    }else{
        return message(0, "parameter sallah" );
    }
}   

//delete data user
//URL DESAIGN delete data user
//localhost/api-native/api.php?function=deleteUser&id={id}

function deletUsers(){
    global $koneksi;

    if(!empty($_GET['id'])){
        $id=$_GET['id'];
    }

    $result= mysqli_query($koneksi, "DELETE FROM users WHERE id='$id'");

    if($result){
        return message(1,"delete sukses");
        
    }else{
        return message(0, "delete gagal");

    }


}

function detailUsersId(){

    global $koneksi;

    if(!empty($_GET['id'])){
        $id=$_GET['id'];
    }

    $result = $koneksi -> query("SELECT * FROM users WHERE id='$id' ");

    while($data =mysqli_fetch_object($result)){
        $detailUser[] = $data;
    }
    if($detailUser){
        $respon = array(
            'status' =>1,
            'message' => "berhasil mendapatkan data detail user",
            'user' => $detailUser
        );

    }else{
        return message(0, "data tidak ketemuan");
    }
    header('Content-Type: application/json');
    print json_encode($respon);

}

?>