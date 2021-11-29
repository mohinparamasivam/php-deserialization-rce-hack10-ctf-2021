<?php
class MySink
{
    private $command = false;

    public function __construct($cmd)
    {
        $this->command = $cmd;
    }

    public function __wakeup()
    {
        if (strlen($this->command) > 4) {
            $this->command = false;
        }
    }

    public function __destruct()
    {
        if (strlen($this->command) > 4) {
            $this->command = false;
        }
        if ($this->command) {
            system($this->command);
        }
    }
}

$iphash = md5($_SERVER['REMOTE_ADDR'] . "hack@10");
$safe = '/tmp/' . $iphash;
if (!is_dir($safe)) {
    @mkdir($safe, 0777, true);
}
chdir($safe);
if (!empty($_REQUEST['code'])) {
    $code = base64_decode($_REQUEST['code']);
    $a = unserialize($code);
} elseif (!empty($_REQUEST['clear'])) {
    @exec('rm -rf ' . $safe);
} else {
    highlight_file(__FILE__);
}
