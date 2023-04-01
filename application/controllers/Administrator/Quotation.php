<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Quotation extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->sbrunch = $this->session->userdata('BRANCHid');
        $access = $this->session->userdata('userId');
        if ($access == '') {
            redirect("Login");
        }
        $this->load->model('Billing_model');
        $this->load->library('cart');
        $this->load->model('Model_table', "mt", TRUE);
        $this->load->helper('form');
    }

    public function index()
    {
        $access = $this->mt->userAccess();
        if (!$access) {
            redirect(base_url());
        }
        $data['title'] = "Quotation Entry";
        $data['quotationId'] = 0;
        $data['invoice'] = $this->mt->generateQuotationInvoice();
        $data['content'] = $this->load->view('Administrator/quotation/quotation_entry', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function addQuotation()
    {
        $res = ['success' => false, 'message' => ''];
        try {
            $data = json_decode($this->input->raw_input_stream);

            $invoice = $data->quotation->invoiceNo;
            $invoiceCount = $this->db->query("select * from tbl_quotation_master where SaleMaster_InvoiceNo = ?", $invoice)->num_rows();
            if ($invoiceCount != 0) {
                $invoice = $this->mt->generateQuotationInvoice();
            }

            $customerId = $data->quotation->customerId;
            if (isset($data->customer)) {
                $customer = (array)$data->customer;
                unset($customer['Customer_SlNo']);
                unset($customer['display_name']);
                $customer['Customer_Code'] = $this->mt->generateCustomerCode();
                $customer['status'] = 'a';
                $customer['AddBy'] = $this->session->userdata("FullName");
                $customer['AddTime'] = date("Y-m-d H:i:s");
                $customer['Customer_brunchid'] = $this->session->userdata("BRANCHid");

                $this->db->insert('tbl_customer', $customer);
                $customerId = $this->db->insert_id();
            }
            $quotation = array(
                'SaleMaster_InvoiceNo'           => $invoice,
                'SalseCustomer_IDNo'             => $customerId,
                'SaleMaster_SaleDate'            => $data->quotation->quotationDate,
                'SaleMaster_TotalSaleAmount'     => $data->quotation->total,
                'SaleMaster_TotalDiscountAmount' => $data->quotation->discount, 
                'aitCost'                       => $data->quotation->aitCost, 
                'SaleMaster_TaxAmount'           => $data->quotation->vat,
                'SaleMaster_Freight'             => $data->quotation->transportCost,
                'SaleMaster_PaidAmount'          => $data->quotation->paid,
                'SaleMaster_DueAmount'           => $data->quotation->due,
                'SaleMaster_SubTotalAmount'      => $data->quotation->subTotal,
                'shipping_cus_name'              => $data->quotation->shipping_cus_name,
                'shipping_mobile'                => $data->quotation->shipping_mobile,
                'shipping_address'               => $data->quotation->shipping_address,
                'warrenty'                       => $data->quotation->warrenty,
                'payment_note'                   => $data->quotation->payment_note,
                'Status'                         => 'a',
                "AddBy"                          => $this->session->userdata("FullName"),
                'AddTime'                        => date("Y-m-d H:i:s"),
                'SaleMaster_branchid'            => $this->session->userdata("BRANCHid")
            );

            $this->db->insert('tbl_quotation_master', $quotation);

            $quotationId = $this->db->insert_id();

            foreach ($data->cart as $cartProduct) {
                $quotationDetails = array(
                    'SaleMaster_IDNo'           => $quotationId,
                    'Product_IDNo'              => $cartProduct->productId,
                    'Product_Custom_Name'       => $cartProduct->custom_name,
                    'SaleDetails_TotalQuantity' => $cartProduct->quantity,
                    'SaleDetails_Rate'          => $cartProduct->salesRate,
                    'SaleDetails_TotalAmount'   => $cartProduct->total,
                    'color_id'                     => $cartProduct->color_id ?? null,
                    'size'                      => $cartProduct->size ?? '',
                    'Status'                    => 'a',
                    'AddBy'                     => $this->session->userdata("FullName"),
                    'AddTime'                   => date('Y-m-d H:i:s'),
                    'SaleDetails_BranchId'      => $this->session->userdata('BRANCHid')
                );

                $this->db->insert('tbl_quotation_details', $quotationDetails);
            }

            $res = ['success' => true, 'message' => 'Quotation added', 'quotationId' => $quotationId];
        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
        }

        echo json_encode($res);
    }

    public function updateQuotation()
    {
        $res = ['success' => false, 'message' => ''];
        try {
            $data = json_decode($this->input->raw_input_stream);

            $quotationId = $data->quotation->quotationId;

            if (isset($data->customer)) {
                $customer = (array)$data->customer;
                unset($customer['Customer_SlNo']);
                unset($customer['display_name']);
                $customer['UpdateBy'] = $this->session->userdata("FullName");
                $customer['UpdateTime'] = date("Y-m-d H:i:s");

                $this->db->where('Customer_SlNo', $data->sales->customerId)->update('tbl_customer', $customer);
            }

            $quotation = array(
                'SaleMaster_InvoiceNo'           => $data->quotation->invoiceNo,
                'SalseCustomer_IDNo'             => $data->quotation->customerId,
                'SaleMaster_SaleDate'            => $data->quotation->quotationDate,
                'SaleMaster_TotalSaleAmount'     => $data->quotation->total,
                'SaleMaster_TotalDiscountAmount' => $data->quotation->discount,
                'aitCost'                       => $data->quotation->aitCost, 
                'SaleMaster_TaxAmount'           => $data->quotation->vat,
                'SaleMaster_Freight'             => $data->quotation->transportCost,
                'SaleMaster_PaidAmount'          => $data->quotation->paid,
                'SaleMaster_DueAmount'           => $data->quotation->due,
                'shipping_cus_name'              => $data->quotation->shipping_cus_name,
                'shipping_mobile'                => $data->quotation->shipping_mobile,
                'shipping_address'               => $data->quotation->shipping_address,
                'SaleMaster_SubTotalAmount'      => $data->quotation->subTotal,
                'warrenty'                       => $data->quotation->warrenty,
                'payment_note'                   => $data->quotation->payment_note,
                'Status'                         => 'a',
                "AddBy"                          => $this->session->userdata("FullName"),
                'AddTime'                        => date("Y-m-d H:i:s"),
                'SaleMaster_branchid'            => $this->session->userdata("BRANCHid")
            );

            $this->db->where('SaleMaster_SlNo', $quotationId)->update('tbl_quotation_master', $quotation);

            $this->db->query("delete from tbl_quotation_details where SaleMaster_IDNo = ?", $quotationId);

            foreach ($data->cart as $cartProduct) {
                $quotationDetails = array(
                    'SaleMaster_IDNo'           => $quotationId,
                    'Product_IDNo'              => $cartProduct->productId,
                    'SaleDetails_TotalQuantity' => $cartProduct->quantity,
                    'SaleDetails_Rate'          => $cartProduct->salesRate,
                    'SaleDetails_TotalAmount'   => $cartProduct->total,
                    'Product_Custom_Name'       => $cartProduct->custom_name,
                    'color_id'                     => $cartProduct->color_id ?? null,
                    'size'                      => $cartProduct->size ?? '',
                    'Status'                    => 'a',
                    'AddBy'                     => $this->session->userdata("FullName"),
                    'AddTime'                   => date('Y-m-d H:i:s'),
                    'SaleDetails_BranchId'      => $this->session->userdata('BRANCHid')
                );

                $this->db->insert('tbl_quotation_details', $quotationDetails);
            }

            $res = ['success' => true, 'message' => 'Quotation updated', 'quotationId' => $quotationId];
        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
        }

        echo json_encode($res);
    }

    public function quotationRecord()
    {
        $access = $this->mt->userAccess();
        if (!$access) {
            redirect(base_url());
        }
        $data['title'] = "Quotation Record";
        $data['content'] = $this->load->view('Administrator/quotation/quotation_record', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function getQuotations()
    {
        $data = json_decode($this->input->raw_input_stream);

        $branchId = $this->session->userdata("BRANCHid");
        $clauses = "";
        if (isset($data->dateFrom) && $data->dateFrom != '' && isset($data->dateTo) && $data->dateTo != '') {
            $clauses .= " and qm.SaleMaster_SaleDate between '$data->dateFrom' and '$data->dateTo'";
        }

        if (isset($data->userFullName) && $data->userFullName != '') {
            $clauses .= " and qm.AddBy = '$data->userFullName'";
        }

        if (isset($data->customerId) && $data->customerId != '') {
            $clauses .= " and qm.SalseCustomer_IDNo = '$data->customerId'";
        }

        if (isset($data->quotationId) && $data->quotationId != '') {
            $clauses .= " and qm.SaleMaster_SlNo = '$data->quotationId'";
        }

        $res['quotations'] = $this->db->query("
            select 
                qm.*,
                c.Customer_Code,
                c.Customer_Name,
                c.Customer_Mobile,
                c.Customer_Address,
                br.Brunch_name,
                (
                    select ifnull(count(*), 0) from tbl_quotation_details qd 
                    where qd.SaleMaster_IDNo = 1
                    and qd.Status != 'd'
                ) as total_products
            from tbl_quotation_master qm
            left join tbl_customer c on c.Customer_SlNo = qm.SalseCustomer_IDNo
            left join tbl_brunch br on br.brunch_id = qm.SaleMaster_branchid
            where qm.SaleMaster_branchid = '$branchId'
            and qm.Status = 'a'
            $clauses
            order by qm.SaleMaster_SlNo desc
        ")->result();

        foreach ($res['quotations'] as $quote) {
            $quote->quotationDetails = $this->db->query("
                select 
                qd.*,
                p.Product_Name,
                p.Product_Img,
                pc.ProductCategory_Name,
                c.color_name
                from tbl_quotation_details qd
                join tbl_product p on p.Product_SlNo = qd.Product_IDNo
                join tbl_color c on c.color_SiNo = qd.color_id
                join tbl_productcategory pc on pc.ProductCategory_SlNo = p.ProductCategory_ID
                where qd.SaleMaster_IDNo = ?
                and qd.Status != 'd'
            ", $quote->SaleMaster_SlNo)->result();
        }

        echo json_encode($res);
    }
    public function getQuotationDetails()
    {
        $data = json_decode($this->input->raw_input_stream);

        $branchId = $this->session->userdata("BRANCHid");
        $clauses = "";
        if (isset($data->dateFrom) && $data->dateFrom != '' && isset($data->dateTo) && $data->dateTo != '') {
            $clauses .= " and qm.SaleMaster_SaleDate between '$data->dateFrom' and '$data->dateTo'";
        }

        if (isset($data->categoryId) && $data->categoryId != '') {
            $clauses .= " and p.ProductCategory_ID = '$data->categoryId'";
        }

        if (isset($data->productId) && $data->productId != '') {
            $clauses .= " and qd.Product_IDNo = '$data->productId'";
        }

        // if (isset($data->quotationId) && $data->quotationId != '') {
        //     $clauses .= " and qm.SaleMaster_SlNo = '$data->quotationId'";
        // }

        $quotationDetails = $this->db->query("
            select 
            qd.*,
            p.Product_Name,
            p.Product_Code,
            p.Product_Img,
            p.ProductCategory_ID,
            pc.ProductCategory_Name,
            c.color_name,
            c.color_SiNo
            from tbl_quotation_details qd
            left join tbl_quotation_master qm on qm.SaleMaster_SlNo = qd.SaleMaster_IDNo
            join tbl_product p on p.Product_SlNo = qd.Product_IDNo
            join tbl_color c on c.color_SiNo = qd.color_id
            join tbl_productcategory pc on pc.ProductCategory_SlNo = p.ProductCategory_ID
            where qd.Status != 'd'
            and qd.SaleDetails_BranchId = ?
            $clauses
        ", $branchId)->result();

        echo json_encode($quotationDetails);
    }

    public function editQuotation($quotationId)
    {
        $data['title'] = "Quotation Edit";
        $data['quotationId'] = $quotationId;
        $data['invoice'] = '';
        $data['content'] = $this->load->view('Administrator/quotation/quotation_entry', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function deleteQuotation()
    {
        $res = ['success' => false, 'message' => ''];
        try {
            $data = json_decode($this->input->raw_input_stream);
            $this->db->query("delete from tbl_quotation_master where SaleMaster_SlNo = ?", $data->quotationId);
            $this->db->query("delete from tbl_quotation_details where SaleMaster_IDNo = ?", $data->quotationId);
            $res = ['success' => true, 'message' => 'Quotation deleted'];
        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
        }

        echo json_encode($res);
    }


    public function checkInvoice()
    {
        $invoice = $this->input->post('invoice');
        $row = $this->db->query("SELECT * FROM tbl_quotation_master WHERE SaleMaster_InvoiceNo = '$invoice'")->row();
        if ($row->SaleMaster_InvoiceNo == $invoice) {
            return true;
        } else {
            return false;
        }
    }


    public function quotation_report()
    {
        $data['title'] = "Quotation Report";
        $id = $this->session->userdata('lastidforprint');
        $data['selse'] =  $this->Quotation_model->find_quotation_info_by_id($id);
        $data['quo_details'] = $this->Quotation_model->get_invoice_wise_quotation_product_details($id);
        $data['SalesID'] = $id;

        $data['content'] = $this->load->view('Administrator/quotation/quotationReport', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function quotationInvoice($quotationId)
    {
        $data['title'] = "Quotation Invoice";
        $data['quotationId'] = $quotationId;
        $data['content'] = $this->load->view('Administrator/quotation/quotation_invoice', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function quotationInvoiceReport()
    {
        $access = $this->mt->userAccess();
        if (!$access) {
            redirect(base_url());
        }
        $data['title'] = "Quotation Invoice";
        $data['content'] = $this->load->view('Administrator/quotation/quotation_invoice_report', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function delete_quotation_invoice()
    {
        $id = $this->input->post('SaleMasteriD');

        $attr = array('Status'  =>  'd');

        $qu = $this->db->where('SaleMaster_SlNo', $id)->update('tbl_quotation_master', $attr);

        if ($this->db->affected_rows()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}