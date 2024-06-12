<?php

namespace App\Http\Controllers\Corporate\Steganography;

use App\Http\Controllers\Controller;
use App\Models\Steganography;
use Illuminate\Http\Request;
use Ramsey\Uuid\Rfc4122\UuidV4;

class DecryptController extends Controller
{
    public function edit(Steganography $decrypt)
    {
        $decrypt->load('user');
        if ($decrypt->user->corporate_id != auth()->user()->corporate_id) {
            return redirect()->route('corporate.encrypt.index')->with('error', 'Decrypt not found');
        }
        $data = [
            'title' => 'Decrypt Image',
            'url' => route('corporate.decrypt.store', $decrypt->id),
            'home' => route('corporate.encrypt.index')
        ];
        return view('page.corporate-dashboard.steganography.decrypt', compact('data'));
    }

    public function decrypt_store(Steganography $decrypt, Request $request)
    {
        $request->validate([
            'password' => 'required'
        ]);

        $password = $request->password;

        $image = $decrypt->encrypted_image;
        $pattern = "/\/storage\/stegano_images\/[^ ]*/";

        preg_match($pattern, $image, $matches);
        $imagePath = public_path($matches[0]);

        // Membuat resource gambar dari file yang disimpan
        $img = null;
        $extension = pathinfo($imagePath, PATHINFO_EXTENSION);
        switch ($extension) {
            case 'jpg':
            case 'jpeg':
                $img = imagecreatefromjpeg($imagePath);
                break;
            case 'png':
                $img = imagecreatefrompng($imagePath);
                break;
            default:
                return redirect()->back()->withErrors(['image' => 'Unsupported image format.']);
        }

        $message = $this->extractMessage($img);
        $message = str_rot13($message);

        $patternPassword = "/password:([^\|]*)/";
        $patternFileType = "/filetype:([^\|]*)/";
        $patternFileData = "/base64:([^\|]*)/";

        if (preg_match($patternPassword, $message, $matches)) {
            if (password_verify($password, $matches[1])) {
                preg_match($patternFileType, $message, $matchesType);
                preg_match($patternFileData, $message, $matchesData);
                $name = UuidV4::uuid4();
                switch ($matchesType[1]) {
                    case 'pdf':
                    case 'jpg':
                    case 'jpeg':
                    case 'png':
                    case 'txt':
                        $file = base64_decode($matchesData[1]);
                        $stream = fopen('php://memory', 'rb+');
                        fwrite($stream, $file);
                        rewind($stream);
                        return response()->streamDownload(function () use ($stream) {
                            fpassthru($stream);
                            fclose($stream);
                        }, $name . '.' . $matchesType[1], [
                            'Content-Type' => $this->getContentType($matchesType[1]),
                            'Content-Disposition' => 'attachment; filename="' . $name . '.' . $matchesType[1] . '"'
                        ]);
                    default:
                        return back()->withInput()->withErrors(['password' => 'File type not supported']);
                }
            } else {
                return back()->withInput()->withErrors(['password' => 'Password salah']);
            }
        } else {
            return back()->withInput()->withErrors(['password' => 'No password format found.']);
        }
    }

    private function getContentType($fileType)
    {
        $mimeTypes = [
            'pdf' => 'application/pdf',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'txt' => 'text/plain'
        ];

        return $mimeTypes[$fileType] ?? 'application/octet-stream';
    }

    public function extractMessage($img)
    {
        $width = imagesx($img);
        $height = imagesy($img);
        $binaryMessage = '';
        $extractedMessage = '';

        // Menelusuri setiap piksel untuk mengekstrak LSB
        for ($y = 0; $y < $height; $y++) {
            for ($x = 0; $x < $width; $x++) {
                $rgb = imagecolorat($img, $x, $y);
                $colors = [
                    ($rgb >> 16) & 0xFF, // R
                    ($rgb >> 8) & 0xFF,  // G
                    $rgb & 0xFF          // B
                ];

                // Ekstrak LSB dari setiap channel R, G, B
                foreach ($colors as $color) {
                    $binaryMessage .= $color & 1;
                }
            }
        }

        // Konversi string biner kembali menjadi teks
        for ($i = 0; $i < strlen($binaryMessage) - 8; $i += 8) {
            $byte = substr($binaryMessage, $i, 8);
            $character = chr(bindec($byte));
            if ($character == "\0") {
                break; // Menghentikan pembacaan jika menemukan karakter null (akhir pesan)
            }
            $extractedMessage .= $character;
        }

        return $extractedMessage;
    }
}
