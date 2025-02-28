<template>
    <div class="row">
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">System Users</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <form
                                    method="POST"
                                    @submit.prevent="submitForm"
                                >
                                    <div class="form-row">
                                        <div class="col-md-4 mb-3">
                                            <label for="validationDefault03"
                                                >Role</label
                                            >
                                            <select
                                                class="form-control"
                                                name="role_id"
                                                :class="{
                                                    'is-invalid':
                                                        form.errors.has(
                                                            'role_id'
                                                        ),
                                                }"
                                                v-model="form.role_id"
                                            >
                                                <option
                                                    v-for="(
                                                        role, index
                                                    ) in role_list"
                                                    :key="index"
                                                    v-bind:value="role.id"
                                                >
                                                    {{ role.name }}
                                                </option>
                                            </select>
                                            <div class="invalid-feedback" v-if="form.errors.has('role_id')" v-html="form.errors.get('role_id')" />
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="validationDefault02"
                                                >Username</label
                                            >
                                            <input
                                                v-model="form.username"
                                                type="text"
                                                name="username"
                                                class="form-control"
                                                :class="{
                                                    'is-invalid':
                                                        form.errors.has(
                                                            'username'
                                                        ),
                                                }"
                                            />
                                            <div class="invalid-feedback" v-if="form.errors.has('username')" v-html="form.errors.get('username')" />
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="validationDefaultEmail"
                                                >Email</label
                                            >
                                            <div class="input-group">
                                                <div
                                                    class="input-group-prepend"
                                                >
                                                    <span
                                                        class="input-group-text"
                                                        id="inputGroupPrepend2"
                                                        >@</span
                                                    >
                                                </div>
                                                <input
                                                    v-model="form.email"
                                                    type="text"
                                                    name="email"
                                                    class="form-control"
                                                    :class="{
                                                        'is-invalid':
                                                            form.errors.has(
                                                                'email'
                                                            ),
                                                    }"
                                                />
                                                 <div class="invalid-feedback" v-if="form.errors.has('email')" v-html="form.errors.get('email')" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-4 mb-3">
                                            <label for="validationDefault04"
                                                >Password</label
                                            >
                                            <input
                                                v-model="form.password"
                                                type="password"
                                                name="password"
                                                class="form-control"
                                                :class="{
                                                    'is-invalid':
                                                        form.errors.has(
                                                            'password'
                                                        ),
                                                }"
                                            />
                                             <div class="invalid-feedback" v-if="form.errors.has('password')" v-html="form.errors.get('password')" />
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="validationDefault05"
                                                >Password Confirmation</label
                                            >
                                            <input
                                                v-model="
                                                    form.password_confirmation
                                                "
                                                type="password"
                                                name="password_confirmation"
                                                class="form-control"
                                                :class="{
                                                    'is-invalid':
                                                        form.errors.has(
                                                            'password'
                                                        ),
                                                }"
                                            />
                                             <div class="invalid-feedback" v-if="form.errors.has('password_confirmation')" v-html="form.errors.get('password_confirmation')" />
                                        </div>
                                    </div>
                                    <div class="form-row py-3">
                                        <div class="col-md-4">
                                            <file-dialog-64
                                                :isInvalid="
                                                    form.errors.errors.hasOwnProperty(
                                                        'photo'
                                                    )
                                                "
                                                :accept="'.jpeg, .jpg, .png'"
                                                @output="
                                                    (file) => {
                                                        uploadFile(file);
                                                    }
                                                "
                                                :label="'Profile image (600px X 600px Recommended)'"
                                            >
                                                <p
                                                    slot="errorMessage"
                                                    class="
                                                        invalid-feedback
                                                        d-block
                                                    "
                                                >
                                                    Image is required
                                                </p>
                                            </file-dialog-64>
                                        </div>
                                    </div>

                                    <button
                                        class="btn btn-primary"
                                        :disabled="submit_disabled"
                                        type="submit"
                                    >
                                        Create
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
    created() {
        this.getAllRoles();
    },
    mounted() {},
    data() {
        return {
            submit_disabled: false,

            form: new Form({
                role_id: "",
                username: "",
                email: "",
                password: "",
                password_confirmation: "",
                photo: {
                    name: "",
                    file: "",
                },
            }),

            role_list: "",
        };
    },
    methods: {
        getAllRoles: async function () {
            try {
                const response = await axios.get("/api/role");
                if (response.status == 200) {
                    this.role_list = response.data;
                }
            } catch (error) {
                console.log(error);
            }
        },
        submitForm: async function () {
            try {
                this.submit_disabled = true;
                const response = await this.form.post("/api/user");
                if (response.status == 200) {
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
        },
        uploadFile: function (file) {
            this.form.photo = file[0];
        },
    },
};
</script>
