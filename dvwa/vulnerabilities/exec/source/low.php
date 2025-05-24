<?php
if (isset($_POST['Submit'])) {
    // Validate IP address
    $target = $_POST['ip'];
    
    if (filter_var($target, FILTER_VALIDATE_IP)) {
        // Choose command based on OS
        $pingCmd = (stripos(PHP_OS, 'WIN') === 0) 
            ? ["ping", "-n", "4", $target]
            : ["ping", "-c", "4", $target];

        // Use proc_open for safe execution
        $descriptorspec = [
            1 => ['pipe', 'w'], // stdout
            2 => ['pipe', 'w'], // stderr
        ];

        $process = proc_open($pingCmd, $descriptorspec, $pipes);

        if (is_resource($process)) {
            $output = stream_get_contents($pipes[1]);
            $error  = stream_get_contents($pipes[2]);

            fclose($pipes[1]);
            fclose($pipes[2]);
            proc_close($process);

            $html .= "<pre>" . htmlspecialchars($output ?: $error) . "</pre>";
        } else {
            $html .= "<pre>Error launching ping process.</pre>";
        }
    } else {
        $html .= "<pre>Invalid IP address.</pre>";
    }
}
?>
