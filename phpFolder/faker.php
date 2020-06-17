<?php
class Faker
{
    public $exts = [];
    public $num = 1;
    public function make(Int $num, array $exts)
    {
        for ($i = 0; $i < $num; $i++) {
            $ext = $exts[rand(0, (count($exts) - 1))];
            $file = "File{$i}.{$ext}";
            touch($file);
            echo "\e[32m {$file} \033[0m Created Successfully" . "\n"; // make it with orange color
        }
    }
}

$files = new Faker();
while (true) :
    $number = (int) readline('number of files: ');
    $inputExt = readline('please enter exts separated with , : ');
    $exts = array_map('trim', array_filter(explode(',', $inputExt)));
    if (!empty($exts)) {
        $files->make($number, $exts);
        break;
    } else {
        echo 'please enter valid inputs';
    }
endwhile;
