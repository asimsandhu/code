<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\QueryException;
use App\Models\APIsModel\Subscriber;
use App\Models\APIsModel\SubDetails;
use App\Models\APIsModel\UnSubscribed;
use App\Models\APIsModel\IncomingCall;
use App\Models\APIsModel\DailyChargeAttempts;
use App\Models\APIsModel\Service;
use App\Models\APIsModel\SuccessChargeDetail;
use App\Models\APIsModel\SubscriberHistory;
use App\Models\APIsModel\KNReporting;
use App\Models\APIsModel\MAU_DAU;
use App\Models\APIsModel\ChargeAttempts;
use App\Models\APIsModel\AppParameters;
use Carbon\Carbon;

class KN_reporting extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'knReporting:run';

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

     *
     **/
    public function handle()

        {
            $datetime =Carbon::now();

            $dated = Carbon::now()->toDateString();
// $datetime = '2021-04-25 00:00:00';
//  $dated = '2021-04-25';
            log::debug("================== Starting KN Reporting Job ".$dated." ====================");

            // pulling data from subscriber table where last call date is current date
            $subscribers = Subscriber::whereDate('last_call_dt',$dated)->select('cellno')->get();
            if($subscribers->count() > 0)
            {
                foreach($subscribers as $sub)
                {
//                inserting cellno to MAU_DAU for today's callers
                    MAU_DAU::create([
                        'Dated' => $dated,
                        'cellno' => $sub->cellno ]);


                }        }
            // calculating total Subscribers for current date
            $TOTAL_SUB = SubDetails::whereDate('sub_dt',$dated)->get()->count();

            // $TOTAL_SUB_RESUB = SubDetails:: whereHas('unsubs', function($q){
            //     $q->where('unsub_dt','LIKE','2021-04-18'.'%');
            // })->get()->count();

            // $TOTAL_SUB = $TOTAL_SUB - $TOTAL_SUB_RESUB;
            log::info('TOTAL_SUB : '.$TOTAL_SUB);

            // calculating total UNSUB for current date who didnot resub
            $TOTAL_UNSUB = UnSubscribed::with('subscriber')->whereDate('unsub_dt',$dated)->get()->count();

            $TOTAL_UNSUB_SUB = UnSubscribed:: whereHas('subscriber', function($q){
                $q->whereDate('unsub_dt',Carbon::now()->toDateString());
            })->get()->count();

            $TOTAL_UNSUB = $TOTAL_UNSUB - $TOTAL_UNSUB_SUB;

            log::info('TOTAL_UNSUB : '.$TOTAL_UNSUB);
            // calculating same day RESUB
            $SAME_DAY_RESUB = Subscriber::whereDate('sub_dt',$dated)->whereDate('unsub_dt',$dated)
                ->get()->count();
            log::info('SAME_DAY_RESUB : '.$SAME_DAY_RESUB);

            // calculating SAMEDDAY UNSUB
            $SAMEDAY_UNSUB = UnSubscribed::whereDate('sub_dt',$dated)->whereDate('unsub_dt',$dated)->get()->count();
            log::info('SAMEDAY_UNSUB : '.$SAMEDAY_UNSUB);

            // calculating CHARGE SUB
            $CHARGE_SUB_SUB = Subscriber::whereDate('sub_dt',$dated)->whereDate('last_charge_dt',$dated)->get()->count();
            $CHARGE_SUB_UNSUB = UnSubscribed::whereDate('sub_dt',$dated)->whereDate('last_charge_dt',$dated)->get()->count();
            $CHARGE_SUB = $CHARGE_SUB_SUB + $CHARGE_SUB_UNSUB;

        // calculating CHARGE FAIL SUB
        $CHARGE_FAIL_SUB = Subscriber::whereDate('sub_dt',$dated)->whereNull('last_charge_dt')->get()->count();
        log::info('CHARGE_FAIL_SUB : '.$CHARGE_FAIL_SUB);

        // calculating CHARGE SUCCESS (Renew + Reattempt)
        // $CHARGE_SUCCESS = DailyChargeAttempts::whereDate('request_dt',$dated)->where('response_code',100)->get()->count();
        // $CHARGE_SUCCESS = SuccessChargeDetail::whereDate('created',$dated)->get()->count();
        $CHARGE_SUCCESS_SUB = Subscriber::whereDate('last_charge_dt',$dated)->whereDate('sub_dt','!=',$dated)->get()->count();
        $CHARGE_SUCCESS_UNSUB = UnSubscribed::whereDate('last_charge_dt',$dated)->whereDate('sub_dt','!=',$dated)->get()->count();
        $CHARGE_SUCCESS = $CHARGE_SUCCESS_SUB + $CHARGE_SUCCESS_UNSUB;
        log::info('CHARGE_SUCCESS(Re[new+attempt]) : '.$CHARGE_SUCCESS);

        // calculating CHARGE FAIL SUB (Renew + Reattempt)
        // $CHARGE_FAIL = DailyChargeAttempts::whereDate('request_dt',$dated)->where('response_code','!=',100)->get()->count();
//             $CHARGE_FAIL = Subscriber::whereDate('charge_attempt_dt',$dated)->whereDate('last_charge_dt','!=',$dated)->get()->count();
//            $CHARGE_FAIL = ChargeAttempts::whereDate('request_dt',$dated)->where('response_code','!=','100')->groupBy('cellno')->get()->count();
        $CHARGE_FAIL = DB::table('charge_process')->where('stat','-100')->get()->count();
        log::info('CHARGE_FAIL(Re[new+attempt]) : '.$CHARGE_FAIL);


        // calculating total DAILIN_ENGAGEMENT
        $DAILIN_ENGAGEMENT = IncomingCall::whereDate('start_dt',$dated)->select('cellno')->groupBy('cellno')->get()->count();
        log::info('DAILIN_ENGAGEMENT : '.$DAILIN_ENGAGEMENT);

        // calculating GRACE_NEW
        $GRACE_NEW = Subscriber::whereDate('sub_dt',$dated)->whereDate('grace_expire_dt','>=',$dated)
            ->get()->count();
        log::info('GRACE_NEW : '.$GRACE_NEW);

        // calculating GRACE_NEW
        $GRACE_OLD = Subscriber::whereDate('sub_dt','<>',$dated)->whereDate('grace_expire_dt','>=',$dated)
            ->get()->count();
        log::info('GRACE_OLD : '.$GRACE_OLD);

        // calculating GRACE_NEW
        $GRACE_USERS = Subscriber::whereDate('grace_expire_dt','>=',$dated)->get()->count();
        log::info('GRACE_USERS : '.$GRACE_USERS);

        // calculating MTD
        $current_days = date('j');
        $dated_MTD = Carbon::now()->subDays($current_days-1)->toDateString();
        log::info('MTD Date : '.$dated_MTD);
        // $MTD = DB::table('mau_dau_kn_data')->where('Dated','>=',$dated_MTD)->select('*', DB::raw('count(cellno) AS user_count'))->groupBy('cellno')->having('cellno','>',$current_days)->get()->count($
        $MTD = MAU_DAU::where('Dated','>',$dated_MTD)->where('Dated','<=',$dated)->get()->count();
        log::info("MTD : ". $MTD);

        // calculating MAU
        $dated_MAU = Carbon::now()->subDays(30)->toDateString();
        log::info('MAU Date : '.$dated_MAU);
        $MAU = MAU_DAU::where('Dated','>',$dated_MAU)->where('Dated','<=',$dated)->get()->count();
        log::info("MAU : ". $MAU);

        // calculating DAU
        $DAU = MAU_DAU::where('Dated',$dated)->get()->count();
        log::info("DAU : ". $DAU);
// calculating PLATFORM BASE
        // $platform_base = Subscriber::where('grace_expire_dt','!=','')->get()->count();
        $platform_base = Subscriber::get()->count();
        log::info('PLATFORM BASE : '.$platform_base);

        // calculating IVR_SUB
        $IVR_SUB = Subscriber::whereDate('sub_dt',$dated)->where('sub_mode','IVR')->get()->count();
        log::info('IVR_SUB : '.$IVR_SUB);

        // calculating WEB_SUB
        $WEB_SUB = Subscriber::whereDate('sub_dt',$dated)->where('sub_mode','CRO')->get()->count();
        log::info('WEB_SUB : '.$WEB_SUB);

        // calculating PROMO_SUB
        $PROMO_SUB = Subscriber::whereDate('sub_dt',$dated)->where('sub_mode','OBD')->get()->count();
        log::info('PROMO_SUB : '.$PROMO_SUB);

        // calculating SMS_SUB
        $SMS_SUB = Subscriber::whereDate('sub_dt',$dated)->where('sub_mode','SMS')->get()->count();
        log::info('SMS_SUB : '.$SMS_SUB);

        // calculating VB_SUB
        $VB_SUB = Subscriber::whereDate('sub_dt',$dated)->where('sub_mode','VB')->get()->count();
        log::info('VB_SUB : '.$VB_SUB);

        // calculating WEBDOC_SUB
        $WEBDOC_SUB = Subscriber::whereDate('sub_dt',$dated)->where('sub_mode','WEBDOC')->get()->count();
        log::info('WEBDOC_SUB : '.$WEBDOC_SUB);

        // calculating IVR_UNSUB
        $IVR_UNSUB = UnSubscribed::whereDate('unsub_dt',$dated)->where('unsub_mode','IVR')->get()->count();
        log::info('IVR_UNSUB : '.$IVR_UNSUB);

        // calculating WEB_UNSUB
        $WEB_UNSUB = UnSubscribed::whereDate('unsub_dt',$dated)->where('unsub_mode','CRO')->get()->count();
        log::info('WEB_UNSUB : '.$WEB_UNSUB);

        // calculating PROMO_UNSUB
        $PROMO_UNSUB = UnSubscribed::whereDate('unsub_dt',$dated)->where('unsub_mode','OBD')->get()->count();
        log::info('PROMO_UNSUB : '.$PROMO_UNSUB);

        // calculating SMS_UNSUB
        $SMS_UNSUB = UnSubscribed::whereDate('unsub_dt',$dated)->where('unsub_mode','SMS')->get()->count();
        log::info('SMS_UNSUB : '.$SMS_UNSUB);

        // calculating VB_UNSUB
        $VB_UNSUB = UnSubscribed::whereDate('unsub_dt',$dated)->where('unsub_mode','VB')->get()->count();
        log::info('VB_UNSUB : '.$VB_UNSUB);

        // calculating WEBDOC_UNSUB
        $WEBDOC_UNSUB = UnSubscribed::whereDate('unsub_dt',$dated)->where('unsub_mode','WEBDOC')->get()->count();
        log::info('WEBDOC_UNSUB : '.$WEBDOC_UNSUB);

        // calculating TP_CC_UNSUB
        // calculating CR_PUR_UNSUB
        $CR_PUR_UNSUB = UnSubscribed::whereDate('unsub_dt',$dated)->where('unsub_mode','CR_PUR')->get()->count();
        log::info('CR_PUR_UNSUB : '.$CR_PUR_UNSUB);

        // calculating USG_PUR_UNSUB
        $USG_PUR_UNSUB = UnSubscribed::whereDate('unsub_dt',$dated)->where('unsub_mode','USG_PUR')->get()->count();
        log::info('USG_PUR_UNSUB : '.$USG_PUR_UNSUB);


        // Promo calls count and pickup count
        $PROMO_CALL=DB::connection('mysql3')->table('job')->whereDate('job_start_dt',$dated)->whereDate('job_end_dt',$dated)->where('status','!=','0')->get()->count();
        $PROMO_JOB=DB::connection('mysql3')->table('job')->select('list_id')->whereDate('job_start_dt',$dated)->whereDate('job_end_dt',$dated)->where('status','!=','0')->get();

        $i=0;
        foreach($PROMO_JOB as $JOB)
        {
            $i++;
            log::info('Job List ID: '.$JOB->list_id);
            $listId=$JOB->list_id;
            ${"total_calls$i"} = DB::connection('mysql3')->table('job_'.$listId.'')->where('status','!=','0')->get()->count();
            ${"total_pickup$i"} = DB::connection('mysql3')->table('job_'.$listId.'')->where('status','100')->where('reason_desc',' Remote end has answered')->get()->count();
        }
        $PROMO_CALL_COUNT = 0;
        $PROMO_CALL_PICKUP = 0;
        for($j=1; $j<=$i; $j++)
        {
            $PROMO_CALL_COUNT = $PROMO_CALL_COUNT + ${"total_calls$j"};
            $PROMO_CALL_PICKUP = $PROMO_CALL_PICKUP + ${"total_pickup$j"};
        }
        log::info('PROMO_CALL_COUNT: '.$PROMO_CALL_COUNT);
        log::info('PROMO_CALL_PICKUP: '.$PROMO_CALL_PICKUP);

        // calculating total MINUTES
        $TOTAL_seconds = IncomingCall::whereHas('subscriber', function($q){
            $q->where('start_dt','LIKE',Carbon::now()->toDateString().'%');})->selectRaw('sum(duration) as total_minutes')->first();
        $TOTAL_MINUTES = ($TOTAL_seconds->total_minutes)/60;
        log::info('TOTAL MINUTES : '.$TOTAL_MINUTES);

        // calculating total CALLS
        // $TOTAL_CALLS = IncomingCall::where('start_dt','LIKE',$dated.'%')->select('cellno')->get()->count();
        $TOTAL_CALLS = IncomingCall::whereHas('subscriber', function($q){
            $q->where('start_dt','LIKE',Carbon::now()->toDateString().'%');})->get()->count();
        log::info('TOTAL CALLS : '.$TOTAL_CALLS);

        // calculating total UNIQUE CALLERS
        $TOTAL_CALLERS = SubDetails::whereHas('calls', function($q){
            $q->where('start_dt','LIKE',Carbon::now()->toDateString().'%');
        })->get()->count();
        log::info('TOTAL CALLERS : '.$TOTAL_CALLERS);

        // calculating successfull charging UU
        $SCUU = $CHARGE_SUB + $CHARGE_SUCCESS;
        log::info('SUCCESSFULL CHARGING UU : '.$SCUU);

        // calculating revenue
        $REVENUE = $SCUU * 5;
        log::info('REVENUE : '.$REVENUE);

        // calculating CURRENT ACTIVE CHARGED
        $CAC = Subscriber::whereNotNull('next_charge_dt')->whereDate('next_charge_dt','>=',$dated)->get()->count();
//        $CAC = Subscriber::whereDate('last_charge_dt',$dated)->get()->count();
        log::info('CURRENT ACTIVE CHARGED : '.$CAC);
//      SELECT COUNT(*) FROM ibit.subscriber WHERE next_charge_dt is not null and date(now())<=next_charge_dt;

        $createReport = KNReporting::create([
            'DATED' => $datetime,
            'BASE' => $platform_base, 'CURRENT_ACTIVE_CHARGED' => $CAC,
            'PLATFORM_BASE' => $platform_base, 'MTD' =>$MTD, 'MAU' =>$MAU, 'DAU' =>$DAU,
            'IVR_SUB' =>$IVR_SUB, 'IVR_UNSUB' => $IVR_UNSUB, 'PROMO_SUB' => $PROMO_SUB,
            'PROMO_UNSUB' => $PROMO_UNSUB, 'SMS_SUB' => $SMS_SUB, 'SMS_UNSUB' => $SMS_UNSUB,
            'WEB_SUB' => $WEB_SUB, 'WEB_UNSUB' => $WEB_UNSUB, 'VB_SUB' => $VB_SUB,
            'VB_UNSUB' => $VB_UNSUB, 'WEBDOC_UNSUB' => $WEBDOC_UNSUB, 'TP_CC_UNSUB' => $TP_CC_UNSUB,
            'CR_PUR' => $CR_PUR_UNSUB, 'USG_PUR' => $USG_PUR_UNSUB, 'SAMEDAY_UNSUB' => $SAMEDAY_UNSUB,
            'TOTAL_SUB' => $TOTAL_SUB, 'TOTAL_UNSUB' => $TOTAL_UNSUB, 'SAME_DAY_RESUB' => $SAME_DAY_RESUB,
            'CHARGE_SUB' => $CHARGE_SUB, 'CHARGE_FAIL_SUB' => $CHARGE_FAIL_SUB, 'CHARGE_SUCCESS' => $CHARGE_SUCCESS,
            'CHARGE_FAIL' => $CHARGE_FAIL, 'PROMO_CALLS_COUNT' => $PROMO_CALL_COUNT, 'PROMO_CALLS_PICKUP' => $PROMO_CALL_PICKUP,
            'DAILIN_ENGAGEMENT' => $DAILIN_ENGAGEMENT, 'GRACE_PERIOD_NEW' => $GRACE_NEW,
            'GRACE_PERIOD_OLD' => $GRACE_OLD, 'GRACE_USERS' => $GRACE_USERS,
            'Minute' => $TOTAL_MINUTES, 'TotalCallers' => $TOTAL_CALLS, 'UniqueCallers' =>$TOTAL_CALLERS,
            'SUCCESSFULL_CHARGE_UU' => $SCUU, 'REVENUE' => $REVENUE,
        ]);

        log::info($createReport);

        log::debug("==================== Ending KN Reporting Job ".$dated." =====================");



    }
}