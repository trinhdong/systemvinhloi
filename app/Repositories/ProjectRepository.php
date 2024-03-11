<?php

namespace App\Repositories;

use App\Models\Bill;
use App\Models\Cost;
use App\Models\Memotag;
use App\Models\ProjectTemplate;
use App\Models\Slip;
use App\Models\Accept;
use App\Models\Project;
use App\Models\Estimate;
use App\Enums\EBillStatus;
use App\Enums\ECostStatus;
use App\Enums\ESlipStatus;
use App\Models\ProjectType;
use App\Enums\EAcceptStatus;
use App\Models\TotalBalance;
use App\Enums\EProjectStatus;
use App\Enums\EEstimateStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;

class ProjectRepository extends BaseRepository
{

    protected $project;
    protected $projectType;
    protected $slip;
    protected $bill;
    protected $totalBalance;
    protected $estimate;
    protected $accept;
    protected $cost;
    protected $memotag;
    protected $projectTemplate;


    /**
     * Create a new repository instance.
     * Created at: 27/06/2023
     * Created by: hien
     * Update at : 15/07/2023
     * Update by : kiều
     *
     * @param \App\Models\Project $project
     * @return void
     */
    public function __construct(
        Project         $project,
        ProjectType     $projectType,
        Slip            $slip,
        Bill            $bill,
        TotalBalance    $totalBalance,
        Estimate        $estimate,
        Accept          $accept,
        Cost            $cost,
        Memotag         $memotag,
        ProjectTemplate $projectTemplate,
    ) {
        $this->project         = $project;
        $this->projectType     = $projectType;
        $this->slip            = $slip;
        $this->bill            = $bill;
        $this->totalBalance    = $totalBalance;
        $this->estimate        = $estimate;
        $this->accept          = $accept;
        $this->cost            = $cost;
        $this->memotag         = $memotag;
        $this->projectTemplate = $projectTemplate;
        $this->setModel();
    }

    /**
     * Setting model want to interact
     * Created at: 27/06/2023
     * Created by: hien
     *
     * @access public
     * @return string
     */
    public function getModel()
    {
        return Project::class;
    }

    /**
     * getTbSumDateNew
     * Created at: 27/06/2023
     * Created by: KieuLe
     *
     * @access public
     * @return string
     */
    public function getTbSumDateNew()
    {
        return $this->totalBalance->select('tb_sum_date')
        ->orderBy('tb_sum_date', 'desc')
        ->first();
    }





    /**
     * get Project
     * Created at: 12/07/2023
     * Created by: Kieu
     */
    public function getProject($params)
    {
        try {
            $result = null;
            $query = $this->model->with('slips')->with('bills')->with('costs')->with('orderSideCompanyName')->with('employeeSale')->with('employeeManager')->with('employeeWork')->with('employeeConfirm')->with('estimates')->with('accepts');
            if ($params['prj_no'] != null) {

                $query->where('prj_no', '=', $params['prj_no']);
            } else {
                if ($params['prj_no_short'] == '' && !empty($params['typesubmit'])) {
                    $query->where('prj_no', 'LIKE', "%{$params['prj_no_short']}%");
                }
                if ($params['prj_no_short'] == '' && $params['lastTwoDigits'] && empty($params['typesubmit'])) {
                    $query->where('prj_no', 'LIKE', "%{$params['lastTwoDigits']}%");
                }
                if ($params['prj_no_short'] != '') {
                    $query->where(function ($query) use ($params) {
                        $query->where(DB::raw("SUBSTRING(prj_no, 1, 2)"), '=', $params['prj_no_short'])
                            ->orWhere('prj_name', 'LIKE', "%{$params['prj_no_short']}%");
                    });
                }
                if ($params['prj_status'] != '') {
                    if ($params['prj_status'] == '123') {
                        $query->whereIn('prj_status', [1, 2, 3]);
                    } else if ($params['prj_status'] == '-2045') {
                        $query->whereIn('prj_status', [0, 4, 5, -2]);
                    } else {
                        $query->where('prj_status', '=', $params['prj_status']);
                    }
                } else {
                    $query->where('prj_status', '=', 1);
                }
            }
            $query->where('prj_no', 'not like', '%M%')
                ->where('prj_no', 'not like', '%Y%')
                ->where('prj_no', 'not like', '%Z%');

            $result = $query->orderBy('prj_no', 'asc')->get();
            return $result;
        } catch (\Throwable $th) {
            Log::error($th);
            return false;
        }
    }


    /**
     * get Project
     * Created at: 12/07/2023
     * Created by: Kieu
     */
    public function getConstructionProgressStatus($params)
    {
        try {
            $result = null;
            $query = $this->model->with('slips')->with('bills')->with('costs')->with('orderSideCompanyName')->with('employeeSale')->with('employeeManager')->with('employeeWork')->with('employeeConfirm')->with('estimates')->with('accepts');

            $query->where('prj_no', 'LIKE', "{$params['prj_no_short']}%");
            // $query->where('prj_no', '22A100-001');

            if ($params['prj_landed_start'] != null && $params['prj_landed_end'] != null) {

                $query->whereDate('prj_landed', '>=', $params['prj_landed_start'])->whereDate('prj_landed', '<=', $params['prj_landed_end']);
            }

            $arrStatus = [];
            if ($params['type1'] == 0) array_push($arrStatus, $params['type1']);
            if ($params['type2']) array_push($arrStatus, $params['type2']);
            if ($params['type3']) array_push($arrStatus, $params['type3']);
            if ($params['type4']) array_push($arrStatus, $params['type4']);
            if ($params['type5']) array_push($arrStatus, $params['type5']);
            if ($params['type6']) array_push($arrStatus, $params['type6']);
            if ($params['type7']) array_push($arrStatus, $params['type7']);

            // $query->whereIn('prj_status', [$params['type1'], $params['type2'], $params['type3'], $params['type4'], $params['type5'], $params['type6'], $params['type7']]);
            $query->whereIn('prj_status', $arrStatus);

            if (isset($params['projTypeClass']) != null && isset($params['projTypeItems']) != null) {

                $ptyp_class = $params['projTypeClass'][0]['ptyp_class'];
                $ptyp_type = $params['projTypeClass'][0]['ptyp_type'];
                $ptyp_example = $params['projTypeClass'][0]['ptyp_example'];

                $ptyp_class = $params['projTypeItems'][0]['ptyp_class'];
                $ptyp_type = $params['projTypeItems'][0]['ptyp_type'];
                $ptyp_example = $params['projTypeItems'][0]['ptyp_example'];

                $query->where(function ($query) use ($ptyp_class, $ptyp_type, $ptyp_example) {
                    $query->where('prj_class1', $ptyp_class)
                        ->where('prj_type1', $ptyp_type)
                        ->where('prj_example1', $ptyp_example);
                })->orWhere(function ($query) use ($ptyp_class, $ptyp_type, $ptyp_example) {
                    $query->where('prj_class2', $ptyp_class)
                        ->where('prj_type2', $ptyp_type)
                        ->where('prj_example2', $ptyp_example);
                });
            } else if (isset($params['projTypeClass']) != null) {

                $ptyp_class = $params['projTypeClass'][0]['ptyp_class'];
                $ptyp_type = $params['projTypeClass'][0]['ptyp_type'];
                $ptyp_example = $params['projTypeClass'][0]['ptyp_example'];

                $query->where(function ($query) use ($ptyp_class, $ptyp_type, $ptyp_example) {
                    $query->where('prj_class1', $ptyp_class)
                        ->where('prj_type1', $ptyp_type)
                        ->where('prj_example1', $ptyp_example);
                });
            } else if (isset($params['projTypeItems']) != null) {

                $ptyp_class = $params['projTypeItems'][0]['ptyp_class'];
                $ptyp_type = $params['projTypeItems'][0]['ptyp_type'];
                $ptyp_example = $params['projTypeItems'][0]['ptyp_example'];

                $query->where(function ($query) use ($ptyp_class, $ptyp_type, $ptyp_example) {
                    $query->where('prj_class2', $ptyp_class)
                        ->where('prj_type2', $ptyp_type)
                        ->where('prj_example2', $ptyp_example);
                });
            }
            $query->where('prj_no', 'not like', '%M%')
                ->where('prj_no', 'not like', '%Y%')
                ->where('prj_no', 'not like', '%Z%');

            $result = $query->orderBy('prj_no', 'asc')->get();
            return $result;
        } catch (\Throwable $th) {

            Log::error($th);
            return false;
        }
    }


    /**
     * get getProjTypeName
     * Created at: 12/07/2023
     * Created by: Kieu
     *
     * @access public
     * @return
     */
    public function getStartDate($prj_no)
    {
        try {
            $oldestDate = "";

            $querySlip = $this->slip->where('slp_project', $prj_no)->orderBy('slp_date2')->first();
            $queryBill = $this->bill->where('bil_prj', $prj_no)->orderBy('bil_date')->first();

            if ($querySlip != null && $queryBill != null) {

                $oldestDate = min($querySlip->slp_date2, $queryBill->bil_date);
            }

            return $oldestDate;
        } catch (\Throwable $th) {

            Log::error($th);
            return false;
        }
    }


    /**
     * get getProjTypeName
     * Created at: 12/07/2023
     * Created by: Kieu
     */
    public function getProjTypeName($ptyp_status)
    {
        try {

            $result = null;
            $query = $this->projectType->select('ptyp_name', 'ptyp_id')->where('ptyp_status', $ptyp_status);

            $result = $query->get();
            return $result;
        } catch (\Throwable $th) {

            Log::error($th);
            return false;
        }
    }


    /**
     * get getProjTypeName
     * Created at: 12/07/2023
     * Created by: Kieu
     *
     * @access public
     * @return
     */
    public function getProjType($id)
    {
        try {
            $result = null;

            $query = $this->projectType->select('ptyp_class', 'ptyp_type', 'ptyp_example', 'ptyp_name')->where('ptyp_id', $id);
            $result = $query->get();

            return $result;
        } catch (\Throwable $th) {

            Log::error($th);
            return false;
        }
    }


    /**
     * createTemporaryTableCheck
     * Created at: 12/07/2023
     * Created by: Kieu
     */
    public function createTemporaryTableCheck($key, $from, $to)
    {
        DB::beginTransaction();
        try {
            //TODO============================ CREATE TABLE =============================

            DB::statement('CREATE TEMPORARY TABLE tmp_tb_deb (
                            deb_id1 INT,
                            deb_id2 INT,
                            deb_debit INT NOT NULL DEFAULT 0,
                            deb_credit INT,
                            deb_ses_key VARCHAR(24),
                            deb_sort_key VARCHAR(64)
                         )');
            DB::statement(' CREATE TEMPORARY TABLE tmp_tb_cre (
                            cre_id1 INT,
                            cre_id2 INT,
                            cre_debit INT,
                            cre_credit INT NOT NULL DEFAULT 0,
                            cre_ses_key VARCHAR(24),
                            cre_sort_key VARCHAR(64)
                        )');
            DB::statement('CREATE TEMPORARY TABLE tmp_tb_work1 (
                            wk1_id1 INT,
                            wk1_id2 INT,
                            wk1_balance INT,
                            wk1_debit INT NOT NULL DEFAULT 0,
                            wk1_credit INT NOT NULL DEFAULT 0,
                            wk1_ses_key VARCHAR(24),
                            wk1_sort_key VARCHAR(64)
                        )');
            DB::statement('CREATE TEMPORARY TABLE tmp_tb_work2 (
                            wk2_id1 INT,
                            wk2_id2 INT,
                            wk2_balance INT,
                            wk2_debit INT,
                            wk2_credit INT,
                            wk2_ses_key VARCHAR(24),
                            wk2_sort_key VARCHAR(64)
                        )');
            DB::statement('CREATE TEMPORARY TABLE tmp_tb_work3 (
                            wk3_id1 INT,
                            wk3_id2 INT,
                            wk3_balance INT,
                            wk3_debit INT,
                            wk3_credit INT,
                            wk3_new_balance INT,
                            wk3_ses_key VARCHAR(24),
                            wk3_sort_key VARCHAR(64)
                        )');
            DB::statement('CREATE TEMPORARY TABLE tmp_tb_output (
                            out_id1 INT,
                            out_id2 INT NOT NULL DEFAULT 9999,
                            out_balance INT,
                            out_debit INT,
                            out_credit INT,
                            out_new_balance INT,
                            out_ses_key VARCHAR(24),
                            out_sort_key VARCHAR(64)
                        )');
            DB::statement('CREATE TEMPORARY TABLE tmp_tb_total_cost1 (
                            cst1_acc1 INT,
                            cst1_acc2 INT,
                            cst1_old_balance INT,
                            cst1_debit INT,
                            cst1_date DATE,
                            cst1_ses_key VARCHAR(24)
                        )');
            DB::statement('CREATE TEMPORARY TABLE tmp_tb_total_cost2 (
                            cst2_acc1 INT,
                            cst2_acc2 INT,
                            cst2_old_balance INT,
                            cst2_debit INT,
                            cst2_new_balance INT,
                            cst2_date DATE,
                            cst2_ses_key VARCHAR(24)
                        )');
            //TODO============================ END CREATE TABLE =============================

            //TODO============================ PROCESS 1 =============================

            $results_m1 = $this->slip->with('customer')
                ->select(DB::raw('sum(slp_money_w_tax) as total_money_w_tax, slp_debit, slp_deb_customer'))
                ->where(function ($query) {
                    $query->where('slp_status', '=', 1)
                        ->orWhere('slp_status', '=', 2);
                })
                ->whereDate('slp_date2', '>=', $from)->whereDate('slp_date2', '<', $to)
                ->where(function ($query) {
                    $query->where('slp_debit', '<', 1122)
                        ->orWhere('slp_debit', '=', 1122)
                        ->orWhere('slp_debit', '=', 2116);
                })
                ->groupBy('slp_debit', 'slp_deb_customer')
                ->get();

            if ($results_m1->isNotEmpty()) {
                foreach ($results_m1 as $value) {
                    $cus_name2 = '';
                    if ($value->customer !== null) $cus_name2 = $value->customer['cus_name2'];

                    // dd($cus_name2);

                    $slp_debit = $value['slp_debit'];
                    $slp_deb_customer = $value['slp_deb_customer'];
                    $deb_debit = $value['total_money_w_tax'];
                    $deb_sort_key = (string)($slp_debit + $slp_deb_customer) . $cus_name2;

                    $data[] = ['deb_id1' => $slp_debit, 'deb_id2' => $slp_deb_customer, 'deb_debit' => $deb_debit, 'deb_credit' => 0, 'deb_ses_key' => $key, 'deb_sort_key' => $deb_sort_key];
                }
                try {
                    DB::table('tmp_tb_deb')->insert($data);
                } catch (QueryException $e) {
                    Log::error('Error while performing insert operation check m1: ' . $e->getMessage());
                }
            }

            // $response_m1 = DB::table('tmp_tb_deb')->select('*')->get(); 
            // dd($response_m1);

            //TODO============================ END PROCESS 1 =============================


            //TODO============================ PROCESS 2 =============================

            $results_m2 = $this->slip->with('customer')
                ->select(DB::raw('sum(slp_money_wo_tax) as total_slp_money_wo_tax, slp_debit, slp_deb_customer'))
                ->where(function ($query) {
                    $query->where('slp_status', '=', 1)
                        ->orWhere('slp_status', '=', 2);
                })
                ->whereDate('slp_date2', '>=', $from)->whereDate('slp_date2', '<', $to)
                ->where(function ($query) {
                    $query->where('slp_debit', '>', 1122)
                        ->where('slp_debit', '!=', 2116);
                })
                ->groupBy('slp_debit', 'slp_deb_customer')
                ->get();

            //             dd($results_m2);

            if ($results_m2->isNotEmpty()) {

                foreach ($results_m2 as $value) {

                    $cus_name2 = '';
                    if ($value->customer !== null) $cus_name2 = $value->customer['cus_name2'];

                    $slp_debit = $value['slp_debit'];
                    $slp_deb_customer = $value['slp_deb_customer'];
                    $slp_money_wo_tax = $value['total_slp_money_wo_tax'];
                    $deb_sort_key = (string)($slp_debit + $slp_deb_customer) . $cus_name2;

                    $data_m2[] = ['deb_id1' => $slp_debit, 'deb_id2' => $slp_deb_customer, 'deb_debit' => $slp_money_wo_tax, 'deb_credit' => 0, 'deb_ses_key' => $key, 'deb_sort_key' => $deb_sort_key];
                }
                try {
                    DB::table('tmp_tb_deb')->insert($data_m2);
                } catch (QueryException $e) {
                    Log::error('Error while performing insert operation check m2: ' . $e->getMessage());
                }
            }

            //             $response_m2 = DB::table('tmp_tb_deb')->select('*')->get();
            //             dd($response_m2);

            //TODO============================ END PROCESS 2 =============================


            //TODO============================ PROCESS 3 =============================

            $results_m3 = $this->slip->with('customer')
                ->select(DB::raw('sum(slp_deb_tax) as total_slp_deb_tax, slp_deb_customer'))
                ->where(function ($query) {
                    $query->where('slp_status', '=', 1)
                        ->orWhere('slp_status', '=', 2);
                })
                ->whereDate('slp_date2', '>=', $from)->whereDate('slp_date2', '<', $to)
                ->where(function ($query) {
                    $query->whereBetween('slp_debit', [1130, 1170])
                        ->orWhereBetween('slp_debit', [6000, 7000])
                        ->orWhereBetween('slp_debit', [1211, 1223])
                        ->orWhere('slp_debit', '=', 1187);
                })
                ->groupBy('slp_deb_customer')
                ->get();

            //             dd($results_m3);

            if ($results_m3->isNotEmpty()) {
                foreach ($results_m3 as $value) {

                    $deb_id2 = 0;
                    if ($value->customer !== null) $deb_id2 = $value->customer['cus_id'];

                    $deb_id1 = 1187;
                    $deb_id2 = $deb_id2; // fix
                    $deb_debit = $value['total_slp_deb_tax'];
                    $deb_credit = 0;
                    $deb_sort_key = $deb_id1 . $deb_id2 . '0000'; //fix

                    $data_m3[] = ['deb_id1' => $deb_id1, 'deb_id2' => $deb_id2, 'deb_debit' => $deb_debit, 'deb_credit' => $deb_credit, 'deb_ses_key' => $key, 'deb_sort_key' => $deb_sort_key];
                }
                try {
                    DB::table('tmp_tb_deb')->insert($data_m3);
                } catch (QueryException $e) {
                    Log::error('Error while performing insert operation check m3: ' . $e->getMessage());
                }
            }

            //             $response_m3 = DB::table('tmp_tb_deb')->select('*')->get();
            //             dd($response_m3);

            //TODO============================ END PROCESS 3 =============================


            //TODO============================  PROCESS 4 =============================

            $results_m4 = $this->slip->with('customer')
                ->select(DB::raw('sum(slp_deb_tax) as total_slp_deb_tax'))
                ->where(function ($query) {
                    $query->where('slp_status', '=', 1)
                        ->orWhere('slp_status', '=', 2);
                })
                ->whereDate('slp_date2', '>=', $from)->whereDate('slp_date2', '<', $to)
                ->where('slp_debit', '=', 2121)
                ->groupBy('slp_debit')
                ->get();

            if ($results_m4->isNotEmpty()) {
                foreach ($results_m4 as $value) {

                    $deb_id2 = 0;
                    if ($value->customer !== null) $deb_id2 = $value->customer['cus_id'];

                    $deb_id1 = 2121;
                    $deb_id2 = $deb_id2; // fix
                    $deb_debit = $value['total_slp_deb_tax'];
                    $deb_credit = 0;
                    $deb_sort_key = $deb_id1 . $deb_id2 . '0000'; //fix

                    $data_m4[] = ['deb_id1' => $deb_id1, 'deb_id2' => $deb_id2, 'deb_debit' => $deb_debit, 'deb_credit' => $deb_credit, 'deb_ses_key' => $key, 'deb_sort_key' => $deb_sort_key];
                }
                try {
                    DB::table('tmp_tb_deb')->insert($data_m4);
                } catch (QueryException $e) {
                    Log::error('Error while performing insert operation check m4: ' . $e->getMessage());
                }
            }

            //             $response_m4 = DB::table('tmp_tb_deb')->select('*')->get();
            //             dd($response_m4);

            //TODO============================ END PROCESS 4 =============================


            //TODO============================ PROCESS 5 =============================

            $results_m5 = $this->slip->with('customerWCredit')
                ->select(DB::raw('SUM(slp_money_w_tax) as total_slp_money_w_tax, slp_credit, slp_cre_customer'))
                ->where(function ($query) {
                    $query->where('slp_status', 1)
                        ->orWhere('slp_status', 2);
                })
                ->whereDate('slp_date2', '>=', $from)->whereDate('slp_date2', '<', $to)
                ->where(function ($query) {
                    $query->where('slp_credit', '<', 1122)
                        ->orWhere('slp_credit', '=',  2112)
                        ->orWhereBetween('slp_credit', [2114, 2116])
                        ->orWhere('slp_credit', '=', 1122);
                })
                ->groupBy('slp_credit', 'slp_cre_customer')
                ->get();

            //            dd($results_m5);
            if ($results_m5->isNotEmpty()) {
                foreach ($results_m5 as $value) {

                    $cus_name2 = '';
                    if ($value->customerWCredit !== null) $cus_name2 = $value->customerWCredit['cus_name2'];

                    $cre_id1 = $value['slp_credit'];
                    $cre_id2 = $value['slp_cre_customer'];
                    $cre_debit = 0;
                    $cre_credit = $value['total_slp_money_w_tax'];
                    $cre_sort_key = (string)($cre_id1 + $cre_id2) . $cus_name2;

                    $data_m5[] = ['cre_id1' => $cre_id1, 'cre_id2' => $cre_id2, 'cre_debit' => $cre_debit, 'cre_credit' => $cre_credit, 'cre_ses_key' => $key, 'cre_sort_key' => $cre_sort_key];
                }
                try {
                    DB::table('tmp_tb_cre')->insert($data_m5);
                } catch (QueryException $e) {
                    Log::error('Error while performing insert operation check m5: ' . $e->getMessage());
                }
            }

            //             $response_m5 = DB::table('tmp_tb_cre')->select('*')->get();
            //             dd($response_m5);

            //TODO============================ END PROCESS 5 =============================


            //TODO============================ PROCESS 6 =============================
            $results_m6 = $this->slip->with('customerWCredit')
                ->select(DB::raw('sum(slp_cre_tax) as total_slp_cre_tax, slp_cre_customer'))
                ->where(function ($query) {
                    $query->where('slp_status', '=', 1)
                        ->orWhere('slp_status', '=', 2);
                })
                ->whereDate('slp_date2', '>=', $from)
                ->whereDate('slp_date2', '<', $to)
                ->where('slp_credit', '=', 1187)
                ->groupBy('slp_cre_customer')
                ->get();

            //             dd( $results_m6 );

            if ($results_m6->isNotEmpty()) {
                foreach ($results_m6 as $value) {

                    $cre_id2 = 0;
                    if ($value->customerWCredit !== null) $cre_id2 = $value->customerWCredit['cus_id'];

                    $cre_id1 = 1187;
                    $cre_id2 = $cre_id2; //fix
                    $cre_debit = 0;
                    $cre_credit = $value['total_slp_cre_tax'];
                    $cre_sort_key = $cre_id1 . $cre_id2 . '0000'; //fix

                    $data_m6[] = ['cre_id1' => $cre_id1, 'cre_id2' => $cre_id2, 'cre_debit' => $cre_debit, 'cre_credit' => $cre_credit, 'cre_ses_key' => $key, 'cre_sort_key' => $cre_sort_key];
                }
                try {
                    DB::table('tmp_tb_cre')->insert($data_m6);
                } catch (QueryException $e) {
                    Log::error('Error while performing insert operation check m6: ' . $e->getMessage());
                }
            }

            //             $response_m6 = DB::table('tmp_tb_cre')->select('*')->get();
            //             dd($response_m6);

            //TODO============================ END PROCESS 6 =============================


            //TODO============================ PROCESS 7 =============================

            $results_m7 = $this->slip->with('customerWCredit')
                ->select(DB::raw('sum(slp_money_wo_tax) as total_slp_money_wo_tax, slp_credit, slp_cre_customer'))
                ->where(function ($query) {
                    $query->where('slp_status', '=', 1)
                        ->orWhere('slp_status', '=', 2);
                })
                ->whereDate('slp_date2', '>=', $from)->whereDate('slp_date2', '<', $to)
                ->where('slp_credit', '>=', 1122)
                ->where('slp_credit', '!=', 2112)
                ->where('slp_credit', '!=', 2114)
                ->where('slp_credit', '!=', 2115)
                ->where('slp_credit', '!=', 2116)
                ->where('slp_credit', '!=', 1122) //
                ->groupBy('slp_credit', 'slp_cre_customer')
                ->get();

            //             dd($results_m7);

            if ($results_m7->isNotEmpty()) {
                foreach ($results_m7 as $value) {

                    $cus_name2 = '';
                    if ($value->customerWCredit !== null) $cus_name2 = $value->customerWCredit['cus_name2'];

                    $cre_id1 = $value['slp_credit'];
                    $cre_id2 = $value['slp_cre_customer'];
                    $cre_debit = 0;
                    $cre_credit = $value['total_slp_money_wo_tax'];
                    $cre_sort_key = (string)($cre_id1 + $cre_id2) . $cus_name2;

                    $data_m7[] = ['cre_id1' => $cre_id1, 'cre_id2' => $cre_id2, 'cre_debit' => $cre_debit, 'cre_credit' => $cre_credit, 'cre_ses_key' => $key, 'cre_sort_key' => $cre_sort_key];
                }
                try {
                    DB::table('tmp_tb_cre')->insert($data_m7);
                } catch (QueryException $e) {
                    Log::error('Error while performing insert operation check m7: ' . $e->getMessage());
                }
            }

            //             $response_m7 = DB::table('tmp_tb_cre')->select('*')->get();
            //             dd($response_m7);

            //TODO============================ END PROCESS 7 =============================


            //TODO============================ PROCESS 8 =============================

            $results_m8 = $this->slip->with('customerWCredit')
                ->select(DB::raw('sum(slp_cre_tax) as total_slp_cre_tax'))
                ->where(function ($query) {
                    $query->where('slp_status', '=', 1)
                        ->orWhere('slp_status', '=', 2);
                })
                ->whereDate('slp_date2', '>=', $from)->whereDate('slp_date2', '<', $to)
                ->where(function ($query) {
                    $query->whereIn('slp_credit', [4111, 7118, 2121])
                        ->orWhere(function ($query) {
                            $query->where('slp_credit', '>', 1210)
                                ->where('slp_credit', '<', 1260);
                        });
                })
                // ->groupBy('slp_credit', 'slp_cre_customer')
                ->get();

            if ($results_m8->isNotEmpty()) {
                foreach ($results_m8 as $value) {

                    $cre_id2 = 0;
                    if ($value->customerWCredit !== null) $cre_id2 = $value->customerWCredit['cus_id'];

                    $cre_id1 = 2121;
                    $cre_id2 = $cre_id2; //fix
                    $cre_debit = 0;
                    $cre_credit = $value['total_slp_cre_tax'] == null ? 0 : $value['total_slp_cre_tax'];
                    $cre_sort_key = $cre_id1 . $cre_id2 . '0000';

                    $data_m8[] = ['cre_id1' => $cre_id1, 'cre_id2' => $cre_id2, 'cre_debit' => $cre_debit, 'cre_credit' => $cre_credit, 'cre_ses_key' => $key, 'cre_sort_key' => $cre_sort_key];
                }
                try {
                    DB::table('tmp_tb_cre')->insert($data_m8);
                } catch (QueryException $e) {
                    Log::error('Error while performing insert operation check m8: ' . $e->getMessage());
                }
            }

            //             $response_m8 = DB::table('tmp_tb_cre')->select('*')->get();
            //             dd($response_m8);

            //TODO============================ END PROCESS 8 =============================


            //TODO============================ PROCESS 9 =============================

            $results_m9 = $this->totalBalance->with('customer')
                ->select('tb_account', 'tb_customer', 'tb_balance')
                ->whereDate('tb_sum_date', '=', $from)
                ->get();
            //            dd($results_m9);

            if ($results_m9->isNotEmpty()) {
                foreach ($results_m9 as $value) {

                    $cus_name2 = '';
                    if ($value->customer !== null) $cus_name2 = $value->customer['cus_name2'];

                    $wk1_id1 = $value['tb_account'];
                    $wk1_id2 = $value['tb_customer'];
                    $wk1_balance = $value['tb_balance'];
                    $wk1_debit = 0;
                    $wk1_credit = 0;
                    $wk1_sort_key = (string)($wk1_id1 * 10000) . $cus_name2;

                    $data_m9[] = ['wk1_id1' => $wk1_id1, 'wk1_id2' => $wk1_id2, 'wk1_balance' => $wk1_balance, 'wk1_debit' => $wk1_debit, 'wk1_credit' => $wk1_credit, 'wk1_ses_key' => $key, 'wk1_sort_key' => $wk1_sort_key];
                }
                try {
                    DB::table('tmp_tb_work1')->insert($data_m9);
                } catch (QueryException $e) {
                    Log::error('Error while performing insert operation check m9: ' . $e->getMessage());
                }
            }

            //             $response_m9 = DB::table('tmp_tb_work1')->select('*')->get();
            //             dd($response_m9);

            //TODO============================ END PROCESS 9 =============================


            //TODO============================ PROCESS 10 =============================

            $results_m10 = DB::table('tmp_tb_deb')->select('deb_id1', 'deb_id2', 'deb_debit', 'deb_credit', 'deb_sort_key')
                ->where('deb_ses_key', '=', $key)
                ->get();

            //             dd( $results_m10);

            if ($results_m10->isNotEmpty()) {
                foreach ($results_m10 as $value) {

                    $wk1_id1 = $value->deb_id1;
                    $wk1_id2 = $value->deb_id2;
                    $wk1_balance = 0;
                    $wk1_debit = $value->deb_debit;
                    $wk1_credit = $value->deb_credit;
                    $wk1_sort_key = $value->deb_sort_key;

                    $data_m10[] = ['wk1_id1' => $wk1_id1, 'wk1_id2' => $wk1_id2, 'wk1_balance' => $wk1_balance, 'wk1_debit' => $wk1_debit, 'wk1_credit' => $wk1_credit, 'wk1_ses_key' => $key, 'wk1_sort_key' => $wk1_sort_key];
                }
                try {
                    DB::table('tmp_tb_work1')->insert($data_m10);
                } catch (QueryException $e) {
                    Log::error('Error while performing insert operation check m10: ' . $e->getMessage());
                }
            }

            //             $response_m10 = DB::table('tmp_tb_work1')->select('*')->get();
            //             dd($response_m10);
            //TODO============================ END PROCESS 10 =============================


            //TODO============================ PROCESS 11 =============================

            $results_m11 = DB::table('tmp_tb_cre')->select('cre_id1', 'cre_id2', 'cre_debit', 'cre_credit', 'cre_sort_key')
                ->where('cre_ses_key', '=', $key)
                ->get();

            // dd( $results_m11);

            if ($results_m11->isNotEmpty()) {
                foreach ($results_m11 as $value) {

                    $wk1_id1 = $value->cre_id1;
                    $wk1_id2 = $value->cre_id2;
                    $wk1_balance = 0;
                    $wk1_debit = $value->cre_debit;
                    $wk1_credit = $value->cre_credit;
                    $wk1_sort_key = $value->cre_sort_key;

                    $data_m11[] = ['wk1_id1' => $wk1_id1, 'wk1_id2' => $wk1_id2, 'wk1_balance' => $wk1_balance, 'wk1_debit' => $wk1_debit, 'wk1_credit' => $wk1_credit, 'wk1_ses_key' => $key, 'wk1_sort_key' => $wk1_sort_key];
                }
                try {
                    DB::table('tmp_tb_work1')->insert($data_m11);
                } catch (QueryException $e) {
                    Log::error('Error while performing insert operation check m11: ' . $e->getMessage());
                }
            }
            //
            //             $response_m11 = DB::table('tmp_tb_work1')->select('*')->get();
            //             dd($response_m11);

            //TODO============================ END PROCESS 11 =============================


            //TODO============================ PROCESS 12 =============================

            $results_m12 = DB::table('tmp_tb_work1')->select(DB::raw('wk1_id1, wk1_id2, sum(wk1_balance) as total_wk1_balance, sum(wk1_debit) as total_wk1_debit, sum(wk1_credit) as total_wk1_credit, wk1_sort_key'))
                ->where('wk1_ses_key', '=', $key)
                ->groupBy('wk1_id1', 'wk1_id2', 'wk1_sort_key')
                ->get();

            // dd( $results_m12);

            if ($results_m12->isNotEmpty()) {
                foreach ($results_m12 as $value) {
                    $wk2_id1 = $value->wk1_id1;
                    $wk2_id2 = $value->wk1_id2;
                    $wk2_balance = $value->total_wk1_balance;
                    $wk2_debit = $value->total_wk1_debit;
                    $wk2_credit = $value->total_wk1_credit;
                    $wk2_sort_key = $value->wk1_sort_key;

                    $data_m12[] = ['wk2_id1' => $wk2_id1, 'wk2_id2' => $wk2_id2, 'wk2_balance' => $wk2_balance, 'wk2_debit' => $wk2_debit, 'wk2_credit' => $wk2_credit, 'wk2_ses_key' => $key, 'wk2_sort_key' => $wk2_sort_key];
                }
                try {
                    DB::table('tmp_tb_work2')->insert($data_m12);
                } catch (QueryException $e) {
                    Log::error('Error while performing insert operation check m12: ' . $e->getMessage());
                }
            }

            // $response_m12 = DB::table('tmp_tb_work2')->select('*')->get();
            // dd($response_m12);

            //TODO============================ END PROCESS 12 =============================


            //TODO============================ PROCESS 13 =============================
            $results_m13 = DB::table('tmp_tb_work2')
                ->select('wk2_id1', 'wk2_id2', 'wk2_balance', 'wk2_debit', 'wk2_credit', 'wk2_sort_key')
                ->where('wk2_ses_key', '=', $key)
                ->where(function ($query) {
                    $query->where(function ($query) {
                        $query->where('wk2_id1', '>=', 2000)
                            ->where('wk2_id1', '<=', 2999);
                    })
                        ->orWhere(function ($query) {
                            $query->where('wk2_id1', '>=', 3000)
                                ->where('wk2_id1', '<=', 3999);
                        })
                        ->orWhere(function ($query) {
                            $query->where('wk2_id1', '>=', 4000)
                                ->where('wk2_id1', '<=', 4999);
                        })
                        ->orWhere(function ($query) {
                            $query->where('wk2_id1', '>=', 9000)
                                ->where('wk2_id1', '<=', 9999);
                        })
                        ->orWhere(function ($query) {
                            $query->whereBetween('wk2_id1', [7000, 7199]);
                        })
                        ->orWhere(function ($query) {
                            $query->whereBetween('wk2_id1', [8000, 8199]);
                        });
                })
                ->get();

            //             dd($results_m13);

            if ($results_m13->isNotEmpty()) {
                foreach ($results_m13 as $value) {
                    $wk3_id1 = $value->wk2_id1;
                    $wk3_id2 = $value->wk2_id2;
                    $wk3_balance = $value->wk2_balance;
                    $wk3_debit = $value->wk2_debit;
                    $wk3_credit = $value->wk2_credit;
                    $wk3_new_balance = ($value->wk2_balance) - ($value->wk2_debit) + ($value->wk2_credit);
                    $wk3_sort_key = $value->wk2_sort_key;

                    $data_m13[] = ['wk3_id1' => $wk3_id1, 'wk3_id2' => $wk3_id2, 'wk3_balance' => $wk3_balance, 'wk3_debit' => $wk3_debit, 'wk3_credit' => $wk3_credit, 'wk3_new_balance' => $wk3_new_balance, 'wk3_ses_key' => $key, 'wk3_sort_key' => $wk3_sort_key];
                }
                try {
                    DB::table('tmp_tb_work3')->insert($data_m13);
                } catch (QueryException $e) {
                    Log::error('Error while performing insert operation check m13: ' . $e->getMessage());
                }
            }

            //             $response_m13 = DB::table('tmp_tb_work3')->select('*')->get();
            //             dd($response_m13);

            //TODO============================ END PROCESS 13 =============================


            //TODO============================ PROCESS 14 =============================

            $results_m14 = DB::table('tmp_tb_work2')
                ->select('wk2_id1', 'wk2_id2', 'wk2_balance', 'wk2_debit', 'wk2_credit', 'wk2_sort_key')
                ->where('wk2_ses_key', '=', $key)
                ->where(function ($query) {
                    $query->where(function ($query) {
                        $query->where('wk2_id1', '>=', 1000)
                            ->where('wk2_id1', '<=', 1999);
                    })
                        ->orWhere(function ($query) {
                            $query->where('wk2_id1', '>=', 5000)
                                ->where('wk2_id1', '<=', 5999);
                        })
                        ->orWhere(function ($query) {
                            $query->where('wk2_id1', '>=', 6000)
                                ->where('wk2_id1', '<=', 6999);
                        })
                        ->orWhere(function ($query) {
                            $query->whereBetween('wk2_id1', [7200, 7999]);
                        })
                        ->orWhere(function ($query) {
                            $query->whereBetween('wk2_id1', [8200, 8999]);
                        });
                })
                ->get();

            //             dd($results_m14);

            if ($results_m14->isNotEmpty()) {
                foreach ($results_m14 as $value) {
                    $wk3_id1         = $value->wk2_id1;
                    $wk3_id2         = $value->wk2_id2;
                    $wk3_balance     = $value->wk2_balance;
                    $wk3_debit       = $value->wk2_debit;
                    $wk3_credit      = $value->wk2_credit;
                    $wk3_new_balance = ($value->wk2_balance) + ($value->wk2_debit) - ($value->wk2_credit);
                    $wk3_sort_key    = $value->wk2_sort_key;

                    $data_m14[] = ['wk3_id1' => $wk3_id1, 'wk3_id2' => $wk3_id2, 'wk3_balance' => $wk3_balance, 'wk3_debit' => $wk3_debit, 'wk3_credit' => $wk3_credit, 'wk3_new_balance' => $wk3_new_balance, 'wk3_ses_key' => $key, 'wk3_sort_key' => $wk3_sort_key];
                }
                try {
                    DB::table('tmp_tb_work3')->insert($data_m14);
                } catch (QueryException $e) {
                    Log::error('Error while performing insert operation check m14: ' . $e->getMessage());
                }
            }

            // $response_m14 = DB::table('tmp_tb_work3')->select('*')->get();
            // dd($response_m14);

            //TODO============================ END PROCESS 14 =============================


            //TODO============================  PROCESS 15 =============================

            // $results_m15 = DB::table('tmp_tb_work3')->select(DB::raw('wk3_id1, sum(wk3_balance) as total_wk3_balance, sum(wk3_debit) as total_wk3_debit, sum(wk3_credit) as total_wk3_credit, sum(wk3_new_balance) as total_wk3_new_balance'))
            //        ->where('wk3_ses_key', '=', $key)
            //     ->where('wk3_id1', '!=', 9000)
            //     ->groupBy('wk3_id1')
            //     ->get();

            // // dd($results_m15);

            // if ($results_m15->isNotEmpty()) {
            //     foreach ($results_m15 as $value) {
            //         $out_id1 = $value->wk3_id1;
            //         $out_id2 = 9999;

            //         $out_balance = $value->total_wk3_balance;
            //         $out_debit = $value->total_wk3_debit;
            //         $out_credit = $value->total_wk3_credit;
            //         $out_new_balance = $value->total_wk3_new_balance;
            //         $out_sort_key = (string)($out_id1 * 10000 + 9999);

            //         $data_m15[] = ['out_id1' => $out_id1, 'out_id2' => $out_id2, 'out_balance' => $out_balance, 'out_debit' => $out_debit, 'out_credit' => $out_credit, 'out_new_balance' => $out_new_balance, 'out_ses_key' => $key, 'out_sort_key' => $out_sort_key];
            //     }
            //     try {
            //         DB::table('tmp_tb_output')->insert($data_m15);
            //     } catch (QueryException $e) {
            //         Log::error('Error while performing insert operation check m15: ' . $e->getMessage());
            //     }
            // }

            // $response_m15 = DB::table('tmp_tb_output')->select('*')->get();
            // dd($response_m15);

            //TODO============================ END PROCESS 15 =============================


            //TODO============================  PROCESS 16 =============================

            // $results_m16 = DB::table('tmp_tb_work3')->select(DB::raw('wk3_id1, sum(wk3_balance) as total_wk3_balance, sum(wk3_debit) as total_wk3_debit, sum(wk3_credit) as total_wk3_credit, sum(wk3_new_balance) as total_wk3_new_balance'))
            //     ->where('wk3_ses_key', '=', $key)
            //     ->where('wk3_id1', '<>', 888000)
            //     ->groupBy('wk3_id1')
            //     ->get();

            // //             dd($results_m16);

            // if ($results_m16->isNotEmpty()) {
            //     foreach ($results_m16 as $value) {

            //         $out_id1 = $value->wk3_id1;
            //         $out_id2 = 9999999;
            //         $out_balance = $value->total_wk3_balance;
            //         $out_debit = $value->total_wk3_debit;
            //         $out_credit = $value->total_wk3_credit;
            //         $out_new_balance = $value->total_wk3_new_balance;
            //         $out_sort_key = (string)($out_id1 / 10000000 * 10000000 + 9999999);

            //         $data_m16[] = ['out_id1' => $out_id1, 'out_id2' => $out_id2, 'out_balance' => $out_balance, 'out_debit' => $out_debit, 'out_credit' => $out_credit, 'out_new_balance' => $out_new_balance, 'out_ses_key' => $key, 'out_sort_key' => $out_sort_key];
            //     }
            //     try {
            //         DB::table('tmp_tb_output')->insert($data_m16);
            //     } catch (QueryException $e) {
            //         Log::error('Error while performing insert operation check m16: ' . $e->getMessage());
            //     }
            // }

            // $response_m16 = DB::table('tmp_tb_output')->select('*')->get();
            // dd($response_m16);

            //TODO============================ END PROCESS 16 =============================


            //TODO============================  PROCESS 17 =============================

            $results_m17 = DB::table('tmp_tb_work3')->select(DB::raw('wk3_id1, wk3_id2, sum(wk3_balance) as total_wk3_balance, sum(wk3_debit) as total_wk3_debit, sum(wk3_credit) as total_wk3_credit, sum(wk3_new_balance) as total_wk3_new_balance, wk3_sort_key'))
                ->where('wk3_ses_key', '=', $key)
                ->groupBy('wk3_id1', 'wk3_id2', 'wk3_sort_key')
                ->get();

            //             dd($results_m17);

            if ($results_m17->isNotEmpty()) {
                foreach ($results_m17 as $value) {

                    $out_id1 = $value->wk3_id1;
                    $out_id2 = $value->wk3_id2;
                    $out_balance = $value->total_wk3_balance;
                    $out_debit = $value->total_wk3_debit;
                    $out_credit = $value->total_wk3_credit;
                    $out_new_balance = $value->total_wk3_new_balance;
                    $out_sort_key = $value->wk3_sort_key;

                    $data_m17[] = ['out_id1' => $out_id1, 'out_id2' => $out_id2, 'out_balance' => $out_balance, 'out_debit' => $out_debit, 'out_credit' => $out_credit, 'out_new_balance' => $out_new_balance, 'out_ses_key' => $key, 'out_sort_key' => $out_sort_key];
                }
                try {
                    DB::table('tmp_tb_output')->insert($data_m17);
                } catch (QueryException $e) {
                    Log::error('Error while performing insert operation check m17: ' . $e->getMessage());
                }
            }

            // $response_m17 = DB::table('tmp_tb_output')->select('*')->orderByRaw('out_id1 + out_id2, out_sort_key')->get();
            $response_m17 = DB::table('tmp_tb_output')->select('*')->orderBy('out_id1')->orderBy('out_id2')->get();
            // dd($response_m17);

            //TODO============================ END PROCESS 17 =============================


            //TODO============================  PROCESS 18 =============================

            $results_m18 = DB::table('tmp_tb_output')->select(DB::raw("out_id1, out_id2, out_debit"))
                ->where('out_id1', '>=', 1130)
                ->where('out_id1', '<', 1180)
                ->where(DB::raw('out_id1 % 10000'), '=', 9999)
                ->where('out_ses_key', '=', $key)
                ->get();

            //             dd($results_m18);
            if ($results_m18->isNotEmpty()) {
                foreach ($results_m18 as $value) {

                    $cst1_acc1 = $value->out_id1;
                    $cst1_acc2 = $value->out_id2;
                    $cst1_old_balance = 0;
                    $cst1_debit = $value->out_debit;
                    $cst1_date = $to;

                    $data_m18[] = ['cst1_acc1' => $cst1_acc1, 'cst1_acc2' => $cst1_acc2, 'cst1_old_balance' => $cst1_old_balance, 'cst1_debit' => $cst1_debit, 'cst1_date' => $cst1_date, 'cst1_ses_key' => $key];
                }
                try {
                    DB::table('tmp_tb_total_cost1')->insert($data_m18);
                } catch (QueryException $e) {
                    Log::error('Error while performing insert operation check m18: ' . $e->getMessage());
                }
            }

            //             $response_m18 = DB::table('tmp_tb_total_cost1')->select('*')->get();
            //             dd($response_m18);

            //TODO============================ END PROCESS 18 =============================


            //TODO============================ PROCESS 19 =============================

            $results_m19 = DB::table('pl_cost')->select(DB::raw("plcost_account, plcost_customer, plcost_balance"))
                ->where('plcost_date', '=', $from)
                ->where('plcost_status', '=', 1)
                ->get();

            //             dd($results_m19);

            if ($results_m19->isNotEmpty()) {
                foreach ($results_m19 as $value) {

                    $cst1_acc1 = $value->plcost_account;
                    $cst1_acc2 = $value->plcost_customer;
                    $cst1_old_balance = $value->plcost_balance;
                    $cst1_debit = 0;
                    $cst1_date = $to;

                    $data_m19[] = ['cst1_acc1' => $cst1_acc1, 'cst1_acc2' => $cst1_acc2, 'cst1_old_balance' => $cst1_old_balance, 'cst1_debit' => $cst1_debit, 'cst1_date' => $cst1_date, 'cst1_ses_key' => $key];
                }
                try {
                    DB::table('tmp_tb_total_cost1')->insert($data_m19);
                } catch (QueryException $e) {
                    Log::error('Error while performing insert operation check m19: ' . $e->getMessage());
                }
            }

            // $response_m19 = DB::table('tmp_tb_total_cost1')->select('*')->get();
            // dd($response_m19);

            //TODO============================ END PROCESS 19 =============================


            //TODO============================ END PROCESS 20 =============================

            $results_m20 = DB::table('tmp_tb_total_cost1')->select(DB::raw("cst1_acc1, cst1_acc2, sum(cst1_old_balance) as total_cst1_old_balance,  sum(cst1_debit) as total_cst1_debit, sum(cst1_old_balance) as total_cst1_old_balance, cst1_date, cst1_ses_key"))
                ->where('cst1_date', '=', $to)
                ->where('cst1_ses_key', '=', $key)
                ->groupBy('cst1_acc1', 'cst1_acc2', 'cst1_date', 'cst1_ses_key')
                ->get();

            //             dd($results_m20);

            if ($results_m20->isNotEmpty()) {
                foreach ($results_m20 as $value) {

                    $cst2_acc1 = $value->cst1_acc1;
                    $cst2_acc2 = $value->cst1_acc2;
                    $cst2_old_balance = $value->total_cst1_old_balance;
                    $cst2_debit = $value->total_cst1_debit;
                    $cst2_new_balance = $value->total_cst1_old_balance;
                    $cst2_date = $value->cst1_date;

                    $data_m20[] = ['cst2_acc1' => $cst2_acc1, 'cst2_acc2' => $cst2_acc2, 'cst2_old_balance' => $cst2_old_balance, 'cst2_debit' => $cst2_debit, 'cst2_new_balance' => $cst2_new_balance, 'cst2_date' => $cst2_date, 'cst2_ses_key' => $key];
                }
                try {
                    DB::table('tmp_tb_total_cost2')->insert($data_m20);
                } catch (QueryException $e) {
                    Log::error('Error while performing insert operation check m20: ' . $e->getMessage());
                }
            }

            // $response_m20 = DB::table('tmp_tb_total_cost2')->select('*')->get();
            // dd($response_m20);

            //TODO============================ END PROCESS 20 =============================


            //TODO============================ PROCESS 21 =============================
            // $results_m21 = DB::table('tmp_tb_total_cost1')->select('wk3_id1', 'wk3_i2', 'wk3_new_balance')
            //     ->where('wk3_ses_key', '=', $key)
            //     ->get();

            // // dd($results_m21);

            // if ($results_m21->isNotEmpty()) {
            //     foreach ($results_m21 as  $value) {

            //         $tb_sum_date = $to;
            //         $tb_ref_date = $from;
            //         $tb_account  = $value->wk3_id1;
            //         $tb_customer = $value->wk3_i2;
            //         $tb_balance  = $value->wk3_new_balance;

            //         $data_m21[] = ['tb_sum_date' =>  $tb_sum_date,  'tb_ref_date' => $tb_ref_date, 'tb_account' => $tb_account, 'tb_customer' => $tb_customer, 'tb_balance' => $tb_balance];
            //     }
            //     try {
            //         DB::table('total_balance')->insert($data_m21);
            //     } catch (QueryException $e) {
            //         Log::error('Error while performing insert operation check m21: ' . $e->getMessage());
            //     }
            // }

            // $response_m21 = DB::table('total_balance')->select('*')->get();
            // dd($response_m21);

            // try {
            //     Slip::where('slp_status', 1)
            //         ->where('slp_date2', '>=', $from)
            //         ->where('slp_date2', '<', $to)
            //         ->update(['slp_status' => 2]);
            // } catch (QueryException $e) {
            //     Log::error('Error while performing insert operation check m21b: ' . $e->getMessage());
            // }

            //TODO============================ END PROCESS 21 =============================


            //TODO============================  PROCESS 22 =============================

            // $results_m22 = DB::table('tmp_tb_total_cost2')->select('cst2_acc1', 'cst2_ac2', 'cst2_date', 'cst2_new_balance')
            //     ->where('cst2_date', '=', $to)
            //     ->where('cst2_ses_key', '=', $key)
            //     ->get();

            // // dd($results_m22);

            // if ($results_m22->isNotEmpty()) {
            //     foreach ($results_m22 as  $value) {

            //         $plcost_account  = $value->cst2_acc1;
            //         $plcost_customer = $value->cst2_ac2;
            //         $plcost_date     = $value->cst2_date;
            //         $plcost_balance  = $value->cst2_new_balance;
            //         $plcost_status   = 1;

            //         $data_m22[] = ['plcost_account' =>  $plcost_account,  'plcost_customer' => $plcost_customer, 'plcost_date' => $plcost_date, 'plcost_balance' => $plcost_balance, 'plcost_status' => $plcost_status];
            //     }
            //     try {
            //         DB::table('pl_cost')->insert($data_m22);
            //     } catch (QueryException $e) {
            //         Log::error('Error while performing insert operation check m22: ' . $e->getMessage());
            //     }
            // }

            // $response_m22 = DB::table('pl_cost')->select('*')->get();
            // dd($response_m22);

            //TODO============================ END PROCESS 22 =============================

            DB::commit();
            return $response_m17;
        } catch (\Throwable $th) {

            Log::error($th);
            DB::rollBack();
            return false;
        }
    }


    /**
     * createTemporaryTableCheck
     * Created at: 12/07/2023
     * Created by: Kieu
     */
    public function createTemporaryTable($key, $from, $to, $flag)
    {
        DB::beginTransaction();
        try {
            //TODO============================ CREATE TABLE =============================

            DB::statement('CREATE TEMPORARY TABLE tmp_tb_deb (
                            deb_id1 INT,
                            deb_id2 INT,
                            deb_debit INT NOT NULL DEFAULT 0,
                            deb_credit INT,
                            deb_ses_key VARCHAR(24),
                            deb_sort_key VARCHAR(64)
                         )');
            DB::statement(' CREATE TEMPORARY TABLE tmp_tb_cre (
                            cre_id1 INT,
                            cre_id2 INT,
                            cre_debit INT,
                            cre_credit INT NOT NULL DEFAULT 0,
                            cre_ses_key VARCHAR(24),
                            cre_sort_key VARCHAR(64)
                        )');
            DB::statement('CREATE TEMPORARY TABLE tmp_tb_work1 (
                            wk1_id1 INT,
                            wk1_id2 INT,
                            wk1_balance INT,
                            wk1_debit INT NOT NULL DEFAULT 0,
                            wk1_credit INT NOT NULL DEFAULT 0,
                            wk1_ses_key VARCHAR(24),
                            wk1_sort_key VARCHAR(64)
                        )');
            DB::statement('CREATE TEMPORARY TABLE tmp_tb_work2 (
                            wk2_id1 INT,
                            wk2_id2 INT,
                            wk2_balance INT,
                            wk2_debit INT,
                            wk2_credit INT,
                            wk2_ses_key VARCHAR(24),
                            wk2_sort_key VARCHAR(64)
                        )');
            DB::statement('CREATE TEMPORARY TABLE tmp_tb_work3 (
                            wk3_id1 INT,
                            wk3_id2 INT,
                            wk3_balance INT,
                            wk3_debit INT,
                            wk3_credit INT,
                            wk3_new_balance INT,
                            wk3_ses_key VARCHAR(24),
                            wk3_sort_key VARCHAR(64)
                        )');
            DB::statement('CREATE TEMPORARY TABLE tmp_tb_output (
                            out_id1 INT,
                            out_id2 INT NOT NULL DEFAULT 9999,
                            out_balance INT,
                            out_debit INT,
                            out_credit INT,
                            out_new_balance INT,
                            out_ses_key VARCHAR(24),
                            out_sort_key VARCHAR(64)
                        )');
            DB::statement('CREATE TEMPORARY TABLE tmp_tb_total_cost1 (
                            cst1_acc1 INT,
                            cst1_acc2 INT,
                            cst1_old_balance INT,
                            cst1_debit INT,
                            cst1_date DATE,
                            cst1_ses_key VARCHAR(24)
                        )');
            DB::statement('CREATE TEMPORARY TABLE tmp_tb_total_cost2 (
                            cst2_acc1 INT,
                            cst2_acc2 INT,
                            cst2_old_balance INT,
                            cst2_debit INT,
                            cst2_new_balance INT,
                            cst2_date DATE,
                            cst2_ses_key VARCHAR(24)
                        )');
            //TODO============================ END CREATE TABLE =============================

            //TODO============================ PROCESS 1 =============================

            $results_m1 = $this->slip->with('customer')
                ->select(DB::raw('sum(slp_money_w_tax) as total_money_w_tax, slp_debit, slp_deb_customer'))
                ->where('slp_status', '=', 1)
                ->whereDate('slp_date2', '>=', $from)->whereDate('slp_date2', '<', $to)
                ->where(function ($query) {
                    $query->where('slp_debit', '<', 1122)
                        ->orWhere('slp_debit', '=', 1122)
                        ->orWhere('slp_debit', '=', 2116);
                })
                ->groupBy('slp_debit', 'slp_deb_customer')
                ->get();

            if ($results_m1->isNotEmpty()) {
                foreach ($results_m1 as $value) {
                    $cus_name2 = '';
                    if ($value->customer !== null) $cus_name2 = $value->customer['cus_name2'];

                    // dd($cus_name2);

                    $slp_debit = $value['slp_debit'];
                    $slp_deb_customer = $value['slp_deb_customer'];
                    $deb_debit = $value['total_money_w_tax'];
                    $deb_sort_key = (string)($slp_debit + $slp_deb_customer) . $cus_name2;

                    $data[] = ['deb_id1' => $slp_debit, 'deb_id2' => $slp_deb_customer, 'deb_debit' => $deb_debit, 'deb_credit' => 0, 'deb_ses_key' => $key, 'deb_sort_key' => $deb_sort_key];
                }
                try {
                    DB::table('tmp_tb_deb')->insert($data);
                } catch (QueryException $e) {
                    Log::error('Error while performing insert operation check m1: ' . $e->getMessage());
                }
            }

            // $response_m1 = DB::table('tmp_tb_deb')->select('*')->get(); 
            // dd($response_m1);

            //TODO============================ END PROCESS 1 =============================


            //TODO============================ PROCESS 2 =============================

            $results_m2 = $this->slip->with('customer')
                ->select(DB::raw('sum(slp_money_wo_tax) as total_slp_money_wo_tax, slp_debit, slp_deb_customer'))
                ->where('slp_status', '=', 1)
                ->whereDate('slp_date2', '>=', $from)->whereDate('slp_date2', '<', $to)
                ->where(function ($query) {
                    $query->where('slp_debit', '>', 1122)
                        ->where('slp_debit', '!=', 2116);
                })
                ->groupBy('slp_debit', 'slp_deb_customer')
                ->get();

            //             dd($results_m2);

            if ($results_m2->isNotEmpty()) {

                foreach ($results_m2 as $value) {

                    $cus_name2 = '';
                    if ($value->customer !== null) $cus_name2 = $value->customer['cus_name2'];

                    $slp_debit = $value['slp_debit'];
                    $slp_deb_customer = $value['slp_deb_customer'];
                    $slp_money_wo_tax = $value['total_slp_money_wo_tax'];
                    $deb_sort_key = (string)($slp_debit + $slp_deb_customer) . $cus_name2;

                    $data_m2[] = ['deb_id1' => $slp_debit, 'deb_id2' => $slp_deb_customer, 'deb_debit' => $slp_money_wo_tax, 'deb_credit' => 0, 'deb_ses_key' => $key, 'deb_sort_key' => $deb_sort_key];
                }
                try {
                    DB::table('tmp_tb_deb')->insert($data_m2);
                } catch (QueryException $e) {
                    Log::error('Error while performing insert operation check m2: ' . $e->getMessage());
                }
            }

            //             $response_m2 = DB::table('tmp_tb_deb')->select('*')->get();
            //             dd($response_m2);

            //TODO============================ END PROCESS 2 =============================


            //TODO============================ PROCESS 3 =============================

            $results_m3 = $this->slip->with('customer')
                ->select(DB::raw('sum(slp_deb_tax) as total_slp_deb_tax, slp_deb_customer'))
                ->where('slp_status', '=', 1)
                ->whereDate('slp_date2', '>=', $from)->whereDate('slp_date2', '<', $to)
                ->where(function ($query) {
                    $query->whereBetween('slp_debit', [1130, 1170])
                        ->orWhereBetween('slp_debit', [6000, 7000])
                        ->orWhereBetween('slp_debit', [1211, 1223])
                        ->orWhere('slp_debit', '=', 1187);
                })
                ->groupBy('slp_deb_customer')
                ->get();

            //             dd($results_m3);

            if ($results_m3->isNotEmpty()) {
                foreach ($results_m3 as $value) {

                    $deb_id2 = 0;
                    if ($value->customer !== null) $deb_id2 = $value->customer['cus_id'];

                    $deb_id1 = 1187;
                    $deb_id2 = $deb_id2; // fix
                    $deb_debit = $value['total_slp_deb_tax'];
                    $deb_credit = 0;
                    $deb_sort_key = $deb_id1 . $deb_id2 . '0000'; //fix

                    $data_m3[] = ['deb_id1' => $deb_id1, 'deb_id2' => $deb_id2, 'deb_debit' => $deb_debit, 'deb_credit' => $deb_credit, 'deb_ses_key' => $key, 'deb_sort_key' => $deb_sort_key];
                }
                try {
                    DB::table('tmp_tb_deb')->insert($data_m3);
                } catch (QueryException $e) {
                    Log::error('Error while performing insert operation check m3: ' . $e->getMessage());
                }
            }

            //             $response_m3 = DB::table('tmp_tb_deb')->select('*')->get();
            //             dd($response_m3);

            //TODO============================ END PROCESS 3 =============================


            //TODO============================  PROCESS 4 =============================

            $results_m4 = $this->slip->with('customer')
                ->select(DB::raw('sum(slp_deb_tax) as total_slp_deb_tax'))
                ->where('slp_status', '=', 1)
                ->whereDate('slp_date2', '>=', $from)->whereDate('slp_date2', '<', $to)
                ->where('slp_debit', '=', 2121)
                ->groupBy('slp_debit')
                ->get();

            if ($results_m4->isNotEmpty()) {
                foreach ($results_m4 as $value) {

                    $deb_id2 = 0;
                    if ($value->customer !== null) $deb_id2 = $value->customer['cus_id'];

                    $deb_id1 = 2121;
                    $deb_id2 = $deb_id2; // fix
                    $deb_debit = $value['total_slp_deb_tax'];
                    $deb_credit = 0;
                    $deb_sort_key = $deb_id1 . $deb_id2 . '0000'; //fix

                    $data_m4[] = ['deb_id1' => $deb_id1, 'deb_id2' => $deb_id2, 'deb_debit' => $deb_debit, 'deb_credit' => $deb_credit, 'deb_ses_key' => $key, 'deb_sort_key' => $deb_sort_key];
                }
                try {
                    DB::table('tmp_tb_deb')->insert($data_m4);
                } catch (QueryException $e) {
                    Log::error('Error while performing insert operation check m4: ' . $e->getMessage());
                }
            }

            //             $response_m4 = DB::table('tmp_tb_deb')->select('*')->get();
            //             dd($response_m4);

            //TODO============================ END PROCESS 4 =============================


            //TODO============================ PROCESS 5 =============================

            $results_m5 = $this->slip->with('customerWCredit')
                ->select(DB::raw('SUM(slp_money_w_tax) as total_slp_money_w_tax, slp_credit, slp_cre_customer'))
                ->where('slp_status', 1)
                ->whereDate('slp_date2', '>=', $from)->whereDate('slp_date2', '<', $to)
                ->where(function ($query) {
                    $query->where('slp_credit', '<', 1122)
                        ->orWhere('slp_credit', '=',  2112)
                        ->orWhereBetween('slp_credit', [2114, 2116])
                        ->orWhere('slp_credit', '=', 1122);
                })
                ->groupBy('slp_credit', 'slp_cre_customer')
                ->get();

            //            dd($results_m5);
            if ($results_m5->isNotEmpty()) {
                foreach ($results_m5 as $value) {

                    $cus_name2 = '';
                    if ($value->customerWCredit !== null) $cus_name2 = $value->customerWCredit['cus_name2'];

                    $cre_id1 = $value['slp_credit'];
                    $cre_id2 = $value['slp_cre_customer'];
                    $cre_debit = 0;
                    $cre_credit = $value['total_slp_money_w_tax'];
                    $cre_sort_key = (string)($cre_id1 + $cre_id2) . $cus_name2;

                    $data_m5[] = ['cre_id1' => $cre_id1, 'cre_id2' => $cre_id2, 'cre_debit' => $cre_debit, 'cre_credit' => $cre_credit, 'cre_ses_key' => $key, 'cre_sort_key' => $cre_sort_key];
                }
                try {
                    DB::table('tmp_tb_cre')->insert($data_m5);
                } catch (QueryException $e) {
                    Log::error('Error while performing insert operation check m5: ' . $e->getMessage());
                }
            }

            //             $response_m5 = DB::table('tmp_tb_cre')->select('*')->get();
            //             dd($response_m5);

            //TODO============================ END PROCESS 5 =============================


            //TODO============================ PROCESS 6 =============================
            $results_m6 = $this->slip->with('customerWCredit')
                ->select(DB::raw('sum(slp_cre_tax) as total_slp_cre_tax, slp_cre_customer'))
                ->where('slp_status', '=', 1)
                ->whereDate('slp_date2', '>=', $from)
                ->whereDate('slp_date2', '<', $to)
                ->where('slp_credit', '=', 1187)
                ->groupBy('slp_cre_customer')
                ->get();

            //             dd( $results_m6 );

            if ($results_m6->isNotEmpty()) {
                foreach ($results_m6 as $value) {

                    $cre_id2 = 0;
                    if ($value->customerWCredit !== null) $cre_id2 = $value->customerWCredit['cus_id'];

                    $cre_id1 = 1187;
                    $cre_id2 = $cre_id2; //fix
                    $cre_debit = 0;
                    $cre_credit = $value['total_slp_cre_tax'];
                    $cre_sort_key = $cre_id1 . $cre_id2 . '0000'; //fix

                    $data_m6[] = ['cre_id1' => $cre_id1, 'cre_id2' => $cre_id2, 'cre_debit' => $cre_debit, 'cre_credit' => $cre_credit, 'cre_ses_key' => $key, 'cre_sort_key' => $cre_sort_key];
                }
                try {
                    DB::table('tmp_tb_cre')->insert($data_m6);
                } catch (QueryException $e) {
                    Log::error('Error while performing insert operation check m6: ' . $e->getMessage());
                }
            }

            //             $response_m6 = DB::table('tmp_tb_cre')->select('*')->get();
            //             dd($response_m6);

            //TODO============================ END PROCESS 6 =============================


            //TODO============================ PROCESS 7 =============================

            $results_m7 = $this->slip->with('customerWCredit')
                ->select(DB::raw('sum(slp_money_wo_tax) as total_slp_money_wo_tax, slp_credit, slp_cre_customer'))
                ->where('slp_status', '=', 1)
                ->whereDate('slp_date2', '>=', $from)->whereDate('slp_date2', '<', $to)
                ->where('slp_credit', '>=', 1122)
                ->where('slp_credit', '!=', 2112)
                ->where('slp_credit', '!=', 2114)
                ->where('slp_credit', '!=', 2115)
                ->where('slp_credit', '!=', 2116)
                ->where('slp_credit', '!=', 1122) //
                ->groupBy('slp_credit', 'slp_cre_customer')
                ->get();

            //             dd($results_m7);

            if ($results_m7->isNotEmpty()) {
                foreach ($results_m7 as $value) {

                    $cus_name2 = '';
                    if ($value->customerWCredit !== null) $cus_name2 = $value->customerWCredit['cus_name2'];

                    $cre_id1 = $value['slp_credit'];
                    $cre_id2 = $value['slp_cre_customer'];
                    $cre_debit = 0;
                    $cre_credit = $value['total_slp_money_wo_tax'];
                    $cre_sort_key = (string)($cre_id1 + $cre_id2) . $cus_name2;

                    $data_m7[] = ['cre_id1' => $cre_id1, 'cre_id2' => $cre_id2, 'cre_debit' => $cre_debit, 'cre_credit' => $cre_credit, 'cre_ses_key' => $key, 'cre_sort_key' => $cre_sort_key];
                }
                try {
                    DB::table('tmp_tb_cre')->insert($data_m7);
                } catch (QueryException $e) {
                    Log::error('Error while performing insert operation check m7: ' . $e->getMessage());
                }
            }

            //             $response_m7 = DB::table('tmp_tb_cre')->select('*')->get();
            //             dd($response_m7);

            //TODO============================ END PROCESS 7 =============================


            //TODO============================ PROCESS 8 =============================

            $results_m8 = $this->slip->with('customerWCredit')
                ->select(DB::raw('sum(slp_cre_tax) as total_slp_cre_tax'))
                ->where('slp_status', '=', 1)
                ->whereDate('slp_date2', '>=', $from)->whereDate('slp_date2', '<', $to)
                ->where(function ($query) {
                    $query->whereIn('slp_credit', [4111, 7118, 2121])
                        ->orWhere(function ($query) {
                            $query->where('slp_credit', '>', 1210)
                                ->where('slp_credit', '<', 1260);
                        });
                })
                // ->groupBy('slp_credit', 'slp_cre_customer')
                ->get();

            if ($results_m8->isNotEmpty()) {
                foreach ($results_m8 as $value) {

                    $cre_id2 = 0;
                    if ($value->customerWCredit !== null) $cre_id2 = $value->customerWCredit['cus_id'];

                    $cre_id1 = 2121;
                    $cre_id2 = $cre_id2; //fix
                    $cre_debit = 0;
                    $cre_credit = $value['total_slp_cre_tax'] == null ? 0 : $value['total_slp_cre_tax'];
                    $cre_sort_key = $cre_id1 . $cre_id2 . '0000';

                    $data_m8[] = ['cre_id1' => $cre_id1, 'cre_id2' => $cre_id2, 'cre_debit' => $cre_debit, 'cre_credit' => $cre_credit, 'cre_ses_key' => $key, 'cre_sort_key' => $cre_sort_key];
                }
                try {
                    DB::table('tmp_tb_cre')->insert($data_m8);
                } catch (QueryException $e) {
                    Log::error('Error while performing insert operation check m8: ' . $e->getMessage());
                }
            }

            //             $response_m8 = DB::table('tmp_tb_cre')->select('*')->get();
            //             dd($response_m8);

            //TODO============================ END PROCESS 8 =============================


            //TODO============================ PROCESS 9 =============================

            $results_m9 = $this->totalBalance->with('customer')
                ->select('tb_account', 'tb_customer', 'tb_balance')
                ->whereDate('tb_sum_date', '=', $from)
                ->get();
            //            dd($results_m9);

            if ($results_m9->isNotEmpty()) {
                foreach ($results_m9 as $value) {

                    $cus_name2 = '';
                    if ($value->customer !== null) $cus_name2 = $value->customer['cus_name2'];

                    $wk1_id1 = $value['tb_account'];
                    $wk1_id2 = $value['tb_customer'];
                    $wk1_balance = $value['tb_balance'];
                    $wk1_debit = 0;
                    $wk1_credit = 0;
                    $wk1_sort_key = (string)($wk1_id1 * 10000) . $cus_name2;

                    $data_m9[] = ['wk1_id1' => $wk1_id1, 'wk1_id2' => $wk1_id2, 'wk1_balance' => $wk1_balance, 'wk1_debit' => $wk1_debit, 'wk1_credit' => $wk1_credit, 'wk1_ses_key' => $key, 'wk1_sort_key' => $wk1_sort_key];
                }
                try {
                    DB::table('tmp_tb_work1')->insert($data_m9);
                } catch (QueryException $e) {
                    Log::error('Error while performing insert operation check m9: ' . $e->getMessage());
                }
            }

            //             $response_m9 = DB::table('tmp_tb_work1')->select('*')->get();
            //             dd($response_m9);

            //TODO============================ END PROCESS 9 =============================


            //TODO============================ PROCESS 10 =============================

            $results_m10 = DB::table('tmp_tb_deb')->select('deb_id1', 'deb_id2', 'deb_debit', 'deb_credit', 'deb_sort_key')
                ->where('deb_ses_key', '=', $key)
                ->get();

            //             dd( $results_m10);

            if ($results_m10->isNotEmpty()) {
                foreach ($results_m10 as $value) {

                    $wk1_id1 = $value->deb_id1;
                    $wk1_id2 = $value->deb_id2;
                    $wk1_balance = 0;
                    $wk1_debit = $value->deb_debit;
                    $wk1_credit = $value->deb_credit;
                    $wk1_sort_key = $value->deb_sort_key;

                    $data_m10[] = ['wk1_id1' => $wk1_id1, 'wk1_id2' => $wk1_id2, 'wk1_balance' => $wk1_balance, 'wk1_debit' => $wk1_debit, 'wk1_credit' => $wk1_credit, 'wk1_ses_key' => $key, 'wk1_sort_key' => $wk1_sort_key];
                }
                try {
                    DB::table('tmp_tb_work1')->insert($data_m10);
                } catch (QueryException $e) {
                    Log::error('Error while performing insert operation check m10: ' . $e->getMessage());
                }
            }

            //             $response_m10 = DB::table('tmp_tb_work1')->select('*')->get();
            //             dd($response_m10);
            //TODO============================ END PROCESS 10 =============================


            //TODO============================ PROCESS 11 =============================

            $results_m11 = DB::table('tmp_tb_cre')->select('cre_id1', 'cre_id2', 'cre_debit', 'cre_credit', 'cre_sort_key')
                ->where('cre_ses_key', '=', $key)
                ->get();

            // dd( $results_m11);

            if ($results_m11->isNotEmpty()) {
                foreach ($results_m11 as $value) {

                    $wk1_id1 = $value->cre_id1;
                    $wk1_id2 = $value->cre_id2;
                    $wk1_balance = 0;
                    $wk1_debit = $value->cre_debit;
                    $wk1_credit = $value->cre_credit;
                    $wk1_sort_key = $value->cre_sort_key;

                    $data_m11[] = ['wk1_id1' => $wk1_id1, 'wk1_id2' => $wk1_id2, 'wk1_balance' => $wk1_balance, 'wk1_debit' => $wk1_debit, 'wk1_credit' => $wk1_credit, 'wk1_ses_key' => $key, 'wk1_sort_key' => $wk1_sort_key];
                }
                try {
                    DB::table('tmp_tb_work1')->insert($data_m11);
                } catch (QueryException $e) {
                    Log::error('Error while performing insert operation check m11: ' . $e->getMessage());
                }
            }
            //
            //             $response_m11 = DB::table('tmp_tb_work1')->select('*')->get();
            //             dd($response_m11);

            //TODO============================ END PROCESS 11 =============================


            //TODO============================ PROCESS 12 =============================

            $results_m12 = DB::table('tmp_tb_work1')->select(DB::raw('wk1_id1, wk1_id2, sum(wk1_balance) as total_wk1_balance, sum(wk1_debit) as total_wk1_debit, sum(wk1_credit) as total_wk1_credit, wk1_sort_key'))
                ->where('wk1_ses_key', '=', $key)
                ->groupBy('wk1_id1', 'wk1_id2', 'wk1_sort_key')
                ->get();

            // dd( $results_m12);

            if ($results_m12->isNotEmpty()) {
                foreach ($results_m12 as $value) {
                    $wk2_id1 = $value->wk1_id1;
                    $wk2_id2 = $value->wk1_id2;
                    $wk2_balance = $value->total_wk1_balance;
                    $wk2_debit = $value->total_wk1_debit;
                    $wk2_credit = $value->total_wk1_credit;
                    $wk2_sort_key = $value->wk1_sort_key;

                    $data_m12[] = ['wk2_id1' => $wk2_id1, 'wk2_id2' => $wk2_id2, 'wk2_balance' => $wk2_balance, 'wk2_debit' => $wk2_debit, 'wk2_credit' => $wk2_credit, 'wk2_ses_key' => $key, 'wk2_sort_key' => $wk2_sort_key];
                }
                try {
                    DB::table('tmp_tb_work2')->insert($data_m12);
                } catch (QueryException $e) {
                    Log::error('Error while performing insert operation check m12: ' . $e->getMessage());
                }
            }

            // $response_m12 = DB::table('tmp_tb_work2')->select('*')->get();
            // dd($response_m12);

            //TODO============================ END PROCESS 12 =============================


            //TODO============================ PROCESS 13 =============================
            $results_m13 = DB::table('tmp_tb_work2')
                ->select('wk2_id1', 'wk2_id2', 'wk2_balance', 'wk2_debit', 'wk2_credit', 'wk2_sort_key')
                ->where('wk2_ses_key', '=', $key)
                ->where(function ($query) {
                    $query->where(function ($query) {
                        $query->where('wk2_id1', '>=', 2000)
                            ->where('wk2_id1', '<=', 2999);
                    })
                        ->orWhere(function ($query) {
                            $query->where('wk2_id1', '>=', 3000)
                                ->where('wk2_id1', '<=', 3999);
                        })
                        ->orWhere(function ($query) {
                            $query->where('wk2_id1', '>=', 4000)
                                ->where('wk2_id1', '<=', 4999);
                        })
                        ->orWhere(function ($query) {
                            $query->where('wk2_id1', '>=', 9000)
                                ->where('wk2_id1', '<=', 9999);
                        })
                        ->orWhere(function ($query) {
                            $query->whereBetween('wk2_id1', [7000, 7199]);
                        })
                        ->orWhere(function ($query) {
                            $query->whereBetween('wk2_id1', [8000, 8199]);
                        });
                })
                ->get();

            //             dd($results_m13);

            if ($results_m13->isNotEmpty()) {
                foreach ($results_m13 as $value) {
                    $wk3_id1 = $value->wk2_id1;
                    $wk3_id2 = $value->wk2_id2;
                    $wk3_balance = $value->wk2_balance;
                    $wk3_debit = $value->wk2_debit;
                    $wk3_credit = $value->wk2_credit;
                    $wk3_new_balance = ($value->wk2_balance) - ($value->wk2_debit) + ($value->wk2_credit);
                    $wk3_sort_key = $value->wk2_sort_key;

                    $data_m13[] = ['wk3_id1' => $wk3_id1, 'wk3_id2' => $wk3_id2, 'wk3_balance' => $wk3_balance, 'wk3_debit' => $wk3_debit, 'wk3_credit' => $wk3_credit, 'wk3_new_balance' => $wk3_new_balance, 'wk3_ses_key' => $key, 'wk3_sort_key' => $wk3_sort_key];
                }
                try {
                    DB::table('tmp_tb_work3')->insert($data_m13);
                } catch (QueryException $e) {
                    Log::error('Error while performing insert operation check m13: ' . $e->getMessage());
                }
            }

            //             $response_m13 = DB::table('tmp_tb_work3')->select('*')->get();
            //             dd($response_m13);

            //TODO============================ END PROCESS 13 =============================


            //TODO============================ PROCESS 14 =============================

            $results_m14 = DB::table('tmp_tb_work2')
                ->select('wk2_id1', 'wk2_id2', 'wk2_balance', 'wk2_debit', 'wk2_credit', 'wk2_sort_key')
                ->where('wk2_ses_key', '=', $key)
                ->where(function ($query) {
                    $query->where(function ($query) {
                        $query->where('wk2_id1', '>=', 1000)
                            ->where('wk2_id1', '<=', 1999);
                    })
                        ->orWhere(function ($query) {
                            $query->where('wk2_id1', '>=', 5000)
                                ->where('wk2_id1', '<=', 5999);
                        })
                        ->orWhere(function ($query) {
                            $query->where('wk2_id1', '>=', 6000)
                                ->where('wk2_id1', '<=', 6999);
                        })
                        ->orWhere(function ($query) {
                            $query->whereBetween('wk2_id1', [7200, 7999]);
                        })
                        ->orWhere(function ($query) {
                            $query->whereBetween('wk2_id1', [8200, 8999]);
                        });
                })
                ->get();

            //             dd($results_m14);

            if ($results_m14->isNotEmpty()) {
                foreach ($results_m14 as $value) {
                    $wk3_id1         = $value->wk2_id1;
                    $wk3_id2         = $value->wk2_id2;
                    $wk3_balance     = $value->wk2_balance;
                    $wk3_debit       = $value->wk2_debit;
                    $wk3_credit      = $value->wk2_credit;
                    $wk3_new_balance = ($value->wk2_balance) + ($value->wk2_debit) - ($value->wk2_credit);
                    $wk3_sort_key    = $value->wk2_sort_key;

                    $data_m14[] = ['wk3_id1' => $wk3_id1, 'wk3_id2' => $wk3_id2, 'wk3_balance' => $wk3_balance, 'wk3_debit' => $wk3_debit, 'wk3_credit' => $wk3_credit, 'wk3_new_balance' => $wk3_new_balance, 'wk3_ses_key' => $key, 'wk3_sort_key' => $wk3_sort_key];
                }
                try {
                    DB::table('tmp_tb_work3')->insert($data_m14);
                } catch (QueryException $e) {
                    Log::error('Error while performing insert operation check m14: ' . $e->getMessage());
                }
            }

            // $response_m14 = DB::table('tmp_tb_work3')->select('*')->get();
            // dd($response_m14);

            //TODO============================ END PROCESS 14 =============================


            //TODO============================  PROCESS 15 =============================

            // $results_m15 = DB::table('tmp_tb_work3')->select(DB::raw('wk3_id1, sum(wk3_balance) as total_wk3_balance, sum(wk3_debit) as total_wk3_debit, sum(wk3_credit) as total_wk3_credit, sum(wk3_new_balance) as total_wk3_new_balance'))
            //        ->where('wk3_ses_key', '=', $key)
            //     ->where('wk3_id1', '!=', 9000)
            //     ->groupBy('wk3_id1')
            //     ->get();

            // // dd($results_m15);

            // if ($results_m15->isNotEmpty()) {
            //     foreach ($results_m15 as $value) {
            //         $out_id1 = $value->wk3_id1;
            //         $out_id2 = 9999;

            //         $out_balance = $value->total_wk3_balance;
            //         $out_debit = $value->total_wk3_debit;
            //         $out_credit = $value->total_wk3_credit;
            //         $out_new_balance = $value->total_wk3_new_balance;
            //         $out_sort_key = (string)($out_id1 * 10000 + 9999);

            //         $data_m15[] = ['out_id1' => $out_id1, 'out_id2' => $out_id2, 'out_balance' => $out_balance, 'out_debit' => $out_debit, 'out_credit' => $out_credit, 'out_new_balance' => $out_new_balance, 'out_ses_key' => $key, 'out_sort_key' => $out_sort_key];
            //     }
            //     try {
            //         DB::table('tmp_tb_output')->insert($data_m15);
            //     } catch (QueryException $e) {
            //         Log::error('Error while performing insert operation check m15: ' . $e->getMessage());
            //     }
            // }

            // $response_m15 = DB::table('tmp_tb_output')->select('*')->get();
            // dd($response_m15);

            //TODO============================ END PROCESS 15 =============================


            //TODO============================  PROCESS 16 =============================

            // $results_m16 = DB::table('tmp_tb_work3')->select(DB::raw('wk3_id1, sum(wk3_balance) as total_wk3_balance, sum(wk3_debit) as total_wk3_debit, sum(wk3_credit) as total_wk3_credit, sum(wk3_new_balance) as total_wk3_new_balance'))
            //     ->where('wk3_ses_key', '=', $key)
            //     ->where('wk3_id1', '<>', 888000)
            //     ->groupBy('wk3_id1')
            //     ->get();

            // //             dd($results_m16);

            // if ($results_m16->isNotEmpty()) {
            //     foreach ($results_m16 as $value) {

            //         $out_id1 = $value->wk3_id1;
            //         $out_id2 = 9999999;
            //         $out_balance = $value->total_wk3_balance;
            //         $out_debit = $value->total_wk3_debit;
            //         $out_credit = $value->total_wk3_credit;
            //         $out_new_balance = $value->total_wk3_new_balance;
            //         $out_sort_key = (string)($out_id1 / 10000000 * 10000000 + 9999999);

            //         $data_m16[] = ['out_id1' => $out_id1, 'out_id2' => $out_id2, 'out_balance' => $out_balance, 'out_debit' => $out_debit, 'out_credit' => $out_credit, 'out_new_balance' => $out_new_balance, 'out_ses_key' => $key, 'out_sort_key' => $out_sort_key];
            //     }
            //     try {
            //         DB::table('tmp_tb_output')->insert($data_m16);
            //     } catch (QueryException $e) {
            //         Log::error('Error while performing insert operation check m16: ' . $e->getMessage());
            //     }
            // }

            // $response_m16 = DB::table('tmp_tb_output')->select('*')->get();
            // dd($response_m16);

            //TODO============================ END PROCESS 16 =============================


            //TODO============================  PROCESS 17 =============================

            $results_m17 = DB::table('tmp_tb_work3')->select(DB::raw('wk3_id1, wk3_id2, sum(wk3_balance) as total_wk3_balance, sum(wk3_debit) as total_wk3_debit, sum(wk3_credit) as total_wk3_credit, sum(wk3_new_balance) as total_wk3_new_balance, wk3_sort_key'))
                ->where('wk3_ses_key', '=', $key)
                ->groupBy('wk3_id1', 'wk3_id2', 'wk3_sort_key')
                ->get();

            //             dd($results_m17);

            if ($results_m17->isNotEmpty()) {
                foreach ($results_m17 as $value) {

                    $out_id1 = $value->wk3_id1;
                    $out_id2 = $value->wk3_id2;
                    $out_balance = $value->total_wk3_balance;
                    $out_debit = $value->total_wk3_debit;
                    $out_credit = $value->total_wk3_credit;
                    $out_new_balance = $value->total_wk3_new_balance;
                    $out_sort_key = $value->wk3_sort_key;

                    $data_m17[] = ['out_id1' => $out_id1, 'out_id2' => $out_id2, 'out_balance' => $out_balance, 'out_debit' => $out_debit, 'out_credit' => $out_credit, 'out_new_balance' => $out_new_balance, 'out_ses_key' => $key, 'out_sort_key' => $out_sort_key];
                }
                try {
                    DB::table('tmp_tb_output')->insert($data_m17);
                } catch (QueryException $e) {
                    Log::error('Error while performing insert operation check m17: ' . $e->getMessage());
                }
            }

            // $response_m17 = DB::table('tmp_tb_output')->select('*')->orderByRaw('out_id1 + out_id2, out_sort_key')->get();
            $response_m17 = DB::table('tmp_tb_output')->select('*')->orderBy('out_id1')->orderBy('out_id2')->get();
            // dd($response_m17);

            //TODO============================ END PROCESS 17 =============================


            //TODO============================  PROCESS 18 =============================

            $results_m18 = DB::table('tmp_tb_output')->select(DB::raw("out_id1, out_id2, out_debit"))
                ->where('out_id1', '>=', 1130)
                ->where('out_id1', '<', 1180)
                ->where(DB::raw('out_id1 % 10000'), '=', 9999)
                ->where('out_ses_key', '=', $key)
                ->get();

            //             dd($results_m18);
            if ($results_m18->isNotEmpty()) {
                foreach ($results_m18 as $value) {

                    $cst1_acc1 = $value->out_id1;
                    $cst1_acc2 = $value->out_id2;
                    $cst1_old_balance = 0;
                    $cst1_debit = $value->out_debit;
                    $cst1_date = $to;

                    $data_m18[] = ['cst1_acc1' => $cst1_acc1, 'cst1_acc2' => $cst1_acc2, 'cst1_old_balance' => $cst1_old_balance, 'cst1_debit' => $cst1_debit, 'cst1_date' => $cst1_date, 'cst1_ses_key' => $key];
                }
                try {
                    DB::table('tmp_tb_total_cost1')->insert($data_m18);
                } catch (QueryException $e) {
                    Log::error('Error while performing insert operation check m18: ' . $e->getMessage());
                }
            }

            //             $response_m18 = DB::table('tmp_tb_total_cost1')->select('*')->get();
            //             dd($response_m18);

            //TODO============================ END PROCESS 18 =============================


            //TODO============================ PROCESS 19 =============================

            $results_m19 = DB::table('pl_cost')->select(DB::raw("plcost_account, plcost_customer, plcost_balance"))
                ->where('plcost_date', '=', $from)
                ->where('plcost_status', '=', 1)
                ->get();

            //             dd($results_m19);

            if ($results_m19->isNotEmpty()) {
                foreach ($results_m19 as $value) {

                    $cst1_acc1 = $value->plcost_account;
                    $cst1_acc2 = $value->plcost_customer;
                    $cst1_old_balance = $value->plcost_balance;
                    $cst1_debit = 0;
                    $cst1_date = $to;

                    $data_m19[] = ['cst1_acc1' => $cst1_acc1, 'cst1_acc2' => $cst1_acc2, 'cst1_old_balance' => $cst1_old_balance, 'cst1_debit' => $cst1_debit, 'cst1_date' => $cst1_date, 'cst1_ses_key' => $key];
                }
                try {
                    DB::table('tmp_tb_total_cost1')->insert($data_m19);
                } catch (QueryException $e) {
                    Log::error('Error while performing insert operation check m19: ' . $e->getMessage());
                }
            }

            // $response_m19 = DB::table('tmp_tb_total_cost1')->select('*')->get();
            // dd($response_m19);

            //TODO============================ END PROCESS 19 =============================


            //TODO============================ END PROCESS 20 =============================

            $results_m20 = DB::table('tmp_tb_total_cost1')->select(DB::raw("cst1_acc1, cst1_acc2, sum(cst1_old_balance) as total_cst1_old_balance,  sum(cst1_debit) as total_cst1_debit, sum(cst1_old_balance) as total_cst1_old_balance, cst1_date, cst1_ses_key"))
                ->where('cst1_date', '=', $to)
                ->where('cst1_ses_key', '=', $key)
                ->groupBy('cst1_acc1', 'cst1_acc2', 'cst1_date', 'cst1_ses_key')
                ->get();

            //             dd($results_m20);

            if ($results_m20->isNotEmpty()) {
                foreach ($results_m20 as $value) {

                    $cst2_acc1 = $value->cst1_acc1;
                    $cst2_acc2 = $value->cst1_acc2;
                    $cst2_old_balance = $value->total_cst1_old_balance;
                    $cst2_debit = $value->total_cst1_debit;
                    $cst2_new_balance = $value->total_cst1_old_balance;
                    $cst2_date = $value->cst1_date;

                    $data_m20[] = ['cst2_acc1' => $cst2_acc1, 'cst2_acc2' => $cst2_acc2, 'cst2_old_balance' => $cst2_old_balance, 'cst2_debit' => $cst2_debit, 'cst2_new_balance' => $cst2_new_balance, 'cst2_date' => $cst2_date, 'cst2_ses_key' => $key];
                }
                try {
                    DB::table('tmp_tb_total_cost2')->insert($data_m20);
                } catch (QueryException $e) {
                    Log::error('Error while performing insert operation check m20: ' . $e->getMessage());
                }
            }

            // $response_m20 = DB::table('tmp_tb_total_cost2')->select('*')->get();
            // dd($response_m20);

            //TODO============================ END PROCESS 20 =============================

            if ($flag) {

                //TODO============================ PROCESS 21 =============================
                $results_m21 = DB::table('tmp_tb_work3')->select('wk3_id1', 'wk3_id2', 'wk3_new_balance')
                    ->where('wk3_ses_key', '=', $key)
                    ->get();

                // dd($results_m21);

                if ($results_m21->isNotEmpty()) {
                    foreach ($results_m21 as $value) {

                        $tb_sum_date = $to;
                        $tb_ref_date = $from;
                        $tb_account = $value->wk3_id1;
                        $tb_customer = $value->wk3_id2;
                        $tb_balance = $value->wk3_new_balance;

                        $data_m21[] = ['tb_sum_date' => $tb_sum_date, 'tb_ref_date' => $tb_ref_date, 'tb_account' => $tb_account, 'tb_customer' => $tb_customer, 'tb_balance' => $tb_balance];
                    }
                    try {
                        DB::table('total_balances')->insert($data_m21);
                    } catch (QueryException $e) {
                        Log::error('Error while performing insert operation check m21: ' . $e->getMessage());
                    }
                }

                // $response_m21 = DB::table('total_balances')->select('*')->get();
                // dd($response_m21);

                try {
                    Slip::where('slp_status', 1)
                        ->where('slp_date2', '>=', $from)
                        ->where('slp_date2', '<', $to)
                        ->update(['slp_status' => 2]);
                } catch (QueryException $e) {
                    Log::error('Error while performing insert operation check m21b: ' . $e->getMessage());
                }


                //TODO============================ END PROCESS 21 =============================


                //TODO============================  PROCESS 22 =============================

                $results_m22 = DB::table('tmp_tb_total_cost2')->select('cst2_acc1', 'cst2_acc2', 'cst2_date', 'cst2_new_balance')
                    ->where('cst2_date', '=', $to)
                    ->where('cst2_ses_key', '=', $key)
                    ->get();

                // dd($results_m22);

                if ($results_m22->isNotEmpty()) {
                    foreach ($results_m22 as $value) {

                        $plcost_account  = $value->cst2_acc1;
                        $plcost_customer = $value->cst2_acc2;
                        $plcost_date     = $value->cst2_date;
                        $plcost_balance  = $value->cst2_new_balance;
                        $plcost_status   = 1;

                        $data_m22[] = ['plcost_account' => $plcost_account, 'plcost_customer' => $plcost_customer, 'plcost_date' => $plcost_date, 'plcost_balance' => $plcost_balance, 'plcost_status' => $plcost_status];
                    }
                    try {
                        DB::table('pl_cost')->insert($data_m22);
                    } catch (QueryException $e) {
                        Log::error('Error while performing insert operation check m22: ' . $e->getMessage());
                    }
                }

                //  $response_m22 = DB::table('pl_cost')->select('*')->get();
                // dd($response_m22);

                //TODO============================ END PROCESS 22 =============================

            }
            DB::commit();
            return $response_m17;
        } catch (\Throwable $th) {

            Log::error($th);
            DB::rollBack();
            return false;
        }
    }


    /**
     * createTemporaryTable
     * Created at: 12/07/2023
     * Created by: Kieu
     */
    public function createTemporaryTableOrg($key, $from, $to, $flag)
    {
        try {

            //TODO============================ CREATE TABLE =============================

            DB::statement('CREATE TEMPORARY TABLE tmp_tb_deb (
                            deb_id1 INT,
                            deb_id2 INT,
                            deb_debit INT NOT NULL DEFAULT 0,
                            deb_credit INT,
                            deb_ses_key VARCHAR(24),
                            deb_sort_key VARCHAR(64)
                         )');
            DB::statement(' CREATE TEMPORARY TABLE tmp_tb_cre (
                            cre_id1 INT,
                            cre_id2 INT,
                            cre_debit INT,
                            cre_credit INT NOT NULL DEFAULT 0,
                            cre_ses_key VARCHAR(24),
                            cre_sort_key VARCHAR(64)
                        )');
            DB::statement('CREATE TEMPORARY TABLE tmp_tb_work1 (
                            wk1_id1 INT,
                            wk1_id2 INT,
                            wk1_balance INT,
                            wk1_debit INT NOT NULL DEFAULT 0,
                            wk1_credit INT NOT NULL DEFAULT 0,
                            wk1_ses_key VARCHAR(24),
                            wk1_sort_key VARCHAR(64)
                        )');
            DB::statement('CREATE TEMPORARY TABLE tmp_tb_work2 (
                            wk2_id1 INT,
                            wk2_id2 INT,
                            wk2_balance INT,
                            wk2_debit INT,
                            wk2_credit INT,
                            wk2_ses_key VARCHAR(24),
                            wk2_sort_key VARCHAR(64)
                        )');
            DB::statement('CREATE TEMPORARY TABLE tmp_tb_work3 (
                            wk3_id1 INT,
                            wk3_id2 INT,
                            wk3_balance INT,
                            wk3_debit INT,
                            wk3_credit INT,
                            wk3_new_balance INT,
                            wk3_ses_key VARCHAR(24),
                            wk3_sort_key VARCHAR(64)
                        )');
            DB::statement('CREATE TEMPORARY TABLE tmp_tb_output (
                            out_id1 INT,
                            out_id2 INT NOT NULL DEFAULT 9999,
                            out_balance INT,
                            out_debit INT,
                            out_credit INT,
                            out_new_balance INT,
                            out_ses_key VARCHAR(24),
                            out_sort_key VARCHAR(64)
                        )');
            DB::statement('CREATE TEMPORARY TABLE tmp_tb_total_cost1 (
                            cst1_acc1 INT,
                            cst1_acc2 INT,
                            cst1_old_balance INT,
                            cst1_debit INT,
                            cst1_date DATE,
                            cst1_ses_key VARCHAR(24)
                        )');
            DB::statement('CREATE TEMPORARY TABLE tmp_tb_total_cost2 (
                            cst2_acc1 INT,
                            cst2_acc2 INT,
                            cst2_old_balance INT,
                            cst2_debit INT,
                            cst2_new_balance INT,
                            cst2_date DATE,
                            cst2_ses_key VARCHAR(24)
                        )');

            //TODO============================ END CREATE TABLE =============================

            //TODO============================ PROCESS 1 =============================

            $results_m1 = $this->slip->with('customer')
                ->select(DB::raw('sum(slp_money_w_tax) as total_money_w_tax, slp_debit, slp_deb_customer'))
                ->where('slp_status', '=', 1)
                ->whereDate('slp_date2', '>=', $from)->whereDate('slp_date2', '<', $to)
                ->where(function ($query) {
                    $query->where('slp_debit', '<', 1122)
                        ->orWhere('slp_debit', '=', 1122)
                        ->orWhere('slp_debit', '=', 2116);
                })
                ->groupBy('slp_debit', 'slp_deb_customer')
                ->get();

            // dd($results_m1);

            if ($results_m1->isNotEmpty()) {

                foreach ($results_m1 as $value) {
                    $cus_name2 = '';
                    if ($value->customer !== null) $cus_name2 = $value->customer['cus_name2'];

                    $slp_debit = $value['slp_debit'];
                    $slp_deb_customer = $value['slp_deb_customer'];
                    $deb_debit = $value['total_money_w_tax'];
                    $deb_sort_key = (string)($slp_debit + $slp_deb_customer) . $cus_name2;

                    $data[] = ['deb_id1' => $slp_debit, 'deb_id2' => $slp_deb_customer, 'deb_debit' => $deb_debit, 'deb_credit' => 0, 'deb_ses_key' => $key, 'deb_sort_key' => $deb_sort_key];
                }

                try {
                    DB::table('tmp_tb_deb')->insert($data);
                } catch (QueryException $e) {
                    Log::error('Error while performing insert operation check m1: ' . $e->getMessage());
                }
            }

            // $response_m1 = DB::table('tmp_tb_deb')->select('*')->get();
            // dd($response_m1);

            //TODO============================ END PROCESS 1 =============================


            //TODO============================ PROCESS 2 =============================

            $results_m2 = $this->slip->with('customer')
                ->select(DB::raw('sum(slp_money_wo_tax) as total_slp_money_wo_tax, slp_debit, slp_deb_customer'))
                ->where('slp_status', '=', 1)
                ->whereDate('slp_date2', '>=', $from)->whereDate('slp_date2', '<', $to)
                ->where(function ($query) {
                    $query->where('slp_debit', '>', 1122)
                        ->where('slp_debit', '!=', 2116);
                })
                ->groupBy('slp_debit', 'slp_deb_customer')
                ->get();

            // dd($results_m2);

            if ($results_m2->isNotEmpty()) {

                foreach ($results_m2 as $value) {

                    $cus_name2 = '';
                    if ($value->customer !== null) $cus_name2 = $value->customer['cus_name2'];

                    $slp_debit = $value['slp_debit'];
                    $slp_deb_customer = $value['slp_deb_customer'];
                    $slp_money_wo_tax = $value['total_slp_money_wo_tax'];
                    $deb_sort_key = (string)($slp_debit + $slp_deb_customer) . $cus_name2;

                    $data_m2[] = ['deb_id1' => $slp_debit, 'deb_id2' => $slp_deb_customer, 'deb_debit' => $slp_money_wo_tax, 'deb_credit' => 0, 'deb_ses_key' => $key, 'deb_sort_key' => $deb_sort_key];
                }
                try {
                    DB::table('tmp_tb_deb')->insert($data_m2);
                } catch (QueryException $e) {
                    Log::error('Error while performing insert operation check m2: ' . $e->getMessage());
                }
            }

            // $response_m2 = DB::table('tmp_tb_deb')->select('*')->get();
            // dd($response_m2);

            //TODO============================ END PROCESS 2 =============================


            //TODO============================ PROCESS 3 =============================

            $results_m3 = $this->slip->with('customer')
                ->select(DB::raw('sum(slp_deb_tax) as total_slp_deb_tax, slp_deb_customer'))
                ->where('slp_status', '=', 1)
                ->whereDate('slp_date2', '>=', $from)->whereDate('slp_date2', '<', $to)
                ->where(function ($query) {
                    $query->whereBetween('slp_debit', [1130, 1170])
                        ->orWhereBetween('slp_debit', [6000, 7000])
                        ->orWhereBetween('slp_debit', [1211, 1223])
                        ->orWhere('slp_debit', '=', 1187);
                })
                ->groupBy('slp_deb_customer')
                ->get();

            // dd($results_m3);

            if ($results_m3->isNotEmpty()) {
                foreach ($results_m3 as $value) {

                    $deb_id2 = 0;
                    if ($value->customer !== null) $deb_id2 = $value->customer['cus_id'];

                    $deb_id1 = 1187;
                    $deb_id2 = $deb_id2; // fix
                    $deb_debit = $value['total_slp_deb_tax'];
                    $deb_credit = 0;
                    $deb_sort_key = $deb_id1 . $deb_id2 . '0000'; //fix

                    $data_m3[] = ['deb_id1' => $deb_id1, 'deb_id2' => $deb_id2, 'deb_debit' => $deb_debit, 'deb_credit' => $deb_credit, 'deb_ses_key' => $key, 'deb_sort_key' => $deb_sort_key];
                }
                try {
                    DB::table('tmp_tb_deb')->insert($data_m3);
                } catch (QueryException $e) {
                    Log::error('Error while performing insert operation check m3: ' . $e->getMessage());
                }
            }

            // $response_m3 = DB::table('tmp_tb_deb')->select('*')->get();
            // dd($response_m3);

            //TODO============================ END PROCESS 3 =============================


            //TODO============================  PROCESS 4 =============================

            $results_m4 = $this->slip->with('customer')
                ->select(DB::raw('sum(slp_deb_tax) as total_slp_deb_tax'))
                ->where('slp_status', '=', 1)
                ->whereDate('slp_date2', '>=', $from)->whereDate('slp_date2', '<', $to)
                ->where('slp_debit', '=', 2121)
                ->groupBy('slp_debit')
                ->get();
            // dd($results_m4);

            if ($results_m4->isNotEmpty()) {
                foreach ($results_m4 as $value) {

                    $deb_id2 = 0;
                    if ($value->customer !== null) $deb_id2 = $value->customer['cus_id'];

                    $deb_id1 = 2121;
                    $deb_id2 = $deb_id2; // fix
                    $deb_debit = $value['total_slp_deb_tax'];
                    $deb_credit = 0;
                    $deb_sort_key = $deb_id1 . $deb_id2 . '0000'; //fix

                    $data_m4[] = ['deb_id1' => $deb_id1, 'deb_id2' => $deb_id2, 'deb_debit' => $deb_debit, 'deb_credit' => $deb_credit, 'deb_ses_key' => $key, 'deb_sort_key' => $deb_sort_key];
                }
                try {
                    DB::table('tmp_tb_deb')->insert($data_m4);
                } catch (QueryException $e) {
                    Log::error('Error while performing insert operation check m4: ' . $e->getMessage());
                }
            }

            // $response_m4 = DB::table('tmp_tb_deb')->select('*')->get();
            // dd($response_m4);

            //TODO============================ END PROCESS 4 =============================


            //TODO============================ PROCESS 5 =============================


            $results_m5 = $this->slip->with('customerWCredit')
                ->select(DB::raw('SUM(slp_money_w_tax) as total_slp_money_w_tax, slp_credit, slp_cre_customer'))
                ->where(function ($query) {
                    $query->where('slp_status', 1)
                        ->orWhere('slp_status', 2);
                })
                ->whereDate('slp_date2', '>=', $from)->whereDate('slp_date2', '<', $to)
                ->where(function ($query) {
                    $query->where('slp_credit', '<', 1122)
                        ->orWhere('slp_credit', '=',  2112)
                        ->orWhereBetween('slp_credit', [2114, 2116])
                        ->orWhere('slp_credit', '=', 1122);
                })
                ->groupBy('slp_credit', 'slp_cre_customer')
                ->get();
            // dd($results_m5);

            if ($results_m5->isNotEmpty()) {
                foreach ($results_m5 as $value) {

                    $cus_name2 = '';
                    if ($value->customerWCredit !== null) $cus_name2 = $value->customerWCredit['cus_name2'];

                    $cre_id1 = $value['slp_credit'];
                    $cre_id2 = $value['slp_cre_customer'];
                    $cre_debit = 0;
                    $cre_credit = $value['total_slp_money_w_tax'];
                    $cre_sort_key = (string)($cre_id1 + $cre_id2) . $cus_name2;

                    $data_m5[] = ['cre_id1' => $cre_id1, 'cre_id2' => $cre_id2, 'cre_debit' => $cre_debit, 'cre_credit' => $cre_credit, 'cre_ses_key' => $key, 'cre_sort_key' => $cre_sort_key];
                }
                try {
                    DB::table('tmp_tb_cre')->insert($data_m5);
                } catch (QueryException $e) {
                    Log::error('Error while performing insert operation check m5: ' . $e->getMessage());
                }
            }

            // $response_m5 = DB::table('tmp_tb_cre')->select('*')->get();
            // dd($response_m5);

            //TODO============================ END PROCESS 5 =============================


            //TODO============================ PROCESS 6 =============================
            $results_m6 = $this->slip->with('customerWCredit')
                ->select(DB::raw('sum(slp_cre_tax) as total_slp_cre_tax, slp_cre_customer'))
                ->where('slp_status', '=', 1)
                ->whereDate('slp_date2', '>=', $from)
                ->whereDate('slp_date2', '<', $to)
                ->where('slp_credit', '=', 1187)
                ->groupBy('slp_cre_customer')
                ->get();

            // dd( $results_m6 );

            if ($results_m6->isNotEmpty()) {
                foreach ($results_m6 as $value) {

                    $cre_id2 = 0;
                    if ($value->customerWCredit !== null) $cre_id2 = $value->customerWCredit['cus_id'];

                    $cre_id1 = 1187;
                    $cre_id2 = $cre_id2; //fix
                    $cre_debit = 0;
                    $cre_credit = $value['total_slp_cre_tax'];
                    $cre_sort_key = $cre_id1 . $cre_id2 . '0000'; //fix

                    $data_m6[] = ['cre_id1' => $cre_id1, 'cre_id2' => $cre_id2, 'cre_debit' => $cre_debit, 'cre_credit' => $cre_credit, 'cre_ses_key' => $key, 'cre_sort_key' => $cre_sort_key];
                }
                try {
                    DB::table('tmp_tb_cre')->insert($data_m6);
                } catch (QueryException $e) {
                    Log::error('Error while performing insert operation check m6: ' . $e->getMessage());
                }
            }

            // $response_m6 = DB::table('tmp_tb_cre')->select('*')->get();
            // dd($response_m6);

            //TODO============================ END PROCESS 6 =============================


            //TODO============================ PROCESS 7 =============================

            $results_m7 = $this->slip->with('customerWCredit')
                ->select(DB::raw('sum(slp_money_wo_tax) as total_slp_money_wo_tax, slp_credit, slp_cre_customer'))
                ->where('slp_status', '=', 1)
                ->whereDate('slp_date2', '>=', $from)->whereDate('slp_date2', '<', $to)
                ->where('slp_credit', '>=', 1122)
                ->where('slp_credit', '!=', 2112)
                ->where('slp_credit', '!=', 2114)
                ->where('slp_credit', '!=', 2115)
                ->where('slp_credit', '!=', 2116)
                ->where('slp_credit', '!=', 1122)
                ->groupBy('slp_credit', 'slp_cre_customer')
                ->get();

            // dd( $results_m7 );

            if ($results_m7->isNotEmpty()) {
                foreach ($results_m7 as $value) {

                    $cus_name2 = '';
                    if ($value->customerWCredit !== null) $cus_name2 = $value->customerWCredit['cus_name2'];

                    $cre_id1 = $value['slp_credit'];
                    $cre_id2 = $value['slp_cre_customer'];
                    $cre_debit = 0;
                    $cre_credit = $value['total_slp_money_wo_tax'];
                    $cre_sort_key = (string)($cre_id1 + $cre_id2) . $cus_name2;

                    $data_m7[] = ['cre_id1' => $cre_id1, 'cre_id2' => $cre_id2, 'cre_debit' => $cre_debit, 'cre_credit' => $cre_credit, 'cre_ses_key' => $key, 'cre_sort_key' => $cre_sort_key];
                }
                try {
                    DB::table('tmp_tb_cre')->insert($data_m7);
                } catch (QueryException $e) {
                    Log::error('Error while performing insert operation check m7: ' . $e->getMessage());
                }
            }

            // $response_m7 = DB::table('tmp_tb_cre')->select('*')->get();
            // dd($response_m7);

            //TODO============================ END PROCESS 7 =============================


            //TODO============================ PROCESS 7 =============================

            $results_m8 = $this->slip->with('customerWCredit')
                ->select(DB::raw('sum(slp_cre_tax) as total_slp_cre_tax'))
                ->where('slp_status', '=', 1)
                ->whereDate('slp_date2', '>=', $from)->whereDate('slp_date2', '<', $to)
                ->where(function ($query) {
                    $query->whereIn('slp_credit', [4111, 7118, 2121])
                        ->orWhere(function ($query) {
                            $query->where('slp_credit', '>', 1210)
                                ->where('slp_credit', '<', 1260);
                        });
                })
                // ->groupBy('slp_credit', 'slp_cre_customer')
                ->get();
            // dd( $results_m8 );

            if ($results_m8->isNotEmpty()) {
                foreach ($results_m8 as $value) {

                    $cre_id2 = 0;
                    if ($value->customerWCredit !== null) $cre_id2 = $value->customerWCredit['cus_id'];

                    $cre_id1 = 2121;
                    $cre_id2 = $cre_id2; //fix
                    $cre_debit = 0;
                    $cre_credit = $value['total_slp_cre_tax'] == null ? 0 : $value['total_slp_cre_tax'];
                    $cre_sort_key = $cre_id1 . $cre_id2 . '0000';

                    $data_m8[] = ['cre_id1' => $cre_id1, 'cre_id2' => $cre_id2, 'cre_debit' => $cre_debit, 'cre_credit' => $cre_credit, 'cre_ses_key' => $key, 'cre_sort_key' => $cre_sort_key];
                }
                try {
                    DB::table('tmp_tb_cre')->insert($data_m8);
                } catch (QueryException $e) {
                    Log::error('Error while performing insert operation check m8: ' . $e->getMessage());
                }
            }

            // $response_m8 = DB::table('tmp_tb_cre')->select('*')->get();
            // dd($response_m8);

            //TODO============================ PROCESS 8 =============================


            //TODO============================ PROCESS 9 =============================

            $results_m9 = $this->totalBalance->with('customer')
                ->select('tb_account', 'tb_customer', 'tb_balance')
                ->whereDate('tb_sum_date', '=', $from)
                ->get();

            // dd($response_m9);

            if ($results_m9->isNotEmpty()) {
                foreach ($results_m9 as $value) {

                    $cus_name2 = '';
                    if ($value->customer !== null) $cus_name2 = $value->customer['cus_name2'];

                    $wk1_id1 = $value['tb_account'];
                    $wk1_id2 = $value['tb_customer'];
                    $wk1_balance = $value['tb_balance'];
                    $wk1_debit = 0;
                    $wk1_credit = 0;
                    $wk1_sort_key = (string)($wk1_id1 * 10000) . $cus_name2;

                    $data_m9[] = ['wk1_id1' => $wk1_id1, 'wk1_id2' => $wk1_id2, 'wk1_balance' => $wk1_balance, 'wk1_debit' => $wk1_debit, 'wk1_credit' => $wk1_credit, 'wk1_ses_key' => $key, 'wk1_sort_key' => $wk1_sort_key];
                }
                try {
                    DB::table('tmp_tb_work1')->insert($data_m9);
                } catch (QueryException $e) {
                    Log::error('Error while performing insert operation check m9: ' . $e->getMessage());
                }
            }

            // $response_m9 = DB::table('tmp_tb_work1')->select('*')->get();
            // dd($response_m9);

            //TODO============================ END PROCESS 9 =============================


            //TODO============================ PROCESS 10 =============================

            $results_m10 = DB::table('tmp_tb_deb')->select('deb_id1', 'deb_id2', 'deb_debit', 'deb_credit', 'deb_sort_key')
                ->where('deb_ses_key', '=', $key)
                ->get();

            // dd( $results_m10);

            if ($results_m10->isNotEmpty()) {
                foreach ($results_m10 as $value) {

                    $wk1_id1 = $value->deb_id1;
                    $wk1_id2 = $value->deb_id2;
                    $wk1_balance = 0;
                    $wk1_debit = $value->deb_debit;
                    $wk1_credit = $value->deb_credit;
                    $wk1_sort_key = $value->deb_sort_key;

                    $data_m10[] = ['wk1_id1' => $wk1_id1, 'wk1_id2' => $wk1_id2, 'wk1_balance' => $wk1_balance, 'wk1_debit' => $wk1_debit, 'wk1_credit' => $wk1_credit, 'wk1_ses_key' => $key, 'wk1_sort_key' => $wk1_sort_key];
                }
                try {
                    DB::table('tmp_tb_work1')->insert($data_m10);
                } catch (QueryException $e) {
                    Log::error('Error while performing insert operation check m10: ' . $e->getMessage());
                }
            }

            // $response_m10 = DB::table('tmp_tb_work1')->select('*')->get();
            // dd($response_m10);
            //TODO============================ END PROCESS 10 =============================


            //TODO============================ PROCESS 11 =============================

            $results_m11 = DB::table('tmp_tb_cre')->select('cre_id1', 'cre_id2', 'cre_debit', 'cre_credit', 'cre_sort_key')
                ->where('cre_ses_key', '=', $key)
                ->get();

            // dd( $results_m11);

            if ($results_m11->isNotEmpty()) {
                foreach ($results_m11 as $value) {

                    $wk1_id1 = $value->cre_id1;
                    $wk1_id2 = $value->cre_id2;
                    $wk1_balance = 0;
                    $wk1_debit = $value->cre_debit;
                    $wk1_credit = $value->cre_credit;
                    $wk1_sort_key = $value->cre_sort_key;

                    $data_m11[] = ['wk1_id1' => $wk1_id1, 'wk1_id2' => $wk1_id2, 'wk1_balance' => $wk1_balance, 'wk1_debit' => $wk1_debit, 'wk1_credit' => $wk1_credit, 'wk1_ses_key' => $key, 'wk1_sort_key' => $wk1_sort_key];
                }
                try {
                    DB::table('tmp_tb_work1')->insert($data_m11);
                } catch (QueryException $e) {
                    Log::error('Error while performing insert operation check m11: ' . $e->getMessage());
                }
            }

            // $response_m11 = DB::table('tmp_tb_work1')->select('*')->get();
            // dd($response_m11);

            //TODO============================ END PROCESS 11 =============================


            //TODO============================ PROCESS 12 =============================

            $results_m12 = DB::table('tmp_tb_work1')->select(DB::raw('wk1_id1, wk1_id2, sum(wk1_balance) as total_wk1_balance, sum(wk1_debit) as total_wk1_debit, sum(wk1_credit) as total_wk1_credit, wk1_sort_key'))
                ->where('wk1_ses_key', '=', $key)
                ->groupBy('wk1_id1', 'wk1_id2', 'wk1_sort_key')
                ->get();

            // dd( $results_m12);

            if ($results_m12->isNotEmpty()) {
                foreach ($results_m12 as $value) {
                    $wk2_id1 = $value->wk1_id1;
                    $wk2_id2 = $value->wk1_id2;
                    $wk2_balance = $value->total_wk1_balance;
                    $wk2_debit = $value->total_wk1_debit;
                    $wk2_credit = $value->total_wk1_credit;
                    $wk2_sort_key = $value->wk1_sort_key;

                    $data_m12[] = ['wk2_id1' => $wk2_id1, 'wk2_id2' => $wk2_id2, 'wk2_balance' => $wk2_balance, 'wk2_debit' => $wk2_debit, 'wk2_credit' => $wk2_credit, 'wk2_ses_key' => $key, 'wk2_sort_key' => $wk2_sort_key];
                }
                try {
                    DB::table('tmp_tb_work2')->insert($data_m12);
                } catch (QueryException $e) {
                    Log::error('Error while performing insert operation check m12: ' . $e->getMessage());
                }
            }

            // $response_m12 = DB::table('tmp_tb_work2')->select('*')->get();
            // dd($response_m12);

            //TODO============================ END PROCESS 12 =============================


            //TODO============================ PROCESS 13 =============================
            $results_m13 = DB::table('tmp_tb_work2')->select('wk2_id1', 'wk2_id2', 'wk2_balance', 'wk2_debit', 'wk2_credit', 'wk2_sort_key')
                ->where('wk2_ses_key', '=', $key)
                ->where(function ($query) {
                    $query->whereIn('wk2_id1', [2000, 3000, 4000, 9000])
                        ->orWhere(function ($query) {
                            $query->whereBetween('wk2_id1', [7000, 7199])
                                ->orWhereBetween('wk2_id1', [8000, 8199]);
                        });
                })
                ->get();

            // dd($results_m13);

            if ($results_m13->isNotEmpty()) {
                foreach ($results_m13 as $value) {
                    $wk3_id1 = $value->wk2_id1;
                    $wk3_id2 = $value->wk2_id2;
                    $wk3_balance = $value->wk2_balance;
                    $wk3_debit = $value->wk2_debit;
                    $wk3_credit = $value->wk2_credit;
                    $wk3_new_balance = ($value->wk2_balance) - ($value->wk2_debit) + ($value->wk2_credit);
                    $wk3_sort_key = $value->wk2_sort_key;

                    $data_m13[] = ['wk3_id1' => $wk3_id1, 'wk3_id2' => $wk3_id2, 'wk3_balance' => $wk3_balance, 'wk3_debit' => $wk3_debit, 'wk3_credit' => $wk3_credit, 'wk3_new_balance' => $wk3_new_balance, 'wk3_ses_key' => $key, 'wk3_sort_key' => $wk3_sort_key];
                }
                try {
                    DB::table('tmp_tb_work3')->insert($data_m13);
                } catch (QueryException $e) {
                    Log::error('Error while performing insert operation check m13: ' . $e->getMessage());
                }
            }

            // $response_m13 = DB::table('tmp_tb_work3')->select('*')->get();
            // dd($response_m13);

            //TODO============================ END PROCESS 13 =============================


            //TODO============================ PROCESS 14 =============================

            $results_m14 = DB::table('tmp_tb_work2')->select('wk2_id1', 'wk2_id2', 'wk2_balance', 'wk2_debit', 'wk2_credit', 'wk2_sort_key')
                ->where('wk2_ses_key', '=', $key)
                ->where(function ($query) {
                    $query->whereIn('wk2_id1', [1000, 5000, 6000])
                        ->orWhere(function ($query) {
                            $query->whereBetween('wk2_id1', [7200, 7999])
                                ->orWhereBetween('wk2_id1', [8200, 8999]);
                        });
                })
                ->get();

            // dd($results_m14);

            if ($results_m14->isNotEmpty()) {
                foreach ($results_m14 as $value) {
                    $wk3_id1 = $value->wk2_id1;
                    $wk3_id2 = $value->wk2_id2;
                    $wk3_balance = $value->wk2_balance;
                    $wk3_debit = $value->wk2_debit;
                    $wk3_credit = $value->wk2_credit;
                    $wk3_new_balance = ($value->wk2_balance) + ($value->wk2_debit) - ($value->wk2_credit);
                    $wk3_sort_key = $value->wk2_sort_key;

                    $data_m14[] = ['wk3_id1' => $wk3_id1, 'wk3_id2' => $wk3_id2, 'wk3_balance' => $wk3_balance, 'wk3_debit' => $wk3_debit, 'wk3_credit' => $wk3_credit, 'wk3_new_balance' => $wk3_new_balance, 'wk3_ses_key' => $key, 'wk3_sort_key' => $wk3_sort_key];
                }
                try {
                    DB::table('tmp_tb_work3')->insert($data_m14);
                } catch (QueryException $e) {
                    Log::error('Error while performing insert operation check m14: ' . $e->getMessage());
                }
            }

            // $response_m14 = DB::table('tmp_tb_work3')->select('*')->get();
            // dd($response_m14);

            //TODO============================ END PROCESS 14 =============================


            //TODO============================  PROCESS 15 =============================

            $results_m15 = DB::table('tmp_tb_work3')->select(DB::raw('wk3_id1, sum(wk3_balance) as total_wk3_balance, sum(wk3_debit) as total_wk3_debit, sum(wk3_credit) as total_wk3_credit, sum(wk3_new_balance) as total_wk3_new_balance'))
                ->where('wk3_ses_key', '=', $key)
                ->where('wk3_id1', '<>', 9000)
                ->groupBy('wk3_id1')
                ->get();

            // dd($results_m15);

            if ($results_m15->isNotEmpty()) {
                foreach ($results_m15 as $value) {

                    $out_id1 = $value->wk3_id1;
                    $out_id2 = 9999;

                    $out_balance = $value->total_wk3_balance;
                    $out_debit = $value->total_wk3_debit;
                    $out_credit = $value->total_wk3_credit;
                    $out_new_balance = $value->total_wk3_new_balance;
                    $out_sort_key = (string)($out_id1 * 10000 + 9999);

                    $data_m15[] = ['out_id1' => $out_id1, 'out_id2' => $out_id2, 'out_balance' => $out_balance, 'out_debit' => $out_debit, 'out_credit' => $out_credit, 'out_new_balance' => $out_new_balance, 'out_ses_key' => $key, 'out_sort_key' => $out_sort_key];
                }
                try {
                    DB::table('tmp_tb_output')->insert($data_m15);
                } catch (QueryException $e) {
                    Log::error('Error while performing insert operation check m15: ' . $e->getMessage());
                }
            }

            // $response_m15 = DB::table('tmp_tb_output')->select('*')->get();
            // dd($response_m15);

            //TODO============================ END PROCESS 15 =============================


            //TODO============================  PROCESS 16 =============================

            $results_m16 = DB::table('tmp_tb_work3')->select(DB::raw('wk3_id1, sum(wk3_balance) as total_wk3_balance, sum(wk3_debit) as total_wk3_debit, sum(wk3_credit) as total_wk3_credit, sum(wk3_new_balance) as total_wk3_new_balance'))
                ->where('wk3_ses_key', '=', $key)
                ->where('wk3_id1', '<>', 888000)
                ->groupBy('wk3_id1')
                ->get();

            // dd($results_m16);

            if ($results_m16->isNotEmpty()) {
                foreach ($results_m16 as $value) {

                    $out_id1 = $value->wk3_id1;
                    $out_id2 = 9999999;
                    $out_balance = $value->total_wk3_balance;
                    $out_debit = $value->total_wk3_debit;
                    $out_credit = $value->total_wk3_credit;
                    $out_new_balance = $value->total_wk3_new_balance;
                    $out_sort_key = (string)($out_id1 / 10000000 * 10000000 + 9999999);

                    $data_m16[] = ['out_id1' => $out_id1, 'out_id2' => $out_id2, 'out_balance' => $out_balance, 'out_debit' => $out_debit, 'out_credit' => $out_credit, 'out_new_balance' => $out_new_balance, 'out_ses_key' => $key, 'out_sort_key' => $out_sort_key];
                }
                try {
                    DB::table('tmp_tb_output')->insert($data_m16);
                } catch (QueryException $e) {
                    Log::error('Error while performing insert operation check m16: ' . $e->getMessage());
                }
            }

            // $response_m16 = DB::table('tmp_tb_output')->select('*')->get();
            // dd($response_m16);

            //TODO============================ END PROCESS 16 =============================


            //TODO============================  PROCESS 17 =============================

            $results_m17 = DB::table('tmp_tb_work3')->select(DB::raw('wk3_id1, wk3_id2, sum(wk3_balance) as total_wk3_balance, sum(wk3_debit) as total_wk3_debit, sum(wk3_credit) as total_wk3_credit, sum(wk3_new_balance) as total_wk3_new_balance, wk3_sort_key'))
                ->where('wk3_ses_key', '=', $key)
                ->groupBy('wk3_id1', 'wk3_id2', 'wk3_sort_key')
                ->get();

            // dd($results_m17);

            if ($results_m17->isNotEmpty()) {
                foreach ($results_m17 as $value) {

                    $out_id1 = $value->wk3_id1;
                    $out_id2 = $value->wk3_id2;
                    $out_balance = $value->total_wk3_balance;
                    $out_debit = $value->total_wk3_debit;
                    $out_credit = $value->total_wk3_credit;
                    $out_new_balance = $value->total_wk3_new_balance;
                    $out_sort_key = $value->wk3_sort_key;

                    $data_m17[] = ['out_id1' => $out_id1, 'out_id2' => $out_id2, 'out_balance' => $out_balance, 'out_debit' => $out_debit, 'out_credit' => $out_credit, 'out_new_balance' => $out_new_balance, 'out_ses_key' => $key, 'out_sort_key' => $out_sort_key];
                }
                try {
                    DB::table('tmp_tb_output')->insert($data_m17);
                } catch (QueryException $e) {
                    Log::error('Error while performing insert operation check m17: ' . $e->getMessage());
                }
            }

            $response_m17 = DB::table('tmp_tb_output')->select('*')->orderByRaw('out_id1')->get();
            // $response_m17 = DB::table('tmp_tb_output')->select('*')->orderByRaw('out_id1 + out_id2, out_sort_key')->get();
            // dd($response_m17);

            //TODO============================ END PROCESS 17 =============================


            //TODO============================  PROCESS 18 =============================

            $results_m18 = DB::table('tmp_tb_output')->select(DB::raw("out_id1, out_id2, out_debit"))
                ->where('out_id1', '>=', 1130)
                ->where('out_id1', '<', 1180)
                ->where(DB::raw('out_id1 % 10000'), '=', 9999)
                ->where('out_ses_key', '=', $key)
                ->get();

            // dd($results_m18);
            if ($results_m18->isNotEmpty()) {
                foreach ($results_m18 as $value) {

                    $cst1_acc1 = $value->out_id1;
                    $cst1_acc2 = $value->out_id2;
                    $cst1_old_balance = 0;
                    $cst1_debit = $value->out_debit;
                    $cst1_date = $to;

                    $data_m18[] = ['cst1_acc1' => $cst1_acc1, 'cst1_acc2' => $cst1_acc2, 'cst1_old_balance' => $cst1_old_balance, 'cst1_debit' => $cst1_debit, 'cst1_date' => $cst1_date, 'cst1_ses_key' => $key];
                }
                try {
                    DB::table('tmp_tb_total_cost1')->insert($data_m18);
                } catch (QueryException $e) {
                    Log::error('Error while performing insert operation check m18: ' . $e->getMessage());
                }
            }

            // $response_m18 = DB::table('tmp_tb_total_cost1')->select('*')->get();
            // dd($response_m18);

            //TODO============================ END PROCESS 18 =============================


            //TODO============================ PROCESS 19 =============================

            $results_m19 = DB::table('pl_cost')->select(DB::raw("plcost_account, plcost_customer, plcost_balance"))
                ->where('plcost_date', '=', $from)
                ->where('plcost_status', '=', 1)
                ->get();

            // dd($results_m19);

            if ($results_m19->isNotEmpty()) {
                foreach ($results_m19 as $value) {

                    $cst1_acc1 = $value->plcost_account;
                    $cst1_acc2 = $value->plcost_customer;
                    $cst1_old_balance = $value->plcost_balance;
                    $cst1_debit = 0;
                    $cst1_date = $to;

                    $data_m19[] = ['cst1_acc1' => $cst1_acc1, 'cst1_acc2' => $cst1_acc2, 'cst1_old_balance' => $cst1_old_balance, 'cst1_debit' => $cst1_debit, 'cst1_date' => $cst1_date, 'cst1_ses_key' => $key];
                }
                try {
                    DB::table('tmp_tb_total_cost1')->insert($data_m19);
                } catch (QueryException $e) {
                    Log::error('Error while performing insert operation check m19: ' . $e->getMessage());
                }
            }

            // $response_m19 = DB::table('tmp_tb_total_cost1')->select('*')->get();
            // dd($response_m19);

            //TODO============================ END PROCESS 19 =============================


            //TODO============================ END PROCESS 20 =============================

            $results_m20 = DB::table('tmp_tb_total_cost1')->select(DB::raw("cst1_acc1, cst1_acc2, sum(cst1_old_balance) as total_cst1_old_balance,  sum(cst1_debit) as total_cst1_debit, sum(cst1_old_balance) as total_cst1_old_balance, cst1_date, cst1_ses_key"))
                ->where('cst1_date', '=', $to)
                ->where('cst1_ses_key', '=', $key)
                ->groupBy('cst1_acc1', 'cst1_acc2', 'cst1_date', 'cst1_ses_key')
                ->get();

            // dd($results_m20);

            if ($results_m20->isNotEmpty()) {
                foreach ($results_m20 as $value) {

                    $cst2_acc1 = $value->cst1_acc1;
                    $cst2_acc2 = $value->cst1_acc2;
                    $cst2_old_balance = $value->total_cst1_old_balance;
                    $cst2_debit = $value->total_cst1_debit;
                    $cst2_new_balance = $value->total_cst1_old_balance;
                    $cst2_date = $value->cst1_date;

                    $data_m20[] = ['cst2_acc1' => $cst2_acc1, 'cst2_acc2' => $cst2_acc2, 'cst2_old_balance' => $cst2_old_balance, 'cst2_debit' => $cst2_debit, 'cst2_new_balance' => $cst2_new_balance, 'cst2_date' => $cst2_date, 'cst2_ses_key' => $key];
                }
                try {
                    DB::table('tmp_tb_total_cost2')->insert($data_m20);
                } catch (QueryException $e) {
                    Log::error('Error while performing insert operation check m20: ' . $e->getMessage());
                }
            }

            // $response_m20 = DB::table('tmp_tb_total_cost2')->select('*')->get();
            // dd($response_m20);

            //TODO============================ END PROCESS 20 =============================

            if ($flag) {
                //TODO============================ PROCESS 21 =============================
                $results_m21 = DB::table('tmp_tb_work3')->select('wk3_id1', 'wk3_id2', 'wk3_new_balance')
                    ->where('wk3_ses_key', '=', $key)
                    ->get();

                // dd($results_m21);

                if ($results_m21->isNotEmpty()) {
                    foreach ($results_m21 as $value) {

                        $tb_sum_date = $to;
                        $tb_ref_date = $from;
                        $tb_account = $value->wk3_id1;
                        $tb_customer = $value->wk3_id2;
                        $tb_balance = $value->wk3_new_balance;

                        $data_m21[] = ['tb_sum_date' => $tb_sum_date, 'tb_ref_date' => $tb_ref_date, 'tb_account' => $tb_account, 'tb_customer' => $tb_customer, 'tb_balance' => $tb_balance];
                    }
                    try {
                        DB::table('total_balances')->insert($data_m21);
                    } catch (QueryException $e) {
                        Log::error('Error while performing insert operation check m21: ' . $e->getMessage());
                    }
                }
                // $response_m21 = DB::table('total_balance')->select('*')->get();
                // dd($response_m21);

                try {
                    Slip::where('slp_status', 1)
                        ->where('slp_date2', '>=', $from)
                        ->where('slp_date2', '<', $to)
                        ->update(['slp_status' => 2]);
                } catch (QueryException $e) {
                    Log::error('Error while performing insert operation check m21b: ' . $e->getMessage());
                }


                //TODO============================ END PROCESS 21 =============================


                //TODO============================  PROCESS 22 =============================

                $results_m22 = DB::table('tmp_tb_total_cost2')->select('cst2_acc1', 'cst2_acc2', 'cst2_date', 'cst2_new_balance')
                    ->where('cst2_date', '=', $to)
                    ->where('cst2_ses_key', '=', $key)
                    ->get();

                // dd($results_m22);

                if ($results_m22->isNotEmpty()) {
                    foreach ($results_m22 as $value) {

                        $plcost_account = $value->cst2_acc1;
                        $plcost_customer = $value->cst2_acc2;
                        $plcost_date = $value->cst2_date;
                        $plcost_balance = $value->cst2_new_balance;
                        $plcost_status = 1;

                        $data_m22[] = ['plcost_account' => $plcost_account, 'plcost_customer' => $plcost_customer, 'plcost_date' => $plcost_date, 'plcost_balance' => $plcost_balance, 'plcost_status' => $plcost_status];
                    }
                    try {
                        DB::table('pl_cost')->insert($data_m22);
                    } catch (QueryException $e) {
                        Log::error('Error while performing insert operation check m22: ' . $e->getMessage());
                    }
                }

                // $response_m22 = DB::table('pl_cost')->select('*')->get();
                // dd($response_m22);
                //TODO============================ END PROCESS 22 =============================
            }

            return $response_m17;
        } catch (\Throwable $th) {
            Log::error($th);
            return false;
        }
    }

    //    /**
    //     * Find Page of Project by ID Repository
    //     * Created at: 25/07/2023
    //     * Created by: Hiếu
    //     *
    //     * @access public
    //     * @param int $prj_id The ID of the project to find the page information for.
    //     * @return mixed Returns the page information of the project if found, or null if the project ID is not found or an error occurs.
    //     */
    //    public function findPageOfProjectByIdRepository($prj_id)
    //    {
    //        try {
    //            $detailProject = $this->model->paginate(1);
    //            for ($page = $detailProject->currentPage(); $page <= $detailProject->lastPage(); $page++) {
    //                $pageOfId = $this->model->paginate(1, ['*'], 'page', $page);
    //                if ($prj_id == $pageOfId[0]['prj_id']) {
    //                    return $pageOfId;
    //                }
    //            }
    //            return null;
    //        } catch (\Throwable $th) {
    //            Log::error($th);
    //            return false;
    //        }
    //    }

    /**
     * Delete Slips Repository
     * Created at: 02/08/2023
     * Created by: Hiếu
     *
     * @access public
     * @param int $prj_id The ID of the project to delete the associated slips.
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteSlipsRepository($prj_id)
    {
        DB::beginTransaction();
        try {
            $project = $this->model->find($prj_id);
            $project->slips()->update(['slp_status' => ESlipStatus::DELETE]);
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => __('construction_project.message.succeeded_in_deleting_slips_information'),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            return response()->json([
                'success' => false,
                'message' => __('construction_project.message.failed_to_delete_slips_information'),
            ]);
        }
    }


    /**
     * Delete Estimates Repository
     * Created at: 02/08/2023
     * Created by: Hiếu
     *
     * @access public
     * @param int $prj_id The ID of the project to delete the associated estimates.
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteEstimatesRepository($prj_id)
    {
        DB::beginTransaction();
        try {
            $project = $this->model->find($prj_id);
            $project->estimates()->update([
                'est_status' => EEstimateStatus::INVALID,
                'est_valid' => EEstimateStatus::INVALID,
            ]);
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => __('construction_project.message.successfully_deleted_budget_information'),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            return response()->json([
                'success' => false,
                'message' => __('construction_project.message.failed_to_delete_budget_information'),
            ]);
        }
    }


    /**
     * Delete Accepts Repository
     * Created at: 02/08/2023
     * Created by: Hiếu
     *
     * @access public
     * @param int $prj_id The ID of the project to delete the associated accepts.
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteAcceptsRepository($prj_id)
    {
        DB::beginTransaction();
        try {
            $project = $this->model->find($prj_id);
            $project->accepts()->update([
                'acp_status' => EAcceptStatus::INVALID,
                'acp_valid' => EAcceptStatus::INVALID,
            ]);
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => __('construction_project.message.approval_removed_successfully'),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            return response()->json([
                'success' => false,
                'message' => __('construction_project.message.failed_to_delete_authorization'),
            ]);
        }
    }


    /**
     * Delete Bills Repository
     * Created at: 02/08/2023
     * Created by: Hiếu
     *
     * @access public
     * @param int $prj_id The ID of the project to delete the associated bills.
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteBillsRepository($prj_id)
    {
        DB::beginTransaction();
        try {
            $project = $this->model->find($prj_id);
            $project->bills()->update([
                'bil_status' => EBillStatus::INVALID,
                'bil_valid' => EBillStatus::INVALID,
            ]);
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => __('construction_project.message.invoice_deleted_successfully'),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            return response()->json([
                'success' => false,
                'message' => __('construction_project.message.failed_to_delete_invoice'),
            ]);
        }
    }


    /**
     * Delete Costs Repository
     * Created at: 02/08/2023
     * Created by: Hiếu
     *
     * @access public
     * @param int $prj_id The ID of the project to delete the associated costs.
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteCostsRepository($prj_id)
    {
        DB::beginTransaction();
        try {
            $project = $this->model->find($prj_id);
            $project->costs()->update(['cst_status' => ECostStatus::INVALID]);
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => __('construction_project.message.expenses_successfully_deleted'),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            return response()->json([
                'success' => false,
                'message' => __('construction_project.message.failed_to_delete_expense'),
            ]);
        }
    }


    /**
     * Delete Project Repository
     * Created at: 02/08/2023
     * Created by: Hiếu
     *
     * @access public
     * @param int $prj_id The ID of the project to be soft deleted.
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteProjectRepository($prj_id)
    {
        $project = $this->model->find($prj_id);
        if ($project) {
            $project->update(['prj_status' => EProjectStatus::DELETE]);

            return response()->json([
                'success' => true,
                'message' => __('construction_project.message.project_deleted_successfully'),
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => __('construction_project.message.failed_to_delete_project'),
            ]);
        }
    }


    /**
     * Edit Number of Construction Project Repository
     * Created at: 02/08/2023
     * Created by: Hiếu
     *
     * @access public
     * @param array $data The data containing the necessary information for updating the project number.
     * @return false
     */
    public function editNumberConstructionProjectRepository($data)
    {

        try {
            DB::beginTransaction();
            $project = $this->model->find($data['prj_id']);
            if (!$project) {
                return false;
            }
            if (isset($data['prj_no_edit_new'])) {
                $project->estimates()->update(['est_prj' => $data['prj_no_edit_new']]);
                $project->accepts()->update(['acp_prj' => $data['prj_no_edit_new']]);
                $project->bills()->update(['bil_prj' => $data['prj_no_edit_new']]);
                $project->costs()->update(['cst_prj' => $data['prj_no_edit_new']]);
                $project->slips()->update(['slp_project' => $data['prj_no_edit_new']]);
                $project->slips()->withTrashed()->update(['slp_project' => $data['prj_no_edit_new']]);
                $project->update(['prj_no' => $data['prj_no_new'], 'prj_status' => EProjectStatus::DELETE, 'prj_revision' => $data['prj_revision']]);
                $editProject = $this->model->create([
                    'prj_no' => $data['prj_no_edit_new'],
                    'prj_class1' => $project['prj_class1'],
                    'prj_type1' => $project['prj_type1'],
                    'prj_example1' => $project['prj_example1'],
                    'prj_class2' => $project['prj_class2'],
                    'prj_type2' => $project['prj_type2'],
                    'prj_example2' => $project['prj_example2'],
                    'prj_name' => $project['prj_name'],
                    'prj_summary' => $project['prj_summary'],
                    'prj_place' => $project['prj_place'],
                    'prj_sales' => $project['prj_sales'],
                    'prj_manager' => $project['prj_manager'],
                    'prj_work' => $project['prj_work'],
                    'prj_customer1' => $project['prj_customer1'],
                    'prj_customer2' => $project['prj_customer2'],
                    'prj_contract_date' => $project['prj_contract_date'],
                    'prj_begin' => $project['prj_begin'],
                    'prj_will_finish' => $project['prj_will_finish'],
                    'prj_finish' => $project['prj_finish'],
                    'prj_landed' => $project['prj_landed'],
                    'prj_status' => EProjectStatus::UNSETTLED,
                    'prj_revision' => $project['prj_revision'],
                    'prj_mtag' => $project['prj_mtag'],
                    'prj_mtag_date' => date("Y-m-d"),
                    'prj_mtag_time' => date("H:i:s"),
                    'prj_mtag_id' => $project['prj_mtag_id'],
                ]);
                if ($editProject) {
                    $prj_mtag_id = $editProject['prj_mtag_id'];
                    $memoTag = $this->memotag->find($prj_mtag_id);
                    $updateMemoTag = $memoTag->update([
                        'mtag_name1' => $editProject['prj_no'],
                        'mtag_out' => '2'
                    ]);
                }
                DB::commit();
                return $editProject;
            }
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("このコードはすでに存在します。再作成してください " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get Customer for Estimates Repository
     * Created at: 02/08/2023
     * Created by: Hiếu
     *
     * @access public
     * @param int $prj_id The ID of the project to find the customer information for estimates.
     * @return string|null Returns the customer information for estimates if found, or null if no customer information is available.
     */
    public function getCustomerForEstimatesRepository($prj_id)
    {
        $project = $this->model->find($prj_id);
        $customer = $project->orderSideCompanyName;
        return $customer;
    }

    /**
     * Get the Biggest ID of Estimates for Project Repository
     * Created at: 02/08/2023
     * Created by: Hiếu
     *
     * @access public
     * @param int $prj_id The ID of the project to find the biggest ID of estimates for.
     * @return int|null Returns the biggest ID of estimates for the project if found, or null if no estimates are available.
     */
    public function getBiggestIdEstimatesForProjectRepository($prj_id)
    {
        try {
            DB::beginTransaction();
            $project = $this->model->find($prj_id);
            if ($project->estimates() != null) {
                $project->estimates()->lockForUpdate()->get();
                $maxEstimateId = $project->estimates()->withTrashed()->max('est_id');
                if ($maxEstimateId != null) {
                    $newEstimatesId = $maxEstimateId + 1;
                } else {
                    $newEstimatesId = $this->estimate->max('est_id') + 1;
                }
                DB::commit();
                return $newEstimatesId;
            } else {
                DB::rollback();
                Log::error("見積もりは存在しません");
                return false;
            }
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("このコードはすでに存在します。再作成してください " . $e->getMessage());
            return false;
        }
    }

    /**
     * Update or create estimates for a project in the repository.
     * Created at: 03/08/2023
     * Created by: Hieu
     * @param array $data The data containing information about the estimate.
     * @return mixed Returns the updated or created estimate model.
     */
    public function updateEstimatesForProjectRepository($data)
    {
        $project = $this->model->find($data['prj_id']);
        //$filePath =  '';
        // $estimates_dir = $data['estimates_dir'];
        //        $estimates_dir_replace = str_replace('storage', 'public', $estimates_dir);
        if (isset($data['estimates_file'])) {
            $file = $data['estimates_file'];
            $extension = $file->getClientOriginalExtension();
            $newFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '.' . $extension;
            $filePath = $file->storeAs('public/estimates/file', $newFileName);
            $pathFile = 'storage' . substr($filePath, 6);
        } else {
            $pathFile = $data['estimates_dir'] . $data['estimates_file_name'];
        }
        //$filePath = $filePath ? $filePath : '';
        $estimatesCreate = $data['estimates_create'] === "null" ? null : $data['estimates_create'];
        $estimatesApproval = $data['estimates_approval'] === "null" ? null : $data['estimates_approval'];
        $estimatesSubmit = $data['estimates_submit'] === "null" ? null : $data['estimates_submit'];
        $updateEstimates = $project->estimates()->updateOrCreate(
            ['est_id' => $data['est_id']],
            [
                'est_no' => $data['estimates_no'],
                'est_date1' => $data['estimates_date1'],
                'est_date2' => $data['estimates_date2'],
                'est_valid' => $data['estimates_valid'],
                'est_create' => $estimatesCreate,
                'est_approval' => $estimatesApproval,
                'est_submit' => $estimatesSubmit,
                'est_dir' => $data['estimates_dir'],
                'est_stamp' => $data['estimates_stamp'],
                'est_memo' => $data['estimates_memo'],
                'est_money_w_tax' => $data['estimates_money_w_tax'],
                'est_money' => $data['estimates_money'],
                'est_taxrate' => $data['estimates_taxrate'],
                'est_tax' => $data['estimates_tax'],
                'est_file' => $pathFile,
                'est_status' => EEstimateStatus::VALID,
                'est_customer' => $data['estimates_customer'],
            ]
        );
        return $updateEstimates;
    }

    /**
     * Delete estimates associated with a project in the repository.
     * Created at: 06/08/2023
     * Created by: Hieu
     * @param array $data The data containing information about the estimate to delete.
     * @return bool Returns true if the estimates were successfully deleted, otherwise false.
     */
    public function deleleEstimatesProjectRepository($data)
    {
        $project = $this->model->find($data['prj_id']);
        $deleteEstimates = $project->estimates->find($data['est_id']);
        if ($deleteEstimates) {
            $deleteEstimates->delete();
            $deleteEstimates->update([
                'est_status' => EEstimateStatus::INVALID,
                'est_valid' => EEstimateStatus::INVALID,
            ]);
            return true;
        }
        return false;
    }

    /**
     * Get the Biggest ID of Accepts for a Project Repository.
     * This function retrieves the largest ID for accepts related to a project.
     * Created at: 06/08/2023
     * Created by: Hieu
     * @param int $prj_id The ID of the project to find the biggest ID of accepts for.
     * @return int|false Returns the biggest ID of accepts for the project if found, or false if there's an error.
     * @throws \Exception If there's a critical error during the process.
     */
    public function getTheBiggestIdAcceptsRepository($prj_id)
    {
        try {
            DB::beginTransaction();
            $project = $this->model->find($prj_id);
            if ($project->accepts() != null) {
                $project->accepts()->lockForUpdate()->get();
                $maxAcceptId = $project->accepts()->withTrashed()->max('acp_id');

                if ($maxAcceptId != null) {
                    $newAcceptId = $maxAcceptId + 1;
                } else {
                    $newAcceptId = $this->accept->max('acp_id') + 1;
                }
                DB::commit();
                return $newAcceptId;
            } else {
                DB::rollback();
                Log::error("受け入れますが存在しません");
                return false;
            }
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("このコードはすでに存在します。再作成してください" . $e->getMessage());
            return false;
        }
    }

    /**
     * Update or Create an Accept in Estimates for a Project Repository.
     * This function updates or creates an accept associated with estimates for a project.
     * Created at: 06/08/2023
     * Created by: Hieu
     *
     * @param array $data An associative array containing accept data.
     * @return bool True if the update or create operation is successful, false otherwise.
     */
    public function updateAcceptInEstimatesForProjectRepository($data)
    {
        $project = $this->model->find($data['prj_id']);
        $updateAccept = $project->accepts()->updateOrCreate(
            ['acp_id' => $data['acp_id']],
            [
                'acp_estimate_no' => $data['acp_estimate_no'],
                'acp_date' => $data['acp_date'],
                'acp_estimate_w_tax' => $data['acp_estimate_w_tax'],
                'acp_estimate_money' => $data['acp_estimate_money'],
                'acp_money_w_tax' => $data['acp_money_w_tax'],
                'acp_money' => $data['acp_money'],
                'acp_taxrate' => $data['acp_taxrate'],
                'acp_tax' => $data['acp_tax'],
                'acp_memo' => $data['acp_memo'],
                'acp_status' => EAcceptStatus::VALID,
                'acp_valid' => 1,
            ]
        );
        return $updateAccept;
    }

    /**
     * Update or Create Accepts for a Project Repository.
     * This function updates or creates an accept associated with a project.
     * Created at: 08/08/2023
     * Created by: Hieu
     *
     * @param array $data An associative array containing accept data.
     * @return bool True if the update or create operation is successful, false otherwise.
     */
    public function updateAcceptsForProjectRepository($data)
    {
        $project = $this->model->find($data['prj_id']);
        //        $filePath =  '';
        //        $acp_dir = $data['acp_dir'];
        //        $acp_dir_replace = str_replace('storage', 'public', $acp_dir);
        if (isset($data['acp_file'])) {
            $file = $data['acp_file'];
            $extension = $file->getClientOriginalExtension();
            $newFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '.' . $extension;
            $filePath = $file->storeAs('public/accept/file', $newFileName);
            $pathFile = 'storage' . substr($filePath, 6);
        } else {
            $pathFile = $data['acp_dir'] . $data['acp_file_name'];
        }
        $updateAccepts = $project->accepts()->updateOrCreate(
            ['acp_id' => $data['acp_id']],
            [
                'acp_estimate_no' => $data['acp_estimate_no'],
                'acp_date' => $data['acp_date'],
                'acp_estimate_w_tax' => $data['acp_estimate_w_tax'],
                'acp_estimate_money' => $data['acp_estimate_money'],
                'acp_money_w_tax' => $data['acp_money_w_tax'],
                'acp_money' => $data['acp_price'],
                'acp_taxrate' => $data['acp_taxrate'],
                'acp_tax' => $data['acp_tax'],
                'acp_valid' => $data['acp_valid'],
                'acp_dir' => $data['acp_dir'],
                'acp_stamp' => $data['acp_stamp'],
                'acp_file' => $pathFile,
                'acp_memo' => $data['acp_memo'],
                'acp_status' => EAcceptStatus::VALID,
            ]
        );
        return $updateAccepts;
    }

    /**
     * Delete or Invalidate Accepts for a Project Repository.
     * This function deletes or invalidates an accept associated with a project.
     * Created at: 09/08/2023
     * Created by: Hieu
     *
     * @param array $data An associative array containing data for deleting or invalidating an accept.
     * @return bool True if the delete or invalidate operation is successful, false otherwise.
     */
    public function deleleAcceptsProjectRepository($data)
    {
        $project = $this->model->find($data['prj_id']);
        $deleteAccepts = $project->accepts->find($data['acp_id']);
        if ($deleteAccepts) {
            $deleteAccepts->delete();
            $deleteAccepts->update([
                'acp_status' => EAcceptStatus::INVALID,
                'acp_valid' => EAcceptStatus::INVALID,
            ]);
            return true;
        }
        return false;
    }

    /**
     * Get the Biggest ID of Costs for a Project Repository.
     * This function retrieves the biggest ID of costs associated with a project.
     * Created at: 10/08/2023
     * Created by: Hieu
     *
     * @param int $prj_id The ID of the project to find the biggest ID of costs for.
     * @return int|null Returns the biggest ID of costs for the project if found, or null if no costs are available.
     */
    public function getTheBiggestIdCostsRepository($prj_id)
    {
        try {
            DB::beginTransaction();
            $project = $this->model->find($prj_id);
            if ($project->costs() != null) {
                $project->costs()->lockForUpdate()->get();
                $maxCostId = $project->costs()->withTrashed()->max('cst_id');
                if ($maxCostId != null) {
                    $newCostId = $maxCostId + 1;
                } else {
                    $newCostId = $this->cost->max('cst_id') + 1;
                }
                DB::commit();
                return $newCostId;
            } else {
                DB::rollback();
                Log::error("コストは存在しません");
                return false;
            }
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("このコードはすでに存在します。再作成してください" . $e->getMessage());
            return false;
        }
    }

    /**
     * Update Costs for a Project Repository.
     * This function updates or creates a new record for costs associated with a project.
     * Created at: 10/08/2023
     * Created by: Hieu
     * @param array $data An array containing the data for updating costs.
     * @return bool Returns true if the update or creation was successful, or false if an error occurred.
     */
    public function updateCostsForProjectRepository($data)
    {
        $project = $this->model->find($data['prj_id']);
        $updateCosts = $project->costs()->updateOrCreate(
            ['cst_id' => $data['cst_id']],
            [
                'cst_date' => $data['cst_date'],
                'cst_customer' => $data['cst_customer'],
                'cst_material' => $data['cst_material'],
                'cst_work' => $data['cst_work'],
                'cst_outsource' => $data['cst_outsource'],
                'cst_expense' => $data['cst_expense'],
                'cst_status' => ECostStatus::VALID,
                'cst_memo' => $data['cst_memo'],
            ]
        );
        return $updateCosts;
    }

    /**
     * Delete Costs for a Project Repository.
     * This function soft-deletes a cost entry associated with a project.
     * Created at: 10/08/2023
     * Created by: Hieu
     *
     * @param array $data An array containing the data for deleting costs.
     * @return bool
     */
    public function deleleCostsProjectRepository($data)
    {
        $project = $this->model->find($data['prj_id']);
        $deleteCosts = $project->costs->find($data['cst_id']);
        if ($deleteCosts) {
            $deleteCosts->delete();
            $deleteCosts->update([
                'cst_status' => ECostStatus::INVALID,
                'cst_valid' => ECostStatus::INVALID,
            ]);
            return true;
        }
        return false;
    }

    /**
     * Find a Page of Details by ID for a Project Repository.
     * This function retrieves a page of project details based on the provided ID and detail type (costs, accepts, estimates, bills).
     * Created at: 13/08/2023
     * Created by: Hieu
     * @param int $prj_id The ID of the project.
     * @param int|null $cst_id The ID of the cost entry to find a page for (default is null).
     * @param int|null $acp_id The ID of the accept entry to find a page for (default is null).
     * @param int|null $est_id The ID of the estimate entry to find a page for (default is null).
     * @param int|null $bill_id The ID of the bill entry to find a page for (default is null).
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator|null Returns a paginator containing a page of project details if found, or null if not found.
     */
    public function findPageByIdRepository($prj_id, $cst_id = null, $acp_id = null, $est_id = null, $bill_id = null)
    {
        try {
            $project = $this->model->find($prj_id);
            if (!$project) {
                return null;
            }
            if ($cst_id !== null) {
                $detailItems = $project->costs();
                $identifier = 'cst_id';
                $idToCheck = $cst_id;
            } elseif ($acp_id !== null) {
                $detailItems = $project->accepts();
                $identifier = 'acp_id';
                $idToCheck = $acp_id;
            } elseif ($est_id !== null) {
                $detailItems = $project->estimates();
                $identifier = 'est_id';
                $idToCheck = $est_id;
            } elseif ($bill_id !== null) {
                $detailItems = $project->bills();
                $identifier = 'bil_id';
                $idToCheck = $bill_id;
            } elseif ($prj_id !== null) {
                $detailItems = $project;
                $identifier = 'prj_id';
                $idToCheck = $prj_id;
            } else {
                return null;
            }
            $detailItems = $project->where('prj_status', '!=', -2);
            $detailItems = $detailItems->orderBy('prj_no', 'asc');
            $detailItemsPagination = $detailItems->paginate(1);

            for ($page = $detailItemsPagination->currentPage(); $page <= $detailItemsPagination->lastPage(); $page++) {
                $pageOfId = $detailItems->paginate(1, ['*'], 'page', $page);
                if ($idToCheck !== null && $idToCheck == $pageOfId[0][$identifier]) {
                    return $pageOfId;
                } elseif ($prj_id == $pageOfId[0]['prj_id']) {
                    return $pageOfId;
                }
            }
            return null;
        } catch (\Throwable $th) {
            Log::error($th);
            return false;
        }
    }

    /**
     * Get the Biggest ID of Bills for a Project Repository.
     * This function retrieves the biggest ID of bills for a given project.
     * Created at: 13/08/2023
     * Created by: Hieu
     * @param int $prj_id The ID of the project to find the biggest bill ID for.
     * @return int|null Returns the biggest ID of bills for the project if found, or null if no bills are available.
     */
    public function getTheBiggestIdBillsRepository($prj_id)
    {
        try {
            DB::beginTransaction();
            $project = $this->model->find($prj_id);
            if ($project->bills() != null) {
                $project->bills()->lockForUpdate()->get();
                $maxBillId = $project->bills()->withTrashed()->max('bil_id');
                if ($maxBillId != null) {
                    $newBillId = $maxBillId + 1;
                } else {
                    $newBillId = $this->bill->max('bil_id') + 1;
                }
                DB::commit();
                return $newBillId;
            } else {
                DB::rollback();
                Log::error("請求書は存在しません");
                return false;
            }
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("このコードはすでに存在します。再作成してください" . $e->getMessage());
            return false;
        }
    }

    /**
     * Update or Create Bills for a Project in the Repository.
     * This function updates or creates a bill for a project in the repository.
     * Created at: 13/08/2023
     * Created by: Hieu
     * @param array $data An array containing bill data.
     * @return mixed Returns the updated or created bill data.
     */
    public function updateBillsForProjectRepository($data)
    {
        $project = $this->model->find($data['prj_id']);
        //        $filePath =  '';
        //        $bill_dir = $data['bill_dir'];
        //        $bill_dir_replace = str_replace('storage', 'public', $bill_dir);
        if (isset($data['bill_file'])) {
            $file = $data['bill_file'];
            $extension = $file->getClientOriginalExtension();
            $newFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '.' . $extension;
            $filePath = $file->storeAs('public/bill/file', $newFileName);
            $pathFile = 'storage' . substr($filePath, 6);
        } else {
            $pathFile = $data['bill_dir'] . $data['bill_file_name'];
        }
        $updateBills = $project->bills()->updateOrCreate(
            ['bil_id' => $data['bill_id']],
            [
                'bil_customer' => $data['bill_customer'],
                'bil_no' => $data['bill_no'],
                'bil_date' => $data['bill_date'],
                'bil_money_w_tax' => $data['bill_money_w_tax'],
                'bil_money_wo_tax' => $data['bill_money_wo_tax'],
                'bil_taxrate' => $data['bill_taxrate'],
                'bil_tax' => $data['bill_tax'],
                'bil_dir' => $data['bill_dir'],
                'bil_valid' => $data['bill_valid'],
                'bil_stamp' => $data['bill_stamp'],
                'bil_status' => EBillStatus::VALID,
                'bil_file' => $pathFile,
                'bil_memo' => $data['bill_memo'],
            ]
        );
        return $updateBills;
    }

    /**
     * Delete a Bill for a Project in the Repository.
     * This function deletes a bill for a project in the repository and updates its status to INVALID.
     * Created at: 13/08/2023
     * Created by: Hieu
     *
     * @param array $data An array containing project and bill IDs.
     * @return bool
     */
    public function deleleBillsProjectRepository($data)
    {
        $project = $this->model->find($data['prj_id']);
        $deleteBills = $project->bills->find($data['bill_id']);
        if ($deleteBills) {
            $deleteBills->delete();
            $deleteBills->update([
                'bil_status' => EBillStatus::INVALID,
                'bil_valid' => EBillStatus::INVALID,
            ]);
            return true;
        }
        return false;
    }

    /**
     * Function createContractNumberAutoInMasterRepository
     * Create a contract number automatically in the master project.
     * Created at: 23/10/2023
     * Created by: Hieu
     *
     * @param array $data The data required for contract number generation.
     * @return bool|string Returns true if successful, 'duplicate' if the contract number already exists, or false on failure.
     */
    public function createContractNumberAutoInMasterRepository($data)
    {
        DB::beginTransaction();
        try {
            $fiscalYear = $data['fiscalYear'];
            $employeeId = $data['employeeId'];
            $employeeName = $data['employeeName'];
            $prjTemplate = $this->projectTemplate->orderBy('mkprj_id', 'asc')->take(8)->get();
            $sequence = 0;
            foreach ($prjTemplate as $key => $templateCode) {
                if ($templateCode['mkprj_code'] == 'Y') {
                    $sequence = str_pad($key + 1, 3, '0', STR_PAD_LEFT);
                } elseif ($templateCode['mkprj_code'] == 'M') {
                    $sequence = ($key % 2 == 0) ? '001' : '003';
                }

                $prjNo = $fiscalYear . $templateCode['mkprj_code'] . $employeeId . '-' . $sequence;
                $prjName = $employeeName . '-' . $templateCode['mkprj_memo'];

                $existingRecord = $this->project->where('prj_no', $prjNo)->first();
                if (!$existingRecord) {
                    $createProjectNo = $this->project->create([
                        'prj_no' => $prjNo,
                        'prj_name' => $prjName,
                        'prj_status' => EProjectStatus::CONTINUATION,
                    ]);

                    if ($createProjectNo) {
                        $memotagData = [
                            'mtag_name1' => $prjNo,
                        ];
                        $newMemotag = $this->memotag->create($memotagData);
                        $mtag_id = $newMemotag->mtag_id;
                        $createProjectNo->update([
                            'prj_mtag_id' => $mtag_id,
                            'prj_mtag' => 1,
                            'prj_mtag_date' => date('Y-m-d'),
                            'prj_mtag_time' => date('H:i:s'),
                        ]);
                    }
                } else {
                    DB::rollBack();
                    return 'duplicate';
                }
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return false;
        }
    }

    /**
     * Function createContractNumberManualInMasterRepository
     * Manually generate a contract number in the master project.
     * Created at: 23/10/2023
     * Created by: Hieu
     *
     * @param array $data The data required for contract number generation.
     * @return bool|string Returns true if successful, 'duplicate' if the contract number already exists, or false on failure.
     */
    public function createContractNumberManualInMasterRepository($data)
    {
        DB::beginTransaction();
        try {
            $contractNumber = $data['contractNumber'];
            $existingRecord = $this->project->where('prj_no', $contractNumber)->first();
            if (!$existingRecord) {
                $createProjectNo = $this->project->create([
                    'prj_no' => $contractNumber,
                    'prj_status' => EProjectStatus::UNSETTLED,
                ]);

                if ($createProjectNo) {
                    $memotagData = [
                        'mtag_name1' => $contractNumber,
                    ];
                    $newMemotag = $this->memotag->create($memotagData);
                    $mtag_id = $newMemotag->mtag_id;
                    $createProjectNo->update([
                        'prj_mtag_id' => $mtag_id,
                        'prj_mtag' => 1,
                        'prj_mtag_date' => date('Y-m-d'),
                        'prj_mtag_time' => date('H:i:s'),
                    ]);
                }
            } else {
                DB::rollBack();
                return 'duplicate';
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return false;
        }
    }
}
