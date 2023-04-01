<style>
.v-select {
    margin-bottom: 5px;
}

.v-select .dropdown-toggle {
    padding: 0px;
}

.v-select input[type=search],
.v-select input[type=search]:focus {
    margin: 0px;
}

.v-select .vs__selected-options {
    overflow: hidden;
    flex-wrap: nowrap;
}

.v-select .selected-tag {
    margin: 2px 0px;
    white-space: nowrap;
    position: absolute;
    left: 0px;
}

.v-select .vs__actions {
    margin-top: -5px;
}

.v-select .dropdown-menu {
    width: auto;
    overflow-y: auto;
}

#branchDropdown .vs__actions button {
    display: none;
}

#branchDropdown .vs__actions .open-indicator {
    height: 15px;
    margin-top: 7px;
}
</style>

<div id="quotation" class="row">
    <div class="col-xs-12 col-md-12 col-lg-12" style="border-bottom:1px #ccc solid;margin-bottom:5px;">
        <div class="row">
            <div class="form-group">
                <label class="col-sm-1 control-label no-padding-right"> Invoice no </label>
                <div class="col-sm-2">
                    <input type="text" class="form-control" v-model="quotation.invoiceNo" readonly />
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-1 control-label no-padding-right"> Quote. By </label>
                <div class="col-sm-2">
                    <input type="text" class="form-control" v-model="quotation.quotationBy" readonly />
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-1 control-label no-padding-right"> Quote. From </label>
                <div class="col-sm-2">
                    <v-select id="branchDropdown" v-bind:options="branches" label="Brunch_name" v-model="selectedBranch"
                        disabled></v-select>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-3">
                    <input class="form-control" type="date" v-model="quotation.quotationDate" />
                </div>
            </div>
        </div>
    </div>


    <div class="col-xs-9 col-md-9 col-lg-9">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title">Quotation Information</h4>
                <div class="widget-toolbar">
                    <a href="#" data-action="collapse">
                        <i class="ace-icon fa fa-chevron-up"></i>
                    </a>

                    <a href="#" data-action="close">
                        <i class="ace-icon fa fa-times"></i>
                    </a>
                </div>
            </div>

            <div class="widget-body">
                <div class="widget-main">

                    <div class="row">
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label class="col-xs-4 control-label no-padding-right"> Customer </label>
                                <div class="col-xs-7">
                                    <v-select v-bind:options="customers" label="display_name" v-model="selectedCustomer"
                                        v-on:input="onCustomerChange"></v-select>
                                </div>
                                <div class="col-xs-1" style="padding: 0;">
                                    <a href="<?= base_url('customer') ?>" class="btn btn-xs btn-danger"
                                        style="height: 25px; border: 0; width: 27px; margin-left: -10px;"
                                        target="_blank" title="Add New Customer"><i class="fa fa-plus"
                                            aria-hidden="true" style="margin-top: 5px;"></i></a>
                                </div>
                            </div>
                            <div class="form-group" style="display:none;"
                                v-bind:style="{display: selectedCustomer.Customer_Type == 'G' ? '' : 'none'}">
                                <label class="col-xs-4 control-label no-padding-right"> Name </label>
                                <div class="col-xs-8">
                                    <input type="text" id="customerName" placeholder="Customer Name"
                                        class="form-control" v-model="selectedCustomer.Customer_Name"
                                        v-bind:disabled="selectedCustomer.Customer_Type == 'G' ? false : true" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-xs-4 control-label no-padding-right"> Mobile No </label>
                                <div class="col-xs-8">
                                    <input type="text" id="mobileNo" placeholder="Mobile No" class="form-control"
                                        v-model="selectedCustomer.Customer_Mobile"
                                        v-bind:disabled="selectedCustomer.Customer_Type == 'G' ? false : true" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-xs-4 control-label no-padding-right"> Address </label>
                                <div class="col-xs-8">
                                    <textarea id="address" placeholder="Address" class="form-control"
                                        v-model="selectedCustomer.Customer_Address"
                                        v-bind:disabled="selectedCustomer.Customer_Type == 'G' ? false : true"></textarea>
                                </div>
                            </div>

                            <!-- <div class="form-group">
								<label class="col-sm-4 control-label no-padding-right"> Mobile No </label>
								<div class="col-sm-8">
									<input type="text" placeholder="Mobile No" class="form-control" v-model="quotation.customerMobile" />
								</div>
							</div>

							<div class="form-group clearfix">
								<label class="col-sm-4 control-label no-padding-right"> Address </label>
								<div class="col-sm-8">
									<textarea placeholder="Address" class="form-control" v-model="quotation.customerAddress"></textarea>
								</div>
							</div> -->

                            <h4 style="padding-left: 10px;">SHIP TO:</h4>
                            <div class="form-check form-check-inline" style="padding: 0px 13px;text-align:right">
                                <label class="col-sm-4 control-label no-padding-right"></label>
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox2"
                                    v-model="sameAddress">
                                <label class="form-check-label" for="inlineCheckbox2">Same Address</label>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-4 control-label no-padding-right">Cus. Name </label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" v-model="quotation.shipping_cus_name"
                                        required />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-4 control-label no-padding-right"> Mobile No </label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" v-model="quotation.shipping_mobile"
                                        required />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-4 control-label no-padding-right"> Address </label>
                                <div class="col-sm-8">
                                    <textarea class="form-control" v-model="quotation.shipping_address"
                                        required></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-5">
                            <form v-on:submit.prevent="addToCart">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right"> Product </label>
                                    <div class="col-sm-8">
                                        <v-select v-bind:options="products" v-model="selectedProduct"
                                            label="display_text" v-on:input="productOnChange"></v-select>
                                    </div>
                                    <div class="col-sm-1" style="padding: 0;">
                                        <a href="<?= base_url('product') ?>" class="btn btn-xs btn-danger"
                                            style="height: 25px; border: 0; width: 27px; margin-left: -10px;"
                                            target="_blank" title="Add New Product"><i class="fa fa-plus"
                                                aria-hidden="true" style="margin-top: 5px;"></i></a>
                                    </div>
                                </div>

                                <div class="form-group" style="display: none;">
                                    <label class="col-sm-3 control-label no-padding-right"> Size </label>
                                    <div class="col-sm-9">
                                        <input type="text" v-model="size" placeholder="Size" class="form-control" />
                                    </div>
                                </div>

                                <div class="form-group" style="display: none;">
                                    <label class="col-sm-3 control-label no-padding-right"> Color </label>
                                    <div class="col-sm-9">
                                        <input type="text" v-model="color" placeholder="Color" class="form-control" />
                                    </div>
                                </div>

                                <div class="form-group" style="display: none;">
                                    <label class="col-sm-3 control-label no-padding-right"> Brand </label>
                                    <div class="col-sm-9">
                                        <input type="text" placeholder="Group" class="form-control" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right"> Sale Rate </label>
                                    <div class="col-sm-9">
                                        <input type="number" placeholder="Rate" class="form-control"
                                            v-model="selectedProduct.Product_SellingPrice" v-on:input="productTotal" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right"> Quantity </label>
                                    <div class="col-sm-9">
                                        <input type="number" id="quantity" placeholder="Qty" class="form-control"
                                            ref="quantity" v-model="selectedProduct.quantity" v-on:input="productTotal"
                                            autocomplete="off" required />
                                    </div>
                                </div>

                                <div class="form-group" style="display:none;">
                                    <label class="col-sm-3 control-label no-padding-right"> Discount</label>
                                    <div class="col-sm-9">
                                        <span>(%)</span>
                                        <input type="text" placeholder="Discount" class="form-control"
                                            style="display: inline-block; width: 90%" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right"> Amount </label>
                                    <div class="col-sm-9">
                                        <input type="text" placeholder="Amount" class="form-control"
                                            v-model="selectedProduct.total" readonly />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right"> </label>
                                    <div class="col-sm-9">
                                        <button type="submit" class="btn btn-default pull-right">Add to Cart</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                        <div class="col-sm-2">
                            <input type="password" ref="productPurchaseRate"
                                v-model="selectedProduct.Product_Purchase_Rate"
                                v-on:mousedown="toggleProductPurchaseRate" v-on:mouseup="toggleProductPurchaseRate"
                                v-on:mouseout="$refs.productPurchaseRate.type = 'password'" readonly
                                title="Purchase rate (click & hold)"
                                style="font-size:12px;width:100%;text-align: center;">
                            <br><br>
                            <div style="text-align:center;display:none" :style="{display: imgUrl != '' ? '' : 'none'}">
                                <img :src="imgUrl" alt="" style="width:100px;height:100px;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-xs-12 col-md-12 col-lg-12" style="padding-left: 0px;padding-right: 0px;">
            <div class="table-responsive">
                <table class="table table-bordered" style="color:#000;margin-bottom: 5px;">
                    <thead>
                        <tr class="">
                            <th style="width:5%;color:#000;">Sl</th>
                            <th style="width:15%;color:#000;">Category</th>
                            <th style="width:20%;color:#000;">Product Name</th>
                            <th style="width:20%;color:#000;">Description</th>
                            <!-- <th style="width:10%;color:#000;">Size</th>
							<th style="width:7%;color:#000;">Color</th> -->
                            <th style="width:7%;color:#000;">Qty</th>
                            <th style="width:8%;color:#000;">Rate</th>
                            <th style="width:15%;color:#000;">Total Amount</th>
                            <th style="width:5%;color:#000;">Action</th>
                        </tr>
                    </thead>
                    <tbody style="display:none;" v-bind:style="{display: cart.length > 0 ? '' : 'none'}">
                        <tr v-for="(product, sl) in cart">
                            <td>{{ sl + 1 }}</td>
                            <td>{{ product.categoryName }}</td>
                            <td>{{ product.name }}</td>
                            <td>
                                <input type="text" class="form-control" v-model="product.custom_name">
                                <!-- {{ product.custom_name }} -->
                            </td>
                            <!-- <td>{{ product.size }}</td>
							<td>{{ product.color }}</td> -->
                            <td>{{ product.quantity }}</td>
                            <td>{{ product.salesRate }}</td>
                            <td>{{ product.total }}</td>
                            <td><a href="" v-on:click.prevent="removeFromCart(sl)"><i class="fa fa-trash"></i></a></td>
                        </tr>
                        <tr>
                            <td colspan="6" style="text-align: left;">
                                <label for=""><strong>Warrenty</strong></label>
                                <textarea class="form-control" cols="30" rows="2" placeholder="Warrenty text here...."
                                    v-model="quotation.warrenty"></textarea>
                            </td>
                            <td colspan="2" style="text-align: center;">
                                <label for=""><strong style="font-size:15px; font-weight:bold;">In Total Amount <br>
                                        {{quotation.total}}</strong></label>

                            </td>
                        </tr>
                        <tr>
                            <td colspan="9" style="text-align: left;">
                                <label for=""><strong>Payment Note</strong></label>
                                <textarea class="form-control" cols="30" rows="5" placeholder="Payment note here...."
                                    v-model="quotation.payment_note"></textarea>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title">Amount Details</h4>
                <div class="widget-toolbar">
                    <a href="#" data-action="collapse">
                        <i class="ace-icon fa fa-chevron-up"></i>
                    </a>

                    <a href="#" data-action="close">
                        <i class="ace-icon fa fa-times"></i>
                    </a>
                </div>
            </div>

            <div class="widget-body">
                <div class="widget-main">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="table-responsive">
                                <table style="color:#000;margin-bottom: 0px;border-collapse: collapse;">
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label class="col-sm-12 control-label no-padding-right">Sub
                                                    Total</label>
                                                <div class="col-sm-12">
                                                    <input type="number" class="form-control"
                                                        v-model="quotation.subTotal" readonly />
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label class="col-sm-12 control-label no-padding-right"> VAT </label>
                                                <div class="col-sm-4">
                                                    <input type="number" id="vatPercent" class="form-control"
                                                        v-model="vatPercent" v-on:input="calculateTotal" />
                                                </div>
                                                <label class="col-sm-1 control-label no-padding-right">%</label>
                                                <div class="col-sm-7">
                                                    <input type="number" class="form-control" v-model="quotation.vat"
                                                        v-on:input="calculateTotal" />
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr style="display:none;">
                                        <td>
                                            <div class="form-group">
                                                <label class="col-sm-12 control-label no-padding-right">Freight</label>
                                                <div class="col-sm-12">
                                                    <input type="number" class="form-control" />
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label class="col-sm-12 control-label no-padding-right">Discount
                                                    Persent</label>

                                                <div class="col-sm-4">
                                                    <input type="number" class="form-control" v-model="discountPercent"
                                                        v-on:input="calculateTotal" />
                                                </div>

                                                <label class="col-sm-1 control-label no-padding-right">%</label>

                                                <div class="col-sm-7">
                                                    <input type="number" id="discount" class="form-control"
                                                        v-model="quotation.discount" v-on:input="calculateTotal" />
                                                </div>

                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label class="col-sm-12 control-label no-padding-right">AIT
                                                    Persent</label>

                                                <div class="col-sm-4">
                                                    <input type="number" class="form-control" v-model="aitPercent"
                                                        v-on:input="calculateTotal" />
                                                </div>

                                                <label class="col-sm-1 control-label no-padding-right">%</label>

                                                <div class="col-sm-7">
                                                    <input type="number" id="aitCost" class="form-control"
                                                        v-model="quotation.aitCost" v-on:input="calculateTotal" />
                                                </div>

                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label class="col-xs-12 control-label no-padding-right">Transport
                                                    Cost</label>
                                                <div class="col-xs-12">
                                                    <input type="number" class="form-control"
                                                        v-model="quotation.transportCost" v-on:input="calculateTotal" />
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- <tr>
										<td>
											<div class="form-group">
												<label class="col-xs-12 control-label no-padding-right">Payment Method</label>
												<div class="col-xs-12">
													<select v-model="quotation.payment_method" id="" class="form-control" style="border-radius: 4px;padding:0px 4px;">
														<option value="" disabled selected>Select</option>
														<option value="Cash">Cash</option>
														<option value="Bank">Bank</option>
													</select>
												</div>
											</div>
										</td>
									</tr>

									<tr style="display: none;" :style="{display: quotation.payment_method == 'Bank' ? '' : 'none'}">
										<td>
											<div class="form-group">
												<label class="col-xs-12 control-label no-padding-right">Bank Name</label>
												<div class="col-xs-12">
													<select v-model="quotation.bank_name" id="" class="form-control" style="border-radius: 4px;padding:0px 4px;">
														<option value="" disabled selected>Select</option>
														<option v-for="bank in bankAccount" :value="bank.account_id">{{ bank.bank_name}} - {{bank.account_number}}</option>
													</select>
												</div>
											</div>
										</td>
									</tr> -->

                                    <!-- <tr style="display:none;">
										<td>
											<div class="form-group">
												<label class="col-sm-12 control-label no-padding-right">Round Of</label>
												<div class="col-sm-12">
													<input type="number" class="form-control" />
												</div>
											</div>
										</td>
									</tr> -->

                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label class="col-sm-12 control-label no-padding-right">Total</label>
                                                <div class="col-sm-12">
                                                    <input type="number" class="form-control" v-model="quotation.total"
                                                        readonly />
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label class="col-xs-12 control-label no-padding-right">Paid</label>
                                                <div class="col-xs-12">
                                                    <input type="number" id="paid" class="form-control"
                                                        v-model="quotation.paid" v-on:input="calculateTotal" readonly />
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label class="col-xs-12 control-label">Due</label>
                                                <div class="col-xs-12">
                                                    <input type="number" id="due" class="form-control"
                                                        v-model="quotation.due" readonly />
                                                </div>
                                                <!-- <div class="col-xs-6">
													<input type="number" id="previousDue" class="form-control" v-model="quotation.previousDue" readonly style="color:red;" />
												</div> -->
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td style="padding: 10px 0 0 13px;">
                                            <div class="form-group">
                                                <input type="button" class="btn btn-default" value="Save"
                                                    v-on:click="saveQuotation"
                                                    style="color:#fff;margin-top: 0px;margin-right: 5px;">
                                                <input type="button" class="btn btn-info" value="New Quotation"
                                                    v-on:click="window.location = '/quotation'"
                                                    style="color:#fff;margin-top: 0px;">
                                            </div>
                                        </td>
                                    </tr>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url(); ?>assets/js/vue/vue.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/axios.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/vue-select.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/moment.min.js"></script>

<script>
Vue.component('v-select', VueSelect.VueSelect);
new Vue({
    el: '#quotation',
    data() {
        return {
            quotation: {
                quotationId: parseInt('<?php echo $quotationId; ?>'),
                invoiceNo: '<?php echo $invoice; ?>',
                customerName: '',
                customerMobile: '',
                customerAddress: '',
                quotationBy: '<?php echo $this->session->userdata("FullName"); ?>',
                quotationFrom: '',
                quotationDate: '',
                subTotal: 0.00,
                discount: 0.00,
                aitCost: 0.00,
                vat: 0.00,
                total: 0.00,
                transportCost: 0.00,
                payment_method: '',
                bank_name: '',
                paid: '',
                due: '',
                warrenty: '3 Years ( For Gas Lift, Castor, Base & Mechanism )',
                payment_note: '50% payment should be paid before transportation\nCash, Card, Mobile Banking, Bank.\nA/C Name: Global Furniture,\nA/C No. 1263287983001, \nThe City Bank, Mirpur Branch, North Dhaka',
                shipping_cus_name: '',
                shipping_mobile: '',
                shipping_address: '',
            },
            customers: [],
            selectedCustomer: {
                Customer_SlNo: '',
                Customer_Code: '',
                Customer_Name: '',
                display_name: 'Select Customer',
                Customer_Mobile: '',
                Customer_Address: '',
                Customer_Type: ''
            },
            sameAddress: false,
            bankAccount: [],
            vatPercent: 0,
            discountPercent: 0,
            aitPercent: 0,
            cart: [],
            branches: [],
            selectedBranch: {
                brunch_id: "<?php echo $this->session->userdata('BRANCHid'); ?>",
                Brunch_name: "<?php echo $this->session->userdata('Brunch_name'); ?>"
            },
            products: [],
            selectedProduct: {
                Product_SlNo: '',
                display_text: 'Select Product',
                Product_Name: '',
                Unit_Name: '',
                quantity: 0,
                Product_Purchase_Rate: '',
                Product_SellingPrice: 0.00,
                total: 0.00,
            },
            imgUrl: '',
            size: '',
            color: '',
        }
    },
    created() {
        this.getCustomers();
        this.quotation.quotationDate = moment().format('YYYY-MM-DD');
        this.getBranches();
        this.getProducts();
        this.getBank();

        if (this.quotation.quotationId != 0) {
            this.getQuotations();
        }
    },
    watch: {
        sameAddress: function(newvalue, oldvalue) {
            // console.log(newvalue, oldvalue);
            // if (this.quotation.quotationId == 0) {
            if (this.selectedCustomer.Customer_Name == '') {
                alert('customer name is empty')
                return;
            }
            if (this.selectedCustomer.Customer_Address == '') {
                alert('customer address is empty')
                return;
            }
            if (this.selectedCustomer.Customer_Mobile == '') {
                alert('customer mobile is empty')
                return;
            }
            if (newvalue) {
                this.quotation.shipping_cus_name = this.selectedCustomer.Customer_Name;
                this.quotation.shipping_mobile = this.selectedCustomer.Customer_Mobile;
                this.quotation.shipping_address = this.selectedCustomer.Customer_Address;
            } else {
                this.quotation.shipping_cus_name = '';
                this.quotation.shipping_mobile = '';
                this.quotation.shipping_address = '';
            }
            // }
        }
    },
    methods: {
        async getCustomers() {
            await axios.post('/get_customers', {}).then(res => {
                this.customers = res.data;
                this.customers.unshift({
                    Customer_SlNo: 'C01',
                    Customer_Code: '',
                    Customer_Name: '',
                    display_name: 'General Customer',
                    Customer_Mobile: '',
                    Customer_Address: '',
                    Customer_Type: 'G'
                })
            })
        },
        getBranches() {
            axios.get('/get_branches').then(res => {
                this.branches = res.data;
            })
        },
        getProducts() {
            axios.get('/get_products').then(res => {
                this.products = res.data;
            })
        },
        getBank() {
            axios.get('/get_bank_accounts').then(res => {
                this.bankAccount = res.data;
            })
        },
        productTotal() {
            this.selectedProduct.total = (parseFloat(this.selectedProduct.quantity) * parseFloat(this
                .selectedProduct.Product_SellingPrice)).toFixed(2);
        },
        productOnChange() {
            this.$refs.quantity.focus();

            this.products.forEach(ele => {
                // console.log(ele);
                if (ele.Product_SlNo == this.selectedProduct.Product_SlNo) {
                    this.imgUrl = './uploads/products/' + ele.Product_Img;
                    throw 'break';
                }
            })
        },
        onCustomerChange() {
            this.quotation.shipping_cus_name = '';
            this.quotation.shipping_mobile = '';
            this.quotation.shipping_address = '';
        },
        toggleProductPurchaseRate() {
            //this.productPurchaseRate = this.productPurchaseRate == '' ? this.selectedProduct.Product_Purchase_Rate : '';
            this.$refs.productPurchaseRate.type = this.$refs.productPurchaseRate.type == 'text' ? 'password' :
                'text';
        },
        addToCart() {
            let product = {
                productId: this.selectedProduct.Product_SlNo,
                categoryName: this.selectedProduct.ProductCategory_Name,
                name: this.selectedProduct.Product_Name,
                custom_name: '',
                salesRate: this.selectedProduct.Product_SellingPrice,
                quantity: this.selectedProduct.quantity,
                total: this.selectedProduct.total,
                color: this.color,
                size: this.size
            }

            if (product.productId == '') {
                alert('Select Product');
                return;
            }
            // if (this.size == '') {
            // 	alert('Select Size');
            // 	return;
            // }
            // if (this.color == '') {
            // 	alert('Select Color');
            // 	return;
            // }

            if (product.quantity == 0 || product.quantity == '') {
                alert('Enter quantity');
                return;
            }

            if (product.salesRate == 0 || product.salesRate == '') {
                alert('Enter sales rate');
                return;
            }

            let cartInd = this.cart.findIndex(p => p.productId == product.productId);
            if (cartInd > -1) {
                this.cart.splice(cartInd, 1);
            }

            this.cart.unshift(product);
            this.clearProduct();
            this.calculateTotal();
        },
        removeFromCart(ind) {
            this.cart.splice(ind, 1);
            this.calculateTotal();
        },
        clearProduct() {
            this.selectedProduct = {
                Product_SlNo: '',
                display_text: 'Select Product',
                Product_Name: '',
                quantity: 0,
                Product_SellingPrice: 0.00,
                total: 0.00,
            }
            this.imgUrl = '';
            this.color = '';
            this.size = '';
        },
        calculateTotal() {
            this.quotation.subTotal = this.cart.reduce((prev, curr) => {
                return prev + parseFloat(curr.total)
            }, 0).toFixed(2);

            if (event.target.id == 'vatPercent') {
                this.quotation.vat = ((parseFloat(this.quotation.subTotal) * parseFloat(this.vatPercent)) / 100)
                    .toFixed(2);
            } else {
                this.vatPercent = (parseFloat(this.quotation.vat) / parseFloat(this.quotation.subTotal) * 100)
                    .toFixed(2);
            }

            if (event.target.id == 'discount') {
                this.discountPercent = (parseFloat(this.quotation.discount) / parseFloat(this.quotation
                    .subTotal) * 100).toFixed(2);
            } else {
                this.quotation.discount = ((parseFloat(this.quotation.subTotal) * parseFloat(this
                    .discountPercent)) / 100).toFixed(2);
            }

            if (event.target.id == 'aitCost') {
                this.aitPercent = (parseFloat(this.quotation.aitCost) / parseFloat(this.quotation
                    .subTotal) * 100).toFixed(2);
            } else {
                this.quotation.aitCost = ((parseFloat(this.quotation.subTotal) * parseFloat(this
                    .aitPercent)) / 100).toFixed(2);
            }

            this.quotation.total = ((parseFloat(this.quotation.subTotal) + parseFloat(this.quotation.vat) +
                parseFloat(this.quotation.aitCost) +
                parseFloat(this.quotation.transportCost)) - parseFloat(this.quotation.discount)).toFixed(2);

            let paid = this.quotation.paid == '' ? 0 : this.quotation.paid;
            // console.log(paid);
            this.quotation.due = (this.quotation.total - paid);
        },
        saveQuotation() {
            if (this.cart.length == 0) {
                alert('Cart is empty');
                return;
            }
            // if (this.quotation.payment_method == '') {
            // 	alert('Select a Payment Method');
            // 	return;
            // }
            // if (this.quotation.payment_method == 'bank' && this.quotation.bank_name == '') {
            // 	alert('Select a Bank Account');
            // 	return;
            // }

            // if (this.quotation.payment_method == 'cash') {
            // 	this.quotation.bank_name = '';
            // }

            let url = "/add_quotation";
            if (this.quotation.quotationId != 0) {
                url = "/update_quotation";
            }
            this.quotation.customerId = this.selectedCustomer.Customer_SlNo;
            this.quotation.quotationFrom = this.selectedBranch.brunch_id;

            let data = {
                quotation: this.quotation,
                cart: this.cart
            }

            if (this.selectedCustomer.Customer_Type == 'G') {
                data.customer = this.selectedCustomer;
            }

            // console.log(data);
            // return;

            axios.post(url, data).then(async res => {
                let r = res.data;
                alert(r.message);
                if (r.success) {
                    let conf = confirm('Do you want to view invoice?');
                    if (conf) {
                        window.open('/quotation_invoice/' + r.quotationId, '_blank');
                        await new Promise(r => setTimeout(r, 1000));
                        window.location = '/quotation';
                    } else {
                        window.location = '/quotation';
                    }
                }
            })
        },
        getQuotations() {
            axios.post('/get_quotations', {
                quotationId: this.quotation.quotationId
            }).then(res => {
                let r = res.data;
                let quotation = r.quotations[0];
                this.quotation.customerName = quotation.SaleMaster_customer_name;
                this.quotation.customerMobile = quotation.SaleMaster_customer_mobile;
                this.quotation.customerAddress = quotation.SaleMaster_customer_address;
                this.quotation.quotationBy = quotation.AddBy;
                this.quotation.invoiceNo = quotation.SaleMaster_InvoiceNo;
                this.quotation.salesFrom = quotation.SaleMaster_branchid;
                this.quotation.salesDate = quotation.SaleMaster_SaleDate;
                this.quotation.subTotal = quotation.SaleMaster_SubTotalAmount;
                this.quotation.discount = quotation.SaleMaster_TotalDiscountAmount;
                this.quotation.vat = quotation.SaleMaster_TaxAmount;
                this.quotation.total = quotation.SaleMaster_TotalSaleAmount;
                this.quotation.shipping_cus_name = quotation.shipping_cus_name;
                this.quotation.shipping_mobile = quotation.shipping_mobile;
                this.quotation.shipping_address = quotation.shipping_address;

                this.vatPercent = parseFloat(this.quotation.vat) * 100 / parseFloat(this.quotation
                    .subTotal);
                this.discountPercent = parseFloat(this.quotation.discount) * 100 / parseFloat(this
                    .quotation.subTotal);


                quotation.quotationDetails.forEach(product => {
                    let cartProduct = {
                        productId: product.Product_IDNo,
                        categoryName: product.ProductCategory_Name,
                        name: product.Product_Name,
                        salesRate: product.SaleDetails_Rate,
                        quantity: product.SaleDetails_TotalQuantity,
                        total: product.SaleDetails_TotalAmount,
                        color: product.color,
                        size: product.size,
                        custom_name: product.Product_Custom_Name
                    }

                    this.cart.push(cartProduct);
                })
                this.selectedCustomer.display_name = quotation.Customer_Code + ' - ' + quotation
                    .Customer_Name + ' -- ' + quotation.Customer_Mobile
                this.selectedCustomer.Customer_SlNo = quotation.SalseCustomer_IDNo
                this.selectedCustomer.Customer_Name = quotation.Customer_Name
                this.selectedCustomer.Customer_Mobile = quotation.Customer_Mobile
                this.selectedCustomer.Customer_Address = quotation.Customer_Address

                if (quotation.shipping_cus_name != '' || quotation.shipping_mobile != '' || quotation
                    .shipping_address != '') {
                    this.sameAddress = true;
                }
                // this.selectedCustomer = {
                // 	Customer_Name: quotation.Customer_Name,
                // 	Customer_SlNo: quotation.SalseCustomer_IDNo,
                // 	display_name: quotation.Customer_Code + ' - ' + quotation.Customer_Name + ' -- ' + quotation.Customer_Mobile,
                // 	Customer_Mobile: quotation.Customer_Mobile,
                // 	Customer_Address: quotation.Customer_Address,
                // 	Customer_Type: ''
                // }
                this.getProducts();
                this.calculateTotal();
            })
        }
    }
})
</script>