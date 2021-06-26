<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Helpers\Notiflix;
use App\Product;
use App\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AppController extends Controller
{
    public function home()
    {
        $products = Product::all();

        return view('home')->with('products', $products);
    }

    public function create_contact(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'name' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/contact')
                ->withErrors($validator)
                ->withInput();
        }

        Contact::create([
            'name' => $req->input('name'),
            'subject' => $req->input('subject'),
            'message' => $req->input('message'),
        ]);

        return redirect()
            ->route('contact')
            ->with(
                'alert',
                Notiflix::make([
                    'code' => 'success',
                    'title' => 'Hoorah!',
                    'subtitle' => 'Message sent successfully!',
                ])
            );
    }

    public function explore(Request $req)
    {
        $query = $req['q'];
        $category = $req['c'];
        $page_title = '';
        if (isset($query)) {
            $products = Product::where(
                'name',
                'like',
                '%' . $query . '%'
            )->paginate(12);
            if (count($products) == 0) {
                $sid = Seller::where('name', '=', $query)->get();
                if (count($sid) > 0) {
                    $products = Product::where(
                        'seller_id',
                        '=',
                        $sid[0]->id
                    )->paginate(12);
                }
            }
            if (count($products) == 0) {
                $products = Product::where(
                    'desc',
                    'like',
                    '%' . $query . '%'
                )->paginate(12);
            }
            $page_title = sprintf('Search Results for %s', $query);
        } elseif (isset($category)) {
            $products = Product::where('type', $category)->paginate(12);
            $page_title = sprintf('Category "%s"', $category);
        } else {
            $products = Product::where('active', 1)->paginate(12);
            $page_title = sprintf('Recently added');
        }

        return view('product.explore', compact('products', 'page_title'));
    }

    public function about()
    {
        return view('app.about');
    }
    public function contact()
    {
        return view('app.contact');
    }
}
