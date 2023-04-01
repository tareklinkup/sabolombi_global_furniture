<div id="sms">
    <div class="row">
        <div class="col-md-5">
            <form v-on:submit.prevent="sendSms">
                <div class="form-group">
                    <label for="smsText">SMS Text</label>
                    <textarea class="form-control" id="smsText" v-model="smsText" v-on:input="checkSmsLength" style="height:100px;"></textarea>
                    <p style="display:none" v-bind:style="{display: smsText.length > 0 ? '' : 'none'}">{{ smsText.length }} | {{ smsLength - smsText.length }} Remains | Max: {{ smsLength }} characters</p>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-xs pull-right" v-bind:style="{display: onProgress ? 'none' : ''}"> <i class="fa fa-send"></i> Send </button>
                    <button type="button" class="btn btn-primary btn-xs pull-right" disabled style="display:none" v-bind:style="{display: onProgress ? '' : 'none'}"> Please Wait .. </button>
                </div>
            </form>
        </div>
    </div>
    <div class="row" style="margin-top: 25px;">
        <div class="col-md-12">
            <input type="checkbox" id="cus" v-model="isCustomer"> <label for="cus">Customer</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="checkbox" id="scus" v-model="isShippingCustomer"> <label for="scus">Shipping Customer</label>
            <br>
            <br>
            <div class="table-responsive">
                <table v-if="isCustomer" class="table table-bordered" style="display:none" v-bind:style="{display: customers.length > 0 ? '' : 'none'}">
                    <thead>
                        <tr>
                            <th>Select All &nbsp; <input type="checkbox" v-on:click="selectAll"></th>
                            <th>Customer Code</th>
                            <th>Customer Name</th>
                            <th>Mobile</th>
                            <th>Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="customer in customers">
                            <td>
                                <input type="checkbox" v-bind:value="customer.Customer_Mobile" v-model="selectedCustomers" v-if="customer.Customer_Mobile.match(regexMobile)">
                            </td>
                            <td>{{ customer.Customer_Code }}</td>
                            <td>{{ customer.Customer_Name }}</td>
                            <td>
                                <span class="label label-md arrowed" v-bind:class="[customer.Customer_Mobile.match(regexMobile) ? 'label-info' : 'label-danger']">{{ customer.Customer_Mobile }}</span>
                            </td>
                            <td>{{ customer.Customer_Address }}</td>
                        </tr>
                    </tbody>
                </table>

                <table v-if="isShippingCustomer" class="table table-bordered" style="display:none" v-bind:style="{display: shipCustomers.length > 0 ? '' : 'none'}">
                    <thead>
                        <tr>
                            <th>Select All &nbsp; <input type="checkbox" v-on:click="selectShipCustomers"></th>
                            <th>Ship Customer Name</th>
                            <th>Ship Customer Mobile</th>
                            <th>Ship Customer Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="scustomer in shipCustomers">
                            <td><input type="checkbox" v-bind:value="scustomer.shipping_mobile" v-model="selectedShipCustomers" v-if="scustomer.shipping_mobile.match(regexMobile)"></td>
                            <td>{{ scustomer.shipping_cus_name }}</td>
                            <td>{{ scustomer.shipping_mobile }}</td>
                            <!-- <td><span class="label label-md arrowed" v-bind:class="[customer.Customer_Mobile.match(regexMobile) ? 'label-info' : 'label-danger']">{{ scustomer.Customer_Mobile }}</span></td> -->
                            <td>{{ scustomer.shipping_address }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url(); ?>assets/js/vue/vue.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/axios.min.js"></script>

<script>
    new Vue({
        el: '#sms',
        data() {
            return {
                customers: [],
                selectedCustomers: [],
                shipCustomers: [],
                selectedShipCustomers: [],
                smsText: '',
                smsLength: 306,
                onProgress: false,
                regexMobile: /^01[3-9][\d]{8}$/,
                isCustomer: false,
                isShippingCustomer: false,
            }
        },
        created() {
            this.getCustomers();
            this.getShipCustomers();
        },
        methods: {
            getCustomers() {
                axios.get('/get_customers').then(res => {
                    this.customers = res.data.map(customer => {
                        customer.Customer_Mobile = customer.Customer_Mobile.trim();
                        return customer;
                    });
                })
            },
            getShipCustomers() {
                axios.get('/get_ship_customers').then(res => {

                    res.data.forEach(element => {
                        if (element.shipping_mobile != null) {
                            if (element.shipping_mobile != '') {
                                element.shipping_mobile = element.shipping_mobile.trim();
                                this.shipCustomers.push(element)
                            }
                        }
                    });

                })
            },
            selectAll() {
                let checked = event.target.checked;
                if (checked) {
                    this.selectedCustomers = [...new Set(this.customers.map(v => v.Customer_Mobile))].filter(mobile => mobile.match(this.regexMobile));
                } else {
                    this.selectedCustomers = [];
                }
            },
            selectShipCustomers() {
                let checked = event.target.checked;
                if (checked) {
                    this.selectedShipCustomers = [...new Set(this.shipCustomers.map(v => v.shipping_mobile))].filter(mobile => mobile.match(this.regexMobile));
                } else {
                    this.selectedShipCustomers = [];
                }
            },
            checkSmsLength() {
                if (this.smsText.length > this.smsLength) {
                    this.smsText = this.smsText.substring(0, this.smsLength);
                }
            },
            sendSms() {
                if (this.selectedCustomers.length == 0) {
                    alert('Select customer');
                    return;
                }

                if (this.smsText.length == 0) {
                    alert('Enter sms text');
                    return;
                }

                let data = {
                    smsText: this.smsText,
                    numbers: this.selectedCustomers
                }

                this.onProgress = true;
                axios.post('/send_bulk_sms', data).then(res => {
                    let r = res.data;
                    alert(r.message);
                    this.onProgress = false;
                })
            }
        }
    })
</script>