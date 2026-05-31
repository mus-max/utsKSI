<?php
$pergantian = [
    'a'=>'1f0', 'b'=>'3g3', 'c'=>'4lk', 'd'=>'2ax', 'e'=>'8ug', 'f'=>'6gr', 'g'=>'7nr',
    'h'=>'9hf', 'i'=>'0g6', 'j'=>'2ml', 'k'=>'5td', 'l'=>'6vb', 'm'=>'3mi', 'n'=>'9jy',
    'o'=>'8ji', 'p'=>'3g6', 'q'=>'1md', 'r'=>'5ya', 's'=>'7uz', 't'=>'6wu', 'u'=>'5us',
    'v'=>'3k0', 'w'=>'5gh', 'x'=>'9rw', 'y'=>'4w2', 'z'=>'7id'
];
function enshift($text, $map){
    $hasil = "";
    $karakter = str_split($text);

    foreach ($karakter as $char){
        $lowerChar = strtolower($char);

        if (array_key_exists($lowerChar, $map)){
            if ($char == strtoupper($char) && $char !== $lowerChar){
                $hasil .= '#'.$map[$lowerChar];
            } else {
                $hasil .= $map[$lowerChar];
            }
        } else {
            $hasil .= $char;
        }
    }
    return $hasil;
}
function deshift($chipherText, $map){
    $dekripsi = array_flip($map); // Balik kunci map array
    $hasil = "";
    $indeks = 0;
    $length = strlen($chipherText);

    while ($indeks < $length){
        $cekKapital = false;
        
        if($chipherText[$indeks] === '#'){
            $cekKapital = true;
            $indeks++;
        }    
        $sandi = substr($chipherText, $indeks, 3);
        
        if(array_key_exists($sandi, $dekripsi)){
            $asli = $dekripsi[$sandi];
            $hasil .= $cekKapital ? strtoupper($asli) : $asli;
            $indeks += 3;
        } else {
            $hasil .= $chipherText[$indeks];
            $indeks += 1;
        }
    }
    return $hasil;
}

$input = "";
$hasilProses = "";
$operasi = "enkripsi";

if (isset($_POST['kirim'])){
    $input = $_POST['pesan'] ?? '';
    $operasi = $_POST['mode'] ?? 'enkripsi';

    if ($operasi === 'enkripsi'){
        $hasilProses = enshift($input, $pergantian);
    } else {
        $hasilProses = deshift($input, $pergantian);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Aplikasi Substitusi Biasa</title>
</head>
<body>

    <h3>Sistem Sandi Substitusi</h3>
    
    <form action="" method="POST">
        <p>
            <label for="mode">Pilih Operasi:</label><br>
            <select id="mode" name="mode">
                <option value="enkripsi" <?php echo ($operasi === 'enkripsi') ? 
                'selected' : ''; ?>>Enkripsi (Teks -> Kode Sandi)</option>
                <option value="dekripsi" <?php echo ($operasi === 'dekripsi') ? 
                'selected' : ''; ?>>Dekripsi (Kode Sandi -> Teks Asli)</option>
            </select>
        </p>
        <p>
            <label for="pesan">Masukkan Teks / Sandi:</label><br>
            <input type="text" id="pesan" name="pesan" size="50" required value="
            <?php echo htmlspecialchars($input); ?>">
        </p>

        <p>
            <button type="submit" name="kirim">Proses Data</button>
        </p>
    </form>

    <?php if (isset($_POST['kirim'])): ?>
        <hr>
        <h3>Hasil</h3>
        <table border="3" cellpadding="6" cellspacing="0">
            <tr>
                <td><b>Output</b></td>
                <td><code><?php echo htmlspecialchars($hasilProses); ?></code></td>
            </tr>
        </table>
    <?php endif; ?>

</body>
</html>