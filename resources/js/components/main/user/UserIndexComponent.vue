<template>
    <div v-if="$can('user_view')" class="row">
        <div class="col-12 mt-3">
            <div class="card">
                <div
                    class="card-header d-flex justify-content-between align-items-center"
                >
                    <h4 class="card-title">System users overview</h4>
                </div>
                <div class="card-body">
                    <data-table
                        :columns="columns"
                        :dataSource="filteredDataSource"
                        :searchText="'Name, Username, Email'"
                        @limitChanged="
                            limit => {
                                getQueryLimit(limit);
                            }
                        "
                        @paginationChanged="
                            page => {
                                getUsers(page);
                            }
                        "
                        @keywordSearched="
                            keyword => {
                                getSpecificUser(keyword);
                            }
                        "
                    >
                        <template v-slot:tbody="{ item: { item, index } }">
                            <td scope="row">{{ item.id }}</td>
                            <td>
                                <span class="text-danger" v-if="!item.name"
                                    >Unassigned</span
                                >
                                <span
                                    v-else
                                    v-html="
                                        $options.filters.searchHighlight(
                                            $options.filters.nameStandard(
                                                item.name
                                            ),
                                            keyword
                                        )
                                    "
                                ></span>
                            </td>
                            <td
                                v-html="
                                    $options.filters.searchHighlight(
                                        $options.filters.capitalize(
                                            item.username
                                        ),
                                        keyword
                                    )
                                "
                            ></td>
                            <td
                                v-html="
                                    $options.filters.searchHighlight(
                                        item.email,
                                        keyword
                                    )
                                "
                            ></td>
                            <td scope="row">
                                {{ item.role }}
                            </td>
                            <td
                                :class="
                                    item.is_active
                                        ? 'text-success'
                                        : 'text-danger'
                                "
                            >
                                {{ item.is_active ? "Active" : "Inactive" }}
                            </td>
                            <td style="text-align: center">
                                <a
                                    v-if="$can('user_update')"
                                    @click="showSelectedUser(index)"
                                    ><i
                                        class="icon-button fa fa-edit text-primary"
                                    ></i
                                ></a>
                            </td>
                        </template>
                    </data-table>
                </div>
            </div>
        </div>

        <!-- Edit Modal -->
        <div
            ref="editModal"
            class="modal fade"
            id="editModal"
            tabindex="-1"
            role="dialog"
            aria-labelledby="editModalId"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit User</h5>
                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="form-group">
                                <label>Username:</label>
                                <input
                                    :class="{
                                        'is-invalid': selected_user.errors.has(
                                            'username'
                                        )
                                    }"
                                    class="form-control"
                                    type="text"
                                    v-model="selected_user.username"
                                />
                                <has-error
                                    :form="selected_user"
                                    field="username"
                                ></has-error>
                            </div>
                            <div class="form-group">
                                <label>Email:</label>
                                <input
                                    class="form-control"
                                    :class="{
                                        'is-invalid': selected_user.errors.has(
                                            'email'
                                        )
                                    }"
                                    type="text"
                                    v-model="selected_user.email"
                                />
                                <has-error
                                    :form="selected_user"
                                    field="email"
                                ></has-error>
                            </div>
                            <div class="form-group">
                                <label>Role:</label>
                                <select
                                    class="form-control"
                                    :class="{
                                        'is-invalid': selected_user.errors.has(
                                            'role_id'
                                        )
                                    }"
                                    v-model="selected_user.role_id"
                                >
                                    <option
                                        v-for="(option, index) in role_list"
                                        :key="index"
                                        :value="option.id"
                                    >
                                        {{ option.name }}
                                    </option>
                                </select>
                                <has-error
                                    :form="selected_user"
                                    field="role_id"
                                ></has-error>
                            </div>
                            <div class="form-group">
                                <label>Status:</label>
                                <select
                                    class="form-control"
                                    :class="{
                                        'is-invalid': selected_user.errors.has(
                                            'is_active'
                                        )
                                    }"
                                    v-model="selected_user.is_active"
                                >
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                                <has-error
                                    :form="selected_user"
                                    field="is_active"
                                ></has-error>
                            </div>
                            <div
                                class="custom-control custom-checkbox custom-control-inline mt-3"
                            >
                                <input
                                    type="checkbox"
                                    class="custom-control-input"
                                    v-model="selected_user.reset_password"
                                    id="chkdanger"
                                />
                                <label
                                    class="custom-control-label checkbox-danger"
                                    for="chkdanger"
                                    >Reset User's Password</label
                                >
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal"
                        >
                            Close
                        </button>
                        <button
                            @click="submitform"
                            :disabled="selected_user.busy"
                            type="button"
                            class="btn btn-primary"
                        >
                            Edit
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Edit Modal -->
    </div>
</template>

<script>
export default {
    props: ["user_id"],
    mounted() {
        $(this.$refs.editModal).on("hidden.bs.modal", this.onModalClose);
        // this.getUsers();
        this.getAllRoles();
    },
    data() {
        return {
            users_list: [],
            role_list: [],
            selected_user: new Form({
                id: "",
                username: "",
                role_id: "",
                email: "",
                is_active: "",
                reset_password: false
            }),
            page: "",
            keyword: "",
            limit: "",
            columns: [
                { name: "#", sortName: "id", sortVal: "asc" },
                { name: "Name", sortName: "name", sortVal: "asc" },
                { name: "Username", sortName: "username", sortVal: "asc" },
                { name: "Email", sortName: "email", sortVal: "asc" },
                { name: "User Type", sortName: "role", sortVal: "asc" },
                { name: "Active", sortName: "is_active", sortVal: "asc" },
                { name: "Actions" }
            ]
        };
    },
    methods: {
        getQueryLimit(limit) {
            this.limit = limit;
            this.getUsers();
        },
        getAllRoles: async function() {
            try {
                const response = await axios.get("/api/role");
                if (response.status == 200) {
                    this.role_list = response.data;
                }
            } catch (error) {
                console.log(error);
            }
        },
        getUsers: function(page = 1) {
            axios
                .get("/api/user", {
                    params: {
                        page,
                        limit: this.limit,
                        keyword: this.keyword
                    }
                })
                .then(response => {
                    this.users_list = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        getSpecificUser(keyword) {
            this.keyword = keyword;
            this.getUsers();
        },
        showSelectedUser: function(index) {
            let user = this.users_list.data[index];
            this.selected_user.id = user.id;
            this.selected_user.username = user.username;
            this.selected_user.role_id = user.roles[0].id;
            this.selected_user.email = user.email;
            this.selected_user.is_active = user.is_active;
            $("#editModal").modal("show");
        },
        onModalClose: function() {
            this.selected_user.reset();
        },
        submitform: async function() {
            try {
                const response = await this.selected_user.patch(
                    "/api/user/" + this.selected_user.id
                );
                if (response.status == 200) {
                    $("#editModal").modal("hide");
                    Toast.fire({
                        icon: "success",
                        title: response.data.message
                    });
                    this.getUsers();
                }
            } catch (error) {
                console.log(error);
            }
        }
    },
    computed: {
        filteredDataSource() {
            if (this.users_list.data) {
                let newData = this.users_list.data.map(x => {
                    return {
                        id: x.id,
                        name: x.employee ? x.employee.name : null,
                        username: x.username,
                        email: x.email,
                        role: x.roles[0].name,
                        role_id: x.roles[0].id,
                        is_active: x.is_active
                    };
                });
                let dataSource = Object.assign({}, this.users_list);
                dataSource.data = newData;
                return dataSource;
            }
            return {};
        }
    }
};
</script>
