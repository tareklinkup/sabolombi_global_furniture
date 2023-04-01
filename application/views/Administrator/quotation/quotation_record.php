<style>
	select.form-control {
		padding: 1px;
	}

	.v-select {
		margin-top: -2.5px;
		float: right;
		min-width: 180px;
		margin-left: 5px;
	}

	.v-select .dropdown-toggle {
		padding: 0px;
		height: 25px;
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

	#searchForm .form-group {
		margin-right: 5px;
	}

	#searchForm * {
		font-size: 13px;
	}

	.record-table {
		width: 100%;
		border-collapse: collapse;
	}

	.record-table thead {
		background-color: #0097df;
		color: white;
	}

	.record-table th,
	.record-table td {
		padding: 3px;
		border: 1px solid #454545;
	}

	.record-table th {
		text-align: center;
	}
</style>
<div id="quotationRecord">
	<div class="row" style="border-bottom: 1px solid #ccc;padding: 3px 0;">
		<div class="col-md-12">
			<form class="form-inline" id="searchForm" @submit.prevent="getSearchResult">
				<div class="form-group">
					<label>Search Type</label>
					<select class="form-control" v-model="searchType" @change="onChangeSearchType">
						<option value="">All</option>
						<option value="customer">By Customer</option>
						<!-- <option value="employee">By Employee</option> -->
						<option value="category">By Category</option>
						<option value="quantity">By Quantity</option>
						<option value="user">By User</option>
					</select>
				</div>
				<div class="form-group" style="display:none;" v-bind:style="{display: searchType == 'customer' ? '' : 'none'}">
					<label>Customer</label>
					<v-select v-bind:options="customers" v-model="selectedCustomer" label="display_name"></v-select>
				</div>

				<div class="form-group" style="display:none;" v-bind:style="{display: searchType == 'employee' ? '' : 'none'}">
					<label>Employee</label>
					<v-select v-bind:options="employees" v-model="selectedEmployee" label="Employee_Name"></v-select>
				</div>

				<div class="form-group" style="display:none;" v-bind:style="{display: searchType == 'quantity' ? '' : 'none'}">
					<label>Product</label>
					<v-select v-bind:options="products" v-model="selectedProduct" label="display_text" @input="sales = []"></v-select>
				</div>

				<div class="form-group" style="display:none;" v-bind:style="{display: searchType == 'category' ? '' : 'none'}">
					<label>Category</label>
					<v-select v-bind:options="categories" v-model="selectedCategory" label="ProductCategory_Name"></v-select>
				</div>

				<div class="form-group" v-bind:style="{display: searchTypesForRecord.includes(searchType) ? '' : 'none'}">
					<label>Record Type</label>
					<select class="form-control" v-model="recordType" @change="quotations = []">
						<option value="without_details">Without Details</option>
						<option value="with_details">With Details</option>
					</select>
				</div>

				<div class="form-group" style="display:none;" v-bind:style="{display: searchType == 'user' ? '' : 'none'}">
					<label>User</label>
					<v-select v-bind:options="users" v-model="selectedUser" label="FullName"></v-select>
				</div>
				<div class="form-group">
					<input type="date" class="form-control" v-model="dateFrom">
				</div>

				<div class="form-group">
					<input type="date" class="form-control" v-model="dateTo">
				</div>

				<div class="form-group" style="margin-top: -5px;">
					<input type="submit" value="Search">
				</div>
			</form>
		</div>
	</div>

	<div class="row" style="margin-top:15px;display:none;" v-bind:style="{display: quotations.length > 0 ? '' : 'none'}">
		<div class="col-md-12" style="margin-bottom: 10px;">
			<a href="" @click.prevent="print"><i class="fa fa-print"></i> Print</a>
		</div>
		<div class="col-md-12" style="display:none;" v-bind:style="{display: quotations.length > 0 && searchTypesForRecord.includes(searchType) && recordType == 'without_details' ? '' : 'none'}">
			<div class="table-responsive" id="reportContent">
				<table class="record-table">
					<thead>
						<tr>
							<th>Invoice No.</th>
							<th>Date</th>
							<th>Customer Name</th>
							<th>Customer Mobile</th>
							<th>Customer Address</th>
							<th>Sub Total</th>
							<th>VAT</th>
							<th>Discount</th>
							<th>Total</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="quotation in quotations">
							<td>{{ quotation.SaleMaster_InvoiceNo }}</td>
							<td>{{ quotation.SaleMaster_SaleDate }}</td>
							<td>{{ quotation.Customer_Name }}</td>
							<td>{{ quotation.Customer_Mobile }}</td>
							<td>{{ quotation.Customer_Address }}</td>
							<td style="text-align:right;">{{ quotation.SaleMaster_SubTotalAmount }}</td>
							<td style="text-align:right;">{{ quotation.SaleMaster_TaxAmount }}</td>
							<td style="text-align:right;">{{ quotation.SaleMaster_TotalDiscountAmount }}</td>
							<td style="text-align:right;">{{ quotation.SaleMaster_TotalSaleAmount }}</td>
							<td style="text-align:center;">
								<a href="" v-bind:href="`/quotation_invoice/${quotation.SaleMaster_SlNo}`" title="View Invoice"><i class="fa fa-file"></i></a>
								<?php if ($this->session->userdata('accountType') != 'u') { ?>
									<a href="" v-bind:href="`/quotation/${quotation.SaleMaster_SlNo}`" title="Edit Quotation"><i class="fa fa-edit"></i></a>
									<a href="" @click.prevent="deleteQuotation(quotation.SaleMaster_SlNo)" title="Delete Quotation"><i class="fa fa-trash"></i></a>
								<?php } ?>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<div v-if="searchTypesForRecord.includes(searchType)" class="col-md-12" style="display:none;" v-bind:style="{display: quotations.length > 0 && searchTypesForRecord.includes(searchType) && recordType == 'with_details' ? '' : 'none'}">
			<div class="table-responsive" id="reportContent">
				<table class="record-table">
					<thead>
						<tr>
							<th>Invoice No.</th>
							<th>Date</th>
							<th>Customer Name</th>
							<th>Saved By</th>
							<th>Product Name</th>
							<th>Price</th>
							<th>Quantity</th>
							<th>Total</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<template v-for="quote in quotations">
							<tr>
								<td>{{ quote.SaleMaster_InvoiceNo }}</td>
								<td>{{ quote.SaleMaster_SaleDate }}</td>
								<td>{{ quote.Customer_Name }}</td>
								<td>{{ quote.AddBy }}</td>
								<td>{{ quote.quotationDetails[0].Product_Name }}</td>
								<td style="text-align:right;">{{ quote.quotationDetails[0].SaleDetails_Rate }}</td>
								<td style="text-align:center;">{{ quote.quotationDetails[0].SaleDetails_TotalQuantity }}</td>
								<td style="text-align:right;">{{ quote.quotationDetails[0].SaleDetails_TotalAmount }}</td>
								<td style="text-align:center;">
									<!-- <a href="" title="Quote Invoice" v-bind:href="`/sale_invoice_print/${sale.SaleMaster_SlNo}`" target="_blank"><i class="fa fa-file"></i></a>
									<a href="" title="Chalan" v-bind:href="`/chalan/${sale.SaleMaster_SlNo}`" target="_blank"><i class="fa fa-file-o"></i></a>
									<?php if ($this->session->userdata('accountType') != 'u') { ?>
										<a href="javascript:" title="Edit Sale" @click="checkReturnAndEdit(sale)"><i class="fa fa-edit"></i></a>
										<a href="" title="Delete Sale" @click.prevent="deleteSale(sale.SaleMaster_SlNo)"><i class="fa fa-trash"></i></a>
									<?php } ?> -->
								</td>
							</tr>
							<tr v-for="(product, sl) in quote.quotationDetails.slice(1)">
								<td colspan="4" v-bind:rowspan="quote.quotationDetails.length - 1" v-if="sl == 0"></td>
								<td>{{ product.Product_Name }}</td>
								<td style="text-align:right;">{{ product.SaleDetails_Rate }}</td>
								<td style="text-align:center;">{{ product.SaleDetails_TotalQuantity }}</td>
								<td style="text-align:right;">{{ product.SaleDetails_TotalAmount }}</td>
								<td></td>
							</tr>
							<tr style="font-weight:bold;">
								<td colspan="4" style="font-weight:normal;"><strong>Note: </strong>{{ quote.SaleMaster_Description }}</td>
								<td colspan="2" style="text-align: right; font-weight:bold">Total = </td>
								<td style="text-align:center;">{{ quote.quotationDetails.reduce((prev, curr) => {return prev + parseFloat(curr.SaleDetails_TotalQuantity)}, 0) }}</td>
								<td style="text-align:right;">{{ quote.SaleMaster_TotalSaleAmount }}</td>
								<td></td>
							</tr>
						</template>
					</tbody>
				</table>
			</div>
		</div>
		<div class="col-md-12" style="display:none;" v-bind:style="{display: quotations.length > 0 && searchTypesForDetails.includes(searchType) ? '' : 'none'}">
			<div class="table-responsive" id="reportContent">
				<table class="record-table">
					<thead>
						<tr>
							<th>Product Id</th>
							<th>Product Information</th>
							<th>Quantity</th>
						</tr>
					</thead>
					<tbody>
						<template v-for="quote in quotations">
							<tr>
								<td colspan="3" style="text-align:center;background: #ccc;">{{ quote.category_name }}</td>
							</tr>
							<tr v-for="product in quote.products">
								<td>{{ product.product_code }}</td>
								<td>{{ product.product_name }}</td>
								<td style="text-align:right;">{{ product.quantity }}</td>
							</tr>
						</template>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<script src="<?php echo base_url(); ?>assets/js/vue/vue.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/axios.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/moment.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/vue-select.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/lodash.min.js"></script>

<script>
	Vue.component('v-select', VueSelect.VueSelect);
	new Vue({
		el: '#quotationRecord',
		data() {
			return {
				searchType: '',
				recordType: 'without_details',
				dateFrom: moment().format('YYYY-MM-DD'),
				dateTo: moment().format('YYYY-MM-DD'),
				quotations: [],
				customers: [],
				selectedCustomer: null,
				employees: [],
				selectedEmployee: null,
				products: [],
				selectedProduct: null,
				users: [],
				selectedUser: null,
				categories: [],
				selectedCategory: null,
				searchTypesForRecord: ['', 'user', 'customer', 'employee'],
				searchTypesForDetails: ['quantity', 'category']
			}
		},
		methods: {
			onChangeSearchType() {
				this.quotations = [];
				if (this.searchType == 'quantity') {
					this.getProducts();
				} else if (this.searchType == 'user') {
					this.getUsers();
				} else if (this.searchType == 'category') {
					this.getCategories();
				} else if (this.searchType == 'customer') {
					this.getCustomers();
				} else if (this.searchType == 'employee') {
					this.getEmployees();
				}
			},
			getProducts() {
				axios.get('/get_products').then(res => {
					this.products = res.data;
				})
			},
			getCustomers() {
				axios.get('/get_customers').then(res => {
					this.customers = res.data;
				})
			},
			getEmployees() {
				axios.get('/get_employees').then(res => {
					this.employees = res.data;
				})
			},
			getUsers() {
				axios.get('/get_users').then(res => {
					this.users = res.data;
				})
			},
			getCategories() {
				axios.get('/get_categories').then(res => {
					this.categories = res.data;
				})
			},
			getSearchResult() {
				if (this.searchType != 'customer') {
					this.selectedCustomer = null;
				}

				if (this.searchType != 'employee') {
					this.selectedEmployee = null;
				}

				if (this.searchType != 'quantity') {
					this.selectedProduct = null;
				}

				if (this.searchType != 'category') {
					this.selectedCategory = null;
				}

				if (this.searchTypesForRecord.includes(this.searchType)) {
					this.getQuoteRecord();
				} else {
					this.getQuoteDetails();
				}
			},

			getQuoteRecord() {
				let filter = {
					userFullName: this.selectedUser == null || this.selectedUser.FullName == '' ? '' : this.selectedUser.FullName,
					customerId: this.selectedCustomer == null || this.selectedCustomer.Customer_SlNo == '' ? '' : this.selectedCustomer.Customer_SlNo,
					// employeeId: this.selectedEmployee == null || this.selectedEmployee.Employee_SlNo == '' ? '' : this.selectedEmployee.Employee_SlNo,
					dateFrom: this.dateFrom,
					dateTo: this.dateTo
				}

				let url = '/get_quotations';

				axios.post(url, filter)
					.then(res => {
						this.quotations = res.data.quotations;
					})
					.catch(error => {
						if (error.response) {
							alert(`${error.response.status}, ${error.response.statusText}`);
						}
					})
			},
			getQuoteDetails() {
				let filter = {
					categoryId: this.selectedCategory == null || this.selectedCategory.ProductCategory_SlNo == '' ? '' : this.selectedCategory.ProductCategory_SlNo,
					productId: this.selectedProduct == null || this.selectedProduct.Product_SlNo == '' ? '' : this.selectedProduct.Product_SlNo,
					dateFrom: this.dateFrom,
					dateTo: this.dateTo
				}

				axios.post('/get_quotedetails', filter)
					.then(res => {
						let quote = res.data;

						// if (this.selectedProduct == null) {
						quote = _.chain(quote)
							.groupBy('ProductCategory_ID')
							.map(sale => {
								return {
									category_name: sale[0].ProductCategory_Name,
									products: _.chain(sale)
										.groupBy('Product_IDNo')
										.map(product => {
											return {
												product_code: product[0].Product_Code,
												product_name: product[0].Product_Name,
												quantity: _.sumBy(product, item => Number(item.SaleDetails_TotalQuantity))
											}
										})
										.value()
								}
							})
							.value();
						// }
						this.quotations = quote;
						// console.log(this.quotations);
					})
					.catch(error => {
						if (error.response) {
							alert(`${error.response.status}, ${error.response.statusText}`);
						}
					})
			},








			// getQuotations() {
			// 	axios.post('/get_quotations', this.filter)
			// 		.then(res => {
			// 			this.quotations = res.data.quotations;
			// 		})
			// },
			deleteQuotation(quotationId) {
				let deleteConfirm = confirm('Are you sure?');
				if (deleteConfirm == false) {
					return;
				}
				axios.post('/delete_quotation', {
					quotationId: quotationId
				}).then(res => {
					let r = res.data;
					alert(r.message);
					if (r.success) {
						this.getQuotations();
					}
				})
			},
			async print() {
				let dateText = '';
				if (this.filter.dateFrom != '' && this.filter.dateTo != '') {
					dateText = `Statemenet from <strong>${this.filter.dateFrom}</strong> to <strong>${this.filter.dateTo}</strong>`;
				}
				let reportContent = `
					<div class="container">
						<div class="row">
							<div class="col-xs-12 text-center">
								<h3>Quotation Record</h3>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12 text-right">
								${dateText}
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12">
								${document.querySelector('#reportContent').innerHTML}
							</div>
						</div>
					</div>
				`;

				var reportWindow = window.open('', 'PRINT', `height=${screen.height}, width=${screen.width}`);
				reportWindow.document.write(`
					<?php $this->load->view('Administrator/reports/reportHeader.php'); ?>
				`);

				reportWindow.document.head.innerHTML += `
					<style>
						.record-table{
							width: 100%;
							border-collapse: collapse;
						}
						.record-table thead{
							background-color: #0097df;
							color:white;
						}
						.record-table th, .record-table td{
							padding: 3px;
							border: 1px solid #454545;
						}
						.record-table th{
							text-align: center;
						}
					</style>
				`;
				reportWindow.document.body.innerHTML += reportContent;

				let rows = reportWindow.document.querySelectorAll('.record-table tr');
				rows.forEach(row => {
					row.lastChild.remove();
				})


				reportWindow.focus();
				await new Promise(resolve => setTimeout(resolve, 1000));
				reportWindow.print();
				reportWindow.close();
			}
		}
	})
</script>