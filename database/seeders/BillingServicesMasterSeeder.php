<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BillingServicesMasterSeeder extends Seeder
{
    public function run(): void
    {
        // Truncate dependent table first to avoid FK constraint errors
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('billing_offers_services')->truncate();
        DB::table('billing_services_master')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $now = now();

        // Helper: offer active Apr 2026
        $os = '2026-04-01';
        $oe = '2026-04-30';

        $services = [
            // ── Beauty Packages › Ayurveda ──────────────────────────────────────
            ['code'=>'ONSGSS-01','category'=>'Beauty Packages','sub_category'=>'Ayurveda',
             'service_name'=>'Nazyam - For Curing Headaches, Migraine, Sinusitis',
             'hsn'=>'999729','unit'=>'Sessions','status'=>'Not Active',
             'max_price'=>5000.00,'min_price'=>2000.00,'product_cost'=>null,
             'tax_applicable_1'=>1,'tax_applicable_2'=>2,'finance_applicable'=>'yes','deffered_payment_applicable'=>'yes',
             'offer_s_date'=>null,'offer_e_date'=>null,'offer_amount'=>null],

            ['code'=>'ONSGSS-02','category'=>'Beauty Packages','sub_category'=>'Ayurveda',
             'service_name'=>'Panchakarma Therapy',
             'hsn'=>'998729','unit'=>'Sessions','status'=>'Not Active',
             'max_price'=>18000.00,'min_price'=>3000.00,'product_cost'=>null,
             'tax_applicable_1'=>1,'tax_applicable_2'=>2,'finance_applicable'=>'yes','deffered_payment_applicable'=>'yes',
             'offer_s_date'=>null,'offer_e_date'=>null,'offer_amount'=>null],

            ['code'=>'ONSGSS-03','category'=>'Beauty Packages','sub_category'=>'Ayurveda',
             'service_name'=>'Siru Dhara - For Dandruff, Psoriasis, Hypertension, Sinusitis',
             'hsn'=>'999729','unit'=>'Sessions','status'=>'Not Active',
             'max_price'=>5000.00,'min_price'=>2500.00,'product_cost'=>null,
             'tax_applicable_1'=>1,'tax_applicable_2'=>2,'finance_applicable'=>'yes','deffered_payment_applicable'=>'yes',
             'offer_s_date'=>null,'offer_e_date'=>null,'offer_amount'=>null],

            ['code'=>'ONSGSS-04','category'=>'Beauty Packages','sub_category'=>'Ayurveda',
             'service_name'=>'Dryness of Nostrils, Mouth and Throat Treatment',
             'hsn'=>'999729','unit'=>'Sessions','status'=>'Not Active',
             'max_price'=>5000.00,'min_price'=>2500.00,'product_cost'=>null,
             'tax_applicable_1'=>1,'tax_applicable_2'=>2,'finance_applicable'=>'yes','deffered_payment_applicable'=>'yes',
             'offer_s_date'=>null,'offer_e_date'=>null,'offer_amount'=>null],

            // ── Beauty Packages › Advanced Treatments ───────────────────────────
            ['code'=>'ONSGSS-05','category'=>'Beauty Packages','sub_category'=>'Beauty - Advanced Treatments',
             'service_name'=>'C-VII Liposomal Serum',
             'hsn'=>'999729','unit'=>'Sessions','status'=>'Active',
             'max_price'=>2500.00,'min_price'=>null,'product_cost'=>null,
             'tax_applicable_1'=>1,'tax_applicable_2'=>2,'finance_applicable'=>'yes','deffered_payment_applicable'=>'yes',
             'offer_s_date'=>$os,'offer_e_date'=>$oe,'offer_amount'=>2000.00],

            ['code'=>'ONSGSS-06','category'=>'Beauty Packages','sub_category'=>'Beauty - Advanced Treatments',
             'service_name'=>'Janssen Skin Brightening Treatment Pkg',
             'hsn'=>'999729','unit'=>'Sessions','status'=>'Active',
             'max_price'=>4500.00,'min_price'=>2250.00,'product_cost'=>null,
             'tax_applicable_1'=>1,'tax_applicable_2'=>2,'finance_applicable'=>'yes','deffered_payment_applicable'=>'yes',
             'offer_s_date'=>$os,'offer_e_date'=>$oe,'offer_amount'=>3500.00],

            ['code'=>'ONSGSS-07','category'=>'Beauty Packages','sub_category'=>'Beauty - Advanced Treatments',
             'service_name'=>'Macadamia Hair Spa-Pkg',
             'hsn'=>'998729','unit'=>'Sessions','status'=>'Active',
             'max_price'=>5000.00,'min_price'=>4199.00,'product_cost'=>null,
             'tax_applicable_1'=>1,'tax_applicable_2'=>2,'finance_applicable'=>'yes','deffered_payment_applicable'=>'yes',
             'offer_s_date'=>$os,'offer_e_date'=>$oe,'offer_amount'=>3999.00],

            ['code'=>'ONSGSS-08','category'=>'Beauty Packages','sub_category'=>'Beauty - Advanced Treatments',
             'service_name'=>'Magic Ink',
             'hsn'=>'999729','unit'=>'Sessions','status'=>'Active',
             'max_price'=>20000.00,'min_price'=>5000.00,'product_cost'=>null,
             'tax_applicable_1'=>1,'tax_applicable_2'=>2,'finance_applicable'=>'yes','deffered_payment_applicable'=>'yes',
             'offer_s_date'=>null,'offer_e_date'=>null,'offer_amount'=>null],

            ['code'=>'ONSGSS-09','category'=>'Beauty Packages','sub_category'=>'Beauty - Advanced Treatments',
             'service_name'=>'MBL (Microblotting)',
             'hsn'=>'999729','unit'=>'Sessions','status'=>'Active',
             'max_price'=>5000.00,'min_price'=>2499.00,'product_cost'=>null,
             'tax_applicable_1'=>1,'tax_applicable_2'=>2,'finance_applicable'=>'yes','deffered_payment_applicable'=>'yes',
             'offer_s_date'=>null,'offer_e_date'=>null,'offer_amount'=>null],

            ['code'=>'ONSGSS-10','category'=>'Beauty Packages','sub_category'=>'Beauty - Advanced Treatments',
             'service_name'=>'Microblading',
             'hsn'=>'999729','unit'=>'Sessions','status'=>'Active',
             'max_price'=>7999.00,'min_price'=>5000.00,'product_cost'=>null,
             'tax_applicable_1'=>1,'tax_applicable_2'=>2,'finance_applicable'=>'yes','deffered_payment_applicable'=>'yes',
             'offer_s_date'=>$os,'offer_e_date'=>$oe,'offer_amount'=>5999.00],

            ['code'=>'ONSGSS-11','category'=>'Beauty Packages','sub_category'=>'Beauty - Advanced Treatments',
             'service_name'=>'Microblading Eye Liner',
             'hsn'=>'999729','unit'=>'Sessions','status'=>'Active',
             'max_price'=>30000.00,'min_price'=>25000.00,'product_cost'=>null,
             'tax_applicable_1'=>1,'tax_applicable_2'=>2,'finance_applicable'=>'yes','deffered_payment_applicable'=>'yes',
             'offer_s_date'=>null,'offer_e_date'=>null,'offer_amount'=>null],

            ['code'=>'ONSGSS-12','category'=>'Beauty Packages','sub_category'=>'Beauty - Advanced Treatments',
             'service_name'=>'Microblading Lips',
             'hsn'=>'999729','unit'=>'Sessions','status'=>'Active',
             'max_price'=>50000.00,'min_price'=>75000.00,'product_cost'=>null,
             'tax_applicable_1'=>1,'tax_applicable_2'=>2,'finance_applicable'=>'yes','deffered_payment_applicable'=>'yes',
             'offer_s_date'=>null,'offer_e_date'=>null,'offer_amount'=>null],

            // ── Slimming › Body Contouring ───────────────────────────────────────
            ['code'=>'SLIM-01','category'=>'Slimming','sub_category'=>'Body Contouring',
             'service_name'=>'CoolSculpting',
             'hsn'=>'999729','unit'=>'Sessions','status'=>'Active',
             'max_price'=>15000.00,'min_price'=>8000.00,'product_cost'=>null,
             'tax_applicable_1'=>1,'tax_applicable_2'=>2,'finance_applicable'=>'yes','deffered_payment_applicable'=>'yes',
             'offer_s_date'=>$os,'offer_e_date'=>$oe,'offer_amount'=>7500.00],

            ['code'=>'SLIM-02','category'=>'Slimming','sub_category'=>'Body Contouring',
             'service_name'=>'VelaShape III',
             'hsn'=>'999729','unit'=>'Sessions','status'=>'Active',
             'max_price'=>12000.00,'min_price'=>6000.00,'product_cost'=>null,
             'tax_applicable_1'=>1,'tax_applicable_2'=>2,'finance_applicable'=>'yes','deffered_payment_applicable'=>'yes',
             'offer_s_date'=>$os,'offer_e_date'=>$oe,'offer_amount'=>5500.00],

            ['code'=>'SLIM-03','category'=>'Slimming','sub_category'=>'Body Contouring',
             'service_name'=>'FATX',
             'hsn'=>'999729','unit'=>'Sessions','status'=>'Active',
             'max_price'=>10000.00,'min_price'=>5000.00,'product_cost'=>null,
             'tax_applicable_1'=>1,'tax_applicable_2'=>2,'finance_applicable'=>'yes','deffered_payment_applicable'=>'yes',
             'offer_s_date'=>null,'offer_e_date'=>null,'offer_amount'=>null],

            // ── Slimming › Weight Loss ───────────────────────────────────────────
            ['code'=>'SLIM-04','category'=>'Slimming','sub_category'=>'Weight Loss',
             'service_name'=>'Aroma Veda Therapy',
             'hsn'=>'999729','unit'=>'Sessions','status'=>'Active',
             'max_price'=>8000.00,'min_price'=>4000.00,'product_cost'=>null,
             'tax_applicable_1'=>1,'tax_applicable_2'=>2,'finance_applicable'=>'yes','deffered_payment_applicable'=>'yes',
             'offer_s_date'=>null,'offer_e_date'=>null,'offer_amount'=>null],

            ['code'=>'SLIM-05','category'=>'Slimming','sub_category'=>'Weight Loss',
             'service_name'=>'Lymphatic Drainage Massage',
             'hsn'=>'999729','unit'=>'Sessions','status'=>'Active',
             'max_price'=>6000.00,'min_price'=>3000.00,'product_cost'=>null,
             'tax_applicable_1'=>1,'tax_applicable_2'=>2,'finance_applicable'=>'yes','deffered_payment_applicable'=>'yes',
             'offer_s_date'=>null,'offer_e_date'=>null,'offer_amount'=>null],

            // ── Hair › Hair Restoration ──────────────────────────────────────────
            ['code'=>'HAIR-01','category'=>'Hair','sub_category'=>'Hair Restoration',
             'service_name'=>'GFC (Growth Factor Concentrate)',
             'hsn'=>'999729','unit'=>'Sessions','status'=>'Active',
             'max_price'=>8000.00,'min_price'=>4000.00,'product_cost'=>null,
             'tax_applicable_1'=>1,'tax_applicable_2'=>2,'finance_applicable'=>'yes','deffered_payment_applicable'=>'yes',
             'offer_s_date'=>$os,'offer_e_date'=>$oe,'offer_amount'=>3500.00],

            ['code'=>'HAIR-02','category'=>'Hair','sub_category'=>'Hair Restoration',
             'service_name'=>'Hair Pro',
             'hsn'=>'999729','unit'=>'Sessions','status'=>'Active',
             'max_price'=>6000.00,'min_price'=>3000.00,'product_cost'=>null,
             'tax_applicable_1'=>1,'tax_applicable_2'=>2,'finance_applicable'=>'yes','deffered_payment_applicable'=>'yes',
             'offer_s_date'=>$os,'offer_e_date'=>$oe,'offer_amount'=>2800.00],

            ['code'=>'HAIR-03','category'=>'Hair','sub_category'=>'Hair Restoration',
             'service_name'=>'Threads',
             'hsn'=>'999729','unit'=>'Sessions','status'=>'Active',
             'max_price'=>5000.00,'min_price'=>2500.00,'product_cost'=>null,
             'tax_applicable_1'=>1,'tax_applicable_2'=>2,'finance_applicable'=>'yes','deffered_payment_applicable'=>'yes',
             'offer_s_date'=>null,'offer_e_date'=>null,'offer_amount'=>null],

            // ── Salon › Basic Services ───────────────────────────────────────────
            ['code'=>'SALON-01','category'=>'Salon','sub_category'=>'Basic Services',
             'service_name'=>'Hair Cut',
             'hsn'=>'999729','unit'=>'Sessions','status'=>'Active',
             'max_price'=>500.00,'min_price'=>200.00,'product_cost'=>null,
             'tax_applicable_1'=>1,'tax_applicable_2'=>2,'finance_applicable'=>'yes','deffered_payment_applicable'=>'yes',
             'offer_s_date'=>null,'offer_e_date'=>null,'offer_amount'=>null],

            ['code'=>'SALON-02','category'=>'Salon','sub_category'=>'Basic Services',
             'service_name'=>'Hair Wash - Medium',
             'hsn'=>'999729','unit'=>'Sessions','status'=>'Active',
             'max_price'=>600.00,'min_price'=>300.00,'product_cost'=>null,
             'tax_applicable_1'=>1,'tax_applicable_2'=>2,'finance_applicable'=>'yes','deffered_payment_applicable'=>'yes',
             'offer_s_date'=>null,'offer_e_date'=>null,'offer_amount'=>null],

            ['code'=>'SALON-03','category'=>'Salon','sub_category'=>'Basic Services',
             'service_name'=>'Glow Facial',
             'hsn'=>'999729','unit'=>'Sessions','status'=>'Active',
             'max_price'=>1500.00,'min_price'=>800.00,'product_cost'=>null,
             'tax_applicable_1'=>1,'tax_applicable_2'=>2,'finance_applicable'=>'yes','deffered_payment_applicable'=>'yes',
             'offer_s_date'=>$os,'offer_e_date'=>$oe,'offer_amount'=>999.00],

            ['code'=>'SALON-04','category'=>'Salon','sub_category'=>'Basic Services',
             'service_name'=>'Pedicure',
             'hsn'=>'999729','unit'=>'Sessions','status'=>'Active',
             'max_price'=>800.00,'min_price'=>400.00,'product_cost'=>null,
             'tax_applicable_1'=>1,'tax_applicable_2'=>2,'finance_applicable'=>'yes','deffered_payment_applicable'=>'yes',
             'offer_s_date'=>null,'offer_e_date'=>null,'offer_amount'=>null],

            ['code'=>'SALON-05','category'=>'Salon','sub_category'=>'Basic Services',
             'service_name'=>'Manicure',
             'hsn'=>'999729','unit'=>'Sessions','status'=>'Active',
             'max_price'=>700.00,'min_price'=>350.00,'product_cost'=>null,
             'tax_applicable_1'=>1,'tax_applicable_2'=>2,'finance_applicable'=>'yes','deffered_payment_applicable'=>'yes',
             'offer_s_date'=>null,'offer_e_date'=>null,'offer_amount'=>null],

            ['code'=>'SALON-06','category'=>'Salon','sub_category'=>'Basic Services',
             'service_name'=>'Waxing - Half Legs',
             'hsn'=>'999729','unit'=>'Sessions','status'=>'Active',
             'max_price'=>500.00,'min_price'=>250.00,'product_cost'=>null,
             'tax_applicable_1'=>1,'tax_applicable_2'=>2,'finance_applicable'=>'yes','deffered_payment_applicable'=>'yes',
             'offer_s_date'=>null,'offer_e_date'=>null,'offer_amount'=>null],

            ['code'=>'SALON-07','category'=>'Salon','sub_category'=>'Basic Services',
             'service_name'=>'Waxing - Half Arms',
             'hsn'=>'999729','unit'=>'Sessions','status'=>'Active',
             'max_price'=>400.00,'min_price'=>200.00,'product_cost'=>null,
             'tax_applicable_1'=>1,'tax_applicable_2'=>2,'finance_applicable'=>'yes','deffered_payment_applicable'=>'yes',
             'offer_s_date'=>null,'offer_e_date'=>null,'offer_amount'=>null],

            ['code'=>'SALON-08','category'=>'Salon','sub_category'=>'Basic Services',
             'service_name'=>'Threading - Eyebrows',
             'hsn'=>'999729','unit'=>'Sessions','status'=>'Active',
             'max_price'=>100.00,'min_price'=>50.00,'product_cost'=>null,
             'tax_applicable_1'=>1,'tax_applicable_2'=>2,'finance_applicable'=>'yes','deffered_payment_applicable'=>'yes',
             'offer_s_date'=>null,'offer_e_date'=>null,'offer_amount'=>null],

            ['code'=>'SALON-09','category'=>'Salon','sub_category'=>'Basic Services',
             'service_name'=>'Shave',
             'hsn'=>'999729','unit'=>'Sessions','status'=>'Active',
             'max_price'=>200.00,'min_price'=>100.00,'product_cost'=>null,
             'tax_applicable_1'=>1,'tax_applicable_2'=>2,'finance_applicable'=>'yes','deffered_payment_applicable'=>'yes',
             'offer_s_date'=>null,'offer_e_date'=>null,'offer_amount'=>null],

            ['code'=>'SALON-10','category'=>'Salon','sub_category'=>'Basic Services',
             'service_name'=>'Bleach - Face & Neck',
             'hsn'=>'999729','unit'=>'Sessions','status'=>'Active',
             'max_price'=>600.00,'min_price'=>300.00,'product_cost'=>null,
             'tax_applicable_1'=>1,'tax_applicable_2'=>2,'finance_applicable'=>'yes','deffered_payment_applicable'=>'yes',
             'offer_s_date'=>null,'offer_e_date'=>null,'offer_amount'=>null],

            ['code'=>'SALON-11','category'=>'Salon','sub_category'=>'Basic Services',
             'service_name'=>'Scalp Massage - Olive Oil',
             'hsn'=>'999729','unit'=>'Sessions','status'=>'Active',
             'max_price'=>500.00,'min_price'=>250.00,'product_cost'=>null,
             'tax_applicable_1'=>1,'tax_applicable_2'=>2,'finance_applicable'=>'yes','deffered_payment_applicable'=>'yes',
             'offer_s_date'=>null,'offer_e_date'=>null,'offer_amount'=>null],
        ];

        foreach ($services as $service) {
            DB::table('billing_services_master')->insert(array_merge($service, [
                'created_at' => $now,
                'updated_at' => $now,
            ]));
        }

        $this->command->info('billing_services_master refreshed: ' . count($services) . ' records.');
    }
}
