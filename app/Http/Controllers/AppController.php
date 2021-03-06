<?php

namespace App\Http\Controllers;

use App\Helpers\Notiflix;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AppController extends Controller
{
    public function home()
    {
        $products = Product::where('active', 1)->get();
        return view('home', compact('products'));
    } // test done

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
        $seller = $req['s'];

        $products = Product::where('active', 1)->paginate(12);
        $sellers = Seller::all();
        $page_title = sprintf('Recently added');
        if (isset($query)) {
            $products = Product::where('active', 1)
                ->where('name', 'like', '%' . $query . '%')
                ->paginate(12);
            if (count($products) == 0) {
                $sid = Seller::where('name', '=', $query)->get();
                if (count($sid) > 0) {
                    $products = Product::where('active', 1)
                        ->where('seller_id', '=', $sid[0]->id)
                        ->paginate(12);
                }
            }
            if (count($products) == 0) {
                $products = Product::where('active', 1)
                    ->where('desc', 'like', '%' . $query . '%')
                    ->paginate(12);
            }
            $page_title = sprintf('Search Results for %s', $query);
        } elseif (isset($category)) {
            $products = Product::where('active', 1)
                ->where('type', $category)
                ->paginate(12);
            $page_title = sprintf(
                'Category "%s"',
                Product::$categories[$category]
            );
        } elseif (isset($seller)) {
            $seller = Seller::where('id', $seller)->first();
            if (isset($seller)) {
                $products = Product::where('active', 1)
                    ->where('seller_id', $seller->id)
                    ->paginate(12);
                $page_title = sprintf('Seller "%s"', $seller->trade_name);
            }
        }

        if ($req->ajax()) {
            $data = '';
            foreach ($products as $product) {
                $data .= view('components.productBox', compact('product'));
            }
            return json_encode([
                'success' => true,
                'data' => $data,
                'next_url' => $products
                    ->appends(request()->input())
                    ->nextPageUrl(),
            ]);
        }

        return view('product.explore', compact('products', 'page_title'));
    } // test done

    public function productBox(Request $req, $id)
    {
        $product = Product::where('active', 1)
            ->where('id', $id)
            ->first();
        return view('components.productBox', compact('product'));
    }

    public function about()
    {
        return view('app.about');
    }// test done

    public function contact()
    {
        return view('app.contact');
    }// test done
}
