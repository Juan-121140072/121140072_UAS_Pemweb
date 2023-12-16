<?php
session_start();
include "db_con.php";

// check cookie
if (!isset($_COOKIE['user_id'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Data Makanan</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:wght@300;400;500;700&display=swap');


        body {
            font-family: 'Roboto', sans-serif;
            background-color: #DEE1E6;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        body::before {
            content: "";
            background-image: url("https://images.unsplash.com/photo-1505935428862-770b6f24f629?q=80&w=1734&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D");
            background-size: cover;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            opacity: 0.9;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
            margin-top: 10px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
        }

        select {
            width: calc(100% - 16px);
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            outline: none;
        }

        input {
            width: calc(100% - 16px);
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            outline: none;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            cursor: pointer;
            border: none;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .hapus {
            background-color: red !important;
        }

        .hidden {
            display: none;
        }

        .menu-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 15px;
            padding: 30px;
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .button {
            align-items: center;
            appearance: none;
            background-image: radial-gradient(100% 100% at 100% 0, #5adaff 0, #5468ff 100%);
            border: 0;
            border-radius: 6px;
            box-shadow: rgba(45, 35, 66, .4) 0 2px 4px, rgba(45, 35, 66, .3) 0 7px 13px -3px, rgba(58, 65, 111, .5) 0 -3px 0 inset;
            box-sizing: border-box;
            color: #fff;
            cursor: pointer;
            display: inline-flex;
            font-family: "JetBrains Mono", monospace;
            height: 30px;
            justify-content: center;
            line-height: 1;
            list-style: none;
            overflow: hidden;
            padding-left: 10px;
            padding-right: 10px;
            position: relative;
            text-align: left;
            text-decoration: none;
            transition: box-shadow .15s, transform .15s;
            user-select: none;
            -webkit-user-select: none;
            touch-action: manipulation;
            white-space: nowrap;
            will-change: box-shadow, transform;
            font-size: 18px;
        }

        .button:focus {
            box-shadow: #3c4fe0 0 0 0 1.5px inset, rgba(45, 35, 66, .4) 0 2px 4px, rgba(45, 35, 66, .3) 0 7px 13px -3px, #3c4fe0 0 -3px 0 inset;
        }

        .button:hover {
            box-shadow: rgba(45, 35, 66, .4) 0 4px 8px, rgba(45, 35, 66, .3) 0 7px 13px -3px, #3c4fe0 0 -3px 0 inset;
            transform: translateY(-2px);
        }

        .button:active {
            box-shadow: #3c4fe0 0 3px 7px inset;
            transform: translateY(2px);
        }

        .logout-button {
            background-color: initial;
            background-image: linear-gradient(-180deg, #FF7E31, #E62C03);
            border-radius: 6px;
            box-shadow: rgba(0, 0, 0, 0.1) 0 2px 4px;
            color: #FFFFFF;
            cursor: pointer;
            display: inline-block;
            font-family: Inter, -apple-system, system-ui, Roboto, "Helvetica Neue", Arial, sans-serif;
            height: 40px;
            line-height: 40px;
            outline: 0;
            overflow: hidden;
            padding: 0 20px;
            pointer-events: auto;
            position: relative;
            text-align: center;
            touch-action: manipulation;
            user-select: none;
            -webkit-user-select: none;
            vertical-align: top;
            white-space: nowrap;
            width: 100%;
            z-index: 9;
            border: 0;
            transition: box-shadow .2s;
        }

        .logout-button:hover {
            box-shadow: rgba(253, 76, 0, 0.5) 0 3px 8px;
        }

        .hapus-button {
            background-color: #FFE7E7;
            background-position: 0 0;
            border: 1px solid #FEE0E0;
            border-radius: 11px;
            box-sizing: border-box;
            color: #D33A2C;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 700;
            line-height: 33.4929px;
            list-style: outside url(https://www.smashingmagazine.com/images/bullet.svg) none;
            padding: 2px 12px;
            text-align: left;
            text-decoration: none;
            text-shadow: none;
            text-underline-offset: 1px;
            transition: border .2s ease-in-out, box-shadow .2s ease-in-out;
            user-select: none;
            -webkit-user-select: none;
            touch-action: manipulation;
            white-space: nowrap;
            word-break: break-word;
        }

        .hapus-button:active,
        .hapus-button:hover,
        .hapus-button:focus {
            outline: 0;
        }


        .hapus-button:active {
            background-color: #D33A2C;
            box-shadow: rgba(0, 0, 0, 0.12) 0 1px 3px 0 inset;
            color: #FFFFFF;
        }

        .hapus-button:hover {
            background-color: #FFE3E3;
            border-color: #FAA4A4;
        }

        .hapus-button:active:hover,
        .hapus-button:focus:hover,
        .hapus-button:focus {
            background-color: #D33A2C;
            box-shadow: rgba(0, 0, 0, 0.12) 0 1px 3px 0 inset;
            color: #FFFFFF;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: gray;
            color: whitesmoke;
        }

        td {
            background-color: whitesmoke
        }

        .table-container {
            width: 50%;
            overflow: auto;
            max-height: 400px;
            margin: 20px;
            margin-top: 5px;
        }

        .makananFilter {
            width: 500px;
            margin-top: 30px;
        }


        .radio-container {
            display: flex;
            gap: 10px;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
        }

        input[type="radio"] {
            display: none;
        }

        input[type="radio"]+label {
            position: relative;
            padding-left: 30px;
            cursor: pointer;
            line-height: 20px;
            display: inline-block;
        }

        input[type="radio"]+label:before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            border: 2px solid #4caf50;
            border-radius: 50%;
            background-color: #fff;
        }

        input[type="radio"]:checked+label:before {
            background-color: #4caf50;
            border-color: #4caf50;
        }

        .checkbox-container {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-bottom: 15px;
        }

        input[type="checkbox"] {
            display: none;
        }

        input[type="checkbox"]+label {
            position: relative;
            padding-left: 30px;
            cursor: pointer;
            line-height: 20px;
            display: inline-block;
        }

        input[type="checkbox"]+label:before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            border: 2px solid #4caf50;
            border-radius: 4px;
            background-color: #fff;
        }

        input[type="checkbox"]:checked+label:before {
            background-color: #4caf50;
            border-color: #4caf50;
        }
    </style>
</head>

<body>
    <div class="menu-container">
        <h2 style="margin:0px; margin-bottom:15px;">Menu Data Makanan</h2>
        <div style="display: flex; gap: 20px;">
            <button class="button" onclick="formTambah()">Tambah Data</button>
            <button class="button" onclick="formEdit()">Edit Data</button>
        </div>
    </div>

    <form class="hidden tambah-data" action="tambahdata.php" method="post" onsubmit="return validasiForm()">
        <h2>Input Data</h2>
        <label for="id">Id Makanan:</label>
        <input type="text" name="id">
        <label for="nama">Nama:</label>
        <input type="text" name="nama">
        <label for="kehalalan">Kehalalan:</label>
        <div class="radio-container">
            <input type="radio" id="Halal" name="kehalalan" value="Halal">
            <label for="Halal">Halal</label>

            <input type="radio" id="Non-halal" name="kehalalan" value="Non-halal">
            <label for="Non-halal">Non-halal</label>
        </div>

        <label for="jenis">Jenis Makanan:</label>
        <select name="jenis" id="jenis">
            <option selected value="Main Course">Main Course</option>
            <option value="Desert">Desert</option>
            <option value="Appetizer">Appetizer</option>
        </select>

        <label for="ciri">Ciri Makanan:</label>
        <div class="checkbox-container">
            <input type="checkbox" id="ciri1" name="ciri[]" value="Manis">
            <label for="ciri1"> Manis</label>

            <input type="checkbox" id="ciri2" name="ciri[]" value="Asin">
            <label for="ciri2"> Asin</label>

            <input type="checkbox" id="ciri3" name="ciri[]" value="Pedas">
            <label for="ciri3"> Pedas</label>

            <input type="checkbox" id="ciri4" name="ciri[]" value="Kering">
            <label for="ciri4"> Kering</label>

            <input type="checkbox" id="ciri5" name="ciri[]" value="Berkuah">
            <label for="ciri5"> Berkuah</label>
        </div>

        <input type="submit" value="Tambahkan">
    </form>

    <form class="hidden edit-data" action="editdata.php" method="post" onsubmit="return validasiForm()">
        <h2>Edit Data</h2>
        <label for="id">Id Makanan:</label>
        <input type="text" name="id">
        <label for="nama">Nama:</label>
        <input type="text" name="nama">
        <label for="kehalalan">Kehalalan:</label>
        <div class="radio-container">
            <input type="radio" id="Halal-Edit" name="kehalalan" value="Halal">
            <label for="Halal-Edit">Halal</label>

            <input type="radio" id="Non-halal-Edit" name="kehalalan" value="Non-halal">
            <label for="Non-halal-Edit">Non-halal</label>
        </div>

        <label for="jenis">Jenis Makanan:</label>
        <select name="jenis" id="jenis">
            <option selected value="Main Course">Main Course</option>
            <option value="Desert">Desert</option>
            <option value="Appetizer">Appetizer</option>
        </select>

        <label for="ciri">Ciri Makanan:</label>
        <div class="checkbox-container">
            <input type="checkbox" id="ciri1-edit" name="ciri[]" value="Manis">
            <label for="ciri1-edit"> Manis</label>

            <input type="checkbox" id="ciri2-edit" name="ciri[]" value="Asin">
            <label for="ciri2-edit"> Asin</label>

            <input type="checkbox" id="ciri3-edit" name="ciri[]" value="Pedas">
            <label for="ciri3-edit"> Pedas</label>

            <input type="checkbox" id="ciri4-edit" name="ciri[]" value="Kering">
            <label for="ciri4-edit"> Kering</label>

            <input type="checkbox" id="ciri5-edit" name="ciri[]" value="Berkuah">
            <label for="ciri5-edit"> Berkuah</label>
        </div>
        <input type="submit" value="Edit">
    </form>

    <select class="makananFilter" onchange="ambilData()">
        <option value="">-- Pilih Jenis --</option>
        <option value="Main Course">Main Course</option>
        <option value="Desert">Desert</option>
        <option value="Appetizer">Appetizer</option>
    </select>

    <div class="table-container">
        <table>
            <thead>
                <th>Id</th>
                <th>Nama Makanan</th>
                <th>Kehalalan</th>
                <th>Jenis Makanan</th>
                <th>Ciri Makanan</th>
                <th>Aksi</th>
            </thead>
            <tbody class="table-body">
            </tbody>
        </table>
        <div>

            <div style="position: fixed; top: 10px; right: 10px;">
                <a href="index.php">
                    <button class="logout-button" onclick={logout()}>
                        Logout
                    </button>
                </a>
            </div>

            <script>
                function checkCookie() {
                    var userIdCookie = getCookie('user_id');
                    if (!userIdCookie) {
                        window.location.href = 'index.php';
                    }
                }

                function getCookie(name) {
                    var match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
                    return match ? match[2] : null;
                }

                let formActiveNow;
                ambilData();
                checkCookie();

                function logout() {
                    document.cookie = 'user_id=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
                    window.location.href = 'index.php';
                }

                function ambilData() {
                    const makananFilter = document.querySelector('.makananFilter').value;

                    const fetchUrl = makananFilter ? `ambildata.php?jenis=${encodeURIComponent(makananFilter)}` : 'ambildata.php';

                    fetch(fetchUrl)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            displayData(data);
                        })
                        .catch(error => {
                            console.error('There was a problem with the fetch operation:', error);
                        });
                }

                function displayData(data) {
                    const tableBody = document.querySelector('.table-body');
                    tableBody.innerHTML = '';

                    if (data.length != 0) {
                        data.forEach(row => {
                            const tr = `<tr><td>${row.id}</td><td>${row.nama}</td><td>${row.kehalalan}</td><td>${row.jenis}</td><td>${row.ciri}</td><td><button class="hapus-button" onclick={hapusData(${row.id})}>Hapus Data</button></td></tr>`;
                            tableBody.innerHTML += tr;
                        });
                    } else {
                        tableBody.innerHTML += `<tr><td colspan="6">Data Tidak Ditemukan</td></tr>`
                    }

                }

                function formTambah() {
                    if (!formActiveNow) {
                        document.querySelector(".tambah-data").classList.remove("hidden");
                        formActiveNow = document.querySelector(".tambah-data");
                    }
                    else if (formActiveNow != document.querySelector(".tambah-data")) {
                        document.querySelector(".tambah-data").classList.remove("hidden");
                        formActiveNow.classList.add("hidden");
                        formActiveNow = document.querySelector(".tambah-data");
                    } else {
                        formActiveNow.classList.add("hidden");
                        formActiveNow = null;
                    }
                }

                function formEdit() {
                    if (!formActiveNow) {
                        document.querySelector(".edit-data").classList.remove("hidden");
                        formActiveNow = document.querySelector(".edit-data");
                    }
                    else if (formActiveNow != document.querySelector(".edit-data")) {
                        document.querySelector(".edit-data").classList.remove("hidden");
                        formActiveNow.classList.add("hidden");
                        formActiveNow = document.querySelector(".edit-data");
                    } else {
                        formActiveNow.classList.add("hidden");
                        formActiveNow = null;
                    }
                }

                function hapusData(id) {
                    if (confirm("Apakah kamu yakin?")) {
                        fetch(`hapusdata.php?del=${encodeURIComponent(id)}`)
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('Network response was not ok');
                                }
                                return response.json();
                            })
                            .then(data => {
                                console.log('Deletion successful:', data);
                                ambilData();
                            })
                            .catch(error => {
                                console.error('There was a problem with the fetch operation:', error);
                            });
                    }
                }

                function validasiForm() {
                    // Ambil nilai dari setiap input
                    var id = document.getElementsByName("id")[0].value;
                    var nama = document.getElementsByName("nama")[0].value;
                    var kehalalan = document.querySelector('input[name="kehalalan"]:checked');
                    var jenis = document.getElementById("jenis").value;
                    var ciri = document.querySelectorAll('input[name="ciri[]"]:checked');

                    // Validasi setiap input
                    if (id.trim() === "") {
                        alert("Id Makanan harus diisi");
                        return false;
                    }

                    if (nama.trim() === "") {
                        alert("Nama harus diisi");
                        return false;
                    }

                    if (!kehalalan) {
                        alert("Kehalalan harus dipilih");
                        return false;
                    }

                    if (jenis === "-- Pilih Jenis --") {
                        alert("Jenis Makanan harus dipilih");
                        return false;
                    }

                    if (ciri.length === 0) {
                        alert("Minimal harus memilih satu Ciri Makanan");
                        return false;
                    }

                    // Jika semua validasi berhasil
                    return true;
                }
            </script>
</body>

</html>