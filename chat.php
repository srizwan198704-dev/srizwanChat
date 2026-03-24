<?php
// মেসেজ সংরক্ষণের জন্য টেক্সট ফাইল
$file = "messages.txt";

// ১. মেসেজ পাঠানোর লজিক (Send Message)
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['msg'])) {
    $name = isset($_POST['name']) ? htmlspecialchars($_POST['name']) : "User";
    $msg = htmlspecialchars($_POST['msg']);
    $time = date("h:i A");
    
    // মেসেজ ফরম্যাট: নাম: মেসেজ (সময়)
    $data = "<div style='margin-bottom:8px; border-bottom:1px dotted #333;'>
                <b style='color:#4fc3f7;'>$name:</b> $msg 
                <br><small style='color:#777; font-size:10px;'>$time</small>
             </div>\n";
    
    // নতুন মেসেজ উপরে দেখানোর জন্য ফাইলের শুরুতে সেভ করা
    $old_content = file_exists($file) ? file_get_contents($file) : "";
    file_put_contents($file, $data . $old_content);
    
    // মেসেজ পাঠানোর পর পেজ রিফ্রেশ (যাতে বারবার একই মেসেজ না যায়)
    header("Location: chat.php");
    exit();
}

// ২. চ্যাট ক্লিয়ার করার লজিক (Clear All)
if (isset($_GET['clear'])) {
    if (file_exists($file)) unlink($file);
    header("Location: chat.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>বাটন চ্যাট</title>
    <style>
        body { 
            font-family: sans-serif; 
            background-color: #000; 
            color: #eee; 
            margin: 0; 
            padding: 5px;
            font-size: 14px;
        }
        .nav { 
            background: #222; 
            padding: 8px; 
            text-align: center; 
            border-bottom: 2px solid #4fc3f7;
        }
        .nav a { 
            color: #fff; 
            text-decoration: none; 
            font-weight: bold; 
            margin: 0 10px;
        }
        .chat-area { 
            background: #111; 
            height: 250px; 
            overflow-y: scroll; 
            padding: 10px; 
            margin: 10px 0;
            border: 1px solid #333;
        }
        .input-group {
            background: #222;
            padding: 10px;
            border-radius: 5px;
        }
        input[type="text"] { 
            width: 90%; 
            padding: 8px; 
            margin-bottom: 5px;
            background: #333;
            color: #fff;
            border: 1px solid #555;
        }
        input[type="submit"] { 
            width: 100%; 
            padding: 10px; 
            background: #4fc3f7; 
            color: #000; 
            border: none; 
            font-weight: bold;
            cursor: pointer;
        }
        .del-link { color: #ff5252; font-size: 12px; }
    </style>
</head>
<body>

    <div class="nav">
        <a href="chat.php">রিফ্রেশ (নতুন মেসেজ)</a>
    </div>

    <div class="chat-area">
        <?php 
        if (file_exists($file) && filesize($file) > 0) {
            echo file_get_contents($file);
        } else {
            echo "<p style='color:#666; text-align:center;'>কোনো মেসেজ নেই।</p>";
        }
        ?>
    </div>

    <div class="input-group">
        <form method="POST" action="chat.php">
            <input type="text" name="name" placeholder="আপনার নাম" value="Admin">
            <input type="text" name="msg" placeholder="বার্তা লিখুন..." required>
            <input type="submit" value="পাঠান (Send)">
        </form>
    </div>

    <div style="text-align: center; margin-top: 15px;">
        <a href="chat.php?clear=1" class="del-link" onclick="return confirm('সব মুছে ফেলবেন?')">সব মেসেজ মুছুন</a>
    </div>

</body>
</html>
