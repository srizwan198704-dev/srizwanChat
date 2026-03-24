<?php
// মেসেজ সংরক্ষণের জন্য একটি টেক্সট ফাইল
$file = "messages.txt";

// মেসেজ পাঠানোর লজিক
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['msg'])) {
    $name = isset($_POST['name']) ? htmlspecialchars($_POST['name']) : "User";
    $msg = htmlspecialchars($_POST['msg']);
    $time = date("h:i A");
    
    // মেসেজ ফরম্যাট: নাম|মেসেজ|সময়
    $data = "<b>$name:</b> $msg <small>($time)</small><br>\n";
    
    // ফাইলের শুরুতে নতুন মেসেজ সেভ করা
    $old_content = file_exists($file) ? file_get_contents($file) : "";
    file_put_contents($file, $data . $old_content);
    
    // পেজ রিফ্রেশ করা যাতে ডাবল মেসেজ না যায়
    header("Location: index.php");
    exit();
}

// চ্যাট ক্লিয়ার করার লজিক
if (isset($_GET['clear'])) {
    if (file_exists($file)) unlink($file);
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>সহজ চ্যাট</title>
    <style>
        body { font-family: sans-serif; background: #000; color: #fff; margin: 5px; }
        .header { background: #333; padding: 5px; text-align: center; font-size: 14px; }
        .chat-box { 
            border: 1px solid #444; 
            height: 200px; 
            overflow-y: scroll; 
            padding: 5px; 
            background: #111;
            margin-bottom: 10px;
            font-size: 14px;
            line-height: 1.6;
        }
        input[type="text"] { width: 70%; padding: 5px; }
        input[type="submit"] { padding: 5px; background: #4fc3f7; border: none; }
        .footer { margin-top: 10px; font-size: 12px; }
        a { color: #ff5252; text-decoration: none; }
    </style>
</head>
<body>

    <div class="header">
        ব্যক্তিগত চ্যাট 
        | <a href="index.php?clear=1" onclick="return confirm('সব মুছে ফেলবেন?')">মুছুন</a>
        | <a href="index.php">রিফ্রেশ</a>
    </div>

    <div class="chat-box">
        <?php 
        if (file_exists($file)) {
            echo file_get_contents($file);
        } else {
            echo "কোনো মেসেজ নেই।";
        }
        ?>
    </div>

    <form method="POST" action="index.php">
        <input type="text" name="name" placeholder="নাম" style="width: 25%;" value="Admin">
        <input type="text" name="msg" placeholder="বার্তা..." required>
        <br><br>
        <input type="submit" value="পাঠান">
    </form>

    <div class="footer">
        * বাটন মোবাইলে নতুন মেসেজ দেখতে 'রিফ্রেশ' করুন।
    </div>

</body>
</html>
