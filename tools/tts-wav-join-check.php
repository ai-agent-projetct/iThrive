<?php
/**
 * Check tts_wav_join(): joined speech must play for the full length.
 *
 * The bug it guards against was silent — glued WAV files still play, they just
 * stop after the first part — so the check measures what a player reads: the
 * sizes in the header, and the number of samples actually present.
 *
 *   php tools/tts-wav-join-check.php
 */

declare(strict_types=1);

require dirname(__DIR__) . '/includes/tts-wav.php';

/** A mono 16-bit WAV of $samples samples at 22,050 Hz, like Sarvam returns. */
function wav(int $samples, int $rate = 22050): string
{
    $pcm = '';
    for ($i = 0; $i < $samples; $i++) {
        $pcm .= pack('v', (int) (8000 * sin($i / 10)) & 0xFFFF);
    }
    $fmt = pack('vvVVvv', 1, 1, $rate, $rate * 2, 2, 16);

    return 'RIFF' . pack('V', 4 + 8 + 16 + 8 + strlen($pcm)) . 'WAVE'
         . 'fmt ' . pack('V', 16) . $fmt
         . 'data' . pack('V', strlen($pcm)) . $pcm;
}

/** [RIFF size, data size, bytes after the data header] as a player sees them. */
function sizes(string $w): array
{
    $riff = unpack('V', substr($w, 4, 4))[1];
    $pos  = strpos($w, 'data');

    return [$riff, unpack('V', substr($w, $pos + 4, 4))[1], strlen($w) - $pos - 8];
}

$fail = 0;
$ok = static function (bool $cond, string $what) use (&$fail): void {
    echo ($cond ? '  ok    ' : '  FAIL  '), $what, "\n";
    $fail += $cond ? 0 : 1;
};

$a = wav(22050);        // one second
$b = wav(11025);        // half a second
$c = wav(33075);        // one and a half seconds

$j = tts_wav_join([$a, $b, $c]);
$ok($j !== null, 'three parts join');

[$riff, $data, $present] = sizes((string) $j);
$ok($data === (22050 + 11025 + 33075) * 2, 'header declares all 3.0 seconds of samples');
$ok($present === $data, 'every declared sample is present');
$ok($riff === strlen((string) $j) - 8, 'RIFF size matches the file');

// What the old code produced, for contrast: glued bytes declare only part one.
[, $gluedDeclared] = sizes($a . $b . $c);
$ok($gluedDeclared === 22050 * 2, 'plain concatenation would declare only the first second (the bug)');

$ok(tts_wav_join([$a, wav(100, 16000)]) === null, 'parts with different formats are refused, not garbled');
$ok(tts_wav_join([$a, 'not a wav']) === null, 'a non-WAV part is refused');

echo $fail === 0 ? "\nall passed\n" : "\n$fail failed\n";
exit($fail === 0 ? 0 : 1);
