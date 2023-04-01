<style>
	.inline-radio {
		display: inline;
	}

	#branch .Inactive {
		color: red;
	}

	#companyProfile input[type="file"] {
		display: none;
	}

	#companyProfile .custom-file-upload {
		border: 1px solid #ccc;
		display: inline-block;
		padding: 5px 12px;
		cursor: pointer;
		margin-top: 5px;
		background-color: #298db4;
		border: none;
		color: white;
	}

	#companyProfile .custom-file-upload:hover {
		background-color: #41add6;
	}

	#productImage {
		height: 100%;
		width: 100%;
	}
</style>
<div id="companyProfile">
	<div class="row" style="border: 1px solid #aaa;padding: 5px 20px 20px;margin:10px 0px;">
		<form @submit.prevent="saveCompanyProfile">
			<p style="font-size: 20px;">Company Profile</p>
			<div class="col-xs-6">
				<div class="form-group">
					<label class="control-label" for="form-field-1"> Company Name </label>
					<div>
						<input v-model="companyProfile.Company_Name" type="text" class="form-control" style="height: 35px;border-radius:0px!important;" />
					</div>
				</div>

				<div class="form-group" style="margin-top:15px">
					<label class="control-label" for="form-field-1"> Description </label>
					<div>
						<textarea id="Description" v-model="companyProfile.Repot_Heading" class="form-control" style="border-radius:0px!important;"></textarea>
					</div>
				</div>

				<div class="form-group" style="margin-top:15px;">
					<label class="control-label bolder">Invoice Print Type : </label>
					<div class="radio inline-radio">
						<label>
							<input v-model="companyProfile.Invoice_Type" id="a4" type="radio" value="1" class="ace" />
							<span class="lbl"> A4 Size</span>
						</label>
					</div>

					<div class="radio inline-radio">
						<label>
							<input v-model="companyProfile.Invoice_Type" id="a42" type="radio" value="2" class="ace" />
							<span class="lbl"> 1/2 of A4 Size</span>
						</label>
					</div>

					<div class="radio inline-radio">
						<label>
							<input v-model="companyProfile.Invoice_Type" id="pos" type="radio" value="3" class="ace" />
							<span class="lbl"> POS </span>
						</label>
					</div>
				</div>
			</div>
			<div class="col-xs-6">
				<div class="form-group">
					<div style="width: 100px;height:100px;border: 1px solid #ccc;overflow:hidden;">
						<img id="productImage" v-if="imageUrl == '' || imageUrl == null" src="/assets/no_image.gif">
						<img id="productImage" v-if="imageUrl != '' && imageUrl != null" v-bind:src="imageUrl">
					</div>
					<div style="text-align:center;">
						<label class="custom-file-upload">
							<input type="file" @change="previewImage" />
							Select Image
						</label>
					</div>
				</div>

			</div>
			<div class="col-xs-12">
				<div style="margin-top:15px;justify-content: right;display: flex;">
					<button type="submit" name="btnSubmit" title="Update" class="btn btn-sm btn-info pull-left">
						Update Company Profile
						<i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
					</button>
				</div>
			</div>
		</form>
	</div>
	<div class="row" style="border: 1px solid #aaa;padding: 5px 20px 20px;margin:10px 0px;">
		<form @submit.prevent="saveBranch">
			<p style="font-size: 20px;">Add Branch</p>
			<div class="col-sm-6">
				<div class="form-group" style="margin-bottom: 10px;">
					<label class="control-label no-padding-right"> Branch Name </label>
					<input type="text" placeholder="Branch Name" class="form-control" v-model="branch.name" required />
				</div>

				<div class="form-group" style="margin-bottom: 10px;">
					<label class="control-label no-padding-right"> Branch Title </label>
					<input type="text" placeholder="Branch Title" class="form-control" v-model="branch.title" required />
				</div>

				<div class="form-group" style="margin-bottom: 10px;">
					<label class="control-label no-padding-right"> Branch Address </label>
					<textarea class="form-control" placeholder="Branch Address" v-model="branch.address" required></textarea>
				</div>

				<div class="form-group">
					<label class="control-label no-padding-right"> Is Production </label>
					<input type="checkbox" v-model="branch.is_production">
				</div>
			</div>
			<div class="col-xs-6">
				<div class="row">
					<div class="col-xs-6">
						<div class="form-group">
							<div style="width: 100px;height:100px;border: 1px solid #ccc;overflow:hidden;">
								<img id="productImage" v-if="branchLogo == '' || branchLogo == null" src="/assets/no_image.gif">
								<img id="productImage" v-if="branchLogo != '' && branchLogo != null" v-bind:src="branchLogo">
							</div>
							<div style="text-align:center;">
								<label class="custom-file-upload">
									<input type="file" @change="selectBranchLogo" />
									Select Logo
								</label>
							</div>
						</div>
					</div>
					<div class="col-xs-6">
						<div class="form-group">
							<div style="width: 100px;height:100px;border: 1px solid #ccc;overflow:hidden;">
								<img id="productImage" v-if="branchQR == '' || branchQR == null" src="/assets/no_image.gif">
								<img id="productImage" v-if="branchQR != '' && branchQR != null" v-bind:src="branchQR">
							</div>
							<div style="text-align:center;">
								<label class="custom-file-upload">
									<input type="file" @change="selectBranchQR" />
									Select QR
								</label>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-12">
				<div style="margin-top:15px;justify-content: right;display: flex;">
					<button type="submit" class="btn btn-sm btn-success">
						Add Branch
						<i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
					</button>
				</div>
			</div>
		</form>
		<div class="col-md-12" style="margin-top: 20px;display:none;" v-bind:style="{display: branches.length > 0 ? '' : 'none'}">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>Sl</th>
						<th>Logo</th>
						<th>QR Image</th>
						<th>Branch Name</th>
						<th>Branch Title</th>
						<th>Branch Address</th>
						<th>Is Production</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<tr v-for="(branch, sl) in branches">
						<td>{{ sl + 1 }}</td>
						<td>
							<img :src="'./uploads/branch_logo_others/' + branch.Logo" alt="" style="width:60px;height:60px;">
						</td>
						<td>
							<img :src="'./uploads/branch_logo_others/' + branch.QR_Image" alt="" style="width:60px;height:60px;">
						</td>
						<td>{{ branch.Brunch_name }}</td>
						<td>{{ branch.Brunch_title }}</td>
						<td>{{ branch.Brunch_address }}</td>
						<td>{{ branch.is_production }}</td>
						<td><span v-bind:class="branch.active_status">{{ branch.active_status }}</span></td>
						<td>
							<?php if ($this->session->userdata('accountType') != 'u') { ?>
								<a href="" title="Edit Branch" @click.prevent="editBranch(branch)"><i class="fa fa-pencil"></i></a>&nbsp;
								<a href="" title="Deactive Branch" v-if="branch.status == 'a'" @click.prevent="changeStatus(branch.brunch_id)"><i class="fa fa-trash"></i></a>
								<a href="" title="Active Branch" v-else><i class="fa fa-check" @click.prevent="changeStatus(branch.brunch_id)"></i></a>
							<?php } ?>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>

<script src="<?php echo base_url(); ?>assets/js/vue/vue.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/axios.min.js"></script>

<script>
	new Vue({
		el: '#companyProfile',
		data() {
			return {
				branch: {
					branchId: 0,
					name: '',
					title: '',
					address: '',
					is_production: false,
				},
				branches: [],
				branchLogo: '',
				selectedLogoFile: null,
				branchQR: '',
				selectedQrFile: null,
				companyProfile: {
					Company_Logo_org: '',
					Company_Logo_thum: '',
					Company_Name: '',
					Company_SlNo: '',
					Currency_Name: '',
					Currency_Symbol: '',
					Invoice_Type: '',
					Repot_Heading: '',
					SubCurrency_Name: '',
					company_BrunchId: '',
					print_type: '',
				},
				imageUrl: '',
				selectedFile: null,
			}
		},
		created() {
			this.getCompanyProfile();
			this.getBranches();
		},
		methods: {
			async getCompanyProfile() {
				await axios.get('/get_company_profile').then(res => {
					this.companyProfile = res.data;
				})
				if (this.companyProfile.Company_Logo_thum != '') {
					this.imageUrl = './uploads/company_profile_thum/' + this.companyProfile.Company_Logo_thum;
				}
			},
			async getBranches() {
				await axios.get('/get_branches').then(res => {
					this.branches = res.data;
				})
				// console.log(this.companyProfile);
			},
			previewImage() {
				if (event.target.files.length > 0) {
					this.selectedFile = event.target.files[0];
					this.imageUrl = URL.createObjectURL(this.selectedFile);
				} else {
					this.selectedFile = null;
					this.imageUrl = null;
				}
			},
			saveCompanyProfile() {

				let fd = new FormData();
				fd.append('image', this.selectedFile);
				fd.append('data', JSON.stringify(this.companyProfile));
				// console.log(fd);
				// return;
				axios.post('/company_profile_Update', fd).then(res => {
					let r = res.data;
					// console.log(r);
					alert(r.message);
				})
			},
			selectBranchLogo() {
				if (event.target.files.length > 0) {
					this.selectedLogoFile = event.target.files[0];
					this.branchLogo = URL.createObjectURL(this.selectedLogoFile);
				} else {
					this.selectedLogoFile = null;
					this.branchLogo = null;
				}
			},
			selectBranchQR() {
				if (event.target.files.length > 0) {
					this.selectedQrFile = event.target.files[0];
					this.branchQR = URL.createObjectURL(this.selectedQrFile);
				} else {
					this.selectedQrFile = null;
					this.branchQR = null;
				}
			},
			saveBranch() {

				let url = "/add_branch";
				if (this.branch.branchId != 0) {
					url = "/update_branch";
				}

				let fd = new FormData();
				fd.append('Logo', this.selectedLogoFile);
				fd.append('QR_Image', this.selectedQrFile);
				fd.append('data', JSON.stringify(this.branch));

				// console.log(fd);
				// return;

				axios.post(url, fd).then(res => {
					let r = res.data;
					// console.log(r);
					alert(r.message);
					if (r.success) {
						this.getBranches();
						this.clearForm();
					}
				})
			},

			editBranch(branch) {
				this.branch.branchId = branch.brunch_id;
				this.branch.name = branch.Brunch_name;
				this.branch.title = branch.Brunch_title;
				this.branch.address = branch.Brunch_address;
				this.branch.is_production = branch.is_production == 'true' ? true : false;

				this.branchLogo = './uploads/branch_logo_others/' + branch.Logo;
				this.branchQR = './uploads/branch_logo_others/' + branch.QR_Image;
			},

			changeStatus(branchId) {
				let changeConfirm = confirm('Are you sure?');
				if (changeConfirm == false) {
					return;
				}
				axios.post('/change_branch_status', {
					branchId: branchId
				}).then(res => {
					let r = res.data;
					alert(r.message);
					if (r.success) {
						this.getBranches();
					}
				})
			},

			clearForm() {
				this.branch = {
					branchId: 0,
					name: '',
					title: '',
					address: ''
				}
			}
		}
	})
</script>