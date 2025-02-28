<template>
    <div class=col-lg-12>
        <div v-if="$can('branch_update')" class="row">
            <div class="col-12 mt-3">
                <div class="card">
                    <div
                            class="
                                card-header
                                d-flex
                                justify-content-between
                                align-items-center
                            "
                        >
                        <h4 class="card-title">Update Branch Details</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <form>
                                    <div class="form-row">
                                        <div class="col-md-4 mb-3"><label for="">Branch Name:</label>
                                            <input
                                                type="text"
                                                class="form-control rounded"
                                                :class="{
                                                    'is-invalid':
                                                        form.errors.has('name'),
                                                }"
                                                id="branchName"
                                                v-model="form.name"
                                                placeholder="Enter Branch Name"
                                            />
                                            <div
                                                class="invalid-feedback"
                                                v-if="form.errors.has('name')"
                                                v-html="form.errors.get('name')"
                                            />
                                        </div>
                                        <div class="col-md-4 mb-3"><label for="">City:</label>
                                            <input
                                                v-model="form.city"
                                                type="text"
                                                class="form-control"
                                                placeholder="Type Branch City"
                                                :class="{
                                                    'is-invalid': form.errors.has('city'),
                                                }"    id="branchCity"
                                            /><div
                                                class="invalid-feedback"
                                                v-if="form.errors.has('name')"
                                                v-html="form.errors.get('name')"
                                            />
                                        </div>
                                        <div class="col-md-4 mb-3"><label for="">Manager Name:</label>
                                            <input
                                                v-model="form.manager_name"
                                                type="text"
                                                class="form-control"
                                                placeholder="Type Manager Name"
                                                :class="{
                                                    'is-invalid': form.errors.has('manager_name'),
                                                }"    id="branchManagerName"
                                            />
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-12 mb-3"><label for=""> Address:</label>
                                            <input
                                                v-model="form.address"
                                                type="text"
                                                class="form-control "
                                                placeholder="Type Branch Address"
                                                :class="{
                                                    'is-invalid': form.errors.has('address'),
                                                }"    id="branchAddress"
                                            />
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-4 mb-3"><label for="">Phone Number:</label>
                                            <input
                                                v-model="form.phone_number"
                                                type="text"
                                                class="form-control"
                                                placeholder="Type Branch's Phone Number"
                                                :class="{
                                                    'is-invalid': form.errors.has('phone_number'),
                                                }"    id="branchPhoneNumber"
                                            />
                                        </div>
                                        <div class="col-md-4 mb-3"><label for="">Status:</label>
                                            <select v-model="form.branch_status" class="form-control" :class="{
                                                    'is-invalid': form.errors.has('branch_status'),
                                                }" id="branchStatus">
                                                <option value="Available">Available</option>
                                                <option value="Permanently Closed">Permanently Closed</option>
                                            </select>
                                        </div>
                                    </div>
                                        <button
                                @click="updateBranch"
                                class="btn btn-primary"
                                :disabled="submit_disabled"
                                type="button"
                            >
                                Update
                            </button>
                            <button
                                @click="deleteBranch"
                                class="btn btn-danger"
                                :disabled="submit_disabled"
                                type="button"
                            >
                                Delete
                            </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["branch"],
    created() {
        this.form.name = this.branch.name;
        this.form.city = this.branch.city;
        this.form.manager_name = this.branch.manager_name;
        this.form.address = this.branch.address;
        this.form.phone_number = this.branch.phone_number;
        this.form.branch_status = this.branch.branch_status;
    },
    mounted() {

    },
    data() {
        return {
            form: new Form({
                name: "",
                city:"",
                address: "",
                manager_name: "",
                phone_number: "",
                branch_status: "",

            }),
        };
    },
    methods: {
        updateBranch: async function () {
            try {
                Toast.fire({
                    icon: "info",
                    title: "Please wait!",
                });
                this.submit_disabled = true;
                const response = await this.form.patch(`/api/branch/${this.branch.id}/update`);
                if (response.status == 200){
                    Toast.fire({
                        icon: "success",
                        title: response.data.message,
                    }).then(() => {
                        this.submit_disabled = false;
                        window.location.href = "/branch/view";
                    });
                }
            } catch (error) {
                console.log(error);
                this.submit_disabled = false;
            }
        },
        deleteBranch: async function () {
            try {
                Toast.fire({
                    icon: "info",
                    title: "Please wait!",
                });
                this.submit_disabled = true;
                const response = await this.form.patch(`/api/branch/${this.branch.id}/delete`);
                if (response.status == 200){
                    Toast.fire({
                        icon: "success",
                        title: response.data.message,
                    }).then(() => {
                        this.submit_disabled = false;
                        window.location.href = "/branch/view";
                    });
                }
            } catch (error) {
                console.log(error);
                this.submit_disabled = false;
            }
        },
    },
    computed: {
    },
};
</script>

