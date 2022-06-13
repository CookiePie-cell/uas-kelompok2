const input_registrasi = document.getElementsByClassName("input-form");
const input_file = document.getElementById("file-gambar");


function validasi_form() {
    let pesan = "";
    for(let data of input_registrasi) {
        if(data.value === "") {
            pesan += `${data.name}, `;
        }
    }
    
    console.log(pesan);
    if(pesan === "") {
        let ukuranFile = parseInt(input_file.files[0].size / 1024 / 1024);
        if(ukuranFile > 5) {
            alert("Ukuran file terlalu besar!");
            return false;
        }
        return true;
    }
    alert(`Tolong masukkan ${pesan.substring(0, pesan.length-2)}`);
    return false;
}



