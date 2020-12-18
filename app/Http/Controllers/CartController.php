<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    //
    public function getDiscounts(Request $req)
    {
        $newCart = [];
        $complexDiscountIsOn = true;
        $cheapest = null;
        $numberOfProductsWithCountMinimum2 = 0;

        foreach ($req->input('products') as $product)
        {
            //Product specific discounts
            $matched = Product::all()->find($product['id']);
            if($matched)
            {
                switch($matched->discount->type)
                {
                    case 'BUYXGETYFREE':
                        $data = explode(';', $matched->discount->data);
                        $x = intval($data[0]);
                        $y = intval($data[1]);
                        if($product['count'] >= $y+$x) {
                            $numberFree = floor($product['count']/($y+$x))*$y;
                            $product['total'] -= $numberFree*$product['unitPrice'];
                        }
                        $product['discount'] = 'Buy ' . $x . ' get ' . $y . ' free';
                        break;
                    case 'SIMPLEDISCOUNT':
                        $product['total'] *= 1 - floatval($matched->discount->data);
                        $product['discount'] = floatval($matched->discount->data)*100 . '% discount';
                        break;
                }
            }

            //General discounts
            //3 different products, at least 2 of each, cheapest at 50%
            if($complexDiscountIsOn)
            {
                if($cheapest == null || ($product['unitPrice'] < $cheapest['unitPrice'] && $product['count'] >= 2)) $cheapest = $product;
                if($product['count'] >= 2) ++$numberOfProductsWithCountMinimum2;
            }

            array_push($newCart, $product);
        }
        //3 different products, at least 2 of each, cheapest at 50%
        if($complexDiscountIsOn && $numberOfProductsWithCountMinimum2 >= 3) {
            $tempArray = [];
            foreach($newCart as $cartProduct)
            {
                if($cartProduct['id'] == $cheapest['id'])
                {
                    $cartProduct['total'] *= 0.5;
                    if(array_key_exists('discount', $cartProduct))
                    {
                        $cartProduct['discount'] += ', complex discount 50% off';
                    }
                    else
                    {
                        $cartProduct['discount'] = 'complex discount 50% off';
                    }
                }
                array_push($tempArray, $cartProduct);
            }
            $newCart = $tempArray;
        }

        return $newCart;
    }

}
