<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'seller_id',
        'desc',
        'price',
        'name',
        'unit',
        'quantity',
        'slug',
        'discount',
        'active',
    ];

    public static $units = [
        'KGS' => 'Kilograms (KGS)',
        'PCS' => 'Pieces (PCS)',
        'UNT' => 'Units (UNT)',
        'NOS' => 'Numbers (NOS)',
        'BAG' => 'Bags (BAG)',
        'BAL' => 'Bale (BAL)',
        'BDL' => 'Bundles (BDL)',
        'BKL' => 'Buckles (BKL)',
        'BOU' => 'Billions Of Units (BOU)',
        'BOX' => 'Box (BOX) ',
        'BTL' => 'Bottles (BTL)',
        'BUN' => 'Bunches (BUN)',
        'CAN' => 'Cans (CAN)',
        'CBM' => 'Cubic Meter (CBM)',
        'CCM' => 'Cubic Centimeter (CCM)',
        'CMS' => 'Centimeter (CMS)',
        'CTN' => 'Cartons (CTN)',
        'DOZ' => 'Dozen (DOZ)',
        'DRM' => 'Drum (DRM)',
        'GGR' => 'Great Gross (GGR)',
        'GMS' => 'Grams (GMS)',
        'GRS' => 'Gross (GRS)',
        'GYD' => 'Gross Yards (GYD)',
        'KLR' => 'Kiloliter (KLR)',
        'KME' => 'Kilometre (KME)',
        'MLT' => 'Millilitre (MLT)',
        'MTR' => 'Meters (MTR)',
        'MTS' => 'Metric Tons (MTS)',
        'PAC' => 'Packs (PAC)',
        'PRS' => 'Pairs (PRS)',
        'QTL' => 'Quintal (QTL)',
        'ROL' => 'Rolls (ROL)',
        'SET' => 'Sets (SET)',
        'SQF' => 'Square Feet (SQF)',
        'SQM' => 'Square Meters (SQM)',
        'SQY' => 'Square Yards (SQY)',
        'TBS' => 'Tablets (TBS)',
        'TGM' => 'Ten Gross (TGM)',
        'THD' => 'Thousands (THD)',
        'TON' => 'Tonnes (TON)',
        'TUB' => 'Tubes (TUB)',
        'UGS' => 'Us Gallons (UGS)',
        'YDS' => 'Yards (YDS)',
    ];

    public static $categories = [
        'Vegetables',
        'Fruits',
        'Cereals',
        'Pulses',
        'Nuts',
        'Oils',
        'Fibre Crops',
        'Beverages',
        'Spices',
        'Sugar and starch',
        'Manure',
        // 'Farming Utilites',
        // 'Seeds',
        // 'Fertilizers',
    ];

    public function seller()
    {
        return $this->belongsTo(Seller::class, 'seller_id');
    }

    public function coverPhotos()
    {
        return $this->hasMany(FileImage::class, 'ref_id')->where(
            'type',
            'products'
        );
    }

    public function getProductUnitAttribute()
    {
        return $this::$units[$this->unit];
    }

    public function getCategoryAttribute()
    {
        return $this::$categories[$this->type];
    }

    public function getDiscountedPriceAttribute()
    {
        return $this->price * (1 - $this->discount);
    }

}
