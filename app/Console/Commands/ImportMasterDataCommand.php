<?php

namespace App\Console\Commands;

use App\Customer;
use App\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ImportMasterDataCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:masterdata';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            // Import Customers
            $this->info('Importing Customers...');
            $customerData = Http::get( env('APP_URL').'import/customers')->json();
            $importedCustomers = 0;
            $skippedCustomers = 0;
            foreach ($customerData as $customer) {
                $name = explode(' ',$customer[3]);
                $date = isset($customer[4])?date('Y-m-d',strtotime($customer[4])):null;
                if(!empty($customer[2])){
                    Customer::create([
                        'id' => $customer[0],
                        'job_title' => $customer[1],
                        'email' => $customer[2],
                        'first_name' => isset($name)?$name[0]:null,
                        'last_name' => isset($name)?$name[1]:null,
                        'registered_since' => $date,
                        'phone' => $customer[5],
                    ]);
                    $importedCustomers++;
                }else{
                    $skippedCustomers++;
                }
            }
            $this->info("Customers imported: $importedCustomers");
            $this->info("Customers skipped: $skippedCustomers");

            // Import Products
            $this->info('Importing Products...');
            $productData = Http::get( env('APP_URL').'import/products')->json();
            $importedProducts = 0;
            $skippedProducts = 0;

            foreach ($productData as $product) {
                if (Product::create([
                    'id' => $product[0],
                    'product_name' => $product[1],
                    'price' => $product[2],
                ])) {
                    $importedProducts++;
                } else {
                    $skippedProducts++;
                }
            }
            $this->info("Products imported: $importedProducts");
            $this->info("Products skipped: $skippedProducts");

            $this->info('Master data import completed.');

            // Logging import results
            Log::info("Import Summary: Customers imported: $importedCustomers, Customers skipped: $skippedCustomers, Products imported: $importedProducts, Products skipped: $skippedProducts");
        } catch (\Exception $e) {
            $this->error('An error occurred during the import: ' . $e->getMessage());
            Log::error('Error occurred during the import: ' . $e->getMessage());
        }
    }
}
