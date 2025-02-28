<template>
	<div class="row">
		<div class="col-12 mt-3">
			<div class="card mb-3">
				<div class="card-header d-flex justify-content-between align-items-center">
					<h4 class="card-title">Add new user type</h4>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-12">
							<form method="POST" @submit.prevent="createNewRole">
								<div class="form-row">
									<div class="form-group col-md-6">
										<label>User type name</label>
										<input
											type="text"
											class="form-control rounded"
											:class="{ 'is-invalid': form.errors.has('name') }"
											v-model="form.name"
											placeholder="Example: Manager"
										/>
										<div class="invalid-feedback" v-if="form.errors.has('name')" v-html="form.errors.get('name')" />
									</div>
								</div>
								<button :disabled="form.busy" type="submit" class="btn btn-primary">Create</button>
							</form>
						</div>
					</div>
				</div>
			</div>

			<div class="card">
				<div class="card-header d-flex justify-content-between align-items-center">
					<h4 class="card-title">Role and permission overview</h4>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-hover">
							<thead>
								<tr>
									<th width="10%" scope="col">#</th>
									<th width="80%" scope="col">User Type</th>
									<th width="10%" scope="col">Actions</th>
								</tr>
							</thead>
							<tbody>
								<tr v-for="(role, index) in roles" v-bind:key="index">
									<th scope="row">{{index + 1}}</th>
									<td>{{role.name}}</td>
									<td style="text-align:center">
										<a v-if="role.name != 'Super Admin'" @click="showRole(role.id)" style="cursor:pointer;">
											<i class="fa fa-eye text-success mx-1"></i>
										</a>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	props:['user_id'],
	mounted() {},
	created() {
		this.getRoles();
		this.$on('role_created', () => {
			this.getRoles();
		});
	},
	data() {
		return {
			form: new Form({
				name: "",
			}),

			roles: "",
		};
	},
	methods: {
		createNewRole: async function () {
			try {
				const response = await this.form.post("/api/role");
				// console.log(response);
				if (response.status == 200) {
					Toast.fire({
						icon: "success",
						title: response.data.message,
					});

					this.form.reset();
					this.$emit('role_created');
				}
			} catch (e) {
				let errors = e.response.data.errors;
				let myerror = "";
				for (let i in errors) {
					myerror += " " + errors[i];
				}
				console.log(myerror);
				Toast.fire({
					icon: "error",
					title: myerror,
				});
			}
		},
		getRoles: function () {
			axios.get('/api/role')
				.then ( (response) => {
					this.roles = response.data;
				})
				.catch( (error) => {
					console.log(error);
				});
		},
		showRole: function (id) {
			let url = '/permission/';
			window.location.href = url + id;
		}
	},
};
</script>
