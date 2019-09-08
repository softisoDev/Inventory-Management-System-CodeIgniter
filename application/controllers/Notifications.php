<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notifications extends CI_Controller
{

    public $viewFolder = "";
    public $pageTitle = "";
    public $pageTitleExt = "";

    public function __construct()
    {
        parent::__construct();
        $this->viewFolder = "";
        $this->pageTitle = "Bildirişlər";
        $this->pageTitleExt = PageTitleExt;
        $this->load->model('notifications_model');
        $this->load->model('warehouse_products_model');
        $this->load->model('notification_types_model');
    }

    public function index(){

    }

    public function checkProductStockAmount(){
        $products = $this->warehouse_products_model->fetchCriticStockAmountProducts();

        if(!empty($products) && $products){
            $getNotifType = $this->notification_types_model->get(array(
                "ID" => 1
            ));

            foreach ($products as  $product){
                $content = "<strong>Məhsul kodu: </strong> {$product->code}<br/>";
                $content .= "<strong>Məhsulun adı: </strong>: {$product->title}<br/>";
                $content .= "<strong>Anbar: </strong>: {$product->name}<br/>";
                $content .= "<strong>Qalan miqdar: </strong>: {$product->netQuantity}<br/>";
                $this->notifications_model->add(array(
                    "title"         =>  $getNotifType->name,
                    "content"       =>  $content,
                    "level"         =>  "medium",
                    "createdAt"    =>   date("Y-m-d H:i:s")
                ));
            }
        }
    }

    public function makeTopNotification(){
        if(!is_null($this->input->post('notification'))){
            $notifications = $this->notifications_model->getAll();
            $result = "";
            if(!empty($notifications) && $notifications) {
                foreach ($notifications as $notification) {
                    $result .= '<a href="javascript:void(0)">';
                    $result .= '<div class="media">';
                    $result .= '<div class="media-left align-self-center"><i class="ft-alert-triangle icon-bg-circle bg-yellow bg-darken-3"></i></div>';
                    $result .= '<div class="media-body">';
                    $result .= '<h6 class="media-heading red darken-1">' . $notification->title . '</h6>';
                    $result .= '<p class="notification-text font-small-3 text-muted">' . $notification->content . '</p>';
                    $result .= '</div></div></a>';
                }
            }
            else{
                $result .= '<a href="javascript:void(0)">';
                $result .= '<div class="media text-center">Yoxdur</div>';
                $result .= '</a>';
            }
            echo $result;
        }

    }

    public function deneme(){
        $kg = convertToKg(10,4,1);
        print_r($kg);

    }

}