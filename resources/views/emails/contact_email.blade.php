<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="{{ url('/send-email') }}"   method="POST"    style="width: 1155px; height: 807px;">
        @csrf
<div style="display: flex; align-items: center; gap: 10px;">
<input type="text" name="name" placeholder="Your Name" style="outline: 1px solid darkgreen; border: none; padding: 8px; border-radius: none; margin:2px">
<input type="text" name="email" placeholder="Email" style="outline: 1px solid darkgreen; border: none; padding: 8px; border-radius: none; margin:2px">

</div>


<div>
    <input type="text" name="subject" placeholder="Subject" style="outline: 1px solid darkgreen; border: none; padding: 8px; border-radius: none;margin:2px;width: 380px;">
</div>
<div>
    <input type="text" name="message" placeholder="Message" style="outline: 1px solid darkgreen; border: none; padding: 8px; border-radius: none;width: 380px; height: 207px;margin-top:5px;text-align:justify;" >
</div>
<button type="submit" style="background-color: #013220; color:white; width: 200px; height: 70px; border-radius:64px;font-style:Rubik; font-size:20px;font-weight:bold;text-align:center;margin-top:3px;">SEND MESSAGE</button>
</form>
</body>
</html>