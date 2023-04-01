const quotationInvoice = Vue.component("quotation-invoice", {
  template: `
        <div>
            <div class="row">
                <div class="col-xs-6">
                    <a href="" v-on:click.prevent="printWithPad"><i class="fa fa-print"></i> Regular Print</a>
                </div>
                <div class="col-xs-6" style="text-align:right;">
                  <a href="" v-on:click.prevent="printWithOutPad"><i class="fa fa-print"></i> Pad Print</a>
            </div>
            </div>
            
            <div id="invoiceContent">
                <div class="row">
                    <div  class="col-xs-12 text-center">
                        <div _h098asdh>
                            <span style="font-size:40px;border-bottom: 1px dotted #ccc;">Quotation</span>
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
                            <span style="font-weight:bold;">Created by: </span> {{ quotation.AddBy }}<br>
                            <span style="font-weight:bold;">Invoice ID: </span> {{ quotation.SaleMaster_InvoiceNo }}<br>
                            <span style="font-weight:bold;">Date: </span> {{ quotation.SaleMaster_SaleDate }}
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top:20px;">
                    <div class="col-xs-12">
                        <div class="row" style="border-bottom:2px solid;width: 100%;margin: 0 auto;">
                            <div class="col-xs-6" style="padding-left: 0px;">
                                <p style="margin: 0px;font-weight:bold">BILL TO</p>
                            </div>
                            <div class="col-xs-6">
                                <p style="margin: 0px;font-weight:bold">SHIP TO</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <strong>Name:</strong> {{ quotation.Customer_Name }}<br>
                                <strong>Address:</strong> {{ quotation.Customer_Address }}<br />
                                <strong>Contact:</strong> {{ quotation.Customer_Mobile }}                                
                            </div>
                            <div class="col-xs-6">
                                <strong>Name:</strong> {{ quotation.shipping_cus_name }}<br>
                                <strong>Address:</strong> {{ quotation.shipping_address }}<br />
                                <strong>Contact:</strong> {{ quotation.shipping_mobile }}
                            </div>
                        </div>
                    </div>
                </div>

            <!--    <div class="row">
                    <div class="col-xs-8">
                        <strong>Customer Name:</strong> {{ quotation.SaleMaster_customer_name }}<br>
                        <strong>Customer Address:</strong> {{ quotation.SaleMaster_customer_address }}<br>
                        <strong>Customer Mobile:</strong> {{ quotation.SaleMaster_customer_mobile }}
                    </div>
                    <div class="col-xs-4 text-right">
                        <strong>Created by:</strong> {{ quotation.AddBy }}<br>
                        <strong>Invoice No.:</strong> {{ quotation.SaleMaster_InvoiceNo }}<br>
                        <strong>Date:</strong> {{ quotation.SaleMaster_SaleDate }} {{ moment(quotation.AddTime).format('h:mm a') }}
                    </div>
                </div> -->
                <div class="row">
                    <div class="col-xs-12">
                        <div _d9283dsc></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <table _a584de>
                            <thead>
                                <tr style="background: #545454; color:#fff;">
                                    <td style="width:5%">SL. NO.</td>
                                    <td style="width:10%">PICTURE</td>
                                    <td style="width:15%">PRODUCT NAME</td>
                                    <td style="width:10%">Color</td>
                                    <td style="width:10%">Size</td>
                                    <td style="width:20%">DESCRIPTION</td>
                                    <td style="width:10%">QTY</td>
                                    <td style="width:10%">UNIT PRICE</td>
                                    <td style="width:10%">TOTAL</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(product, sl) in cart">
                                    <td>{{ sl + 1 }}</td>
                                    <td>
                                        <img :src="'../uploads/products/' + product.Product_Img" style="width:60px;"/>
                                    </td>
                                    <td>{{ product.Product_Name }}</td>
                                    <td>{{ product.color_name ? product.color_name  : '-' }}</td>
                                    <td>{{ product.size ? product.size : '-'  }}</td>
                                    <td>{{ product.Product_Custom_Name }}</td>
                                    <td>{{ product.SaleDetails_TotalQuantity }}</td>
                                    <td>{{ product.SaleDetails_Rate }}</td>
                                    <td align="right">{{ product.SaleDetails_TotalAmount }}</td>
                                </tr>
                                <tr style="font-weight:bold">
                                    <td colspan="6">Total Qty</td>
                                    <td>{{ cart.reduce(function(prev,curr){ return prev + parseFloat(curr.SaleDetails_TotalQuantity)}, 0) }}</td>
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
                            <tr>
                                <td><strong>In Words: </strong>{{ convertNumberToWords(quotation.SaleMaster_TotalSaleAmount) }}</td>
                            </tr>
                            
                            
                            <tr>
                                <td ><strong>Warranty: </strong><br><span style="white-space: pre-wrap">{{ quotation.warrenty }}</span></td>
                            </tr>
                            <tr>
                                <td><strong>Payment : </strong></td>
                            </tr>
                            <tr>
                                <td style="border:1px solid #ccc; height:60px; width:100%;vertical-align: top;">
                                <span style="white-space: pre-wrap">{{ quotation.payment_note }}</span>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-xs-5 col-xs-offset-1">
                        <table _t92sadbc2>
                            <tr>
                                <td><strong>SUB TOTAL</strong></td>
                                <td style="text-align:right">{{ quotation.SaleMaster_SubTotalAmount }}</td>
                            </tr>
                            <tr v-if="quotation.SaleMaster_TaxAmount != 0">
                                <td><strong>VAT</strong></td>
                                <td style="text-align:right">{{ quotation.SaleMaster_TaxAmount }}</td>
                            </tr>
                            <tr v-if="quotation.aitCost != 0">
                              <td><strong>AIT Cost</strong></td>
                              <td style="text-align:right">{{ quotation.aitCost }}</td>
                            </tr>
                            <tr v-if="quotation.SaleMaster_Freight != 0">
                                <td><strong>TRANSPORT COST</strong></td>
                                <td style="text-align:right">{{ quotation.SaleMaster_Freight }}</td>
                            </tr>
                            <tr v-if="quotation.SaleMaster_TotalDiscountAmount != 0">
                                <td><strong>DISCOUNT</strong></td>
                                <td style="text-align:right">{{ quotation.SaleMaster_TotalDiscountAmount }}</td>
                            </tr>
                            <tr><td colspan="2" style="border-bottom: 2px solid"></td></tr>
                            <tr>
                                <td><strong>TOTAL AMOUNT:</strong></td>
                                <td style="text-align:right">{{ quotation.SaleMaster_TotalSaleAmount }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    `,
  props: ["quotation_id"],
  data() {
    return {
      quotation: {
        SaleMaster_InvoiceNo: null,
        SaleMaster_customer_name: null,
        SaleMaster_customer_mobile: null,
        SaleMaster_customer_address: null,
        SaleMaster_SaleDate: null,
        SaleMaster_TotalSaleAmount: null,
        SaleMaster_TotalDiscountAmount: null,
        SaleMaster_TaxAmount: null,
        SaleMaster_SubTotalAmount: null,
        AddBy: null,
      },
      cart: [],
      style: null,
      companyProfile: null,
      currentBranch: null,
    };
  },
  created() {
    this.setStyle();
    this.getQuotations();
    this.getCompanyProfile();
    this.getCurrentBranch();
  },
  methods: {
    getQuotations() {
      axios
        .post("/get_quotations", { quotationId: this.quotation_id })
        .then((res) => {
          this.quotation = res.data.quotations[0];
          this.cart = res.data.quotations[0].quotationDetails;
        });
    },
    getCompanyProfile() {
      axios.get("/get_company_profile").then((res) => {
        this.companyProfile = res.data;
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
                    // background-color:#e0e0e0;
                    font-weight: bold;
                    // font-size:15px;
                    font-size:36px;
                    margin-bottom:15px;
                    padding: 5px;
                }
                div[_h099asdh]{
                    white-space: pre-line;
                }
                div[_d9283dsc]{
                    padding-bottom:25px;
                    border-bottom: 1px solid #ccc;
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
                    border: 1px solid #000;
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
      return words_string + " Taka only"; 
    },
    async printWithPad() {
      let invoiceContent = document.querySelector("#invoiceContent").innerHTML;
      let printWindow = window.open(
        "",
        "PRINT",
        `width=${screen.width}, height=${screen.height}, left=0, top=0`
      );
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
                        <div class="row">
                            <div class="col-xs-4"><img src="/uploads/branch_logo_others/${
                              this.currentBranch.Logo
                            }" alt="Logo" style="height:60px;width:auto" /></div>

                            <div class="col-xs-5"></div>

                            <div class="col-xs-3" style="text-align:right;"><img src="/uploads/branch_logo_others/${
                              this.currentBranch.QR_Image
                            }" alt="Logo" style="height:100px;width:100px" /></div>

                         <!--   <div class="col-xs-8" style="padding-top:20px;">
                                <strong style="font-size:18px;">${
                                  this.companyProfile.Company_Name
                                }</strong><br>
                                ${this.companyProfile.Repot_Heading}
                            </div> -->
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col-xs-12">
                                ${invoiceContent}
                            </div>
                        </div>
                    </div>
                    <div class="container" style="position:fixed;bottom:15px;width:100%;">
                        <div class="row" style="border-bottom:1px solid #ccc;margin-bottom:5px;padding-bottom:6px;">
                            <div class="col-xs-6">
                                ** THANK YOU FOR YOUR BUSINESS **
                            </div>
                            <div class="col-xs-6 text-right">
                            <img src="/uploads/global_sign_200x200.png" id="logo" style="width:100px;position: absolute;
                                    top: -95px;right: 20px;">
                                <span style="text-decoration:overline;">Authorized Signature</span>
                            </div>
                        </div>

                        <div class="row" style="font-size:12px;">
                            <div class="col-xs-6">
                                Print Date: ${moment().format(
                                  "DD-MM-YYYY h:mm a"
                                )}, Printed by: ${this.quotation.AddBy}
                            </div>
                            <div class="col-xs-6 text-right">
                                
                            </div>
                        </div>
                    </div>
                </body>
                </html>
            `);
      let invoiceStyle = printWindow.document.createElement("style");
      invoiceStyle.innerHTML = this.style.innerHTML;
      printWindow.document.head.appendChild(invoiceStyle);
      printWindow.moveTo(0, 0);

      printWindow.focus();
      await new Promise((resolve) => setTimeout(resolve, 1000));
      printWindow.print();
      printWindow.close();
    },

    async printWithOutPad() {
        let invoiceContent = document.querySelector("#invoiceContent").innerHTML;
        let printWindow = window.open(
          "",
          "PRINT",
          `width=${screen.width}, height=${screen.height}, left=0, top=0`
        );
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
                          <div class="row">
                              <div class="col-xs-4"><img src="/uploads/branch_logo_others/${
                                this.currentBranch.Logo
                              }" alt="Logo" style="height:60px;width:auto" /></div>
  
                              <div class="col-xs-5"></div>
  
                              <div class="col-xs-3" style="text-align:right;"><img src="/uploads/branch_logo_others/${
                                this.currentBranch.QR_Image
                              }" alt="Logo" style="height:100px;width:100px" /></div>
  
                           <!--   <div class="col-xs-8" style="padding-top:20px;">
                                  <strong style="font-size:18px;">${
                                    this.companyProfile.Company_Name
                                  }</strong><br>
                                  ${this.companyProfile.Repot_Heading}
                              </div> -->
                          </div>
                          <div class="row">
                              <div class="col-xs-12">
                              </div>
                          </div>
                      </div>
                      <div class="container">
                          <div class="row">
                              <div class="col-xs-12">
                                  ${invoiceContent}
                              </div>
                          </div>
                      </div>
                      <div class="container" style="position:fixed;bottom:15px;width:100%;">
                          <div class="row" style="border-bottom:1px solid #ccc;margin-bottom:5px;padding-bottom:6px;">
                              <div class="col-xs-6">
                                  ** THANK YOU FOR YOUR BUSINESS **
                              </div>
                              <div class="col-xs-6 text-right">
                              
                                  <span style="text-decoration:overline;">Authorized Signature</span>
                              </div>
                          </div>
  
                          <div class="row" style="font-size:12px;">
                              <div class="col-xs-6">
                                  Print Date: ${moment().format(
                                    "DD-MM-YYYY h:mm a"
                                  )}, Printed by: ${this.quotation.AddBy}
                              </div>
                              <div class="col-xs-6 text-right">
                                  
                              </div>
                          </div>
                      </div>
                  </body>
                  </html>
              `);
              printWindow.document.title = `Quotation - ${this.quotation.Customer_Name}`;
        let invoiceStyle = printWindow.document.createElement("style");
        invoiceStyle.innerHTML = this.style.innerHTML;
        printWindow.document.head.appendChild(invoiceStyle);
        printWindow.moveTo(0, 0);
  
        printWindow.focus();
        await new Promise((resolve) => setTimeout(resolve, 1000));
        printWindow.print();
        printWindow.close();
      },
  },
});

