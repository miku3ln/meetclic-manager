<?php



namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class FrontendPagesOwnerCmsController  extends  Controller
{
    public function businessOwner(Request $request)
    {
        $slug = $request->route('slug');
        $section = $request->route('section');

        return view('cityBook.web.businessOwner.mikuy-yachak', [
            'slug' => $slug,
            'section' => $section
        ]);
    }
    public function muelleCatalina(Request $request)
    {
        $slug = $request->route('slug');
        $section = $request->route('section');

        return view('cityBook.web.businessOwner.muelle-catalina', [
            'slug' => $slug,
            'section' => $section
        ]);
    }
}
