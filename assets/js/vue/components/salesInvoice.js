const salesInvoice = Vue.component("sales-invoice", {
  template: `
        <div>
            <div class="row">
                <div class="col-xs-6">
                    <a href="" v-on:click.prevent="printWithSeal"><i class="fa fa-print"></i> Regular Print</a>
                </div>
                <div class="col-xs-6 text-right">
                <a href="" v-on:click.prevent="printWithOutSeal"><i class="fa fa-print"></i> Pad Print</a>
            </div>
            </div>
            
            <div id="invoiceContent">
                <div class="row">
                    <div  class="col-xs-12 text-center">
                        <div _h098asdh>
                            <span style="font-size:40px;border-bottom: 1px dotted #ccc;">INVOICE</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div  class="col-xs-6">
                        <div _h099asdh>
                            <span style="font-weight:bold;">{{ currentBranch.Company_Name }}</span>
                            {{ currentBranch.Repot_Heading }}
                        </div>
                    </div>
                    <div  class="col-xs-6">
                        <div style="text-align:right;">
                            <span style="font-weight:bold;">Created by: </span> {{ sales.AddBy }}<br>
                            <span style="font-weight:bold;">Invoice ID: </span> {{ sales.SaleMaster_InvoiceNo }}<br>
                            <span style="font-weight:bold;">Date: </span> {{ sales.SaleMaster_SaleDate }}<br>
                            <!-- <span style="font-weight:bold;">Is Curier: </span> {{ sales.is_curier == true ? 'Yes' : '' }} -->
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top:20px;">
                    <div class="col-xs-12">
                        <div class="row" style="width: 100%;margin: 0 auto;">
                            <div class="col-xs-6" style="padding-left: 0px;">
                               
                            </div>
                            <div class="col-xs-6" style="padding-right:0px;">
                                <table style="width:150px;text-align:center;float:right;">
                                    <tr style="border:1px solid;font-weight:bold">
                                        <td>{{ sales.shipping_due == 1 ? 'SHIPPING DUE' : (sales.shipping_paid == 1 ? 'SHIPPING PAID' : '') }}</td>
                                    </tr>
                                    <tr v-else style="border:1px solid;font-weight:bold">
                                        <td>SHIPPING</td>
                                    </tr>
                                    <tr v-if="sales.SaleMaster_DueAmount > 0" style="border:1px solid;">
                                        <td>{{ sales.SaleMaster_DueAmount }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row" style="border-bottom:2px solid;width: 100%;margin: 0 auto;">
                            <div class="col-xs-6" style="padding-left: 0px;">
                                <p style="margin: 0px;font-weight:bold">BILL TO</p>
                            </div>
                            <div class="col-xs-6">
                                <p style="margin: 0px;font-weight:bold">SHIP TO</p>
                            </div>
                        </div>
                        <div class="row" style="display:flex;">
                            <div class="col-xs-6">
                                <b>Name: </b>{{ sales.Customer_Name }}<br>
                                <b>Address:</b> {{ sales.Customer_Address }}<br />
                                <b>Contact:</b> {{ sales.Customer_Mobile }}
                                
                            </div>
                            <div class="col-xs-6">
                                <b>Name:</b> {{ sales.shipping_cus_name }}<br>
                                <b>Address:</b> {{ sales.shipping_address }}<br />
                                <b>Contact:</b> {{ sales.shipping_mobile }}
                            </div>
                            
                        </div>
                    </div>
                </div>


                <div class="row" style="margin-top:5px;">
                    <div class="col-xs-12">
                        <table _a584de>
                            <thead>
                                <tr style="background: #545454; color:#fff;">
                                    <td>Sl.</td>
                                    <td>Product Name</td>
                                    <td>Color</td>
                                    <td>Size</td>
                                    <td>Qnty</td>
                                    <td>Unit</td>
                                    <td>Unit Price</td>
                                    <td>Total</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(product, sl) in cart">
                                    <td>{{ sl + 1 }}</td>
                                    <td>{{ product.Product_Name }}</td>
                                    <td>{{ product.color_name ? product.color_name : '-' }}</td>
                                    <td>{{ product.size ? product.size : '-'  }}</td>
                                    <td>{{ product.SaleDetails_TotalQuantity }}</td>
                                    <td>{{ product.Unit_Name }}</td>
                                    <td>{{ product.SaleDetails_Rate }}</td>
                                    <td align="right">{{ product.SaleDetails_TotalAmount }}</td>
                                </tr>
                                <tr style="font-weight:bold">
                                    <td colspan="4">Total Qty</td>
                                    <td>{{ cart.reduce(function(prev,curr){ return prev + parseFloat(curr.SaleDetails_TotalQuantity)}, 0) }}</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row"> 
                    <div class="col-xs-6" style="margin-top:20px;">
                        <table _t92sadbc2>
                            <tr  v-if="sales.warrenty != ''">
                                <td>
                                <strong>In Word: </strong> {{ convertNumberToWords(sales.SaleMaster_TotalSaleAmount) }}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        <br>
                        <table class="pull-left">
                            <tr>
                                <td><strong>Previous Due:</strong></td>
                                
                                <td style="text-align:right">{{ sales.SaleMaster_Previous_Due == null ? '0.00' : sales.SaleMaster_Previous_Due  }}</td>
                            </tr>
                            <tr>
                                <td><strong>Current Due:</strong></td>
                                
                                <td style="text-align:right">{{ sales.SaleMaster_DueAmount == null ? '0.00' : sales.SaleMaster_DueAmount  }}</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="border-bottom: 1px solid black;"></td>
                            </tr>
                            <tr>
                                <td><strong>Total Due:</strong></td>
                                
                                <td style="text-align:right">{{ (parseFloat(sales.SaleMaster_Previous_Due) + parseFloat(sales.SaleMaster_DueAmount == null ? 0.00 : sales.SaleMaster_DueAmount)).toFixed(2) }}</td>
                            </tr>
                        </table>
                    </div> 

                    <div class="col-xs-6">
                        <table _t92sadbc2>
                            <tr>
                                <td style="text-align:right;width:140px;">SUBTOTAL</td>
                                <td style="text-align:right">{{ sales.SaleMaster_SubTotalAmount }}</td>
                            </tr>
                            <tr v-if="sales.SaleMaster_TaxAmount != 0">
                                <td style="text-align:right;width:140px;">VAT</td>
                                <td style="text-align:right">{{ sales.SaleMaster_TaxAmount }}</td>
                            </tr>
                            <tr v-if="sales.SaleMaster_Freight != 0">
                                <td style="text-align:right;width:140px;">TRANSPORT COST</td>
                                <td style="text-align:right">{{ sales.SaleMaster_Freight }}</td>
                            </tr>
                            <tr v-if="sales.aitCost != 0">
                                <td style="text-align:right;width:140px;">AIT</td>
                                <td style="text-align:right">{{ sales.aitCost }}</td>
                            </tr>
                            <tr><td colspan="2" style="border-bottom: 1px solid black"></td></tr>
                            <tr>
                                <td style="text-align:right;width:140px;">TOTAL AMOUNT</td>
                                <td style="text-align:right">{{ totalAmount }}</td>
                            </tr>
                            <tr v-if="sales.SaleMaster_TotalDiscountAmount != 0">
                                <td style="text-align:right;width:140px;">DISCOUNT</td>
                                <td style="text-align:right">{{ sales.SaleMaster_TotalDiscountAmount }}</td>
                            </tr>
                            <tr><td colspan="2" style="border-bottom: 1px solid black"></td></tr>
                            <tr>
                                <td style="text-align:right;width:140px;">TOTAL</td>
                                <td style="text-align:right">{{ sales.SaleMaster_TotalSaleAmount }}</td>
                            </tr>
                            <tr v-if="sales.SaleMaster_PaidAmount != 0">
                                <td style="text-align:right;width:140px;">CASH PAYMENT</td>
                                <td style="text-align:right">{{ sales.SaleMaster_PaidAmount }}</td>
                            </tr>
                            <tr v-if="sales.SaleMaster_BankPaidAmount != 0">
                                <td style="text-align:right;width:140px;">BANK PAYMENT</td>
                                <td style="text-align:right">{{ sales.SaleMaster_BankPaidAmount }}</td>
                            </tr>
                            <tr><td colspan="2" style="border-bottom: 2px solid black"></td></tr>
                            <tr style="font-weight:bold" v-if="sales.SaleMaster_DueAmount != 0">
                                <td style="text-align:right;width:140px;"><strong>BALANCE DUE</strong></td>
                                <td style="text-align:right">{{ sales.SaleMaster_DueAmount }}</td>
                            </tr>                            
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                    <strong v-if="sales.warrenty != '' "> Warranty: </strong><br><span style="white-space: pre-wrap">{{ sales.warrenty }}</span>                    
                    <br><br>
                        <strong v-if="sales.SaleMaster_Description != '' ">Note: </strong>
                        <p style="white-space: pre-line">{{ sales.SaleMaster_Description }}</p>
                    </div>
                </div>
            </div>
        </div>
    `,
  props: ["sales_id"],
  data() {
    return {
      sales: {
        SaleMaster_InvoiceNo: null,
        SalseCustomer_IDNo: null,
        SaleMaster_SaleDate: null,
        Customer_Name: null,
        Customer_Address: null,
        Customer_Mobile: null,
        SaleMaster_TotalSaleAmount: null,
        SaleMaster_TotalDiscountAmount: null,
        SaleMaster_TaxAmount: null,
        SaleMaster_Freight: null,
        SaleMaster_SubTotalAmount: null,
        SaleMaster_PaidAmount: null,
        SaleMaster_DueAmount: null,
        SaleMaster_Previous_Due: null,
        SaleMaster_Description: null,
        warrenty: null,
        AddBy: null,
      },
      cart: [],
      style: null,
      companyProfile: null,
      currentBranch: {},
    };
  },
  filters: {
    formatDateTime(dt, format) {
      return dt == "" || dt == null ? "" : moment(dt).format(format);
    },
  },
  created() {
    this.setStyle();
    this.getSales();
    this.getCurrentBranch();
  },
  computed: {
    totalAmount() {
      return (
        parseFloat(this.sales.SaleMaster_SubTotalAmount) +
        parseFloat(this.sales.SaleMaster_TaxAmount) +
        parseFloat(this.sales.aitCost) +
        parseFloat(this.sales.SaleMaster_Freight)
      ).toFixed(2);
    },
  },
  methods: {
    getSales() {
      axios.post("/get_sales", { salesId: this.sales_id }).then((res) => {
        this.sales = res.data.sales[0];
        this.cart = res.data.saleDetails;
      });
    },
    getCurrentBranch() {
      axios.get("/get_current_branch").then((res) => {
        this.currentBranch = res.data;
      });
    },
    setStyle() {
      this.style = document.createElement("style");
      this.style.innerHTML = `
                div[_h098asdh]{
                    /*background-color:#e0e0e0;*/
                    font-weight: bold;
                    font-size:15px;
                    margin-bottom:15px;
                    padding: 5px;
                    // border-top: 1px dotted black;
                    // border-bottom: 1px dotted black;
                }
                div[_h099asdh]{
                    white-space: pre-line;
                }
                div[_d9283dsc]{
                    padding-bottom:25px;
                    border-bottom: 1px solid black;
                    margin-bottom: 15px;
                }
                table[_a584de]{
                    width: 100%;
                    text-align:center;
                }
                table[_a584de] thead{
                    font-weight:bold;
                }
                table[_a584de] td{
                    padding: 3px;
                    border: 1px solid black;
                }
                table[_t92sadbc2]{
                    width: 100%;
                }
                table[_t92sadbc2] td{
                    padding: 2px;
                }
            `;
      document.head.appendChild(this.style);
    },
    convertNumberToWords(amountToWord) {
      var words = new Array();
      words[0] = "";
      words[1] = "One";
      words[2] = "Two";
      words[3] = "Three";
      words[4] = "Four";
      words[5] = "Five";
      words[6] = "Six";
      words[7] = "Seven";
      words[8] = "Eight";
      words[9] = "Nine";
      words[10] = "Ten";
      words[11] = "Eleven";
      words[12] = "Twelve";
      words[13] = "Thirteen";
      words[14] = "Fourteen";
      words[15] = "Fifteen";
      words[16] = "Sixteen";
      words[17] = "Seventeen";
      words[18] = "Eighteen";
      words[19] = "Nineteen";
      words[20] = "Twenty";
      words[30] = "Thirty";
      words[40] = "Forty";
      words[50] = "Fifty";
      words[60] = "Sixty";
      words[70] = "Seventy";
      words[80] = "Eighty";
      words[90] = "Ninety";
      amount = amountToWord == null ? "0.00" : amountToWord.toString();
      var atemp = amount.split(".");
      var number = atemp[0].split(",").join("");
      var n_length = number.length;
      var words_string = "";
      if (n_length <= 9) {
        var n_array = new Array(0, 0, 0, 0, 0, 0, 0, 0, 0);
        var received_n_array = new Array();
        for (var i = 0; i < n_length; i++) {
          received_n_array[i] = number.substr(i, 1);
        }
        for (var i = 9 - n_length, j = 0; i < 9; i++, j++) {
          n_array[i] = received_n_array[j];
        }
        for (var i = 0, j = 1; i < 9; i++, j++) {
          if (i == 0 || i == 2 || i == 4 || i == 7) {
            if (n_array[i] == 1) {
              n_array[j] = 10 + parseInt(n_array[j]);
              n_array[i] = 0;
            }
          }
        }
        value = "";
        for (var i = 0; i < 9; i++) {
          if (i == 0 || i == 2 || i == 4 || i == 7) {
            value = n_array[i] * 10;
          } else {
            value = n_array[i];
          }
          if (value != 0) {
            words_string += words[value] + " ";
          }
          if (
            (i == 1 && value != 0) ||
            (i == 0 && value != 0 && n_array[i + 1] == 0)
          ) {
            words_string += "Crores ";
          }
          if (
            (i == 3 && value != 0) ||
            (i == 2 && value != 0 && n_array[i + 1] == 0)
          ) {
            words_string += "Lakhs ";
          }
          if (
            (i == 5 && value != 0) ||
            (i == 4 && value != 0 && n_array[i + 1] == 0)
          ) {
            words_string += "Thousand ";
          }
          if (
            i == 6 &&
            value != 0 &&
            n_array[i + 1] != 0 &&
            n_array[i + 2] != 0
          ) {
            words_string += "Hundred and ";
          } else if (i == 6 && value != 0) {
            words_string += "Hundred ";
          }
        }
        words_string = words_string.split("  ").join(" ");
      }
      return words_string + " only";
    },
    async printWithSeal() {
      let invoiceContent = document.querySelector("#invoiceContent").innerHTML;
      let printWindow = window.open(
        "",
        "PRINT",
        `width=${screen.width}, height=${screen.height}, left=0, top=0`
      );
      if (this.currentBranch.print_type == "3") {
        printWindow.document.write(`
                    <html>
                        <head>
                            <title>Invoice</title>
                            <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
                            <style>
                                body, table{
                                    font-size:11px;
                                }
                            </style>
                        </head>
                        <body>
                            <div style="text-align:center;">
                                <img src="/uploads/company_profile_thum/${this.currentBranch.Company_Logo_org}" alt="Logo" style="height:60px;margin:0px;" /><br>
                                <strong style="font-size:18px;">${this.currentBranch.Company_Name}</strong><br>
                                <p style="white-space:pre-line;">${this.currentBranch.Repot_Heading}</p>
                            </div>
                            ${invoiceContent}
                        </body>
                    </html>
                `);
      } else if (this.currentBranch.print_type == "2") {
        printWindow.document.write(`
                    <!DOCTYPE html>
                    <html lang="en">
                    <head>
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <meta http-equiv="X-UA-Compatible" content="ie=edge">
                        <title>Invoice</title>
                        <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
                        <style>
                            html, body{
                                width:500px!important;
                            }
                            body, table{
                                font-size: 13px;
                            }
                        </style>
                    </head>
                    <body>
                        <div class="row">
                            <div class="col-xs-2"><img src="/uploads/company_profile_thum/${this.currentBranch.Company_Logo_org}" alt="Logo" style="height:60px;width:auto" /></div>
                            <div class="col-xs-10" style="padding-top:20px;">
                                <strong style="font-size:18px;">${this.currentBranch.Company_Name}</strong><br>
                                <p style="white-space:pre-line;">${this.currentBranch.Repot_Heading}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div style="border-bottom: 4px double #454545;margin-top:7px;margin-bottom:7px;"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                ${invoiceContent}
                            </div>
                        </div>
                    </body>
                    </html>
				`);
      } else {
        printWindow.document.write(`
                    <!DOCTYPE html>
                    <html lang="en">
                    <head>
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <meta http-equiv="X-UA-Compatible" content="ie=edge">
                        <title>Invoice</title>
                        <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
                        <style>
                            body, table{
                                font-size: 13px;
                            }
                        </style>
                    </head>
                    <body>
                        <div class="container">
                            <table style="width:100%;">
                                <thead>
                                    <tr>
                                        <td>
                                            <div class="row">
                                                <div class="col-xs-4"><img src="/uploads/branch_logo_others/${
                                                  this.currentBranch.Logo
                                                }" alt="Logo" style="height:60px;width:auto" /></div>

                                                <div class="col-xs-5"></div>
                    
                                                <div class="col-xs-3" style="text-align:right;"><img src="/uploads/branch_logo_others/${
                                                  this.currentBranch.QR_Image
                                                }" alt="Logo" style="height:100px;width:100px" />
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-12">
                                                   
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    ${invoiceContent}
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td>
                                            <div style="width:100%;height:50px;">&nbsp;</div>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                            <div class="row" style="border-bottom:1px solid #ccc;margin-bottom:5px;padding-bottom:6px;">
                                <div class="col-xs-6">
                                    <span style="text-decoration:overline;">Received by</span><br><br>
                                    ** THANK YOU FOR YOUR BUSINESS **
                                </div>
                                <div class="col-xs-6 text-right">
                                    <span style="text-decoration:overline;">Authorized by</span>
                                </div>
                            </div>
                            <div style="position:fixed;left:0;bottom:15px;width:100%;">
                                <div class="row" style="font-size:12px;">
                                    <div class="col-xs-6">
                                        Print Date: ${moment().format(
                                          "DD-MM-YYYY h:mm a"
                                        )}, Printed by: ${this.sales.AddBy}
                                    </div>
                                    <div class="col-xs-6 text-right">                                     
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </body>
                    </html>
				`);
      }

      printWindow.document.title = `Invoice- ${this.sales.Customer_Name }`;

      let invoiceStyle = printWindow.document.createElement("style");
      invoiceStyle.innerHTML = this.style.innerHTML;
      printWindow.document.head.appendChild(invoiceStyle);
      printWindow.moveTo(0, 0);

      printWindow.focus();
      await new Promise((resolve) => setTimeout(resolve, 1000));
      printWindow.print();
      printWindow.close();
    },

    async printWithOutSeal() {
        let invoiceContent = document.querySelector("#invoiceContent").innerHTML;
        let printWindow = window.open(
          "",
          "PRINT",
          `width=${screen.width}, height=${screen.height}, left=0, top=0`
        );
        if (this.currentBranch.print_type == "3") {
          printWindow.document.write(`
                      <html>
                          <head>
                              <title>Invoice</title>
                              <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
                              <style>
                                  body, table{
                                      font-size:11px;
                                  }
                              </style>
                          </head>
                          <body>
                              <div style="text-align:center;">
                                  <img src="/uploads/company_profile_thum/${this.currentBranch.Company_Logo_org}" alt="Logo" style="height:60px;margin:0px;" /><br>
                                  <strong style="font-size:18px;">${this.currentBranch.Company_Name}</strong><br>
                                  <p style="white-space:pre-line;">${this.currentBranch.Repot_Heading}</p>
                              </div>
                              ${invoiceContent}
                          </body>
                      </html>
                  `);
        } else if (this.currentBranch.print_type == "2") {
          printWindow.document.write(`
                      <!DOCTYPE html>
                      <html lang="en">
                      <head>
                          <meta charset="UTF-8">
                          <meta name="viewport" content="width=device-width, initial-scale=1.0">
                          <meta http-equiv="X-UA-Compatible" content="ie=edge">
                          <title>Invoice</title>
                          <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
                          <style>
                              html, body{
                                  width:500px!important;
                              }
                              body, table{
                                  font-size: 13px;
                              }
                          </style>
                      </head>
                      <body>
                          <div class="row">
                              <div class="col-xs-2"><img src="/uploads/company_profile_thum/${this.currentBranch.Company_Logo_org}" alt="Logo" style="height:60px;width:auto" /></div>
                              <div class="col-xs-10" style="padding-top:20px;">
                                  <strong style="font-size:18px;">${this.currentBranch.Company_Name}</strong><br>
                                  <p style="white-space:pre-line;">${this.currentBranch.Repot_Heading}</p>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-xs-12">
                                  <div style="border-bottom: 4px double #454545;margin-top:7px;margin-bottom:7px;"></div>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-xs-12">
                                  ${invoiceContent}
                              </div>
                          </div>
                      </body>
                      </html>
                  `);
        } else {
          printWindow.document.write(`
                      <!DOCTYPE html>
                      <html lang="en">
                      <head>
                          <meta charset="UTF-8">
                          <meta name="viewport" content="width=device-width, initial-scale=1.0">
                          <meta http-equiv="X-UA-Compatible" content="ie=edge">
                          <title>Invoice</title>
                          <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
                          <style>
                              body, table{
                                  font-size: 13px;
                              }
                          </style>
                      </head>
                      <body>
                          <div class="container">
                              <table style="width:100%;">
                                  <tbody>
                                      <tr>
                                          <td>
                                              <div class="row" style="margin-top:100px;">
                                                  <div class="col-xs-12">
                                                      ${invoiceContent}
                                                  </div>
                                              </div>
                                          </td>
                                      </tr>
                                  </tbody>
                                  <tfoot>
                                      <tr>
                                          <td>
                                              <div style="width:100%;height:50px;">&nbsp;</div>
                                          </td>
                                      </tr>
                                  </tfoot>
                              </table>
                              <div class="row" style="border-bottom:1px solid #ccc;margin-bottom:5px;padding-bottom:6px;">
                                  <div class="col-xs-6">
                                      <span style="text-decoration:overline;">Received by</span><br><br>
                                      ** THANK YOU FOR YOUR BUSINESS **
                                  </div>
                                  <div class="col-xs-6 text-right">
                                     
                                      <span style="text-decoration:overline;">Authorized by</span>
                                  </div>
                              </div>
                              <div style="position:fixed;left:0;bottom:15px;width:100%;">
                                  <div class="row" style="font-size:12px;">
                                      <div class="col-xs-6">
                                          Print Date: ${moment().format(
                                            "DD-MM-YYYY h:mm a"
                                          )}, Printed by: ${this.sales.AddBy}
                                      </div>
                                      <div class="col-xs-6 text-right">                                     
                                      </div>
                                  </div>
                              </div>
                          </div>
                          
                      </body>
                      </html>
                  `);
        }
        let invoiceStyle = printWindow.document.createElement("style");
        invoiceStyle.innerHTML = this.style.innerHTML;
        printWindow.document.head.appendChild(invoiceStyle);
        printWindow.moveTo(0, 0);
  
        printWindow.focus();
        await new Promise((resolve) => setTimeout(resolve, 1000));
        printWindow.print();
        printWindow.close();
      },

    logo(){
        $("#logo").hide();
    }
  },
});
