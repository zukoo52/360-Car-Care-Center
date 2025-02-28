<template>
    <div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <data-table
                        :columns="columns"
                        :dataSource="filteredDataSource"
                        :searchText="'Branch Name  or City'"
                        @limitChanged="
                            (limit) => {
                                getQueryLimit(limit);
                            }
                        "
                        @paginationChanged="
                            (page) => {
                                getBranches(page);
                            }
                        "
                        @keywordSearched="
                            (keyword) => {
                                getSpecificBranch(keyword);
                            }
                        "
                    >
                        <template v-slot:tbody="{ item: { item } }">
                            <td
                                v-html="
                                    $options.filters.searchHighlight(
                                        $options.filters.capitalize(
                                            item.id.toString()
                                        ),
                                        keyword
                                    )
                                "
                            ></td>
                            <td
                                v-html="
                                    $options.filters.searchHighlight(
                                        $options.filters.capitalize(
                                            item.name
                                        ),
                                        keyword
                                    )
                                "
                            ></td>
                            <td
                                v-html="
                                    $options.filters.searchHighlight(
                                        $options.filters.capitalize(
                                            item.city
                                        ),
                                        keyword
                                    )
                                "
                            ></td>
                            <td>{{ item.address }}</td>
                            <td>{{ item.manager_name }}</td>
                            <td>{{ item.phone_number }}</td>
                            <td>{{ item.branch_status }}</td>
                            <td style="text-align:center">
										<a v-if="$can('branch_update')" @click="showRole(item.id)" style="cursor:pointer;">
											<i class="
                                            fa fa-edit
                                            icon-button
                                            text-primary"></i>
										</a>
									</td>
                        </template>
                    </data-table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    created() {
        // this.getBranches();
    },

    mounted() {
    },

    data() {
        return {
            branches: [],
            page: "",
            keyword: "",
            limit: "",

            columns: [
                { name: "ID", sortName: "name", sortVal: "asc" },
                { name: "Branch Name"},
                { name: "City"},
                { name: "Address"},
                { name: "Manager Name"},
                { name: "Phone Number"},
                { name: "Status"},
            ],
        };
    },

    methods: {
        getQueryLimit(limit) {
            this.limit = limit;
            this.getBranches();
        },
        getSpecificBranch(keyword) {
            this.keyword = keyword;
            this.getBranches();
        },
        getBranches: function (page = 1) {
            axios
                .get("/api/branch", {
                    params: {
                        page,
                        limit: this.limit,
                        keyword: this.keyword,
                    },
                })
                .then((response) => {
                    this.branches = response.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        showRole: function (id) {
			let url = '/branch/update/';
			window.location.href = url + id;
		}
    },

    computed: {
        filteredDataSource() {
            if (this.branches.data) {
                let newData = this.branches.data.map((branch) => {
                    return {
                        id: branch.id,
                        name: branch.name,
                        city: branch.city,
                        address: branch.address,
                        manager_name: branch.manager_name,
                        phone_number: branch.phone_number,
                        branch_status: branch.branch_status,
                    };
                });

                let dataSource = Object.assign({}, this.branches);
                dataSource.data = newData;
                return dataSource;
            }
            return {};
        },
    },
};
</script>

<style></style>
