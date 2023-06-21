<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;

use Illuminate\Http\Request;
use App\Donation;
use App\Project;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Agreement;
use PayPal\Api\Payer;
use PayPal\Api\Plan;
use PayPal\Api\PaymentDefinition;
use PayPal\Api\PayerInfo;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Amount;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use Carbon\Carbon;

use URL;
use Session;

class DonationController extends Controller
{
    public function __construct()
    {

         /** PayPal api context **/
        $paypal_configuration = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_configuration['client_id'], $paypal_configuration['secret']));
        $this->_api_context->setConfig($paypal_configuration['settings']);
    }    
    public function add_donation(Request $request) {

      $project_name = Project::find($request->input('project_id'));
      $amountToBePaid = $request->input('amount');
      $payer = new Payer();
      $payer->setPaymentMethod('paypal');
  
      $item_1 = new Item();
      $item_1->setName('Donation project') /** название элемента **/
              ->setCurrency('USD')
              ->setQuantity(1)
              ->setPrice($amountToBePaid); /** цена **/
  
        $item_list = new ItemList();
      $item_list->setItems(array($item_1));

      $amount = new Amount();
      $amount->setCurrency('USD')
             ->setTotal($amountToBePaid);      
             
      $redirect_urls = new RedirectUrls();
      /** Укажите обратный URL **/
      $redirect_urls->setReturnUrl(URL::route('status'))
                ->setCancelUrl(URL::route('status'));
      
      $transaction = new Transaction();
      $transaction->setAmount($amount)
              ->setItemList($item_list)
              ->setDescription('Donation project ');   
   
      $payment = new Payment();
      $payment->setIntent('Sale')
              ->setPayer($payer)
              ->setRedirectUrls($redirect_urls)
              ->setTransactions(array($transaction));
      try {
           $payment->create($this->_api_context);
      } catch (\PayPal\Exception\PPConnectionException $ex) {
           if (\Config::get('app.debug')) {
              \Session::put('error', 'Connection timeout');
              return response()->json(['check' => 1]);
           } else {
              return response()->json(['check' => 2]);
           }
      }
      
      foreach ($payment->getLinks() as $link) {
        if ($link->getRel() == 'approval_url') {
           $redirect_url = $link->getHref();
           break;
        }
      }
      

      session()->put('paypal_payment_id', $payment->getId());
      
      if (isset($redirect_url)) {
         /** редиректим в paypal **/
         //return Redirect::away($redirect_url);
         $newDonation =  Donation::create($request->all());
         $newDonationId = $newDonation->id;
         session()->put('newDonationId', $newDonationId);
         return response()->json(['check' => 0, 'redirect_url'=>$redirect_url]);
      }
        
      return response()->json(['check' => 3]);
        //return response()->json(['check' => 1]);
    }
    public function getPaymentStatus(Request $request)
    {
          
          $payment_id = Session::get('paypal_payment_id');
          $newDonation = Session::get('newDonationId');
 
          Session::forget('paypal_payment_id');      
          Session::forget('newDonation');  
          if (empty($request->PayerID) || empty($request->token)) {
             //dd($payment_id);
          }      
          
          $payment = Payment::get($payment_id, $this->_api_context);
          $execution = new PaymentExecution();
          $execution->setPayerId($request->PayerID);      
          
          /** Выполняем платёж **/
          $result = $payment->execute($execution, $this->_api_context);
          
          if ($result->getState() == 'approved') {
            
            $donations = Donation::findOrFail($newDonation);
            $donations->paypal_payment_id = $payment_id;
            $donations->check = 1;
            $donations->save();
          }      
          
          //session()->flash('error', 'Платеж не прошел');
          return redirect('/my_donates');    
    }





    public function show_donated() {
        $donation = Donation::where('user_id', auth()->user()->id)->where('check', 1)->get();

        $donationByMonth = $donation->groupBy(function($donations) {
            return Carbon::parse($donations->created_at)->format('m');
        });

        $totalsByMonth = [];

        foreach ($donationByMonth as $month => $donation_s) {
            $total = $donation_s->sum('amount');
            $monthName = Carbon::createFromDate(null, $month, null)->format('F');

            $totalsByMonth[$monthName] = $total;
        }
        return view('my_donation',['donations'=>$donation,'totalsByMonth'=>$totalsByMonth]);
    }

    public function history_donated() {
        $projects_all = Project::where('user_id', auth()->user()->id)->get();
        $myproject_id = [];
        foreach ($projects_all as $project_all) {
            $myproject_id[]=$project_all->id;
        }
       
        $donation_my = Donation::WhereIn('project_id', $myproject_id)->where('check', 1)->get();
        $donationByMonth = $donation_my->groupBy(function($donations) {
            return Carbon::parse($donations->created_at)->format('m');
        });

        $totalsByMonth = [];

        foreach ($donationByMonth as $month => $donation_s) {
            $total = $donation_s->sum('amount');
            $monthName = Carbon::createFromDate(null, $month, null)->format('F');

            $totalsByMonth[$monthName] = $total;
        }
        return view('history_donation',['donation_my'=>$donation_my,'totalsByMonth'=>$totalsByMonth]);
    }
}
