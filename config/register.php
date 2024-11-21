<?php
include 'link.php';
include '../navbar/nav_login.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Galeri Lulu</title>
</head>

<body>
    <!-- REGISTER -->
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body bg-light">
                        <div class="text-center">
                            <h5>REGISTER</h5>
                        </div>
                        <form action="../config/register_function.php" method="POST">
                            <label class="form-label">USERNAME</label>
                            <input type="text" name="username" class="form-control" required>

                            <label class="form-label">PASSWORD</label>
                            <input type="password" name="password" class="form-control" required>

                            <label class="form-label">EMAIL</label>
                            <input type="email" name="email" class="form-control" required>

                            <label class="form-label">NAMA LENGKAP</label>
                            <input type="text" name="namalengkap" class="form-control" required>

                            <label class="form-label">ALAMAT</label>
                            <input type="text" name="alamat" class="form-control" required>

                            <label class="form-label">LEVEL</label>
                            <select name="level" class="form-control" required>
                                <option value="user">User</option>
                                <option value="admin">Admin</option>
                            </select>




                            <div class="d-grid mt-2">
                                <button class="btn btn-primary" type="submit" name="submit">MASUK</button>
                            </div>


                        </form>
                        <hr>
                        <p>Sudah Punya Akun? <a href="Login.php">Klik disini</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>


</body>

</html>