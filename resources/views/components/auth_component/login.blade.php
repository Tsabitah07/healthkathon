<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>{{$title}}</title>
</head>
<body>
<div style="display: flex; justify-content: space-between; align-items: center;height: 100vh; text-align: center">
    <div style="width: 55vw; height: 100vh; display: flex; justify-content: center; align-items: center;">
        <img src="https://images.seeklogo.com/logo-png/30/1/bpjs-kesehatan-logo-png_seeklogo-306177.png" alt="image" width="100%" height="100%" style="object-fit: cover;">
    </div>
    <div style="background: #28a745; height: 100vh; width: 40%; color: white; display: flex; flex-direction: column; justify-content: center; align-items: center">
        <div class="d-flex justify-start align-items-center" style="width: 55%">
            <a href="{{ route('home') }}" style="top: 20px; left: 20px; color: white; text-decoration: none; font-weight: bold;">&larr; Back to Home</a>
        </div>
        <h3>Welcome to Healthkathon</h3>
        <p >Only admin has access to this website</p>
        <form method="post" action="{{ route('login.post') }}" style="margin-top: 2vh; width: 55%; text-align: center;" >
            @csrf
            <div class="mb-2" style="text-align: left">
                <label for="email" class="form-label">Email</label>
                <input type="text" class="form-control" id="email" name="email" placeholder="input email" style="padding: 10px 15px">
            </div>
            <div class="mb-2" style="text-align: left">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="input password" style="padding: 10px 15px">
            </div>
            <button type="submit" class="btn" style="background: midnightblue; color: white; font-weight: bold; width: 100%; padding: 10px 0; margin-top: 3vh; ">Login</button>
        </form>
    </div>
</div>
</body>
</html>
