<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('product_model');
    }

    public function index() {
        if ($this->session->userdata('user_id')) {
            $abcd = $this->session->get_userdata('user_name');
            $data['title'] = 'Product';
            $this->load->view('layout/header.php', $data);
            $this->load->view('layout/sidebar.php');
            $this->load->view('product_view.php');
            $this->load->view('layout/footer.php');
        } else {
            return redirect('login');
        }
        $post = $this->input->post();
        if (!empty($post)) {
            $colnum = array(
                0 => 'site_id',
                1 => 'product_name',
                2 => 'category',
                3 => 'sub_category',
                4 => 'stock_status',
                5 => 'status',
            );
            $this->product_model->site_id = isset($post['site_id']) ? $post['site_id'] : '';
            $this->product_model->search = isset($post['search']['value']) ? $post['search']['value'] : '';
            $this->product_model->start = isset($post['start']) ? $post['start'] : '';
            $this->product_model->length = isset($post['length']) ? $post['length'] : '';
            $this->product_model->column = isset($post['order'][0]['column']) ? $colnum[$post['order'][0]['column']] : '';
            $this->product_model->dire = isset($post['order'][0]['dir']) ? $post['order'][0]['dir'] : '';
            $conn = FALSE;
            $user = $this->product_model->ViewList($conn);
            $conn = true;
            $result = $this->product_model->ViewList($conn);
            $product_data = array();
            foreach ($result as $array) {

                $site = "";
                if (isset($array['site_id']) && $array['site_id'] == RENT4HEALTHID) {
                    $site = "Rent4health";
                } else if (isset($array['site_id']) && $array['site_id'] == BUY4HEALTHID) {
                    $site = "Buy4health";
                }

                $id = $array['id'];
                $data['site_id'] = $site;
                $data['product_type'] = $array['product_type'];
                $data['product_code'] = $array['product_code'];
                $data['product_name'] = $array['product_name'];
                $data['category'] = $array['category_name'];
                $data['sub_category'] = $array['sub_category'];
                $data['stock_status'] = $array['stock_status'];
                $data['status'] = $array['status'];
                $data['action'] = '<div style="display:flex;"><a href="' . base_url() . 'product/view/' . $id . '" class="btn btn-xs btn-info viewbtn"> View</a>&nbsp;';
                $data['action'] .= '<a href="' . base_url() . 'product/image/' . $id . '" class="btn btn-xs btn-success imagebtn"> Images</a>&nbsp;';
                $data['action'] .= '<a href="' . base_url() . 'product/price/' . $id . '" class="btn btn-xs btn-warning pricebtn"> Prices</a>&nbsp;';
                $data['action'] .= '<a href="' . base_url() . 'product/rent/' . $id . '" class="btn btn-xs btn-primary rentbtn"> Rent</a></div>';
//                $data['action'] .= '<div class="col-sm-3"><a href="' . base_url() . 'product/rent/' . $id . '" class="btn btn-xs btn-primary rentbtn"> Rent</a></div>';
                $product_data[] = $data;
            }
            $json = array(
                "draw" => $_POST['draw'],
                "data" => $product_data,
                "recordsFiltered" => intval($user),
                "recordsTotal" => intval($user),
            );
            echo json_encode($json);
            exit;
        }
    }

    public function view($id) {
        $data = $this->product_model->Productview($id);
        $this->load->view('layout/header.php');
        $this->load->view('layout/sidebar.php');
        $this->load->view('product_row_view.php', $data);
        $this->load->view('layout/footer.php');
    }

    public function image($id) {
        $data['id'] = $id;
        $this->load->view('layout/header.php');
        $this->load->view('layout/sidebar.php');
        $this->load->view('Product_row_image.php', $data);
        $this->load->view('layout/footer.php');
    }

    public function view_image($id) {
        $post = $this->input->post();
        if (!empty($post)) {
            $colnum = array(
                0 => 'p.name',
                1 => 'pi.product_image',
            );
            $this->product_model->search = isset($post['search']['value']) ? $post['search']['value'] : '';
            $this->product_model->start = isset($post['start']) ? $post['start'] : '';
            $this->product_model->length = isset($post['length']) ? $post['length'] : '';
            $this->product_model->column = isset($post['order'][0]['column']) ? $colnum[$post['order'][0]['column']] : '';
            $this->product_model->dire = isset($post['order'][0]['dir']) ? $post['order'][0]['dir'] : '';
            $conn = FALSE;
            $count = $this->product_model->ProductImageList($conn, $id);
            $conn = true;
            $product_image = $this->product_model->ProductImageList($conn, $id);
            $product_image_data = array();
            foreach ($product_image as $array) {
                $id = $array['id'];
                $data['name'] = $array['product_name'];
                $data['image'] = "<img src='" . base_url() . "assets/uploads/product/" . $array['product_image'] . "' alt='" . $array['product_image'] . "' style='height: 70px;width: 70px;' >";
                $data['action'] = '';
//                $data['action'] = '<div><a class="btn btn-xs btn-info editbtn"> Edit</a>   ';
//                $data['action'] .= '<a class="btn btn-xs btn-danger deletebtn"> Delete</a></div>';
                $product_image_data[] = $data;
            }
            $json = array(
                "draw" => $_POST['draw'],
                "data" => $product_image_data,
                "recordsFiltered" => intval($count),
                "recordsTotal" => intval($count),
            );
            echo json_encode($json);
            exit;
        }
    }

    public function price($id) {
        $data = $this->product_model->price($id);
        $this->load->view('layout/header.php');
        $this->load->view('layout/sidebar.php');
        $this->load->view('Product_row_price.php', $data);
        $this->load->view('layout/footer.php');
    }

    public function view_price($id) {
        $post = $this->input->post();
        if (!empty($post)) {
            $colnum = array(
                0 => 'st.size_type',
                1 => 's.size',
                2 => 'pp.quantity',
                3 => 'pp.low_level',
                4 => 'pp.service_tax',
                5 => 'pp.mrp',
                6 => 'pp.price',
                7 => 'pp.status',
            );
            $this->product_model->search = isset($post['search']['value']) ? $post['search']['value'] : '';
            $this->product_model->start = isset($post['start']) ? $post['start'] : '';
            $this->product_model->length = isset($post['length']) ? $post['length'] : '';
            $this->product_model->column = isset($post['order'][0]['column']) ? $colnum[$post['order'][0]['column']] : '';
            $this->product_model->dire = isset($post['order'][0]['dir']) ? $post['order'][0]['dir'] : '';
            $conn = FALSE;
            $count = $this->product_model->ProductPriceList($conn, $id);
            $conn = true;
            $product_price = $this->product_model->ProductPriceList($conn, $id);

            $product_price_data = array();
            foreach ($product_price as $array) {
                $id = $array['id'];
                $data['size_type'] = $array['size_type'];
                $data['size_id'] = $array['size'];
                $data['quantity'] = $array['quantity'];
                $data['low_level'] = $array['low_level'];
                $data['service_tax'] = $array['service_tax'];
                $data['mrp'] = $array['mrp'];
                $data['price'] = $array['price'];
                $data['status'] = $array['status'];
//                $data['action'] = '<div><a class="btn btn-xs btn-info editbtn"> Edit</a>   ';
//                $data['action'] .= '<a class="btn btn-xs btn-danger deletebtn"> Delete</a></div>';
                $product_price_data[] = $data;
            }
            $json = array(
                "draw" => $_POST['draw'],
                "data" => $product_price_data,
                "recordsFiltered" => intval($count),
                "recordsTotal" => intval($count),
            );
            echo json_encode($json);
            exit;
        }
    }

    public function rent($id) {
        $data = $this->product_model->price($id);
        $this->load->view('layout/header.php');
        $this->load->view('layout/sidebar.php');
        $this->load->view('Product_row_rent.php', $data);
        $this->load->view('layout/footer.php');
    }

    public function view_rent($id) {
        $post = $this->input->post();
        if (!empty($post)) {
            $colnum = array(
                0 => 'pr.rent_duration',
                1 => 'pr.rent_amount',
                2 => 'pr.advance_amount',
                3 => 'pr.status',
            );
            $this->product_model->search = isset($post['search']['value']) ? $post['search']['value'] : '';
            $this->product_model->start = isset($post['start']) ? $post['start'] : '';
            $this->product_model->length = isset($post['length']) ? $post['length'] : '';
            $this->product_model->column = isset($post['order'][0]['column']) ? $colnum[$post['order'][0]['column']] : '';
            $this->product_model->dire = isset($post['order'][0]['dir']) ? $post['order'][0]['dir'] : '';
            $conn = FALSE;
            $count = $this->product_model->ProductRentList($conn, $id);
            $conn = true;
            $product_rent = $this->product_model->ProductRentList($conn, $id);
            $product_rent_data = array();
            foreach ($product_rent as $array) {
                $id = $array['id'];
                $data['rent_duration'] = $array['rent_duration'];
                $data['rent_amount'] = $array['rent_amount'];
                $data['advance_amount'] = $array['advance_amount'];
                $data['status'] = $array['status'];
                $product_rent_data[] = $data;
            }
            $json = array(
                "draw" => $_POST['draw'],
                "data" => $product_rent_data,
                "recordsFiltered" => intval($count),
                "recordsTotal" => intval($count),
            );
            echo json_encode($json);
            exit;
        }
    }

}

?>