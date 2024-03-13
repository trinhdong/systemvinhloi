<?php

namespace App\Services;

use App\Repositories\ProjectRepository;
use Hash;
use Illuminate\Support\Facades\DB;
use \Illuminate\Support\Facades\Log;

class ProjectService extends BaseService
{

    protected $projectRepository;

    /**
     * Method: __construct
     * Created at: 27/06/2023
     * Created by: Hien
     *
     * @param App\Repositories\ProjectRepository $projectRepository
     * @access public
     * @return void
     */
    public function __construct(ProjectRepository $projectRepository)
    {
        $this->projectRepository = $projectRepository;
        $this->setRepository();
    }

    /**
     * Setting repository want to interact
     * Created at: 27/06/2023
     * Created by: Hien
     *
     * @access public
     * @return Repository
     */
    public function getRepository()
    {
        return ProjectRepository::class;
    }

    /**
     * Get Data Relations of Project
     * Created at: 21/07/2023
     * Created by: Hiếu
     *
     * @access public
     * @param array $data An array of project data.
     * @return array|bool Returns the modified project data array on success, or false if an error occurs.
     */
    public function getDataRelationOfProjectService($data)
    {
        try {
            foreach ($data as $item) {
                //Employee
                $item->prj_sales_name = $item->employeeSale;
                $item->prj_manager_name = $item->employeeManager;
                $item->prj_work_name = $item->employeeWork;
                $item->prj_confirm_name = $item->employeeConfirm;
                //ProjectType
                $item->prj_type_main = $item->mainTypeOfBusiness;
                $item->prj_type_sub = $item->subTypeOfBusiness;
                //Customer
                $item->prj_customer_name1 = $item->orderSideCompanyName;
                $item->prj_customer_name2 = $item->personInChargeName;

                //Estimate
                $item->prj_estimates = $item->estimates;
                $item->total_est_money = $item->getEstimatedTotal();

                //Accept
                $item->prj_accepts = $item->accepts;
                $item->total_acp_money = $item->getAcceptTotal();

                //Bill
                $item->prj_bills = $item->bills;
                $item->total_bill_money = $item->getBillTotal();

                //Slip
                $item->total_slip_money = $item->getSlipTotal();
                $item->total_money_paid_material_fee = $item->getMoneyPaidMaterialFee();
                $item->total_money_paid_labor_fee = $item->getMoneyPaidLaborFee();
                $item->total_money_paid_outsourcing_fee = $item->getMoneyPaidOutsourcingFee();
                $item->total_money_paid_funds = $item->getMoneyPaidFunds();

                //Cost
                $item->prj_costs = $item->costs;
                $item->total_implementation_estimate = $item->getImplementationEstimate();
                $item->total_cost_material = $item->getCostMaterial();
                $item->total_cost_work = $item->getCostWork();
                $item->total_cost_outsource = $item->getCostOutsource();
                $item->total_cost_expense = $item->getCostExpense();
            }
            return $data;
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
    public function getProject($params)
    {
        $result = $this->projectRepository->getProject($params);
        return $result;
    }


    /**
     * get Project
     * Created at: 12/07/2023
     * Created by: Kieu
     */
    public function getStartDate($prj_no)
    {
        $result = $this->projectRepository->getStartDate($prj_no);
        return $result;
    }


    /**
     * get Construction Progress Status
     * Created at: 12/07/2023
     * Created by: Kieu
     */
    public function getConstructionProgressStatus($params)
    {
        $result = $this->projectRepository->getConstructionProgressStatus($params);
        return $result;
    }


    /**
     * get getProjTypeName
     * Created at: 12/07/2023
     * Created by: Kieu
     */
    public function getProjTypeName($ptyp_status)
    {
        $result = $this->projectRepository->getProjTypeName($ptyp_status);
        return $result;
    }


    /**
     * get ProjType
     * Created at: 12/07/2023
     * Created by: Kieu
     */
    public function getProjType($id)
    {
        $result = $this->projectRepository->getProjType($id);
        return $result;
    }


    /**
     * get ProjType
     * Created at: 12/07/2023
     * Created by: Kieu
     */
    public function createTemporaryTableCheck($key, $from, $to)
    {
        $result = $this->projectRepository->createTemporaryTableCheck($key, $from, $to);
        return $result;
    }

    /**
     * get tb_SUM_DATE_NEW
     * Created at: 12/07/2023
     * Created by: Kieu
     */
    public function getTbSumDateNew()
    {
        $result = $this->projectRepository->getTbSumDateNew();
        return $result;
    }


    /**
     * get ProjType
     * Created at: 12/07/2023
     * Created by: Kieu
     */
    public function createTemporaryTable($key, $from, $to, $flag)
    {
        $result = $this->projectRepository->createTemporaryTable($key, $from, $to, $flag);
        return $result;
    }


    /**
     * Get Next Serial Number
     * Created at: 20/07/2023
     * Created by: Hiếu
     *
     * @access public
     * @param string $currentSerialNumber The current serial number as a string in the format "xxx-yyy-zzz".
     * @return string Returns the next serial number as a string in the format "zzz", with leading zeros if necessary.
     */
    public function getNextSerialNumber($currentSerialNumber)
    {
        try {
            $parts = explode('-', $currentSerialNumber);
            $currentSerialNumber = end($parts);

            $number = (int) $currentSerialNumber;
            $newNumber = $number + 1;
            return str_pad($newNumber, 3, '0', STR_PAD_LEFT);
        } catch (\Throwable $th) {
            Log::error($th);
            return false;
        }
    }

    /**
     * Get Serial Number from Contract Number
     * Created at: 20/07/2023
     * Created by: Hiếu
     *
     * @access public
     * @param string $contractNumber The contract number in the format "xxx-yyy-zzz".
     * @return int Returns the extracted serial number as an integer.
     */
    public function getSerialNumberFromContractNumber($contractNumber)
    {
        try {
            $parts = explode('-', $contractNumber);
            $serialNumber = end($parts);
            return intval($serialNumber);
        } catch (\Throwable $th) {
            Log::error($th);
            return false;
        }
    }

    /**
     * Find Page of Project by ID Service
     * Created at: 25/07/2023
     * Created by: Hiếu
     *
     * @access public
     * @param int $prj_id The ID of the project to find the page information for.
     * @return mixed Returns the page information of the project if found, or false if an error occurs.
     */
    public function findPageOfProjectByIdService($prj_id)
    {
        try {
            return $this->projectRepository->findPageByIdRepository($prj_id);
        } catch (\Throwable $th) {
            Log::error($th);
            return false;
        }
    }

    /**
     * Delete Construction Project Service
     * Created at: 02/08/2023
     * Created by: Hiếu
     *
     * @access public
     * @param int $prj_id The ID of the project to be soft deleted.
     * @return \Illuminate\Http\JsonResponse Returns a JSON response indicating the status and result of the deletion operation.
     */
    public function deleteConstructionProjectService($prj_id)
    {
        try {
            DB::beginTransaction();

            $project = $this->projectRepository->find($prj_id);

            if (!$project) {
                return response()->json(['message' => __('construction_project.message.project_does_not_exist')], 404);
            }

            $operations = [
                'deleteSlipsRepository',
                'deleteEstimatesRepository',
                'deleteAcceptsRepository',
                'deleteBillsRepository',
                'deleteCostsRepository',
                'deleteProjectRepository',
            ];

            $allOperationsSuccessful = true; // Biến flag để kiểm tra trạng thái của các hoạt động xóa

            foreach ($operations as $operation) {
                $deleteResult = $this->projectRepository->$operation($prj_id);

                if (!$deleteResult->getData()->success) {
                    $allOperationsSuccessful = false;
                    break;
                }
            }

            if ($allOperationsSuccessful) {
                DB::commit();
                return response()->json([
                    'success' => true,
                    'message' => __('construction_project.message.it_was_deleted')
                ]);
            } else {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => __('construction_project.message.an_error_occurred_during_deletion'),
                ]);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            return response()->json([
                'success' => false,
                'message' => __('construction_project.message.an_error_occurred_during_deletion'),
            ]);
        }
    }


    /**
     * Edit Number of Construction Project Service
     * Created at: 02/08/2023
     * Created by: Hiếu
     *
     * @access public
     * @param array $data The data containing the necessary information for updating the project number.
     * @return mixed Returns the result of the update operation if successful, or false if an error occurs.
     */
    public function editNumberConstructionProjectService($data)
    {
        try {
            return $this->projectRepository->editNumberConstructionProjectRepository($data);
        }catch (\Throwable $th){
            Log::error($th);
            return false;
        }
    }

    /**
     * Get Customer for Estimates
     * Created at: 02/08/2023
     * Created by: Hiếu
     *
     * @access public
     * @param int $prj_id The ID of the project to find the customer information for estimates.
     * @return mixed Returns the customer information for estimates if found, or false if an error occurs.
     */
    public function getCustomerForEstimates($prj_id)
    {
        try {
            return $this->projectRepository->getCustomerForEstimatesRepository($prj_id);
        }catch (\Throwable $th){
            Log::error($th);
            return false;
        }
    }

    /**
     * Get the Biggest ID of Estimates for Project
     * Created at: 02/08/2023
     * Created by: Hiếu
     *
     * @access public
     * @param int $prj_id The ID of the project to find the biggest ID of estimates for.
     * @return mixed Returns the biggest ID of estimates for the project if found, or false if an error occurs.
     */
    public function getBiggestIdEstimatesForProjectService($prj_id)
    {
        try {
            return $this->projectRepository->getBiggestIdEstimatesForProjectRepository($prj_id);
        }catch (\Throwable $th){
            Log::error($th);
            return false;
        }
    }

    /**
     * Update or Create an Estimate for a Project in the Service layer.
     * This function updates or creates an estimate for a project using the provided data.
     * If successful, it returns the updated or created estimate; otherwise, it returns false.
     * Created at: 03/08/2023
     * Created by: Hiếu
     * @param array $data An array containing the estimate data.
     * @return mixed The updated or created estimate or false on failure.
     */
    public function updateEstimatesForProjectService($data)
    {
        try {
            return $this->projectRepository->updateEstimatesForProjectRepository($data);
        }catch (\Throwable $th){
            Log::error($th);
            return false;
        }
    }

    /**
     * Delete an Estimate for a Project in the Service layer.
     * This function soft-deletes an estimate associated with a project based on the provided data.
     * If successful, it returns true; otherwise, it returns false.
     * Created at: 06/08/2023
     * Created by: Hieu
     * @param array $data An array containing the data necessary for deleting the estimate.
     * @return bool True if the estimate was deleted successfully, false otherwise.
     */
    public function deleteEstimatesProjectService($data)
    {
        try {
            return $this->projectRepository->deleleEstimatesProjectRepository($data);
        } catch (\Throwable $th) {
            Log::error($th);
            return false;
        }
    }

    /**
     * Get the Biggest ID of Accepts for a Project in the Service layer.
     * This function retrieves the biggest ID of accepts associated with a project.
     * Created at: 06/08/2023
     * Created by: Hieu
     *
     * @param int $prj_id The ID of the project to find the biggest ID of accepts for.
     * @return int|null Returns the biggest ID of accepts for the project if found, or null if no accepts are available.
     */
    public function getTheBiggestIdAcceptsService($prj_id)
    {
        try {
            return $this->projectRepository->getTheBiggestIdAcceptsRepository($prj_id);
        }catch (\Throwable $th){
            Log::error($th);
            return false;
        }
    }

    /**
     * Update or Create an Accept in Estimates for a Project in the Service layer.
     * This function updates or creates an accept in estimates associated with a project.
     * Created at: 06/08/2023
     * Created by: Hieu
     *
     * @param array $data The data for the accept in estimates.
     * @return mixed Returns the updated or created accept in estimates if successful, or false if an error occurs.
     */
    public function updateAcceptInEstimatesForProjectService($data)
    {
        try {
            return $this->projectRepository->updateAcceptInEstimatesForProjectRepository($data);
        }catch (\Throwable $th){
            Log::error($th);
            return false;
        }
    }

    /**
     * Update or Create Accepts for a Project in the Service layer.
     * This function updates or creates accepts associated with a project.
     * Created at: 08/08/2023
     * Created by: Hieu
     * @param array $data The data for the accepts.
     * @return mixed Returns the updated or created accepts if successful, or false if an error occurs.
     */
    public function updateAcceptsForProjectService($data)
    {
        try {
            return $this->projectRepository->updateAcceptsForProjectRepository($data);
        }catch (\Throwable $th){
            Log::error($th);
            return false;
        }
    }

    /**
     * Delete Accepts for a Project in the Service layer.
     * This function deletes accepts associated with a project.
     * Created at: 09/08/2023
     * Created by: Hieu
     *
     * @param array $data The data for deleting accepts.
     * @return false
     */
    public function deleteAcceptsProjectService($data)
    {
        try {
            return $this->projectRepository->deleleAcceptsProjectRepository($data);
        } catch (\Throwable $th) {
            Log::error($th);
            return false;
        }
    }

    /**
     * Get the Biggest ID of Costs for a Project in the Service layer.
     * This function retrieves the biggest ID of costs associated with a project.
     * Created at: 10/08/2023
     * Created by: Hieu
     *
     * @param int $prj_id The ID of the project to find the biggest ID of costs for.
     * @return int|false Returns the biggest ID of costs for the project if found, or false if an error occurs.
     */
    public function getTheBiggestIdCostsService($prj_id)
    {
        try {
            return $this->projectRepository->getTheBiggestIdCostsRepository($prj_id);
        }catch (\Throwable $th){
            Log::error($th);
            return false;
        }
    }

    /**
     * Update Costs for a Project in the Service layer.
     * This function updates or creates costs associated with a project based on the provided data.
     * Created at: 10/08/2023
     * Created by: Hieu
     *
     * @param array $data The data for updating or creating costs.
     * @return bool|mixed Returns true if the costs are successfully updated or created, or false if an error occurs.
     */
    public function updateCostsForProjectService($data)
    {
        try {
            return $this->projectRepository->updateCostsForProjectRepository($data);
        }catch (\Throwable $th){
            Log::error($th);
            return false;
        }
    }

    /**
     * Delete Costs of a Project in the Service layer.
     * This function deletes costs associated with a project based on the provided data.
     * Created at: 10/08/2023
     * Created by: Hieu
     *
     * @param array $data The data for deleting costs.
     * @return false
     */
    public function deleteCostsProjectService($data)
    {
        try {
            return $this->projectRepository->deleleCostsProjectRepository($data);
        } catch (\Throwable $th) {
            Log::error($th);
            return false;
        }
    }

    /**
     * Find a Page of Project Costs by Project and Cost ID in the Service layer.
     * This function retrieves a page of project costs based on the provided project ID and cost ID.
     * Created at: 13/08/2023
     * Created by: Hieu
     *
     * @param int $prj_id The ID of the project to find costs for.
     * @param int $cst_id The ID of the cost to locate within the project.
     * @return mixed Returns the page of project costs if found, or false if not found or an error occurs.
     */
    public function findPageOfProjectCostByIdService($prj_id, $cst_id)
    {
        try {
            return $this->projectRepository->findPageByIdRepository($prj_id, $cst_id);
        } catch (\Throwable $th) {
            Log::error($th);
            return false;
        }
    }

    /**
     * Find a Page of Project Accepts by Project and Accept ID in the Service layer.
     * This function retrieves a page of project accepts based on the provided project ID and accept ID.
     * Created at: 13/08/2023
     * Created by: Hieu
     *
     * @param int $prj_id The ID of the project to find accepts for.
     * @param int $acp_id The ID of the accept to locate within the project.
     * @return mixed Returns the page of project accepts if found, or false if not found or an error occurs.
     */
    public function findPageOfProjectAcceptByIdService($prj_id, $acp_id)
    {
        try {
            return $this->projectRepository->findPageByIdRepository($prj_id, null,$acp_id );
        } catch (\Throwable $th) {
            Log::error($th);
            return false;
        }
    }

    /**
     * Find a Page of Project Estimates by Project and Estimate ID in the Service layer.
     * This function retrieves a page of project estimates based on the provided project ID and estimate ID.
     * Created at: 13/08/2023
     * Created by: Hieu
     *
     * @param int $prj_id The ID of the project to find estimates for.
     * @param int $est_id The ID of the estimate to locate within the project.
     * @return mixed Returns the page of project estimates if found, or false if not found or an error occurs.
     */
    public function findPageOfProjectEstimatesByIdService($prj_id, $est_id)
    {
        try {
            return $this->projectRepository->findPageByIdRepository($prj_id, null,null, $est_id, null );
        } catch (\Throwable $th) {
            Log::error($th);
            return false;
        }
    }

    /**
     * Get the Biggest ID of Bills for a Project in the Service layer.
     * This function retrieves the biggest ID of bills for a specific project.
     * Created at: 13/08/2023
     * Created by: Hieu
     *
     * @param int $prj_id The ID of the project to find the biggest ID of bills for.
     * @return mixed Returns the biggest ID of bills for the project if found, or false if not found or an error occurs.
     */
    public function getTheBiggestIdBillsService($prj_id)
    {
        try {
            return $this->projectRepository->getTheBiggestIdBillsRepository($prj_id);
        }catch (\Throwable $th){
            Log::error($th);
            return false;
        }
    }

    /**
     * Update Bills for a Project in the Service layer.
     * This function updates or inserts bill information for a project.
     * Created at: 13/08/2023
     * Created by: Hieu
     *
     * @param array $data An array containing bill data to be updated or inserted.
     * @return mixed Returns the updated or inserted bill data if successful, or false if an error occurs.
     */
    public function updateBillsForProjectService($data)
    {
        try {
            return $this->projectRepository->updateBillsForProjectRepository($data);
        }catch (\Throwable $th){
            Log::error($th);
            return false;
        }
    }

    /**
     * Find a Page of Project Bills by Project ID and Bill ID in the Service layer.
     * This function retrieves a page of project bills based on the project ID and optionally, the bill ID.
     * Created at: 13/08/2023
     * Created by: Hieu
     *
     * @param int $prj_id The ID of the project to search for bills within.
     * @param int|null $bill_id (Optional) The ID of the specific bill to find. If provided, this function will return
     *                          the page containing the specified bill.
     * @return mixed Returns the page of project bills if found, or false if an error occurs.
     */
    public function findPageOfProjectBillsByIdService($prj_id, $bill_id)
    {
        try {
            return $this->projectRepository->findPageByIdRepository($prj_id, null,null,null, $bill_id );
        } catch (\Throwable $th) {
            Log::error($th);
            return false;
        }
    }

    /**
     * Delete a Bill for a Project in the Service layer.
     * This function calls the repository to delete a bill for a project and updates its status to INVALID.
     * Created at: 13/08/2023
     * Created by: Hiếu
     *
     * @param array $data An array containing project and bill IDs.
     * @return false
     */
    public function deleteBillsProjectService($data)
    {
        try {
            return $this->projectRepository->deleleBillsProjectRepository($data);
        } catch (\Throwable $th) {
            Log::error($th);
            return false;
        }
    }
    /**
     * Function createContractNumberAutoInMasterService
     * Create a contract number automatically in the master project.
     * Created at: 23/10/2023
     * Created by: Hiếu
     *
     * @param array $data The data required for contract number generation.
     * @return bool|string Returns true if successful, 'duplicate' if the contract number already exists, or false on failure.
     */
    public function createContractNumberAutoInMasterService($data)
    {
        try {
            return $this->projectRepository->createContractNumberAutoInMasterRepository($data);
        } catch (\Throwable $th) {
            Log::error($th);
            return false;
        }
    }

    /**
     * Function createContractNumberManualInMasterService
     * Manually generate a contract number in the master project.
     * Created at: 23/10/2023
     * Created by: Hiếu
     *
     * @param array $data The data required for contract number generation.
     * @return bool|string Returns true if successful, 'duplicate' if the contract number already exists, or false on failure.
     */
    public function createContractNumberManualInMasterService($data)
    {
        try {
            return $this->projectRepository->createContractNumberManualInMasterRepository($data);
        } catch (\Throwable $th) {
            Log::error($th);
            return false;
        }
    }
}

