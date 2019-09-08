<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tasks extends CI_Controller
{

    public $viewFolder = "";
    public $pageTitle = "";
    public $pageTitleExt = "";
    const  cigPerMC = 10000;

    public function __construct()
    {
        parent::__construct();
        if(!get_active_user()){
            redirect(base_url("login"));
        }
        $this->viewFolder = "tasks_v";
        $this->pageTitle = "Tasklar";
        $this->pageTitleExt = PageTitleExt;
        $this->load->model('tasks_model');
        $this->load->model('recipes_model');
        $this->load->model('premixes_model');
        $this->load->model('recipes_items_model');
        $this->load->model('machines_model');
        $this->load->model('cigarette_types_model');
        $this->load->model('warehouse_products_model');
        $this->load->model('task_logs_model');
    }

    public function index(){
        $viewData = new stdClass();
        $viewData->viewFolder       = $this->viewFolder;
        $viewData->subViewFolder    = "list";
        $viewData->pageTitle        = $this->pageTitle.$this->pageTitleExt;
        $viewData->header           = $this->pageTitle;

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index",$viewData);
    }

    public function new_form(){

        $viewData = new stdClass();
        $viewData->viewFolder       = $this->viewFolder;
        $viewData->subViewFolder    = "add";
        $viewData->pageTitle        = "Task Əlavə Et".$this->pageTitleExt;
        $viewData->header           = "Task Əlavə Et";
        $viewData->newCode          = $this->tasks_model->generate_autoCode('TSK');
        $viewData->recipes          = $this->recipes_model->getAll();
        $viewData->machines         = $this->machines_model->getAll();
        $viewData->cigarettes       = $this->cigarette_types_model->getAll();

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index",$viewData);
    }

    public function save(){

        $this->load->library('form_validation');

        $this->form_validation->set_rules("auto-code","Avto Kod","required|trim");
        $this->form_validation->set_rules("task-name","Task Adı","required|trim");
        $this->form_validation->set_rules("startDate","Başlanğıc tarixi","required|trim");
        $this->form_validation->set_rules("endDate","Bitiş tarixi","required|trim");
        $this->form_validation->set_rules("machine","Makina","required|trim");
        $this->form_validation->set_rules("machine-mc","Ortalam MC","required|trim");
        $this->form_validation->set_rules("cigaretteType","Siqaret tipi","required|trim");
        $this->form_validation->set_rules("expTobac","Tütün miqdarı","required|trim");
        $this->form_validation->set_rules("recipe","Reçete","required|trim");
        $this->form_validation->set_rules("description","Qeyd","trim");

        $this->form_validation->set_message(array(
            "required" => "{field} boş buraxıla bilməz!"
        ));

        $checkValidation = $this->form_validation->run();

        if($checkValidation){
            $save = $this->tasks_model->add(array(
                "autoCode"    => $this->input->post("auto-code"),
                "name"        => $this->input->post("task-name"),
                "description" => $this->input->post("description"),
                "recipeID"    => $this->input->post("recipe"),
                "machineID"   => $this->input->post("machine"),
                "ctID"        => $this->input->post("cigaretteType"),
                "startDate"   => $this->input->post("startDate"),
                "endDate"     => $this->input->post("endDate")
            ));

            if($save){
                $alert = array(
                    "title"    => "Əməliyyat uğurla yerinə yetirildi",
                    "text"     => "",
                    "type"     => "success",
                    "position" => "toast-top-center"
                );
                $this->session->set_flashdata("alert",$alert);
            }
            else{

                $alert = array(
                    "title"    => "Üzr istəyirik!",
                    "text"     => "Bilinməyən xəta baş verdi. Zəhmət olmasa birazdan bir daha cəhd edin",
                    "type"     => "error",
                    "position" => "toast-top-center"
                );
                $this->session->set_flashdata("alert",$alert);
            }
            redirect(base_url('tasks/add-task'));
        }
        else{

            $viewData = new stdClass();
            $viewData->viewFolder       = $this->viewFolder;
            $viewData->subViewFolder    = "add";
            $viewData->pageTitle        = "Task Əlavə Et".$this->pageTitleExt;
            $viewData->header           = "Task Əlavə Et";
            $viewData->newCode          = $this->tasks_model->generate_autoCode('TSK');
            $viewData->recipes          = $this->recipes_model->getAll();
            $viewData->machines         = $this->machines_model->getAll();
            $viewData->cigarettes       = $this->cigarette_types_model->getAll();
            $viewData->form_error       = true;

            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index",$viewData);
        }
    }

    public function update_form($id){
        $id = (int) $id;
        $viewData = new stdClass();
        $viewData->viewFolder       = $this->viewFolder;
        $viewData->subViewFolder    = "update";
        $viewData->pageTitle        = "Task Əlavə Et".$this->pageTitleExt;
        $viewData->header           = "Task Əlavə Et";
        $viewData->recipes          = $this->recipes_model->getAll();
        $viewData->machines         = $this->machines_model->getAll();
        $viewData->cigarettes       = $this->cigarette_types_model->getAll();
        $viewData->task             = $this->tasks_model->get(array(
            "ID"    => $id
        ));
        if(!$viewData->task && is_int($id) && $id != 0):
            $viewData->result     = false;
        else:
            $viewData->result     = true;
        endif;
        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index",$viewData);
    }

    public function update($id){
        $id = (int) $id;
        $this->load->library('form_validation');

        $this->form_validation->set_rules("auto-code","Avto Kod","required|trim");
        $this->form_validation->set_rules("task-name","Task Adı","required|trim");
        $this->form_validation->set_rules("startDate","Başlanğıc tarixi","required|trim");
        $this->form_validation->set_rules("endDate","Bitiş tarixi","required|trim");
        $this->form_validation->set_rules("machine","Makina","required|trim");
        $this->form_validation->set_rules("machine-mc","Ortalam MC","required|trim");
        $this->form_validation->set_rules("cigaretteType","Siqaret tipi","required|trim");
        $this->form_validation->set_rules("expTobac","Tütün miqdarı","required|trim");
        $this->form_validation->set_rules("recipe","Reçete","required|trim");
        $this->form_validation->set_rules("description","Qeyd","trim");

        $this->form_validation->set_message(array(
            "required" => "{field} boş buraxıla bilməz!"
        ));

        $checkValidation = $this->form_validation->run();

        if($checkValidation){
            if(is_int($id) && $id != 0){
                $update = $this->tasks_model->update(
                    array(
                        "ID" => $id
                    ),
                    array(
                        "name"        => $this->input->post("task-name"),
                        "description" => $this->input->post("description"),
                        "recipeID"    => $this->input->post("recipe"),
                        "machineID"   => $this->input->post("machine"),
                        "ctID"        => $this->input->post("cigaretteType"),
                        "startDate"   => $this->input->post("startDate"),
                        "endDate"     => $this->input->post("endDate")
                    ));

                if($update){
                    $alert = array(
                        "title"    => "Əməliyyat uğurla yerinə yetirildi",
                        "text"     => "",
                        "type"     => "success",
                        "position" => "toast-top-center"
                    );
                    $this->session->set_flashdata("alert",$alert);
                }
                else{

                    $alert = array(
                        "title"    => "Üzr istəyirik!",
                        "text"     => "Bilinməyən xəta baş verdi. Zəhmət olmasa birazdan bir daha cəhd edin",
                        "type"     => "error",
                        "position" => "toast-top-center"
                    );

                    $this->session->set_flashdata("alert",$alert);
                }
                redirect(base_url('tasks'));
            }
            else{
                $viewData->viewFolder       = $this->viewFolder;
                $viewData->subViewFolder    = "update";
                $viewData->pageTitle        = "Task Əlavə Et".$this->pageTitleExt;
                $viewData->header           = "Task Əlavə Et";
                $viewData->recipes          = $this->recipes_model->getAll();
                $viewData->machines         = $this->machines_model->getAll();
                $viewData->cigarettes       = $this->cigarette_types_model->getAll();
                $viewData->task             = $this->tasks_model->get(array(
                    "ID"    => $id
                ));
                if(!$viewData->task && is_int($id) && $id != 0):
                    $viewData->result     = false;
                else:
                    $viewData->result     = true;
                endif;
                $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index",$viewData);
            }

        }
        else{

            $viewData->viewFolder       = $this->viewFolder;
            $viewData->subViewFolder    = "update";
            $viewData->pageTitle        = "Task Əlavə Et".$this->pageTitleExt;
            $viewData->header           = "Task Əlavə Et";
            $viewData->recipes          = $this->recipes_model->getAll();
            $viewData->machines         = $this->machines_model->getAll();
            $viewData->cigarettes       = $this->cigarette_types_model->getAll();
            $viewData->task             = $this->tasks_model->get(array(
                "ID"    => $id
            ));
            $viewData->form_error       = true;
            if(!$viewData->task && is_int($id) && $id != 0):
                $viewData->result     = false;
            else:
                $viewData->result     = true;
            endif;

            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index",$viewData);
        }
    }

    public function delete($id){

        $delete = $this->tasks_model->delete(array(
            "ID" => $id
        ));

        if($delete){
            $alert = array(
                "title"    => "Əməliyyat uğurla yerinə yetirildi",
                "text"     => "Məlumat silindi",
                "type"     => "success",
                "position" => "toast-top-center"
            );
        }
        else{
            $alert = array(
                "title"    => "Üzr istəyirik!",
                "text"     => "Bilinməyən xəta baş verdi. Zəhmət olmasa birazdan bir daha cəhd edin",
                "type"     => "error",
                "position" => "toast-top-center"
            );
        }

        $this->session->set_flashdata("alert",$alert);
        redirect(base_url('tasks'));
    }

    public function makeIsDone($id){
        $makeDone = $this->tasks_model->update(array(
            "ID"    => $id
        ),
            array(
               "isDone" => 1
            ));
        if($makeDone){
            $alert = array(
                "title"    => "Əməliyyat uğurla yerinə yetirildi",
                "text"     => "",
                "type"     => "success",
                "position" => "toast-top-center"
            );
        }
        else{
            $alert = array(
                "title"    => "Üzr istəyirik!",
                "text"     => "Bilinməyən xəta baş verdi. Zəhmət olmasa birazdan bir daha cəhd edin",
                "type"     => "error",
                "position" => "toast-top-center"
            );
        }

        $this->session->set_flashdata("alert",$alert);
        redirect(base_url('tasks'));
    }

    public function more($id){
        $id = (int)$id;

        $viewData = new stdClass();
        $viewData->viewFolder       = $this->viewFolder;
        $viewData->subViewFolder    = "more";
        $viewData->pageTitle        = "Task Əlavə Et".$this->pageTitleExt;
        $viewData->header           = "Task Əlavə Et";
        $viewData->task             = $this->tasks_model->get(array(
            "t.ID" => $id
        ),true);
        $viewData->taskDetails      = $this->task_logs_model->getAll(array(
           "taskID" => $id
        ));
        $viewData->result           = false;

        if(is_int($id) && $id != 0):
            $viewData->result = true;
        endif;

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index",$viewData);
    }

    public function saveTaskLog($id){
        $id = (int) $id;
        if(is_int($id) && $id != 0){
            $this->load->library('form_validation');

            $this->form_validation->set_rules("dailyMC","Master Case","required|trim");
            $this->form_validation->set_rules("today","Tarix","required|trim");

            $this->form_validation->set_message(array(
                "required" => "{field} boş buraxıla bilməz!"
            ));

            $checkValidation = $this->form_validation->run();

            if($checkValidation){
                $checkCurrentDate = $this->task_logs_model->get(array(
                   "logDate"    => $this->input->post("today"),
                    "taskID"    => $id
                ));
                if(!$checkCurrentDate){
                    $saveTaskLog = $this->task_logs_model->add(array(
                        "taskID"    => $id,
                        "content"   => null,
                        "prepMC"    => $this->input->post("dailyMC"),
                        "logDate"   => $this->input->post("today")
                    ));
                }
                else{
                    $updateTaskLog = $this->task_logs_model->updateByTaskLogDate(
                        $id,
                        $this->input->post("dailyMC"),
                        $this->input->post("today")
                    );
                }

                /* Reduce from stock */
                if($saveTaskLog || $updateTaskLog){
                    $taskDetail = $this->tasks_model->get(array(
                        "t.ID" => $id
                    ),true);
                    $recipeID = $taskDetail->rID;
                    $tobacAmount = $taskDetail->expTobac;
                    $checkAvailability = self::reduceFromStock($recipeID,$this->input->post("dailyMC"), $tobacAmount);
                }

                if($checkAvailability){
                    $alert = array(
                        "title"    => "Əməliyyat uğurla yerinə yetirildi",
                        "text"     => "",
                        "type"     => "success",
                        "position" => "toast-top-center"
                    );
                    $this->session->set_flashdata("alert",$alert);
                }
                else{
                    $alert = array(
                        "title"    => "Üzr istəyirik!",
                        "text"     => "Bilinməyən xəta baş verdi. Zəhmət olmasa birazdan bir daha cəhd edin",
                        "type"     => "error",
                        "position" => "toast-top-center"
                    );
                    $this->session->set_flashdata("alert",$alert);
                }
                redirect(base_url("tasks/more/{$id}"));
            }
            else{
                $viewData = new stdClass();
                $viewData->viewFolder       = $this->viewFolder;
                $viewData->subViewFolder    = "more";
                $viewData->pageTitle        = "Task Əlavə Et".$this->pageTitleExt;
                $viewData->header           = "Task Əlavə Et";
                $viewData->task             = $this->tasks_model->get(array(
                    "t.ID" => $id
                ),true);
                $viewData->taskDetail       = $this->task_logs_model->getAll(array(
                    "taskID" => $id
                ));
                $viewData->form_error       = false;

                $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index",$viewData);
            }
        }
        else{
            $viewData = new stdClass();
            $viewData->viewFolder       = $this->viewFolder;
            $viewData->subViewFolder    = "more";
            $viewData->pageTitle        = "Task Əlavə Et".$this->pageTitleExt;
            $viewData->header           = "Task Əlavə Et";
            $viewData->task             = $this->tasks_model->get(array(
                "t.ID" => $id
            ),true);
            $viewData->taskDetail       = $this->task_logs_model->getAll(array(
                "taskID" => $id
            ));
            $viewData->result           = false;

            if(is_int($id) && $id != 0):
                $viewData->result = true;
            endif;

            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index",$viewData);
        }
    }

    public function isActiveSetter($id)
    {
        if ($id) {
            $isChecked = ($this->input->post("isChecked") === "true") ? 1 : 0;
            $isActive = $this->tasks_model->update(
                array(
                    "ID" => $id
                ),
                array(
                    "isActive" => $isChecked
                )
            );
        }
    }

    public function checkPlanAvaliablity(){

        $this->load->library('form_validation');

        $this->form_validation->set_rules("auto-code","Avto Kod","required|trim");
        $this->form_validation->set_rules("task-name","Task Adı","required|trim");
        $this->form_validation->set_rules("startDate","Başlanğıc tarixi","required|trim");
        $this->form_validation->set_rules("endDate","Bitiş tarixi","required|trim");
        $this->form_validation->set_rules("machine","Makina","required|trim");
        $this->form_validation->set_rules("machine-mc","Ortalam MC","required|trim");
        $this->form_validation->set_rules("cigaretteType","Siqaret tipi","required|trim");
        $this->form_validation->set_rules("expTobac","Tütün miqdarı","required|trim");
        $this->form_validation->set_rules("recipe","Reçete","required|trim");

        $this->form_validation->set_message(array(
            "required" => "{field} boş buraxıla bilməz!"
        ));

        $checkValidation = $this->form_validation->run();

        $result = array();
        if($checkValidation){
            $result["error"] = 0;

            $result["data"] = self::calculatePlanAvaliablity(
                $this->input->post("startDate"),
                $this->input->post("endDate"),
                $this->input->post("recipe"),
                $this->input->post("machine-mc"),
                $this->input->post("expTobac")
            );
        }
        else{
            $result["error"] = 1;
        }

        echo json_encode($result);
    }

    private function reduceFromStock($recipeID, $mc, $tobacAmount){
        $recipeTimesPerDay = self::calculateRecipeTimesPerDay($recipeID,$mc,$tobacAmount);
        $items = self::checkProductAvailability($recipeTimesPerDay,$recipeID);
        $availability = self::makeWarningMessages($items);
        $result = array();
        if($availability['errorCount'] == 0){
            $fetchItems = $this->recipes_items_model->getAll(
                array(
                    "recipeID" => $recipeID
                )
            );

            foreach ($fetchItems as $item){
                if(!is_null($item->productID)){
                    $requiredAmount = $item->amount*$recipeTimesPerDay;
                    $decrease = $this->warehouse_products_model->addOutAmount(
                        $item->productID,
                        $item->warehouseID,
                        $requiredAmount
                    );
                    array_push($result,$decrease);
                    /* Check product for notification */
                    checkProductForNotification($item->productID, $item->warehouseID);
                }
                else{
                    $requiredAmount = $item->amount*$recipeTimesPerDay;
                    $decrease = $this->premixes_model->decreaseAmount($item->premixID, $requiredAmount);
                    array_push($result,$decrease);
                }
            }

        }
        else{
            array_push($result, false);
        }
        if(in_array(false,$result)):
            return false;
        else:
            return true;
        endif;
    }

    private function calculateRecipeTimesPerDay($recipeID, $mc, $tobacAmount){
        $recipeSum  = self::calculateRecipeSumWeight($recipeID);
        $cigarAmountPerRecipe = floor(($recipeSum*1000000)/$tobacAmount);
        $mcAmountPerRecipe = ($cigarAmountPerRecipe > self::cigPerMC)? floor($cigarAmountPerRecipe/self::cigPerMC):floor(self::cigPerMC/$cigarAmountPerRecipe);
        $recipeTimesPerDay = floor($mc/$mcAmountPerRecipe);

        return $recipeTimesPerDay;
    }

    private function calculatePlanAvaliablity($startDate, $endDate, $recipeID, $mc, $tobacAmount){
        $days       = self::calculateDifference2Dates($startDate, $endDate);

        /*$recipeSum  = self::calculateRecipeSumWeight($recipeID);
        $cigarAmountPerRecipe = floor(($recipeSum*1000000)/$tobacAmount);
        $mcAmountPerRecipe = ($cigarAmountPerRecipe>self::cigPerMC)? floor($cigarAmountPerRecipe/self::cigPerMC):floor(self::cigPerMC/$cigarAmountPerRecipe);
        $recipeTimesPerDay = floor($mc/$mcAmountPerRecipe);*/

        $recipeTimesPerDay = self::calculateRecipeTimesPerDay($recipeID,$mc,$tobacAmount);
        $recipeTimes = $days*$recipeTimesPerDay;

        $items = self::checkProductAvailability($recipeTimes,$recipeID);

        return self::makeWarningMessages($items);
    }

    private function checkProductAvailability($recipeTimes, $recipeID){
        $fetchItems = $this->recipes_items_model->getAll(
            array(
                "recipeID" => $recipeID
            )
        );
        $items = array();

        foreach ($fetchItems as $item){
            if(!is_null($item->productID)){
                $requiredAmount = $item->amount*$recipeTimes;
                $fetchSingleData = $this->warehouse_products_model->get(array(
                   "productID"      => $item->productID,
                   "warehouseID"    => $item->warehouseID
                ));
                if($requiredAmount>$fetchSingleData->netQuantity):
                    array_push($items,array(
                        "available"      => false,
                        "ID"             => $item->productID,
                        "type"           => "product",
                        "requiredAmount" => ($fetchSingleData->netQuantity-$requiredAmount)
                    ));
                else:
                    array_push($items,array(
                       "available"  => true,
                       "ID"         => $item->productID,
                       "type"      => "product"
                    ));
                endif;

            }
            else{
                $requiredAmount = $item->amount*$recipeTimes;
                $fetchSingleData = $this->premixes_model->get(array(
                   "ID"     => $item->premixID
                ));
                if($requiredAmount>$fetchSingleData->netAmount):
                    array_push($items,array(
                        "available" => false,
                        "ID"        => $item->premixID,
                        "type"      => "premix",
                        "requiredAmount" => ($fetchSingleData->netAmount-$requiredAmount)
                    ));
                else:
                    array_push($items,array(
                        "available" => true,
                        "ID"        => $item->premixID,
                        "type"      => "premix"
                    ));
                endif;
            }
        }

        return $items;
    }

    private function makeWarningMessages($items){
        $this->load->model('products_model');

        $result = array();
        $result['messages'] = array();
        $result['errorCount'] = 0;
        foreach ($items as $item){
                if(!$item['available']){
                if($item['type'] == 'product'){
                    $fetchSingleProduct = $this->products_model->get(array(
                       "ID"     => $item['ID']
                    ));
                    $message = "<span class='font-weight-bold'>Çatışmayan məhsul:</span> ".$fetchSingleProduct->title." (".$fetchSingleProduct->code.") <span class='font-weight-bold'><br/>Miqdar: </span> <span class='red'>".$item['requiredAmount']."</span><hr>";
                    array_push($result['messages'],$message);
                }
                else{
                    $fetchSinglePremix = $this->premixes_model->get(array(
                       "ID"     => $item['ID']
                    ));
                    $message = "<span class='font-weight-bold'>Çatışmayan premix:</span> ".$fetchSinglePremix->name." (".$fetchSinglePremix->code.") <span class='font-weight-bold'><br/>Miqdar: </span> <span class='red'>".$item['requiredAmount']."</span><hr>";
                    array_push($result['messages'],$message);
                }
                $result['errorCount'] += 1;
            }

        }

        if($result['errorCount'] == 0):
            $result['title'] = "<h1 class='success font-weight-bold mt-1'>Bu plan tətbiq oluna bilər</h1>";
        else:
            $result['title'] = "<h1 class='red font-weight-bold'>Bu plan tətbiq oluna bilməz!</h1><br/>";
        endif;

        return $result;
    }

    private function calculateRecipeSumWeight($recipeID){
        $this->db->select('SUM(amount) AS sum');
        $this->db->from('recipes_items');
        $this->db->where(array(
            "recipeID"   => $recipeID
        ));
        $result = $this->db->get()->row();
        return $result->sum;
    }

    private function calculateDifference2Dates($startDate, $endDate){
        $startDate = new DateTime($startDate);
        $endDate   = new DateTime($endDate);
        $interval  = $startDate->diff($endDate);
        return $interval->format("%a%");
    }

    public function getDataTable(){
        echo $this->tasks_model->getDataTable();
    }

}