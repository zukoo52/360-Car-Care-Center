<template>
    <div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <data-table
                        :columns="columns"
                        :dataSource="filteredDataSource"
                        :searchText="'Product Name'"
                        @limitChanged="
                            (limit) => {
                                getQueryLimit(limit);
                            }
                        "
                        @paginationChanged="
                            (page) => {
                                getProducts(page);
                            }
                        "
                        @keywordSearched="
                            (keyword) => {
                                getSpecificProduct(keyword);
                            }
                        "
                    >
                    <template v-slot:tbody="{ item: { item } }">
                        <!-- <td
                                v-html="
                                    $options.filters.searchHighlight(
                                        $options.filters.capitalize(
                                            item.id.toString()
                                        ),
                                        keyword
                                    )
                                "
                            ></td> -->
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
                            <td>{{ item.manufacturer }}</td>
                            <td>{{ item.manufacturing }}</td>
                            <td>{{ item.total_quantity }}</td>
                            <td>{{"Rs : " + item.cost_per_one}}</td>
                            <td>{{"Rs : " + item.price_per_one}}</td>
                            <td style="text-align:center">
										<a @click="showDescription(item.description)" style="cursor:pointer;">
											<i class="
                                            fa fa-eye text-success mx-1"></i>
										</a>
									</td>
                                    <td style="text-align:center">
										<a v-if="$can('product_update')" @click="showProduct(item.id)" style="cursor:pointer;">
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
    },

    data() {
        return {
            products: [],
            page: "",
            keyword: "",
            limit: "",

            columns: [
                //{ name: "ID", sortName: "id", sortVal: "asc" },
                { name: "Product Name" },
                { name: "Manufacturer" },
                { name: "Manufacturing" },
                { name: "Total Quantity" },
                { name: "Cost Per One"},
                { name: "Price Per One" },
                { name: "Description" },
            ],
        };
    },

    methods: {
        getQueryLimit(limit) {
            this.limit = limit;
            this.getProducts();
        },
        getSpecificProduct(keyword) {
            this.keyword = keyword;
            this.getProducts();
        },
        getProducts(page = 1) {
            axios
                .get("/api/product", {
                    params: {
                        page,
                        limit: this.limit,
                        keyword: this.keyword,
                    },
                })
                .then((response) => {
                    this.products = response.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        showProduct: function (id) {
            let url = '/product/update/';
            window.location.href = url + id;
        },
        showDescription(description) {
            swal.fire(description);
        },
    },

    computed: {
        filteredDataSource() {
            if (this.products.data) {
                let newData = this.products.data.map((product) => {
                    return {
                        id: product.id,
                        name: product.name,
                        manufacturer: product.manufacturer,
                        manufacturing: product.manufacturing,
                        total_quantity: product.total_quantity,
                        cost_per_one: product.cost_per_one,
                        price_per_one: product.price_per_one,
                        description: product.description,
                    };
                });

                let dataSource = Object.assign({}, this.products);
                dataSource.data = newData;
                return dataSource;
            }
            return {};
        },
    },
};
</script>

<style>
</style>
