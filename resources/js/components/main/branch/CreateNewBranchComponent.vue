<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header"><h5>New Branch</h5></div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <form>
                                        <div class="form-row">
                                            <div class="col-md-4 mb-3"><label for="">Branch Name:</label>
                                            <input
                                                    v-model="form.name"
                                                    type="text"
                                                    class="form-control"
                                                    placeholder="Type Branch Name"
                                                    :class="{
                                                        'is-invalid': form.errors.has('name'),
                                                    }"    id="branchName"
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
                                    @click="submitForm"
                                    class="btn btn-primary"
                                    :disabled="submit_disabled"
                                    type="button"
                                >
                                    Submit
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
    created() {},
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
        submitForm: async function () {
            try {
                const response = await this.form.post("api/branch/create");
                if (response.status == 200){
                    this.form.reset();
                    this.submit_disabled = false;
                    Toast.fire({
                        icon: "success",
                        title: response.data.message,
                    });
                }
            } catch (error) {
                console.log(error);
                this.submit_disabled = false;
            }
        }

    },


};
</script>
<style>
.align-horizontal {
  display: flex;
  align-items: center;
}
</style>
