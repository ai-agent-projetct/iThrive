<?php

declare(strict_types=1);

/**
 * Join WAV files into one.
 *
 * Unlike MP3 frames, WAV files cannot be concatenated byte for byte: each one
 * opens with a header that states its own length, so a player given two glued
 * files plays the first and stops. Every answer longer than one synthesis
 * chunk was being cut off after its first few sentences. This keeps the first
 * file's format, concatenates the audio samples, and writes one header for the
 * total. Returns null if the parts disagree on format.
 *
 * @param array<int, string> $wavs
 */
function tts_wav_join(array $wavs): ?string
{
    $fmt = null;
    $pcm = '';

    foreach ($wavs as $w) {
        if (substr($w, 0, 4) !== 'RIFF' || substr($w, 8, 4) !== 'WAVE') {
            return null;
        }
        $pos  = 12;
        $data = null;
        while ($pos + 8 <= strlen($w)) {
            $id   = substr($w, $pos, 4);
            $size = unpack('V', substr($w, $pos + 4, 4))[1];
            if ($id === 'fmt ') {
                $f = substr($w, $pos + 8, $size);
                $fmt ??= $f;
                if ($f !== $fmt) {
                    return null;
                }
            } elseif ($id === 'data') {
                $data = substr($w, $pos + 8, min($size, strlen($w) - $pos - 8));
                break;
            }
            $pos += 8 + $size + ($size & 1);
        }
        if ($data === null || $fmt === null) {
            return null;
        }
        $pcm .= $data;
    }

    $fmtChunk  = 'fmt ' . pack('V', strlen($fmt)) . $fmt;
    $dataChunk = 'data' . pack('V', strlen($pcm)) . $pcm;

    return 'RIFF' . pack('V', 4 + strlen($fmtChunk) + strlen($dataChunk)) . 'WAVE' . $fmtChunk . $dataChunk;
}
