<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Login - SIABSAR</title>

<link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

<style>
body{
    background-image:url("{{ asset('images/kebun-sawit.jpeg') }}");
    background-size:cover;
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    font-family:Poppins;
}

.card{
    width:420px;
    padding:30px;
    border-radius:18px;
    background:white;
    box-shadow:0 6px 20px rgba(0,0,0,.3);
}

.role-box{
    display:flex;
    margin-bottom:20px;
}

.role-btn{
    flex:1;
    padding:10px;
    border:1px solid #ccc;
    background:#f1f1f1;
    cursor:pointer;
    font-weight:600;
}

.role-btn.active{
    background:#003366;
    color:white;
}

.role-btn:first-child{
    border-radius:8px 0 0 8px;
}
.role-btn:last-child{
    border-radius:0 8px 8px 0;
}
</style>
</head>
<body>

<div class="card">

<h4 class="text-center mb-4">SIABSAR</h4>

<!-- ROLE -->
<div class="role-box">
    <button type="button" class="role-btn active" onclick="setRole('admin')">Admin</button>
    <button type="button" class="role-btn" onclick="setRole('karyawan')">Karyawan</button>
</div>

<form method="POST" action="{{ route('login') }}">
@csrf

<input type="hidden" name="role" id="role" value="admin">

<div class="mb-3">
<label>Email</label>
<input type="email" class="form-control" name="email" required>
</div>

<div class="mb-3">
<label>Password</label>
<input type="password" class="form-control" name="password" required>
</div>

<button class="btn btn-primary w-100">Login</button>

</form>

</div>

<script>
function setRole(role){
    document.getElementById("role").value = role;

    let btns = document.querySelectorAll(".role-btn");
    btns.forEach(btn => btn.classList.remove("active"));

    event.target.classList.add("active");
}
</script>

</body>
</html>