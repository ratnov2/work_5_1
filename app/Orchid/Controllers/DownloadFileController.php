<?php

namespace App\Orchid\Controllers;

use App\Containers\BoxUnique\Models\BoxPromocode;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class DownloadFileController extends Controller
{
    public function downloadBoxPromocodes()
    {
        $codes = BoxPromocode::active()->get();

        $content = "";
        foreach ($codes as $code) {
            $content .= $code->value;
            $content .= "\n";
        }

        $content .= "\n ------------------ С лимитом ------------------ \n";

        foreach ($codes as $code) {
            $content .= $code->value . ' | Limit:' . $code->limit;
            $content .= "\n";
        }

        // file name that will be used in the download
        $fileName = "Active box promocodes.txt";

        // use headers in order to generate the download
        $headers = [
            'Content-type' => 'text/plain',
            'Content-Disposition' => sprintf('attachment; filename="%s"', $fileName),
            'Content-Length' => strlen($content)
        ];

        // make a response, with the content, a 200 response code and the headers
        return Response::make($content, 200, $headers);
    }
}
